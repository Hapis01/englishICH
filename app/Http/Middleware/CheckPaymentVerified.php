<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

class CheckPaymentVerified
{
    /**
     * Handle an incoming request.
     * Ensure student's payment has been verified by admin.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Only apply to students
        if ($user->role !== 'student') {
            return $next($request);
        }

        // Check for overdue installments dynamically before anything else
        \App\Models\PaymentInstallment::checkAndUpdateOverdue($user);
        
        // Refresh the user to get the latest status
        $user->refresh();
        $status = $user->student_status;

        if ($status === 'ACTIVE') {
            return $next($request);
        }

        if ($status === 'AWAITING_PAYMENT') {
            return redirect()->route('student.payments')->with('error', 'Please make payment first.');
        }

        if ($status === 'PAYMENT_VERIFICATION') {
            return redirect()->route('student.payments')->with('info', 'Pembayaran sedang diverifikasi admin.');
        }

        if ($status === 'PAYMENT_OVERDUE') {
            return redirect()->route('student.payments')->with('error', 'Please make payment first.');
        }

        if ($status === 'SUSPENDED' || $status === 'INACTIVE') {
            return redirect()->route('student.dashboard')->with('error', 'Akun anda sedang diblokir atau tidak aktif.');
        }

        // Fallback
        return redirect()->route('student.dashboard')->with('error', 'Akses ditolak.');
    }
}
