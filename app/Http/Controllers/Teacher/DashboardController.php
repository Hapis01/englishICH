<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolClass;
use App\Models\AttendanceSession;
use App\Models\Assessment;
use App\Models\AssessmentScore;
use App\Models\StudentGrade;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the teacher dashboard overview.
     */
    public function index()
    {
        $teacher = Auth::user();
        
        // Get teacher's classes with relationships
        $classes = SchoolClass::where('teacher_id', $teacher->id)
            ->where('status', 'active')
            ->with(['course', 'students', 'assessments', 'attendanceSessions'])
            ->get();

        // Dashboard Statistics
        $totalClasses = $classes->count();
        
        $totalStudents = $classes->flatMap(function ($class) {
            return $class->students;
        })->unique('id')->count();

        $onlineClasses = $classes->where('learning_method', 'online')->count();
        $offlineClasses = $classes->where('learning_method', 'offline')->count();

        // Upcoming Meetings
        $upcomingMeetings = AttendanceSession::where('teacher_id', $teacher->id)
            ->where('meeting_status', 'scheduled')
            ->where('platform', '!=', 'Offline')
            ->whereDate('session_date', '>=', Carbon::today())
            ->orderBy('session_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        // Pending Assessments (Draft assessments)
        $pendingAssessments = Assessment::where('teacher_id', $teacher->id)
            ->where('is_published', false)
            ->count();

        // Today's Schedule
        $today = Carbon::now()->format('l'); // Monday, Tuesday, etc.
        $todaySchedule = $classes->filter(function ($class) use ($today) {
            return stripos($class->schedule, $today) !== false;
        })->take(5);

        // Pending Assignments (Needs Grading in AssessmentScore)
        $pendingAssignmentsCount = AssessmentScore::whereHas('assessment', function($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->whereNull('score')
            ->count();

        // Average Class Attendance Rate (Estimate based on current month)
        $attendanceSessions = \App\Models\AttendanceSession::whereIn('class_id', $classes->pluck('id'))
            ->whereMonth('session_date', Carbon::now()->month)
            ->with('attendances')
            ->get();

        $totalAttendances = 0;
        $presentAttendances = 0;
        foreach ($attendanceSessions as $session) {
            $totalAttendances += $session->attendances->count();
            $presentAttendances += $session->attendances->where('status', 'present')->count();
        }
        $avgAttendanceRate = $totalAttendances > 0 ? round(($presentAttendances / $totalAttendances) * 100) : 0;

        // Average GPA for teacher's classes
        $averageGpa = StudentGrade::whereIn('class_id', $classes->pluck('id'))->avg('average') ?? 0;

        // Activity Feed
        $recentSubmissions = AssessmentScore::whereHas('assessment', function($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->with(['assessment', 'student'])
            ->whereNotNull('file_path')
            ->latest('submitted_at')
            ->take(5)
            ->get();

        // Recent Assessments
        $recentAssessments = Assessment::where('teacher_id', $teacher->id)
            ->with(['schoolClass', 'scores'])
            ->latest()
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact(
            'teacher',
            'classes',
            'totalClasses',
            'totalStudents',
            'onlineClasses',
            'offlineClasses',
            'upcomingMeetings',
            'pendingAssessments',
            'todaySchedule',
            'pendingAssignmentsCount',
            'recentAssessments',
            'avgAttendanceRate',
            'averageGpa',
            'recentSubmissions'
        ));
    }
}
