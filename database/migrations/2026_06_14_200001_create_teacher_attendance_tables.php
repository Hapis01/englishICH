<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_attendance_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->json('days'); // e.g. ["Monday","Wednesday","Friday"]
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('attendance_type', ['morning', 'afternoon'])->default('morning');
            $table->enum('schedule_type', ['today_only', 'recurring'])->default('recurring');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('teacher_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('setting_id')->nullable()->constrained('teacher_attendance_settings')->onDelete('set null');
            $table->date('date');
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->enum('status', ['Present', 'Late', 'Absent', 'Invalid'])->default('Absent');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['teacher_id', 'class_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_attendances');
        Schema::dropIfExists('teacher_attendance_settings');
    }
};
