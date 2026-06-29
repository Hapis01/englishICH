<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\SchoolClass;
use App\Models\StudentGrade;
use App\Models\User;

class GradingController extends Controller
{
    /**
     * Display grading system.
     */
    public function index(Request $request)
    {
        $teacher = Auth::user();
        
        // Get filter parameters
        $classId = $request->get('class_id');
        $month = $request->get('month');

        // Get teacher's classes
        $classes = SchoolClass::where('teacher_id', $teacher->id)
            ->where('status', 'active')
            ->with('course')
            ->get();

        // Get students with grades
        $gradesQuery = StudentGrade::where('teacher_id', $teacher->id)
            ->with(['student', 'schoolClass']);

        if ($classId) {
            $gradesQuery->where('class_id', $classId);
        }

        if ($month) {
            $gradesQuery->whereMonth('created_at', date('m', strtotime($month)))
                       ->whereYear('created_at', date('Y', strtotime($month)));
        }

        $grades = $gradesQuery->latest()->get();

        return view('teacher.grading', compact('classes', 'grades', 'classId', 'month'));
    }

    /**
     * Store or update grade.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
            'listening' => 'nullable|numeric|min:0|max:100',
            'speaking' => 'nullable|numeric|min:0|max:100',
            'reading' => 'nullable|numeric|min:0|max:100',
            'writing' => 'nullable|numeric|min:0|max:100',
            'grammar' => 'nullable|numeric|min:0|max:100',
            'attendance' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            StudentGrade::updateOrCreate(
                [
                    'student_id' => $request->student_id,
                    'class_id' => $request->class_id,
                ],
                [
                    'teacher_id' => Auth::id(),
                    'listening' => $request->listening,
                    'speaking' => $request->speaking,
                    'reading' => $request->reading,
                    'writing' => $request->writing,
                    'grammar' => $request->grammar,
                    'attendance' => $request->attendance,
                    'notes' => $request->notes,
                    'published' => false,
                    'grade_date' => now(),
                ]
            );

            return back()->with('success', 'Grade saved successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to save grade: ' . $e->getMessage());
        }
    }

    /**
     * Publish grade.
     */
    public function publish(StudentGrade $grade)
    {
        if ($grade->teacher_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        try {
            $grade->update(['published' => true]);
            return back()->with('success', 'Grade published successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to publish grade: ' . $e->getMessage());
        }
    }

    /**
     * Unpublish grade.
     */
    public function unpublish(StudentGrade $grade)
    {
        if ($grade->teacher_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        try {
            $grade->update(['published' => false]);
            return back()->with('success', 'Grade unpublished successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to unpublish grade: ' . $e->getMessage());
        }
    }
}
