-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2025 at 10:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `krs_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', 'admin@simak.ac.id', '$2y$12$iSVQdJ8lFQMLgH0DrrWiaeHo3rAPiNRGdh3Dig.N3Md7EWSBs22.y', 'admin', NULL, '2025-07-30 04:40:55', '2025-07-30 04:40:55'),
(2, 'koordinator', 'Koordinator SIM', 'koordinator@simak.ac.id', '$2y$12$aCMV0g6yRFBj7SqM3WO.VumDFyL0S39PVXKACm12v6V9pLy8n9MY.', 'admin', NULL, '2025-07-30 04:40:55', '2025-07-30 04:40:55');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `credits` int(11) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `day` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room` varchar(255) NOT NULL,
  `lecturer` varchar(255) NOT NULL,
  `quota` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `code`, `name`, `description`, `credits`, `semester`, `day`, `start_time`, `end_time`, `room`, `lecturer`, `quota`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'IF101', 'Pemrograman Dasar', 'Mata kuliah dasar pemrograman menggunakan bahasa C++', 3, '1', 'Senin', '08:00:00', '10:30:00', 'Lab 1', 'Dr. Bambang Sutrisno', 29, 1, '2025-07-30 04:40:59', '2025-07-30 04:44:58'),
(2, 'IF102', 'Algoritma dan Struktur Data', 'Mata kuliah tentang algoritma dan struktur data dasar', 3, '2', 'Selasa', '08:00:00', '10:30:00', 'Lab 2', 'Dr. Siti Aminah', 24, 1, '2025-07-30 04:40:59', '2025-07-30 04:44:34'),
(3, 'IF201', 'Pemrograman Web', 'Mata kuliah pemrograman web menggunakan HTML, CSS, dan JavaScript', 3, '3', 'Rabu', '13:00:00', '15:30:00', 'Lab 3', 'Ir. Ahmad Hidayat', 29, 1, '2025-07-30 04:40:59', '2025-07-30 04:45:17'),
(4, 'IF202', 'Basis Data', 'Mata kuliah tentang konsep dan implementasi basis data', 3, '3', 'Kamis', '08:00:00', '10:30:00', 'Lab 4', 'Dr. Rina Mardiana', 27, 1, '2025-07-30 04:40:59', '2025-07-30 04:45:03'),
(5, 'IF301', 'Pemrograman Berorientasi Objek', 'Mata kuliah pemrograman berorientasi objek menggunakan Java', 3, '5', 'Senin', '13:00:00', '15:30:00', 'Lab 1', 'Ir. Budi Santoso', 24, 1, '2025-07-30 04:40:59', '2025-07-30 04:44:28'),
(6, 'IF302', 'Jaringan Komputer', 'Mata kuliah tentang konsep dan implementasi jaringan komputer', 3, '5', 'Selasa', '13:00:00', '15:30:00', 'Lab 2', 'Dr. Hendra Wijaya', 19, 1, '2025-07-30 04:40:59', '2025-07-30 04:44:31'),
(7, 'IF401', 'Pemrograman Mobile', 'Mata kuliah pengembangan aplikasi mobile', 3, '7', 'Rabu', '08:00:00', '10:30:00', 'Lab 3', 'Ir. Dian Kusuma', 22, 1, '2025-07-30 04:40:59', '2025-07-30 04:40:59'),
(8, 'IF402', 'Kecerdasan Buatan', 'Mata kuliah tentang konsep dan implementasi kecerdasan buatan', 3, '7', 'Kamis', '13:00:00', '15:30:00', 'Lab 4', 'Dr. Eko Prasetyo', 18, 1, '2025-07-30 04:40:59', '2025-07-30 04:40:59'),
(9, 'SI101', 'Pengantar Sistem Informasi', 'Mata kuliah pengantar sistem informasi', 3, '1', 'Jumat', '08:00:00', '10:30:00', 'Ruang 101', 'Dr. Sri Wahyuni', 34, 1, '2025-07-30 04:40:59', '2025-07-30 04:44:38'),
(10, 'SI201', 'Analisis dan Perancangan Sistem', 'Mata kuliah analisis dan perancangan sistem informasi', 3, '3', 'Jumat', '13:00:00', '15:30:00', 'Ruang 102', 'Ir. Joko Widodo', 29, 1, '2025-07-30 04:40:59', '2025-07-30 04:44:41'),
(11, 'IF505', 'Analisa Pasar', NULL, 3, '5', 'Senin', '09:00:00', '11:00:00', 'Ruang !02', 'Rudi', 50, 1, '2025-07-30 05:10:52', '2025-07-30 05:10:52');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_30_053309_create_students_table', 1),
(5, '2025_07_30_053311_create_courses_table', 1),
(6, '2025_07_30_053315_create_student_courses_table', 1),
(7, '2025_07_30_053407_create_admins_table', 1),
(8, '2025_07_30_064256_add_soft_deletes_to_student_courses_table', 1),
(9, '2025_07_30_073034_create_personal_access_tokens_table', 1),
(10, '2025_07_30_073226_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('B2uO7XGRBWMOji8P6i8hUMgY5OsCEQkcS9cJztdr', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:141.0) Gecko/20100101 Firefox/141.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiclpYRzVuMkVURGY3QVY1NDhibGJJcXNkTWE2MzJHZkRwbjN0aFNmYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9rcnMiO31zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1753877483),
('xOGt9PzGbDu3dZ3oSKZixYCTlDFXA0m85h4yHTaQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:141.0) Gecko/20100101 Firefox/141.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiallhd2FnU1djTW5wc0xXaGpabGp3Y085NkhBNHZjQlFYeVo2VlRXZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1753877540);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `major` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `nim`, `name`, `email`, `password`, `major`, `semester`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '2021001', 'Ahmad Fauzi', 'ahmad.fauzi@student.ac.id', '$2y$12$7a6HTd/p3R8xYLm7H.me2O8RAwkYFS.kX2zue2PzI1wCb1XI5mvvS', 'Sistem Informasi', '5', NULL, '2025-07-30 04:40:56', '2025-07-30 04:40:56'),
(2, '2021002', 'Siti Nurhaliza', 'siti.nurhaliza@student.ac.id', '$2y$12$jfAer9UVwapEU3EsleD0kOvTm47/MMC8Iey3VvKAv2r8u2LIHCKZW', 'Sistem Informasi', '5', NULL, '2025-07-30 04:40:57', '2025-07-30 04:40:57'),
(3, '2021003', 'Budi Santoso', 'budi.santoso@student.ac.id', '$2y$12$48xBSyO4KD26WMU6QlHEru23.W31BX/BaasZhf6MDzG0TU44b9hhK', 'Teknik Informatika', '3', NULL, '2025-07-30 04:40:57', '2025-07-30 04:40:57'),
(4, '2021004', 'Dewi Sartika', 'dewi.sartika@student.ac.id', '$2y$12$mMS5vpisTu5cuGVnJWtGVu2cRg.LhUtAVart0euNgckoY1ELNnu3e', 'Teknik Informatika', '3', NULL, '2025-07-30 04:40:58', '2025-07-30 04:40:58'),
(5, '2021005', 'Rizki Pratama', 'rizki.pratama@student.ac.id', '$2y$12$ho.Ctf/ORNsKDdMMDV0D2u3rSjPY7QAVE14zR93JKLPzu2Hmvls.S', 'Sistem Informasi', '7', NULL, '2025-07-30 04:40:59', '2025-07-30 04:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `student_courses`
--

CREATE TABLE `student_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_courses`
--

INSERT INTO `student_courses` (`id`, `student_id`, `course_id`, `academic_year`, `semester`, `status`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 5, '2024/2025', 'Ganjil', 'pending', NULL, '2025-07-30 04:44:28', '2025-07-30 04:44:28', NULL),
(2, 1, 6, '2024/2025', 'Ganjil', 'pending', NULL, '2025-07-30 04:44:31', '2025-07-30 04:44:31', NULL),
(3, 1, 2, '2024/2025', 'Ganjil', 'pending', NULL, '2025-07-30 04:44:34', '2025-07-30 04:44:34', NULL),
(4, 1, 9, '2024/2025', 'Ganjil', 'pending', NULL, '2025-07-30 04:44:38', '2025-07-30 04:44:38', NULL),
(5, 1, 10, '2024/2025', 'Ganjil', 'pending', NULL, '2025-07-30 04:44:41', '2025-07-30 04:44:41', NULL),
(6, 1, 1, '2024/2025', 'Ganjil', 'pending', NULL, '2025-07-30 04:44:58', '2025-07-30 04:44:58', NULL),
(7, 1, 4, '2024/2025', 'Ganjil', 'approved', NULL, '2025-07-30 04:45:03', '2025-07-30 05:11:22', NULL),
(8, 1, 3, '2024/2025', 'Ganjil', 'approved', NULL, '2025-07-30 04:45:17', '2025-07-30 05:02:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`),
  ADD KEY `notifications_type_index` (`type`),
  ADD KEY `notifications_read_at_index` (`read_at`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_nim_unique` (`nim`),
  ADD UNIQUE KEY `students_email_unique` (`email`);

--
-- Indexes for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_course_unique` (`student_id`,`course_id`,`academic_year`,`semester`),
  ADD KEY `student_courses_course_id_foreign` (`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_courses`
--
ALTER TABLE `student_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD CONSTRAINT `student_courses_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_courses_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
