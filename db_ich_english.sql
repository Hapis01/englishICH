-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Jun 2026 pada 17.19
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
(3, 1, 2, NULL, 'asdasdsa', 'Assignment', 'buat tugas dari ini bla bla', '2026-06-08', '23:41:00', 'harus ini itu', 'assessments/1780918568_QRIS_ICH (2).jpg', 1, 0, NULL, NULL, '2026-06-08 11:36:08', '2026-06-08 11:43:49'),
(4, 1, 2, NULL, 'asdasdasd', 'Final Test', 'asdasdas', '2026-06-09', NULL, 'asdasdasdasdas', 'assessments/1780919546_HCLPartnerEngineerPostVisitMuhammadHafizBatubara.pdf', 1, 0, NULL, NULL, '2026-06-08 11:52:26', '2026-06-18 13:06:13'),
(6, 1, 2, NULL, 'asd', 'Quiz', 'asd', '2026-06-20', '20:07:00', 'asd', 'assessments/1781788044_Certificate_CERT-202606-KE3IAK (4).pdf', 1, 1, '2026-06-18', '20:07:00', '2026-06-18 13:07:24', '2026-06-18 13:07:24'),
(7, 2, 2, NULL, 'asdasda', 'Quiz', 'asd', '2026-06-20', '21:10:00', 'asdasdasd', 'assessments/1781791865_tol.png', 1, 1, '2026-06-18', '21:10:00', '2026-06-18 14:11:05', '2026-06-18 14:11:05'),
(8, 1, 2, NULL, 'Tugas Hari ini', 'Assignment', 'Kerjakan Hari ini', '2026-06-26', '05:09:00', 'Buat di buku tulis', 'assessments/1782252596_image 19.png', 1, 1, '2026-06-24', '05:09:00', '2026-06-23 22:09:56', '2026-06-23 22:09:56'),
(9, 1, 2, NULL, 'Rawr', 'Assignment', 'asd', '2026-06-24', '05:14:00', 'asd', NULL, 1, 1, '2026-06-24', '05:11:00', '2026-06-23 22:11:11', '2026-06-23 22:11:11');

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

--
-- Dumping data untuk tabel `assessment_scores`
--

