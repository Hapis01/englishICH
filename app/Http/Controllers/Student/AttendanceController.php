<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceSession;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $enrolledClassIds = $student->enrolledClasses()->where('status', 'active')->pluck('classes.id');

        $now = now()->format('H:i:s');
        $activeSessions = AttendanceSession::whereIn('class_id', $enrolledClassIds)
            ->where(function ($query) {
                $query->where('is_open', true)
                      ->orWhereDate('session_date', now()->toDateString());
            })
            ->with(['schoolClass.course', 'teacher'])
            ->get();

        $history = Attendance::where('student_id', $student->id)
            ->with(['session.schoolClass', 'session.teacher'])
            ->latest()
            ->get();

        return view('student.attendance.index', compact('activeSessions', 'history'));
    }

    public function mark(Request $request, AttendanceSession $session)
    {
        $student = Auth::user();

        if (!$student->isEnrolledIn($session->class_id)) {
            return back()->with('error', 'You are not enrolled in this class.');
        }

        if (!$session->is_active) {
            return back()->with('error', 'This attendance session is not open.');
        }

        $existing = Attendance::where('attendance_session_id', $session->id)
            ->where('student_id', $student->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already marked your attendance for this session.');
        }

        Attendance::create([
            'attendance_session_id' => $session->id,
            'student_id' => $student->id,
            'status' => 'Present',
            'notes' => 'Self-marked by student'
        ]);

        return back()->with('success', 'Attendance marked successfully!');
    }
}
