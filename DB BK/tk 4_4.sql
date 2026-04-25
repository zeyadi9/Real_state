-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2026 at 11:02 PM
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
  `updated_at` timestamp NULL DEFAULT NULL,
  `actioned_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `user_id`, `date`, `day`, `name`, `reason`, `substitute`, `days_count`, `status`, `refuse_reason`, `created_at`, `updated_at`, `actioned_by`) VALUES
(2, 3, '2026-03-08', 'الاحد', 'Adam', 'عزومة المركز', '.', 1, 'accepted', NULL, '2026-03-24 16:06:08', '2026-03-28 11:14:12', NULL),
(3, 3, '2026-03-17', 'الثلاثاء', 'Adam', 'راحه', '.', 1, 'accepted', NULL, '2026-03-24 16:08:03', '2026-03-28 11:14:12', NULL),
(4, 3, '2026-03-18', 'الاربع', 'Adam', 'راحه', '.', 1, 'refused', 'نم', '2026-03-24 16:08:23', '2026-03-28 11:15:12', NULL),
(5, 3, '2026-03-19', 'الخميس', 'Adam', 'راحه', '.', 1, 'refused', 'منت', '2026-03-24 16:09:02', '2026-03-28 11:15:07', NULL),
(7, 3, '2026-03-26', 'الخميس', 'Adam', 'سفر', '.', 1, 'pending', NULL, '2026-03-27 13:17:47', '2026-03-27 13:17:47', NULL),
(9, 56, '2026-03-28', 'السبت', 'Shimaa', 'مرضي', 'أميرة معوض', 1, 'accepted', NULL, '2026-03-29 13:20:24', '2026-03-29 13:21:36', NULL),
(10, 59, '2026-03-29', 'الاحد', 'Am Adham', 'ابني جالو حاله تسمم فا ا.حسام قالي امشي', '..', 1, 'pending', NULL, '2026-03-30 08:11:52', '2026-03-30 08:11:52', NULL),
(11, 60, '2026-03-30', 'الاثنين', 'Alaa', 'امتحانات', 'مريم بعلم ا حسام', 1, 'pending', NULL, '2026-03-30 11:51:30', '2026-03-30 11:51:30', NULL),
(12, 24, '2026-04-02', 'الخميس', 'shorouk atef', 'مرضي', 'ملك', 1, 'pending', NULL, '2026-04-03 19:00:55', '2026-04-03 19:00:55', NULL);

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
(11, '2026_03_03_103600_create_permissions_table', 7),
(12, '2026_03_03_140944_add_alarm_to_permissions_table', 8),
(13, '2026_03_28_203421_create_penalties_table', 8),
(14, '2026_03_28_213829_add_actioned_by_to_leaves_table', 9),
(15, '2026_03_28_213836_add_actioned_by_to_permissions_table', 9),
(16, '2026_03_28_213842_add_actioned_by_to_overtimes_table', 10),
(17, '2026_03_28_220458_add_actioned_by_to_penalties_table', 11),
(18, '2026_03_29_000001_add_super_admin_role_to_users_table', 12),
(19, '2026_03_29_000002_add_status_to_penalties_table', 12);

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
  `refuse_reason` text DEFAULT NULL,
  `actioned_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `overtimes`
--

