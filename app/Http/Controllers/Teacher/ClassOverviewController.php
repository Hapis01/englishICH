<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Auth;


class ClassOverviewController extends Controller
{
    public function show(SchoolClass $schoolClass)
    {
        if ($schoolClass->teacher_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access to this class.');
        }

        // Load relations needed for overview
        $schoolClass->load([
            'course',
            'students',
            'materials',
            'assessments',
            'onlineMeetings' => function ($query) {
                $query->latest('session_date')->take(5);
            },
            'attendanceSessions.attendances'
        ]);

        $studentsCount = $schoolClass->students->count();
        $materialsCount = $schoolClass->materials->count();
        $assessmentsCount = $schoolClass->assessments->count();

        // Calculate class attendance rate
        $totalAttendances = 0;
        $presentAttendances = 0;
        
        // Add frequently absent calculation
        $absentCounts = [];
        $lateCounts = [];
        
        foreach ($schoolClass->attendanceSessions as $session) {
            foreach ($session->attendances as $attendance) {
                $totalAttendances++;
                if ($attendance->status === 'present') {
                    $presentAttendances++;
                } elseif ($attendance->status === 'absent') {
                    if (!isset($absentCounts[$attendance->student_id])) {
                        $absentCounts[$attendance->student_id] = 0;
                    }
                    $absentCounts[$attendance->student_id]++;
                } elseif ($attendance->status === 'late') {
                    if (!isset($lateCounts[$attendance->student_id])) {
                        $lateCounts[$attendance->student_id] = 0;
                    }
                    $lateCounts[$attendance->student_id]++;
                }
            }
        }
        
        $attendanceRate = $totalAttendances > 0 ? round(($presentAttendances / $totalAttendances) * 100) : 0;

        // Frequently Absent Students (e.g. 3 or more absences)
        $atRiskStudents = [];
        foreach ($schoolClass->students as $student) {
            $absent = $absentCounts[$student->id] ?? 0;
            $late = $lateCounts[$student->id] ?? 0;
            
            if ($absent >= 2 || $late >= 3) {
                $student->absent_count = $absent;
                $student->late_count = $late;
                $atRiskStudents[] = $student;
            }
        }
        
        // Sort by absent count descending
        usort($atRiskStudents, function($a, $b) {
            return $b->absent_count <=> $a->absent_count;
        });

        return view('teacher.classes.show', compact(
            'schoolClass',
            'studentsCount',
            'materialsCount',
            'assessmentsCount',
            'attendanceRate',
            'atRiskStudents'
        ));
    }

    public function announce(Request $request, SchoolClass $schoolClass)
    {
        if ($schoolClass->teacher_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $students = $schoolClass->students;
        $teacher = Auth::user();

        $count = 0;
        foreach ($students as $student) {
            $student->notify(new \App\Notifications\GeneralNotification(
                'Class Announcement: ' . $schoolClass->name,
                $teacher->name . ' announced: ' . $request->message,
                'announcement',
                route('student.dashboard')
            ));
            $count++;
        }

        return back()->with('success', "Announcement sent to $count students.");
    }
}
