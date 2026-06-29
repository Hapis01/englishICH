<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\AssessmentScore;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $enrolledClassIds = $student->enrolledClasses()->where('status', 'active')->pluck('classes.id');
        
        $assessments = Assessment::whereIn('class_id', $enrolledClassIds)
            ->with(['schoolClass', 'teacher', 'scores' => function($q) use ($student) {
                $q->where('student_id', $student->id);
            }])
            ->latest()
            ->get();

        return view('student.assessments.index', compact('assessments'));
    }

    public function show(Assessment $assessment)
    {
        $student = Auth::user();
        
        if (!$student->isEnrolledIn($assessment->class_id)) {
            return back()->with('error', 'You are not enrolled in this class.');
        }

        if (!$assessment->is_published) {
            return back()->with('error', 'Assessment is not available.');
        }

        if ($assessment->is_upcoming) {
            return back()->with('error', 'Assessment is coming soon and not yet open.');
        }

        $submission = $assessment->scores()->where('student_id', $student->id)->first();

        if ($assessment->is_overdue && (!$submission || !$submission->file_path)) {
            return back()->with('error', 'Assessment is closed and can no longer be viewed.');
        }

        return view('student.assessments.show', compact('assessment', 'submission'));
    }

    public function submit(Request $request, Assessment $assessment)
    {
        $student = Auth::user();

        if (!$student->isEnrolledIn($assessment->class_id)) {
            return back()->with('error', 'You are not enrolled in this class.');
        }

        if (!$assessment->is_active) {
            if ($assessment->is_upcoming) {
                return back()->with('error', 'This assessment is not open for submissions yet.');
            }
            if ($assessment->is_overdue || !$assessment->is_published) {
                return back()->with('error', 'The time limit for this assessment has passed or it is currently closed.');
            }
            return back()->with('error', 'Assessment is not currently accepting submissions.');
        }

        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:10240',
            'notes' => 'nullable|string'
        ]);

        $existingSubmission = $assessment->scores()->where('student_id', $student->id)->first();
        if ($existingSubmission && $existingSubmission->file_path) {
            return back()->with('error', 'You have already submitted this assessment.');
        }

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('assessments/submissions', $fileName, 'public');

        if ($existingSubmission) {
            $existingSubmission->update([
                'file_path' => $filePath,
                'submitted_at' => now(),
                'notes' => $request->notes,
            ]);
        } else {
            AssessmentScore::create([
                'assessment_id' => $assessment->id,
                'student_id' => $student->id,
                'file_path' => $filePath,
                'submitted_at' => now(),
                'notes' => $request->notes,
            ]);
        }

        return back()->with('success', 'Assessment submitted successfully!');
    }
}