INSERT INTO `overtimes` (`id`, `date`, `day`, `name`, `total_hours`, `reason`, `from`, `to`, `created_at`, `updated_at`, `user_id`, `status`, `refuse_reason`, `actioned_by`) VALUES
(15, '2026-03-05', 'الخميس', 'Zeyad Yasser', 1.25, 'pet ct Support', '11:15:00', '12:30:00', '2026-03-05 13:39:04', '2026-03-28 11:08:45', 1, 'accepted', NULL, 'Mohamed Taha'),
(16, '2026-03-05', 'الخميس', 'Zeyad Yasser', 3.00, 'متابعه صيانه الجهاز و الدوريه للتيوبه الجديده', '16:00:00', '19:00:00', '2026-03-05 13:40:15', '2026-03-28 11:08:39', 1, 'accepted', NULL, NULL),
(17, '2026-03-01', 'الاحد', 'Youssef', 4.50, 'pet ct support', '10:00:00', '14:30:00', '2026-03-08 10:47:02', '2026-03-28 11:08:56', 2, 'accepted', NULL, NULL),
(18, '2026-03-09', 'الاتنين', 'Youssef', 6.00, 'pet ct support', '10:30:00', '16:30:00', '2026-03-09 18:55:46', '2026-03-28 11:08:25', 2, 'accepted', NULL, NULL),
(19, '2026-03-11', 'الاربع', 'Adam', 1.67, 'حل مشكلة طابعة الافلام ct', '16:00:00', '17:40:00', '2026-03-11 13:43:28', '2026-03-25 12:55:30', 3, 'accepted', NULL, NULL),
(20, '2026-03-11', 'الاربع', 'Zeyad Yasser', 1.67, 'حل مشكله طابعه الاكس راي', '16:00:00', '17:40:00', '2026-03-11 13:43:49', '2026-03-28 11:08:18', 1, 'accepted', NULL, NULL),
(21, '2026-03-14', 'السبت', 'Zeyad Yasser', 1.50, 'pet support', '12:00:00', '13:30:00', '2026-03-14 16:49:30', '2026-03-28 11:08:11', 1, 'accepted', NULL, NULL),
(22, '2026-03-16', 'الاتنين', 'Zeyad Yasser', 2.50, 'pet support', '11:30:00', '14:00:00', '2026-03-16 10:29:45', '2026-03-28 11:08:05', 1, 'accepted', NULL, NULL),
(23, '2026-03-16', 'الاتنين', 'Zeyad Yasser', 1.00, 'استلام الطابعه الجديده ال A4', '16:00:00', '17:00:00', '2026-03-16 16:25:21', '2026-03-28 11:07:52', 1, 'accepted', NULL, NULL),
(24, '2026-03-24', 'الثلاثاء', 'Adam', 4.00, 'سيرفر طباعة الفشن وطابعة الفشن', '14:00:00', '18:00:00', '2026-03-24 16:02:12', '2026-03-25 12:55:32', 3, 'accepted', NULL, NULL),
(31, '2026-03-28', 'السبت', 'Youssef Mohammed', 1.00, 'مكان محمد لطيف', '15:30:00', '16:30:00', '2026-03-28 14:55:03', '2026-03-28 14:55:03', 21, 'pending', NULL, NULL),
(32, '2026-03-29', 'الاحد', 'Yasmine', 3.50, 'مكان ام ادهم', '12:00:00', '15:30:00', '2026-03-29 08:22:00', '2026-03-29 08:22:00', 49, 'pending', NULL, NULL),
(33, '2026-03-28', 'السبت', 'Maha', 0.50, 'حالات مع دكتور خالد', '22:00:00', '22:30:00', '2026-03-29 09:39:06', '2026-03-29 09:39:06', 30, 'pending', NULL, NULL),
(34, '2026-03-28', 'السبت', 'Laflofa rabee', 0.58, 'الدكتور كان معاه حالات بعد الساعه ١٠', '22:00:00', '22:35:00', '2026-03-29 10:33:10', '2026-03-29 10:33:10', 48, 'pending', NULL, NULL),
(35, '2026-03-30', 'الاتنين', 'Amira', 0.77, 'مكان رحمه', '15:30:00', '16:16:00', '2026-03-30 13:16:27', '2026-03-30 13:16:27', 54, 'pending', NULL, NULL),
(36, '2026-03-30', 'الاتنين', 'Yasmine', 1.00, 'مكان استاذة هند', '14:30:00', '15:30:00', '2026-03-30 17:07:45', '2026-03-30 17:07:45', 49, 'pending', NULL, NULL),
(37, '2026-03-30', 'الاتنين', 'Wafaa rabee', 1.02, 'قعدت ساعه مكان سلسبيل وسلسبيل طلعت استعلامات ف قعدت مكانها لحد ما ا محمد لطيف يجي', '15:29:00', '16:30:00', '2026-03-30 18:22:50', '2026-03-30 18:22:50', 48, 'pending', NULL, NULL),
(38, '2026-03-30', 'الاثنين', 'Rahma Atef', 1.00, 'مع دكتوره هدي', '15:30:00', '16:30:00', '2026-03-30 18:54:32', '2026-03-30 18:54:32', 13, 'pending', NULL, NULL),
(39, '2026-03-30', 'الاثنين', 'Adam', 2.50, 'تغطيه مكان زياد عشان كان عندو جامعه', '11:30:00', '14:00:00', '2026-03-30 19:00:52', '2026-03-30 19:00:52', 3, 'pending', NULL, NULL),
(40, '2026-03-30', 'الاحد 29/3', 'Habiba Ayman', 2.00, 'استكمال شفت رنين', '07:00:00', '09:00:00', '2026-03-31 07:03:49', '2026-03-31 07:03:49', 25, 'pending', NULL, NULL),
(41, '2026-03-31', 'الاتنين', 'Youssef', 3.50, 'pet ct support', '10:30:00', '14:00:00', '2026-03-31 16:43:25', '2026-03-31 16:43:25', 2, 'pending', NULL, NULL),
(42, '2026-04-01', 'الاربعاء', 'Aya', 1.00, 'مكان رحمه', '15:30:00', '16:30:00', '2026-04-01 12:09:32', '2026-04-01 12:09:32', 62, 'pending', NULL, NULL),
(43, '2026-04-01', 'الاربع', 'Youssef Mohammed', 1.02, 'مكان محمد لطيف', '15:29:00', '16:30:00', '2026-04-01 12:50:58', '2026-04-01 12:50:58', 21, 'pending', NULL, NULL),
(44, '2026-04-02', 'الخميس', 'Amira', 0.58, 'مكان رحمه', '15:30:00', '16:05:00', '2026-04-02 12:05:25', '2026-04-02 12:05:25', 54, 'pending', NULL, NULL),
(45, '2026-04-01', 'الاربعاء', 'Maha', 0.50, 'رحمه مشت بدرى وفاه جدها', '15:00:00', '15:30:00', '2026-04-02 15:52:04', '2026-04-02 15:52:04', 30, 'pending', NULL, NULL),
(46, '2026-04-01', 'الاربعاء', 'Maha', 0.50, 'حالات مع دكتور خالد', '22:00:00', '22:30:00', '2026-04-02 16:04:22', '2026-04-02 16:04:22', 30, 'pending', NULL, NULL),
(47, '2026-04-03', 'الجمعه', 'Abdallah Raafat', 3.00, 'اضافي بدل ا.ياسر شكري الدور التالت', '18:00:00', '21:00:00', '2026-04-03 14:04:38', '2026-04-03 14:04:38', 67, 'pending', NULL, NULL),
(48, '2026-04-04', 'السبت', 'Youssef', 2.50, 'تغطية شيفت', '11:30:00', '14:00:00', '2026-04-04 11:20:19', '2026-04-04 11:20:19', 2, 'pending', NULL, NULL),
(49, '2026-04-04', 'السبت', 'Rahmaa', 2.00, 'مكان اميره', '14:00:00', '16:00:00', '2026-04-04 11:33:50', '2026-04-04 11:33:50', 36, 'pending', NULL, NULL),
(50, '2026-04-04', 'السبت', 'Youssef Mohammed', 1.50, 'مكان محمد لطيف', '15:30:00', '17:00:00', '2026-04-04 12:48:22', '2026-04-04 12:48:22', 21, 'pending', NULL, NULL),
(51, '2026-04-04', 'السبت', 'Wafa rabee', 0.50, 'ان سلسبيل اخرت نص ساعه', '15:30:00', '16:00:00', '2026-04-04 17:09:56', '2026-04-04 17:09:56', 48, 'pending', NULL, NULL),
(52, '2026-04-03', 'الجمعه', 'Shimaa', 7.50, 'شفت فى حديث المدينه', '09:00:00', '16:30:00', '2026-04-04 18:38:17', '2026-04-04 18:38:17', 56, 'pending', NULL, NULL);

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
-- Table structure for table `penalties`
--

