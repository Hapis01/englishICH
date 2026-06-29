<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'course_id',
        'teacher_id',
        'name',
        'learning_method',
        'schedule',
        'max_students',
        'current_students',
        'start_date',
        'end_date',
        'gmeet_link',
        'status',
        'teacher_attendance_days',
        'teacher_start_time',
        'teacher_end_time',
        'teacher_schedule_type',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'teacher_attendance_days' => 'array',
    ];

    /**
     * Get the course that owns the class.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the teacher that teaches the class.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the payments for the class.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'class_id');
    }

    /**
     * Get the materials for the class.
     */
    public function materials()
    {
        return $this->hasMany(ClassMaterial::class, 'class_id');
    }

    /**
     * Get the grades for the class.
     */
    public function grades()
    {
        return $this->hasMany(StudentGrade::class, 'class_id');
    }

    /**
     * Get students enrolled in this class (via payments).
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'payments', 'class_id', 'user_id')
            ->where('users.role', 'student')
            ->where('payments.payment_status', 'paid')
            ->distinct();
    }

    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class, 'class_id');
    }

    public function onlineMeetings()
    {
        return $this->hasMany(AttendanceSession::class, 'class_id')
                    ->where('platform', '!=', 'Offline');
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'class_id');
    }

    /**
     * Get the weeks for this class.
     */
    public function weeks()
    {
        return $this->hasMany(Week::class, 'class_id')->orderBy('week_number');
    }




    /**
     * Parse schedule string to get days.
     * e.g. "Monday & Wednesday 08:00-10:00" => ['Monday', 'Wednesday']
     */
    public function getScheduleDaysAttribute()
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $scheduleDays = [];
        foreach ($days as $day) {
            if (stripos($this->schedule, $day) !== false) {
                $scheduleDays[] = $day;
            }
        }
        return $scheduleDays;
    }

    /**
     * Parse schedule string to get time range.
     * e.g. "Monday & Wednesday 08:00-10:00" => ['08:00', '10:00']
     */
    public function getScheduleTimeAttribute()
    {
        if (preg_match('/(\d{2}:\d{2})-(\d{2}:\d{2})/', $this->schedule, $matches)) {
            return ['start' => $matches[1], 'end' => $matches[2]];
        }
        return null;
    }
}
