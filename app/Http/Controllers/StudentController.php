<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'whatsapp' => 'nullable|string|max:20',
            'password' => 'required|min:8',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status' => 'required|in:active,inactive',
            'student_status' => 'required|in:CLASS_NOT_SELECTED,AWAITING_PAYMENT,PAYMENT_VERIFICATION,ACTIVE,PAYMENT_OVERDUE,SUSPENDED,INACTIVE',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['role'] = 'student';
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

        $student = User::create($data);

        \App\Models\UserLog::record($student->id, 'Student Created', 'Admin created a new student record.');

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, User $user)
    {
        // Ensure we're updating a student
        if ($user->role !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a student'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'whatsapp' => 'nullable|string|max:20',
            'password' => 'nullable|min:8',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status' => 'required|in:active,inactive',
            'student_status' => 'required|in:CLASS_NOT_SELECTED,AWAITING_PAYMENT,PAYMENT_VERIFICATION,ACTIVE,PAYMENT_OVERDUE,SUSPENDED,INACTIVE',
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
            // Delete old photo if exists
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

        \App\Models\UserLog::record($user->id, 'Student Updated', 'Admin updated the student record.');

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully',
            'data' => $user
        ], 200);
    }

    /**
     * Remove the specified student.
     */
    public function destroy(User $user)
    {
        // Ensure we're deleting a student
        if ($user->role !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a student'
            ], 400);
        }

        // Delete photo if exists
        if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
            @unlink(public_path($user->profile_photo));
        }

        $userId = $user->id;
        $user->delete();

        \App\Models\UserLog::record($userId, 'Student Deleted', 'Admin deleted the student record.');

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully'
        ], 200);
    }
}
