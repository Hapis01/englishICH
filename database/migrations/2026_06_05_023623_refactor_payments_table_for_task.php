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
            if (Schema::hasColumn('payments', 'payment_type')) {
                // MariaDB/MySQL sometimes struggles to modify ENUM directly, so we can change it via raw DB statement
                // But let's try dropping the column and recreating it, since old data might be conflicting
                $table->dropColumn('payment_type');
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_type', ['FULL', 'INSTALLMENT'])->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'payment_type')) {
                $table->dropColumn('payment_type');
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_type', ['Kursus Basic','Kursus Premium','Kursus VIP','Private Class','TOEFL Program','IELTS Program','Other'])->nullable()->after('payment_status');
        });
    }
};
