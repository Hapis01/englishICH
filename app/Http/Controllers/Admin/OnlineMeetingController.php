<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSession;
use Illuminate\Http\Request;

class OnlineMeetingController extends Controller
{
    public function index(Request $request)
    {
        $query = AttendanceSession::where('platform', '!=', 'Offline')->with(['schoolClass.course', 'teacher']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhereHas('schoolClass', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('teacher', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        if ($request->filled('status')) {
            $query->where('meeting_status', $request->status);
        }

        $meetings = $query->latest('session_date')->paginate(15)->withQueryString();

        // Pass 'status' as 'meeting_status' and 'meeting_date' as 'session_date' for the view to render it cleanly
        foreach ($meetings as $meeting) {
            $meeting->meeting_date = clone $meeting->session_date;
            $meeting->meeting_time = $meeting->start_time;
            $meeting->status = $meeting->meeting_status;
            $meeting->link = $meeting->meeting_link;
        }

        return view('admin.meetings.index', compact('meetings'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'platform' => 'required|in:Google Meet,Zoom,Offline',
            'link' => 'nullable|url',
            'status' => 'required|in:scheduled,completed,cancelled'
        ]);

        $meeting = AttendanceSession::findOrFail($id);
        $meeting->update([
            'title' => $request->title,
            'platform' => $request->platform,
            'meeting_link' => $request->link,
            'meeting_status' => $request->status
        ]);

        return back()->with('success', 'Meeting updated successfully.');
    }

    public function destroy($id)
    {
        $meeting = AttendanceSession::findOrFail($id);
        if ($meeting->attendances()->count() == 0) {
            $meeting->delete();
        } else {
            $meeting->update([
                'platform' => 'Offline',
                'meeting_link' => null,
                'meeting_status' => 'cancelled'
            ]);
        }
        return back()->with('success', 'Meeting deleted/cancelled.');
    }
}
