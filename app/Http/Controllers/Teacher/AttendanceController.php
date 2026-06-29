<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceSession;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $sessions = AttendanceSession::where('teacher_id', Auth::id())->with('schoolClass')->latest()->get();
        $classes = SchoolClass::where('teacher_id', Auth::id())->get();
        return view('teacher.attendance.index', compact('sessions', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'title' => 'required|string|max:255',
            'session_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
        ]);

        AttendanceSession::create([
            'class_id' => $request->class_id,
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'session_date' => $request->session_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_open' => $request->start_time ? false : true,
        ]);

        return back()->with('success', 'Attendance session created.');
    }

    public function destroy(AttendanceSession $session)
    {
        if ($session->teacher_id == Auth::id()) {
            $session->delete();
        }
        return back()->with('success', 'Session deleted.');
    }

    public function publish(AttendanceSession $session)
    {
        if ($session->teacher_id == Auth::id()) {
            $session->update(['is_published' => !$session->is_published]);
        }
        return back()->with('success', 'Session publication status updated.');
    }

    public function toggleOpen(AttendanceSession $session)
    {
        if ($session->teacher_id == Auth::id()) {
            if ($session->is_active) {
                // Force close (clear auto-schedule and manual open)
                $session->update([
                    'is_open' => false,
                    'start_time' => null,
                    'end_time' => null,
                ]);
                $status = 'closed';
            } else {
                // Force open
                $session->update(['is_open' => true]);
                $status = 'opened';
            }
            return back()->with('success', "Session has been manually {$status} for attendance.");
        }
        return back()->with('error', 'Unauthorized action.');
    }

    public function show(AttendanceSession $session)
    {
        if ($session->teacher_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $session->load(['schoolClass.students', 'attendances.student']);
        
        // Map attendances by student id
        $attendances = $session->attendances->keyBy('student_id');

        return view('teacher.attendance.show', compact('session', 'attendances'));
    }

    public function updateStudentAttendance(Request $request, AttendanceSession $session)
    {
        if ($session->teacher_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'student_id' => 'required|exists:users,id',
            'status' => 'required|in:Present,Absent,Late,Excused',
            'notes' => 'nullable|string'
        ]);

        \App\Models\Attendance::updateOrCreate(
            ['attendance_session_id' => $session->id, 'student_id' => $request->student_id],
            ['status' => $request->status, 'notes' => $request->notes]
        );

        return back()->with('success', 'Attendance updated successfully.');
    }

    public function report()
    {
        $teacher = Auth::user();
        $classes = SchoolClass::where('teacher_id', $teacher->id)->with('attendanceSessions.attendances')->get();
        return view('teacher.attendance.report', compact('classes'));
    }
}
