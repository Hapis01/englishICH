<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. users & notification_preferences
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('class_reminder')->default(true);
            $table->boolean('grade_notification')->default(true);
            $table->boolean('chat_notification')->default(true);
            $table->boolean('material_notification')->default(true);
        });

        DB::table('notification_preferences')->orderBy('id')->chunk(100, function ($prefs) {
            foreach ($prefs as $pref) {
                DB::table('users')->where('id', $pref->user_id)->update([
                    'class_reminder' => $pref->class_reminder,
                    'grade_notification' => $pref->grade_notification,
                    'chat_notification' => $pref->chat_notification,
                    'material_notification' => $pref->material_notification,
                ]);
            }
        });
        Schema::dropIfExists('notification_preferences');

        // 2. classes & teacher_attendance_settings
        Schema::table('classes', function (Blueprint $table) {
            $table->json('teacher_attendance_days')->nullable();
            $table->time('teacher_start_time')->nullable();
            $table->time('teacher_end_time')->nullable();
            $table->string('teacher_schedule_type')->nullable();
        });

        DB::table('teacher_attendance_settings')->orderBy('id')->chunk(100, function ($settings) {
            foreach ($settings as $setting) {
                DB::table('classes')->where('id', $setting->class_id)->update([
                    'teacher_attendance_days' => $setting->days,
                    'teacher_start_time' => $setting->start_time,
                    'teacher_end_time' => $setting->end_time,
                    'teacher_schedule_type' => $setting->schedule_type,
                ]);
            }
        });

        // 3. attendance_sessions & online_meetings & teacher_attendances
        Schema::table('attendance_sessions', function (Blueprint $table) {
            $table->enum('platform', ['Google Meet', 'Zoom', 'Offline'])->default('Offline');
            $table->string('meeting_link')->nullable();
            $table->enum('meeting_status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->time('teacher_time_in')->nullable();
            $table->time('teacher_time_out')->nullable();
            $table->enum('teacher_attendance_status', ['Present', 'Late', 'Absent', 'Invalid'])->default('Absent');
        });

        DB::table('online_meetings')->orderBy('id')->chunk(100, function ($meetings) {
            foreach ($meetings as $meeting) {
                $session = DB::table('attendance_sessions')
                    ->where('class_id', $meeting->class_id)
                    ->where('session_date', $meeting->meeting_date)
                    ->first();
                
                if ($session) {
                    DB::table('attendance_sessions')->where('id', $session->id)->update([
                        'platform' => $meeting->platform,
                        'meeting_link' => $meeting->link,
                        'meeting_status' => $meeting->status,
                    ]);
                } else {
                    DB::table('attendance_sessions')->insert([
                        'class_id' => $meeting->class_id,
                        'teacher_id' => $meeting->teacher_id,
                        'title' => $meeting->title,
                        'session_date' => $meeting->meeting_date,
                        'start_time' => $meeting->meeting_time,
                        'is_published' => $meeting->is_published,
                        'platform' => $meeting->platform,
                        'meeting_link' => $meeting->link,
                        'meeting_status' => $meeting->status,
                        'created_at' => $meeting->created_at,
                        'updated_at' => $meeting->updated_at,
                    ]);
                }
            }
        });

        DB::table('teacher_attendances')->orderBy('id')->chunk(100, function ($attendances) {
            foreach ($attendances as $att) {
                $session = DB::table('attendance_sessions')
                    ->where('class_id', $att->class_id)
                    ->where('session_date', $att->date)
                    ->first();
                
                if ($session) {
                    DB::table('attendance_sessions')->where('id', $session->id)->update([
                        'teacher_time_in' => $att->time_in,
                        'teacher_time_out' => $att->time_out,
                        'teacher_attendance_status' => $att->status,
                    ]);
                } else {
                    DB::table('attendance_sessions')->insert([
                        'class_id' => $att->class_id,
                        'teacher_id' => $att->teacher_id,
                        'title' => 'Session ' . $att->date,
                        'session_date' => $att->date,
                        'teacher_time_in' => $att->time_in,
                        'teacher_time_out' => $att->time_out,
                        'teacher_attendance_status' => $att->status,
                        'created_at' => $att->created_at,
                        'updated_at' => $att->updated_at,
                    ]);
                }
            }
        });

        Schema::dropIfExists('online_meetings');
        Schema::dropIfExists('teacher_attendances');
        Schema::dropIfExists('teacher_attendance_settings');

        // 4. student_grades & certificates & teacher_student_notes
        Schema::table('student_grades', function (Blueprint $table) {
            $table->string('certificate_number')->nullable()->unique();
            $table->date('issue_date')->nullable();
            $table->text('qr_code')->nullable();
            $table->string('verification_token')->nullable()->unique();
            $table->enum('certificate_status', ['active', 'revoked'])->default('active');
            $table->json('teacher_notes')->nullable();
        });

        DB::table('certificates')->orderBy('id')->chunk(100, function ($certs) {
            foreach ($certs as $cert) {
                DB::table('student_grades')
                    ->where('student_id', $cert->student_id)
                    ->where('class_id', $cert->class_id)
                    ->update([
                        'certificate_number' => $cert->certificate_number,
                        'issue_date' => $cert->issue_date,
                        'qr_code' => $cert->qr_code,
                        'verification_token' => $cert->verification_token,
                        'certificate_status' => $cert->status,
                    ]);
            }
        });

        DB::table('teacher_student_notes')->orderBy('id')->chunk(100, function ($notes) {
            foreach ($notes as $note) {
                $grade = DB::table('student_grades')
                    ->where('student_id', $note->student_id)
                    ->where('teacher_id', $note->teacher_id)
                    ->first();
                if ($grade) {
                    $existing = $grade->teacher_notes ? json_decode($grade->teacher_notes, true) : [];
                    $existing[] = [
                        'content' => $note->content,
                        'date' => $note->created_at ?? now()
                    ];
                    DB::table('student_grades')->where('id', $grade->id)->update([
                        'teacher_notes' => json_encode($existing)
                    ]);
                }
            }
        });

        Schema::dropIfExists('certificates');
        Schema::dropIfExists('teacher_student_notes');

        // 5. messages & conversations
        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('receiver_id')->nullable()->after('sender_id');
        });

        DB::table('messages')->orderBy('id')->chunk(100, function ($messages) {
            foreach ($messages as $msg) {
                $conv = DB::table('conversations')->where('id', $msg->conversation_id)->first();
                if ($conv) {
                    $receiverId = ($msg->sender_id == $conv->student_id) ? $conv->teacher_id : $conv->student_id;
                    DB::table('messages')->where('id', $msg->id)->update(['receiver_id' => $receiverId]);
                }
            }
        });

        try {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropForeign(['conversation_id']);
            });
        } catch (\Exception $e) {}

        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('conversation_id');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::dropIfExists('conversations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Not implemented for brevity
    }
};
