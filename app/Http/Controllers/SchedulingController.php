<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchedulingController extends Controller
{
    /**
     * Store a newly created class.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'schedule' => 'required|string|max:255',
            'max_students' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive,completed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify teacher role
        $teacher = User::find($request->teacher_id);
        if ($teacher->role !== 'teacher') {
            return response()->json([
                'success' => false,
                'message' => 'Selected user is not a teacher'
            ], 400);
        }

        $data = $validator->validated();
        $data['current_students'] = 0;

        $class = SchoolClass::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Class created successfully',
            'data' => $class->load(['course', 'teacher'])
        ], 201);
    }

    /**
     * Update the specified class.
     */
    public function update(Request $request, SchoolClass $schoolClass)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'schedule' => 'required|string|max:255',
            'max_students' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive,completed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify teacher role
        $teacher = User::find($request->teacher_id);
        if ($teacher->role !== 'teacher') {
            return response()->json([
                'success' => false,
                'message' => 'Selected user is not a teacher'
            ], 400);
        }

        $data = $validator->validated();

        $schoolClass->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Class updated successfully',
            'data' => $schoolClass->load(['course', 'teacher'])
        ], 200);
    }

    /**
     * Remove the specified class.
     */
    public function destroy(SchoolClass $schoolClass)
    {
        // Check if class has payments
        if ($schoolClass->payments()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete class with existing payments'
            ], 400);
        }

        $schoolClass->delete();

        return response()->json([
            'success' => true,
            'message' => 'Class deleted successfully'
        ], 200);
    }

    /**
     * Get courses for dropdown.
     */
    public function getCourses()
    {
        $courses = Course::where('status', 'active')
            ->select('id', 'name', 'level', 'price', 'duration')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $courses
        ]);
    }

    /**
     * Get teachers for dropdown.
     */
    public function getTeachers()
    {
        $teachers = User::where('role', 'teacher')
            ->where('status', 'active')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $teachers
        ]);
    }
}
