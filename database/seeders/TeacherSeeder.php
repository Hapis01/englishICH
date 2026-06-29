<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\ClassMaterial;
use App\Models\StudentGrade;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo teacher
        $teacher = User::create([
            'name' => 'Michael Chen',
            'email' => 'michael.chen@ich.edu',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'phone' => '+62 812-3456-7890',
            'address' => 'Jl. Pendidikan No. 123, Medan',
        ]);

        // Get existing classes (assuming ClassSeeder has run)
        $classes = SchoolClass::take(3)->get();

        if ($classes->count() > 0) {
            // Assign teacher to classes
            foreach ($classes as $class) {
                $class->update(['teacher_id' => $teacher->id]);
            }

            // Create sample materials for each class
            foreach ($classes as $class) {
                ClassMaterial::create([
                    'class_id' => $class->id,
                    'teacher_id' => $teacher->id,
                    'title' => 'Introduction to English Grammar',
                    'description' => 'Basic grammar rules and exercises',
                    'file_path' => 'materials/grammar-basics.pdf',
                    'file_type' => 'pdf',
                    'file_size' => 1024000,
                    'uploaded_at' => now()->subDays(10),
                ]);

                ClassMaterial::create([
                    'class_id' => $class->id,
                    'teacher_id' => $teacher->id,
                    'title' => 'Vocabulary Building Exercises',
                    'description' => 'Common English words and phrases',
                    'file_path' => 'materials/vocabulary-exercises.docx',
                    'file_type' => 'docx',
                    'file_size' => 512000,
                    'uploaded_at' => now()->subDays(5),
                ]);

                ClassMaterial::create([
                    'class_id' => $class->id,
                    'teacher_id' => $teacher->id,
                    'title' => 'Speaking Practice Presentation',
                    'description' => 'Tips for improving speaking skills',
                    'file_path' => 'materials/speaking-practice.pptx',
                    'file_type' => 'pptx',
                    'file_size' => 2048000,
                    'uploaded_at' => now()->subDays(2),
                ]);
            }

            // Get students from the classes
            $students = User::where('role', 'student')->take(10)->get();

            if ($students->count() > 0) {
                // Create sample grades for students
                foreach ($classes as $class) {
                    foreach ($students->take(5) as $student) {
                        StudentGrade::create([
                            'student_id' => $student->id,
                            'class_id' => $class->id,
                            'teacher_id' => $teacher->id,
                            'listening' => rand(70, 95),
                            'speaking' => rand(70, 95),
                            'reading' => rand(70, 95),
                            'writing' => rand(70, 95),
                            'attendance' => rand(80, 100),
                            'notes' => 'Good progress. Keep up the excellent work!',
                            'published' => true,
                            'grade_date' => now()->subDays(rand(1, 30)),
                        ]);
                    }
                }

                // Create sample chat conversations
                foreach ($students->take(5) as $student) {
                    $conversation = Conversation::create([
                        'student_id' => $student->id,
                        'teacher_id' => $teacher->id,
                        'last_message_at' => now()->subHours(rand(1, 48)),
                    ]);

                    // Create sample messages
                    Message::create([
                        'conversation_id' => $conversation->id,
                        'sender_id' => $student->id,
                        'message' => 'Hello Mr. Chen, I have a question about the homework.',
                        'is_read' => true,
                        'created_at' => now()->subHours(rand(24, 48)),
                    ]);

                    Message::create([
                        'conversation_id' => $conversation->id,
                        'sender_id' => $teacher->id,
                        'message' => 'Hi! Sure, what would you like to know?',
                        'is_read' => true,
                        'created_at' => now()->subHours(rand(23, 47)),
                    ]);

                    Message::create([
                        'conversation_id' => $conversation->id,
                        'sender_id' => $student->id,
                        'message' => 'I\'m having trouble with the grammar exercises on page 15.',
                        'is_read' => true,
                        'created_at' => now()->subHours(rand(22, 46)),
                    ]);

                    Message::create([
                        'conversation_id' => $conversation->id,
                        'sender_id' => $teacher->id,
                        'message' => 'No problem! Let me explain. The key is to understand the difference between present perfect and past simple tenses.',
                        'is_read' => rand(0, 1) == 1,
                        'created_at' => now()->subHours(rand(1, 24)),
                    ]);
                }
            }
        }

        $this->command->info('✅ Teacher seeder completed successfully!');
        $this->command->info('📧 Teacher Email: michael.chen@ich.edu');
        $this->command->info('🔑 Password: password');
    }
}
