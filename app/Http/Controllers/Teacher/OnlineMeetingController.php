<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceSession;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Auth;

class OnlineMeetingController extends Controller
{
    public function index()
    {
        $meetings = AttendanceSession::where('teacher_id', Auth::id())
            ->where('platform', '!=', 'Offline')
            ->latest()
            ->get();
        $classes = SchoolClass::where('teacher_id', Auth::id())->get();
        return view('teacher.meetings.index', compact('meetings', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'title' => 'required|string|max:255',
            'platform' => 'required|in:Google Meet,Zoom',
            'link' => 'required|url',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required',
        ]);

        $session = AttendanceSession::firstOrCreate([
            'class_id' => $request->class_id,
            'session_date' => $request->meeting_date,
        ], [
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'start_time' => $request->meeting_time,
        ]);

        $session->update([
            'title' => $request->title,
            'platform' => $request->platform,
            'meeting_link' => $request->link,
            'start_time' => $request->meeting_time,
        ]);

        return back()->with('success', 'Meeting saved successfully.');
    }

    public function destroy($id)
    {
        $meeting = AttendanceSession::findOrFail($id);
        if ($meeting->teacher_id == Auth::id()) {
            if ($meeting->attendances()->count() == 0) {
                $meeting->delete();
            } else {
                $meeting->update([
                    'platform' => 'Offline',
                    'meeting_link' => null,
                    'meeting_status' => 'cancelled'
                ]);
            }
        }
        return back()->with('success', 'Meeting deleted/cancelled.');
    }

    public function publish($id)
    {
        $meeting = AttendanceSession::findOrFail($id);
        if ($meeting->teacher_id == Auth::id()) {
            $meeting->update(['is_published' => !$meeting->is_published]);
        }
        return back()->with('success', 'Meeting publication status updated.');
    }
}
