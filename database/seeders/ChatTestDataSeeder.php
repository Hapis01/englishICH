<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChatTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if test conversation already exists
        $existingConversation = DB::table('conversations')
            ->where('student_id', 20)
            ->where('teacher_id', 3)
            ->first();

        if ($existingConversation) {
            $this->command->info('⚠️  Test conversation already exists. Skipping...');
            return;
        }

        // Create conversation between Michael Chen (teacher, id=3) and Test Student (student, id=20)
        $conversationId = DB::table('conversations')->insertGetId([
            'student_id' => 20,
            'teacher_id' => 3,
            'last_message_at' => Carbon::parse('2026-06-01 10:30:00'),
            'created_at' => Carbon::parse('2026-06-01 09:00:00'),
            'updated_at' => Carbon::parse('2026-06-01 10:30:00'),
        ]);

        // Insert test messages
        DB::table('messages')->insert([
            [
                'conversation_id' => $conversationId,
                'sender_id' => 20, // Test Student
                'message' => 'Hello Mr. Michael, I have a question about the Basic English course.',
                'attachment' => null,
                'is_read' => true,
                'created_at' => Carbon::parse('2026-06-01 09:00:00'),
                'updated_at' => Carbon::parse('2026-06-01 09:00:00'),
            ],
            [
                'conversation_id' => $conversationId,
                'sender_id' => 3, // Michael Chen
                'message' => 'Hello! Of course, I\'m happy to help. What would you like to know?',
                'attachment' => null,
                'is_read' => true,
                'created_at' => Carbon::parse('2026-06-01 09:15:00'),
                'updated_at' => Carbon::parse('2026-06-01 09:15:00'),
            ],
            [
                'conversation_id' => $conversationId,
                'sender_id' => 20, // Test Student
                'message' => 'I\'m having trouble with the grammar exercises in Chapter 3. Could you explain the difference between present perfect and past simple?',
                'attachment' => null,
                'is_read' => true,
                'created_at' => Carbon::parse('2026-06-01 09:20:00'),
                'updated_at' => Carbon::parse('2026-06-01 09:20:00'),
            ],
            [
                'conversation_id' => $conversationId,
                'sender_id' => 3, // Michael Chen
                'message' => 'Great question! Present perfect is used for actions that happened at an unspecified time or have relevance to the present. Past simple is for completed actions at a specific time in the past. Let me give you some examples...',
                'attachment' => null,
                'is_read' => true,
                'created_at' => Carbon::parse('2026-06-01 09:25:00'),
                'updated_at' => Carbon::parse('2026-06-01 09:25:00'),
            ],
            [
                'conversation_id' => $conversationId,
                'sender_id' => 20, // Test Student
                'message' => 'Thank you so much! That makes it much clearer now. I will practice more exercises.',
                'attachment' => null,
                'is_read' => false,
                'created_at' => Carbon::parse('2026-06-01 10:30:00'),
                'updated_at' => Carbon::parse('2026-06-01 10:30:00'),
            ],
        ]);

        $this->command->info('✅ Test chat data created successfully!');
        $this->command->info('📝 Conversation between Michael Chen (teacher) and Test Student');
        $this->command->info('💬 5 test messages inserted');
    }
}
