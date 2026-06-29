<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Display settings page.
     */
    public function index()
    {
        $teacher = Auth::user();
        return view('teacher.settings', compact('teacher'));
    }

    /**
     * Update security question.
     */
    public function updateSecurityQuestion(Request $request)
    {
        $teacher = Auth::user();

        $validator = Validator::make($request->all(), [
            'security_question' => 'required|string|max:255',
            'security_answer' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $teacher->update([
                'security_question' => $request->security_question,
                'security_answer' => $request->security_answer,
            ]);

            \App\Models\UserLog::record($teacher->id, 'Security Question Updated', 'Teacher updated their security question and answer.');

            return back()->with('success', 'Security question updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update security question: ' . $e->getMessage());
        }
    }

    /**
     * Update profile.
     */
    public function updateProfile(Request $request)
    {
        $teacher = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $teacher->update([
                'name' => $request->name,
                'whatsapp' => $request->whatsapp,
            ]);

            \App\Models\UserLog::record($teacher->id, 'Profile Updated', 'Teacher updated their profile information.');

            return back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $teacher = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $teacher->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        try {
            $teacher->update([
                'password' => Hash::make($request->new_password),
            ]);

            \App\Models\UserLog::record($teacher->id, 'Password Changed', 'Teacher changed their password.');

            return back()->with('success', 'Password updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update password: ' . $e->getMessage());
        }
    }

    /**
     * Upload profile photo.
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpg,jpeg,png|max:5120', // 5MB max
        ]);

        try {
            $teacher = Auth::user();

            // Delete old profile photo if exists
            if ($teacher->profile_photo && file_exists(public_path($teacher->profile_photo))) {
                @unlink(public_path($teacher->profile_photo));
            }

            // Store new profile photo
            $file = $request->file('profile_photo');
            $fileName = 'profile_' . $teacher->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            $directory = public_path('profile');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            
            $file->move($directory, $fileName);
            $filePath = 'profile/' . $fileName;

            $teacher->update(['profile_photo' => $filePath]);

            \App\Models\UserLog::record($teacher->id, 'Avatar Updated', 'Teacher uploaded a new profile photo.');

            return back()->with('success', 'Profile photo updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to upload profile photo: ' . $e->getMessage());
        }
    }
}
