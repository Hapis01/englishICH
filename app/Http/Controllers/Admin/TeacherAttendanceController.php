<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\AttendanceSession;
use App\Models\User;
use Carbon\Carbon;

class TeacherAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $teachers = User::where('role', 'teacher')
            ->where('status', 'active')
            ->get();

        $classes = SchoolClass::where('status', 'active')
            ->with('course')
            ->get();

        $settingsQuery = SchoolClass::whereNotNull('teacher_attendance_days')
            ->where('status', 'active')
            ->with(['teacher', 'course']);

        if ($request->filled('teacher_id')) {
            $settingsQuery->where('teacher_id', $request->teacher_id);
        }

        $settings = $settingsQuery->latest()->get();
        foreach ($settings as $setting) {
            $setting->class_id = $setting->id;
            $setting->days = is_string($setting->teacher_attendance_days) ? json_decode($setting->teacher_attendance_days, true) : $setting->teacher_attendance_days;
            $setting->start_time = $setting->teacher_start_time;
            $setting->end_time = $setting->teacher_end_time;
            $setting->schedule_type = $setting->teacher_schedule_type;
            $setting->schoolClass = $setting;
        }

        $attendanceQuery = AttendanceSession::whereNotNull('teacher_time_in')
            ->with(['teacher', 'schoolClass.course']);

        if ($request->filled('teacher_id')) {
            $attendanceQuery->where('teacher_id', $request->teacher_id);
        }
        if ($request->filled('class_id')) {
            $attendanceQuery->where('class_id', $request->class_id);
        }
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $attendanceQuery->whereDate('session_date', Carbon::today());
                    break;
                case 'this_week':
                    $attendanceQuery->whereBetween('session_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $attendanceQuery->whereMonth('session_date', Carbon::now()->month)
                                  ->whereYear('session_date', Carbon::now()->year);
                    break;
            }
        }
        if ($request->filled('status')) {
            $attendanceQuery->where('teacher_attendance_status', $request->status);
        }

        $attendances = $attendanceQuery->orderBy('session_date', 'desc')->paginate(20);

        foreach ($attendances as $att) {
            $att->date = $att->session_date;
            $att->time_in = $att->teacher_time_in;
            $att->time_out = $att->teacher_time_out;
            $att->status = $att->teacher_attendance_status;
            $att->setting = (object)[
                'start_time' => $att->schoolClass->teacher_start_time ?? '00:00',
                'end_time' => $att->schoolClass->teacher_end_time ?? '23:59',
            ];
        }

        $stats = [
            'total_present' => AttendanceSession::where('teacher_attendance_status', 'Present')->count(),
            'total_absent' => AttendanceSession::where('teacher_attendance_status', 'Absent')->count(),
        ];

        return view('admin.teacher-attendance.index', compact(
            'teachers',
            'classes',
            'settings',
            'attendances',
            'stats'
        ));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'target_type' => 'required|in:specific_teacher,specific_class,all,morning,afternoon',
            'teacher_id' => 'required_if:target_type,specific_teacher|nullable|exists:users,id',
            'class_id' => 'required_if:target_type,specific_class|nullable|exists:classes,id',
            'days' => 'required|array|min:1',
            'days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'schedule_type' => 'required|in:today_only,recurring',
        ]);

        try {
            $classIds = collect();

            if ($request->target_type === 'specific_teacher') {
                $classIds = SchoolClass::where('teacher_id', $request->teacher_id)->where('status', 'active')->pluck('id');
            } elseif ($request->target_type === 'specific_class') {
                $classIds->push($request->class_id);
            } else {
                $classes = SchoolClass::where('status', 'active')->get();
                foreach ($classes as $c) {
                    if ($request->target_type === 'all') {
                        $classIds->push($c->id);
                    } elseif (str_contains(strtolower($c->name), 'morning') && $request->target_type === 'morning') {
                        $classIds->push($c->id);
                    } elseif (str_contains(strtolower($c->name), 'afternoon') && $request->target_type === 'afternoon') {
                        $classIds->push($c->id);
                    }
                }
            }

            SchoolClass::whereIn('id', $classIds)->update([
                'teacher_attendance_days' => json_encode($request->days),
                'teacher_start_time' => $request->start_time,
                'teacher_end_time' => $request->end_time,
                'teacher_schedule_type' => $request->schedule_type,
            ]);

            return back()->with('success', "Attendance schedule updated successfully for {$classIds->count()} classes.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create schedule: ' . $e->getMessage());
        }
    }

    public function updateSchedule(Request $request, $id)
    {
        $request->validate([
            'days' => 'required|array|min:1',
            'days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'schedule_type' => 'required|in:today_only,recurring',
        ]);

        try {
            $class = SchoolClass::findOrFail($id);
            $class->update([
                'teacher_attendance_days' => json_encode($request->days),
                'teacher_start_time' => $request->start_time,
                'teacher_end_time' => $request->end_time,
                'teacher_schedule_type' => $request->schedule_type,
            ]);

            return back()->with('success', 'Attendance schedule updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update schedule: ' . $e->getMessage());
        }
    }

    public function destroySchedule($id)
    {
        try {
            $class = SchoolClass::findOrFail($id);
            $class->update([
                'teacher_attendance_days' => null,
                'teacher_start_time' => null,
                'teacher_end_time' => null,
                'teacher_schedule_type' => null,
            ]);
            return back()->with('success', 'Attendance schedule deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete schedule: ' . $e->getMessage());
        }
    }
}
