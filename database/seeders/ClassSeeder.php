<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            [
                'course_id' => 1, // Basic English
                'teacher_id' => 2, // Sarah Johnson
                'name' => 'Basic English - Morning Class',
                'schedule' => 'Monday & Wednesday 10:00-12:00',
                'max_students' => 20,
                'current_students' => 15,
                'start_date' => Carbon::parse('2026-06-01'),
                'end_date' => Carbon::parse('2026-09-01'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 2, // Intermediate English
                'teacher_id' => 3, // Michael Chen
                'name' => 'Intermediate English - Afternoon Class',
                'schedule' => 'Tuesday & Thursday 14:00-16:00',
                'max_students' => 18,
                'current_students' => 12,
                'start_date' => Carbon::parse('2026-06-15'),
                'end_date' => Carbon::parse('2026-10-15'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 3, // Advanced English
                'teacher_id' => 4, // Emily Rodriguez
                'name' => 'Advanced English - Evening Class',
                'schedule' => 'Monday & Wednesday 18:00-20:00',
                'max_students' => 15,
                'current_students' => 10,
                'start_date' => Carbon::parse('2026-07-01'),
                'end_date' => Carbon::parse('2026-11-01'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 4, // Business English
                'teacher_id' => 5, // David Williams
                'name' => 'Business English - Weekend Class',
                'schedule' => 'Saturday 09:00-12:00',
                'max_students' => 15,
                'current_students' => 8,
                'start_date' => Carbon::parse('2026-06-07'),
                'end_date' => Carbon::parse('2026-09-07'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 5, // IELTS Preparation
                'teacher_id' => 6, // Jessica Taylor
                'name' => 'IELTS Preparation - Intensive Class',
                'schedule' => 'Monday to Friday 16:00-18:00',
                'max_students' => 12,
                'current_students' => 10,
                'start_date' => Carbon::parse('2026-06-10'),
                'end_date' => Carbon::parse('2026-08-10'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 6, // TOEFL Preparation
                'teacher_id' => 2, // Sarah Johnson
                'name' => 'TOEFL Preparation - Fast Track',
                'schedule' => 'Tuesday & Thursday 18:00-20:00',
                'max_students' => 12,
                'current_students' => 9,
                'start_date' => Carbon::parse('2026-07-15'),
                'end_date' => Carbon::parse('2026-09-15'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 1, // Basic English
                'teacher_id' => 3, // Michael Chen
                'name' => 'Basic English - Evening Class',
                'schedule' => 'Tuesday & Thursday 18:00-20:00',
                'max_students' => 20,
                'current_students' => 18,
                'start_date' => Carbon::parse('2026-06-05'),
                'end_date' => Carbon::parse('2026-09-05'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 2, // Intermediate English
                'teacher_id' => 4, // Emily Rodriguez
                'name' => 'Intermediate English - Weekend Class',
                'schedule' => 'Sunday 10:00-13:00',
                'max_students' => 18,
                'current_students' => 14,
                'start_date' => Carbon::parse('2026-06-08'),
                'end_date' => Carbon::parse('2026-10-08'),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('classes')->insert($classes);
    }
}
