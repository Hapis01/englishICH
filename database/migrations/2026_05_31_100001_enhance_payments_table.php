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
            // Add new columns for invoice system
            $table->string('title')->nullable()->after('notes');
            $table->text('description')->nullable()->after('title');
            $table->date('due_date')->nullable()->after('description');
            $table->enum('verification_status', ['pending_verification', 'approved', 'rejected', 'none'])->default('none')->after('payment_status');
            $table->unsignedBigInteger('verified_by')->nullable()->after('verification_status');
            $table->timestamp('verification_date')->nullable()->after('verified_by');
            $table->string('verified_proof_of_payment')->nullable()->after('verification_date');
            
            // Add foreign key for verified_by
            $table->foreign('verified_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['title', 'description', 'due_date', 'verification_status', 'verified_by', 'verification_date', 'verified_proof_of_payment']);
        });
    }
};
