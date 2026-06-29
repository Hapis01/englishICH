<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Phase 1: Drop unused tables (password_reset_tokens, chat_requests, failed_jobs, jobs, job_batches)
     * Phase 2: Merge assignments into assessments (add week_id to assessments, drop assignment tables)
     */
    public function up(): void
    {
        // Phase 1: Drop unused tables
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('chat_requests');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');

        // Phase 2: Add week_id to assessments to absorb assignment functionality
        Schema::table('assessments', function (Blueprint $table) {
            $table->foreignId('week_id')->nullable()->after('teacher_id')
                  ->constrained('weeks')->nullOnDelete();
        });

        // Phase 2: Drop assignment tables (both are empty, no data loss)
        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('assignments');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate assignments table
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
            $table->boolean('is_open')->default(false);
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->timestamps();

            $table->index(['class_id', 'status']);
            $table->index('teacher_id');
            $table->index('week_id');
        });

        // Recreate assignment_submissions table
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

        // Remove week_id from assessments
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropForeign(['week_id']);
            $table->dropColumn('week_id');
        });

        // Recreate unused tables
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('chat_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('recipient_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'blocked'])->default('pending');
            $table->text('message')->nullable();
            $table->timestamps();
            $table->unique(['sender_id', 'recipient_id']);
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });
    }
};
