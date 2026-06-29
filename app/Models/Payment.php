<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'class_id',
        'amount',
        'payment_status',
        'payment_date',
        'proof_of_payment',
        'notes',
        'title',
        'description',
        'due_date',
        'payment_type',
        'installment_total',
        'installment_paid',
        'installment_remaining',
        'next_due_date',
        'proof_image',
        'payment_notes',
        'verification_status',
        'verified_by',
        'verification_date',
        'verified_proof_of_payment',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'installment_total' => 'decimal:2',
        'installment_paid' => 'decimal:2',
        'installment_remaining' => 'decimal:2',
        'payment_date' => 'date',
        'due_date' => 'date',
        'next_due_date' => 'date',
        'verification_date' => 'datetime',
    ];

    /**
     * Get the user (student) that made the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the class that the payment is for.
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the admin who verified the payment.
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get the installments for the payment.
     */
    public function installments()
    {
        return $this->hasMany(PaymentInstallment::class);
    }

    /**
     * Get the count of paid (approved) installments.
     */
    public function getPaidInstallmentCountAttribute()
    {
        return $this->installments()->where('status', 'paid')->count();
    }

    /**
     * Get the total number of installments.
     */
    public function getTotalInstallmentCountAttribute()
    {
        return $this->installments()->count();
    }
}
