<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = [
            [
                'user_id' => 7, // Ahmad Rizki
                'class_id' => 1, // Basic English - Morning Class
                'amount' => 1500000,
                'payment_method' => 'transfer',
                'payment_status' => 'paid',
                'payment_date' => Carbon::parse('2026-05-15'),
                'notes' => 'Payment via BCA transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 8, // Siti Nurhaliza
                'class_id' => 2, // Intermediate English - Afternoon Class
                'amount' => 2000000,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
                'payment_date' => Carbon::parse('2026-05-20'),
                'notes' => 'Cash payment at office',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 9, // Budi Santoso
                'class_id' => 3, // Advanced English - Evening Class
                'amount' => 2500000,
                'payment_method' => 'transfer',
                'payment_status' => 'paid',
                'payment_date' => Carbon::parse('2026-06-01'),
                'notes' => 'Payment via Mandiri transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 10, // Dewi Lestari
                'class_id' => 4, // Business English - Weekend Class
                'amount' => 3000000,
                'payment_method' => 'credit_card',
                'payment_status' => 'paid',
                'payment_date' => Carbon::parse('2026-05-25'),
                'notes' => 'Credit card payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 11, // Eko Prasetyo
                'class_id' => 5, // IELTS Preparation - Intensive Class
                'amount' => 3500000,
                'payment_method' => 'transfer',
                'payment_status' => 'paid',
                'payment_date' => Carbon::parse('2026-06-05'),
                'notes' => 'Payment via BNI transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 12, // Fitri Handayani
                'class_id' => 6, // TOEFL Preparation - Fast Track
                'amount' => 3500000,
                'payment_method' => 'transfer',
                'payment_status' => 'pending',
                'payment_date' => Carbon::parse('2026-07-10'),
                'notes' => 'Waiting for payment confirmation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 13, // Gunawan Wijaya
                'class_id' => 7, // Basic English - Evening Class
                'amount' => 1500000,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
                'payment_date' => Carbon::parse('2026-05-18'),
                'notes' => 'Cash payment at office',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 14, // Hani Kusuma
                'class_id' => 8, // Intermediate English - Weekend Class
                'amount' => 2000000,
                'payment_method' => 'transfer',
                'payment_status' => 'paid',
                'payment_date' => Carbon::parse('2026-05-22'),
                'notes' => 'Payment via BRI transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 15, // Indra Permana
                'class_id' => 1, // Basic English - Morning Class
                'amount' => 1500000,
                'payment_method' => 'transfer',
                'payment_status' => 'paid',
                'payment_date' => Carbon::parse('2026-05-16'),
                'notes' => 'Payment via BCA transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 16, // Joko Widodo
                'class_id' => 2, // Intermediate English - Afternoon Class
                'amount' => 2000000,
                'payment_method' => 'credit_card',
                'payment_status' => 'paid',
                'payment_date' => Carbon::parse('2026-05-21'),
                'notes' => 'Credit card payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 17, // Kartika Sari
                'class_id' => 3, // Advanced English - Evening Class
                'amount' => 2500000,
                'payment_method' => 'transfer',
                'payment_status' => 'failed',
                'payment_date' => Carbon::parse('2026-06-02'),
                'notes' => 'Payment failed - insufficient funds',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 18, // Linda Wijayanti
                'class_id' => 4, // Business English - Weekend Class
                'amount' => 3000000,
                'payment_method' => 'transfer',
                'payment_status' => 'paid',
                'payment_date' => Carbon::parse('2026-05-26'),
                'notes' => 'Payment via Mandiri transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7, // Ahmad Rizki (second payment)
                'class_id' => 5, // IELTS Preparation - Intensive Class
                'amount' => 3500000,
                'payment_method' => 'transfer',
                'payment_status' => 'paid',
                'payment_date' => Carbon::parse('2026-06-06'),
                'notes' => 'Payment via BCA transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 8, // Siti Nurhaliza (second payment)
                'class_id' => 6, // TOEFL Preparation - Fast Track
                'amount' => 3500000,
                'payment_method' => 'cash',
                'payment_status' => 'pending',
                'payment_date' => Carbon::parse('2026-07-11'),
                'notes' => 'Scheduled cash payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 9, // Budi Santoso (second payment)
                'class_id' => 7, // Basic English - Evening Class
                'amount' => 1500000,
                'payment_method' => 'transfer',
                'payment_status' => 'refunded',
                'payment_date' => Carbon::parse('2026-05-19'),
                'notes' => 'Refunded due to class cancellation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 10, // Dewi Lestari (second payment)
                'class_id' => 8, // Intermediate English - Weekend Class
                'amount' => 2000000,
                'payment_method' => 'credit_card',
                'payment_status' => 'paid',
                'payment_date' => Carbon::parse('2026-05-23'),
                'notes' => 'Credit card payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 11, // Eko Prasetyo (second payment)
                'class_id' => 1, // Basic English - Morning Class
                'amount' => 1500000,
                'payment_method' => 'transfer',
                'payment_status' => 'paid',
                'payment_date' => Carbon::parse('2026-05-17'),
                'notes' => 'Payment via BNI transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 12, // Fitri Handayani (second payment)
                'class_id' => 2, // Intermediate English - Afternoon Class
                'amount' => 2000000,
                'payment_method' => 'transfer',
                'payment_status' => 'pending',
                'payment_date' => Carbon::parse('2026-06-12'),
                'notes' => 'Waiting for payment confirmation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('payments')->insert($payments);
    }
}
