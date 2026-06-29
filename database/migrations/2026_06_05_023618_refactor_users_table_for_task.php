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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('users', 'avatar')) {
                $table->renameColumn('avatar', 'profile_photo');
            }
            if (!Schema::hasColumn('users', 'student_status')) {
                $table->enum('student_status', [
                    'CLASS_NOT_SELECTED', 
                    'AWAITING_PAYMENT', 
                    'PAYMENT_VERIFICATION', 
                    'ACTIVE', 
                    'PAYMENT_OVERDUE', 
                    'SUSPENDED', 
                    'INACTIVE'
                ])->default('CLASS_NOT_SELECTED')->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'profile_photo')) {
                $table->renameColumn('profile_photo', 'avatar');
            }
            if (Schema::hasColumn('users', 'student_status')) {
                $table->dropColumn('student_status');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }
        });
    }
};
