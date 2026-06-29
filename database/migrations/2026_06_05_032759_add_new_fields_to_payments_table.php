<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop old payment_type if it is enum and replace with string
            if (Schema::hasColumn('payments', 'payment_type')) {
                $table->dropColumn('payment_type');
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            // New fields from TASK.md
            $table->string('payment_type')->nullable()->after('payment_status');
            $table->decimal('installment_total', 10, 2)->nullable()->after('payment_type');
            $table->decimal('installment_paid', 10, 2)->nullable()->after('installment_total');
            $table->decimal('installment_remaining', 10, 2)->nullable()->after('installment_paid');
            $table->date('next_due_date')->nullable()->after('due_date');
            
            // proof_image (proof_of_payment already exists, we will keep both or replace? The user said "Tambahkan jika belum ada: proof_image". I will just add it)
            if (!Schema::hasColumn('payments', 'proof_image')) {
                $table->string('proof_image')->nullable()->after('proof_of_payment');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'payment_type',
                'installment_total',
                'installment_paid',
                'installment_remaining',
                'next_due_date',
                'proof_image'
            ]);
        });
    }
};
