-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2025 at 06:27 PM
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
-- Database: `db_tikako`
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
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `menu_id`, `quantity`, `created_at`, `updated_at`) VALUES
(23, 2, 6, 1, '2025-11-17 12:51:36', '2025-11-17 12:51:36'),
(24, 2, 5, 2, '2025-11-17 12:57:04', '2025-11-17 13:07:31');

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
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `name`, `email`, `rating`, `message`, `created_at`, `updated_at`) VALUES
(1, 'ari', NULL, 5, 'terbaik makanannya', '2025-11-19 14:46:23', '2025-11-19 14:46:23');

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
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `kategori` varchar(255) NOT NULL DEFAULT 'Makanan',
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `is_tersedia` tinyint(1) NOT NULL DEFAULT 1,
  `is_rekomendasi` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nama_menu`, `harga`, `kategori`, `deskripsi`, `foto`, `is_tersedia`, `is_rekomendasi`, `created_at`, `updated_at`) VALUES
(5, 'Ayam Bakar Kampung 1 Ekor Full', 125000, 'Makanan', '-', 'menu_fotos/c0xb9JmDvHze8IOgo5do4PP1PaLP8yRSjvoEYzWq.jpg', 1, 1, '2025-11-14 11:55:24', '2025-11-19 13:00:11'),
(6, 'Nasi Goreng Ikan', 15000, 'Makanan', '-', 'menu_fotos/sXI8wB2JiTcDbRbDQBbDVKhx2DZJZdmoF1v1gbC8.jpg', 1, 1, '2025-11-16 10:57:54', '2025-11-16 15:06:25'),
(7, 'Nasi Goreng Spesial', 20000, 'Makanan', '-', 'menu_fotos/9O5u4s3CGWLg6yqd2q7NerU5DqmPycNnywrGnTY9.jpg', 1, 1, '2025-11-16 10:58:28', '2025-11-16 15:06:44'),
(8, 'Nasi Goreng Bakso', 18000, 'Makanan', '-', 'menu_fotos/gADg4kc0scOmZ9cY3Sq5bRndo2h3His8I7mCHBSo.jpg', 1, 1, '2025-11-16 14:27:51', '2025-11-16 14:53:06'),
(9, 'Nasi Goreng Udang', 20000, 'Makanan', '-', 'menu_fotos/AuET6h2ge66b11jGH43q45CEtfywQhiY6sPSRf4I.jpg', 1, 0, '2025-11-16 14:57:05', '2025-11-16 14:57:05'),
(10, 'Nasi Goreng Sambal Ijo', 20000, 'Makanan', '-', 'menu_fotos/i7pphqnLktullhsahOLxlC0GpXRROGFGulDeqZCz.jpg', 1, 0, '2025-11-16 14:57:58', '2025-11-16 14:57:58'),
(11, 'Es Jeruk', 5000, 'Minuman', '-', 'menu_fotos/tnSa9xmQCpNrRASiCITxbizmSFzrDQN6O99GdaKX.jpg', 1, 0, '2025-11-16 15:57:16', '2025-11-16 15:57:16'),
(12, 'Kentang Goreng', 15000, 'Cemilan', '-', 'menu_fotos/LCKhDD07QlW4XPO8ogzxpJ17gcPNYYYLTs6K8Yed.jpg', 1, 0, '2025-11-16 15:57:51', '2025-11-16 15:57:51'),
(13, 'Tahu Krispi', 15000, 'Cemilan', '-', 'menu_fotos/3zv1QQ7z1aqhIKMxnD7tFiCYtgAeFJlwpjiJWUua.jpg', 1, 0, '2025-11-16 16:17:52', '2025-11-16 16:17:52'),
(14, 'Es Teh', 5000, 'Minuman', '-', 'menu_fotos/E02RBQZDG4esPqQ2IIyoV6ZfO1XNhYPghtYgrURN.jpg', 1, 0, '2025-11-16 16:19:02', '2025-11-16 16:19:02'),
(15, 'Ayam Bakar Kampung + Nasi', 37000, 'Makanan', '-', 'menu_fotos/DOMxw2wk76VQxbiXD95gK1kA0UZKVizRAedLDoYC.jpg', 1, 1, '2025-11-18 15:31:49', '2025-11-19 13:05:28');

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
(4, '2025_11_14_173040_create_menu_table', 1),
(5, '2025_11_15_181231_create_cart_items_table', 2),
(6, '2025_11_15_191445_create_orders_table', 3),
(7, '2025_11_15_191634_create_order_details_table', 3),
(8, '2025_11_16_194542_add_nomor_meja_to_orders_table', 4),
(9, '2025_11_17_003402_update_cart_items_to_use_user_id', 5),
(10, '2025_11_17_003511_update_orders_to_use_user_id', 5),
(11, '2025_11_18_005330_add_role_column_to_users_table', 6),
(12, '2025_11_19_092226_create_feedback_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nomor_meja` varchar(255) DEFAULT NULL,
  `total_price` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Diterima',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `nomor_meja`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(4, 1, '2', 15000, 'Diterima', '2025-11-16 23:03:44', '2025-11-16 23:03:44'),
