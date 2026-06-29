<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentGrade extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'teacher_id',
        'listening',
        'speaking',
        'reading',
        'writing',
        'grammar',
        'attendance',
        'average',
        'notes',
        'published',
        'grade_date',
        'certificate_number',
        'issue_date',
        'qr_code',
        'verification_token',
        'certificate_status',
        'teacher_notes',
    ];

    protected $casts = [
        'listening' => 'decimal:2',
        'speaking' => 'decimal:2',
        'reading' => 'decimal:2',
        'writing' => 'decimal:2',
        'grammar' => 'decimal:2',
        'attendance' => 'decimal:2',
        'average' => 'decimal:2',
        'published' => 'boolean',
        'grade_date' => 'date',
        'issue_date' => 'date',
        'teacher_notes' => 'array',
    ];

    /**
     * Boot method to auto-calculate average.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($grade) {
            $grade->calculateAverage();
        });
    }

    /**
     * Calculate average grade from all components.
     */
    public function calculateAverage()
    {
        $components = [
            $this->listening,
            $this->speaking,
            $this->reading,
            $this->writing,
            $this->grammar,
        ];

        $validComponents = array_filter($components, function ($value) {
            return $value !== null;
        });

        if (count($validComponents) > 0) {
            $this->average = array_sum($validComponents) / count($validComponents);
        } else {
            $this->average = null;
        }
    }

    /**
     * Get the student.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the class.
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the teacher.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get letter grade based on average.
     */
    public function getLetterGradeAttribute()
    {
        if (!$this->average) {
            return 'N/A';
        }

        if ($this->average >= 90) return 'A';
        if ($this->average >= 80) return 'B';
        if ($this->average >= 70) return 'C';
        if ($this->average >= 60) return 'D';
        return 'F';
    }

    /**
     * Get final score attribute mapping.
     */
    public function getFinalScoreAttribute()
    {
        return $this->average;
    }

    /**
     * Get certificate status attribute mapping.
     */
    public function getStatusAttribute()
    {
        return $this->certificate_status;
    }

    /**
     * Get grade description based on letter grade.
     */
    public function getGradeDescriptionAttribute()
    {
        $grade = $this->letter_grade;
        return match($grade) {
            'A' => 'Excellent',
            'B' => 'Good',
            'C' => 'Satisfactory',
            'D' => 'Pass',
            'F' => 'Fail',
            default => 'N/A'
        };
    }
}
