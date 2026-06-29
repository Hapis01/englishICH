<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Week;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Auth;

class WeekController extends Controller
{
    /**
     * Store a new week.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'week_number' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Ensure teacher owns this class
        $class = SchoolClass::where('id', $request->class_id)
            ->where('teacher_id', Auth::id())
            ->firstOrFail();

        // Check for duplicate week number
        $exists = Week::where('class_id', $class->id)
            ->where('week_number', $request->week_number)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Week ' . $request->week_number . ' already exists for this class.');
        }

        Week::create([
            'class_id' => $class->id,
            'week_number' => $request->week_number,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Week created successfully!');
    }

    /**
     * Update a week.
     */
    public function update(Request $request, Week $week)
    {
        // Verify teacher owns the class
        if ($week->schoolClass->teacher_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $week->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Week updated successfully!');
    }

    /**
     * Delete a week.
     */
    public function destroy(Week $week)
    {
        // Verify teacher owns the class
        if ($week->schoolClass->teacher_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $week->delete();

        return back()->with('success', 'Week deleted successfully!');
    }
}
