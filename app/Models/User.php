<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'security_question',
        'security_answer',
        'role',
        'student_status',
        'whatsapp',
        'profile_photo',
        'status',
        'class_reminder',
        'grade_notification',
        'chat_notification',
        'material_notification',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'class_reminder' => 'boolean',
            'grade_notification' => 'boolean',
            'chat_notification' => 'boolean',
            'material_notification' => 'boolean',
        ];
    }

    /**
     * Get the classes taught by the teacher.
     */
    public function taughtClasses()
    {
        return $this->hasMany(SchoolClass::class, 'teacher_id');
    }

    /**
     * Get the payments made by the student.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the materials uploaded by the teacher.
     */
    public function materials()
    {
        return $this->hasMany(ClassMaterial::class, 'teacher_id');
    }

    /**
     * Get the grades given by the teacher.
     */
    public function givenGrades()
    {
        return $this->hasMany(StudentGrade::class, 'teacher_id');
    }

    /**
     * Get the grades received by the student.
     */
    public function receivedGrades()
    {
        return $this->hasMany(StudentGrade::class, 'student_id');
    }

    /**
     * Get enrolled classes (via paid payments).
     */
    public function enrolledClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'payments', 'user_id', 'class_id')
            ->wherePivot('payment_status', 'paid')
            ->withPivot('payment_date', 'amount')
            ->withTimestamps();
    }

    /**
     * Check if student is enrolled in a specific class.
     */
    public function isEnrolledIn($classId)
    {
        return $this->enrolledClasses()->where('classes.id', $classId)->exists();
    }

    /**
     * Get student's published grades.
     */
    public function publishedGrades()
    {
        return $this->receivedGrades()->where('published', true);
    }

    /**
     * Get student's GPA (average of all published grades).
     */
    public function getGpaAttribute()
    {
        return $this->publishedGrades()->avg('average') ?? 0;
    }

    /**
     * Get student's total certificates count.
     */
    public function getCertificateCountAttribute()
    {
        return $this->receivedGrades()
            ->whereNotNull('certificate_number')
            ->where('certificate_status', 'active')
            ->count();
    }

    /**
     * Get sent messages.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get received messages.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function assessmentScores()
    {
        return $this->hasMany(AssessmentScore::class, 'student_id');
    }

    public function createdAssessments()
    {
        return $this->hasMany(Assessment::class, 'teacher_id');
    }
}