(5, 1, '2', 15000, 'Diterima', '2025-11-16 23:42:14', '2025-11-16 23:42:14'),
(6, 1, '2', 50000, 'Diterima', '2025-11-17 06:48:35', '2025-11-17 06:48:35'),
(7, 1, '2', 50000, 'Diterima', '2025-11-17 06:56:46', '2025-11-17 06:56:46'),
(8, 1, '2', 50000, 'Diterima', '2025-11-17 06:59:42', '2025-11-17 06:59:42'),
(9, 1, '2', 15000, 'Diterima', '2025-11-17 12:26:04', '2025-11-17 12:26:04'),
(10, 2, '4', 15000, 'Selesai', '2025-11-17 12:47:18', '2025-11-17 21:41:36'),
(11, 3, '6', 30000, 'Sedang Dimasak', '2025-11-17 14:06:42', '2025-11-17 16:47:41'),
(12, 3, '6', 15000, 'Dibatalkan', '2025-11-17 16:49:35', '2025-11-17 20:03:39'),
(13, 3, '4', 15000, 'Selesai', '2025-11-17 16:54:51', '2025-11-17 19:08:10'),
(14, 4, '10', 125000, 'Diterima', '2025-11-18 13:26:54', '2025-11-18 13:26:54'),
(15, 4, '10', 125000, 'Diterima', '2025-11-18 13:49:52', '2025-11-18 13:49:52'),
(16, 4, '7', 15000, 'Diterima', '2025-11-18 15:02:15', '2025-11-18 15:02:15'),
(17, 4, '9', 15000, 'Diterima', '2025-11-18 15:03:17', '2025-11-18 15:03:17'),
(18, 4, '9', 20000, 'Selesai', '2025-11-18 15:12:10', '2025-11-18 15:59:00'),
(19, 4, '7', 125000, 'Diterima', '2025-11-19 04:35:16', '2025-11-19 04:35:16'),
(20, 4, '3', 375000, 'Diterima', '2025-11-19 12:09:46', '2025-11-19 12:09:46'),
(21, 4, '1', 48000, 'Diterima', '2025-11-19 14:13:49', '2025-11-19 14:13:49'),
(22, 4, '4', 125000, 'Diterima', '2025-11-19 14:17:29', '2025-11-19 14:17:29'),
(23, 4, '3', 20000, 'Diterima', '2025-11-19 14:21:23', '2025-11-19 14:21:23'),
(24, 4, '6', 18000, 'Diterima', '2025-11-19 14:45:33', '2025-11-19 14:45:33');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `menu_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(4, 4, 6, 1, 15000, '2025-11-16 23:03:44', '2025-11-16 23:03:44'),
(5, 5, 6, 1, 15000, '2025-11-16 23:42:14', '2025-11-16 23:42:14'),
(6, 6, 7, 2, 20000, '2025-11-17 06:48:35', '2025-11-17 06:48:35'),
(7, 6, 14, 1, 5000, '2025-11-17 06:48:35', '2025-11-17 06:48:35'),
(8, 6, 11, 1, 5000, '2025-11-17 06:48:35', '2025-11-17 06:48:35'),
(9, 7, 7, 2, 20000, '2025-11-17 06:56:46', '2025-11-17 06:56:46'),
(10, 7, 14, 1, 5000, '2025-11-17 06:56:46', '2025-11-17 06:56:46'),
(11, 7, 11, 1, 5000, '2025-11-17 06:56:46', '2025-11-17 06:56:46'),
(12, 8, 7, 2, 20000, '2025-11-17 06:59:42', '2025-11-17 06:59:42'),
(13, 8, 14, 1, 5000, '2025-11-17 06:59:42', '2025-11-17 06:59:42'),
(14, 8, 11, 1, 5000, '2025-11-17 06:59:42', '2025-11-17 06:59:42'),
(15, 9, 6, 1, 15000, '2025-11-17 12:26:04', '2025-11-17 12:26:04'),
(16, 10, 6, 1, 15000, '2025-11-17 12:47:18', '2025-11-17 12:47:18'),
(17, 11, 5, 2, 15000, '2025-11-17 14:06:42', '2025-11-17 14:06:42'),
(18, 12, 6, 1, 15000, '2025-11-17 16:49:35', '2025-11-17 16:49:35'),
(19, 13, 5, 1, 15000, '2025-11-17 16:54:51', '2025-11-17 16:54:51'),
(20, 14, 5, 1, 125000, '2025-11-18 13:26:54', '2025-11-18 13:26:54'),
(21, 15, 5, 1, 125000, '2025-11-18 13:49:52', '2025-11-18 13:49:52'),
(22, 16, 6, 1, 15000, '2025-11-18 15:02:15', '2025-11-18 15:02:15'),
(23, 17, 6, 1, 15000, '2025-11-18 15:03:17', '2025-11-18 15:03:17'),
(24, 18, 7, 1, 20000, '2025-11-18 15:12:10', '2025-11-18 15:12:10'),
(25, 19, 5, 1, 125000, '2025-11-19 04:35:16', '2025-11-19 04:35:16'),
(26, 20, 5, 3, 125000, '2025-11-19 12:09:46', '2025-11-19 12:09:46'),
(27, 21, 6, 2, 15000, '2025-11-19 14:13:49', '2025-11-19 14:13:49'),
(28, 21, 8, 1, 18000, '2025-11-19 14:13:49', '2025-11-19 14:13:49'),
(29, 22, 5, 1, 125000, '2025-11-19 14:17:29', '2025-11-19 14:17:29'),
(30, 23, 7, 1, 20000, '2025-11-19 14:21:23', '2025-11-19 14:21:23'),
(31, 24, 8, 1, 18000, '2025-11-19 14:45:33', '2025-11-19 14:45:33');

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
('06mUwzElM6E8BObKWINVzUXVAEoxdNRJXkP4YV7X', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZktyTElicVdtN0JaWTd3Z2xnTVF0OGVYMFI5OWsxbkR3RFFWYlJUMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9xcmNvZGUiO3M6NToicm91dGUiO3M6MTg6ImFkbWluLnFyY29kZS5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1763569767),
('8qljIbaGtcL0LJwA68LOJkbaqR2z5JVyChr1jNkw', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2FmMzZ0TDl5RFplYlhXMGo2d1ZMRG9CdFN6d2RrckhMcmRBeGRHRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly8xOTIuMTY4LjEuMTE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJiZXJhbmRhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763571601),
('OIBmDZ81zdvnfKo4e3JT12sUwxZOGvDJsJQJUYNv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOGJNdXAzcDFvUzVJZU9lOHlqQ1g5S2pjSHlQQUVBOGNOTnZXM0lLQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJiZXJhbmRhIjt9fQ==', 1763567817),
('OyDYUAYUedNrakcH0bexKeXkYpwl9Kmjm8wIoK5P', 2, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaU8yMXU3RWkyZkhLSnVKVXlxUUV0cnluangzaWw4YnFXZ0pYaTlmdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xOTIuMTY4LjEuMTE6ODAwMC9hZG1pbi9xcmNvZGUiO3M6NToicm91dGUiO3M6MTg6ImFkbWluLnFyY29kZS5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1763571652);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'dayat', 'firmanhidayat610@gmail.com', 'user', NULL, '$2y$12$sXVAaMS6tZ6hRVnIQvl8duHWF30tQsia3VnvG/FJqs1UUUIV.fDyq', NULL, '2025-11-16 18:01:37', '2025-11-17 08:05:03'),
(2, 'renan', 'firmanhidayat00@gmail.com', 'admin', NULL, '$2y$12$Q0kVxmI.FLk7qeShtbYls.Q29hc5qIYxOAdbDU9JOYX6iC6aSfJP.', NULL, '2025-11-17 12:27:42', '2025-11-17 12:27:42'),
(3, 'nur', 'firmanhidayat0@gmail.com', 'user', NULL, '$2y$12$CfM2YYJjFFqsa.VPvIj9yuQ6FqotrCVyZO7pkDPlFp.s72XWviWTW', NULL, '2025-11-17 13:41:54', '2025-11-17 13:41:54'),
(4, 'ari', 'gorvaoel@gmail.com', 'user', NULL, '$2y$12$PVQsqdy2NAOcxBdZGeltF.VEX8ZJEiBGhytMdx.K0j4hj5xQtt5mC', NULL, '2025-11-17 19:04:21', '2025-11-17 19:04:21');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_menu_id_foreign` (`menu_id`),
  ADD KEY `cart_items_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
