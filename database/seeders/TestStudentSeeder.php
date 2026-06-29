<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Payment;
use App\Models\ClassMaterial;
use App\Models\StudentGrade;
use App\Models\Certificate;
use App\Models\NotificationPreference;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestStudentSeeder extends Seeder
{
    /**
     * Seed test student with complete data.
     */
    public function run(): void
    {
        // Create or get test student
        $student = User::firstOrCreate(
            ['email' => 'student@ich.com'],
            [
                'name' => 'Test Student',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'phone' => '+628123456789',
                'whatsapp' => '+628123456789',
                'status' => 'active',
            ]
        );

        echo "✓ Test student created: {$student->email}\n";

        // Create notification preferences
        NotificationPreference::firstOrCreate(
            ['user_id' => $student->id],
            NotificationPreference::defaults()
        );

        echo "✓ Notification preferences created\n";

        // Get active classes
        $classes = SchoolClass::where('status', 'active')->limit(3)->get();

        if ($classes->isEmpty()) {
            echo "⚠ No active classes found. Please run ClassSeeder first.\n";
            return;
        }

        // Enroll student in classes via payments
        foreach ($classes as $class) {
            Payment::firstOrCreate(
                [
                    'user_id' => $student->id,
                    'class_id' => $class->id,
                ],
                [
                    'amount' => 500000,
                    'payment_status' => 'paid',
                    'payment_date' => Carbon::now(),
                    'payment_method' => 'transfer',
                ]
            );
        }

        echo "✓ Student enrolled in {$classes->count()} classes\n";

        // Create sample grades for enrolled classes
        foreach ($classes as $class) {
            StudentGrade::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'class_id' => $class->id,
                    'teacher_id' => $class->teacher_id,
                ],
                [
                    'listening' => rand(70, 95),
                    'speaking' => rand(70, 95),
                    'reading' => rand(70, 95),
                    'writing' => rand(70, 95),
                    'attendance' => rand(80, 100),
                    'published' => true,
                    'grade_date' => Carbon::now()->subDays(rand(1, 30)),
                    'notes' => 'Great progress! Keep up the good work.',
                ]
            );
        }

        echo "✓ Sample grades created\n";

        // Create a certificate for the first class
        if ($classes->isNotEmpty()) {
            $firstClass = $classes->first();
            $grade = StudentGrade::where('student_id', $student->id)
                ->where('class_id', $firstClass->id)
                ->first();

            if ($grade) {
                Certificate::firstOrCreate(
                    [
                        'student_id' => $student->id,
                        'class_id' => $firstClass->id,
                    ],
                    [
                        'final_score' => $grade->average,
                        'issue_date' => Carbon::now(),
                        'status' => 'active',
                    ]
                );

                echo "✓ Sample certificate created\n";
            }
        }

        echo "\n";
        echo "========================================\n";
        echo "TEST STUDENT ACCOUNT READY\n";
        echo "========================================\n";
        echo "Email: student@ich.com\n";
        echo "Password: password123\n";
        echo "Enrolled Classes: {$classes->count()}\n";
        echo "GPA: " . number_format($student->fresh()->gpa, 2) . "\n";
        echo "Certificates: {$student->fresh()->certificate_count}\n";
        echo "========================================\n";
    }
}
