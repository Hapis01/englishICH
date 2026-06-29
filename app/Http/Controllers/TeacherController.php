<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Store a newly created teacher.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'whatsapp' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['role'] = 'teacher';
        $data['password'] = Hash::make($data['password']);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            $directory = public_path('profile');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            $file->move($directory, $filename);
            $path = 'profile/' . $filename;
            
            $data['profile_photo'] = $path;
        }

        $teacher = User::create($data);

        \App\Models\UserLog::record($teacher->id, 'Teacher Created', 'Admin created a new teacher record.');

        return response()->json([
            'success' => true,
            'message' => 'Teacher created successfully',
            'data' => $teacher
        ], 201);
    }

    /**
     * Update the specified teacher.
     */
    public function update(Request $request, User $user)
    {
        // Ensure we're updating a teacher
        if ($user->role !== 'teacher') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a teacher'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'whatsapp' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        // Update password only if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if exists
            if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
                @unlink(public_path($user->profile_photo));
            }

            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            $directory = public_path('profile');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            $file->move($directory, $filename);
            $path = 'profile/' . $filename;
            
            $data['profile_photo'] = $path;
        }

        $user->update($data);

        \App\Models\UserLog::record($user->id, 'Teacher Updated', 'Admin updated the teacher record.');

        return response()->json([
            'success' => true,
            'message' => 'Teacher updated successfully',
            'data' => $user
        ], 200);
    }

    /**
     * Remove the specified teacher.
     */
    public function destroy(User $user)
    {
        // Ensure we're deleting a teacher
        if ($user->role !== 'teacher') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a teacher'
            ], 400);
        }

        // Delete profile photo if exists
        if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
            @unlink(public_path($user->profile_photo));
        }

        $userId = $user->id;
        $user->delete();

        \App\Models\UserLog::record($userId, 'Teacher Deleted', 'Admin deleted the teacher record.');

        return response()->json([
            'success' => true,
            'message' => 'Teacher deleted successfully'
        ], 200);
    }
}
