<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\AttendanceSession;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = SchoolClass::with(['course', 'teacher'])->withCount('attendanceSessions');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhereHas('course', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('teacher', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $classes = $query->latest()->paginate(15)->withQueryString();

        return view('admin.attendance.index', compact('classes'));
    }

    public function show($id)
    {
        $class = SchoolClass::with(['course', 'teacher', 'students'])->findOrFail($id);
        
        $sessions = AttendanceSession::where('class_id', $id)
            ->with(['attendances.student'])
            ->orderBy('session_date', 'desc')
            ->get();

        return view('admin.attendance.show', compact('class', 'sessions'));
    }

    public function update(Request $request, $id)
    {
        $attendance = \App\Models\Attendance::findOrFail($id);
        $request->validate([
            'status' => 'required|in:Present,Absent,Late,Excused',
            'notes' => 'nullable|string'
        ]);
        $attendance->update($request->only('status', 'notes'));
        return back()->with('success', 'Attendance updated successfully.');
    }

    public function destroy($id)
    {
        $attendance = \App\Models\Attendance::findOrFail($id);
        $attendance->delete();
        return back()->with('success', 'Attendance deleted successfully.');
    }
}