CREATE TABLE `penalties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `amount` varchar(200) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `actioned_by` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','refused') NOT NULL DEFAULT 'pending',
  `refuse_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penalties`
--

INSERT INTO `penalties` (`id`, `user_id`, `name`, `reason`, `amount`, `notes`, `created_at`, `updated_at`, `actioned_by`, `status`, `refuse_reason`) VALUES
(9, 3, 'Adam', 'اهمال', '1/2 شفت', NULL, '2026-03-29 10:33:53', '2026-03-29 16:14:33', 'M.TAHA', 'accepted', NULL),
(10, 48, 'Wafa rabee', 'عدم ارتداء id', 'ربع شفت', 'يرجي الالتزام بارتداء ال id', '2026-04-04 12:08:52', '2026-04-04 12:09:13', 'M.TAHA', 'accepted', NULL);

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
  `from` time DEFAULT NULL,
  `to` time DEFAULT NULL,
  `status` enum('pending','accepted','refused') NOT NULL DEFAULT 'pending',
  `refuse_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `alarm` tinyint(1) NOT NULL DEFAULT 0,
  `actioned_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `user_id`, `date`, `day`, `name`, `reason`, `from`, `to`, `status`, `refuse_reason`, `created_at`, `updated_at`, `alarm`, `actioned_by`) VALUES
(11, 1, '2026-03-05', 'الخميس', 'Zeyad Yasser', 'نسيان بصمه دخول', '11:15:00', '12:30:00', 'accepted', NULL, '2026-03-05 13:36:59', '2026-03-28 11:16:01', 0, NULL),
(16, 11, '2026-03-28', 'السبت', 'Menaaali', 'تاخير بإذن مسبق', '08:00:00', '09:30:00', 'pending', NULL, '2026-03-28 14:26:54', '2026-03-28 14:26:54', 0, NULL),
(17, 10, '2026-03-28', 'الخميس 26/3', 'Esraa Mohamed', 'إذن تأخير بعلم ا. حسام', '08:00:00', '08:30:00', 'pending', NULL, '2026-03-28 15:22:40', '2026-03-28 15:22:40', 0, NULL),
(18, 47, '2026-03-27', 'الجمعه', 'Salsabel', 'انحراف بدون بصمه بعد استأذن من ا. حسام لظرف  الوقت الي قعدتو', '13:00:00', '16:00:00', 'pending', NULL, '2026-03-28 19:17:48', '2026-03-28 19:17:48', 0, NULL),
(20, 37, '2026-03-28', 'السبت', 'mera', 'اذن. انصراف باكر', '21:20:00', '22:00:00', 'pending', NULL, '2026-03-29 05:04:27', '2026-03-29 05:04:27', 0, NULL),
(21, 20, '2026-03-30', 'الأثنين', 'shahd amr', 'اذن بسبب الذهاب الي طبيب بعلم ا. روان', '12:00:00', '12:46:00', 'pending', NULL, '2026-03-30 10:19:09', '2026-03-30 10:19:09', 0, NULL),
(22, 30, '2026-03-30', 'الاثنين', 'Maha', 'مرضى', '20:00:00', '22:00:00', 'pending', NULL, '2026-03-31 07:51:09', '2026-03-31 07:51:09', 0, NULL),
(23, 61, '2026-03-30', 'الاثنين', 'Hend', 'مرضي', '15:00:00', '15:30:00', 'pending', NULL, '2026-03-31 08:18:19', '2026-03-31 08:18:19', 0, NULL),
(25, 63, '2026-03-31', 'الثلاثاء', 'Amal ezzeldien', 'اذن بصمة لظروف خاصة', NULL, NULL, 'accepted', NULL, '2026-03-31 15:47:47', '2026-04-04 12:37:16', 0, NULL),
(26, 10, '2026-04-01', 'الاربعاء', 'Esraa Mohamed', 'تعب مفاجاه بعلم ا. حسام', '14:00:00', '14:30:00', 'pending', NULL, '2026-04-01 12:42:32', '2026-04-01 12:42:32', 0, NULL),
(27, 49, '2026-04-02', 'الخميس', 'Yasmine', 'مكنش في مواصلات بسبب المطرة', '09:00:00', '10:00:00', 'pending', NULL, '2026-04-02 12:09:32', '2026-04-02 12:09:32', 0, NULL),
(28, 37, '2026-04-02', 'الخميس', 'mera', 'تاخير بسبب المطره الصبح والدنيا متبهدله ومفيش مواصلات', '09:00:00', '10:00:00', 'pending', NULL, '2026-04-02 17:43:01', '2026-04-02 17:43:01', 0, NULL),
(29, 10, '2026-04-04', 'السبت', 'Esraa Mohamed', 'إذن نصف ساعه تأخير نسيت الموبيل ورجعت', '08:00:00', '08:30:00', 'pending', NULL, '2026-04-04 10:53:52', '2026-04-04 10:53:52', 0, NULL),
(30, 9, '2026-04-04', 'السبت', 'Mohamed latif', 'تاخير ساعة', '15:30:00', '16:30:00', 'pending', NULL, '2026-04-04 13:06:50', '2026-04-04 13:06:50', 0, NULL),
(32, 25, '2026-04-04', 'السبت', 'Habiba Ayman', 'تاخير كان في امتحان مبلغه ا/ روان', '12:00:00', '13:00:00', 'pending', NULL, '2026-04-04 13:48:54', '2026-04-04 13:48:54', 0, NULL),
(38, 25, '2026-04-04', 'السبت', 'Habiba Ayman', 'انصراف باكر مبلغه ا/ روان', '18:00:00', '19:00:00', 'pending', NULL, '2026-04-04 13:49:44', '2026-04-04 13:49:44', 0, NULL),
(39, 1, '2026-04-04', 'السبت', 'Zeyad Yasser', 'تكريم مبادره --  نسيان بصمه حضور', NULL, NULL, 'pending', NULL, '2026-04-04 15:49:23', '2026-04-04 15:49:23', 0, NULL);

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
  `role` enum('admin','user','super_admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Zeyad Yasser', 'z@z.z', NULL, '$2y$12$9h087W9JzDk5JLpvcz.ituk56GGw7rpqP2e.61BmXDtACaQoybh3.', NULL, '2026-03-02 16:31:18', '2026-03-03 07:50:18', 'super_admin'),
(2, 'Youssef', 'Y@Y.Y', NULL, '$2y$12$r9zv947u9PvAo1WhsVHMQ.hVnhrcZ.mH57UpLyNnFIkFK6G3Xwgcm', NULL, '2026-03-03 07:52:58', '2026-03-03 07:52:58', 'user'),
(3, 'Adam', 'a@a.a', NULL, '$2y$12$0O9qfxCG/QN2Jy8Z8FbNUOj6ilXsZiXoJhVjlFBtEtdQKY9PGt0NO', NULL, '2026-03-03 08:07:55', '2026-03-03 08:07:55', 'user'),
(6, 'M.TAHA', 'mtaha@gama.com', NULL, '$2y$12$pJQKzvmELUlxm6h0X6fpM.gWOJELv4.Lpa62QZkbevinaW7AJLLGi', NULL, '2026-03-07 10:45:40', '2026-03-07 10:45:40', 'super_admin'),
(9, 'Mohamed latif', 'ostora.7799852@gmail.com', NULL, '$2y$12$PVuUVi.OswvzwYdggt9t4OxsPes4ZkqQbFgDg1dLoAh6TGlVgoGqK', NULL, '2026-03-28 13:43:07', '2026-03-28 13:43:07', 'user'),
(10, 'Esraa Mohamed', 'esraa.abdulla30@gmail.com', NULL, '$2y$12$huDWK..3kY4Tob9yq3JLW.Xw5KOFvpfa4GbXCRn29h7Epf5HcJsmW', NULL, '2026-03-28 13:53:01', '2026-03-28 13:53:01', 'user'),
(11, 'Menaa ali', 'menna.ali311@gmail.com', NULL, '$2y$12$DXcl2yQgv8b/xvjpP8IVZuVvm95IdG9/PYG/b5V2w5WxSp/2hRXcG', NULL, '2026-03-28 13:57:04', '2026-03-28 13:57:04', 'user'),
(13, 'Rahma Atef', 'atefrahma639@gmail.com', NULL, '$2y$12$b8iNbmuta..tkoAXOT85Qu8iUyd2POviUBjHnd10lHpA5.MWTDyZO', NULL, '2026-03-28 14:04:11', '2026-03-29 16:44:24', 'user'),
(15, 'soha', 'soha@gamma.scan', NULL, '$2y$12$sYIvYwBgFIXM0.CQJhK4q.bQqxioARCY95B.p5J5qT2JVGt6UkoOS', NULL, '2026-03-28 14:11:28', '2026-03-28 14:11:28', 'user'),
(17, 'Norhan eid mohamed', 'norhaneid11@gmail.com', NULL, '$2y$12$236zn.qJ4F/2s9X2wlNV3ORIKPug4zshm1cgfuOiQvEIJ.HFvchTW', NULL, '2026-03-28 14:29:54', '2026-03-28 14:29:54', 'user'),
(19, 'Hossamm', 'Hossamm@gamma.scan', NULL, '$2y$12$GNrWinUGqof7DpR8DItUlOp8.lgqcqwPbmhN5AeQrH8d2LPhJr9gO', NULL, '2026-03-28 14:46:05', '2026-03-28 14:46:05', 'user'),
(20, 'shahd amr', 'shahd@gamma.scan', NULL, '$2y$12$IToQK/SaMsBauGeLZklj3.VghrEID1wK0yPmaRzPPFlQ3uWV0gKJq', NULL, '2026-03-28 14:51:37', '2026-03-28 14:51:37', 'user'),
(21, 'Youssef Mohammed', 'youssef.2422ascll@gmail.com', NULL, '$2y$12$XRbFq8X6J14q3NjcTmTTd.svd41vBTuVvSTvnqjHKRSwZDtkXZwD2', NULL, '2026-03-28 14:52:57', '2026-03-28 14:52:57', 'user'),
(24, 'shorouk atef', 'shoroukatef@yahoo.com', NULL, '$2y$12$aRoKJrwMjLQf55IxbzF4H.sK.w3ZSWJygqAfiZVu.pMO0OvewmZvO', NULL, '2026-03-28 14:54:55', '2026-03-28 16:12:46', 'user'),
(25, 'Habiba Ayman', 'hbybhaymn89@gmail.com', NULL, '$2y$12$EVg1Qmz1kyAPj/M.c79lY.0319IVq4OXBCIT9uXeYvXvjS7Q.suQO', NULL, '2026-03-28 14:55:58', '2026-03-28 14:55:58', 'user'),
(28, 'Shahd ibrahim', 'shahdshosho2412@gmail.com', NULL, '$2y$12$SO6iGZeDK0nXz46KFaOX0.PGrdErWCoOxpdYSLWHAVZOojYgmKYp6', NULL, '2026-03-28 15:50:26', '2026-03-28 15:50:26', 'user'),
(30, 'Maha', 'maha@gama.com', NULL, '$2y$12$qv0K6OutQ/SbojJhM8JNU.mTrfuveoMW6fBy7VGw3MLvwU4QfPgS.', NULL, '2026-03-28 15:57:56', '2026-03-28 15:57:56', 'user'),
(31, 'NorhaneEmad', 'naneemad56@gmail.com', NULL, '$2y$12$dBnmMZUqsJqN7/8Nyn6oA.iih4JqJwJrjQAeIIxVIDrSd3bBLX4Ve', NULL, '2026-03-28 15:58:29', '2026-03-28 15:58:29', 'user'),
(36, 'Rahmaa', 'rahmaa@gama.com', NULL, '$2y$12$FoJkpbjlsjrIT.qX8fs5E.VrdPh82y8CNtmlCwsjovhdF7z1bq.ES', NULL, '2026-03-28 16:12:04', '2026-03-28 16:12:04', 'user'),
(37, 'mera', 'amira@gmail.com', NULL, '$2y$12$H0j8LQeRMM/jMSudODzI8OV1FJbQHyl5U0d8/.Lvij18pxG2m1AXO', NULL, '2026-03-28 16:14:41', '2026-03-28 16:14:41', 'user'),
(38, 'Khaled', 'khaled@gama.com', NULL, '$2y$12$54c3C02eTn1Uf.azxc9oXeKwilCWwDHyqzmUfwG.vljtNlZasiHLe', NULL, '2026-03-28 16:20:02', '2026-03-28 16:20:02', 'user'),
(40, 'amira', 'essammohamed9@gmail.com', NULL, '$2y$12$NVTKufQ990Ezol5tuJSyJ.FgyNFfLDw2EFXRnX8yXYnWrUnySAZPq', NULL, '2026-03-28 16:27:02', '2026-03-28 16:27:02', 'user'),
(41, 'Rawan Essam', 'RawanEssam@gamma.com', NULL, '$2y$12$Po99ttEUejmW91W5x9yVOutCLsQSSstWKbLpgj5h.cWAYzd4KCzAG', NULL, '2026-03-28 17:29:21', '2026-03-28 17:29:21', 'user'),
(44, 'mariam', 'mariam@gamma.scan', NULL, '$2y$12$egBQdOKyoZlh8HLc/spOUeB/Lg0feKfra2PqamGrI4JuA2WEXWytC', NULL, '2026-03-28 18:42:31', '2026-03-28 18:42:31', 'user'),
(47, 'Salsabel', 'salsabilsahmed232@gmail.com', NULL, '$2y$12$eByb7U1rde5s6LPytV7EK.5FAz7c/zpLw1Mydnx7AFv52FaekOnpC', NULL, '2026-03-28 19:14:56', '2026-03-28 19:14:56', 'user'),
(48, 'Wafa rabee', 'fofarabee11@gmail.com', NULL, '$2y$12$58lWzVNWPyNILneE.CoLEeh7sHV8mtJzgDC6kMdjWc7BCKLmGX/Wy', NULL, '2026-03-28 20:03:35', '2026-03-28 20:03:35', 'user'),
(49, 'Yasmine', 'saiedyasmin21@gmail.com', NULL, '$2y$12$fzDgPzXKrr.AewdnDLKC8exO74aZ6yH07FIAnfQhmNU9JFYHIz36y', NULL, '2026-03-28 20:18:03', '2026-03-28 20:18:03', 'user'),
(50, 'aya22@gmail.com', 'aya@ahmed', NULL, '$2y$12$sPAO1.IjS4.JzsXoA6ZIz.3Qsd31caBOkHt4oZSq/vLNjyV34uVmy', NULL, '2026-03-29 05:31:50', '2026-03-29 05:31:50', 'user'),
(51, 'heba fouad', 'barbhassan1@gmail.com', NULL, '$2y$12$qNnVJTi3vuvXgJAOfmEvlecuW2yA/hQY8YC8pGIXyVbvg8Mm.Hk1C', NULL, '2026-03-29 05:33:36', '2026-03-29 05:33:36', 'user'),
(52, 'Rabab Elqellawy', 'Rabab@gamma.com', NULL, '$2y$12$99HxXpsG6vx2Tvf3zroKCeNXlxEhPAUmd3TDEaOv7bAhLGalnBiCO', NULL, '2026-03-29 07:34:41', '2026-03-29 07:34:41', 'user'),
(53, 'Mariem tharwt', 'mariamthrwat345@gmail.com', NULL, '$2y$12$PHUR83TvJV117cgrG1dHvuUTmKIIWsFX8267jUemKHWcOMDddRGTq', NULL, '2026-03-29 11:13:47', '2026-03-29 11:13:47', 'user'),
(54, 'Amira', 'amiraessammohamedsd9@gmail.com', NULL, '$2y$12$GyvhYxAqdYzDVa7xTAtazeJ.OWm8ua9Qfc7VIPMCqdU6jDNoLfOcC', NULL, '2026-03-29 11:38:46', '2026-03-29 11:38:46', 'user'),
(55, 'test', 'test@gamma.scan', NULL, '$2y$12$c5ElIBPcbJ8RdQAKMe/XVuZhEU5EIohRO0qKR0ixKwrnN.P4U7o/K', NULL, '2026-03-29 12:43:07', '2026-03-29 12:43:07', 'user'),
(56, 'Shimaa', 'shimaa@gama.com', NULL, '$2y$12$2rR1xQOy7v2QJ/fSybkQc.Pq8vynZoBDTTI6pSOnxh7Q/I0jRjKiq', NULL, '2026-03-29 13:17:22', '2026-03-29 13:17:22', 'user'),
(59, 'Sahar Sholqamy', 'shrshlqamy85@gmail.com', NULL, '$2y$12$uTxCvEyUXg0qFmLev0S11.HrjTav4bgB4zaYH9QfeTamqNa4Kf/b2', NULL, '2026-03-30 07:40:44', '2026-03-30 07:40:44', 'user'),
(60, 'Alaa', 'Alaa@gama.com', NULL, '$2y$12$hJfLvzqWSm2sB.4Pqk14geV0oIZVkbKm.LnJ6HC7Msd0kkcUClBvS', NULL, '2026-03-30 11:47:16', '2026-03-30 11:47:16', 'user'),
(61, 'Hend', 'hend@gama.com', NULL, '$2y$12$Cc5LcBKZUrMCh7z6ISyy9.F71XrVtTU6zwVNfdwLRNqTND/SbEwXW', NULL, '2026-03-31 08:16:28', '2026-03-31 08:16:28', 'user'),
(62, 'Aya', 'aya@gama.com', NULL, '$2y$12$/bPxxBzfEhfBbnb2rc5iGecrFYoa9V/0hoWgXeHjMHEjdACmKFaeC', NULL, '2026-03-31 12:22:37', '2026-03-31 12:22:37', 'user'),
(63, 'Amal ezzeldien', 'ezzamal73@gmail.com', NULL, '$2y$12$Hydx9.6K5ySmADLhHvvyzOX5S/wdkgrLa3ozuuq63akG0fUHODMQe', NULL, '2026-03-31 15:45:41', '2026-03-31 15:45:41', 'user'),
(64, 'Rehab Elderbashy', 'rehabelderbashy@gmail.com', NULL, '$2y$12$ufjjQXhUkIXk9xhFhCxbOeW39izQY07V52nT3BWds88cxlN0py/wy', NULL, '2026-03-31 16:16:28', '2026-03-31 16:16:28', 'user'),
(65, 'عزه حسين', 'zhhsyn52@gmail.com', NULL, '$2y$12$wvvrvVD93bQ9BirDsJthH.GibuqnmrVKrVr/CMd/YrOOXOssOfs..', NULL, '2026-04-02 15:16:38', '2026-04-02 15:16:38', 'user'),
(66, 'Doaa kamal', 'nurse_doaa@gamma.scan', NULL, '$2y$12$NnfatIKqftvOcdGOWyRbxeG.E7pYA7AzsJNpTQ6ob9Lgz30uV/0m.', NULL, '2026-04-02 16:04:47', '2026-04-02 16:04:47', 'user'),
(67, 'Abdallah Raafat', 'Abdallah@gamma.scan', NULL, '$2y$12$MUIp3XvJGc.HLmrIJifzaeMY.IrSpQuiZu6D3NQMjF7Ziw5LKiiYW', NULL, '2026-04-03 14:01:07', '2026-04-03 14:01:07', 'user');

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
-- Indexes for table `penalties`
--
ALTER TABLE `penalties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penalties_user_id_foreign` (`user_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `overtimes`
--
ALTER TABLE `overtimes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `penalties`
--
ALTER TABLE `penalties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penalties`
--
ALTER TABLE `penalties`
  ADD CONSTRAINT `penalties_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
