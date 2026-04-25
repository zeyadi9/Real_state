-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2026 at 12:44 PM
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
-- Database: `tk`
--

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
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `day` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `substitute` varchar(255) NOT NULL,
  `days_count` int(11) NOT NULL,
  `status` enum('pending','accepted','refused') NOT NULL DEFAULT 'pending',
  `refuse_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(4, '2026_03_02_190515_overtime', 2),
(5, '2026_03_03_091920_add_user_id_to_overtimes_table', 3),
(6, '2026_03_03_092506_add_status_to_overtimes_table', 4),
(7, '2026_03_03_094634_add_user_id_to_overtimes_table', 4),
(8, '2026_03_03_094950_add_role_to_users_table', 5),
(9, '2026_03_03_101051_add_refuse_reason_to_overtimes_table', 6),
(10, '2026_03_03_103556_create_leaves_table', 7),
(11, '2026_03_03_103600_create_permissions_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `overtimes`
--

CREATE TABLE `overtimes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `day` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_hours` decimal(5,2) NOT NULL,
  `reason` text NOT NULL,
  `from` time NOT NULL,
  `to` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','accepted','refused') NOT NULL DEFAULT 'pending',
  `refuse_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `overtimes`
--

INSERT INTO `overtimes` (`id`, `date`, `day`, `name`, `total_hours`, `reason`, `from`, `to`, `created_at`, `updated_at`, `user_id`, `status`, `refuse_reason`) VALUES
(1, '2026-03-10', 'السبت', 'Zeyad Yasser', 3.00, 'سيبسي', '00:00:00', '13:00:00', '2026-03-02 17:24:50', '2026-03-03 07:52:38', 0, 'refused', NULL),
(2, '2026-03-01', 'الاحد', 'زياد ياسر عبدالله', 4.00, 'pet support', '01:00:00', '13:00:00', '2026-03-02 17:40:44', '2026-03-03 07:52:37', 0, 'accepted', NULL),
(3, '2026-03-03', 'الاحد', 'زياد ياسر عبدالله', 4.00, 'pet support', '01:00:00', '13:00:00', '2026-03-02 17:49:18', '2026-03-03 07:52:36', 0, 'accepted', NULL),
(4, '2026-03-12', 'السبت', 'محمد طه', 6.00, 'pet support', '01:00:00', '12:59:00', '2026-03-02 17:55:55', '2026-03-03 07:52:35', 0, 'accepted', NULL),
(5, '2026-03-03', 'السبت', 'محمد طه', 1.00, 'pet support', '01:00:00', '02:00:00', '2026-03-02 18:10:17', '2026-03-03 07:52:33', 0, 'refused', NULL),
(6, '2026-03-03', 'السبت', 'محمد طه', 2.00, 'pet support', '01:00:00', '03:00:00', '2026-03-02 18:10:43', '2026-03-03 07:52:30', 0, 'accepted', NULL),
(7, '2026-03-03', 'السبت', 'Youssef', 1.67, 'pet support', '01:00:00', '02:40:00', '2026-03-03 08:03:54', '2026-03-03 08:09:28', 2, 'accepted', NULL),
(8, '2026-03-12', 'السبت', 'Adam', 2.00, 'pet support', '01:00:00', '03:00:00', '2026-03-03 08:08:16', '2026-03-03 08:09:30', 3, 'refused', NULL),
(9, '2026-03-12', 'السبت', 'Adam', 2.00, 'pet support', '02:00:00', '04:00:00', '2026-03-03 08:13:33', '2026-03-03 08:13:56', 3, 'refused', NULL),
(10, '2026-03-12', 'السبت', 'Zeyad Yasser', 1.00, 'pet support', '01:00:00', '02:00:00', '2026-03-03 08:14:38', '2026-03-03 08:14:43', 1, 'accepted', NULL),
(11, '2026-03-12', 'السبت', 'Adam', 3.00, 'pet support', '03:00:00', '06:00:00', '2026-03-03 08:18:04', '2026-03-03 08:18:15', 3, 'refused', NULL),
(12, '2026-03-12', 'السبت', 'Adam', 3.00, 'pet support', '02:00:00', '05:00:00', '2026-03-03 08:20:21', '2026-03-03 08:20:58', 3, 'refused', 'احبنه'),
(13, '2026-03-12', 'السبت', 'Adam', 2.00, 'pet support', '02:00:00', '04:00:00', '2026-03-03 08:21:27', '2026-03-03 08:21:39', 3, 'refused', 'احبنه');

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `day` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `from` time NOT NULL,
  `to` time NOT NULL,
  `status` enum('pending','accepted','refused') NOT NULL DEFAULT 'pending',
  `refuse_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `user_id`, `date`, `day`, `name`, `reason`, `from`, `to`, `status`, `refuse_reason`, `created_at`, `updated_at`) VALUES
(1, 3, '2026-03-12', 'السبت', 'Adam', 'صثبشيثس', '01:00:00', '02:00:00', 'accepted', NULL, '2026-03-03 08:45:15', '2026-03-03 09:14:55');

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
('41qZHKNZWY8zPuV72GSCqZawWQpjJrWfOmbmdApY', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWnNuOGViRGlpT2JBMnpKTWRseEhQbjFQOGlPT0tENGJFOUxwUEtSWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC92aWV3X3Blcm1pc3Npb24iO3M6NToicm91dGUiO3M6MTU6InZpZXdfcGVybWlzc2lvbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1772536614);

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Zeyad Yasser', 'z@z.z', NULL, '$2y$12$9h087W9JzDk5JLpvcz.ituk56GGw7rpqP2e.61BmXDtACaQoybh3.', NULL, '2026-03-02 16:31:18', '2026-03-03 07:50:18', 'admin'),
(2, 'Youssef', 'Y@Y.Y', NULL, '$2y$12$r9zv947u9PvAo1WhsVHMQ.hVnhrcZ.mH57UpLyNnFIkFK6G3Xwgcm', NULL, '2026-03-03 07:52:58', '2026-03-03 07:52:58', 'user'),
(3, 'Adam', 'adam@a.a', NULL, '$2y$12$0O9qfxCG/QN2Jy8Z8FbNUOj6ilXsZiXoJhVjlFBtEtdQKY9PGt0NO', NULL, '2026-03-03 08:07:55', '2026-03-03 08:07:55', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

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
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leaves_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtimes`
--
ALTER TABLE `overtimes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `overtimes`
--
ALTER TABLE `overtimes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
