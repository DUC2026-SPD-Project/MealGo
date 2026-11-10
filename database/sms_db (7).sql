-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 07, 2026 at 11:30 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `clock_in` time NOT NULL,
  `clock_out` time DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'present',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `user_id`, `date`, `clock_in`, `clock_out`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-01-30', '11:19:18', NULL, 'present', '2026-01-30 04:19:18', '2026-01-30 04:19:18'),
(2, 2, '2026-02-05', '13:06:20', NULL, 'present', '2026-02-05 06:06:20', '2026-02-05 06:06:20'),
(3, 1, '2026-02-07', '05:28:42', '10:28:38', 'present', '2026-02-06 22:28:42', '2026-02-07 03:28:38'),
(4, 2, '2026-02-07', '11:03:57', '11:04:08', 'present', '2026-02-07 04:03:57', '2026-02-07 04:04:08'),
(5, 1, '2026-02-15', '01:01:07', '01:01:18', 'present', '2026-02-14 18:01:07', '2026-02-14 18:01:18');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin_notifications', 'a:1:{i:0;a:8:{s:4:\"type\";s:9:\"new_order\";s:5:\"title\";s:24:\"New Order Received! 🎉\";s:7:\"message\";s:35:\"Order #ORD-20260215-ABBB38 - $17.69\";s:8:\"order_id\";i:37;s:12:\"order_number\";s:19:\"ORD-20260215-ABBB38\";s:13:\"customer_name\";s:11:\"Nann AmmZem\";s:5:\"total\";s:5:\"17.69\";s:9:\"timestamp\";s:27:\"2026-02-15T00:56:25.316223Z\";}}', 1771203385),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:27:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"view stock\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"manage stock\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:10:\"make sales\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:16:\"manage employees\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:14:\"view dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:10:\"access pos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:13:\"view products\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:15:\"create products\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:13:\"edit products\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:15:\"delete products\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"view categories\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:17:\"manage categories\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:14:\"view employees\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:14:\"view customers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:16:\"manage customers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:14:\"view suppliers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:16:\"manage suppliers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:15:\"view promotions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:17:\"manage promotions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:12:\"view reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:14:\"export reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:15:\"view attendance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:17:\"manage attendance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:10:\"view roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:12:\"manage roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:13:\"view settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:15:\"manage settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"staff\";s:1:\"c\";s:3:\"web\";}}}', 1771203697);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', '2026-01-30 02:42:27', '2026-01-30 10:01:15'),
(2, 'Beverages', '2026-01-30 02:42:27', '2026-01-30 02:42:27'),
(3, 'Snacks', '2026-01-30 02:42:27', '2026-01-30 02:42:27'),
(4, 'Household', '2026-01-30 02:42:27', '2026-01-30 02:42:27'),
(6, 'Fresh Food', '2026-01-30 02:42:27', '2026-01-30 02:42:27'),
(7, 'Cafe', '2026-01-31 00:49:50', '2026-01-31 00:49:50');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `name`, `phone`, `email`, `address`, `created_at`, `updated_at`) VALUES
(1, 10, 'da', NULL, 'dada@gmail.com', NULL, '2026-02-05 05:58:36', '2026-02-05 05:58:36'),
(2, 11, 'sa', NULL, 'sa@gmail.com', NULL, '2026-02-05 23:16:17', '2026-02-05 23:16:17');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
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
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_24_123038_create_categories_table', 1),
(5, '2026_01_24_104328_create_permission_tables', 1),
(6, '2026_01_24_123701_create_suppliers_table', 1),
(7, '2026_01_27_142309_create_customers_table', 1),
(8, '2026_01_27_153721_create_promotions_table', 1),
(9, '2027_01_13_065621_create_products_table', 1),
(10, '2027_01_14_000000_create_sales_tables', 1),
(11, '2027_01_15_082408_add_checkout_fields_to_sales_table', 1),
(12, '2027_01_16_082442_add_product_name_to_sale_items_table', 1),
(13, '2028_01_27_151058_create_stock_transactions_table', 1),
(14, '2028_01_27_152558_create_attendances_table', 1),
(15, '2026_01_30_143737_add_invoice_fields_to_sales_table', 2),
(16, '2027_02_05_000000_add_user_id_to_customers_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view stock', 'web', '2026-01-30 02:42:27', '2026-01-30 02:42:27'),
(2, 'manage stock', 'web', '2026-01-30 02:42:27', '2026-01-30 02:42:27'),
(3, 'make sales', 'web', '2026-01-30 02:42:27', '2026-01-30 02:42:27'),
(4, 'manage employees', 'web', '2026-01-30 02:42:27', '2026-01-30 02:42:27'),
(5, 'view dashboard', 'web', '2026-02-05 07:01:49', '2026-02-05 07:01:49'),
(6, 'access pos', 'web', '2026-02-05 07:01:49', '2026-02-05 07:01:49'),
(7, 'view products', 'web', '2026-02-05 07:01:49', '2026-02-05 07:01:49'),
(8, 'create products', 'web', '2026-02-05 07:01:49', '2026-02-05 07:01:49'),
(9, 'edit products', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(10, 'delete products', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(11, 'view categories', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(12, 'manage categories', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(13, 'view employees', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(14, 'view customers', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(15, 'manage customers', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(16, 'view suppliers', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(17, 'manage suppliers', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(18, 'view promotions', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(19, 'manage promotions', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(20, 'view reports', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(21, 'export reports', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(22, 'view attendance', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(23, 'manage attendance', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(24, 'view roles', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(25, 'manage roles', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(26, 'view settings', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50'),
(27, 'manage settings', 'web', '2026-02-05 07:01:50', '2026-02-05 07:01:50');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `supplier_id` bigint UNSIGNED DEFAULT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_kh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `qty` int NOT NULL DEFAULT '0',
  `alert_qty` int NOT NULL DEFAULT '5',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `supplier_id`, `name_en`, `name_kh`, `barcode`, `cost_price`, `sale_price`, `qty`, `alert_qty`, `image`, `status`, `description`, `created_at`, `updated_at`) VALUES
(18, 6, 4, 'Berger', 'ប៊ឺហ្គឺ', '1111', 4.00, 2.00, 9, 10, 'products/1769849944_697dc4583e656.png', 'active', 'Yummy', '2026-01-31 01:59:04', '2026-02-06 11:04:48'),
(19, 7, 4, 'Hot Capuchino', 'កាពូឈីណូ', '2222', 3.00, 4.00, 48, 10, 'products/1770441650_6986cbb29be36.png', 'active', 'Relax with it.', '2026-01-31 02:00:18', '2026-02-06 22:20:50'),
(21, 2, 4, 'Coca Cola', 'ខូឡា', '12345', 4.00, 4.00, 9, 10, 'products/1770440933_6986c8e50bc40.png', 'active', 'Sweet', '2026-01-31 19:18:01', '2026-02-07 03:56:54'),
(22, 2, 4, 'Moutai', 'ស្រាស', '11222', 40.00, 45.00, 49, 10, 'products/1770441192_6986c9e82bcc3.jpg', 'active', 'Jeat', '2026-02-06 22:13:12', '2026-02-06 22:53:51'),
(23, 4, NULL, 'PopCorn', 'ពោតផ្ទុះ', '41414', 2.00, 2.50, 21, 10, 'products/1770441403_6986cabbb14c7.jpg', 'active', 'Jeat\r\njeat\r\njeat', '2026-02-06 22:16:43', '2026-02-14 17:58:55'),
(24, 6, 4, 'Banana', 'ចេកទុំ', '11111', 3.00, 3.50, 7, 10, 'products/1770441608_6986cb88089bd.jpg', 'active', 'jeat klng nas', '2026-02-06 22:20:08', '2026-02-14 17:56:10'),
(25, 7, 4, 'Hot Americano', 'កាហ្វេខ្មៅ', '14151', 2.00, 2.50, 50, 10, 'products/1770441942_6986ccd60bccf.jpg', 'active', 'jeat dl kor', '2026-02-06 22:25:42', '2026-02-06 22:25:42'),
(26, 1, 4, 'Type-C Cable', 'ខ្សែរសាក', '543213', 3.00, 3.50, 15, 10, 'products/1770442077_6986cd5d812b9.jpg', 'active', 'gggggg', '2026-02-06 22:27:57', '2026-02-06 22:27:57');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_percent` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `name`, `discount_percent`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Chinese New Year', 30, '2026-02-01', '2026-02-02', 'active', '2026-01-31 00:48:37', '2026-01-31 00:48:37');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-01-30 02:42:27', '2026-01-30 02:42:27'),
(2, 'staff', 'web', '2026-01-30 02:42:27', '2026-01-30 02:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(3, 2),
(5, 2),
(6, 2),
(7, 2),
(14, 2),
(20, 2),
(22, 2),
(23, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `invoice_date` timestamp NULL DEFAULT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `order_number`, `invoice_number`, `user_id`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `city`, `postal_code`, `notes`, `subtotal`, `total_price`, `tax`, `shipping`, `total`, `status`, `invoice_date`, `due_date`, `payment_method`, `created_at`, `updated_at`) VALUES
(3, 'ORD-20260130-9AAABF', NULL, 1, 'John Doe', 'john.doe@example.com', '+1 (555) 123-4567', '123 Main Street, Apartment 4B', 'New York', '10001', 'Please deliver during business hours', 125.00, 147.49, 12.50, 9.99, 147.49, 'completed', NULL, NULL, 'cash', '2026-01-30 04:16:41', '2026-01-30 04:16:41'),
(4, 'ORD-20260130-8809E3', NULL, 1, 'John Doe', 'john.doe@example.com', '+1 (555) 123-4567', '123 Main Street, Apartment 4B', 'New York', '10001', 'Please deliver during business hours', 125.00, 147.49, 12.50, 9.99, 147.49, 'completed', NULL, NULL, 'cash', '2026-01-30 04:17:12', '2026-01-30 04:17:12'),
(5, 'ORD-20260130-A44F6F', NULL, 4, 'nann', 'nannammzem7383@gmail.com', '+855 093747807', 'phnom penh', 'Phnom Penh', '18000', NULL, 125.00, 147.49, 12.50, 9.99, 147.49, 'completed', NULL, NULL, 'cash', '2026-01-30 04:18:18', '2026-01-30 04:18:18'),
(6, 'ORD-20260130-B3A684', NULL, 4, 'nann', 'nannammzem7383@gmail.com', '+855 093747807', 'phnom penh', 'Phnom Penh', '18000', NULL, 125.00, 147.49, 12.50, 9.99, 147.49, 'completed', NULL, NULL, 'cash', '2026-01-30 04:26:03', '2026-01-30 04:26:03'),
(7, 'ORD-20260130-05550F', 'INV-2026-0001', 4, 'hah', 'nannammzem7383@gmail.com', '+855093747807', 'phnom penh', 'Phnom Penh', '18000', NULL, 82.00, 100.19, 8.20, 9.99, 100.19, 'completed', '2026-01-30 07:42:24', '2026-03-01 07:42:24', 'cash', '2026-01-30 07:42:24', '2026-01-30 07:42:24'),
(8, 'ORD-20260130-465FE2', 'INV-2026-0002', 4, 'hah', 'nannammzem7383@gmail.com', '1 093747807', 'phnom penh', 'Phnom Penh', '18000', NULL, 123.00, 145.29, 12.30, 9.99, 145.29, 'completed', '2026-01-30 07:47:48', '2026-03-01 07:47:48', 'cash', '2026-01-30 07:47:48', '2026-01-30 07:47:48'),
(9, 'ORD-20260130-B201CE', 'INV-2026-0003', 4, 'hah', 'nannammzem7383@gmail.com', '+855 093747807', 'phnom penh', 'Phnom Penh', '18000', NULL, 123.00, 145.29, 12.30, 9.99, 145.29, 'completed', '2026-01-30 07:48:11', '2026-03-01 07:48:11', 'cash', '2026-01-30 07:48:11', '2026-01-30 07:48:11'),
(10, 'ORD-20260130-D400DA', 'INV-2026-0004', 4, 'gagag', 'nannammzem7383@gmail.com', '+855 093747807', 'phnom penh', 'Phnom Penh', '18000', NULL, 126.00, 148.59, 12.60, 9.99, 148.59, 'completed', '2026-01-30 07:51:25', '2026-03-01 07:51:25', 'cash', '2026-01-30 07:51:25', '2026-01-30 07:51:25'),
(11, 'ORD-20260130-05F4A7', 'INV-2026-0005', 4, 'bababab', 'nannammzem7383@gmail.com', '+855 093747807', 'phnom penh', 'Phnom Penh', '18000', NULL, 126.00, 148.59, 12.60, 9.99, 148.59, 'completed', '2026-01-30 07:58:08', '2026-03-01 07:58:08', 'cash', '2026-01-30 07:58:08', '2026-01-30 07:58:08'),
(12, 'ORD-20260130-974776', 'INV-2026-0006', 4, 'drtyftguyhui', 'nannammzem7383@gmail.com', '+855 093747807', 'phnom penh', 'Phnom Penh', '18000', NULL, 126.00, 148.59, 12.60, 9.99, 148.59, 'completed', '2026-01-30 08:24:25', '2026-03-01 08:24:25', 'cash', '2026-01-30 08:24:25', '2026-01-30 08:24:25'),
(13, 'POS-20260130-DE85F9', NULL, NULL, 'Test Customer', 'test@example.com', '123456789', NULL, NULL, NULL, NULL, 42.00, 46.20, 4.20, 0.00, 46.20, 'completed', NULL, NULL, 'cash', '2026-01-30 09:00:29', '2026-01-30 09:00:29'),
(14, 'POS-20260130-6B2080', NULL, 1, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 5.00, 5.50, 0.50, 0.00, 5.50, 'completed', NULL, NULL, 'cash', '2026-01-30 09:33:26', '2026-01-30 09:33:26'),
(15, 'POS-20260130-F73485', NULL, 1, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 5.00, 5.50, 0.50, 0.00, 5.50, 'completed', NULL, NULL, 'cash', '2026-01-30 09:38:23', '2026-01-30 09:38:23'),
(16, 'POS-20260130-D8637E', NULL, 1, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 129.00, 141.90, 12.90, 0.00, 141.90, 'completed', NULL, NULL, 'cash', '2026-01-30 09:55:09', '2026-01-30 09:55:09'),
(17, 'ORD-20260131-FDF88E', 'INV-2026-0007', 4, 'bababa', 'nannammzem7383@gmail.com', '+855 093747807', 'phnom penh', 'Phnom Penh', '18000', NULL, 42.00, 56.19, 4.20, 9.99, 56.19, 'completed', '2026-01-30 22:07:27', '2026-03-01 22:07:27', 'cash', '2026-01-30 22:07:27', '2026-01-30 22:07:27'),
(18, 'ORD-20260131-D9E31E', 'INV-2026-0008', 1, 'hah', 'nannammzem7383@gmail.com', '+855 093747807', 'phnom penh', 'Phnom Penh', '18000', NULL, 198.00, 227.79, 19.80, 9.99, 227.79, 'completed', '2026-01-31 00:55:57', '2026-03-02 00:55:57', 'card', '2026-01-31 00:55:57', '2026-01-31 00:55:57'),
(19, 'POS-20260206-5595A5', NULL, 1, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 4.00, 4.40, 0.40, 0.00, 4.40, 'completed', NULL, NULL, 'cash', '2026-02-06 01:49:41', '2026-02-06 01:49:41'),
(20, 'ORD-20260206-8DB8C4', 'INV-2026-0009', 1, 'dada', 'nann@gmail.com', '+1 234567890', 'ppdadadadda', 'pp', '87654', NULL, 4.00, 14.39, 0.40, 9.99, 14.39, 'completed', '2026-02-06 01:51:20', '2026-03-08 01:51:20', 'cash', '2026-02-06 01:51:20', '2026-02-06 01:51:20'),
(21, 'POS-20260206-7005BC', NULL, 2, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 4.00, 4.40, 0.40, 0.00, 4.40, 'completed', NULL, NULL, 'cash', '2026-02-06 09:31:51', '2026-02-06 09:31:51'),
(22, 'POS-20260206-0E56AD', NULL, 2, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 4.00, 4.40, 0.40, 0.00, 4.40, 'completed', NULL, NULL, 'card', '2026-02-06 09:32:16', '2026-02-06 09:32:16'),
(23, 'POS-20260206-F266F3', NULL, 1, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 4.00, 4.40, 0.40, 0.00, 4.40, 'completed', NULL, NULL, 'cash', '2026-02-06 09:49:35', '2026-02-06 09:49:35'),
(24, 'POS-20260206-789E95', NULL, 1, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 8.00, 8.80, 0.80, 0.00, 8.80, 'completed', NULL, NULL, 'card', '2026-02-06 09:49:43', '2026-02-06 09:49:43'),
(25, 'POS-20260206-D3D207', NULL, 2, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 4.00, 4.40, 0.40, 0.00, 4.40, 'completed', NULL, NULL, 'cash', '2026-02-06 10:01:33', '2026-02-06 10:01:33'),
(26, 'POS-20260206-7CD770', NULL, 1, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 4.00, 4.40, 0.40, 0.00, 4.40, 'completed', NULL, NULL, 'cash', '2026-02-06 10:07:19', '2026-02-06 10:07:19'),
(27, 'POS-20260206-CA08BB', NULL, 2, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 4.00, 4.40, 0.40, 0.00, 4.40, 'completed', NULL, NULL, 'cash', '2026-02-06 10:07:56', '2026-02-06 10:07:56'),
(28, 'ORD-20260206-8EB0E7', 'INV-2026-0010', 1, 'iuhytrew', 'nann@gmail.com', '+1 (555) 123-4567', 'ppkjuhygtfrde', 'pp', '87654', NULL, 4.00, 14.39, 0.40, 9.99, 14.39, 'completed', '2026-02-06 11:03:04', '2026-03-08 11:03:04', 'cash', '2026-02-06 11:03:04', '2026-02-06 11:03:04'),
(29, 'POS-20260206-02E457', NULL, 1, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 8.00, 8.80, 0.80, 0.00, 8.80, 'completed', NULL, NULL, 'cash', '2026-02-06 11:04:48', '2026-02-06 11:04:48'),
(30, 'POS-20260206-E4FCFA', NULL, 1, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 4.00, 4.40, 0.40, 0.00, 4.40, 'completed', NULL, NULL, 'cash', '2026-02-06 11:05:18', '2026-02-06 11:05:18'),
(31, 'POS-20260207-FD9B6E', NULL, 1, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 45.00, 49.50, 4.50, 0.00, 49.50, 'completed', NULL, NULL, 'cash', '2026-02-06 22:53:51', '2026-02-06 22:53:51'),
(32, 'ORD-20260207-D5931C', 'INV-2026-0011', 4, 'Nann AmmZem', 'nannammzem7383@gmail.com', '+855 93747807', 'phnom penh', 'Phnom Penh', '18000', NULL, 7.00, 17.69, 0.70, 9.99, 17.69, 'completed', '2026-02-07 03:13:33', '2026-03-09 03:13:33', 'bank_transfer', '2026-02-07 03:13:33', '2026-02-07 03:13:33'),
(33, 'POS-20260207-277A19', NULL, 1, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 7.00, 7.70, 0.70, 0.00, 7.70, 'completed', NULL, NULL, 'cash', '2026-02-07 03:34:26', '2026-02-07 03:34:26'),
(34, 'ORD-20260207-15B80F', 'INV-2026-0012', 4, 'Nann AmmZem', 'nannammzem7383@gmail.com', '+855 093747807', 'phnom penh', 'Phnom Penh', '18000', NULL, 3.50, 13.84, 0.35, 9.99, 13.84, 'completed', '2026-02-07 03:54:25', '2026-03-09 03:54:25', 'card', '2026-02-07 03:54:25', '2026-02-07 03:54:25'),
(35, 'POS-20260207-6086D7', NULL, 1, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 8.00, 8.80, 0.80, 0.00, 8.80, 'completed', NULL, NULL, 'cash', '2026-02-07 03:56:54', '2026-02-07 03:56:54'),
(36, 'POS-20260207-B72719', NULL, 1, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 2.50, 2.75, 0.25, 0.00, 2.75, 'completed', NULL, NULL, 'cash', '2026-02-07 03:58:51', '2026-02-07 03:58:51'),
(37, 'ORD-20260215-ABBB38', 'INV-2026-0013', 4, 'Nann AmmZem', 'nannammzem7383@gmail.com', '+855 093747807', 'phnom penh', 'Phnom Penh', '18000', 'Good', 7.00, 17.69, 0.70, 9.99, 17.69, 'completed', '2026-02-14 17:56:10', '2026-03-16 17:56:10', 'card', '2026-02-14 17:56:10', '2026-02-14 17:56:10'),
(38, 'POS-20260215-FE92E2', NULL, 1, 'Walk-in Customer', NULL, NULL, NULL, NULL, NULL, NULL, 2.50, 2.75, 0.25, 0.00, 2.75, 'completed', NULL, NULL, 'cash', '2026-02-14 17:58:55', '2026-02-14 17:58:55');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint UNSIGNED NOT NULL,
  `sale_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `qty` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `product_name`, `quantity`, `qty`, `price`, `total`, `created_at`, `updated_at`) VALUES
(29, 19, 21, 'Coca Cola', 1, 1, 4.00, 4.00, '2026-02-06 01:49:41', '2026-02-06 01:49:41'),
(30, 20, 18, 'Berger', 2, 2, 2.00, 4.00, '2026-02-06 01:51:20', '2026-02-06 01:51:20'),
(31, 21, 21, 'Coca Cola', 1, 1, 4.00, 4.00, '2026-02-06 09:31:51', '2026-02-06 09:31:51'),
(32, 22, 21, 'Coca Cola', 1, 1, 4.00, 4.00, '2026-02-06 09:32:16', '2026-02-06 09:32:16'),
(33, 23, 21, 'Coca Cola', 1, 1, 4.00, 4.00, '2026-02-06 09:49:35', '2026-02-06 09:49:35'),
(34, 24, 21, 'Coca Cola', 1, 1, 4.00, 4.00, '2026-02-06 09:49:43', '2026-02-06 09:49:43'),
(35, 24, 19, 'Capuchino', 1, 1, 2.00, 2.00, '2026-02-06 09:49:43', '2026-02-06 09:49:43'),
(36, 24, 18, 'Berger', 1, 1, 2.00, 2.00, '2026-02-06 09:49:43', '2026-02-06 09:49:43'),
(37, 25, 21, 'Coca Cola', 1, 1, 4.00, 4.00, '2026-02-06 10:01:33', '2026-02-06 10:01:33'),
(38, 26, 21, 'Coca Cola', 1, 1, 4.00, 4.00, '2026-02-06 10:07:19', '2026-02-06 10:07:19'),
(39, 27, 21, 'Coca Cola', 1, 1, 4.00, 4.00, '2026-02-06 10:07:56', '2026-02-06 10:07:56'),
(40, 28, 18, 'Berger', 2, 2, 2.00, 4.00, '2026-02-06 11:03:04', '2026-02-06 11:03:04'),
(41, 29, 21, 'Coca Cola', 1, 1, 4.00, 4.00, '2026-02-06 11:04:48', '2026-02-06 11:04:48'),
(42, 29, 19, 'Capuchino', 1, 1, 2.00, 2.00, '2026-02-06 11:04:48', '2026-02-06 11:04:48'),
(43, 29, 18, 'Berger', 1, 1, 2.00, 2.00, '2026-02-06 11:04:48', '2026-02-06 11:04:48'),
(44, 30, 21, 'Coca Cola', 1, 1, 4.00, 4.00, '2026-02-06 11:05:18', '2026-02-06 11:05:18'),
(45, 31, 22, 'Moutai', 1, 1, 45.00, 45.00, '2026-02-06 22:53:51', '2026-02-06 22:53:51'),
(46, 32, 24, 'Banana', 2, 2, 3.50, 7.00, '2026-02-07 03:13:33', '2026-02-07 03:13:33'),
(47, 33, 24, 'Banana', 2, 2, 3.50, 7.00, '2026-02-07 03:34:26', '2026-02-07 03:34:26'),
(48, 34, 24, 'Banana', 1, 1, 3.50, 3.50, '2026-02-07 03:54:25', '2026-02-07 03:54:25'),
(49, 35, 21, 'Coca Cola', 2, 2, 4.00, 8.00, '2026-02-07 03:56:54', '2026-02-07 03:56:54'),
(50, 36, 23, 'PopCorn', 1, 1, 2.50, 2.50, '2026-02-07 03:58:51', '2026-02-07 03:58:51'),
(51, 37, 24, 'Banana', 2, 2, 3.50, 7.00, '2026-02-14 17:56:10', '2026-02-14 17:56:10'),
(52, 38, 23, 'PopCorn', 1, 1, 2.50, 2.50, '2026-02-14 17:58:55', '2026-02-14 17:58:55');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('lGZQ69PBXIyZm5Qx3yADxzHQ8jZd23KFPeA1bZjE', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVjlOQmNKQjdjNjk5dFdOSWJXeW4yZlRIMDF3ZUxsNXZwT2o2Q0lYeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1794050429),
('Qq41sMCZ8SXJCFQBhBZVUURRyOzaQ91EZKGBy6SR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.143.1 Chrome/150.0.7871.250 Electron/43.7.7 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOHBEVmg2SG1QYjFlOUdtbTZhbWJna3dvcnZuQXUzUHdYQkVmQjlxNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1794050430);

-- --------------------------------------------------------

--
-- Table structure for table `stock_transactions`
--

CREATE TABLE `stock_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(4, 'Nann', '0123456789', 'PP', '2026-01-30 11:36:12', '2026-01-30 11:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@gmail.com', NULL, '$2y$12$FBXTmdPQsY8Dw3fU5YR1xOtONxUkFk.JC6xgpCV6PsfCjD8WEU78.', 'hgbEVQnG0hABZcwkecsrMtQpFmeJijnJ6JQUTBMBiuTaI5Kszeat2Zb5yCAk', '2026-01-30 02:42:27', '2026-01-30 02:42:27'),
(2, 'Staff Member', 'staff@gmail.com', NULL, '$2y$12$mxLqCgHbuOtMIpFKxRH5LOtQTLIMhYz.aaWFfiDXq1uOwFC/BvKqO', NULL, '2026-01-30 02:42:27', '2026-01-30 02:42:27'),
(3, 'Admin', 'admin@sms.com', NULL, '$2y$12$NvjeMqj2rT6O3M9ZhMUVtuFmuWd97UbYMJcLPE8cCh0Zn0TF.ew2a', NULL, '2026-01-30 02:45:21', '2026-01-30 02:45:21'),
(4, 'nann', 'nann@gmail.com', NULL, '$2y$12$AAvwm8yJ4BHff1BpTciydeQZeSLLsktqpx5lu0dECA6Qg3G/aomBW', 'Aw6m6mdYPxEWvrUAOdnnkh2ruckQOu4pSfI9JHccgw1GwwaJkXDhWHUF5XZS', '2026-01-30 02:51:35', '2026-01-30 02:51:35'),
(5, 'ka', 'ka@gmail.com', NULL, '$2y$12$AfJEPyCmmPKkBghTwrQ8Uej7C7qkoGc0ozIPg7Cv86JM4uOJJVzQ2', NULL, '2026-01-31 19:50:50', '2026-01-31 19:50:50'),
(6, 'ngim', 'ngim@gmail.com', NULL, '$2y$12$QB9zBxqkOcbOK7SJqHQ6seCx8CL0bF0sUsEJ0P0oAH47j8QfYHHzy', NULL, '2026-02-05 04:41:43', '2026-02-05 04:41:43'),
(10, 'da', 'dada@gmail.com', NULL, '$2y$12$v6tQP6.EPWXQAJi3LPwRXO.aKWZoLG/m3TrRreGfVTurbi5X8n6ii', NULL, '2026-02-05 05:58:36', '2026-02-05 05:58:36'),
(11, 'sa', 'sa@gmail.com', NULL, '$2y$12$dG9gLB0bGDzWb5OvnOHVmOJktWm.UN3DHaUx4LLOf7xukM.uVVCAC', NULL, '2026-02-05 23:16:17', '2026-02-05 23:16:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_user_id_foreign` (`user_id`);

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_phone_unique` (`phone`),
  ADD KEY `customers_user_id_foreign` (`user_id`);

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
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

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
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_barcode_unique` (`barcode`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_order_number_unique` (`order_number`),
  ADD UNIQUE KEY `sales_invoice_number_unique` (`invoice_number`),
  ADD KEY `sales_user_id_foreign` (`user_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_items_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transactions_product_id_foreign` (`product_id`),
  ADD KEY `stock_transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD CONSTRAINT `stock_transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `stock_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