INSERT INTO `assessment_scores` (`id`, `assessment_id`, `student_id`, `file_path`, `submitted_at`, `score`, `maximum_score`, `is_published`, `graded_by`, `graded_at`, `notes`, `created_at`, `updated_at`) VALUES
(1, 4, 42, 'assessments/submissions/1780921162_HCLPartnerEngineerPostVisitMuhammadHafizBatubara.pdf', '2026-06-08 12:19:22', 80.00, 100.00, 0, 2, '2026-06-08 14:23:50', 'asd', '2026-06-08 12:19:22', '2026-06-08 14:23:50'),
(2, 6, 42, 'assessments/submissions/1781788081_123397939_366656847887660_9078904100081516688_n.jpg', '2026-06-18 13:08:01', NULL, 100.00, 0, NULL, NULL, 'asd', '2026-06-18 13:08:01', '2026-06-18 13:08:01'),
(3, 7, 50, 'assessments/submissions/1781794440_tol.png', '2026-06-18 14:54:00', 80.00, 100.00, 0, 2, '2026-06-18 14:54:33', 'asd', '2026-06-18 14:54:00', '2026-06-18 14:54:33'),
(4, 8, 56, 'assessments/submissions/1782252725_image 7.png', '2026-06-23 22:12:05', 90.00, 100.00, 1, 2, '2026-06-23 22:13:07', 'Saya selesai mengerjakan', '2026-06-23 22:12:05', '2026-06-23 22:13:07');

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
(4, 9, 42, 'Absent', 'Self-marked by student', '2026-06-08 11:21:15', '2026-06-20 09:48:45'),
(5, 10, 42, 'Absent', 'Self-marked by student', '2026-06-08 11:46:34', '2026-06-20 09:48:39'),
(6, 11, 42, 'Present', NULL, '2026-06-08 15:22:53', '2026-06-08 15:22:53'),
(7, 12, 42, 'Present', 'Self-marked by student', '2026-06-09 08:59:48', '2026-06-09 08:59:48'),
(8, 13, 42, 'Absent', 'Self-marked by student', '2026-06-09 09:00:41', '2026-06-09 09:00:50'),
(9, 19, 50, 'Present', 'Self-marked by student', '2026-06-18 14:29:46', '2026-06-18 14:29:46'),
(10, 24, 56, 'Present', 'Self-marked by student', '2026-06-23 22:14:45', '2026-06-23 22:14:45');

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
(1, 1, 2, 'asd', '2026-06-08', NULL, NULL, 0, 0, '2026-06-08 08:47:55', '2026-06-08 08:47:55', 'Offline', NULL, 'scheduled', NULL, NULL, 'Absent'),
(2, 1, 2, 'Absen hari ini', '2026-06-08', NULL, NULL, 0, 0, '2026-06-08 09:36:40', '2026-06-08 09:36:40', 'Offline', NULL, 'scheduled', NULL, NULL, 'Absent'),
(3, 1, 2, 'asd', '2026-06-08', NULL, NULL, 0, 0, '2026-06-08 10:01:00', '2026-06-08 10:01:00', 'Offline', NULL, 'scheduled', NULL, NULL, 'Absent'),
(9, 1, 2, 'asd', '2026-06-08', '18:20:00', '20:21:00', 0, 0, '2026-06-08 11:19:04', '2026-06-08 11:19:04', 'Offline', NULL, 'scheduled', NULL, NULL, 'Absent'),
(10, 1, 2, 'asd', '2026-06-08', '18:46:00', '18:49:00', 0, 0, '2026-06-08 11:44:53', '2026-06-08 11:44:53', 'Offline', NULL, 'scheduled', NULL, NULL, 'Absent'),
(11, 1, 2, 'asd', '2026-06-08', '19:46:00', '19:48:00', 0, 0, '2026-06-08 11:46:47', '2026-06-08 11:46:47', 'Offline', NULL, 'scheduled', NULL, NULL, 'Absent'),
(12, 1, 2, 'rawr', '2026-06-09', '15:00:00', '16:00:00', 0, 0, '2026-06-09 08:59:14', '2026-06-09 08:59:14', 'Google Meet', 'https://meet.google.com/yrv-uzod-wcp', 'scheduled', NULL, NULL, 'Absent'),
(13, 1, 2, 'asd', '2026-06-09', '16:00:00', '18:02:00', 0, 0, '2026-06-09 09:00:35', '2026-06-09 09:00:35', 'Offline', NULL, 'scheduled', NULL, NULL, 'Absent'),
(15, 1, 2, 'Session 2026-06-14', '2026-06-14', NULL, NULL, 0, 0, '2026-06-14 15:00:03', '2026-06-14 15:06:18', 'Offline', NULL, 'scheduled', '22:00:03', '22:06:18', 'Present'),
(16, 2, 2, 'Session 2026-06-14', '2026-06-14', NULL, NULL, 0, 0, '2026-06-14 15:44:35', '2026-06-14 15:44:39', 'Offline', NULL, 'scheduled', '22:44:35', '22:44:39', 'Present'),
(17, 1, 2, 'Session 2026-06-17', '2026-06-17', NULL, NULL, 0, 0, '2026-06-16 20:06:38', '2026-06-16 20:06:38', 'Offline', NULL, 'scheduled', '03:06:38', NULL, 'Present'),
(19, 2, 2, 'asd', '2026-06-18', '22:03:00', '21:35:00', 1, 1, '2026-06-18 14:29:39', '2026-06-20 09:48:30', 'Offline', NULL, 'cancelled', NULL, NULL, 'Absent'),
(20, 1, 2, 'Session 2026-06-19', '2026-06-19', NULL, NULL, 0, 0, '2026-06-19 08:48:49', '2026-06-19 08:51:26', 'Offline', NULL, 'scheduled', '15:48:49', '15:51:26', 'Present'),
(21, 1, 2, 'Session 2026-06-20', '2026-06-20', NULL, NULL, 0, 0, '2026-06-20 09:36:08', '2026-06-20 09:36:15', 'Offline', NULL, 'scheduled', '16:36:08', '16:36:15', 'Present'),
(22, 1, 2, 'asdasd', '2026-06-21', '21:21:00', '21:23:00', 0, 1, '2026-06-21 14:21:57', '2026-06-21 14:21:57', 'Offline', NULL, 'scheduled', NULL, NULL, 'Absent'),
(23, 1, 2, 'Session 2026-06-22', '2026-06-22', NULL, NULL, 0, 0, '2026-06-22 05:37:46', '2026-06-22 05:37:50', 'Offline', NULL, 'scheduled', '12:37:46', '12:37:50', 'Present'),
(24, 1, 2, 'Meeting Hari ini', '2026-06-24', '05:15:00', '05:20:00', 1, 1, '2026-06-23 22:13:55', '2026-06-23 22:15:55', 'Google Meet', 'https://meet.google.com/jgp-evbx-pez', 'cancelled', NULL, NULL, 'Absent');

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
(1, 1, 2, 'Basic Plan - Morning Class', 'offline', 'Monday & Wednesday 08:00-10:00', 20, 5, '2026-06-13', '2026-09-06', NULL, 'active', '2026-06-06 02:31:51', '2026-06-06 02:31:51', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\",\"Saturday\",\"Sunday\"]', '11:00:00', '14:00:00', 'recurring'),
(2, 1, 2, 'Basic Plan - Afternoon Class', 'online', 'Monday & Wednesday 15:00-17:00', 20, 5, '2026-06-13', '2026-09-06', 'https://meet.google.com/ljd-mhej-iei', 'active', '2026-06-06 02:31:51', '2026-06-06 02:31:51', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\",\"Saturday\",\"Sunday\"]', '16:00:00', '20:00:00', 'recurring'),
(3, 2, 3, 'Intermediate Plan - Morning Class', 'offline', 'Monday & Wednesday 08:00-10:00', 20, 5, '2026-06-13', '2026-10-06', NULL, 'active', '2026-06-06 02:31:51', '2026-06-06 02:31:51', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\",\"Saturday\",\"Sunday\"]', '11:00:00', '14:00:00', 'recurring'),
(4, 2, 3, 'Intermediate Plan - Afternoon Class', 'online', 'Monday & Wednesday 15:00-17:00', 20, 5, '2026-06-13', '2026-10-06', 'https://meet.google.com/ptk-fgoh-uta', 'active', '2026-06-06 02:31:51', '2026-06-06 02:31:51', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\",\"Saturday\",\"Sunday\"]', '16:00:00', '20:00:00', 'recurring'),
(5, 3, 4, 'Advanced Plan - Morning Class', 'offline', 'Monday & Wednesday 08:00-10:00', 20, 5, '2026-06-13', '2026-10-06', NULL, 'active', '2026-06-06 02:31:51', '2026-06-06 02:31:51', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\",\"Saturday\",\"Sunday\"]', '11:00:00', '14:00:00', 'recurring'),
(6, 3, 4, 'Advanced Plan - Afternoon Class', 'online', 'Monday & Wednesday 15:00-17:00', 20, 5, '2026-06-13', '2026-10-06', 'https://meet.google.com/brk-ojqu-rfi', 'active', '2026-06-06 02:31:51', '2026-06-06 02:31:51', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\",\"Saturday\",\"Sunday\"]', '16:00:00', '20:00:00', 'recurring'),
(8, 1, 51, 'Basic Plan - Morning Class', 'offline', 'Senin sampai selasa, pukul 10.00 - 12-00 WIB', 10, 0, '2026-06-19', '2026-10-19', NULL, 'active', '2026-06-19 06:31:30', '2026-06-19 06:31:30', NULL, NULL, NULL, NULL);

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

--
-- Dumping data untuk tabel `class_materials`
--

INSERT INTO `class_materials` (`id`, `class_id`, `week_id`, `teacher_id`, `title`, `file_path`, `file_type`, `file_size`, `description`, `uploaded_at`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 2, 'asd', 'materials/1780908246_1780248536_SK MAGANG PT PATRA NIAGA.pdf', 'pdf', 105033, 'asd', '2026-06-08 08:44:06', '2026-06-08 08:44:06', '2026-06-08 08:44:06'),
(2, 1, NULL, 2, 'asd', 'materials/1781778645_1780908246_1780248536_SK MAGANG PT PATRA NIAGA.pdf', 'pdf', 105033, 'asd', '2026-06-18 10:30:46', '2026-06-18 10:30:46', '2026-06-18 10:30:46'),
(3, 2, 3, 2, 'asd', 'materials/1781791832_tol.png', 'png', 174187, 'asd', '2026-06-18 14:10:32', '2026-06-18 14:10:32', '2026-06-18 14:10:32'),
(4, 1, NULL, 2, 'Materi Hari ini', 'materials/1782252498_Certificate_CERT-202606-KE3IAK (4).pdf', 'pdf', 1115083, NULL, '2026-06-23 22:08:19', '2026-06-23 22:08:19', '2026-06-23 22:08:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `level` enum('basic','intermediate','advanced','business','ielts','toefl') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration in months',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `level`, `price`, `duration`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Basic Plan', 'Fundamental English course for beginners. Learn basic grammar, vocabulary, and conversation skills.', 'basic', 1999000.00, 3, 'active', '2026-06-06 02:31:51', '2026-06-06 02:31:51'),
(2, 'Intermediate Plan', 'Intermediate level English course. Improve your grammar, expand vocabulary, and enhance communication skills.', 'intermediate', 3499000.00, 4, 'active', '2026-06-06 02:31:51', '2026-06-06 02:31:51'),
(3, 'Advanced Plan', 'Advanced English course for fluent speakers. Master complex grammar, idioms, and professional communication.', 'advanced', 5999000.00, 4, 'active', '2026-06-06 02:31:51', '2026-06-06 02:31:51');

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
(1, 46, 8, 'hi sir', NULL, 0, '2026-06-07 07:30:01', '2026-06-07 07:30:01'),
(2, 42, 10, 'mobile friendly', NULL, 0, '2026-06-07 19:29:19', '2026-06-07 19:29:19'),
(3, 42, 2, 'halo pak', NULL, 1, '2026-06-16 19:28:22', '2026-06-16 19:30:56'),
(4, 42, 2, '', 'images/chat/chat_1781638123_jQy6Zo_0e039e00c88257fbab9761a3b455b6fc.jpg', 1, '2026-06-16 19:28:43', '2026-06-16 19:30:56'),
(5, 42, 2, 'coba ini', NULL, 1, '2026-06-16 19:30:00', '2026-06-16 19:30:56'),
(6, 42, 2, '', 'images/chat/chat_1781638205_VV0wnj_1780908246_1780248536_SK_MAGANG_PT_PATRA_NIAGA.pdf', 1, '2026-06-16 19:30:05', '2026-06-16 19:30:56'),
(7, 2, 42, 'oke', NULL, 1, '2026-06-16 19:33:56', '2026-06-16 19:34:05'),
(8, 42, 2, 'kenapa gitu pak?', NULL, 1, '2026-06-16 19:34:10', '2026-06-16 19:34:13'),
(9, 2, 42, 'ga juga sih', NULL, 1, '2026-06-16 19:34:22', '2026-06-16 19:34:25'),
(10, 42, 2, 'lagian dimana aja dipikir pikir', NULL, 1, '2026-06-16 19:34:37', '2026-06-16 19:35:30'),
(11, 2, 42, 'iya juga', NULL, 1, '2026-06-16 19:35:36', '2026-06-16 19:35:36'),
(12, 50, 2, 'ton sehat', NULL, 1, '2026-06-18 14:57:28', '2026-06-18 14:57:35'),
(13, 2, 50, 'iya ajg', NULL, 1, '2026-06-18 14:57:39', '2026-06-18 14:57:39'),
(14, 2, 50, 'ini coba liat ton', 'images/chat/chat_1781794681_2iic9c_tol.png', 1, '2026-06-18 14:58:01', '2026-06-18 14:58:04'),
(15, 2, 50, '', 'images/chat/chat_1781794696_JTLmZQ_Certificate_CERT-202606-KE3IAK__3_.pdf', 1, '2026-06-18 14:58:16', '2026-06-18 14:58:19'),
(16, 56, 2, 'Halo selamat pagi pak', NULL, 1, '2026-06-23 22:17:15', '2026-06-23 22:17:19'),
(17, 2, 56, 'Iya nak', NULL, 1, '2026-06-23 22:17:36', '2026-06-23 22:17:36');

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
(28, '2026_06_06_100949_create_academic_management_tables', 2),
(29, '2026_06_07_142501_create_user_logs_table', 3),
(30, '2026_06_08_150000_create_weekly_materials_and_assignments_system', 4),
(31, '2026_06_08_181750_add_submission_fields_to_assessments_tables', 5),
(32, '2026_06_08_184540_add_open_logic_to_assignments_table', 6),
(33, '2026_06_08_185739_add_open_logic_to_assessments_table', 7),
(34, '2026_06_08_191755_make_score_nullable_on_assessment_scores_table', 8),
(35, '2026_06_08_194813_add_grading_fields_to_assessment_scores_table', 9),
(36, '2026_06_08_194825_create_teacher_student_notes_table', 9),
(37, '2026_06_08_213333_update_assessments_type_enum', 10),
(38, '2026_06_14_200000_add_grammar_to_student_grades_table', 11),
(39, '2026_06_14_200001_create_teacher_attendance_tables', 11),
(40, '2026_06_17_000001_cleanup_database_drop_unused_and_merge_assignments', 12),
(41, '2026_06_17_021143_optimize_database_structure', 13),
(42, '2026_06_19_161001_add_owner_role_to_users_table', 14);

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
('01356b6a-fd5e-4c92-b65e-43ba439adbe3', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 45, '{\"title\":\"Class Announcement: Basic Plan - Morning Class\",\"message\":\"Benton Pfeffer announced: asd\",\"type\":\"announcement\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\"}', NULL, '2026-06-19 08:45:19', '2026-06-19 08:45:19'),
('0a9c3192-1dc8-4484-bd52-fb0388f8b410', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 42, '{\"title\":\"Installment Rejected\",\"message\":\"Cicilan ke-3 sebesar Rp 499.750 ditolak. Silakan upload ulang bukti pembayaran.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-07 06:53:49', '2026-06-07 06:53:49'),
('0e0f2a08-ce3d-41cf-9cb8-99d6f509ca8e', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 55, '{\"title\":\"Installment Approved\",\"message\":\"Cicilan ke-1 sebesar Rp 499.750 telah disetujui. Progress: 1\\/4 cicilan, Rp 499.750 \\/ Rp 1.999.000.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-22 05:36:16', '2026-06-22 05:36:16'),
('1435dcca-c904-4008-8819-f1b6079961e8', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 42, '{\"title\":\"Installment Approved\",\"message\":\"Cicilan ke-4 sebesar Rp 499.750 telah disetujui. Progress: 4\\/4 cicilan, Rp 1.999.000 \\/ Rp 1.999.000.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-07 07:06:42', '2026-06-07 07:06:42'),
('15406421-328a-489e-9d7c-d0fb3282cf69', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 46, '{\"title\":\"Class Announcement: Basic Plan - Morning Class\",\"message\":\"Benton Pfeffer announced: asd\",\"type\":\"announcement\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\"}', NULL, '2026-06-19 08:45:19', '2026-06-19 08:45:19'),
('1971bde2-86cf-494d-b8c6-79cf5c3b9f69', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 42, '{\"title\":\"Class Announcement: Basic Plan - Morning Class\",\"message\":\"Benton Pfeffer announced: asd\",\"type\":\"announcement\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\"}', NULL, '2026-06-19 08:45:19', '2026-06-19 08:45:19'),
('19a906e5-f819-4013-a97b-1145556fe78b', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 42, '{\"title\":\"Installment Approved\",\"message\":\"Cicilan ke-2 sebesar Rp 499.750 telah disetujui. Progress: 2\\/4 cicilan, Rp 999.500 \\/ Rp 1.999.000.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-07 06:53:24', '2026-06-07 06:53:24'),
('1dd2ceb5-a3c6-4a06-8b91-4462bdd51356', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 46, '{\"title\":\"Payment Approved\",\"message\":\"Your payment of Rp 1.999.000 has been approved.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-07 07:09:16', '2026-06-07 07:09:16'),
('3236c2d7-696a-4bb9-a04c-e4e6616286dc', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 56, '{\"title\":\"Installment Approved\",\"message\":\"Cicilan ke-1 sebesar Rp 499.750 telah disetujui. Progress: 1\\/4 cicilan, Rp 499.750 \\/ Rp 1.999.000.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-23 22:06:37', '2026-06-23 22:06:37'),
('3e1a2bf9-1a1d-44e3-9256-7a2b3a7f29d8', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 42, '{\"title\":\"Payment Approved\",\"message\":\"Your payment of Rp 1.999.000 has been approved.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-07 01:02:02', '2026-06-07 01:02:02'),
('45d19e5f-f0dc-4443-9cf3-db4a38b3149f', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 42, '{\"title\":\"Installment Approved\",\"message\":\"Cicilan ke-1 sebesar Rp 499.750 telah disetujui. Progress: 1\\/4 cicilan, Rp 499.750 \\/ Rp 1.999.000.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-07 01:35:48', '2026-06-07 01:35:48'),
('4b7c6df1-a87c-4226-9459-c3d80faeb57d', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 47, '{\"title\":\"Installment Approved\",\"message\":\"Cicilan ke-1 sebesar Rp 874.750 telah disetujui. Progress: 1\\/4 cicilan, Rp 874.750 \\/ Rp 3.499.000.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-16 18:47:29', '2026-06-16 18:47:29'),
('719d78fb-48b7-4ccb-ac5f-79d284dda0eb', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 47, '{\"title\":\"Installment Rejected\",\"message\":\"Cicilan ke-1 sebesar Rp 874.750 ditolak. Silakan upload ulang bukti pembayaran.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-16 18:46:48', '2026-06-16 18:46:48'),
('783f24ab-ad87-41a7-9e43-bd74ff50b018', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 45, '{\"title\":\"Installment Approved\",\"message\":\"Cicilan ke-1 sebesar Rp 499.750 telah disetujui. Progress: 1\\/4 cicilan, Rp 499.750 \\/ Rp 1.999.000.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-08 08:38:24', '2026-06-08 08:38:24'),
('886c72b8-332d-4668-865e-831a94c549bd', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 48, '{\"title\":\"Payment Approved\",\"message\":\"Your payment of Rp 3.499.000 has been approved.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-18 10:13:56', '2026-06-18 10:13:56'),
('a3103567-a818-4a4f-be02-790f84e58e17', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 44, '{\"title\":\"Payment Approved\",\"message\":\"Your payment of Rp 3.499.000 has been approved.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-07 01:24:36', '2026-06-07 01:24:36'),
('a4c44d93-1d49-49ba-a044-9465c41fecea', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 50, '{\"title\":\"Installment Approved\",\"message\":\"Cicilan ke-1 sebesar Rp 499.750 telah disetujui. Progress: 1\\/4 cicilan, Rp 499.750 \\/ Rp 1.999.000.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-18 14:09:51', '2026-06-18 14:09:51'),
('a8fdda65-94f9-4b98-b635-5f7d35031574', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 49, '{\"title\":\"Installment Rejected\",\"message\":\"Cicilan ke-1 sebesar Rp 499.750 ditolak. Silakan upload ulang bukti pembayaran.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-18 14:08:57', '2026-06-18 14:08:57'),
('caea7808-2aa4-45ce-9e1f-c5c9652acd7e', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 43, '{\"title\":\"Installment Approved\",\"message\":\"Cicilan ke-1 sebesar Rp 874.750 telah disetujui. Progress: 1\\/4 cicilan, Rp 874.750 \\/ Rp 3.499.000.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-07 01:22:55', '2026-06-07 01:22:55'),
('d8cf8019-33b3-40bf-b7db-1d95af520fec', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 42, '{\"title\":\"Installment Approved\",\"message\":\"Cicilan ke-3 sebesar Rp 499.750 telah disetujui. Progress: 3\\/4 cicilan, Rp 1.499.250 \\/ Rp 1.999.000.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-07 06:54:19', '2026-06-07 06:54:19'),
('fa7e0e6a-7117-406f-83a3-d616c7cab47c', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 53, '{\"title\":\"Payment Approved\",\"message\":\"Your payment of Rp 1.999.000 has been approved.\",\"type\":\"payment\",\"action_url\":\"http:\\/\\/127.0.0.1:8000\\/student\\/payments\"}', NULL, '2026-06-19 15:58:10', '2026-06-19 15:58:10');

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
(1, 42, 1, 1999000.00, 'paid', 'installment', 1999000.00, 1999000.00, 0.00, 'approved', 1, '2026-06-07 01:02:02', 'images/payment-proofs/payment_1780819287_QRIS_ICH.jpg', '2026-06-07', 'images/payment-proofs/payment_1780841192_QRIS_ICH.jpg', 'images/payment-proofs/payment_1780841192_QRIS_ICH.jpg', NULL, 'Pembayaran Cicilan - Basic Plan', 'Pembayaran Cicilan', 'Pembayaran cicilan 4x untuk kelas Basic Plan - Morning Class', NULL, NULL, '2026-06-07 01:01:18', '2026-06-07 07:06:42'),
(2, 43, 3, 3499000.00, 'paid', 'installment', 3499000.00, 874750.00, 2624250.00, 'none', NULL, NULL, NULL, '2026-06-07', 'images/payment-proofs/payment_1780820546_QRIS_ICH.jpg', 'images/payment-proofs/payment_1780820546_QRIS_ICH.jpg', NULL, 'Pembayaran Cicilan - Premium Plan', 'Pembayaran Cicilan', 'Pembayaran cicilan 4x untuk kelas Premium Plan - Morning Class', NULL, '2026-07-14', '2026-06-07 01:22:19', '2026-06-07 01:22:55'),
(3, 44, 3, 3499000.00, 'paid', 'full', 3499000.00, 0.00, 3499000.00, 'approved', 1, '2026-06-07 01:24:36', 'images/payment-proofs/payment_1780820664_QRIS_ICH.jpg', '2026-06-07', 'images/payment-proofs/payment_1780820664_QRIS_ICH.jpg', 'images/payment-proofs/payment_1780820664_QRIS_ICH.jpg', NULL, 'Pembayaran Penuh - Premium Plan', 'Pembayaran Penuh', 'Pembayaran penuh untuk kelas Premium Plan - Morning Class', '2026-06-14', '2026-06-14', '2026-06-07 01:24:15', '2026-06-07 01:24:36'),
(4, 46, 1, 1999000.00, 'paid', 'full', 1999000.00, 0.00, 1999000.00, 'approved', 1, '2026-06-07 07:09:16', 'images/payment-proofs/payment_1780841339_QRIS_ICH.jpg', '2026-06-07', 'images/payment-proofs/payment_1780841339_QRIS_ICH.jpg', 'images/payment-proofs/payment_1780841339_QRIS_ICH.jpg', NULL, 'Pembayaran Penuh - Basic Plan', 'Pembayaran Penuh', 'Pembayaran penuh untuk kelas Basic Plan - Morning Class', '2026-06-14', '2026-06-14', '2026-06-07 07:08:36', '2026-06-07 07:09:16'),
(5, 45, 1, 1999000.00, 'paid', 'installment', 1999000.00, 499750.00, 1499250.00, 'none', NULL, NULL, NULL, '2026-06-08', 'images/payment-proofs/payment_1780907874_QRIS_ICH.jpg', 'images/payment-proofs/payment_1780907874_QRIS_ICH.jpg', NULL, 'Pembayaran Cicilan - Basic Plan', 'Pembayaran Cicilan', 'Pembayaran cicilan 4x untuk kelas Basic Plan - Morning Class', NULL, '2026-07-15', '2026-06-08 08:37:47', '2026-06-08 08:38:24'),
(6, 47, 3, 3499000.00, 'paid', 'installment', 3499000.00, 874750.00, 2624250.00, 'none', NULL, NULL, NULL, '2026-06-17', 'images/payment-proofs/payment_1781635629_Black___Blue_Minimalist_Modern_Initial_Font_Logo-fotor-2023091821848.png', 'images/payment-proofs/payment_1781635629_Black___Blue_Minimalist_Modern_Initial_Font_Logo-fotor-2023091821848.png', NULL, 'Pembayaran Cicilan - Intermediate Plan', 'Pembayaran Cicilan', 'Pembayaran cicilan 4x untuk kelas Intermediate Plan - Morning Class', NULL, '2026-07-24', '2026-06-16 18:45:51', '2026-06-16 18:47:29'),
(7, 48, 3, 3499000.00, 'paid', 'full', 3499000.00, 0.00, 3499000.00, 'approved', 1, '2026-06-18 10:13:53', 'images/payment-proofs/payment_1781777619_123397939_366656847887660_9078904100081516688_n.jpg', '2026-06-18', 'images/payment-proofs/payment_1781777619_123397939_366656847887660_9078904100081516688_n.jpg', 'images/payment-proofs/payment_1781777619_123397939_366656847887660_9078904100081516688_n.jpg', NULL, 'Pembayaran Penuh - Intermediate Plan', 'Pembayaran Penuh', 'Pembayaran penuh untuk kelas Intermediate Plan - Morning Class', '2026-06-25', '2026-06-25', '2026-06-18 10:12:37', '2026-06-18 10:13:53'),
(8, 49, 1, 1999000.00, 'pending', 'installment', 1999000.00, 0.00, 1999000.00, 'none', NULL, NULL, NULL, '2026-06-18', 'images/payment-proofs/payment_1781791718_tol.png', 'images/payment-proofs/payment_1781791718_tol.png', NULL, 'Pembayaran Cicilan - Basic Plan', 'Pembayaran Cicilan', 'Pembayaran cicilan 4x untuk kelas Basic Plan - Morning Class', NULL, '2026-06-25', '2026-06-18 13:44:10', '2026-06-18 14:08:57'),
(9, 50, 2, 1999000.00, 'paid', 'installment', 1999000.00, 499750.00, 1499250.00, 'none', NULL, NULL, NULL, '2026-06-18', 'images/payment-proofs/payment_1781791252_tol.png', 'images/payment-proofs/payment_1781791252_tol.png', NULL, 'Pembayaran Cicilan - Basic Plan', 'Pembayaran Cicilan', 'Pembayaran cicilan 4x untuk kelas Basic Plan - Afternoon Class', NULL, '2026-07-25', '2026-06-18 13:51:16', '2026-06-18 14:09:51'),
(10, 53, 1, 1999000.00, 'paid', 'full', 1999000.00, 0.00, 1999000.00, 'approved', 1, '2026-06-19 15:58:08', 'images/payment-proofs/payment_1781882751_teacher3.jpg', '2026-06-19', 'images/payment-proofs/payment_1781882751_teacher3.jpg', 'images/payment-proofs/payment_1781882751_teacher3.jpg', NULL, 'Pembayaran Penuh - Basic Plan', 'Pembayaran Penuh', 'Pembayaran penuh untuk kelas Basic Plan - Morning Class', '2026-06-26', '2026-06-26', '2026-06-19 15:21:54', '2026-06-19 15:58:08'),
(11, 55, 1, 1999000.00, 'paid', 'installment', 1999000.00, 499750.00, 1499250.00, 'none', NULL, NULL, NULL, '2026-06-22', 'images/payment-proofs/payment_1782106552_asdsd.png', 'images/payment-proofs/payment_1782106552_asdsd.png', NULL, 'Pembayaran Cicilan - Basic Plan', 'Pembayaran Cicilan', 'Pembayaran cicilan 4x untuk kelas Basic Plan - Morning Class', NULL, '2026-07-29', '2026-06-22 05:34:58', '2026-06-22 05:36:13'),
(12, 56, 1, 1999000.00, 'paid', 'installment', 1999000.00, 499750.00, 1499250.00, 'none', NULL, NULL, NULL, '2026-06-24', 'images/payment-proofs/payment_1782252321_image_4.png', 'images/payment-proofs/payment_1782252321_image_4.png', NULL, 'Pembayaran Cicilan - Basic Plan', 'Pembayaran Cicilan', 'Pembayaran cicilan 4x untuk kelas Basic Plan - Morning Class', NULL, '2026-08-01', '2026-06-23 22:04:38', '2026-06-23 22:06:35');

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
(1, 1, 1, 499750.00, '2026-06-07', '2026-06-07', 'paid', 'images/payment-proofs/payment_1780821108_qris.jpg', 'approved', 1, '2026-06-07 01:35:48', NULL, '2026-06-07 01:01:18', '2026-06-07 01:35:48'),
(2, 1, 2, 499750.00, '2026-07-07', '2026-06-07', 'paid', 'images/payment-proofs/payment_1780840381_QRIS_ICH.jpg', 'approved', 1, '2026-06-07 06:53:24', NULL, '2026-06-07 01:01:18', '2026-06-07 06:53:24'),
(3, 1, 3, 499750.00, '2026-08-07', '2026-06-07', 'paid', 'images/payment-proofs/payment_1780840448_QRIS_ICH.jpg', 'approved', 1, '2026-06-07 06:54:19', NULL, '2026-06-07 01:01:18', '2026-06-07 06:54:19'),
(4, 1, 4, 499750.00, '2026-06-04', '2026-06-07', 'paid', 'images/payment-proofs/payment_1780841192_QRIS_ICH.jpg', 'approved', 1, '2026-06-07 07:06:42', NULL, '2026-06-07 01:01:18', '2026-06-07 07:06:42'),
(5, 2, 1, 874750.00, '2026-06-14', '2026-06-07', 'paid', 'images/payment-proofs/payment_1780820546_QRIS_ICH.jpg', 'approved', 1, '2026-06-07 01:22:55', NULL, '2026-06-07 01:22:19', '2026-06-07 01:22:55'),
(6, 2, 2, 874750.00, '2026-07-14', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-07 01:22:19', '2026-06-07 01:22:19'),
(7, 2, 3, 874750.00, '2026-08-14', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-07 01:22:19', '2026-06-07 01:22:19'),
(8, 2, 4, 874750.00, '2026-08-14', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-07 01:22:19', '2026-06-07 01:22:19'),
(9, 5, 1, 499750.00, '2026-06-15', '2026-06-08', 'paid', 'images/payment-proofs/payment_1780907874_QRIS_ICH.jpg', 'approved', 1, '2026-06-08 08:38:24', NULL, '2026-06-08 08:37:47', '2026-06-08 08:38:24'),
(10, 5, 2, 499750.00, '2026-07-15', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-08 08:37:47', '2026-06-08 08:37:47'),
(11, 5, 3, 499750.00, '2026-08-15', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-08 08:37:47', '2026-06-08 08:37:47'),
(12, 5, 4, 499750.00, '2026-09-15', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-08 08:37:47', '2026-06-08 08:37:47'),
(13, 6, 1, 874750.00, '2026-06-24', '2026-06-17', 'paid', 'images/payment-proofs/payment_1781635629_Black___Blue_Minimalist_Modern_Initial_Font_Logo-fotor-2023091821848.png', 'approved', 1, '2026-06-16 18:47:29', NULL, '2026-06-16 18:45:51', '2026-06-16 18:47:29'),
(14, 6, 2, 874750.00, '2026-07-24', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-16 18:45:51', '2026-06-16 18:45:51'),
(15, 6, 3, 874750.00, '2026-08-24', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-16 18:45:51', '2026-06-16 18:45:51'),
(16, 6, 4, 874750.00, '2026-09-24', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-16 18:45:51', '2026-06-16 18:45:51'),
(17, 8, 1, 499750.00, '2026-06-25', '2026-06-18', 'pending', 'images/payment-proofs/payment_1781791718_tol.png', 'rejected', 1, '2026-06-18 14:08:57', NULL, '2026-06-18 13:44:10', '2026-06-18 14:08:57'),
(18, 8, 2, 499750.00, '2026-07-25', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-18 13:44:10', '2026-06-18 13:44:10'),
(19, 8, 3, 499750.00, '2026-08-25', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-18 13:44:10', '2026-06-18 13:44:10'),
(20, 8, 4, 499750.00, '2026-09-25', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-18 13:44:10', '2026-06-18 13:44:10'),
(21, 9, 1, 499750.00, '2026-06-25', '2026-06-18', 'paid', 'images/payment-proofs/payment_1781790924_tol.png', 'approved', 1, '2026-06-18 14:09:51', NULL, '2026-06-18 13:51:16', '2026-06-18 14:09:51'),
(22, 9, 2, 499750.00, '2026-07-25', '2026-06-18', 'pending', 'images/payment-proofs/payment_1781791252_tol.png', 'pending_verification', NULL, NULL, NULL, '2026-06-18 13:51:16', '2026-06-18 14:00:52'),
(23, 9, 3, 499750.00, '2026-08-25', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-18 13:51:16', '2026-06-18 13:51:16'),
(24, 9, 4, 499750.00, '2026-09-25', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-18 13:51:16', '2026-06-18 13:51:16'),
(25, 11, 1, 499750.00, '2026-06-29', '2026-06-22', 'paid', 'images/payment-proofs/payment_1782106552_asdsd.png', 'approved', 1, '2026-06-22 05:36:13', NULL, '2026-06-22 05:34:58', '2026-06-22 05:36:13'),
(26, 11, 2, 499750.00, '2026-07-29', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-22 05:34:58', '2026-06-22 05:34:58'),
(27, 11, 3, 499750.00, '2026-08-29', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-22 05:34:58', '2026-06-22 05:34:58'),
(28, 11, 4, 499750.00, '2026-09-29', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-22 05:34:58', '2026-06-22 05:34:58'),
(29, 12, 1, 499750.00, '2026-07-01', '2026-06-24', 'paid', 'images/payment-proofs/payment_1782252321_image_4.png', 'approved', 1, '2026-06-23 22:06:35', NULL, '2026-06-23 22:04:38', '2026-06-23 22:06:35'),
(30, 12, 2, 499750.00, '2026-08-01', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-23 22:04:38', '2026-06-23 22:04:38'),
(31, 12, 3, 499750.00, '2026-09-01', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-23 22:04:38', '2026-06-23 22:04:38'),
(32, 12, 4, 499750.00, '2026-10-01', NULL, 'pending', NULL, 'none', NULL, NULL, NULL, '2026-06-23 22:04:38', '2026-06-23 22:04:38');

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
('eh2qOlhwbFnxXjaHmufdMGpFgZUAvDKqNCjX5HAr', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNHU0VnlGWDZqbERzSE9oNXlKN0J6S1ZEUUh5ajUzazdTR3VDeGZLciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJsYW5kaW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1782378049),
('ljlQoKKH94fbCLvqL0oca0Kuo2UI8n45opsGbcJs', 57, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMnhsRWRZZXFJV2RxY3pFZVNWdDU5bGRab3E4TDJZRlBGVVRHdzBFNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdHVkZW50L3NlbGVjdC1jbGFzcyI7czo1OiJyb3V0ZSI7czoyMDoic3R1ZGVudC5zZWxlY3QuY2xhc3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1Nzt9', 1782378878),
('nKWldiFVBiIVI846txXuwVCVAIHMT4XlYTuzLFii', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFdwSGFPNm1NYUY3UUZvME40c3FmQVViVDc1RFdCQ1RiSHM2YjVEZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJsYW5kaW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1782378155),
('nPhEz2nOcpGvUNMmWdCa4o9EAhGRQyZBZBh72vVK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRUJzWFFwWkhMYzV1VGdqMlc0TWlrMFNCUUZiQk9EYk1DSGg4N3ZReiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJsYW5kaW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJsb2NhbGUiO3M6MjoiaWQiO30=', 1782400750),
('sdUJFdS89LPFPMKokgSCwYVurWOCPPbxNrh5NViI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZUdjU0Jpc21nSGpxT0dTTHVVZ2MyS2xDcjc1T1ptZkV1WnBTYjhYUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJsYW5kaW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1782378038);

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
(1, 42, 1, 2, 70.00, 80.00, 90.00, 60.00, 80.00, 80.00, 76.00, NULL, 1, '2026-06-18', '2026-06-08 15:18:04', '2026-06-20 05:00:19', 'CERT-202606-KE3IAK', '2026-06-18', 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2ZmZmZmZiIvPjxnIHRyYW5zZm9ybT0ic2NhbGUoMy4wMykiPjxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsMCkiPjxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTEwIDBMMTAgMkwxMSAyTDExIDBaTTEyIDBMMTIgMUwxMyAxTDEzIDJMMTIgMkwxMiA0TDEzIDRMMTMgMkwxNCAyTDE0IDVMMTUgNUwxNSA2TDE0IDZMMTQgOEwxMiA4TDEyIDdMMTMgN0wxMyA1TDExIDVMMTEgNkwxMCA2TDEwIDRMMTEgNEwxMSAzTDggM0w4IDRMOSA0TDkgNUw4IDVMOCA3TDkgN0w5IDhMNiA4TDYgOUw1IDlMNSA4TDAgOEwwIDExTDEgMTFMMSAxMkwyIDEyTDIgMTNMMSAxM0wxIDE4TDAgMThMMCAyNUwxIDI1TDEgMjJMMiAyMkwyIDI1TDggMjVMOCAyN0w5IDI3TDkgMjhMOCAyOEw4IDMzTDEwIDMzTDEwIDMyTDExIDMyTDExIDMzTDEzIDMzTDEzIDMxTDE0IDMxTDE0IDI5TDE2IDI5TDE2IDMwTDE1IDMwTDE1IDMyTDE0IDMyTDE0IDMzTDE1IDMzTDE1IDMyTDE3IDMyTDE3IDMzTDE4IDMzTDE4IDMyTDE3IDMyTDE3IDMxTDE5IDMxTDE5IDMwTDIwIDMwTDIwIDMxTDIxIDMxTDIxIDMyTDIyIDMyTDIyIDMzTDIzIDMzTDIzIDMyTDI0IDMyTDI0IDMzTDI1IDMzTDI1IDMyTDI0IDMyTDI0IDMxTDI3IDMxTDI3IDMyTDI4IDMyTDI4IDMzTDI5IDMzTDI5IDMxTDMwIDMxTDMwIDMyTDMxIDMyTDMxIDMzTDMyIDMzTDMyIDMyTDMxIDMyTDMxIDMxTDMyIDMxTDMyIDMwTDMxIDMwTDMxIDI5TDMwIDI5TDMwIDI4TDMyIDI4TDMyIDI5TDMzIDI5TDMzIDI4TDMyIDI4TDMyIDI2TDMzIDI2TDMzIDI0TDMyIDI0TDMyIDI2TDMxIDI2TDMxIDI1TDMwIDI1TDMwIDI0TDMxIDI0TDMxIDIzTDMyIDIzTDMyIDIyTDMzIDIyTDMzIDIxTDMyIDIxTDMyIDIwTDMxIDIwTDMxIDE5TDMyIDE5TDMyIDE4TDMzIDE4TDMzIDE3TDMyIDE3TDMyIDE2TDMxIDE2TDMxIDE1TDMyIDE1TDMyIDE0TDMzIDE0TDMzIDEzTDMxIDEzTDMxIDE1TDMwIDE1TDMwIDEzTDI5IDEzTDI5IDEwTDI4IDEwTDI4IDhMMjcgOEwyNyA5TDI2IDlMMjYgOEwyNSA4TDI1IDZMMjQgNkwyNCA4TDIzIDhMMjMgNUwyNCA1TDI0IDRMMjUgNEwyNSAzTDI0IDNMMjQgMkwyNSAyTDI1IDFMMjQgMUwyNCAwTDIyIDBMMjIgMUwyMSAxTDIxIDBMMTkgMEwxOSAxTDE4IDFMMTggMEwxNCAwTDE0IDFMMTMgMUwxMyAwWk04IDFMOCAyTDkgMkw5IDFaTTE0IDFMMTQgMkwxNSAyTDE1IDNMMTggM0wxOCA1TDE3IDVMMTcgNEwxNSA0TDE1IDVMMTYgNUwxNiA2TDE1IDZMMTUgN0wxNiA3TDE2IDhMMTUgOEwxNSA5TDE0IDlMMTQgMTFMMTMgMTFMMTMgMTNMMTIgMTNMMTIgMTJMMTEgMTJMMTEgMTFMMTIgMTFMMTIgOUwxMSA5TDExIDhMMTAgOEwxMCA5TDkgOUw5IDEyTDExIDEyTDExIDEzTDEwIDEzTDEwIDE0TDkgMTRMOSAxM0w4IDEzTDggMTJMNyAxMkw3IDExTDYgMTFMNiAxMkw3IDEyTDcgMTNMNiAxM0w2IDE0TDcgMTRMNyAxNUw1IDE1TDUgMTRMNCAxNEw0IDEzTDUgMTNMNSAxMkw0IDEyTDQgMTNMMiAxM0wyIDE0TDMgMTRMMyAxNUw1IDE1TDUgMTZMMyAxNkwzIDE3TDIgMTdMMiAxOUwxIDE5TDEgMjFMMyAyMUwzIDE4TDQgMThMNCAyMUw1IDIxTDUgMjNMNCAyM0w0IDIyTDMgMjJMMyAyM0w0IDIzTDQgMjRMNSAyNEw1IDIzTDYgMjNMNiAyNEw3IDI0TDcgMjNMOCAyM0w4IDIyTDcgMjJMNyAyMUw5IDIxTDkgMjJMMTAgMjJMMTAgMjFMMTEgMjFMMTEgMjBMMTIgMjBMMTIgMjJMMTEgMjJMMTEgMjNMMTIgMjNMMTIgMjJMMTMgMjJMMTMgMjRMMTAgMjRMMTAgMjVMOSAyNUw5IDI0TDggMjRMOCAyNUw5IDI1TDkgMjZMMTEgMjZMMTEgMjdMMTAgMjdMMTAgMjhMOSAyOEw5IDMxTDEzIDMxTDEzIDI5TDE0IDI5TDE0IDI4TDE2IDI4TDE2IDI5TDE3IDI5TDE3IDI4TDE4IDI4TDE4IDI5TDIyIDI5TDIyIDMwTDIxIDMwTDIxIDMxTDIyIDMxTDIyIDMyTDIzIDMyTDIzIDMxTDI0IDMxTDI0IDI3TDIzIDI3TDIzIDI2TDI0IDI2TDI0IDI1TDIyIDI1TDIyIDI0TDIzIDI0TDIzIDIzTDI0IDIzTDI0IDI0TDI3IDI0TDI3IDIyTDI1IDIyTDI1IDIxTDI3IDIxTDI3IDIwTDI4IDIwTDI4IDE5TDI2IDE5TDI2IDE4TDI1IDE4TDI1IDE3TDI4IDE3TDI4IDE4TDI5IDE4TDI5IDE3TDMwIDE3TDMwIDE5TDI5IDE5TDI5IDIwTDMwIDIwTDMwIDIxTDI4IDIxTDI4IDI0TDMwIDI0TDMwIDIzTDI5IDIzTDI5IDIyTDMwIDIyTDMwIDIxTDMxIDIxTDMxIDIwTDMwIDIwTDMwIDE5TDMxIDE5TDMxIDE2TDMwIDE2TDMwIDE1TDI5IDE1TDI5IDEzTDI4IDEzTDI4IDE2TDI2IDE2TDI2IDE0TDI1IDE0TDI1IDEzTDI3IDEzTDI3IDEyTDI4IDEyTDI4IDExTDI3IDExTDI3IDEwTDI1IDEwTDI1IDlMMjQgOUwyNCAxMEwyMyAxMEwyMyA5TDIyIDlMMjIgOEwyMCA4TDIwIDlMMTkgOUwxOSA4TDE4IDhMMTggNUwxOSA1TDE5IDdMMjAgN0wyMCA1TDE5IDVMMTkgNEwyMSA0TDIxIDVMMjMgNUwyMyA0TDI0IDRMMjQgM0wxOSAzTDE5IDJMMjEgMkwyMSAxTDE5IDFMMTkgMkwxOCAyTDE4IDFMMTcgMUwxNyAyTDE1IDJMMTUgMVpNMjIgMUwyMiAyTDI0IDJMMjQgMVpNOSA2TDkgN0wxMCA3TDEwIDZaTTExIDZMMTEgN0wxMiA3TDEyIDZaTTE2IDZMMTYgN0wxNyA3TDE3IDZaTTIxIDZMMjEgN0wyMiA3TDIyIDZaTTI5IDhMMjkgOUwzMCA5TDMwIDhaTTMxIDhMMzEgMTBMMzMgMTBMMzMgOUwzMiA5TDMyIDhaTTEgOUwxIDExTDIgMTFMMiAxMkwzIDEyTDMgMTFMMiAxMUwyIDEwTDMgMTBMMyA5Wk02IDlMNiAxMEw3IDEwTDcgOVpNMTAgOUwxMCAxMUwxMSAxMUwxMSA5Wk0xNSA5TDE1IDExTDE0IDExTDE0IDE0TDE1IDE0TDE1IDE1TDE2IDE1TDE2IDE0TDE1IDE0TDE1IDEzTDE3IDEzTDE3IDE1TDE4IDE1TDE4IDE2TDE3IDE2TDE3IDE3TDE2IDE3TDE2IDE2TDE0IDE2TDE0IDE3TDEzIDE3TDEzIDE4TDEyIDE4TDEyIDIwTDEzIDIwTDEzIDIxTDE0IDIxTDE0IDIzTDE2IDIzTDE2IDI0TDE0IDI0TDE0IDI1TDE2IDI1TDE2IDI2TDE0IDI2TDE0IDI3TDE2IDI3TDE2IDI4TDE3IDI4TDE3IDI2TDE4IDI2TDE4IDI4TDIwIDI4TDIwIDI3TDIxIDI3TDIxIDI4TDIyIDI4TDIyIDI5TDIzIDI5TDIzIDI3TDIyIDI3TDIyIDI2TDIxIDI2TDIxIDI1TDE5IDI1TDE5IDI2TDE4IDI2TDE4IDI0TDE3IDI0TDE3IDIyTDE4IDIyTDE4IDIzTDE5IDIzTDE5IDIyTDIwIDIyTDIwIDIzTDIxIDIzTDIxIDI0TDIyIDI0TDIyIDIzTDIzIDIzTDIzIDIyTDI0IDIyTDI0IDIxTDIzIDIxTDIzIDIwTDI0IDIwTDI0IDE5TDI1IDE5TDI1IDE4TDI0IDE4TDI0IDE3TDI1IDE3TDI1IDE2TDI0IDE2TDI0IDE3TDIzIDE3TDIzIDE0TDI0IDE0TDI0IDEzTDIzIDEzTDIzIDEyTDI2IDEyTDI2IDExTDI1IDExTDI1IDEwTDI0IDEwTDI0IDExTDIxIDExTDIxIDEwTDIyIDEwTDIyIDlMMjAgOUwyMCAxMUwxOCAxMUwxOCAxMkwxNyAxMkwxNyA5Wk0xOCA5TDE4IDEwTDE5IDEwTDE5IDlaTTE1IDExTDE1IDEyTDE2IDEyTDE2IDExWk0zMCAxMUwzMCAxMkwzMSAxMkwzMSAxMVpNMTggMTJMMTggMTNMMTkgMTNMMTkgMTJaTTIwIDEyTDIwIDE0TDE5IDE0TDE5IDE3TDE3IDE3TDE3IDE5TDEzIDE5TDEzIDIwTDE0IDIwTDE0IDIxTDE1IDIxTDE1IDIwTDE2IDIwTDE2IDIxTDE3IDIxTDE3IDIwTDE4IDIwTDE4IDIxTDIwIDIxTDIwIDE5TDIyIDE5TDIyIDIwTDIxIDIwTDIxIDIxTDIyIDIxTDIyIDIwTDIzIDIwTDIzIDE5TDI0IDE5TDI0IDE4TDE5IDE4TDE5IDE3TDIyIDE3TDIyIDE2TDIwIDE2TDIwIDE0TDIxIDE0TDIxIDEzTDIyIDEzTDIyIDE0TDIzIDE0TDIzIDEzTDIyIDEzTDIyIDEyWk03IDEzTDcgMTRMOCAxNEw4IDEzWk0xMSAxM0wxMSAxNEwxMCAxNEwxMCAxNUw5IDE1TDkgMTZMMTEgMTZMMTEgMTRMMTIgMTRMMTIgMTZMMTMgMTZMMTMgMTRMMTIgMTRMMTIgMTNaTTUgMTZMNSAxN0w0IDE3TDQgMThMNSAxOEw1IDIwTDYgMjBMNiAyMUw3IDIxTDcgMjBMMTAgMjBMMTAgMTlMMTEgMTlMMTEgMTdMOCAxN0w4IDE2Wk0yOCAxNkwyOCAxN0wyOSAxN0wyOSAxNlpNNiAxN0w2IDE4TDggMThMOCAxOUwxMCAxOUwxMCAxOEw4IDE4TDggMTdaTTE0IDE3TDE0IDE4TDE2IDE4TDE2IDE3Wk0xOCAxOEwxOCAxOUwxOSAxOUwxOSAxOFpNNiAxOUw2IDIwTDcgMjBMNyAxOVpNNiAyMkw2IDIzTDcgMjNMNyAyMlpNMTEgMjVMMTEgMjZMMTIgMjZMMTIgMjdMMTEgMjdMMTEgMjhMMTIgMjhMMTIgMjlMMTMgMjlMMTMgMjhMMTIgMjhMMTIgMjdMMTMgMjdMMTMgMjZMMTIgMjZMMTIgMjVaTTI1IDI1TDI1IDI4TDI4IDI4TDI4IDI1Wk0yOSAyNUwyOSAyOEwzMCAyOEwzMCAyN0wzMSAyN0wzMSAyNkwzMCAyNkwzMCAyNVpNMTkgMjZMMTkgMjdMMjAgMjdMMjAgMjZaTTI2IDI2TDI2IDI3TDI3IDI3TDI3IDI2Wk0xMCAyOUwxMCAzMEwxMSAzMEwxMSAyOVpNMjUgMjlMMjUgMzBMMjggMzBMMjggMzFMMjkgMzFMMjkgMzBMMjggMzBMMjggMjlaTTIyIDMwTDIyIDMxTDIzIDMxTDIzIDMwWk0zMCAzMEwzMCAzMUwzMSAzMUwzMSAzMFpNMTkgMzJMMTkgMzNMMjAgMzNMMjAgMzJaTTAgMEwwIDdMNyA3TDcgMFpNMSAxTDEgNkw2IDZMNiAxWk0yIDJMMiA1TDUgNUw1IDJaTTI2IDBMMjYgN0wzMyA3TDMzIDBaTTI3IDFMMjcgNkwzMiA2TDMyIDFaTTI4IDJMMjggNUwzMSA1TDMxIDJaTTAgMjZMMCAzM0w3IDMzTDcgMjZaTTEgMjdMMSAzMkw2IDMyTDYgMjdaTTIgMjhMMiAzMUw1IDMxTDUgMjhaIiBmaWxsPSIjMDAwMDAwIi8+PC9nPjwvZz48L3N2Zz4K', 'OfyxDj1ixkmgwCb7H3SQkPN4DJKFrxPb', 'active', '[{\"content\":\"rawr\",\"date\":\"2026-06-09 16:14:00\"},{\"content\":\"ya tambah lagi\",\"date\":\"2026-06-14 22:50:39\"}]'),
(2, 46, 1, 2, 90.00, 90.00, 100.00, 80.00, 80.00, 0.00, 88.00, NULL, 1, '2026-06-18', '2026-06-18 11:24:56', '2026-06-20 05:00:19', 'CERT-202606-AK5DLW', '2026-06-18', 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2ZmZmZmZiIvPjxnIHRyYW5zZm9ybT0ic2NhbGUoMy4wMykiPjxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsMCkiPjxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTggMEw4IDFMOSAxTDkgMkw4IDJMOCA1TDkgNUw5IDRMMTEgNEwxMSA1TDEwIDVMMTAgMTBMOSAxMEw5IDhMOCA4TDggOUw3IDlMNyA4TDYgOEw2IDlMNSA5TDUgMTBMNCAxMEw0IDhMMCA4TDAgMTNMMSAxM0wxIDEyTDIgMTJMMiAxM0w0IDEzTDQgMTRMNiAxNEw2IDE1TDcgMTVMNyAxNkwzIDE2TDMgMTRMMCAxNEwwIDE1TDIgMTVMMiAxNkwzIDE2TDMgMTdMMCAxN0wwIDE4TDEgMThMMSAyMEwwIDIwTDAgMjJMMiAyMkwyIDIzTDEgMjNMMSAyNEwwIDI0TDAgMjVMMSAyNUwxIDI0TDQgMjRMNCAyNUw3IDI1TDcgMjRMOSAyNEw5IDI1TDggMjVMOCAyNkwxMCAyNkwxMCAyOUwxMSAyOUwxMSAzMEwxMCAzMEwxMCAzMUwxMSAzMUwxMSAzMEwxMiAzMEwxMiAzM0wxMyAzM0wxMyAzMUwxNCAzMUwxNCAzMEwxMiAzMEwxMiAyOUwxNCAyOUwxNCAyOEwxMyAyOEwxMyAyN0wxNCAyN0wxNCAyNkwxNiAyNkwxNiAyOUwxNSAyOUwxNSAzMkwxNCAzMkwxNCAzM0wxOSAzM0wxOSAzMkwxOCAzMkwxOCAzMUwxOSAzMUwxOSAzMEwxOCAzMEwxOCAyOUwxOSAyOUwxOSAyOEwyMCAyOEwyMCAzMkwyMSAzMkwyMSAzM0wyMiAzM0wyMiAzMkwyMSAzMkwyMSAyOUwyMiAyOUwyMiAzMUwyMyAzMUwyMyAyOUwyNSAyOUwyNSAzMEwyNCAzMEwyNCAzMkwyNSAzMkwyNSAzM0wyNiAzM0wyNiAzMkwyNyAzMkwyNyAzM0wyOCAzM0wyOCAzMkwzMCAzMkwzMCAzM0wzMSAzM0wzMSAzMkwzMCAzMkwzMCAyOUwzMSAyOUwzMSAzMUwzMiAzMUwzMiAzMkwzMyAzMkwzMyAzMUwzMiAzMUwzMiAyOUwzMSAyOUwzMSAyOEwzMiAyOEwzMiAyN0wzMSAyN0wzMSAyNkwzMCAyNkwzMCAyNEwyOSAyNEwyOSAyM0wyOCAyM0wyOCAyNEwyNiAyNEwyNiAyM0wyNyAyM0wyNyAyMkwyOCAyMkwyOCAyMUwyNiAyMUwyNiAyMEwyOSAyMEwyOSAyMUwzMCAyMUwzMCAyMkwzMSAyMkwzMSAyNEwzMiAyNEwzMiAyNUwzMyAyNUwzMyAyNEwzMiAyNEwzMiAyM0wzMyAyM0wzMyAyMUwzMSAyMUwzMSAyMEwzMCAyMEwzMCAxOEwzMSAxOEwzMSAxOUwzMiAxOUwzMiAyMEwzMyAyMEwzMyAxOUwzMiAxOUwzMiAxOEwzMyAxOEwzMyAxNkwzMSAxNkwzMSAxNEwzMiAxNEwzMiAxM0wzMCAxM0wzMCAxNEwyOCAxNEwyOCAxNUwyNyAxNUwyNyAxNEwyNiAxNEwyNiAxM0wyNCAxM0wyNCAxNUwyNiAxNUwyNiAyMEwyNSAyMEwyNSAxN0wyNCAxN0wyNCAxNkwyMyAxNkwyMyAxNUwyMSAxNUwyMSAxM0wyMCAxM0wyMCAxMkwyMSAxMkwyMSAxMUwyMiAxMUwyMiA4TDIzIDhMMjMgMTJMMjIgMTJMMjIgMTNMMjMgMTNMMjMgMTJMMjQgMTJMMjQgN0wyNSA3TDI1IDJMMjQgMkwyNCAwTDIyIDBMMjIgMUwyMyAxTDIzIDNMMjQgM0wyNCA3TDIzIDdMMjMgNkwyMiA2TDIyIDhMMjEgOEwyMSA1TDIyIDVMMjIgNEwyMSA0TDIxIDNMMjAgM0wyMCAyTDIxIDJMMjEgMEwyMCAwTDIwIDJMMTkgMkwxOSAxTDE4IDFMMTggM0wxOSAzTDE5IDRMMTggNEwxOCA1TDE3IDVMMTcgNEwxNiA0TDE2IDNMMTQgM0wxNCAyTDE1IDJMMTUgMEwxMiAwTDEyIDFMMTEgMUwxMSAwTDEwIDBMMTAgMUw5IDFMOSAwWk0xMyAxTDEzIDJMMTEgMkwxMSA0TDEyIDRMMTIgM0wxMyAzTDEzIDVMMTIgNUwxMiA2TDExIDZMMTEgOEwxMiA4TDEyIDlMMTEgOUwxMSAxMEwxMiAxMEwxMiA5TDEzIDlMMTMgOEwxNSA4TDE1IDlMMTQgOUwxNCAxMEwxMyAxMEwxMyAxMUwxMSAxMUwxMSAxMkwxMiAxMkwxMiAxM0wxMCAxM0wxMCAxNEw5IDE0TDkgMThMOCAxOEw4IDE2TDcgMTZMNyAxN0w2IDE3TDYgMThMNSAxOEw1IDE3TDMgMTdMMyAxOEwyIDE4TDIgMTlMMyAxOUwzIDIwTDIgMjBMMiAyMkw0IDIyTDQgMjRMNSAyNEw1IDIwTDcgMjBMNyAyMUw2IDIxTDYgMjJMNyAyMkw3IDIzTDYgMjNMNiAyNEw3IDI0TDcgMjNMOCAyM0w4IDIyTDcgMjJMNyAyMUw4IDIxTDggMjBMOSAyMEw5IDE5TDEwIDE5TDEwIDIwTDExIDIwTDExIDIxTDEwIDIxTDEwIDIyTDkgMjJMOSAyNEwxMSAyNEwxMSAyMkwxMiAyMkwxMiAyM0wxMyAyM0wxMyAyMkwxNCAyMkwxNCAyMUwxNSAyMUwxNSAyM0wxNCAyM0wxNCAyNEwxMyAyNEwxMyAyNUwxNCAyNUwxNCAyNEwxNSAyNEwxNSAyM0wxNyAyM0wxNyAyNUwyMCAyNUwyMCAyNkwyMSAyNkwyMSAyN0wyMCAyN0wyMCAyOEwyMSAyOEwyMSAyN0wyMiAyN0wyMiAyNkwyMyAyNkwyMyAyNUwyMiAyNUwyMiAyMkwxOSAyMkwxOSAyMUwxOCAyMUwxOCAyM0wxNyAyM0wxNyAyMkwxNiAyMkwxNiAyMUwxNyAyMUwxNyAxN0wxNSAxN0wxNSAxNUwxNiAxNUwxNiAxNkwxOSAxNkwxOSAxN0wxOCAxN0wxOCAxOEwxOSAxOEwxOSAyMEwyMiAyMEwyMiAyMUwyNCAyMUwyNCAyMkwyNSAyMkwyNSAyM0wyNiAyM0wyNiAyMkwyNSAyMkwyNSAyMUwyNCAyMUwyNCAxOEwyMyAxOEwyMyAxN0wyMSAxN0wyMSAxOEwyMCAxOEwyMCAxNUwxOSAxNUwxOSAxNEwxNyAxNEwxNyAxNUwxNiAxNUwxNiAxNEwxNSAxNEwxNSAxM0wxNyAxM0wxNyAxMkwxOCAxMkwxOCAxMUwxOSAxMUwxOSAxMkwyMCAxMkwyMCAxMUwyMSAxMUwyMSAxMEwyMCAxMEwyMCA2TDE5IDZMMTkgNUwyMSA1TDIxIDRMMTkgNEwxOSA1TDE4IDVMMTggNkwxNyA2TDE3IDVMMTYgNUwxNiA0TDE0IDRMMTQgM0wxMyAzTDEzIDJMMTQgMkwxNCAxWk0xNiAxTDE2IDJMMTcgMkwxNyAxWk0xMyA1TDEzIDZMMTIgNkwxMiA4TDEzIDhMMTMgNkwxNCA2TDE0IDdMMTUgN0wxNSA4TDE2IDhMMTYgN0wxNyA3TDE3IDlMMTUgOUwxNSAxMEwxNiAxMEwxNiAxMUwxOCAxMUwxOCA3TDE5IDdMMTkgNkwxOCA2TDE4IDdMMTcgN0wxNyA2TDE2IDZMMTYgN0wxNSA3TDE1IDZMMTQgNkwxNCA1Wk04IDZMOCA3TDkgN0w5IDZaTTI1IDhMMjUgMTBMMjYgMTBMMjYgMTFMMjcgMTFMMjcgMTNMMjkgMTNMMjkgMTJMMjggMTJMMjggMTFMMzEgMTFMMzEgMTJMMzIgMTJMMzIgMTFMMzMgMTFMMzMgOEwzMiA4TDMyIDlMMzEgOUwzMSA4TDI4IDhMMjggOUwyNiA5TDI2IDhaTTEgOUwxIDEwTDIgMTBMMiAxMUwzIDExTDMgMTBMMiAxMEwyIDlaTTYgOUw2IDEwTDUgMTBMNSAxMUw2IDExTDYgMTJMOCAxMkw4IDExTDYgMTFMNiAxMEw3IDEwTDcgOVpNMjggOUwyOCAxMEwyNyAxMEwyNyAxMUwyOCAxMUwyOCAxMEwzMSAxMEwzMSAxMUwzMiAxMUwzMiAxMEwzMSAxMEwzMSA5Wk0xMyAxMUwxMyAxM0wxMiAxM0wxMiAxNEwxMyAxNEwxMyAxNUwxNCAxNUwxNCAxNEwxMyAxNEwxMyAxM0wxNCAxM0wxNCAxMkwxNSAxMkwxNSAxMVpNNCAxMkw0IDEzTDUgMTNMNSAxMlpNNiAxM0w2IDE0TDggMTRMOCAxM1pNMTAgMTVMMTAgMTlMMTEgMTlMMTEgMThMMTIgMThMMTIgMjBMMTMgMjBMMTMgMTlMMTYgMTlMMTYgMThMMTIgMThMMTIgMTdMMTQgMTdMMTQgMTZMMTIgMTZMMTIgMTVaTTI4IDE1TDI4IDE2TDMwIDE2TDMwIDE1Wk0yNyAxN0wyNyAxOEwyOCAxOEwyOCAxN1pNMzEgMTdMMzEgMThMMzIgMThMMzIgMTdaTTMgMThMMyAxOUw1IDE5TDUgMThaTTYgMThMNiAxOUw3IDE5TDcgMThaTTE4IDIzTDE4IDI0TDIwIDI0TDIwIDIzWk0yMSAyNUwyMSAyNkwyMiAyNkwyMiAyNVpNMjUgMjVMMjUgMjhMMjggMjhMMjggMjVaTTExIDI2TDExIDI4TDEyIDI4TDEyIDI2Wk0xNyAyNkwxNyAyOUwxNiAyOUwxNiAzMkwxNyAzMkwxNyAzMUwxOCAzMUwxOCAzMEwxNyAzMEwxNyAyOUwxOCAyOUwxOCAyN0wxOSAyN0wxOSAyNlpNMjYgMjZMMjYgMjdMMjcgMjdMMjcgMjZaTTI5IDI2TDI5IDI5TDI4IDI5TDI4IDMxTDI3IDMxTDI3IDMyTDI4IDMyTDI4IDMxTDI5IDMxTDI5IDI5TDMwIDI5TDMwIDI2Wk0yMyAyN0wyMyAyOEwyNCAyOEwyNCAyN1pNOCAyOUw4IDMzTDkgMzNMOSAyOVpNMjYgMjlMMjYgMzBMMjcgMzBMMjcgMjlaTTI1IDMxTDI1IDMyTDI2IDMyTDI2IDMxWk0xMCAzMkwxMCAzM0wxMSAzM0wxMSAzMlpNMCAwTDAgN0w3IDdMNyAwWk0xIDFMMSA2TDYgNkw2IDFaTTIgMkwyIDVMNSA1TDUgMlpNMjYgMEwyNiA3TDMzIDdMMzMgMFpNMjcgMUwyNyA2TDMyIDZMMzIgMVpNMjggMkwyOCA1TDMxIDVMMzEgMlpNMCAyNkwwIDMzTDcgMzNMNyAyNlpNMSAyN0wxIDMyTDYgMzJMNiAyN1pNMiAyOEwyIDMxTDUgMzFMNSAyOFoiIGZpbGw9IiMwMDAwMDAiLz48L2c+PC9nPjwvc3ZnPgo=', 'YXWZ91KyPhjvrpXmSE8QM0o2Hkv1NF6y', 'active', NULL),
(3, 50, 2, 2, 90.00, 90.00, 80.00, 70.00, 80.00, 100.00, 82.00, NULL, 1, '2026-06-18', '2026-06-18 14:58:45', '2026-06-20 10:07:43', 'CERT-202606-YAKXJK', '2026-06-20', 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2ZmZmZmZiIvPjxnIHRyYW5zZm9ybT0ic2NhbGUoMy4wMykiPjxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsMCkiPjxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTEwIDBMMTAgMkwxMSAyTDExIDBaTTEyIDBMMTIgMUwxMyAxTDEzIDJMMTIgMkwxMiA0TDE0IDRMMTQgNUwxMSA1TDExIDZMMTAgNkwxMCA0TDExIDRMMTEgM0w4IDNMOCA0TDkgNEw5IDVMOCA1TDggN0w5IDdMOSA4TDYgOEw2IDlMMTAgOUwxMCAxMUwxMSAxMUwxMSA5TDEyIDlMMTIgMTBMMTUgMTBMMTUgMTFMMTcgMTFMMTcgMTBMMTUgMTBMMTUgOEwxNiA4TDE2IDlMMTkgOUwxOSAxMEwyMCAxMEwyMCAxMUwxOCAxMUwxOCAxMkwxNCAxMkwxNCAxM0wxNyAxM0wxNyAxNEwxOCAxNEwxOCAxNkwxNyAxNkwxNyAxN0wxNSAxN0wxNSAxNkwxNiAxNkwxNiAxNEwxNCAxNEwxNCAxN0wxMyAxN0wxMyAxNkwxMiAxNkwxMiAxN0wxMyAxN0wxMyAxOEwxMiAxOEwxMiAxOUwxNCAxOUwxNCAxOEwxNSAxOEwxNSAyMEwxNCAyMEwxNCAyMUwxNiAyMUwxNiAyMkwxNCAyMkwxNCAyM0wxNiAyM0wxNiAyNEwxNyAyNEwxNyAyM0wxNiAyM0wxNiAyMkwxNyAyMkwxNyAyMUwxNiAyMUwxNiAyMEwxNyAyMEwxNyAxOUwxNiAxOUwxNiAxOEwxNyAxOEwxNyAxN0wxOCAxN0wxOCAxNkwxOSAxNkwxOSAxNEwyMCAxNEwyMCAxNkwyMiAxNkwyMiAxN0wxOSAxN0wxOSAxOEwyNCAxOEwyNCAxOUwyMyAxOUwyMyAyMEwyMiAyMEwyMiAxOUwyMCAxOUwyMCAyMUwxOCAyMUwxOCAyM0wxOSAyM0wxOSAyMkwyMCAyMkwyMCAyM0wyMSAyM0wyMSAyNEwyMiAyNEwyMiAyNUwyNCAyNUwyNCAyNkwyMyAyNkwyMyAyN0wyMiAyN0wyMiAyNkwyMSAyNkwyMSAyNUwxNSAyNUwxNSAyNEwxNCAyNEwxNCAyNkwxNSAyNkwxNSAyN0wxNCAyN0wxNCAyOEwxMyAyOEwxMyAyOUwxMSAyOUwxMSAyOEwxMiAyOEwxMiAyN0wxMSAyN0wxMSAyOEwxMCAyOEwxMCAzMUw5IDMxTDkgMjhMOCAyOEw4IDMzTDEwIDMzTDEwIDMyTDExIDMyTDExIDMwTDEyIDMwTDEyIDMxTDEzIDMxTDEzIDMwTDE1IDMwTDE1IDMxTDE5IDMxTDE5IDMwTDIwIDMwTDIwIDMxTDIxIDMxTDIxIDMyTDIyIDMyTDIyIDMzTDIzIDMzTDIzIDMyTDI0IDMyTDI0IDMzTDI1IDMzTDI1IDMyTDI0IDMyTDI0IDMxTDI3IDMxTDI3IDMyTDI4IDMyTDI4IDMzTDI5IDMzTDI5IDMxTDMwIDMxTDMwIDMyTDMxIDMyTDMxIDMzTDMyIDMzTDMyIDMyTDMxIDMyTDMxIDMxTDMyIDMxTDMyIDMwTDMxIDMwTDMxIDI5TDMwIDI5TDMwIDI4TDMyIDI4TDMyIDI5TDMzIDI5TDMzIDI4TDMyIDI4TDMyIDI2TDMzIDI2TDMzIDI0TDMyIDI0TDMyIDI2TDMxIDI2TDMxIDI1TDMwIDI1TDMwIDI0TDMxIDI0TDMxIDIzTDMyIDIzTDMyIDIyTDMzIDIyTDMzIDIxTDMyIDIxTDMyIDIwTDMxIDIwTDMxIDE5TDMyIDE5TDMyIDE4TDMzIDE4TDMzIDE3TDMyIDE3TDMyIDE2TDMxIDE2TDMxIDE1TDMyIDE1TDMyIDE0TDMzIDE0TDMzIDEzTDMxIDEzTDMxIDE1TDMwIDE1TDMwIDEzTDI5IDEzTDI5IDEwTDI4IDEwTDI4IDhMMjcgOEwyNyA5TDI2IDlMMjYgOEwyNSA4TDI1IDZMMjQgNkwyNCA4TDIzIDhMMjMgNUwyNCA1TDI0IDRMMjUgNEwyNSAzTDI0IDNMMjQgMkwyNSAyTDI1IDFMMjQgMUwyNCAwTDIyIDBMMjIgMUwyMSAxTDIxIDJMMjAgMkwyMCAzTDE5IDNMMTkgMkwxOCAyTDE4IDNMMTcgM0wxNyAyTDE2IDJMMTYgMUwxNyAxTDE3IDBMMTYgMEwxNiAxTDE1IDFMMTUgMEwxNCAwTDE0IDFMMTMgMUwxMyAwWk0xOSAwTDE5IDFMMjAgMUwyMCAwWk04IDFMOCAyTDkgMkw5IDFaTTE0IDFMMTQgMkwxMyAyTDEzIDNMMTQgM0wxNCA0TDE1IDRMMTUgNUwxNCA1TDE0IDZMMTMgNkwxMyA3TDEyIDdMMTIgNkwxMSA2TDExIDdMMTIgN0wxMiA4TDEzIDhMMTMgOUwxNCA5TDE0IDZMMTUgNkwxNSA3TDE2IDdMMTYgOEwxOCA4TDE4IDVMMTkgNUwxOSA4TDIwIDhMMjAgOUwyMiA5TDIyIDEwTDIxIDEwTDIxIDExTDI0IDExTDI0IDEwTDI1IDEwTDI1IDExTDI2IDExTDI2IDEyTDIzIDEyTDIzIDEzTDIyIDEzTDIyIDEyTDIwIDEyTDIwIDE0TDIxIDE0TDIxIDEzTDIyIDEzTDIyIDE0TDIzIDE0TDIzIDE3TDI0IDE3TDI0IDE4TDI1IDE4TDI1IDE5TDI0IDE5TDI0IDIwTDIzIDIwTDIzIDIxTDI0IDIxTDI0IDIyTDIzIDIyTDIzIDIzTDIyIDIzTDIyIDI0TDIzIDI0TDIzIDIzTDI0IDIzTDI0IDI0TDI3IDI0TDI3IDIyTDI1IDIyTDI1IDIxTDI3IDIxTDI3IDIwTDI4IDIwTDI4IDE5TDI2IDE5TDI2IDE4TDI1IDE4TDI1IDE3TDI4IDE3TDI4IDE4TDI5IDE4TDI5IDE3TDMwIDE3TDMwIDE5TDI5IDE5TDI5IDIwTDMwIDIwTDMwIDIxTDI4IDIxTDI4IDI0TDMwIDI0TDMwIDIzTDI5IDIzTDI5IDIyTDMwIDIyTDMwIDIxTDMxIDIxTDMxIDIwTDMwIDIwTDMwIDE5TDMxIDE5TDMxIDE2TDMwIDE2TDMwIDE1TDI5IDE1TDI5IDEzTDI4IDEzTDI4IDE2TDI2IDE2TDI2IDE0TDI1IDE0TDI1IDEzTDI3IDEzTDI3IDEyTDI4IDEyTDI4IDExTDI3IDExTDI3IDEwTDI1IDEwTDI1IDlMMjQgOUwyNCAxMEwyMyAxMEwyMyA5TDIyIDlMMjIgOEwyMSA4TDIxIDdMMjIgN0wyMiA2TDIxIDZMMjEgN0wyMCA3TDIwIDRMMjEgNEwyMSA1TDIzIDVMMjMgNEwyNCA0TDI0IDNMMjAgM0wyMCA0TDE4IDRMMTggNUwxNyA1TDE3IDdMMTYgN0wxNiA2TDE1IDZMMTUgNUwxNiA1TDE2IDRMMTcgNEwxNyAzTDE2IDNMMTYgMkwxNSAyTDE1IDFaTTIyIDFMMjIgMkwyNCAyTDI0IDFaTTE0IDJMMTQgM0wxNSAzTDE1IDJaTTkgNkw5IDdMMTAgN0wxMCA2Wk0wIDhMMCAxMkwxIDEyTDEgMTRMMiAxNEwyIDEzTDMgMTNMMyAxMkw0IDEyTDQgMTBMNSAxMEw1IDEyTDYgMTJMNiAxM0w0IDEzTDQgMTRMNiAxNEw2IDE1TDcgMTVMNyAxNkw2IDE2TDYgMTdMNSAxN0w1IDE2TDQgMTZMNCAxNUwwIDE1TDAgMTdMMSAxN0wxIDE2TDMgMTZMMyAxN0wyIDE3TDIgMjBMMCAyMEwwIDI1TDEgMjVMMSAyMUwzIDIxTDMgMjJMMiAyMkwyIDIzTDQgMjNMNCAyNUw1IDI1TDUgMjNMNyAyM0w3IDI0TDYgMjRMNiAyNUw3IDI1TDcgMjRMOCAyNEw4IDIzTDcgMjNMNyAyMkw1IDIyTDUgMjNMNCAyM0w0IDIxTDMgMjFMMyAxOUw1IDE5TDUgMjBMNiAyMEw2IDIxTDcgMjFMNyAyMEw4IDIwTDggMjFMOSAyMUw5IDIwTDEwIDIwTDEwIDIyTDEyIDIyTDEyIDI0TDEzIDI0TDEzIDIyTDEyIDIyTDEyIDIxTDExIDIxTDExIDIwTDEwIDIwTDEwIDE5TDExIDE5TDExIDE3TDEwIDE3TDEwIDE2TDkgMTZMOSAxNUw4IDE1TDggMTRMOSAxNEw5IDEzTDExIDEzTDExIDE0TDEwIDE0TDEwIDE1TDExIDE1TDExIDE0TDEyIDE0TDEyIDEzTDEzIDEzTDEzIDExTDEyIDExTDEyIDEyTDkgMTJMOSAxM0w4IDEzTDggMTRMNiAxNEw2IDEzTDcgMTNMNyAxMkw4IDEyTDggMTFMOSAxMUw5IDEwTDggMTBMOCAxMUw3IDExTDcgMTBMNSAxMEw1IDhaTTEwIDhMMTAgOUwxMSA5TDExIDhaTTI5IDhMMjkgOUwzMCA5TDMwIDhaTTMxIDhMMzEgMTBMMzMgMTBMMzMgOUwzMiA5TDMyIDhaTTEgOUwxIDEyTDIgMTJMMiAxMUwzIDExTDMgMTBMNCAxMEw0IDlaTTYgMTFMNiAxMkw3IDEyTDcgMTFaTTMwIDExTDMwIDEyTDMxIDEyTDMxIDExWk0xOCAxMkwxOCAxNEwxOSAxNEwxOSAxMlpNMjMgMTNMMjMgMTRMMjQgMTRMMjQgMTNaTTggMTZMOCAxN0w2IDE3TDYgMThMNyAxOEw3IDE5TDYgMTlMNiAyMEw3IDIwTDcgMTlMOCAxOUw4IDE4TDkgMThMOSAxNlpNMjQgMTZMMjQgMTdMMjUgMTdMMjUgMTZaTTI4IDE2TDI4IDE3TDI5IDE3TDI5IDE2Wk0zIDE3TDMgMThMNSAxOEw1IDE3Wk0xOCAxOUwxOCAyMEwxOSAyMEwxOSAxOVpNMjEgMjBMMjEgMjFMMjIgMjFMMjIgMjBaTTkgMjNMOSAyNEwxMSAyNEwxMSAyM1pNOCAyNUw4IDI3TDkgMjdMOSAyNkwxMyAyNkwxMyAyNVpNMjUgMjVMMjUgMjhMMjggMjhMMjggMjVaTTI5IDI1TDI5IDI4TDMwIDI4TDMwIDI3TDMxIDI3TDMxIDI2TDMwIDI2TDMwIDI1Wk0xNiAyNkwxNiAyN0wxNSAyN0wxNSAyOEwxNCAyOEwxNCAyOUwxNSAyOUwxNSAyOEwxNiAyOEwxNiAyOUwxNyAyOUwxNyAyOEwxOCAyOEwxOCAyOUwyMiAyOUwyMiAzMEwyMSAzMEwyMSAzMUwyMiAzMUwyMiAzMkwyMyAzMkwyMyAzMUwyNCAzMUwyNCAyN0wyMyAyN0wyMyAyOUwyMiAyOUwyMiAyOEwyMSAyOEwyMSAyN0wyMCAyN0wyMCAyNkwxOSAyNkwxOSAyN0wyMCAyN0wyMCAyOEwxOCAyOEwxOCAyN0wxNyAyN0wxNyAyNlpNMjYgMjZMMjYgMjdMMjcgMjdMMjcgMjZaTTI1IDI5TDI1IDMwTDI4IDMwTDI4IDMxTDI5IDMxTDI5IDMwTDI4IDMwTDI4IDI5Wk0yMiAzMEwyMiAzMUwyMyAzMUwyMyAzMFpNMzAgMzBMMzAgMzFMMzEgMzFMMzEgMzBaTTEzIDMyTDEzIDMzTDE4IDMzTDE4IDMyWk0xOSAzMkwxOSAzM0wyMCAzM0wyMCAzMlpNMCAwTDAgN0w3IDdMNyAwWk0xIDFMMSA2TDYgNkw2IDFaTTIgMkwyIDVMNSA1TDUgMlpNMjYgMEwyNiA3TDMzIDdMMzMgMFpNMjcgMUwyNyA2TDMyIDZMMzIgMVpNMjggMkwyOCA1TDMxIDVMMzEgMlpNMCAyNkwwIDMzTDcgMzNMNyAyNlpNMSAyN0wxIDMyTDYgMzJMNiAyN1pNMiAyOEwyIDMxTDUgMzFMNSAyOFoiIGZpbGw9IiMwMDAwMDAiLz48L2c+PC9nPjwvc3ZnPgo=', 'iL484xtAJksBNdH39ns3XEZDQ8t70tEi', 'active', NULL),
(4, 56, 1, 2, 90.00, 80.00, 80.00, 70.00, 78.00, 100.00, 79.60, NULL, 1, '2026-06-24', '2026-06-23 22:18:15', '2026-06-23 22:19:39', 'CERT-202606-RWD30Y', '2026-06-24', 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2ZmZmZmZiIvPjxnIHRyYW5zZm9ybT0ic2NhbGUoMy4wMykiPjxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsMCkiPjxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTEwIDBMMTAgMkwxMSAyTDExIDBaTTEyIDBMMTIgMUwxNCAxTDE0IDBaTTE1IDBMMTUgMkwxNiAyTDE2IDNMMTcgM0wxNyAyTDE5IDJMMTkgM0wyMCAzTDIwIDRMMTggNEwxOCA1TDE3IDVMMTcgNEwxNiA0TDE2IDVMMTQgNUwxNCA4TDEyIDhMMTIgN0wxMyA3TDEzIDVMMTEgNUwxMSA2TDEwIDZMMTAgNEwxMSA0TDExIDNMOCAzTDggNEw5IDRMOSA1TDggNUw4IDdMOSA3TDkgOEw2IDhMNiA5TDcgOUw3IDEwTDYgMTBMNiAxMUw3IDExTDcgMTJMNSAxMkw1IDEwTDMgMTBMMyA5TDUgOUw1IDhMMCA4TDAgMTBMMSAxMEwxIDExTDAgMTFMMCAxNUwyIDE1TDIgMTdMMSAxN0wxIDE2TDAgMTZMMCAxN0wxIDE3TDEgMThMMCAxOEwwIDE5TDEgMTlMMSAyMEwwIDIwTDAgMjVMMSAyNUwxIDIwTDIgMjBMMiAxOUwxIDE5TDEgMThMMiAxOEwyIDE3TDQgMTdMNCAxOUw1IDE5TDUgMTdMNyAxN0w3IDE2TDkgMTZMOSAxOUw4IDE5TDggMjFMOSAyMUw5IDE5TDEwIDE5TDEwIDE2TDExIDE2TDExIDE4TDEyIDE4TDEyIDE3TDE0IDE3TDE0IDIwTDEyIDIwTDEyIDE5TDExIDE5TDExIDIwTDEwIDIwTDEwIDIxTDExIDIxTDExIDIyTDEyIDIyTDEyIDIxTDEzIDIxTDEzIDIzTDEyIDIzTDEyIDI1TDExIDI1TDExIDI0TDEwIDI0TDEwIDIyTDggMjJMOCAyM0w5IDIzTDkgMjRMNiAyNEw2IDI1TDggMjVMOCAyN0w5IDI3TDkgMjRMMTAgMjRMMTAgMjVMMTEgMjVMMTEgMjZMMTIgMjZMMTIgMjhMMTMgMjhMMTMgMjZMMTIgMjZMMTIgMjVMMTQgMjVMMTQgMjZMMTUgMjZMMTUgMjdMMTQgMjdMMTQgMjlMMTUgMjlMMTUgMzBMMTQgMzBMMTQgMzFMMTUgMzFMMTUgMzNMMTYgMzNMMTYgMzFMMTggMzFMMTggMzBMMjAgMzBMMjAgMzFMMjEgMzFMMjEgMzJMMjIgMzJMMjIgMzNMMjMgMzNMMjMgMzJMMjQgMzJMMjQgMzNMMjUgMzNMMjUgMzJMMjQgMzJMMjQgMzFMMjcgMzFMMjcgMzJMMjggMzJMMjggMzNMMjkgMzNMMjkgMzFMMzAgMzFMMzAgMzJMMzEgMzJMMzEgMzNMMzIgMzNMMzIgMzJMMzEgMzJMMzEgMzFMMzIgMzFMMzIgMzBMMzEgMzBMMzEgMjlMMzAgMjlMMzAgMjhMMzIgMjhMMzIgMjlMMzMgMjlMMzMgMjhMMzIgMjhMMzIgMjZMMzMgMjZMMzMgMjRMMzIgMjRMMzIgMjZMMzEgMjZMMzEgMjVMMzAgMjVMMzAgMjRMMzEgMjRMMzEgMjNMMzIgMjNMMzIgMjJMMzMgMjJMMzMgMjFMMzIgMjFMMzIgMjBMMzEgMjBMMzEgMTlMMzIgMTlMMzIgMThMMzMgMThMMzMgMTdMMzIgMTdMMzIgMTZMMzEgMTZMMzEgMTVMMzIgMTVMMzIgMTRMMzMgMTRMMzMgMTNMMzEgMTNMMzEgMTVMMzAgMTVMMzAgMTNMMjkgMTNMMjkgMTBMMjggMTBMMjggOEwyNyA4TDI3IDlMMjYgOUwyNiA4TDI1IDhMMjUgNkwyNCA2TDI0IDhMMjMgOEwyMyA1TDI0IDVMMjQgNEwyNSA0TDI1IDNMMjQgM0wyNCAyTDI1IDJMMjUgMUwyNCAxTDI0IDBMMjIgMEwyMiAxTDIxIDFMMjEgMFpNOCAxTDggMkw5IDJMOSAxWk0xNiAxTDE2IDJMMTcgMkwxNyAxWk0xOSAxTDE5IDJMMjEgMkwyMSAxWk0yMiAxTDIyIDJMMjQgMkwyNCAxWk0xMiAyTDEyIDRMMTMgNEwxMyAyWk0xNCAzTDE0IDRMMTUgNEwxNSAzWk0yMSAzTDIxIDRMMjAgNEwyMCA1TDE4IDVMMTggNkwxNyA2TDE3IDVMMTYgNUwxNiA2TDE1IDZMMTUgMTBMMTYgMTBMMTYgMTFMMTcgMTFMMTcgMTJMMTggMTJMMTggMTNMMTcgMTNMMTcgMTZMMTYgMTZMMTYgMTVMMTUgMTVMMTUgMTRMMTYgMTRMMTYgMTNMMTUgMTNMMTUgMTRMMTQgMTRMMTQgMTNMMTIgMTNMMTIgMTJMMTEgMTJMMTEgMTFMMTIgMTFMMTIgOUwxMSA5TDExIDhMMTAgOEwxMCA5TDggOUw4IDEyTDcgMTJMNyAxM0w2IDEzTDYgMTRMOCAxNEw4IDE1TDkgMTVMOSAxNkwxMCAxNkwxMCAxNUwxMiAxNUwxMiAxNEwxMyAxNEwxMyAxNkwxNSAxNkwxNSAxOEwxNiAxOEwxNiAxN0wxNyAxN0wxNyAxOEwxOSAxOEwxOSAxOUwxNSAxOUwxNSAyMEwxNiAyMEwxNiAyMUwxNCAyMUwxNCAyM0wxMyAyM0wxMyAyNEwxNCAyNEwxNCAyNUwxNyAyNUwxNyAyNkwxOCAyNkwxOCAyNUwyMSAyNUwyMSAyNkwyMiAyNkwyMiAyN0wyMyAyN0wyMyAyOUwyMiAyOUwyMiAyOEwyMSAyOEwyMSAyN0wyMCAyN0wyMCAyNkwxOSAyNkwxOSAyN0wyMCAyN0wyMCAyOEwxOCAyOEwxOCAyN0wxNSAyN0wxNSAyOUwxNyAyOUwxNyAzMEwxOCAzMEwxOCAyOUwyMiAyOUwyMiAzMEwyMSAzMEwyMSAzMUwyMiAzMUwyMiAzMkwyMyAzMkwyMyAzMUwyNCAzMUwyNCAyN0wyMyAyN0wyMyAyNkwyNCAyNkwyNCAyNUwyMiAyNUwyMiAyNEwyMyAyNEwyMyAyM0wyNCAyM0wyNCAyNEwyNyAyNEwyNyAyMkwyNSAyMkwyNSAyMUwyNyAyMUwyNyAyMEwyOCAyMEwyOCAxOUwyNiAxOUwyNiAxOEwyNSAxOEwyNSAxN0wyOCAxN0wyOCAxOEwyOSAxOEwyOSAxN0wzMCAxN0wzMCAxOUwyOSAxOUwyOSAyMEwzMCAyMEwzMCAyMUwyOCAyMUwyOCAyNEwzMCAyNEwzMCAyM0wyOSAyM0wyOSAyMkwzMCAyMkwzMCAyMUwzMSAyMUwzMSAyMEwzMCAyMEwzMCAxOUwzMSAxOUwzMSAxNkwzMCAxNkwzMCAxNUwyOSAxNUwyOSAxM0wyOCAxM0wyOCAxNkwyNiAxNkwyNiAxNEwyNSAxNEwyNSAxM0wyNyAxM0wyNyAxMkwyOCAxMkwyOCAxMUwyNyAxMUwyNyAxMEwyNSAxMEwyNSA5TDI0IDlMMjQgMTBMMjMgMTBMMjMgOUwyMiA5TDIyIDhMMjEgOEwyMSA3TDIyIDdMMjIgNkwyMSA2TDIxIDdMMjAgN0wyMCA1TDIzIDVMMjMgNEwyNCA0TDI0IDNaTTkgNkw5IDdMMTAgN0wxMCA2Wk0xMSA2TDExIDdMMTIgN0wxMiA2Wk0xNiA2TDE2IDdMMTcgN0wxNyA2Wk0xOCA2TDE4IDdMMTkgN0wxOSA4TDIwIDhMMjAgMTFMMTkgMTFMMTkgOUwxOCA5TDE4IDhMMTcgOEwxNyA5TDE2IDlMMTYgMTBMMTcgMTBMMTcgMTFMMTkgMTFMMTkgMTRMMjAgMTRMMjAgMTZMMjIgMTZMMjIgMTdMMTkgMTdMMTkgMThMMjQgMThMMjQgMTlMMjMgMTlMMjMgMjBMMjIgMjBMMjIgMTlMMjAgMTlMMjAgMjFMMTggMjFMMTggMjBMMTcgMjBMMTcgMjFMMTYgMjFMMTYgMjJMMTUgMjJMMTUgMjNMMTcgMjNMMTcgMjFMMTggMjFMMTggMjJMMjAgMjJMMjAgMjNMMjEgMjNMMjEgMjRMMjIgMjRMMjIgMjNMMjMgMjNMMjMgMjJMMjQgMjJMMjQgMjFMMjMgMjFMMjMgMjBMMjQgMjBMMjQgMTlMMjUgMTlMMjUgMThMMjQgMThMMjQgMTdMMjUgMTdMMjUgMTZMMjQgMTZMMjQgMTdMMjMgMTdMMjMgMTRMMjQgMTRMMjQgMTNMMjMgMTNMMjMgMTJMMjYgMTJMMjYgMTFMMjUgMTFMMjUgMTBMMjQgMTBMMjQgMTFMMjEgMTFMMjEgMTBMMjIgMTBMMjIgOUwyMSA5TDIxIDhMMjAgOEwyMCA3TDE5IDdMMTkgNlpNMjkgOEwyOSA5TDMwIDlMMzAgOFpNMzEgOEwzMSAxMEwzMyAxMEwzMyA5TDMyIDlMMzIgOFpNMSA5TDEgMTBMMiAxMEwyIDlaTTEwIDlMMTAgMTFMMTEgMTFMMTEgOVpNMTMgOUwxMyAxMEwxNCAxMEwxNCA5Wk0xMyAxMUwxMyAxMkwxNSAxMkwxNSAxMVpNMzAgMTFMMzAgMTJMMzEgMTJMMzEgMTFaTTMgMTJMMyAxNEw0IDE0TDQgMTNMNSAxM0w1IDEyWk04IDEyTDggMTNMMTEgMTNMMTEgMTRMMTIgMTRMMTIgMTNMMTEgMTNMMTEgMTJaTTIwIDEyTDIwIDE0TDIxIDE0TDIxIDEzTDIyIDEzTDIyIDE0TDIzIDE0TDIzIDEzTDIyIDEzTDIyIDEyWk0xIDEzTDEgMTRMMiAxNEwyIDEzWk05IDE0TDkgMTVMMTAgMTVMMTAgMTRaTTMgMTVMMyAxNkw0IDE2TDQgMTdMNSAxN0w1IDE1Wk02IDE1TDYgMTZMNyAxNkw3IDE1Wk0xOCAxNUwxOCAxNkwxOSAxNkwxOSAxNVpNMjggMTZMMjggMTdMMjkgMTdMMjkgMTZaTTYgMThMNiAxOUw3IDE5TDcgMThaTTQgMjBMNCAyMUwzIDIxTDMgMjJMMiAyMkwyIDI0TDMgMjRMMyAyM0w0IDIzTDQgMjRMNSAyNEw1IDIzTDcgMjNMNyAyMkw2IDIyTDYgMjFMNyAyMUw3IDIwWk0xMSAyMEwxMSAyMUwxMiAyMUwxMiAyMFpNMjEgMjBMMjEgMjFMMjIgMjFMMjIgMjBaTTI1IDI1TDI1IDI4TDI4IDI4TDI4IDI1Wk0yOSAyNUwyOSAyOEwzMCAyOEwzMCAyN0wzMSAyN0wzMSAyNkwzMCAyNkwzMCAyNVpNMjYgMjZMMjYgMjdMMjcgMjdMMjcgMjZaTTggMjhMOCAzM0w5IDMzTDkgMzBMMTIgMzBMMTIgMzFMMTMgMzFMMTMgMzBMMTIgMzBMMTIgMjlMMTAgMjlMMTAgMjhaTTI1IDI5TDI1IDMwTDI4IDMwTDI4IDMxTDI5IDMxTDI5IDMwTDI4IDMwTDI4IDI5Wk0yMiAzMEwyMiAzMUwyMyAzMUwyMyAzMFpNMzAgMzBMMzAgMzFMMzEgMzFMMzEgMzBaTTEwIDMyTDEwIDMzTDExIDMzTDExIDMyWk0xMyAzMkwxMyAzM0wxNCAzM0wxNCAzMlpNMTcgMzJMMTcgMzNMMTggMzNMMTggMzJaTTE5IDMyTDE5IDMzTDIwIDMzTDIwIDMyWk0wIDBMMCA3TDcgN0w3IDBaTTEgMUwxIDZMNiA2TDYgMVpNMiAyTDIgNUw1IDVMNSAyWk0yNiAwTDI2IDdMMzMgN0wzMyAwWk0yNyAxTDI3IDZMMzIgNkwzMiAxWk0yOCAyTDI4IDVMMzEgNUwzMSAyWk0wIDI2TDAgMzNMNyAzM0w3IDI2Wk0xIDI3TDEgMzJMNiAzMkw2IDI3Wk0yIDI4TDIgMzFMNSAzMUw1IDI4WiIgZmlsbD0iIzAwMDAwMCIvPjwvZz48L2c+PC9zdmc+Cg==', 'S6kGktSeBGaKKcotjnHEvpuj1D4pagjb', 'active', NULL);

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
(1, 'Admin ICH', 'admin@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'admin', '+628000000000', '1780841959_QRIS_ICH.jpg', 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-07 07:19:19', 1, 1, 1, 1),
(2, 'Benton Pfeffer', 'alize1@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'teacher', '+1-901-296-1484', 'profile/profile_2_1780928388.jpg', 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-08 14:19:48', 1, 1, 1, 1),
(3, 'Ruth Senger IV', 'theron2@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'teacher', '+1 (336) 265-7225', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(4, 'Ms. Karolann Fahey III', 'joana3@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'teacher', '+17088231428', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(5, 'Lonie D\'Amore V', 'brennan4@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'teacher', '1-920-871-7883', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(6, 'Carlo Okuneva', 'kayden5@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'teacher', '332.814.7408', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(7, 'Mr. Brennon Kuphal', 'eva6@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'teacher', '442-776-5749', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(8, 'Dr. Travis Abbott', 'annette7@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'teacher', '(864) 573-4749', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(9, 'Dr. Victoria Howe II', 'ardith8@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'teacher', '(848) 695-0050', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(10, 'Enrico Bayer III', 'marcelo9@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'teacher', '+1 (279) 833-6143', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(11, 'Miss Gregoria Bosco Sr.', 'nathanael10@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'teacher', '1-903-312-1016', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(12, 'Silas Larkin', 'susanna1@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '(346) 317-3161', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(13, 'Tiara Olson', 'cedrick2@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '830-750-7930', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(14, 'Nelle Ortiz', 'daphnee3@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '(773) 388-3871', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(15, 'Nick Bins MD', 'corine4@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '+1-229-858-0689', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(16, 'Dr. Helena Hartmann', 'vida5@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '1-248-565-1015', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(17, 'Kaylin Oberbrunner', 'jesse6@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '541-348-4766', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(18, 'Ms. Pearlie Nicolas', 'dulce7@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '628.959.9259', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(19, 'Karolann Ortiz', 'hailey8@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '(539) 359-4191', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(20, 'Della Weissnat PhD', 'allen9@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '314-321-4289', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(21, 'Kristoffer Bode', 'jaqueline10@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '+1 (281) 550-2963', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(22, 'Kirstin Kirlin', 'lambert11@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '920.225.0671', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(23, 'Zelda Leannon', 'magdalena12@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '+1-530-761-7008', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(24, 'Curtis Stoltenberg', 'allene13@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '+15038417255', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(25, 'Adela White', 'anabel14@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '(260) 734-4938', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(26, 'Miss Jermaine Bernier PhD', 'mariana15@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '(806) 701-2764', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(27, 'Emile Runte', 'connie16@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '747.547.0063', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(28, 'Ray Schinner V', 'abigail17@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '629-636-1337', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(29, 'Hosea Yost', 'robyn18@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '+16076325401', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(30, 'Dr. Ariel Kiehn I', 'wallace19@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '+1-682-391-7821', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(31, 'Dr. Colby Boehm', 'providenci20@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '(947) 399-9986', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(32, 'Mr. Robbie Waters', 'dave21@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '+16602286723', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(33, 'Jovani Sawayn', 'esmeralda22@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '231.369.3060', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(34, 'Zelda Prosacco', 'carmen23@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '+18579298361', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(35, 'Prof. Kaley Tromp', 'rosalinda24@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '1-424-475-7849', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(36, 'Prof. Adelia Larkin', 'eloise25@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '+1.979.647.1901', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(37, 'Elizabeth Parker', 'pierce26@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '(234) 761-9155', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(38, 'Kiarra Romaguera', 'francisco27@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '+16674929196', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(39, 'Dr. Rollin Cormier', 'blair28@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '+15134126239', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(40, 'Samir Ziemann', 'jimmie29@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '352.218.3979', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(41, 'London Mueller', 'ken30@ich.com', NULL, '$2y$12$aSH7Z9/1DCpP.dIDnFHveOGQKBJTDUON6vYFvE4JPgIkNXsWvMBke', NULL, NULL, 'student', '954.395.6750', NULL, 'active', 'ACTIVE', NULL, '2026-06-06 02:31:51', '2026-06-06 02:31:51', 1, 1, 1, 1),
(42, 'hafiz batubara', 'hafiz@ich.com', NULL, '$2y$12$BgHN8vHFMH/k3HbsSakbku127tbcu.3Ld1D/X/8MeTd09/lDaOL5G', 'pet_name', '$2y$12$oUCqtE8G6M.CjuML8mPDQeDSLOJbClNU6A2vM9ps4L/JJmpVmVIc2', 'student', '+6286873843773', 'profile/profile_42_1781637873.jpg', 'active', 'ACTIVE', NULL, '2026-06-07 01:01:07', '2026-06-23 20:53:12', 1, 1, 1, 1),
(43, 'batubara', 'batubara@ich.com', NULL, '$2y$12$FJ2GB.sHv.nTM7.C88O9p.B/IkoT9Rh.QAQBJSZ5KXK8F20AZfUtG', 'pet_name', '$2y$12$uYBTWGzwpDWC2kXCcVp/qOg0bCSBAq8D.o3smH4Ztul2/u8rYKjl6', 'student', '823812832713', NULL, 'active', 'ACTIVE', NULL, '2026-06-07 01:22:06', '2026-06-07 01:22:55', 1, 1, 1, 1),
(44, 'jancok', 'jancok@ich.com', NULL, '$2y$12$.42lHGa7kjQWn8aOQ17tPegxEkzmqgMaRCOvo2dPZmDROkyYHb6sW', 'mother_maiden_name', '$2y$12$DFZ4s8WDUnR4u6cooievv.ReHxIMMXDAJkaMLPPK/iohDKrbPGWtK', 'student', '86299234823', NULL, 'active', 'ACTIVE', NULL, '2026-06-07 01:23:51', '2026-06-07 01:24:36', 1, 1, 1, 1),
(45, 'khairul', 'khairul@ich.com', NULL, '$2y$12$6Mw7WdISPwGM66WxlAcM3OCLyOB32ijKKltKw9qPDPE/bXpksoBwK', 'favorite_teacher', '$2y$12$bdYWQaqx5zEHOgPp2xpPD.TgQczObB4lomczeD7ioS74KoQA9YHjW', 'student', '8272731272312', NULL, 'active', 'ACTIVE', NULL, '2026-06-07 01:38:27', '2026-06-08 08:39:52', 1, 1, 1, 1),
(46, 'kalama', 'kalama@ich.com', NULL, '$2y$12$VZiHzfIMYlkNKsdQmYQZIuK9kwCwINengFNGwwQ/w14hpctrWLhMS', 'pet_name', '$2y$12$OePjEaQ/LYSnYifq.IbbOepfTp85k.wALJYQUMGgZ5RcsPJrVa8CS', 'student', '+629383728423', 'profile/profile_46_1780842720.jpg', 'active', 'ACTIVE', NULL, '2026-06-07 07:08:21', '2026-06-07 08:11:02', 1, 1, 1, 1),
(47, 'Bimas', 'bima@ich.com', NULL, '$2y$12$VOv9kmDdS9QCMf31fLVL4eGBgZJkb3NQJpXLBClVoHMIlsCXtOEFq', 'mother_maiden_name', '$2y$12$Y9Rnpy.zugZ2wi4znuoUCO6bqDgHpQxXzckLZoDNzB/L74.VGd8Ai', 'student', '0882016572736', 'profile/profile_47_1781635671.png', 'active', 'ACTIVE', NULL, '2026-06-16 18:44:53', '2026-06-16 18:47:58', 1, 1, 1, 1),
(48, 'chrisandy hutabarat', 'chris@ich.com', NULL, '$2y$12$1sZoShJkYoowxejQ6rd7numkuoCF.cwa1Bd9YNDS3cHSWqp97fXV.', 'favorite_teacher', '$2y$12$RBEYQ4Mwocb2iQ1sJZ3xOuRCxSBACpIC9pgRigjRuoVvVtFSip0Qy', 'student', '0882812831283', NULL, 'active', 'ACTIVE', NULL, '2026-06-18 10:12:02', '2026-06-18 10:13:53', 1, 1, 1, 1),
(49, 'bima', 'bimarawr@ich.com', NULL, '$2y$12$mvwYUSRgdfSJAvYEIg1/heqkgJm5xO2o7yMOyoChr6c940OcjgRwy', 'mother_maiden_name', '$2y$12$zin8HoxywPPNUEcxOr5v6OhU00bqdo3V8q2bV3iVMi526UVPsB81e', 'student', '0882827371283', NULL, 'active', 'AWAITING_PAYMENT', NULL, '2026-06-18 13:40:37', '2026-06-18 14:08:57', 1, 1, 1, 1),
(50, 'dedy', 'dedy@ich.com', NULL, '$2y$12$Sh99N17k662F.N9Sq/Ome.CF7lE1N3qFyrhoMpt4L6J9YMRcWyF0a', 'favorite_teacher', '$2y$12$xJk1R.1HBp.vUrxGdKLcNObiIEGLKRyd8Fn09Z4wkUqe7lNlhngli', 'student', '0882017462732', NULL, 'active', 'ACTIVE', NULL, '2026-06-18 13:49:23', '2026-06-18 14:09:51', 1, 1, 1, 1),
(51, 'Jaka Manis', 'jaka1@ich.com', NULL, '$2y$12$mJve4Ephw6k/fiI/jfQ5cei4l/Cm87j5OjzMyfJbeZJl4W78ygSvm', NULL, NULL, 'teacher', '08829277173', NULL, 'active', 'CLASS_NOT_SELECTED', NULL, '2026-06-19 06:29:58', '2026-06-19 06:29:58', 1, 1, 1, 1),
(52, 'Owner', 'owner@ich.com', '2026-06-19 09:10:47', '$2y$12$6urwsvOMdHfr8ROqJH9n4O3PK1z2ynbWZqI2PrUrfJxnROJO/Nd/K', NULL, NULL, 'owner', NULL, NULL, 'active', 'CLASS_NOT_SELECTED', NULL, '2026-06-19 09:10:47', '2026-06-19 09:10:47', 1, 1, 1, 1),
(53, 'dhapin', 'dhapin@ich.com', NULL, '$2y$12$MIso4fpA451EffhTfOImLuHP.I//m598yXr64P1RfNAFLeO468OvK', 'birth_city', '$2y$12$MBYU1HxC8hVV7bgBQIU2neWZ1PGoQZ5O/rLdnjtjclkPc/D2Hlo3O', 'student', '08820172372', NULL, 'active', 'ACTIVE', NULL, '2026-06-19 15:16:52', '2026-06-19 15:58:08', 1, 1, 1, 1),
(54, 'Farhan Lubis', 'farhan@ich.com', NULL, '$2y$12$mPbqIqQIJmGKCSVt8e0CMe7nlYtKseHLvhYkSMb8CdU4v96GGhhCe', 'elementary_school', '$2y$12$qYj/mD2S2j7sXrE5PxRHp.F9bJeswm3Iuie5t.BxEbuiQI9j4Mruy', 'student', '088292912732', NULL, 'active', 'CLASS_NOT_SELECTED', NULL, '2026-06-22 04:38:01', '2026-06-22 04:38:01', 1, 1, 1, 1),
(55, 'Mia', 'mia@ich.com', NULL, '$2y$12$YYeAqU62e/psFpnE26VvSuog7PAzFiTahrdAwReY0QtqxnGfRyORC', 'mother_maiden_name', '$2y$12$Ph8.bAkO8SOpvnJyhPGin.1rjz2qC32dDYHHDRobhdFENrLtNxZ9q', 'student', '08829182372', NULL, 'active', 'ACTIVE', NULL, '2026-06-22 05:34:06', '2026-06-22 05:36:13', 1, 1, 1, 1),
(56, 'muhammad akbar batubara', 'akbar@ich.com', NULL, '$2y$12$ud5H.NYTTDAkMasqDOTddOZPaG8dSjgp9HqWTpAWUlbjliYQ.BTQy', 'pet_name', '$2y$12$ltDzftTIM7at2ep5xd3xYO8Oh9sECKAEGGvgqqllwteUVb7moap8C', 'student', '0882929717231', NULL, 'active', 'ACTIVE', NULL, '2026-06-23 22:02:14', '2026-06-23 22:21:27', 1, 1, 1, 1),
(57, 'tri septian', 'trisep@ich.com', NULL, '$2y$12$T5GKAqGm60LQzSgo1vhBmesNFmvDgyMLPdX82iKLeuG.a1.ZA/iwK', 'pet_name', '$2y$12$qRDXXugJXyWPj3STlEESm.oiOeThyiQHp7THctPQjDTNvP87Fgz46', 'student', '08820182372', NULL, 'active', 'CLASS_NOT_SELECTED', NULL, '2026-06-25 09:07:04', '2026-06-25 09:07:04', 1, 1, 1, 1);

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
(1, 46, 46, 'Avatar Updated', 'Student uploaded a new profile photo.', '127.0.0.1', '2026-06-07 07:32:00', '2026-06-07 07:32:00'),
(2, 46, 46, 'Password Changed', 'Student changed their password.', '127.0.0.1', '2026-06-07 08:11:02', '2026-06-07 08:11:02'),
(3, 42, 42, 'Avatar Updated', 'Student uploaded a new profile photo.', '127.0.0.1', '2026-06-07 11:54:57', '2026-06-07 11:54:57'),
(4, 42, 42, 'Profile Updated', 'Student updated their profile information.', '127.0.0.1', '2026-06-07 11:55:11', '2026-06-07 11:55:11'),
(5, 42, 42, 'Profile Updated', 'Student updated their profile information.', '127.0.0.1', '2026-06-07 11:56:09', '2026-06-07 11:56:09'),
(6, 2, 2, 'Avatar Updated', 'Teacher uploaded a new profile photo.', '127.0.0.1', '2026-06-08 14:19:48', '2026-06-08 14:19:48'),
(7, 47, 47, 'Avatar Updated', 'Student uploaded a new profile photo.', '127.0.0.1', '2026-06-16 18:47:51', '2026-06-16 18:47:51'),
(8, 47, 47, 'Profile Updated', 'Student updated their profile information.', '127.0.0.1', '2026-06-16 18:47:58', '2026-06-16 18:47:58'),
(9, 42, 42, 'Avatar Updated', 'Student uploaded a new profile photo.', '127.0.0.1', '2026-06-16 19:24:33', '2026-06-16 19:24:33'),
(10, 51, 1, 'Teacher Created', 'Admin created a new teacher record.', '127.0.0.1', '2026-06-19 06:29:58', '2026-06-19 06:29:58'),
(11, 42, 42, 'Profile Updated', 'Student updated their profile information.', '127.0.0.1', '2026-06-23 20:53:12', '2026-06-23 20:53:12'),
(12, 56, 56, 'Profile Updated', 'Student updated their profile information.', '127.0.0.1', '2026-06-23 22:21:27', '2026-06-23 22:21:27');

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
-- Dumping data untuk tabel `weeks`
--

INSERT INTO `weeks` (`id`, `class_id`, `week_number`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'asd', 'asd', '2026-06-08 14:04:47', '2026-06-08 14:04:47'),
(2, 1, 2, 'asd', 'ads', '2026-06-18 10:26:28', '2026-06-18 10:26:28'),
(3, 2, 1, 'ads', 'asd', '2026-06-18 14:10:19', '2026-06-18 14:10:19');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `assessment_scores`
--
ALTER TABLE `assessment_scores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `class_materials`
--
ALTER TABLE `class_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `payment_installments`
--
ALTER TABLE `payment_installments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `student_grades`
--
ALTER TABLE `student_grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT untuk tabel `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `weeks`
--
ALTER TABLE `weeks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
