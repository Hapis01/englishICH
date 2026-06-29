<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function index(Request $request)
    {
        $query = Course::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%")
                  ->orWhere('level', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $courses = $query->latest()->paginate(10)->withQueryString();

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'suitable_for' => 'nullable|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:basic,intermediate,advanced,business,ielts,toefl',
            'original_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'is_featured' => 'boolean',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput()->with('error', 'Failed to add course package. Please check your input.');
        }

        $data = $validator->validated();
        $data['is_featured'] = $request->has('is_featured') ? true : false;
        
        // Features array processing
        if ($request->has('features')) {
            // Remove empty features
            $data['features'] = array_filter($data['features'], fn($value) => !is_null($value) && $value !== '');
        } else {
            $data['features'] = [];
        }

        Course::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Course package successfully added'
            ]);
        }

        return back()->with('success', 'Course package successfully added');
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'suitable_for' => 'nullable|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:basic,intermediate,advanced,business,ielts,toefl',
            'original_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'is_featured' => 'boolean',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput()->with('error', 'Failed to update course package. Please check your input.');
        }

        $data = $validator->validated();
        $data['is_featured'] = $request->has('is_featured') ? true : false;
        
        // Features array processing
        if ($request->has('features')) {
            // Remove empty features
            $data['features'] = array_values(array_filter($data['features'], fn($value) => !is_null($value) && $value !== ''));
        } else {
            $data['features'] = [];
        }

        $course->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Course package successfully updated'
            ]);
        }

        return back()->with('success', 'Course package successfully updated');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Request $request, Course $course)
    {
        // Check if there are active classes using this course
        if ($course->classes()->count() > 0) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Cannot delete a course package that is being used by active classes'], 400);
            }
            return back()->with('error', 'Cannot delete a course package that is being used by active classes');
        }

        $course->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Course package successfully deleted'
            ]);
        }

        return back()->with('success', 'Course package successfully deleted');
    }
}
