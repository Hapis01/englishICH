-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jun 2026 pada 14.45
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ich_english`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `assessments`
--

CREATE TABLE `assessments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `week_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('Assignment','Quiz','Mid Test','Final Test','Speaking Test','Speaking','Reading','Listening','Writing','Custom Assessment') NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `is_open` tinyint(1) NOT NULL DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `assessments`
--

INSERT INTO `assessments` (`id`, `class_id`, `teacher_id`, `week_id`, `title`, `type`, `description`, `due_date`, `due_time`, `instructions`, `attachment`, `is_published`, `is_open`, `start_date`, `start_time`, `created_at`, `updated_at`) VALUES
(3, 3, 2, NULL, 'Test', 'Quiz', NULL, NULL, NULL, NULL, NULL, 1, 0, '2026-06-30', NULL, '2026-06-27 21:16:56', '2026-06-27 21:16:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `assessment_scores`
--

CREATE TABLE `assessment_scores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `score` decimal(5,2) DEFAULT NULL,
  `maximum_score` decimal(5,2) NOT NULL DEFAULT 100.00,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `graded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `graded_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attendance_session_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Present','Absent','Late','Excused') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `attendances`
--

INSERT INTO `attendances` (`id`, `attendance_session_id`, `student_id`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(3, 8, 3, 'Present', 'Self-marked by student', '2026-06-27 21:21:03', '2026-06-27 21:21:03'),
(4, 9, 3, 'Absent', 'Self-marked by student', '2026-06-27 21:21:19', '2026-06-27 21:21:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `attendance_sessions`
--

CREATE TABLE `attendance_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `session_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `is_open` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `platform` enum('Google Meet','Zoom','Offline') NOT NULL DEFAULT 'Offline',
  `meeting_link` varchar(255) DEFAULT NULL,
  `meeting_status` enum('scheduled','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `teacher_time_in` time DEFAULT NULL,
  `teacher_time_out` time DEFAULT NULL,
  `teacher_attendance_status` enum('Present','Late','Absent','Invalid') NOT NULL DEFAULT 'Absent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `attendance_sessions`
--

INSERT INTO `attendance_sessions` (`id`, `class_id`, `teacher_id`, `title`, `session_date`, `start_time`, `end_time`, `is_published`, `is_open`, `created_at`, `updated_at`, `platform`, `meeting_link`, `meeting_status`, `teacher_time_in`, `teacher_time_out`, `teacher_attendance_status`) VALUES
(8, 3, 2, 'Week 1', '2026-06-28', '04:20:00', '04:22:00', 0, 0, '2026-06-27 21:20:43', '2026-06-27 21:20:43', 'Offline', NULL, 'scheduled', NULL, NULL, 'Absent'),
(9, 3, 2, 'Week 2', '2026-06-28', '04:20:00', '04:23:00', 0, 0, '2026-06-27 21:20:57', '2026-06-27 21:20:57', 'Offline', NULL, 'scheduled', NULL, NULL, 'Absent');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `learning_method` enum('online','offline') NOT NULL DEFAULT 'offline',
  `schedule` varchar(255) NOT NULL COMMENT 'Day and time of class',
  `max_students` int(11) NOT NULL DEFAULT 20,
  `current_students` int(11) NOT NULL DEFAULT 0,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `gmeet_link` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','completed') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `teacher_attendance_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`teacher_attendance_days`)),
  `teacher_start_time` time DEFAULT NULL,
  `teacher_end_time` time DEFAULT NULL,
  `teacher_schedule_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `classes`
--

INSERT INTO `classes` (`id`, `course_id`, `teacher_id`, `name`, `learning_method`, `schedule`, `max_students`, `current_students`, `start_date`, `end_date`, `gmeet_link`, `status`, `created_at`, `updated_at`, `teacher_attendance_days`, `teacher_start_time`, `teacher_end_time`, `teacher_schedule_type`) VALUES
(1, 1, 2, 'Basic Plan - Morning Class', 'offline', 'Monday & Wednesday 09:00-11:00', 20, 0, '2026-06-28', '2026-09-28', NULL, 'active', '2026-06-27 20:51:44', '2026-06-27 20:51:44', NULL, NULL, NULL, NULL),
(2, 1, 2, 'Basic Plan - Afternoon Class', 'online', 'Tuesday & Thursday 14:00-16:00', 20, 0, '2026-06-28', '2026-09-28', NULL, 'active', '2026-06-27 20:51:44', '2026-06-27 20:51:44', NULL, NULL, NULL, NULL),
(3, 2, 2, 'Intermediate Plan - Morning Class', 'offline', 'Monday & Wednesday 09:00-11:00', 20, 0, '2026-06-28', '2026-09-28', NULL, 'active', '2026-06-27 20:51:44', '2026-06-27 20:51:44', NULL, NULL, NULL, NULL),
(4, 2, 2, 'Intermediate Plan - Afternoon Class', 'online', 'Tuesday & Thursday 14:00-16:00', 20, 0, '2026-06-28', '2026-09-28', NULL, 'active', '2026-06-27 20:51:44', '2026-06-27 20:51:44', NULL, NULL, NULL, NULL),
(5, 3, 2, 'Advanced Plan - Morning Class', 'offline', 'Monday & Wednesday 09:00-11:00', 20, 0, '2026-06-28', '2026-09-28', NULL, 'active', '2026-06-27 20:51:44', '2026-06-27 20:51:44', NULL, NULL, NULL, NULL),
(6, 3, 2, 'Advanced Plan - Afternoon Class', 'online', 'Tuesday & Thursday 14:00-16:00', 20, 0, '2026-06-28', '2026-09-28', NULL, 'active', '2026-06-27 20:51:44', '2026-06-27 20:51:44', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `class_materials`
--

CREATE TABLE `class_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `week_id` bigint(20) UNSIGNED DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `suitable_for` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `level` enum('basic','intermediate','advanced','business','ielts','toefl') NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `original_price` decimal(15,2) DEFAULT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration in months',
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `courses`
--

INSERT INTO `courses` (`id`, `name`, `subtitle`, `suitable_for`, `description`, `level`, `price`, `original_price`, `duration`, `features`, `is_featured`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Basic', 'Perfect for beginners', 'Beginners & Casual Learners', 'Build a strong foundation in English with our Basic package. Ideal for those starting from scratch, focusing on essential vocabulary, basic grammar, and simple conversations.', 'basic', 1999000.00, 2500000.00, 3, '[\"12 live sessions\",\"Basic learning materials\",\"Certificate of completion\",\"Email support\"]', 0, 'active', '2026-06-27 20:43:10', '2026-06-29 12:29:04'),
(2, 'Intermediate', 'Best value for serious learners', 'Intermediate Learners & Professionals', 'Take your English to the next level. This package is designed to improve fluency, expand vocabulary, and build confidence in both casual and professional settings.', 'intermediate', 3499000.00, 4500000.00, 3, '[\"24 live sessions\",\"Complete learning materials\",\"Certificate of completion\",\"Priority support\",\"Access to learning portal\",\"Monthly progress report\"]', 1, 'active', '2026-06-27 20:43:10', '2026-06-27 20:43:10'),
(3, 'Advanced', 'Ultimate learning experience', 'Advanced Learners & Career Focus', 'Master the English language with our Advanced package. Focus on complex grammar, advanced vocabulary, professional communication, and accent reduction.', 'advanced', 5999000.00, 7500000.00, 3, '[\"36 live sessions\",\"Advanced learning materials\",\"Certificate of completion\",\"24\\/7 priority support\",\"Full portal access\",\"Weekly progress report\",\"1-on-1 mentoring sessions\",\"Exclusive workshops\"]', 0, 'active', '2026-06-27 20:43:10', '2026-06-27 20:43:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `attachment`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 'Halo, selamat pagi pak', NULL, 1, '2026-06-27 21:05:50', '2026-06-27 21:05:54'),
(2, 2, 3, 'Iya selamat pagi dek', NULL, 1, '2026-06-27 21:05:59', '2026-06-27 21:06:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_22_041445_create_courses_table', 1),
(5, '2026_05_22_041455_create_classes_table', 1),
(6, '2026_05_22_041502_create_payments_table', 1),
(7, '2026_05_25_100001_create_class_materials_table', 1),
(8, '2026_05_25_100002_create_student_grades_table', 1),
(9, '2026_05_25_100003_create_conversations_table', 1),
(10, '2026_05_25_100004_create_messages_table', 1),
(11, '2026_05_29_100001_create_certificates_table', 1),
(12, '2026_05_29_100002_create_notification_preferences_table', 1),
(13, '2026_05_31_100001_enhance_payments_table', 1),
(14, '2026_06_01_000001_make_class_id_nullable_in_payments', 1),
(15, '2026_06_01_000002_add_payment_type_and_notes_to_payments', 1),
(16, '2026_06_01_100001_create_chat_requests_table', 1),
(17, '2026_06_01_183430_add_security_questions_to_users_table', 1),
(18, '2026_06_02_000000_add_security_fields_to_users_table', 1),
(19, '2026_06_05_023618_refactor_users_table_for_task', 1),
(20, '2026_06_05_023623_refactor_payments_table_for_task', 1),
(21, '2026_06_05_023625_create_payment_installments_table', 1),
(22, '2026_06_05_024019_add_proof_to_installments_table', 1),
(23, '2026_06_05_025808_create_notifications_table', 1),
(24, '2026_06_05_032759_add_new_fields_to_payments_table', 1),
(25, '2026_06_05_042709_drop_payment_method_from_payments_table', 1),
(26, '2026_06_05_053000_add_learning_method_to_classes_table', 1),
(27, '2026_06_06_092357_add_gmeet_link_to_classes_table', 1),
(28, '2026_06_06_100949_create_academic_management_tables', 1),
(29, '2026_06_07_142501_create_user_logs_table', 1),
(30, '2026_06_08_150000_create_weekly_materials_and_assignments_system', 1),
(31, '2026_06_08_181750_add_submission_fields_to_assessments_tables', 1),
(32, '2026_06_08_184540_add_open_logic_to_assignments_table', 1),
(33, '2026_06_08_185739_add_open_logic_to_assessments_table', 1),
(34, '2026_06_08_191755_make_score_nullable_on_assessment_scores_table', 1),
(35, '2026_06_08_194813_add_grading_fields_to_assessment_scores_table', 1),
(36, '2026_06_08_194825_create_teacher_student_notes_table', 1),
(37, '2026_06_08_213333_update_assessments_type_enum', 1),
(38, '2026_06_14_200000_add_grammar_to_student_grades_table', 1),
(39, '2026_06_14_200001_create_teacher_attendance_tables', 1),
(40, '2026_06_17_000001_cleanup_database_drop_unused_and_merge_assignments', 1),
(41, '2026_06_17_021143_optimize_database_structure', 1),
(42, '2026_06_19_161001_add_owner_role_to_users_table', 1),
(43, '2026_06_28_025410_add_pricing_fields_to_courses_table', 1),
(44, '2026_06_28_033119_change_price_columns_on_courses_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('feebc7f9-2fed-4655-b925-97f0fa7e42be', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 3, '{\"title\":\"Installment Approved\",\"message\":\"Cicilan ke-1 sebesar Rp 874.750 telah disetujui. Progress: 1\\/4 cicilan, Rp 874.750 \\/ Rp 3.499.000.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-27 20:55:14', '2026-06-27 20:55:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `payment_type` varchar(255) DEFAULT NULL,
  `installment_total` decimal(10,2) DEFAULT NULL,
  `installment_paid` decimal(10,2) DEFAULT NULL,
  `installment_remaining` decimal(10,2) DEFAULT NULL,
  `verification_status` enum('pending_verification','approved','rejected','none') NOT NULL DEFAULT 'none',
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `verification_date` timestamp NULL DEFAULT NULL,
  `verified_proof_of_payment` varchar(255) DEFAULT NULL,
  `payment_date` date NOT NULL,
  `proof_of_payment` varchar(255) DEFAULT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `payment_notes` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `next_due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `class_id`, `amount`, `payment_status`, `payment_type`, `installment_total`, `installment_paid`, `installment_remaining`, `verification_status`, `verified_by`, `verification_date`, `verified_proof_of_payment`, `payment_date`, `proof_of_payment`, `proof_image`, `notes`, `title`, `payment_notes`, `description`, `due_date`, `next_due_date`, `created_at`, `updated_at`) VALUES
(1, 3, 3, 3499000.00, 'paid', 'installment', 3499000.00, 874750.00, 2624250.00, 'none', NULL, NULL, NULL, '2026-06-28', 'images/payment-proofs/payment_1782593697_WhatsApp_Image_2026-06-27_at_02.50.53.jpeg', 'images/payment-proofs/payment_1782593697_WhatsApp_Image_2026-06-27_at_02.50.53.jpeg', NULL, 'Pembayaran Cicilan - Intermediate', 'Pembayaran Cicilan', 'Pembayaran cicilan 4x untuk kelas Intermediate Plan - Morning Class', NULL, '2026-08-05', '2026-06-27 20:54:50', '2026-06-27 20:55:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_installments`
--

CREATE TABLE `payment_installments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `installment_number` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_date` date NOT NULL,
  `payment_date` date DEFAULT NULL,
  `status` enum('pending','paid','overdue') NOT NULL DEFAULT 'pending',
  `proof_of_payment` varchar(255) DEFAULT NULL,
  `verification_status` enum('none','pending_verification','approved','rejected') NOT NULL DEFAULT 'none',
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `verification_date` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payment_installments`
--

INSERT INTO `payment_installments` (`id`, `payment_id`, `installment_number`, `amount`, `due_date`, `payment_date`, `status`, `proof_of_payment`, `verification_status`, `verified_by`, `verification_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 874750.00, '2026-07-05', '2026-06-28', 'paid', 'images/payment-proofs/payment_1782593697_WhatsApp_Image_2026-06-27_at_02.50.53.jpeg', 'approved', 1, '2026-06-27 20:55:12', NULL, '2026-06-27 20:54:50', '2026-06-27 20:55:12'),
(2, 1, 2, 874750.00, '2026-08-05', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-27 20:54:50', '2026-06-27 20:54:50'),
(3, 1, 3, 874750.00, '2026-09-05', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-27 20:54:50', '2026-06-27 20:54:50'),
(4, 1, 4, 874750.00, '2026-10-05', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-27 20:54:50', '2026-06-27 20:54:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('JpMRjotnimCRdEdvTyr3nLn2njsMweBp4PLPEJQj', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMHdHSEFwcUY4ZkpIYnVOYzQ5b0Rla2dIMEJ5ZGhpSEZON2c5QXBwVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdHVkZW50L3NlbGVjdC1jbGFzcyI7czo1OiJyb3V0ZSI7czoyMDoic3R1ZGVudC5zZWxlY3QuY2xhc3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1782736191),
('UGqJcMDZ4exWgHWstQS55qXcitVkHUH17iIT76Vv', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid05aVjRkRGhJNFcxamJtY2hhQVVjcnBCRTRhWVNuSmJNMVdRVkJ4TyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jZXJ0aWZpY2F0ZXMiO3M6NToicm91dGUiO3M6MTg6ImFkbWluLmNlcnRpZmljYXRlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1782737082);

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_grades`
--

CREATE TABLE `student_grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `listening` decimal(5,2) DEFAULT NULL,
  `speaking` decimal(5,2) DEFAULT NULL,
  `reading` decimal(5,2) DEFAULT NULL,
  `writing` decimal(5,2) DEFAULT NULL,
  `grammar` decimal(5,2) DEFAULT NULL,
  `attendance` decimal(5,2) DEFAULT NULL,
  `average` decimal(5,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `grade_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `certificate_number` varchar(255) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `qr_code` text DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `certificate_status` enum('active','revoked') NOT NULL DEFAULT 'active',
  `teacher_notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`teacher_notes`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `student_grades`
--

INSERT INTO `student_grades` (`id`, `student_id`, `class_id`, `teacher_id`, `listening`, `speaking`, `reading`, `writing`, `grammar`, `attendance`, `average`, `notes`, `published`, `grade_date`, `created_at`, `updated_at`, `certificate_number`, `issue_date`, `qr_code`, `verification_token`, `certificate_status`, `teacher_notes`) VALUES
(1, 3, 3, 2, 90.00, 80.00, 80.00, 70.00, 80.00, 50.00, 80.00, NULL, 1, '2026-06-28', '2026-06-27 21:20:17', '2026-06-29 12:44:41', 'CERT-202606-RYCGFX', '2026-06-29', 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2ZmZmZmZiIvPjxnIHRyYW5zZm9ybT0ic2NhbGUoMy4wMykiPjxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsMCkiPjxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTggMEw4IDFMOSAxTDkgMkw4IDJMOCA1TDkgNUw5IDRMMTEgNEwxMSA1TDEwIDVMMTAgMTBMOCAxMEw4IDlMOSA5TDkgOEw4IDhMOCA5TDcgOUw3IDhMNiA4TDYgOUw3IDlMNyAxMEw2IDEwTDYgMTFMNSAxMUw1IDEwTDMgMTBMMyA5TDQgOUw0IDhMMCA4TDAgMTBMMSAxMEwxIDExTDIgMTFMMiAxM0wwIDEzTDAgMTVMMSAxNUwxIDE0TDIgMTRMMiAxNkwzIDE2TDMgMThMNiAxOEw2IDE5TDggMTlMOCAyMUw3IDIxTDcgMjBMNiAyMEw2IDIxTDQgMjFMNCAxOUwzIDE5TDMgMjFMMiAyMUwyIDE5TDEgMTlMMSAxOEwyIDE4TDIgMTdMMCAxN0wwIDIyTDEgMjJMMSAyMUwyIDIxTDIgMjNMMSAyM0wxIDI0TDAgMjRMMCAyNUwxIDI1TDEgMjRMMiAyNEwyIDI1TDMgMjVMMyAyNEw1IDI0TDUgMjVMNyAyNUw3IDI0TDUgMjRMNSAyMkw2IDIyTDYgMjNMNyAyM0w3IDIyTDggMjJMOCAyNkw5IDI2TDkgMjVMMTAgMjVMMTAgMjdMMTEgMjdMMTEgMjhMMTIgMjhMMTIgMjlMMTAgMjlMMTAgMzBMMTMgMzBMMTMgMzFMMTIgMzFMMTIgMzNMMTMgMzNMMTMgMzFMMTQgMzFMMTQgMzJMMTUgMzJMMTUgMzNMMTkgMzNMMTkgMzFMMTcgMzFMMTcgMzBMMTYgMzBMMTYgMjlMMTkgMjlMMTkgMjhMMjAgMjhMMjAgMzJMMjEgMzJMMjEgMzNMMjIgMzNMMjIgMzJMMjEgMzJMMjEgMjlMMjIgMjlMMjIgMzFMMjMgMzFMMjMgMjlMMjUgMjlMMjUgMzBMMjQgMzBMMjQgMzJMMjUgMzJMMjUgMzNMMjYgMzNMMjYgMzJMMjcgMzJMMjcgMzNMMjggMzNMMjggMzJMMzAgMzJMMzAgMzNMMzEgMzNMMzEgMzJMMzAgMzJMMzAgMjlMMzEgMjlMMzEgMzFMMzIgMzFMMzIgMzJMMzMgMzJMMzMgMzFMMzIgMzFMMzIgMjlMMzEgMjlMMzEgMjhMMzIgMjhMMzIgMjdMMzEgMjdMMzEgMjZMMzAgMjZMMzAgMjRMMjkgMjRMMjkgMjNMMjggMjNMMjggMjRMMjYgMjRMMjYgMjNMMjcgMjNMMjcgMjJMMjggMjJMMjggMjFMMjYgMjFMMjYgMjBMMjkgMjBMMjkgMjFMMzAgMjFMMzAgMjJMMzEgMjJMMzEgMjRMMzIgMjRMMzIgMjVMMzMgMjVMMzMgMjRMMzIgMjRMMzIgMjNMMzMgMjNMMzMgMjFMMzEgMjFMMzEgMjBMMzAgMjBMMzAgMThMMzEgMThMMzEgMTlMMzIgMTlMMzIgMjBMMzMgMjBMMzMgMTlMMzIgMTlMMzIgMThMMzMgMThMMzMgMTZMMzEgMTZMMzEgMTRMMzIgMTRMMzIgMTNMMzAgMTNMMzAgMTRMMjggMTRMMjggMTVMMjcgMTVMMjcgMTRMMjYgMTRMMjYgMTNMMjQgMTNMMjQgMTVMMjYgMTVMMjYgMjBMMjUgMjBMMjUgMTdMMjQgMTdMMjQgMTZMMjMgMTZMMjMgMTVMMjEgMTVMMjEgMTNMMjAgMTNMMjAgMTJMMjEgMTJMMjEgMTFMMjIgMTFMMjIgOEwyMyA4TDIzIDEyTDIyIDEyTDIyIDEzTDIzIDEzTDIzIDEyTDI0IDEyTDI0IDdMMjUgN0wyNSAyTDI0IDJMMjQgMEwyMiAwTDIyIDFMMjMgMUwyMyAzTDI0IDNMMjQgN0wyMyA3TDIzIDZMMjIgNkwyMiA4TDIxIDhMMjEgNUwyMiA1TDIyIDRMMjEgNEwyMSA1TDIwIDVMMjAgNEwxOCA0TDE4IDNMMTkgM0wxOSAxTDIwIDFMMjAgM0wyMSAzTDIxIDBMMTkgMEwxOSAxTDE3IDFMMTcgMEwxNSAwTDE1IDFMMTQgMUwxNCAwTDEyIDBMMTIgMUwxMSAxTDExIDBMMTAgMEwxMCAxTDkgMUw5IDBaTTEzIDFMMTMgMkwxMSAyTDExIDRMMTIgNEwxMiAzTDEzIDNMMTMgMkwxNCAyTDE0IDFaTTE1IDFMMTUgMkwxNiAyTDE2IDFaTTE3IDJMMTcgM0wxNSAzTDE1IDdMMTYgN0wxNiA0TDE3IDRMMTcgM0wxOCAzTDE4IDJaTTEzIDRMMTMgNUwxMiA1TDEyIDZMMTEgNkwxMSA4TDEyIDhMMTIgOUwxMSA5TDExIDEwTDEyIDEwTDEyIDlMMTMgOUwxMyAxMUwxMSAxMUwxMSAxMkwxMyAxMkwxMyAxNkwxMSAxNkwxMSAxNUwxMiAxNUwxMiAxM0w2IDEzTDYgMTJMNyAxMkw3IDExTDggMTFMOCAxMkw5IDEyTDkgMTFMOCAxMUw4IDEwTDcgMTBMNyAxMUw2IDExTDYgMTJMNCAxMkw0IDExTDMgMTFMMyAxNUw0IDE1TDQgMTdMNiAxN0w2IDE4TDggMThMOCAxN0wxMSAxN0wxMSAxOEw5IDE4TDkgMTlMMTAgMTlMMTAgMjJMOSAyMkw5IDIxTDggMjFMOCAyMkw5IDIyTDkgMjNMMTAgMjNMMTAgMjJMMTIgMjJMMTIgMjNMMTEgMjNMMTEgMjRMMTAgMjRMMTAgMjVMMTEgMjVMMTEgMjdMMTMgMjdMMTMgMzBMMTQgMzBMMTQgMzFMMTUgMzFMMTUgMzJMMTYgMzJMMTYgMzFMMTUgMzFMMTUgMzBMMTQgMzBMMTQgMjlMMTUgMjlMMTUgMjdMMTYgMjdMMTYgMjhMMTkgMjhMMTkgMjZMMTcgMjZMMTcgMjdMMTYgMjdMMTYgMjZMMTUgMjZMMTUgMjVMMTMgMjVMMTMgMjNMMTQgMjNMMTQgMjRMMTYgMjRMMTYgMjVMMjAgMjVMMjAgMjZMMjEgMjZMMjEgMjdMMjAgMjdMMjAgMjhMMjEgMjhMMjEgMjdMMjIgMjdMMjIgMjZMMjMgMjZMMjMgMjVMMjIgMjVMMjIgMjJMMTkgMjJMMTkgMjNMMjAgMjNMMjAgMjRMMTggMjRMMTggMjBMMjIgMjBMMjIgMjFMMjQgMjFMMjQgMjJMMjUgMjJMMjUgMjNMMjYgMjNMMjYgMjJMMjUgMjJMMjUgMjFMMjQgMjFMMjQgMThMMjMgMThMMjMgMTdMMjEgMTdMMjEgMThMMjAgMThMMjAgMTVMMTkgMTVMMTkgMThMMTggMThMMTggMTVMMTcgMTVMMTcgMTdMMTYgMTdMMTYgMTZMMTUgMTZMMTUgMTVMMTYgMTVMMTYgMTRMMTcgMTRMMTcgMTNMMTkgMTNMMTkgMTJMMjAgMTJMMjAgMTFMMjEgMTFMMjEgMTBMMTkgMTBMMTkgMTJMMTggMTJMMTggOUwxNyA5TDE3IDhMMTUgOEwxNSA5TDEzIDlMMTMgOEwxNCA4TDE0IDZMMTMgNkwxMyA1TDE0IDVMMTQgNFpNMTcgNUwxNyA3TDE4IDdMMTggOEwxOSA4TDE5IDlMMjAgOUwyMCA2TDE5IDZMMTkgN0wxOCA3TDE4IDVaTTggNkw4IDdMOSA3TDkgNlpNMTIgNkwxMiA4TDEzIDhMMTMgNlpNMjUgOEwyNSAxMEwyNiAxMEwyNiAxMUwyNyAxMUwyNyAxM0wyOSAxM0wyOSAxMkwyOCAxMkwyOCAxMUwzMSAxMUwzMSAxMkwzMiAxMkwzMiAxMUwzMyAxMUwzMyA4TDMyIDhMMzIgOUwzMSA5TDMxIDhMMjggOEwyOCA5TDI2IDlMMjYgOFpNMSA5TDEgMTBMMiAxMEwyIDlaTTE1IDlMMTUgMTBMMTQgMTBMMTQgMTFMMTMgMTFMMTMgMTJMMTQgMTJMMTQgMTVMMTUgMTVMMTUgMTRMMTYgMTRMMTYgMTNMMTcgMTNMMTcgOVpNMjggOUwyOCAxMEwyNyAxMEwyNyAxMUwyOCAxMUwyOCAxMEwzMSAxMEwzMSAxMUwzMiAxMUwzMiAxMEwzMSAxMEwzMSA5Wk0xNSAxMEwxNSAxMkwxNiAxMkwxNiAxMFpNNCAxNEw0IDE1TDUgMTVMNSAxNkw2IDE2TDYgMTdMNyAxN0w3IDE2TDYgMTZMNiAxNUw4IDE1TDggMTZMMTAgMTZMMTAgMTRMNiAxNEw2IDE1TDUgMTVMNSAxNFpNMjggMTVMMjggMTZMMzAgMTZMMzAgMTVaTTEyIDE3TDEyIDE4TDEzIDE4TDEzIDE5TDExIDE5TDExIDIwTDEyIDIwTDEyIDIxTDEzIDIxTDEzIDE5TDE0IDE5TDE0IDE4TDE1IDE4TDE1IDE5TDE3IDE5TDE3IDIwTDE1IDIwTDE1IDIxTDE0IDIxTDE0IDIyTDE3IDIyTDE3IDIwTDE4IDIwTDE4IDE5TDE3IDE5TDE3IDE4TDE1IDE4TDE1IDE3Wk0yNyAxN0wyNyAxOEwyOCAxOEwyOCAxN1pNMzEgMTdMMzEgMThMMzIgMThMMzIgMTdaTTMgMjFMMyAyM0w0IDIzTDQgMjFaTTYgMjFMNiAyMkw3IDIyTDcgMjFaTTExIDI0TDExIDI1TDEyIDI1TDEyIDI2TDEzIDI2TDEzIDI3TDE0IDI3TDE0IDI2TDEzIDI2TDEzIDI1TDEyIDI1TDEyIDI0Wk0yMSAyNUwyMSAyNkwyMiAyNkwyMiAyNVpNMjUgMjVMMjUgMjhMMjggMjhMMjggMjVaTTI2IDI2TDI2IDI3TDI3IDI3TDI3IDI2Wk0yOSAyNkwyOSAyOUwyOCAyOUwyOCAzMUwyNyAzMUwyNyAzMkwyOCAzMkwyOCAzMUwyOSAzMUwyOSAyOUwzMCAyOUwzMCAyNlpNMjMgMjdMMjMgMjhMMjQgMjhMMjQgMjdaTTggMjlMOCAzM0wxMSAzM0wxMSAzMUwxMCAzMUwxMCAzMkw5IDMyTDkgMjlaTTI2IDI5TDI2IDMwTDI3IDMwTDI3IDI5Wk0yNSAzMUwyNSAzMkwyNiAzMkwyNiAzMVpNMCAwTDAgN0w3IDdMNyAwWk0xIDFMMSA2TDYgNkw2IDFaTTIgMkwyIDVMNSA1TDUgMlpNMjYgMEwyNiA3TDMzIDdMMzMgMFpNMjcgMUwyNyA2TDMyIDZMMzIgMVpNMjggMkwyOCA1TDMxIDVMMzEgMlpNMCAyNkwwIDMzTDcgMzNMNyAyNlpNMSAyN0wxIDMyTDYgMzJMNiAyN1pNMiAyOEwyIDMxTDUgMzFMNSAyOFoiIGZpbGw9IiMwMDAwMDAiLz48L2c+PC9nPjwvc3ZnPgo=', 'yfutgVtGQEmxdIT1VKIdAFS4pZ7zxUKi', 'active', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `security_question` varchar(255) DEFAULT NULL,
  `security_answer` varchar(255) DEFAULT NULL,
  `role` enum('admin','owner','teacher','student') DEFAULT 'student',
  `whatsapp` varchar(255) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `student_status` enum('CLASS_NOT_SELECTED','AWAITING_PAYMENT','PAYMENT_VERIFICATION','ACTIVE','PAYMENT_OVERDUE','SUSPENDED','INACTIVE') NOT NULL DEFAULT 'CLASS_NOT_SELECTED',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `class_reminder` tinyint(1) NOT NULL DEFAULT 1,
  `grade_notification` tinyint(1) NOT NULL DEFAULT 1,
  `chat_notification` tinyint(1) NOT NULL DEFAULT 1,
  `material_notification` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `security_question`, `security_answer`, `role`, `whatsapp`, `profile_photo`, `status`, `student_status`, `remember_token`, `created_at`, `updated_at`, `class_reminder`, `grade_notification`, `chat_notification`, `material_notification`) VALUES
(1, 'Admin ICH', 'admin@ich.com', NULL, '$2y$12$le1KXgbBib4nDerl73d.A.Y051D.mhQ6msE3OeIMwyJslV0EYlMW2', NULL, NULL, 'admin', '+628000000000', NULL, 'active', 'ACTIVE', NULL, '2026-06-27 20:24:23', '2026-06-27 20:24:23', 1, 1, 1, 1),
(2, 'Khairul Sagala', 'khairul@ich.com', NULL, '$2y$12$cMti0ekCzyqNpHMu2PnbteJovxR.ICTqGKFGniW.cGy0c/HvHbT7a', NULL, NULL, 'teacher', '081388992877', 'profile/profile_2_1782592058.jpg', 'active', 'CLASS_NOT_SELECTED', NULL, '2026-06-27 20:26:00', '2026-06-27 20:27:38', 1, 1, 1, 1),
(3, 'Hafiz Batubara', 'hafiz@ich.com', NULL, '$2y$12$Uesu05ok5d9x1xSPaOaHm.oVpwTgmXQrRQXSp32p0aWYFDwoBPQVW', 'mother_maiden_name', '$2y$12$642O7UhTLEsVXLn3IlUQvuyyt8B6j./KxKVYqsyaVRMCjPRLxYaQe', 'student', '088201826733', NULL, 'active', 'ACTIVE', NULL, '2026-06-27 20:54:33', '2026-06-27 20:55:12', 1, 1, 1, 1),
(4, 'Mariska Siagian', 'mariska@ich.com', NULL, '$2y$12$OzH9fo.Afc4ZayfxQikPHegg4fEIQUmjraMlHNGLDtm8.I1o8Z1wO', 'mother_maiden_name', '$2y$12$orI5pXVCgoJC86x9YrovNe80b1WJtvbzURhTLr9E6Sm/CPQpQZcj6', 'student', '088829175723', NULL, 'active', 'CLASS_NOT_SELECTED', NULL, '2026-06-29 12:12:58', '2026-06-29 12:12:58', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_logs`
--

CREATE TABLE `user_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_logs`
--

INSERT INTO `user_logs` (`id`, `user_id`, `causer_id`, `action`, `description`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Teacher Created', 'Admin created a new teacher record.', '127.0.0.1', '2026-06-27 20:26:00', '2026-06-27 20:26:00'),
(2, 2, 1, 'Teacher Updated', 'Admin updated the teacher record.', '127.0.0.1', '2026-06-27 20:26:06', '2026-06-27 20:26:06'),
(3, 2, 1, 'Teacher Updated', 'Admin updated the teacher record.', '127.0.0.1', '2026-06-27 20:26:39', '2026-06-27 20:26:39'),
(4, 2, 2, 'Avatar Updated', 'Teacher uploaded a new profile photo.', '127.0.0.1', '2026-06-27 20:27:38', '2026-06-27 20:27:38'),
(5, 2, 2, 'Profile Updated', 'Teacher updated their profile information.', '127.0.0.1', '2026-06-27 20:27:39', '2026-06-27 20:27:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `weeks`
--

CREATE TABLE `weeks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `week_number` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessments_class_id_foreign` (`class_id`),
  ADD KEY `assessments_teacher_id_foreign` (`teacher_id`),
  ADD KEY `assessments_week_id_foreign` (`week_id`);

--
-- Indeks untuk tabel `assessment_scores`
--
ALTER TABLE `assessment_scores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assessment_scores_assessment_id_student_id_unique` (`assessment_id`,`student_id`),
  ADD KEY `assessment_scores_student_id_foreign` (`student_id`),
  ADD KEY `assessment_scores_graded_by_foreign` (`graded_by`);

--
-- Indeks untuk tabel `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_attendance_session_id_student_id_unique` (`attendance_session_id`,`student_id`),
  ADD KEY `attendances_student_id_foreign` (`student_id`);

--
-- Indeks untuk tabel `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_sessions_class_id_foreign` (`class_id`),
  ADD KEY `attendance_sessions_teacher_id_foreign` (`teacher_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classes_course_id_foreign` (`course_id`),
  ADD KEY `classes_teacher_id_foreign` (`teacher_id`);

--
-- Indeks untuk tabel `class_materials`
--
ALTER TABLE `class_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_materials_class_id_index` (`class_id`),
  ADD KEY `class_materials_teacher_id_index` (`teacher_id`),
  ADD KEY `class_materials_week_id_index` (`week_id`);

--
-- Indeks untuk tabel `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_index` (`sender_id`),
  ADD KEY `messages_is_read_index` (`is_read`),
  ADD KEY `messages_created_at_index` (`created_at`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_foreign` (`user_id`),
  ADD KEY `payments_class_id_foreign` (`class_id`),
  ADD KEY `payments_verified_by_foreign` (`verified_by`);

--
-- Indeks untuk tabel `payment_installments`
--
ALTER TABLE `payment_installments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_installments_payment_id_foreign` (`payment_id`),
  ADD KEY `payment_installments_verified_by_foreign` (`verified_by`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `student_grades`
--
ALTER TABLE `student_grades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_grades_student_id_class_id_unique` (`student_id`,`class_id`),
  ADD UNIQUE KEY `student_grades_certificate_number_unique` (`certificate_number`),
  ADD UNIQUE KEY `student_grades_verification_token_unique` (`verification_token`),
  ADD KEY `student_grades_student_id_index` (`student_id`),
  ADD KEY `student_grades_class_id_index` (`class_id`),
  ADD KEY `student_grades_teacher_id_index` (`teacher_id`),
  ADD KEY `student_grades_published_index` (`published`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_logs_user_id_foreign` (`user_id`),
  ADD KEY `user_logs_causer_id_foreign` (`causer_id`);

--
-- Indeks untuk tabel `weeks`
--
ALTER TABLE `weeks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `weeks_class_id_week_number_unique` (`class_id`,`week_number`),
  ADD KEY `weeks_class_id_index` (`class_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `assessments`
--
ALTER TABLE `assessments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `assessment_scores`
--
ALTER TABLE `assessment_scores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `class_materials`
--
ALTER TABLE `class_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `payment_installments`
--
ALTER TABLE `payment_installments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `student_grades`
--
ALTER TABLE `student_grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `weeks`
--
ALTER TABLE `weeks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `assessments`
--
ALTER TABLE `assessments`
  ADD CONSTRAINT `assessments_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessments_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessments_week_id_foreign` FOREIGN KEY (`week_id`) REFERENCES `weeks` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `assessment_scores`
--
ALTER TABLE `assessment_scores`
  ADD CONSTRAINT `assessment_scores_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessment_scores_graded_by_foreign` FOREIGN KEY (`graded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assessment_scores_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_attendance_session_id_foreign` FOREIGN KEY (`attendance_session_id`) REFERENCES `attendance_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  ADD CONSTRAINT `attendance_sessions_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_sessions_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classes_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `class_materials`
--
ALTER TABLE `class_materials`
  ADD CONSTRAINT `class_materials_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_materials_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_materials_week_id_foreign` FOREIGN KEY (`week_id`) REFERENCES `weeks` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payment_installments`
--
ALTER TABLE `payment_installments`
  ADD CONSTRAINT `payment_installments_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_installments_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `student_grades`
--
ALTER TABLE `student_grades`
  ADD CONSTRAINT `student_grades_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_grades_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_grades_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_logs`
--
ALTER TABLE `user_logs`
  ADD CONSTRAINT `user_logs_causer_id_foreign` FOREIGN KEY (`causer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `weeks`
--
ALTER TABLE `weeks`
  ADD CONSTRAINT `weeks_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
