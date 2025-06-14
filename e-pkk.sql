-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2025 at 07:52 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-pkk`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangs`
--

CREATE TABLE `barangs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_barang` enum('makanan','kerajinan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'makanan',
  `harga_barang` int NOT NULL,
  `jumlah_barang` int NOT NULL,
  `foto_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `keterangan_barang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `harga_pokok` decimal(10,2) NOT NULL DEFAULT '0.00',
  `keuntungan_per_unit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jumlah_barang_awal` int NOT NULL DEFAULT '0',
  `jumlah_terjual` int NOT NULL DEFAULT '0',
  `total_harga_terjual` decimal(15,2) NOT NULL DEFAULT '0.00',
  `keuntungan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `stok_tersisa` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barangs`
--

INSERT INTO `barangs` (`id`, `user_id`, `nama_barang`, `kategori_barang`, `harga_barang`, `jumlah_barang`, `foto_barang`, `total`, `keterangan_barang`, `created_at`, `updated_at`, `harga_pokok`, `keuntungan_per_unit`, `jumlah_barang_awal`, `jumlah_terjual`, `total_harga_terjual`, `keuntungan`, `stok_tersisa`) VALUES
(5, 2, 'Toples Rajut', 'kerajinan', 34500, 12, 'images/pCsRmNvGaaNUqhnZsQNYzZmMDxYICFXY8h4Y4x3e.jpg', NULL, NULL, '2024-12-07 05:54:44', '2025-05-26 06:16:11', 33000.00, 0.00, 16, 0, 0.00, 0.00, 0),
(8, 4, 'Rajut Bunga Tulip', 'kerajinan', 26500, 20, 'images/Ow20D0M4OFBU04ZywGzPghxIlficKmkSMWLtlBCs.jpg', NULL, 'Tersedia dalam berbagai warna', '2024-12-07 05:58:01', '2025-06-14 00:52:24', 25000.00, 0.00, 20, 0, 0.00, 0.00, 0),
(11, 2, 'Bunga Lavender', 'kerajinan', 29500, 9853, 'images/dAHAVAjI9AxE26TsRnBcd5X4h5KDcfjjp6gd9VWN.jpg', NULL, NULL, '2024-12-09 18:39:28', '2025-05-14 19:40:33', 28000.00, 0.00, 9867, 0, 0.00, 0.00, 0),
(13, 2, 'Dimsum', 'makanan', 9000, 30, 'images/vmKT4CrsYemSKSt0MNpg5LTm8tGTyW4MKpsXl7eA.jpg', NULL, NULL, '2024-12-09 20:03:38', '2025-06-02 23:43:21', 7500.00, 0.00, 30, 0, 0.00, 0.00, 0),
(18, 15, 'Mie Ayam', 'makanan', 9500, 183, 'images/O6ooC1lugGoABylaSP4wIz5c4665jnA33Pq9g1Vv.jpg', NULL, NULL, '2024-12-12 21:19:06', '2025-06-02 23:36:46', 8000.00, 0.00, 185, 0, 0.00, 0.00, 0),
(20, 3, 'Daging Ayam', 'makanan', 9000, 20, 'images/lqp0zHODKBol7DJGFmEOl7Aft2rImdwOpBeGSjhj.jpg', NULL, 'Daging', '2024-12-18 18:04:55', '2025-06-14 00:51:33', 7500.00, 0.00, 20, 3, 0.00, 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_11_24_055849_create_barangs_table', 1),
(5, '2024_11_25_100842_add_role_and_kode_to_users_table', 1),
(6, '2024_11_26_152208_add_harga_pokok_to_barangs_table', 1),
(7, '2024_11_26_152334_create_transaksis_table', 1),
(8, '2024_11_27_100500_add_total_harga_terjual_and_keuntungan_to_barangs_table', 1),
(9, '2024_11_27_101453_add_keuntungan_per_unit_to_barangs_table', 1),
(10, '2024_11_27_141507_create_orders_table', 1),
(11, '2024_11_27_141537_create_order_items_table', 1),
(12, '2024_11_30_142634_add_stok_tersisa_to_barangs_table', 1),
(13, '2024_12_07_063031_add_foto_to_users_table', 1),
(14, '2024_12_08_062018_add_payment_method_to_orders_table', 2),
(15, '2024_12_10_162856_create_purchases_table', 3),
(16, '2025_05_11_003326_create_feedback_table', 4),
(17, '2025_05_11_177086_create_feedback_table', 5),
(18, '2025_05_11_177085_create_feedback_table', 6),
(19, '2025_05_11_020208_create_wishlists_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `created_at`, `updated_at`, `payment_method`) VALUES
(1, 8, 10500.00, '2025-05-11 01:02:52', '2025-05-11 01:02:52', NULL),
(2, 8, 28000.00, '2025-05-11 01:37:53', '2025-05-11 01:37:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `status` enum('pending','completed','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `user_id`, `barang_id`, `jumlah`, `price`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 11, 1, 31000.00, 31000.00, 'cancelled', '2025-05-03 11:35:22', '2025-05-10 16:27:19'),
(2, 8, 11, 1, 31000.00, 31000.00, 'completed', '2025-05-03 11:39:37', '2025-05-10 16:26:21'),
(3, 1, 18, 2, 10500.00, 21000.00, 'completed', '2025-05-03 12:14:17', '2025-05-10 16:34:59'),
(4, 8, 11, 1, 31000.00, 31000.00, 'pending', '2025-05-04 00:12:28', '2025-05-04 00:12:28'),
(5, 16, 5, 1, 36000.00, 36000.00, 'pending', '2025-05-04 00:43:59', '2025-05-04 00:43:59'),
(6, 6, 18, 3, 10500.00, 31500.00, 'completed', '2025-05-04 21:53:54', '2025-05-10 16:28:39'),
(7, 8, 18, 1, 10500.00, 10500.00, 'completed', '2025-05-14 19:33:11', '2025-05-14 19:33:11'),
(8, 8, 18, 1, 10500.00, 10500.00, 'completed', '2025-05-14 19:40:33', '2025-05-14 19:40:33'),
(9, 8, 20, 1, 10500.00, 10500.00, 'completed', '2025-05-14 19:40:33', '2025-05-14 19:40:33'),
(10, 8, 11, 1, 31000.00, 31000.00, 'completed', '2025-05-14 19:40:33', '2025-05-14 19:40:33'),
(11, 8, 20, 2, 10500.00, 21000.00, 'completed', '2025-05-14 19:45:38', '2025-05-14 19:45:38'),
(12, 8, 20, 1, 10500.00, 10500.00, 'completed', '2025-05-14 19:46:23', '2025-05-14 19:46:23'),
(13, 8, 20, 1, 10500.00, 10500.00, 'completed', '2025-05-14 19:50:04', '2025-05-14 19:50:04'),
(14, 16, 5, 1, 34500.00, 34500.00, 'completed', '2025-05-26 06:16:12', '2025-06-02 23:29:57'),
(15, 16, 18, 1, 9500.00, 9500.00, 'pending', '2025-06-02 23:36:46', '2025-06-02 23:36:46');

-- --------------------------------------------------------

--
-- Table structure for table `sarans`
--

CREATE TABLE `sarans` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sarans`
--

INSERT INTO `sarans` (`id`, `nama`, `email`, `pesan`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Sigmas', 'sigma@gmail.com', 'xfhldgdfbgldfglgl;sk', '2025-05-10 18:45:49', '2025-05-10 18:45:49', NULL),
(2, 'Timothy', 'fokuscrypto@gmail.com', 'Buat agar layout tidak berantakan di HP', '2025-05-11 02:29:43', '2025-05-11 02:29:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('59pPiXAc2e3jNSkKzAVe2pxY2lCPQrBPtFQ69BIP', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU3ZCbkJaNHlONUFURUUwVm1ZVFE2cEVuUlN2VTNTWGRrTjl1b3p4biI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9iYXJhbmdzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1749234435),
('kHD36VccXf9iFW405F3DVqpVbfRw2xrSq0uHpLnx', 15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYmdWQnNRZXFXa2ZaOGk2ajlLYjZvZWRoaHNRWlZuQkYyWGd1bWk1VSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9maWxlLzE1Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTU7fQ==', 1749224655),
('lzFv0TU4MRiY9gtukPRGe8FKavJIHHMs3ScJuRVJ', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUHM5WDVOOVVJQzVBT2hheFY1YXVvSXpEMENPRExQdnlONzEzSmtFQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjg7fQ==', 1749267244),
('sdwcmvehOyRnOPFm0BXzU6cZHmFgrgkTBXKnV1Jw', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMmo1NmlST2dVOWw2azVHbTNjNTVmQlphSlY0SGpiSEJvTDVzdlpYSCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo4O30=', 1749264358),
('uB7rLrC1q5J8lp146FNp4Z5xn9DvDvx6BrSpcgCr', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieVFXV0F0RmxKeTYyWTRuUzFyS2RDTHRDM2VkVVBnNlRLVTJxdDZBRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1749887559);

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `keuntungan` decimal(10,2) NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('user','supplier','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `about` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `birth_date` date DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_pendaftaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `about`, `birth_date`, `foto`, `kode_pendaftaran`) VALUES
(1, 'Adnan', 'adnan', 'adnan@gmail.com', NULL, '$2y$12$HeFrqSzS4G1F5ar3VEMBOuvjU91EHQWZ.IsNtxW7AZyO83uIyWCdK', NULL, '2024-12-07 00:52:02', '2024-12-09 23:10:57', 'user', NULL, NULL, 'photos/1733557921_22.jpg', NULL),
(2, 'Admin PKK', 'admin', 'admin@gmail.com', NULL, '$2y$12$QGN8lP90uG.DvHKjtqGGTuQ7wOvA09G41dtraPkKGiGUqNhBGJ0fW', NULL, '2024-12-07 00:52:38', '2024-12-15 06:08:17', 'admin', 'Admin PKK SMK Negeri 8 Jakarta', '1965-09-30', 'photos/1733557958_SMK_Negeri_8_Jakarta.png', NULL),
(3, 'Suplier', 'supplier', 'suplier@gmail.com', NULL, '$2y$12$9G/FlSHmboZ3xyogGBBOuunmD5xtUcx2dKewmjj/Th8hR7/UI7emS', NULL, '2024-12-07 00:56:08', '2024-12-07 00:56:08', 'supplier', NULL, NULL, 'photos/1733558168_logo.png', NULL),
(4, 'Ammar', 'ammar', 'ammar@gmail.com', NULL, '$2y$12$8mQLGdck/VBM9tXn78tBiuKoJL5qcK0ycc9pBieTJ7zzhAqh7.sau', NULL, '2024-12-07 00:57:00', '2024-12-07 00:57:00', 'supplier', NULL, NULL, 'photos/1733558220_6.jpg', NULL),
(5, 'Zey', 'zey', 'zey@gmail.com', NULL, '$2y$12$qttzNqwyzq4R01nEFKrn9eyZvQfUpc3kAVqdtN5D4oRWeKtb8.aSC', NULL, '2024-12-07 00:58:08', '2024-12-07 00:58:08', 'supplier', NULL, NULL, 'photos/1733558288_21.jpg', NULL),
(6, 'Zaki', 'zaki', 'user@gmail.com', NULL, '$2y$12$SE5R6TUPd96Qb3nVUBpHM.SF3rx2puDiMKoFAdrTUO.DrHfs6Ae66', NULL, '2024-12-07 05:00:52', '2024-12-10 17:18:38', 'user', NULL, NULL, 'photos/1733573610_35.JPG', NULL),
(7, 'Hiqma 3H', 'hiqma', 'higma@gmail.com', NULL, '$2y$12$td556iOdgx2206yY2HlDS.frnBWOhJptUa9FVrIuT6X2zcSfmVWzu', NULL, '2024-12-08 04:01:59', '2024-12-08 04:03:51', 'supplier', NULL, NULL, 'photos/1733655719_17.jpg', NULL),
(8, 'Gagah', 'gagah', 'gagah@gmail.com', NULL, '$2y$12$ba1WmZeZKHCtDucSLP0Yo.S4tQuf7zE4E0CAP.LZMreTWXlpVtJq.', NULL, '2024-12-08 04:06:26', '2025-05-14 07:15:04', 'user', NULL, NULL, 'photos/1733655985_33.jpg', NULL),
(9, 'Zei', 'zei', 'user7@gmail.com', NULL, '$2y$12$uZUit5n0pVJWEJF.0VcGCeeoZ0jdPEPNj10Aar8TbjqYh70QuMrd2', NULL, '2024-12-08 23:06:23', '2024-12-08 23:06:23', 'user', NULL, NULL, 'photos/1733724383_DSC08363.JPG', NULL),
(10, 'Omar Kampang', 'omar', 'oieee@gmail.com', NULL, '$2y$12$OgCM8jutkF1sglUMddkX2OVF.3JE5ItfkGi0EhMaBkmXqBMwxZ5aO', NULL, '2024-12-09 19:58:08', '2024-12-12 04:59:43', 'supplier', NULL, NULL, 'photos/1733799487_19.jpg', NULL),
(11, 'Gagah', 'gagahgolbie', 'wisanggagah@gmail.com', NULL, '$2y$12$frVcQthFfRVoTlZ0ou80iuXqpsG3dA5qfgWQQ.DJlUnMGtfhC1CjK', NULL, '2024-12-10 18:40:38', '2024-12-15 09:17:44', 'user', 'Hello World', '2007-10-03', 'photos/1733881431_akademi wigga.jpg', NULL),
(12, 'Admiin', 'admin2', 'adminganss28@gmail.com', NULL, '', NULL, '2024-12-11 23:14:23', '2024-12-11 23:14:23', 'admin', NULL, NULL, NULL, NULL),
(13, 'Gagah Baik', 'gagah2', 'admin69@gmail.com', NULL, '$2y$12$rEYzBAvVDBdVYjENRMVG3egFB46d4QglZrlbnBseP16Wpg5cIn37i', NULL, '2024-12-11 23:24:38', '2024-12-11 23:44:42', 'admin', NULL, NULL, 'photos/1733985882_BSOD but.jpg', NULL),
(14, 'Sigma Boy', 'sigma', 'sigma@gmail.com', NULL, '$2y$12$cM.xjJ2mGRZkQEWS9v22nOfWkFWcE/b3FYSZWXfT5BT7ssFlNxrUu', NULL, '2024-12-11 23:33:52', '2024-12-11 23:35:56', 'supplier', NULL, NULL, 'photos/1733985356_download (1).jpg', NULL),
(15, 'Fariz', 'farizz', 'farizz@gmail.com', NULL, '$2y$12$iOEaDGAmUWoHv.R3vgz1eu4ESZGO2yaE0L0dsfkCfIOduCPlY88Ye', NULL, '2024-12-12 21:04:40', '2025-05-25 09:36:15', 'supplier', NULL, NULL, NULL, NULL),
(16, 'userzey', 'userzey', 'userzey@gmail.com', NULL, '$2y$12$9AJJCpPgjUvD.IX3OW333OxgslrakH65pchXVBICiWZTlymxFXPtq', NULL, '2024-12-12 21:41:01', '2024-12-12 21:41:01', 'user', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `barang_id`, `created_at`, `updated_at`) VALUES
(9, 8, 20, '2025-05-23 22:46:38', '2025-05-23 22:46:38'),
(12, 8, 18, '2025-05-24 19:05:18', '2025-05-24 19:05:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangs`
--
ALTER TABLE `barangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangs_user_id_foreign` (`user_id`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `sarans`
--
ALTER TABLE `sarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sarans_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksis_user_id_index` (`user_id`),
  ADD KEY `transaksis_barang_id_index` (`barang_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_barang_id_unique` (`user_id`,`barang_id`),
  ADD KEY `wishlists_barang_id_foreign` (`barang_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sarans`
--
ALTER TABLE `sarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barangs`
--
ALTER TABLE `barangs`
  ADD CONSTRAINT `barangs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sarans`
--
ALTER TABLE `sarans`
  ADD CONSTRAINT `sarans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
