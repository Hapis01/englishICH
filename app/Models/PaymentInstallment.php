<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentInstallment extends Model
{
    protected $fillable = [
        'payment_id',
        'installment_number',
        'amount',
        'due_date',
        'payment_date',
        'status',
        'notes',
        'proof_of_payment',
        'verification_status',
        'verified_by',
        'verification_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'payment_date' => 'date',
        'verification_date' => 'datetime',
    ];

    /**
     * Get the payment that owns the installment.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Get the admin who verified the installment payment.
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check and update overdue installments.
     * Can optionally scope to a specific user.
     */
    public static function checkAndUpdateOverdue($user = null)
    {
        $query = self::where('status', 'pending')
            ->whereDate('due_date', '<', now()->toDateString());
            
        if ($user) {
            $query->whereHas('payment', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $overdueInstallments = $query->with('payment.user')->get();

        foreach ($overdueInstallments as $installment) {
            $installment->update(['status' => 'overdue']);
            
            $student = $installment->payment->user;
            if ($student && in_array($student->student_status, ['ACTIVE', 'AWAITING_PAYMENT'])) {
                $student->update(['student_status' => 'PAYMENT_OVERDUE']);
            }
        }
    }
}
