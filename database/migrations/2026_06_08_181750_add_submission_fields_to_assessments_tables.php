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
        Schema::table('assessments', function (Blueprint $table) {
            $table->date('due_date')->nullable()->after('description');
            $table->time('due_time')->nullable()->after('due_date');
            $table->text('instructions')->nullable()->after('due_time');
            $table->string('attachment')->nullable()->after('instructions');
        });

        Schema::table('assessment_scores', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('student_id');
            $table->timestamp('submitted_at')->nullable()->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_scores', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'submitted_at']);
        });

        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn(['due_date', 'due_time', 'instructions', 'attachment']);
        });
    }
};
