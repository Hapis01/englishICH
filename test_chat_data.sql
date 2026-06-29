-- TEST CHAT DATA
-- This creates a test conversation between Michael Chen (teacher) and Test Student
-- Run this SQL in phpMyAdmin or MySQL command line

-- Insert test conversation
INSERT INTO `conversations` (`id`, `student_id`, `teacher_id`, `last_message_at`, `created_at`, `updated_at`) VALUES
(1, 20, 3, '2026-06-01 10:30:00', '2026-06-01 09:00:00', '2026-06-01 10:30:00');

-- Insert test messages
INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `message`, `attachment`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 20, 'Hello Mr. Michael, I have a question about the Basic English course.', NULL, 1, '2026-06-01 09:00:00', '2026-06-01 09:00:00'),
(2, 1, 3, 'Hello! Of course, I\'m happy to help. What would you like to know?', NULL, 1, '2026-06-01 09:15:00', '2026-06-01 09:15:00'),
(3, 1, 20, 'I\'m having trouble with the grammar exercises in Chapter 3. Could you explain the difference between present perfect and past simple?', NULL, 1, '2026-06-01 09:20:00', '2026-06-01 09:20:00'),
(4, 1, 3, 'Great question! Present perfect is used for actions that happened at an unspecified time or have relevance to the present. Past simple is for completed actions at a specific time in the past. Let me give you some examples...', NULL, 1, '2026-06-01 09:25:00', '2026-06-01 09:25:00'),
(5, 1, 20, 'Thank you so much! That makes it much clearer now. I will practice more exercises.', NULL, 0, '2026-06-01 10:30:00', '2026-06-01 10:30:00');

-- Verify the data
SELECT 'Conversations created:' as info;
SELECT * FROM conversations;

SELECT 'Messages created:' as info;
SELECT m.id, m.conversation_id, u.name as sender, m.message, m.created_at 
FROM messages m 
JOIN users u ON m.sender_id = u.id 
ORDER BY m.created_at;
