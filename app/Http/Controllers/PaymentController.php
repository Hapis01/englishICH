<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Notifications\GeneralNotification;

class PaymentController extends Controller
{
    /**
     * Store a newly created payment.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'payment_date' => 'required|date',
            'proof_of_payment' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        // Handle file upload
        if ($request->hasFile('proof_of_payment')) {
            $data['proof_of_payment'] = $this->storeProofFile($request->file('proof_of_payment'));
        }

        $payment = Payment::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Payment recorded successfully',
            'data' => $payment->load(['user', 'schoolClass.course'])
        ], 201);
    }

    /**
     * Update the specified payment.
     */
    public function update(Request $request, Payment $payment)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'payment_date' => 'required|date',
            'proof_of_payment' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        // Handle file upload
        if ($request->hasFile('proof_of_payment')) {
            $data['proof_of_payment'] = $this->storeProofFile($request->file('proof_of_payment'), $payment->proof_of_payment);
        }

        $payment->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Payment updated successfully',
            'data' => $payment->load(['user', 'schoolClass.course'])
        ], 200);
    }

    /**
     * Remove the specified payment.
     */
    public function destroy(Payment $payment)
    {
        // Delete proof of payment file if exists
        $this->deleteProofFile($payment->proof_of_payment);

        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment deleted successfully'
        ], 200);
    }

    /**
     * Get students for dropdown.
     */
    public function getStudents()
    {
        $students = User::where('role', 'student')
            ->where('status', 'active')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    /**
     * Get classes for dropdown.
     */
    public function getClasses()
    {
        $classes = SchoolClass::with('course:id,name')
            ->where('status', 'active')
            ->select('id', 'name', 'course_id', 'schedule')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $classes
        ]);
    }

    /**
     * Create a new invoice/billing for a student.
     */
    public function createInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date|after:today',
            'payment_type' => 'nullable|in:Kursus Basic,Kursus Premium,Kursus VIP,Private Class,TOEFL Program,IELTS Program,Other',
            'payment_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::findOrFail($request->user_id);
        
        // Verify user is student
        if ($user->role !== 'student') {
            return response()->json([
                'success' => false,
                'error' => 'User must be a student'
            ], 400);
        }

        $invoice = Payment::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'payment_type' => $request->payment_type,
            'payment_notes' => $request->payment_notes,
            'payment_status' => 'pending',
            'verification_status' => 'none',
            'payment_date' => now()->toDateString(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Invoice created successfully',
            'data' => $invoice->load('user')
        ], 201);
    }

    public function uploadProof(Request $request, Payment $payment)
    {
        // Check if user is the student who created this payment
        if ($payment->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'proof_of_payment' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:5120', // 5MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $path = $this->storeProofFile($request->file('proof_of_payment'), $payment->proof_of_payment);

        $payment->update([
            'proof_of_payment' => $path,
            'proof_image' => $path,
            'verification_status' => 'pending_verification',
        ]);

        Auth::user()->update(['student_status' => 'PAYMENT_VERIFICATION']);

        return response()->json([
            'success' => true,
            'message' => 'Proof uploaded successfully',
            'data' => $payment
        ], 200);
    }

    public function uploadInstallmentProof(Request $request, \App\Models\PaymentInstallment $installment)
    {
        // Check if user is the student who created this payment
        if ($installment->payment->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized'
            ], 403);
        }

        // Enforce sequential: only allow upload for the next pending installment
        $nextPending = $installment->payment->installments()
            ->where('status', '!=', 'paid')
            ->where('verification_status', '!=', 'pending_verification')
            ->orderBy('installment_number')
            ->first();

        if (!$nextPending || $nextPending->id !== $installment->id) {
            return response()->json([
                'success' => false,
                'error' => 'Anda hanya bisa mengupload bukti pembayaran untuk cicilan berikutnya yang belum dibayar.'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'proof_of_payment' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $path = $this->storeProofFile($request->file('proof_of_payment'), $installment->proof_of_payment);

        $installment->update([
            'proof_of_payment' => $path,
            'verification_status' => 'pending_verification',
            'payment_date' => now(),
        ]);
        
        // Also update the main payment proof image
        $installment->payment->update([
            'proof_image' => $path,
            'proof_of_payment' => $path,
            'verification_status' => 'pending_verification',
        ]);

        Auth::user()->update(['student_status' => 'PAYMENT_VERIFICATION']);

        return response()->json([
            'success' => true,
            'message' => 'Proof uploaded successfully',
            'data' => $installment
        ], 200);
    }

    /**
     * Verify/approve payment by admin.
     */
    public function verifyPayment(Request $request, Payment $payment)
    {
        // Check if current user is admin
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $status = $request->status;

        if ($status === 'approved') {
            $payment->update([
                'verification_status' => 'approved',
                'payment_status' => 'paid',
                'verified_by' => Auth::id(),
                'verification_date' => now(),
                'verified_proof_of_payment' => $payment->proof_of_payment,
            ]);

            $payment->user->update(['student_status' => 'ACTIVE']);
            
            $payment->user->notify(new GeneralNotification(
                'Payment Approved',
                "Your payment of Rp " . number_format($payment->amount, 0, ',', '.') . " has been approved.",
                'payment',
                route('student.payments')
            ));
        } else {
            $payment->update([
                'verification_status' => 'rejected',
                'verified_by' => Auth::id(),
                'verification_date' => now(),
            ]);
            
            $payment->user->update(['student_status' => 'AWAITING_PAYMENT']);
            
            $payment->user->notify(new GeneralNotification(
                'Payment Rejected',
                "Your payment of Rp " . number_format($payment->amount, 0, ',', '.') . " was rejected. Please re-upload proof of payment.",
                'payment',
                route('student.payments')
            ));
        }

        if ($request->filled('notes')) {
            $payment->update(['notes' => $request->notes]);
        }

        return response()->json([
            'success' => true,
            'message' => "Payment {$status} successfully",
            'data' => $payment->load(['user', 'verifier'])
        ], 200);
    }

    public function verifyInstallment(Request $request, \App\Models\PaymentInstallment $installment)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $status = $request->status;

        if ($status === 'approved') {
            $installment->update([
                'verification_status' => 'approved',
                'status' => 'paid',
                'verified_by' => Auth::id(),
                'verification_date' => now(),
            ]);

            $payment = $installment->payment;
            
            // Update installment money tracking on parent Payment
            $installmentPaid = $payment->installment_paid + $installment->amount;
            $installmentRemaining = $payment->installment_total - $installmentPaid;
            
            // Find next due date from remaining pending installments
            $nextInstallment = $payment->installments()
                ->where('status', 'pending')
                ->where('id', '!=', $installment->id)
                ->orderBy('due_date')
                ->first();
                
            $nextDueDate = $nextInstallment ? $nextInstallment->due_date : null;
            $allPaid = $installmentRemaining <= 0;

            // Set parent payment as 'paid' once the FIRST installment is approved
            // This allows the student to enroll (enrolledClasses checks payment_status = paid)
            // The payment stays 'paid' throughout — tracking is done via installment counts
            $payment->update([
                'installment_paid' => $installmentPaid,
                'installment_remaining' => $installmentRemaining,
                'next_due_date' => $nextDueDate,
                'payment_status' => 'paid',
                'verification_status' => $allPaid ? 'approved' : 'none',
            ]);

            // Update student status
            $hasOverdue = $payment->user->payments()
                ->whereHas('installments', function ($query) {
                    $query->where('status', 'overdue');
                })->exists();
                
            if (!$hasOverdue) {
                $payment->user->update(['student_status' => 'ACTIVE']);
            }
            
            // Count-based tracking for notification
            $paidCount = $payment->installments()->where('status', 'paid')->count();
            $totalCount = $payment->installments()->count();
            
            $payment->user->notify(new GeneralNotification(
                'Installment Approved',
                "Cicilan ke-{$installment->installment_number} sebesar Rp " . number_format($installment->amount, 0, ',', '.') . " telah disetujui. Progress: {$paidCount}/{$totalCount} cicilan, Rp " . number_format($installmentPaid, 0, ',', '.') . " / Rp " . number_format($payment->installment_total, 0, ',', '.') . ".",
                'payment',
                route('student.payments')
            ));
        } else {
            $installment->update([
                'verification_status' => 'rejected',
                'status' => 'pending',
                'verified_by' => Auth::id(),
                'verification_date' => now(),
            ]);

            // Reset parent payment verification so student can re-upload
            $installment->payment->update(['verification_status' => 'none']);
            
            $installment->payment->user->update(['student_status' => 'AWAITING_PAYMENT']);
            
            $installment->payment->user->notify(new GeneralNotification(
                'Installment Rejected',
                "Cicilan ke-{$installment->installment_number} sebesar Rp " . number_format($installment->amount, 0, ',', '.') . " ditolak. Silakan upload ulang bukti pembayaran.",
                'payment',
                route('student.payments')
            ));
        }

        if ($request->filled('notes')) {
            $installment->update(['notes' => $request->notes]);
        }

        return response()->json([
            'success' => true,
            'message' => "Installment {$status} successfully",
        ], 200);
    }

    /**
     * Get pending verification payments for admin.
     */
    public function getPendingVerification()
    {
        $payments = Payment::where('verification_status', 'pending_verification')
            ->with(['user', 'verifier'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $payments
        ]);
    }

    private function storeProofFile($file, $existingPath = null)
    {
        $directory = public_path('images/payment-proofs');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if ($existingPath) {
            $this->deleteProofFile($existingPath);
        }

        $originalName = $file->getClientOriginalName();
        $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
        $filename = 'payment_' . time() . '_' . $safeName;

        $file->move($directory, $filename);

        return 'images/payment-proofs/' . $filename;
    }

    private function deleteProofFile($path)
    {
        if (!$path) {
            return;
        }

        $publicPath = public_path($path);

        if (file_exists($publicPath)) {
            @unlink($publicPath);
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
