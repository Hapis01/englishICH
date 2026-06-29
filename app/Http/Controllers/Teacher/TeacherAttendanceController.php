<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolClass;
use App\Models\AttendanceSession;
use Carbon\Carbon;

class TeacherAttendanceController extends Controller
{
    /**
     * Display teacher's attendance page.
     */
    public function index()
    {
        $teacher = Auth::user();

        // Auto checkout logic for sessions > 4 hours
        $pendingSessions = AttendanceSession::where('teacher_id', $teacher->id)
            ->whereNotNull('teacher_time_in')
            ->whereNull('teacher_time_out')
            ->get();

        foreach ($pendingSessions as $session) {
            $checkInTime = Carbon::parse($session->session_date->format('Y-m-d') . ' ' . $session->teacher_time_in);
            if (now()->diffInHours($checkInTime) >= 4) {
                $session->update([
                    'teacher_time_out' => $checkInTime->addHours(4)->format('H:i:s')
                ]);
            }
        }

        $classes = SchoolClass::where('teacher_id', $teacher->id)
            ->where('status', 'active')
            ->with('course')
            ->get();

        $today = now()->format('l');

        $todaySchedules = $classes->filter(function ($class) use ($today) {
            if (!$class->teacher_attendance_days) return false;
            $days = is_string($class->teacher_attendance_days) ? json_decode($class->teacher_attendance_days, true) : $class->teacher_attendance_days;
            return in_array($today, $days ?? []);
        });

        // Add dummy properties to match old setting model for the view
        foreach ($todaySchedules as $class) {
            $class->id_for_setting = $class->id;
            $class->start_time = $class->teacher_start_time;
            $class->end_time = $class->teacher_end_time;
            $class->isTodayValid = function() { return true; };
            $class->isWithinTimeWindow = function() { return true; };
            $class->schoolClass = $class;
        }

        $todayAttendances = AttendanceSession::where('teacher_id', $teacher->id)
            ->whereDate('session_date', now()->toDateString())
            ->whereNotNull('teacher_time_in')
            ->with('schoolClass')
            ->get();

        foreach ($todayAttendances as $att) {
            $att->time_in = $att->teacher_time_in;
            $att->time_out = $att->teacher_time_out;
            $att->status = $att->teacher_attendance_status;
            $att->date = clone $att->session_date;
            $att->setting = (object)[
                'start_time' => $att->schoolClass->teacher_start_time,
                'end_time' => $att->schoolClass->teacher_end_time,
            ];
        }

        $attendanceHistory = AttendanceSession::where('teacher_id', $teacher->id)
            ->whereNotNull('teacher_time_in')
            ->with('schoolClass')
            ->orderBy('session_date', 'desc')
            ->paginate(20);

        foreach ($attendanceHistory as $att) {
            $att->time_in = $att->teacher_time_in;
            $att->time_out = $att->teacher_time_out;
            $att->status = $att->teacher_attendance_status;
            $att->date = clone $att->session_date;
            $att->setting = (object)[
                'start_time' => $att->schoolClass->teacher_start_time,
                'end_time' => $att->schoolClass->teacher_end_time,
            ];
        }

        return view('teacher.teacher-attendance', compact(
            'classes',
            'todaySchedules',
            'todayAttendances',
            'attendanceHistory'
        ));
    }

    /**
     * Check-in attendance.
     */
    public function checkIn(Request $request)
    {
        // View passes setting_id which is now class_id
        $classId = $request->input('setting_id') ?? $request->input('class_id');
        if (!$classId) {
            return back()->with('error', 'Class ID is required.');
        }

        $teacher = Auth::user();
        $class = SchoolClass::findOrFail($classId);

        if ($class->teacher_id !== $teacher->id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $session = AttendanceSession::firstOrCreate([
            'class_id' => $class->id,
            'session_date' => now()->toDateString(),
        ], [
            'teacher_id' => $teacher->id,
            'title' => 'Session ' . now()->toDateString(),
        ]);

        if ($session->teacher_time_in) {
            return back()->with('error', 'You have already checked in for this class today.');
        }

        $status = 'Present';

        $session->update([
            'teacher_time_in' => now()->format('H:i:s'),
            'teacher_attendance_status' => $status,
        ]);

        return back()->with('success', 'Check-in successful! Status: ' . $status);
    }

    /**
     * Check-out attendance.
     */
    public function checkOut(Request $request)
    {
        $attendanceId = $request->input('attendance_id');
        $teacher = Auth::user();
        $session = AttendanceSession::findOrFail($attendanceId);

        if ($session->teacher_id !== $teacher->id) {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($session->teacher_time_out) {
            return back()->with('error', 'You have already checked out.');
        }

        $session->update([
            'teacher_time_out' => now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Check-out successful!');
    }
}
