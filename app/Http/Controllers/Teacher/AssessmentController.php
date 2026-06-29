<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\SchoolClass;
use App\Models\AssessmentScore;
use App\Models\Week;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::where('teacher_id', Auth::id())->with(['schoolClass', 'scores', 'week'])->latest()->get();
        $classes = SchoolClass::where('teacher_id', Auth::id())->where('status', 'active')->get();
        return view('teacher.assessments.index', compact('assessments', 'classes'));
    }

    public function create()
    {
        $classes = SchoolClass::where('teacher_id', Auth::id())->where('status', 'active')->with('weeks')->get();
        return view('teacher.assessments.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'week_id' => 'nullable|exists:weeks,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:Assignment,Quiz,Mid Test,Final Test,Speaking Test,Speaking,Reading,Listening,Writing,Custom Assessment',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'start_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable|date_format:H:i',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:10240',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('assessments', $fileName, 'public');
        }

        Assessment::create([
            'class_id' => $request->class_id,
            'week_id' => $request->week_id,
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'instructions' => $request->instructions,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'due_date' => $request->due_date,
            'due_time' => $request->due_time,
            'is_open' => $request->start_date ? false : $request->has('is_open'),
            'attachment' => $attachmentPath,
            'is_published' => true, // Changed to true so it appears immediately on student dashboard
        ]);

        return redirect()->route('teacher.assessments.index')->with('success', 'Assessment created.');
    }

    public function edit(Assessment $assessment)
    {
        if ($assessment->teacher_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $classes = SchoolClass::where('teacher_id', Auth::id())->where('status', 'active')->with('weeks')->get();
        return view('teacher.assessments.edit', compact('assessment', 'classes'));
    }

    public function update(Request $request, Assessment $assessment)
    {
        if ($assessment->teacher_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Assignment,Quiz,Mid Test,Final Test,Speaking Test,Speaking,Reading,Listening,Writing,Custom Assessment',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'week_id' => 'nullable|exists:weeks,id',
            'start_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable|date_format:H:i',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:10240',
        ]);

        $attachmentPath = $assessment->attachment;
        if ($request->hasFile('attachment')) {
            if ($attachmentPath && Storage::disk('public')->exists($attachmentPath)) {
                Storage::disk('public')->delete($attachmentPath);
            }
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('assessments', $fileName, 'public');
        }

        $assessment->update([
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'instructions' => $request->instructions,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'due_date' => $request->due_date,
            'due_time' => $request->due_time,
            'is_open' => $request->start_date ? false : $request->has('is_open'),
            'attachment' => $attachmentPath,
            'week_id' => $request->week_id,
        ]);

        return redirect()->route('teacher.assessments.index')->with('success', 'Assessment updated.');
    }

    public function destroy(Assessment $assessment)
    {
        if ($assessment->teacher_id == Auth::id()) {
            if ($assessment->attachment && Storage::disk('public')->exists($assessment->attachment)) {
                Storage::disk('public')->delete($assessment->attachment);
            }
            $assessment->delete();
        }
        return back()->with('success', 'Assessment deleted.');
    }

    public function toggleStatus(Assessment $assessment)
    {
        if ($assessment->teacher_id == Auth::id()) {
            $assessment->update(['is_published' => !$assessment->is_published]);
            $status = $assessment->is_published ? 'published (opened)' : 'closed';
            return back()->with('success', "Assessment manually {$status}.");
        }
        return back()->with('error', 'Unauthorized action.');
    }

    public function toggleOpen(Assessment $assessment)
    {
        if ($assessment->teacher_id == Auth::id()) {
            $assessment->update(['is_open' => !$assessment->is_open]);
            $status = $assessment->is_open ? 'forced open' : 'returned to schedule';
            return back()->with('success', "Assessment {$status}.");
        }
        return back()->with('error', 'Unauthorized action.');
    }

    public function submissions(Assessment $assessment)
    {
        if ($assessment->teacher_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $submissions = $assessment->scores()->with('student')->get();
        
        $enrolledStudents = \App\Models\User::where('role', 'student')
            ->whereHas('enrolledClasses', function($q) use ($assessment) {
                $q->where('classes.id', $assessment->class_id);
            })->get();

        return view('teacher.assessments.submissions', compact('assessment', 'submissions', 'enrolledStudents'));
    }

    public function gradeSubmission(Request $request, AssessmentScore $submission)
    {
        $assessment = $submission->assessment;
        if ($assessment->teacher_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'score' => 'required|numeric|min:0',
            'maximum_score' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ]);

        $submission->update([
            'score' => $request->score,
            'maximum_score' => $request->maximum_score,
            'notes' => $request->notes,
            'is_published' => $request->has('is_published'),
            'graded_by' => Auth::id(),
            'graded_at' => now(),
        ]);


        return back()->with('success', 'Score updated successfully!');
    }

    public function storeManualGrade(Request $request, Assessment $assessment)
    {
        if ($assessment->teacher_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'student_id' => 'required|exists:users,id',
            'score' => 'required|numeric|min:0',
            'maximum_score' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ]);

        $score = AssessmentScore::updateOrCreate(
            ['assessment_id' => $assessment->id, 'student_id' => $request->student_id],
            [
                'score' => $request->score,
                'maximum_score' => $request->maximum_score,
                'notes' => $request->notes,
                'is_published' => $request->has('is_published'),
                'graded_by' => Auth::id(),
                'graded_at' => now(),
            ]
        );


        return back()->with('success', 'Manual grade recorded successfully!');
    }
}
