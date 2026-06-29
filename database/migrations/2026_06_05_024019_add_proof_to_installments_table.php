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
        Schema::table('payment_installments', function (Blueprint $table) {
            $table->string('proof_of_payment')->nullable()->after('status');
            $table->enum('verification_status', ['none', 'pending_verification', 'approved', 'rejected'])->default('none')->after('proof_of_payment');
            $table->unsignedBigInteger('verified_by')->nullable()->after('verification_status');
            $table->timestamp('verification_date')->nullable()->after('verified_by');
            
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_installments', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['proof_of_payment', 'verification_status', 'verified_by', 'verification_date']);
        });
    }
};
