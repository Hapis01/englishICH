<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\SchoolClass;
use App\Models\Payment;
use App\Models\PaymentInstallment;
use App\Models\StudentGrade;
use App\Models\Assessment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard overview.
     */
    public function index()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        
        $totalFullPaymentRevenue = Payment::where('payment_type', 'full')->where('payment_status', 'paid')->sum('amount');
        $totalInstallmentRevenue = PaymentInstallment::where('status', 'paid')->sum('amount');
        $totalRevenue = $totalFullPaymentRevenue + $totalInstallmentRevenue;

        $studentStatusCounts = User::where('role', 'student')
            ->select('student_status', DB::raw('count(*) as total'))
            ->groupBy('student_status')
            ->pluck('total', 'student_status');

        $recentPayments = Payment::with(['user', 'schoolClass'])
            ->latest()
            ->take(5)
            ->get();
        $upcomingClasses = SchoolClass::with(['course', 'teacher'])
            ->where('status', 'active')
            ->orderBy('start_date')
            ->take(5)
            ->get();

        // Performance Statistics
        $overallGpa = StudentGrade::avg('average') ?? 0;
        $avgAttendance = StudentGrade::avg('attendance') ?? 0;
        $totalAssessments = Assessment::count();

        return view('admin.index', compact(
            'totalStudents',
            'totalTeachers',
            'totalRevenue',
            'recentPayments',
            'upcomingClasses',
            'studentStatusCounts',
            'overallGpa',
            'avgAttendance',
            'totalAssessments'
        ));
    }

    /**
     * Display all payments/transactions.
     */
    public function payments(Request $request)
    {
        // Dynamically update overdue installments globally before calculating stats
        \App\Models\PaymentInstallment::checkAndUpdateOverdue();

        $stats = [
            'total_full' => Payment::where('payment_type', 'full')->count(),
            'total_installment' => Payment::where('payment_type', 'installment')->count(),
            'total_paid' => Payment::where('payment_status', 'paid')->count(),
            'total_pending' => Payment::where('payment_status', 'pending')->count(),
            'total_overdue' => \App\Models\PaymentInstallment::where('status', 'overdue')->count() + Payment::where('payment_status', 'failed')->count(),
        ];

        $query = Payment::with(['user', 'schoolClass.course', 'installments']);

        // Search by user name or payment method
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Filter by payment status
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        // Filter by payment type
        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        $payments = $query->latest()->paginate(10);

        return view('admin.payments', compact('payments', 'stats'));
    }

    /**
     * Display all students.
     */
    public function students(Request $request)
    {
        $query = User::where('role', 'student')->with('payments');

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('whatsapp', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->latest()->paginate(20)->withQueryString();

        return view('admin.students', compact('students'));
    }

    /**
     * Display all teachers.
     */
    public function teachers(Request $request)
    {
        $query = User::where('role', 'teacher')->with('taughtClasses');

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('whatsapp', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $teachers = $query->latest()->paginate(20)->withQueryString();

        return view('admin.teachers', compact('teachers'));
    }

    /**
     * Display class scheduling.
     */
    public function scheduling(Request $request)
{
    $query = SchoolClass::with(['course', 'teacher', 'payments', 'students']);

    // Search
    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('name', 'like', "%{$search}%")

                ->orWhereHas('teacher', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })

                ->orWhereHas('course', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });

        });
    }

    // Status Filter
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Date Filter
    if ($request->filled('date_from')) {
        $query->whereDate('start_date', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('end_date', '<=', $request->date_to);
    }

    $classes = $query->latest()->paginate(20)->withQueryString();

    // FIX VARIABLE
    $courses = Course::where('status', 'active')->get();

    $teachers = User::where('role', 'teacher')
        ->where('status', 'active')
        ->get();

    return view('admin.scheduling', compact(
        'classes',
        'courses',
        'teachers'
    ));
}
public function settings()
{
    $admin = Auth::user();

    return view('admin.settings', compact('admin'));
}
public function updateProfile(Request $request)
{
    $admin = Auth::user();

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $admin->id,
        'whatsapp' => 'nullable|string|max:20',
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {

        return back()
            ->withErrors($validator)
            ->withInput();
    }

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'whatsapp' => $request->whatsapp,
    ];

    if ($request->hasFile('profile_photo')) {
        $file = $request->file('profile_photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('profile'), $filename);
        
        // Delete old photo if exists
        if ($admin->profile_photo && file_exists(public_path('profile/' . $admin->profile_photo))) {
            @unlink(public_path('profile/' . $admin->profile_photo));
        }
        
        $data['profile_photo'] = $filename;
    }

    $admin->update($data);

    \App\Models\UserLog::record($admin->id, 'Profile Updated', 'Admin updated their profile information.');

    return back()->with('success', 'Profile updated successfully');
}
public function updatePassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    if ($validator->fails()) {

        return back()
            ->withErrors($validator)
            ->withInput();
    }

    $admin = Auth::user();

    if (!Hash::check($request->current_password, $admin->password)) {

        return back()->with('error', 'Current password is incorrect');
    }

    $admin->update([
        'password' => Hash::make($request->new_password)
    ]);

    \App\Models\UserLog::record($admin->id, 'Password Changed', 'Admin changed their password.');

    return back()->with('success', 'Password updated successfully');
}

public function getUserLogs(User $user)
{
    $logs = \App\Models\UserLog::where('user_id', $user->id)
        ->with('causer')
        ->latest()
        ->get()
        ->map(function ($log) {
            return [
                'id' => $log->id,
                'action' => $log->action,
                'description' => $log->description,
                'causer_name' => $log->causer ? $log->causer->name : 'System',
                'created_at' => $log->created_at->format('d M Y H:i:s'),
                'created_at_human' => $log->created_at->diffForHumans()
            ];
        });

    return response()->json([
        'success' => true,
        'logs' => $logs
    ]);
}
}

