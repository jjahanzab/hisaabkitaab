-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2023 at 03:58 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hisaabkitaab`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `slug`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, '12345678', 'Cycles', 'new cycles', '2022-03-09 16:06:31', '2022-03-10 08:26:31'),
(4, '1190891674', 'Toys', 'new toys', '2022-03-10 08:26:19', '2022-03-10 08:26:19');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `installs`
--

CREATE TABLE `installs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('F','T') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'F',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `installs`
--

INSERT INTO `installs` (`id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'T', '2023-05-01 13:51:36', '2023-05-01 13:51:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2022_03_07_160843_create_system_infos_table', 1),
(7, '2022_03_08_171943_create_categories_table', 2),
(8, '2022_03_08_172113_create_products_table', 2),
(12, '2022_03_08_173706_create_orders_table', 3),
(14, '2022_03_08_182727_create_order_totals_table', 3),
(15, '2022_03_08_173725_create_settings_table', 4),
(16, '2023_05_01_133508_create_installs_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `purchase_price` double(8,2) DEFAULT NULL,
  `sale_price` double(8,2) DEFAULT NULL,
  `sub_total` double(8,2) DEFAULT NULL,
  `status` enum('P','L') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense` double(8,2) DEFAULT NULL,
  `expense_detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `slug`, `order_number`, `category_id`, `product_id`, `product_quantity`, `purchase_price`, `sale_price`, `sub_total`, `status`, `expense`, `expense_detail`, `order_date`, `created_at`, `updated_at`) VALUES
(4, '1647085003743', 3, 1, 2, 1, 900.00, 800.00, 100.00, 'L', NULL, NULL, '2022-03-12', '2022-03-12 06:36:47', '2022-03-12 06:36:47'),
(5, '1647090821043', 4, 1, 2, 1, 900.00, 1100.00, 200.00, 'P', 100.00, 'food', '2022-03-12', '2022-03-12 08:14:44', '2022-03-12 08:14:44'),
(6, '1647090861278', 4, 1, 3, 1, 400.00, 500.00, 100.00, 'P', NULL, NULL, '2022-03-12', '2022-03-12 08:14:44', '2022-03-12 08:14:44'),
(7, '1647108920778', 5, 1, 2, 1, 900.00, 1000.00, 100.00, 'P', NULL, NULL, '2022-03-12', '2022-03-12 13:22:42', '2022-03-12 13:22:42'),
(8, '1647109353443', 5, 1, 3, 1, 400.00, 500.00, 100.00, 'P', 400.00, 'bill', '2022-03-12', '2022-03-12 13:22:42', '2022-03-12 13:22:42'),
(9, '1647249477302', 6, 1, 2, 1, 900.00, 1000.00, 100.00, 'P', NULL, NULL, '2022-03-14', '2022-03-14 06:58:24', '2022-03-14 06:58:24'),
(10, '1647249498953', 6, 1, 2, 2, 900.00, 700.00, 200.00, 'L', 80.00, 'bills', '2022-03-14', '2022-03-14 06:58:24', '2022-03-14 06:58:24'),
(11, '1647257963112', 6, 1, 2, 1, 900.00, 500.00, 400.00, 'L', 50.00, 'food', '2022-03-14', '2022-03-14 06:58:24', '2022-03-14 06:58:24'),
(12, '1647483961285', 7, 1, 2, 1, 900.00, 2000.00, 1100.00, 'P', NULL, NULL, '2022-03-17', '2022-03-16 21:26:06', '2022-03-16 21:26:06'),
(13, '1649249479799', 8, 1, 2, 2, 900.00, 1000.00, 100.00, 'P', NULL, NULL, '2022-04-06', '2022-04-06 07:56:37', '2022-04-06 07:56:37'),
(14, '1649249842507', 9, 1, 2, 2, 900.00, 1100.00, 200.00, 'P', NULL, NULL, '2022-04-06', '2022-04-06 07:57:51', '2022-04-06 07:57:51'),
(15, '1649316928636', 10, 1, 2, 2, 900.00, 800.00, 100.00, 'L', 100.00, 'bill', '2022-04-07', '2022-04-07 02:35:57', '2022-04-07 02:35:57');

-- --------------------------------------------------------

--
-- Table structure for table `order_totals`
--

CREATE TABLE `order_totals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` int(11) NOT NULL,
  `total_product_quantity` int(11) DEFAULT NULL,
  `total_purchase_price` double(8,2) DEFAULT NULL,
  `total_sale_price` double(8,2) DEFAULT NULL,
  `total_sub_total` double(8,2) DEFAULT NULL,
  `sale_status` enum('P','L') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_expense` double(8,2) DEFAULT NULL,
  `net_total` double(8,2) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_totals`
--

INSERT INTO `order_totals` (`id`, `slug`, `order_number`, `total_product_quantity`, `total_purchase_price`, `total_sale_price`, `total_sub_total`, `sale_status`, `total_expense`, `net_total`, `order_date`, `created_at`, `updated_at`) VALUES
(3, '1647085006898', 3, 1, 900.00, 800.00, 100.00, 'L', 0.00, 100.00, '2022-03-12', '2022-03-12 06:36:47', '2022-03-12 06:36:47'),
(4, '1647090884045', 4, 2, 1300.00, 1600.00, 300.00, 'P', 100.00, 200.00, '2022-03-12', '2022-03-12 08:14:44', '2022-03-12 08:14:44'),
(5, '1647109362499', 5, 2, 1300.00, 1500.00, 200.00, 'P', 400.00, -200.00, '2022-03-12', '2022-03-12 13:22:42', '2022-03-12 13:22:42'),
(6, '1647259103422', 6, 4, 2700.00, 2200.00, 500.00, 'L', 130.00, 630.00, '2022-03-14', '2022-03-14 06:58:24', '2022-03-14 06:58:24'),
(7, '1647483965613', 7, 1, 900.00, 2000.00, 1100.00, 'P', 0.00, 1100.00, '2022-03-17', '2022-03-16 21:26:06', '2022-03-16 21:26:06'),
(8, '1649249796963', 8, 2, 900.00, 1000.00, 100.00, 'P', 0.00, 100.00, '2022-04-06', '2022-04-06 07:56:37', '2022-04-06 07:56:37'),
(9, '1649249870656', 9, 2, 900.00, 1100.00, 200.00, 'P', 0.00, 200.00, '2022-04-06', '2022-04-06 07:57:51', '2022-04-06 07:57:51'),
(10, '1649316956458', 10, 2, 900.00, 800.00, 100.00, 'L', 100.00, 200.00, '2022-04-07', '2022-04-07 02:35:57', '2022-04-07 02:35:57');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manufacturer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('A','I') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `slug`, `category_id`, `name`, `price`, `quantity`, `description`, `manufacturer`, `supplier`, `product_code`, `pic`, `status`, `created_at`, `updated_at`) VALUES
(2, '1404375281', 1, 'bicycle', 900.00, 2, 'new style bicycle', 'king', 'riders', 'bicyc4321', '1080171409.jpg', 'A', '2022-03-09 12:20:46', '2022-04-07 02:50:07'),
(3, '1342204858', 1, 'toy cycle', 400.00, 5, NULL, NULL, NULL, NULL, NULL, 'A', '2022-03-10 03:02:00', '2022-04-05 08:09:52'),
(4, '1417900452', 4, 'phone', 100.00, 10, NULL, NULL, NULL, NULL, NULL, 'A', '2022-04-05 08:07:45', '2022-04-05 08:07:45');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `shop_name`, `shop_contact`, `address`, `created_at`, `updated_at`) VALUES
(1, 'App Store', '0300-0000000', 'New Town ABCD', '2022-03-10 03:56:31', '2023-03-20 06:46:30');

-- --------------------------------------------------------

--
-- Table structure for table `system_infos`
--

CREATE TABLE `system_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_infos`
--

INSERT INTO `system_infos` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'mac1', '34-E6-D7-05-AC-E8', '2023-05-01 08:55:48', '2023-05-01 08:55:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
(1, 'app', 'app@store.com', NULL, '$2y$10$RjH5HiX8kC2vd9LSSKMiXONs7JfgiKko6LWpkjWndmkMlke7f0dWy', NULL, '2022-03-07 12:27:15', '2022-03-07 12:27:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `installs`
--
ALTER TABLE `installs`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_totals`
--
ALTER TABLE `order_totals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_infos`
--
ALTER TABLE `system_infos`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `installs`
--
ALTER TABLE `installs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `order_totals`
--
ALTER TABLE `order_totals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_infos`
--
ALTER TABLE `system_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
