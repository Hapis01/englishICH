<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates weeks table, assignments table, assignment_submissions table,
     * and modifies class_materials and attendance_sessions tables.
     */
    public function up(): void
    {
        // 1. Create weeks table for weekly learning materials grouping
        Schema::create('weeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->integer('week_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['class_id', 'week_number']);
            $table->index('class_id');
        });

        // 2. Add week_id to class_materials (nullable for backward compatibility)
        Schema::table('class_materials', function (Blueprint $table) {
            $table->foreignId('week_id')->nullable()->after('class_id')->constrained('weeks')->nullOnDelete();
            $table->index('week_id');
        });

        // 3. Add is_open, start_time, end_time to attendance_sessions
        Schema::table('attendance_sessions', function (Blueprint $table) {
            $table->boolean('is_open')->default(false)->after('is_published');
            $table->time('start_time')->nullable()->after('session_date');
            $table->time('end_time')->nullable()->after('start_time');
        });

        // 4. Create assignments table
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('week_id')->nullable()->constrained('weeks')->nullOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            $table->date('due_date');
            $table->time('due_time')->nullable();
            $table->string('attachment')->nullable();
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
            $table->timestamps();

            $table->index(['class_id', 'status']);
            $table->index('teacher_id');
            $table->index('week_id');
        });

        // 5. Create assignment_submissions table
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->string('file_path');
            $table->text('notes')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->decimal('score', 5, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->timestamp('graded_at')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['assignment_id', 'student_id']);
            $table->index('student_id');
            $table->index('graded_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('assignments');

        Schema::table('attendance_sessions', function (Blueprint $table) {
            $table->dropColumn(['is_open', 'start_time', 'end_time']);
        });

        Schema::table('class_materials', function (Blueprint $table) {
            $table->dropForeign(['week_id']);
            $table->dropIndex(['week_id']);
            $table->dropColumn('week_id');
        });

        Schema::dropIfExists('weeks');
    }
};
