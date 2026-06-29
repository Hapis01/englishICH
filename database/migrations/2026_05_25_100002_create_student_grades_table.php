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
        Schema::create('student_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            
            // Grade components (0-100)
            $table->decimal('listening', 5, 2)->nullable();
            $table->decimal('speaking', 5, 2)->nullable();
            $table->decimal('reading', 5, 2)->nullable();
            $table->decimal('writing', 5, 2)->nullable();
            $table->decimal('attendance', 5, 2)->nullable();
            
            // Auto-calculated average
            $table->decimal('average', 5, 2)->nullable();
            
            // Additional info
            $table->text('notes')->nullable();
            $table->boolean('published')->default(false);
            $table->date('grade_date')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->index('student_id');
            $table->index('class_id');
            $table->index('teacher_id');
            $table->index('published');
            
            // Unique constraint: one grade record per student per class
            $table->unique(['student_id', 'class_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_grades');
    }
};
