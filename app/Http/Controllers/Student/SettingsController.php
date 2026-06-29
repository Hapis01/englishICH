<?php

namespace App\Http\Controllers\Student;

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
        $student = Auth::user();
        
        return view('student.settings', compact('student'));
    }

    /**
     * Update profile information.
     */
    public function updateProfile(Request $request)
    {
        $student = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $student->update([
                'name' => $request->name,
                'whatsapp' => $request->whatsapp,
            ]);

            \App\Models\UserLog::record($student->id, 'Profile Updated', 'Student updated their profile information.');

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
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $student = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $student->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        try {
            $student->update([
                'password' => Hash::make($request->new_password),
            ]);

            \App\Models\UserLog::record($student->id, 'Password Changed', 'Student changed their password.');

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
            $student = Auth::user();

            // Delete old profile photo if exists
            if ($student->profile_photo && file_exists(public_path($student->profile_photo))) {
                @unlink(public_path($student->profile_photo));
            }

            // Store new profile photo
            $file = $request->file('profile_photo');
            $fileName = 'profile_' . $student->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            $directory = public_path('profile');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            
            $file->move($directory, $fileName);
            $avatarPath = 'profile/' . $fileName;

            $student->update(['profile_photo' => $avatarPath]);

            \App\Models\UserLog::record($student->id, 'Avatar Updated', 'Student uploaded a new profile photo.');

            return back()->with('success', 'Profile photo updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to upload profile photo. Please try again.');
        }
    }

    /**
     * Update security question.
     */
    public function updateSecurityQuestion(Request $request)
    {
        $student = Auth::user();

        $validator = Validator::make($request->all(), [
            'security_question' => 'required|string|max:255',
            'security_answer' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $student->update([
                'security_question' => $request->security_question,
                'security_answer' => $request->security_answer,
            ]);

            \App\Models\UserLog::record($student->id, 'Security Question Updated', 'Student updated their security question and answer.');

            return back()->with('success', 'Security question updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update security question: ' . $e->getMessage());
        }
    }

    /**
     * Update language preference.
     */
    public function updateLanguage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required|in:en,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        // Store language preference in session
        session(['locale' => $request->language]);

        return back()->with('success', 'Language preference updated!');
    }
}
