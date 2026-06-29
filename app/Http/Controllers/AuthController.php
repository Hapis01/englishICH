<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    private function redirectByRole(User $user)
    {
        return match ($user->role) {
            'admin', 'owner' => redirect()->route('admin.index'),
            'teacher' => redirect()->route('teacher.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            default => redirect()->route('landing'),
        };
    }

    /**
     * Show the login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect based on user role
            if (in_array($user->role, ['admin', 'owner', 'teacher', 'student'])) {
                $flashType = 'success';
                $flashMsg = 'Login berhasil. Selamat datang kembali.';
                
                // Check if password was reset to 123456
                if (Hash::check('123456', $user->password)) {
                    $flashType = 'warning';
                    $flashMsg = 'Penting: Anda harus segera mengganti password Anda dalam waktu 24 jam!';
                }

                return $this->redirectByRole($user)
                    ->with($flashType, $flashMsg);
            }

            Auth::logout();
            return back()->with('error', 'Invalid user role.');
        }

        return back()
            ->with('error', 'Email atau password salah.')
            ->withInput($request->only('email', 'remember'));
    }

    /**
     * Show the registration form.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|regex:/^[a-zA-Z0-9._%+-]+@ich\.com$/',
            'password' => 'required|min:8|confirmed',
            'security_question' => 'required|string',
            'security_answer' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'terms' => 'required|accepted',
        ], [
            'email.regex' => 'Email harus menggunakan domain @ich.com',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation', 'security_answer'));
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'security_question' => $request->security_question,
                'security_answer' => Hash::make($request->security_answer),
                'role' => 'student', // Default role is student
                'student_status' => 'CLASS_NOT_SELECTED', // Default status for new students
                'whatsapp' => $request->whatsapp,
                'status' => 'active',
            ]);

            // Auto login after registration
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            return $this->redirectByRole($user)
                ->with('success', 'Registration successful! Welcome to English Club ICH Medan.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Registration failed. Please try again.')
                ->withInput($request->except('password', 'password_confirmation', 'security_answer'));
        }
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully');
    }

    /**
     * Forgot Password - Step 1: Check Email
     */
    public function forgotPasswordCheckEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Email tidak ditemukan, coba lagi']);
        }
        
        $questions = [
            'mother_maiden_name' => 'Nama gadis ibu kandung Anda?',
            'pet_name' => 'Nama hewan peliharaan pertama Anda?',
            'birth_city' => 'Kota tempat Anda dilahirkan?',
            'elementary_school' => 'Nama sekolah dasar Anda?',
            'favorite_teacher' => 'Nama guru favorit Anda?',
            'childhood_friend' => 'Nama teman masa kecil terbaik Anda?'
        ];

        if (!$user->security_question) {
            return response()->json(['success' => false, 'message' => 'Akun ini tidak memiliki pertanyaan keamanan.']);
        }

        return response()->json([
            'success' => true,
            'question_key' => $user->security_question,
            'question_text' => $questions[$user->security_question] ?? 'Pertanyaan Keamanan',
        ]);
    }

    /**
     * Forgot Password - Step 2: Verify Answer
     */
    public function forgotPasswordVerifyAnswer(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'security_answer' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (Hash::check($request->security_answer, $user->security_answer)) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Jawaban keamanan salah.']);
    }

    /**
     * Forgot Password - Step 3: Reset Password
     */
    public function forgotPasswordReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'whatsapp' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->whatsapp === $request->whatsapp) {
            $user->password = Hash::make('123456');
            $user->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Nomor WhatsApp tidak cocok.']);
    }
}
