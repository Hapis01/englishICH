<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentGrade;

class ProgressController extends Controller
{
    /**
     * Display progress overview.
     */
    public function index()
    {
        $student = Auth::user();
        
        // Get all published grades
        $grades = $student->publishedGrades()
            ->with(['schoolClass.course', 'teacher'])
            ->latest()
            ->get();

        // Calculate skill averages
        $skillProgress = [
            'listening' => round($grades->avg('listening') ?? 0, 2),
            'speaking' => round($grades->avg('speaking') ?? 0, 2),
            'reading' => round($grades->avg('reading') ?? 0, 2),
            'writing' => round($grades->avg('writing') ?? 0, 2),
            'grammar' => round($grades->avg('grammar') ?? 0, 2),
            'attendance' => round($grades->avg('attendance') ?? 0, 2),
        ];

        // GPA
        $gpa = round($grades->avg('average') ?? 0, 2);

        // Score history (for chart)
        $scoreHistory = $grades->map(function ($grade) {
            return [
                'date' => $grade->grade_date->format('M d, Y'),
                'average' => $grade->average,
                'class' => $grade->schoolClass->name,
            ];
        })->reverse()->values();

        return view('student.progress', compact(
            'grades',
            'skillProgress',
            'gpa',
            'scoreHistory'
        ));
    }

    /**
     * Display detailed grades.
     */
    public function grades(Request $request)
    {
        $student = Auth::user();
        
        // Get filter parameters
        $classId = $request->get('class_id');

        // Build query
        $gradesQuery = $student->publishedGrades()
            ->with(['schoolClass.course', 'teacher']);

        if ($classId) {
            $gradesQuery->where('class_id', $classId);
        }

        $grades = $gradesQuery->latest()->get();

        // Get enrolled classes for filter
        $enrolledClasses = $student->enrolledClasses()
            ->where('status', 'active')
            ->with('course')
            ->get();

        return view('student.grades', compact('grades', 'enrolledClasses', 'classId'));
    }

    /**
     * Get skill progress data (for AJAX/API).
     */
    public function skillProgress()
    {
        $student = Auth::user();
        
        $grades = $student->publishedGrades()->get();

        $skillProgress = [
            'listening' => round($grades->avg('listening') ?? 0, 2),
            'speaking' => round($grades->avg('speaking') ?? 0, 2),
            'reading' => round($grades->avg('reading') ?? 0, 2),
            'writing' => round($grades->avg('writing') ?? 0, 2),
            'grammar' => round($grades->avg('grammar') ?? 0, 2),
            'attendance' => round($grades->avg('attendance') ?? 0, 2),
        ];

        return response()->json([
            'success' => true,
            'data' => $skillProgress,
        ]);
    }
}
