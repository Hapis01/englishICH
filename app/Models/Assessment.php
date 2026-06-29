<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'class_id',
        'teacher_id',
        'week_id',
        'title',
        'type',
        'description',
        'instructions',
        'start_date',
        'start_time',
        'due_date',
        'due_time',
        'attachment',
        'is_published',
        'is_open',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_open' => 'boolean',
        'start_date' => 'date',
        'due_date' => 'date',
    ];

    /**
     * Check if assessment is active (can be submitted).
     */
    public function getIsActiveAttribute()
    {
        if ($this->is_open) {
            return true;
        }

        if (!$this->is_published) {
            return false;
        }

        $now = now();
        $isPastStart = true;

        if ($this->start_date) {
            $startDateTime = $this->start_time 
                ? $this->start_date->copy()->setTimeFromTimeString($this->start_time)
                : $this->start_date->copy()->startOfDay();
            $isPastStart = $now->gte($startDateTime);
        }

        return $isPastStart && !$this->is_overdue;
    }

    /**
     * Check if assessment is upcoming.
     */
    public function getIsUpcomingAttribute()
    {
        if ($this->is_open || !$this->is_published) {
            return false;
        }

        if (!$this->start_date) {
            return false; // If no start date, it's immediately active (or overdue)
        }

        $now = now();
        $startDateTime = $this->start_time 
            ? $this->start_date->copy()->setTimeFromTimeString($this->start_time)
            : $this->start_date->copy()->startOfDay();

        return $now->lt($startDateTime);
    }

    /**
     * Check if assessment is overdue.
     */
    public function getIsOverdueAttribute()
    {
        if (!$this->is_published) {
            return true; // Technically closed
        }

        if (!$this->due_date) return false;
        
        if ($this->due_time) {
            return now()->gt($this->due_date->copy()->setTimeFromTimeString($this->due_time));
        }
        return now()->gt($this->due_date->copy()->endOfDay());
    }

    public function week()
    {
        return $this->belongsTo(Week::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function scores()
    {
        return $this->hasMany(AssessmentScore::class);
    }
}
