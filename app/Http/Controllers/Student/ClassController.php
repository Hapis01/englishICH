<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolClass;
use Carbon\Carbon;

class ClassController extends Controller
{
    /**
     * Display active classes.
     */
    public function index()
    {
        $student = Auth::user();
        
        // Get enrolled classes
        $activeClasses = $student->enrolledClasses()
            ->where('status', 'active')
            ->with(['course', 'teacher'])
            ->get();

        // Add schedule information for each class
        $today = Carbon::now()->format('l');
        
        foreach ($activeClasses as $class) {
            // Determine if class is today
            $class->is_today = stripos($class->schedule, $today) !== false;
            
            // Parse schedule to get next session
            $class->next_session = $this->getNextSession($class->schedule);
            
            // Determine if online or offline (placeholder - add meeting_link field to classes table)
            $class->is_online = !empty($class->meeting_link ?? null);
        }

        return view('student.classes', compact('activeClasses'));
    }

    /**
     * Display upcoming online meetings for student.
     */
    public function meetings()
    {
        $student = Auth::user();
        
        // Get enrolled classes
        $enrolledClasses = $student->enrolledClasses()
            ->where('status', 'active')
            ->get();

        // Upcoming Online Meetings
        $meetings = \App\Models\AttendanceSession::whereIn('class_id', $enrolledClasses->pluck('id'))
            ->where('is_published', true)
            ->where('platform', '!=', 'Offline')
            ->where('meeting_status', 'scheduled')
            ->whereDate('session_date', '>=', now()->toDateString())
            ->orderBy('session_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('student.meetings', compact('meetings'));
    }

    /**
     * Show class details.
     */
    public function show(SchoolClass $class)
    {
        $student = Auth::user();

        // Check if student is enrolled
        if (!$student->isEnrolledIn($class->id)) {
            return back()->with('error', 'You are not enrolled in this class.');
        }

        $class->load(['course', 'teacher', 'materials']);

        // Get materials for this class
        $materials = $class->materials()->latest()->get();

        // Get student's grades for this class
        $grades = $class->grades()
            ->where('student_id', $student->id)
            ->where('published', true)
            ->latest()
            ->get();

        // Parse schedule
        $schedule = $this->parseSchedule($class->schedule, $class->meeting_link);

        return view('student.class-detail', compact('class', 'materials', 'grades', 'schedule'));
    }

    /**
     * Join online class (redirect to Google Meet).
     */
    public function joinOnlineClass(SchoolClass $class)
    {
        $student = Auth::user();

        // Check if student is enrolled
        if (!$student->isEnrolledIn($class->id)) {
            abort(403, 'You are not enrolled in this class.');
        }

        // Check if meeting link exists
        $meetingLink = $class->meeting_link ?? null;
        
        if (!$meetingLink) {
            return back()->with('error', 'No meeting link available for this class.');
        }

        // Redirect to meeting link
        return redirect()->away($meetingLink);
    }

    /**
     * Parse schedule and get next session date/time.
     */
    private function getNextSession($schedule)
    {
        // Simple parsing - can be enhanced
        // Example schedule: "Monday & Wednesday 10:00-12:00"
        
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $today = Carbon::now();
        
        foreach ($days as $day) {
            if (stripos($schedule, $day) !== false) {
                $nextDate = Carbon::parse("next {$day}");
                
                if ($nextDate->isToday()) {
                    return 'Today';
                } elseif ($nextDate->isTomorrow()) {
                    return 'Tomorrow';
                } else {
                    return $nextDate->format('l, M d');
                }
            }
        }
        
        return 'Schedule not available';
    }

    /**
     * Parse schedule for class detail view.
     */
    private function parseSchedule($schedule, $meetingLink = null)
    {
        // Example: "Monday & Wednesday 10:00-12:00 | Online | https://meet.google.com/xxx"
        
        $parts = explode('|', $schedule);
        $dayTime = trim($parts[0] ?? '');
        $mode = trim($parts[1] ?? 'offline');
        $link = trim($parts[2] ?? $meetingLink ?? '');

        // Extract day and time
        preg_match('/([A-Za-z\s&]+)\s+(\d{1,2}:\d{2}-\d{1,2}:\d{2})/', $dayTime, $matches);
        
        $day = trim($matches[1] ?? 'N/A');
        $time = trim($matches[2] ?? 'N/A');

        // Extract room if offline
        $room = null;
        if (stripos($mode, 'offline') !== false && isset($parts[3])) {
            $room = trim($parts[3]);
        }

        return [
            'day' => $day,
            'time' => $time,
            'mode' => strtolower($mode) === 'online' ? 'online' : 'offline',
            'meeting_link' => $link,
            'room' => $room,
        ];
    }
}
