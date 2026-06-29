<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    protected $fillable = [
        'class_id',
        'teacher_id',
        'title',
        'session_date',
        'start_time',
        'end_time',
        'is_published',
        'is_open',
        'platform',
        'meeting_link',
        'meeting_status',
        'teacher_time_in',
        'teacher_time_out',
        'teacher_attendance_status',
    ];

    protected $casts = [
        'session_date' => 'date',
        'is_published' => 'boolean',
        'is_open' => 'boolean',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Check if attendance session is currently active (open + correct date).
     */
    public function getIsActiveAttribute()
    {
        // Manual override: if it's manually opened, it's active regardless of time/date
        if ($this->is_open) {
            return true;
        }

        if (!$this->session_date->isToday()) {
            return false;
        }

        if ($this->start_time && $this->end_time) {
            $now = now()->format('H:i:s');
            // Using >= and <= so that boundary exact times are inclusive
            return $now >= $this->start_time && $now <= $this->end_time;
        }

        return false;
    }
}
