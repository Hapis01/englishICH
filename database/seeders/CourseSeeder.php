<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'name' => 'Basic',
                'description' => 'Fundamental English course for beginners. Learn basic grammar, vocabulary, and conversation skills.',
                'subtitle' => 'Perfect for beginners',
                'suitable_for' => 'Beginners & Casual Learners',
                'level' => 'basic',
                'original_price' => 2500000,
                'price' => 1999000,
                'duration' => 3,
                'features' => json_encode([
                    '12 live sessions',
                    'Basic learning materials',
                    'Certificate of completion',
                    'Email support'
                ]),
                'is_featured' => false,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Intermediate',
                'description' => 'Intermediate level English course. Improve your grammar, expand vocabulary, and enhance communication skills.',
                'subtitle' => 'Best value for serious learners',
                'suitable_for' => 'Intermediate Learners & Professionals',
                'level' => 'intermediate',
                'original_price' => 4500000,
                'price' => 3499000,
                'duration' => 3,
                'features' => json_encode([
                    '24 live sessions',
                    'Complete learning materials',
                    'Certificate of completion',
                    'Priority support',
                    'Access to learning portal',
                    'Monthly progress report'
                ]),
                'is_featured' => true,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Advanced',
                'description' => 'Advanced English course for fluent speakers. Master complex grammar, idioms, and professional communication.',
                'subtitle' => 'Ultimate learning experience',
                'suitable_for' => 'Advanced Learners & Career Focus',
                'level' => 'advanced',
                'original_price' => 7500000,
                'price' => 5999000,
                'duration' => 3,
                'features' => json_encode([
                    '36 live sessions',
                    'Advanced learning materials',
                    'Certificate of completion',
                    '24/7 priority support',
                    'Full portal access',
                    'Weekly progress report',
                    '1-on-1 mentoring sessions',
                    'Exclusive workshops'
                ]),
                'is_featured' => false,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Business English',
                'description' => 'Specialized course for business professionals. Learn business vocabulary, presentation skills, and corporate communication.',
                'subtitle' => 'For professionals',
                'suitable_for' => 'Business Professionals',
                'level' => 'business',
                'original_price' => 4000000,
                'price' => 3000000,
                'duration' => 3,
                'features' => json_encode([
                    '24 live sessions',
                    'Business materials'
                ]),
                'is_featured' => false,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IELTS Preparation',
                'description' => 'Comprehensive IELTS preparation course. Practice all four skills: listening, reading, writing, and speaking.',
                'subtitle' => 'Ace the IELTS',
                'suitable_for' => 'Students planning to study abroad',
                'level' => 'ielts',
                'original_price' => 4500000,
                'price' => 3500000,
                'duration' => 2,
                'features' => json_encode([
                    '16 live sessions',
                    'IELTS materials'
                ]),
                'is_featured' => false,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TOEFL Preparation',
                'description' => 'Complete TOEFL preparation course. Master test strategies and improve your score in all sections.',
                'subtitle' => 'Achieve your best score',
                'suitable_for' => 'Students & Professionals',
                'level' => 'toefl',
                'original_price' => 4500000,
                'price' => 3500000,
                'duration' => 2,
                'features' => json_encode([
                    '16 live sessions',
                    'TOEFL materials'
                ]),
                'is_featured' => false,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($courses as $course) {
            \App\Models\Course::updateOrCreate(
                ['level' => $course['level']],
                $course
            );
        }
    }
}
