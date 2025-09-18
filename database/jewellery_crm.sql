-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2025 at 01:10 PM
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
-- Database: `jewellery_crm`
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
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','redeemed','expired') NOT NULL DEFAULT 'active',
  `redeemed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_code`, `customer_id`, `status`, `redeemed_at`, `created_at`, `updated_at`) VALUES
(1, 'LD-9C3EED', 28, 'active', NULL, '2025-09-08 06:11:45', '2025-09-08 06:11:45'),
(2, 'LD-8004E6', 29, 'active', NULL, '2025-09-09 02:32:16', '2025-09-09 02:32:16'),
(3, 'LD-5B7699', 30, 'active', NULL, '2025-09-09 05:36:13', '2025-09-09 05:36:13'),
(4, 'LD-F9AB7F', 31, 'active', NULL, '2025-09-09 06:01:43', '2025-09-09 06:01:43'),
(5, 'LD-1A2C7D', 32, 'active', NULL, '2025-09-09 23:32:57', '2025-09-09 23:32:57'),
(6, 'LD-16816D', 33, 'active', NULL, '2025-09-10 00:30:01', '2025-09-10 00:30:01'),
(7, 'LD-64600F', 34, 'active', NULL, '2025-09-10 00:30:38', '2025-09-10 00:30:38'),
(8, 'LD-797D63', 35, 'active', NULL, '2025-09-10 05:12:15', '2025-09-10 05:12:15'),
(9, 'LD-AD5D80', 36, 'active', NULL, '2025-09-10 06:05:06', '2025-09-10 06:05:06'),
(10, 'LD-609976', 37, 'active', NULL, '2025-09-10 06:50:22', '2025-09-10 06:50:22');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scheme_id` bigint(20) UNSIGNED DEFAULT NULL,
  `scheme_duration` varchar(255) DEFAULT NULL,
  `scheme_total_amount` decimal(10,2) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `qr_code` text DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `mtoken` varchar(255) NOT NULL,
  `verification_status` varchar(50) DEFAULT 'pending',
  `payment_status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `payment_link` varchar(255) DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `verification_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `scheme_id`, `scheme_duration`, `scheme_total_amount`, `name`, `mobile`, `email`, `qr_code`, `address`, `agent_id`, `created_at`, `updated_at`, `is_active`, `token`, `mtoken`, `verification_status`, `payment_status`, `payment_link`, `verified_at`, `verification_notes`) VALUES
(1, NULL, NULL, NULL, 'Rahul Sharma', '9876543210', 'rahul@gmail.com', NULL, 'hii jatin mishra', 3, '2025-09-05 10:09:37', '2025-09-08 06:38:19', 1, '', '', 'approved', 'success', NULL, NULL, NULL),
(2, NULL, NULL, NULL, 'Priya Patel', '8765432109', 'priya@gmail.com', NULL, '', 3, '2025-09-05 10:09:37', '2025-09-09 02:29:53', 0, '', '', 'approved', 'pending', NULL, NULL, NULL),
(3, NULL, NULL, NULL, 'Amit Kumar', '7654321098', 'amit@gmail.com', NULL, '', 3, '2025-09-05 10:09:37', '2025-09-08 06:37:56', 0, '', '', 'rejected', 'pending', NULL, NULL, NULL),
(4, NULL, NULL, NULL, 'Sneha Desai', '6543210987', 'sneha@gmail.com', NULL, '', 3, '2025-09-05 10:09:37', '2025-09-06 03:34:35', 0, '', '', 'rejected', 'pending', NULL, NULL, NULL),
(28, NULL, NULL, NULL, 'ajay13', '80761898373', 'ajay31@mail.com', 'https://quickchart.io/qr?text=%7B%22name%22%3A%22ajay13%22%2C%22mobile%22%3A%2280761898373%22%2C%22email%22%3A%22ajay31%40mail.com%22%2C%22token%22%3A%22TKN-68BEC0F9C1DBF%22%2C%22scheme%22%3A%22Not+Provided%22%2C%22use%22%3A%22Verification+%5C%2F+Check-in+%5C%2F+Order+Reference%22%2C%22payment_status%22%3A%22pending%22%2C%22payment_link%22%3Anull%7D&size=200', 'kanpur nagar', 3, '2025-09-08 06:11:45', '2025-09-08 06:35:53', 1, 'TKN-68BEC0F9C1DBF', '', 'approved', 'success', 'jjjj', NULL, NULL),
(29, NULL, NULL, NULL, 'rahul', '9876476474', 'sa@gmail.com', 'https://quickchart.io/qr?text=%7B%22name%22%3A%22rahul%22%2C%22mobile%22%3A%229876476474%22%2C%22email%22%3A%22sa%40gmail.com%22%2C%22token%22%3A%22TKN-68BFDF07F0CBB%22%2C%22scheme%22%3A%22Not+Provided%22%2C%22use%22%3A%22Verification+%5C%2F+Check-in+%5C%2F+Order+Reference%22%2C%22payment_status%22%3A%22pending%22%2C%22payment_link%22%3A%22thi+is+test%22%7D&size=200', 'kanpur nagar', 3, '2025-09-09 02:32:15', '2025-09-09 02:32:15', 1, 'TKN-68BFDF07F0CBB', '', 'pending', 'pending', 'thi is test', NULL, NULL),
(30, 2, NULL, NULL, 'test', '9876476477', 'admin@mail.com', 'https://quickchart.io/qr?text=%7B%22name%22%3A%22test%22%2C%22mobile%22%3A%229876476477%22%2C%22email%22%3A%22admin%40mail.com%22%2C%22token%22%3A%22TKN-68C00A25B3891%22%2C%22scheme%22%3A%22Not+Provided%22%2C%22use%22%3A%22Verification+%5C%2F+Check-in+%5C%2F+Order+Reference%22%2C%22payment_status%22%3A%22pending%22%2C%22payment_link%22%3A%22kkkkkkk%22%7D&size=200', 'dsdsfsfd', 3, '2025-09-09 05:36:13', '2025-09-09 05:36:13', 1, 'TKN-68C00A25B3891', '', 'pending', 'pending', 'kkkkkkk', NULL, NULL),
(31, 3, NULL, NULL, 'rajiv', '9876476456', 'adm22in@mail.com', 'https://quickchart.io/qr?text=%7B%22name%22%3A%22rajiv%22%2C%22mobile%22%3A%229876476456%22%2C%22email%22%3A%22adm22in%40mail.com%22%2C%22token%22%3A%22TKN-68C0101F9662E%22%2C%22scheme%22%3A%22Not+Provided%22%2C%22use%22%3A%22Verification+%5C%2F+Check-in+%5C%2F+Order+Reference%22%2C%22payment_status%22%3A%22pending%22%2C%22payment_link%22%3A%22ssqwqwqwq%22%7D&size=200', 'sdsdsss', 3, '2025-09-09 06:01:43', '2025-09-09 06:01:43', 1, 'TKN-68C0101F9662E', '', 'pending', 'pending', 'ssqwqwqwq', NULL, NULL),
(32, 1, NULL, NULL, 'Kunal Verma', '9876476490', 'test@test.com', 'https://quickchart.io/qr?text=%7B%22name%22%3A%22Kunal+Verma%22%2C%22mobile%22%3A%229876476490%22%2C%22email%22%3A%22test%40test.com%22%2C%22token%22%3A%22TKN-68C1068192812%22%2C%22scheme%22%3A%22Not+Provided%22%2C%22mtoken%22%3A%2212ssaS21E2%22%2C%22use%22%3A%22Verification+%5C%2F+Check-in+%5C%2F+Order+Reference%22%2C%22payment_status%22%3A%22pending%22%2C%22payment_link%22%3A%22vgyyvyg%22%7D&size=200', 'hjhjhj j j j', 3, '2025-09-09 23:32:57', '2025-09-09 23:32:57', 1, 'TKN-68C1068192812', '12ssaS21E2', 'pending', 'pending', 'vgyyvyg', NULL, NULL),
(33, 4, NULL, NULL, 'cbc', '9876476994', 'cc@mail.com', 'https://quickchart.io/qr?text=%7B%22name%22%3A%22cbc%22%2C%22mobile%22%3A%229876476994%22%2C%22email%22%3A%22cc%40mail.com%22%2C%22token%22%3A%22TKN-68C113E16486F%22%2C%22scheme%22%3A%7B%22id%22%3A4%2C%22name%22%3A%22Wedding+Collection+Plan%22%2C%22description%22%3A%22Wedding+jewellery+savings+plan%22%2C%22duration%22%3A10%2C%22total_amount%22%3A%22200000.00%22%2C%22status%22%3A%22active%22%2C%22created_at%22%3A%222025-09-05T15%3A39%3A37.000000Z%22%2C%22updated_at%22%3A%222025-09-05T15%3A39%3A37.000000Z%22%7D%2C%22mtoken%22%3A%2212ssaS21E2%22%2C%22use%22%3A%22Verification+%5C%2F+Check-in+%5C%2F+Order+Reference%22%2C%22payment_status%22%3A%22pending%22%2C%22payment_link%22%3A%22aAa%22%7D&size=200', 'aAaA', 3, '2025-09-10 00:30:01', '2025-09-10 03:31:32', 1, 'TKN-68C113E16486F', '12ssaS21E2', 'approved', 'pending', 'aAa', NULL, NULL),
(34, NULL, NULL, NULL, 'SSS', '9889090837', 'SS@mail.com', 'https://quickchart.io/qr?text=%7B%22name%22%3A%22SSS%22%2C%22mobile%22%3A%229876476224%22%2C%22email%22%3A%22SS%40mail.com%22%2C%22token%22%3A%22TKN-68C1140642920%22%2C%22scheme%22%3A%7B%22id%22%3A2%2C%22name%22%3A%22Diamond+Savings+Plan%22%2C%22description%22%3A%22Quarterly+diamond+investment+plan%22%2C%22duration%22%3A4%2C%22total_amount%22%3A%2280000.00%22%2C%22status%22%3A%22active%22%2C%22created_at%22%3A%222025-09-05T15%3A39%3A37.000000Z%22%2C%22updated_at%22%3A%222025-09-05T15%3A39%3A37.000000Z%22%7D%2C%22mtoken%22%3A%2212ssaS21E2%22%2C%22use%22%3A%22Verification+%5C%2F+Check-in+%5C%2F+Order+Reference%22%2C%22payment_status%22%3A%22pending%22%2C%22payment_link%22%3A%22asasasa%22%7D&size=200', 'zasasaa', 3, '2025-09-10 00:30:38', '2025-09-10 05:10:29', 1, 'TKN-68C1140642920', '12ssaS21E2', 'approved', 'pending', 'asasasa', NULL, NULL),
(35, 2, NULL, NULL, 'Ethan', '98764764897', 'amin@mail.com', 'https://quickchart.io/qr?text=%7B%22name%22%3A%22Ethan%22%2C%22mobile%22%3A%2298764764897%22%2C%22email%22%3A%22amin%40mail.com%22%2C%22token%22%3A%22TKN-68C1560791EF8%22%2C%22scheme%22%3A%7B%22id%22%3A2%2C%22name%22%3A%22Diamond+Savings+Plan%22%2C%22description%22%3A%22Quarterly+diamond+investment+plan%22%2C%22duration%22%3A4%2C%22total_amount%22%3A%2280000.00%22%2C%22status%22%3A%22active%22%2C%22created_at%22%3A%222025-09-05T15%3A39%3A37.000000Z%22%2C%22updated_at%22%3A%222025-09-05T15%3A39%3A37.000000Z%22%7D%2C%22mtoken%22%3A%22555%22%2C%22use%22%3A%22Verification+%5C%2F+Check-in+%5C%2F+Order+Reference%22%2C%22payment_status%22%3A%22pending%22%2C%22payment_link%22%3A%22hhhhhh%22%7D&size=200', 'kanpur nagar', 3, '2025-09-10 05:12:15', '2025-09-10 05:12:15', 1, 'TKN-68C1560791EF8', '555', 'pending', 'pending', 'hhhhhh', NULL, NULL),
(36, 2, '4', 80000.00, 'saket', '9676767676', 'saket@mail.com', 'https://quickchart.io/qr?text=%7B%22name%22%3A%22saket%22%2C%22mobile%22%3A%229676767676%22%2C%22email%22%3A%22saket%40mail.com%22%2C%22token%22%3A%22TKN-68C1626AD0F24%22%2C%22scheme%22%3A%7B%22id%22%3A2%2C%22name%22%3A%22Diamond+Savings+Plan%22%2C%22description%22%3A%22Quarterly+diamond+investment+plan%22%2C%22duration%22%3A4%2C%22total_amount%22%3A%2280000.00%22%2C%22status%22%3A%22active%22%2C%22created_at%22%3A%222025-09-05T15%3A39%3A37.000000Z%22%2C%22updated_at%22%3A%222025-09-05T15%3A39%3A37.000000Z%22%7D%2C%22mtoken%22%3A%22666%22%2C%22use%22%3A%22Verification+%5C%2F+Check-in+%5C%2F+Order+Reference%22%2C%22payment_status%22%3A%22pending%22%2C%22payment_link%22%3A%22uuiisidsid%22%7D&size=200', 'asjiasjiajsias', 3, '2025-09-10 06:05:06', '2025-09-10 06:05:06', 1, 'TKN-68C1626AD0F24', '666', 'pending', 'pending', 'uuiisidsid', NULL, NULL),
(37, 2, '4', 80000.00, 'abhay', '9876400474', 'abhay@mail.com', 'https://quickchart.io/qr?text=%7B%22name%22%3A%22abhay%22%2C%22mobile%22%3A%229876400474%22%2C%22email%22%3A%22abhay%40mail.com%22%2C%22token%22%3A%22TKN-68C16D0604F97%22%2C%22scheme%22%3A%7B%22id%22%3A2%2C%22name%22%3A%22Diamond+Savings+Plan%22%2C%22description%22%3A%22Quarterly+diamond+investment+plan%22%2C%22duration%22%3A4%2C%22total_amount%22%3A%2280000.00%22%2C%22status%22%3A%22active%22%2C%22created_at%22%3A%222025-09-05T15%3A39%3A37.000000Z%22%2C%22updated_at%22%3A%222025-09-05T15%3A39%3A37.000000Z%22%7D%2C%22mtoken%22%3A%225555%22%2C%22use%22%3A%22Verification+%5C%2F+Check-in+%5C%2F+Order+Reference%22%2C%22payment_status%22%3A%22pending%22%2C%22payment_link%22%3A%22hjhjhjhhj%22%7D&size=200', 'hjhjhhjhjhjhj', 3, '2025-09-10 06:50:22', '2025-09-10 06:50:22', 1, 'TKN-68C16D0604F97', '5555', 'pending', 'pending', 'hjhjhjhhj', NULL, NULL);

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
-- Table structure for table `lucky_draws`
--

CREATE TABLE `lucky_draws` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `scheme_id` bigint(20) UNSIGNED NOT NULL,
  `scheme_payment_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `lucky_draw_amount` decimal(10,2) DEFAULT 0.00,
  `status` enum('pending','won','lost') DEFAULT 'pending',
  `reward_type` varchar(50) DEFAULT NULL,
  `reward_value` varchar(255) DEFAULT NULL,
  `reward_message` text DEFAULT NULL,
  `reward_status` enum('pending','sent','failed') DEFAULT 'pending',
  `rewarded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lucky_draws`
--

INSERT INTO `lucky_draws` (`id`, `customer_id`, `scheme_id`, `scheme_payment_id`, `coupon_code`, `lucky_draw_amount`, `status`, `reward_type`, `reward_value`, `reward_message`, `reward_status`, `rewarded_at`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 1, 'LD-0001', 500.00, 'pending', 'cashback', '787', 'Dear Customer, you have won a reward of ₹500.00 from Vijay Jewellers Lucky Draw. Your coupon code: LD-0001. Visit our store to claim your reward.', 'sent', '2025-09-10 03:42:42', '2025-09-10 02:12:28', '2025-09-10 03:42:42');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_01_01_000000_create_roles_table', 1),
(6, '2023_01_01_000001_create_customers_table', 1),
(7, '2023_01_01_000002_create_schemes_table', 1),
(8, '2023_01_01_000003_create_scheme_members_table', 1),
(9, '2023_01_01_000004_create_sales_table', 1),
(10, '2025_09_05_075150_create_cache_table', 2),
(11, '2025_09_05_075342_create_sessions_table', 3);

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `method` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`permissions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '{\"manage_users\": true, \"manage_roles\": true, \"view_all_customers\": true, \"view_all_schemes\": true, \"manage_coupons\": true, \"view_reports\": true, \"delete_records\": true, \"modify_records\": true}', '2025-09-05 10:09:37', '2025-09-05 10:09:37'),
(2, 'Manager', '{\"view_all_customers\": true, \"view_all_schemes\": true, \"approve_coupons\": true, \"approve_schemes\": true, \"view_reports\": true}', '2025-09-05 10:09:37', '2025-09-05 10:09:37'),
(3, 'Executive', '{\"add_customers\": true, \"view_own_customers\": true, \"generate_tokens\": true}', '2025-09-05 10:09:37', '2025-09-05 10:09:37'),
(4, 'Accounts', '{\"view_schemes\": true, \"view_payments\": true, \"view_invoices\": true}', '2025-09-05 10:09:37', '2025-09-05 10:09:37'),
(5, 'Marketing', '{\"send_promotions\": true, \"send_lucky_draws\": true}', '2025-09-05 10:09:37', '2025-09-05 10:09:37');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_type` enum('Gold','Silver','Diamond','Plated') NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `sale_date` date NOT NULL,
  `sale_type` enum('online','offline') DEFAULT 'offline',
  `payment_status` enum('pending','completed','failed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_type`, `product_name`, `amount`, `sale_date`, `sale_type`, `payment_status`, `created_at`, `updated_at`, `quantity`, `customer_id`) VALUES
(7, 'Gold', 'Diamond Necklace', 128000.00, '2025-09-05', 'offline', 'pending', '2025-09-05 10:09:37', '2025-09-05 10:09:37', 1, NULL),
(8, 'Silver', 'Silver Bracelet', 18700.00, '2025-09-05', 'online', 'pending', '2025-09-05 10:09:37', '2025-09-05 10:09:37', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schemes`
--

CREATE TABLE `schemes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('active','inactive','completed') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schemes`
--

INSERT INTO `schemes` (`id`, `name`, `description`, `duration`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Gold Savings Scheme jatin', 'Monthly gold investment scheme', 12, 120000.00, 'active', '2025-09-05 10:09:37', '2025-09-05 23:42:34'),
(2, 'Diamond Savings Plan', 'Quarterly diamond investment plan', 4, 80000.00, 'active', '2025-09-05 10:09:37', '2025-09-05 10:09:37'),
(3, 'Festival Savings Scheme', 'Special festival savings scheme', 6, 60000.00, 'active', '2025-09-05 10:09:37', '2025-09-05 10:09:37'),
(4, 'Wedding Collection Plan', 'Wedding jewellery savings plan', 10, 200000.00, 'active', '2025-09-05 10:09:37', '2025-09-05 10:09:37'),
(5, 'Kunal Verma', 'dscsd', 32, 3244.00, 'active', '2025-09-05 23:48:24', '2025-09-05 23:48:24'),
(8, 'gold investment plan', 'this is very good products .', 18, 54000.00, 'active', '2025-09-10 05:07:19', '2025-09-10 05:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `scheme_members`
--

CREATE TABLE `scheme_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scheme_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `joined_date` date NOT NULL,
  `payment_status` enum('pending','paid','overdue') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scheme_members`
--

INSERT INTO `scheme_members` (`id`, `scheme_id`, `customer_id`, `joined_date`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-09-05', 'paid', '2025-09-05 10:09:37', '2025-09-05 10:09:37'),
(2, 1, 2, '2025-09-05', 'paid', '2025-09-05 10:09:37', '2025-09-05 10:09:37'),
(3, 2, 3, '2025-09-05', 'pending', '2025-09-05 10:09:37', '2025-09-05 10:09:37'),
(4, 3, 4, '2025-09-05', 'paid', '2025-09-05 10:09:37', '2025-09-05 10:09:37');

-- --------------------------------------------------------

--
-- Table structure for table `scheme_payments`
--

CREATE TABLE `scheme_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scheme_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_duration` varchar(50) NOT NULL DEFAULT '30 days',
  `status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `method` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scheme_payments`
--

INSERT INTO `scheme_payments` (`id`, `scheme_id`, `customer_id`, `amount`, `payment_duration`, `status`, `method`, `notes`, `due_date`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 2000.00, '30 days', 'success', 'upi', NULL, NULL, NULL, '2025-09-10 00:43:24', '2025-09-10 06:30:38');

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
('i4S9Fc3HAutYebx0x5iCulobEXHlJmXnYv28Bynl', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVUJ6WktYTG5TVjlYRDZKT21EZnNQaHZjUjgxUGNxbDFnd3BhbGNUYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zY2hlbWVzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1757588911);

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
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@mail.com', '2025-09-05 10:09:37', '$2y$12$oqbQVAIrxWckseOY3atcH.PGGEhbI05CQLJ89CoZ2KF9DGtcY4oI6', 1, NULL, '2025-09-05 10:09:37', '2025-09-05 10:09:37'),
(2, 'Manager User', 'manager@mail.com', '2025-09-05 10:09:37', '$2y$12$oqbQVAIrxWckseOY3atcH.PGGEhbI05CQLJ89CoZ2KF9DGtcY4oI6', 2, NULL, '2025-09-05 10:09:37', '2025-09-05 10:09:37'),
(3, 'Executive User', 'executive@mail.com', '2025-09-05 10:09:37', '$2y$12$oqbQVAIrxWckseOY3atcH.PGGEhbI05CQLJ89CoZ2KF9DGtcY4oI6', 3, NULL, '2025-09-05 10:09:37', '2025-09-05 10:09:37'),
(4, 'Accounts User', 'accounts@mail.com', '2025-09-05 10:09:37', '$2y$12$oqbQVAIrxWckseOY3atcH.PGGEhbI05CQLJ89CoZ2KF9DGtcY4oI6', 4, NULL, '2025-09-05 10:09:37', '2025-09-05 10:09:37'),
(5, 'Marketing User', 'marketing@jewellery.com', '2025-09-05 10:09:37', '$2y$12$oqbQVAIrxWckseOY3atcH.PGGEhbI05CQLJ89CoZ2KF9DGtcY4oI6', 5, NULL, '2025-09-05 10:09:37', '2025-09-05 10:09:37');

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
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`),
  ADD KEY `fk_coupons_customer` (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_agent_id_foreign` (`agent_id`),
  ADD KEY `customers_name_index` (`name`),
  ADD KEY `customers_mobile_index` (`mobile`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `lucky_draws`
--
ALTER TABLE `lucky_draws`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `scheme_id` (`scheme_id`),
  ADD KEY `scheme_payment_id` (`scheme_payment_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_customer_id_foreign` (`customer_id`),
  ADD KEY `payments_sale_id_foreign` (`sale_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_sale_date_index` (`sale_date`),
  ADD KEY `sales_product_type_index` (`product_type`);

--
-- Indexes for table `schemes`
--
ALTER TABLE `schemes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scheme_members`
--
ALTER TABLE `scheme_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scheme_members_scheme_id_foreign` (`scheme_id`),
  ADD KEY `scheme_members_customer_id_foreign` (`customer_id`),
  ADD KEY `scheme_members_joined_date_index` (`joined_date`),
  ADD KEY `scheme_members_payment_status_index` (`payment_status`);

--
-- Indexes for table `scheme_payments`
--
ALTER TABLE `scheme_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scheme_payments_customer_id_foreign` (`customer_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lucky_draws`
--
ALTER TABLE `lucky_draws`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schemes`
--
ALTER TABLE `schemes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `scheme_members`
--
ALTER TABLE `scheme_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `scheme_payments`
--
ALTER TABLE `scheme_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `fk_coupons_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lucky_draws`
--
ALTER TABLE `lucky_draws`
  ADD CONSTRAINT `lucky_draws_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lucky_draws_ibfk_2` FOREIGN KEY (`scheme_id`) REFERENCES `schemes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lucky_draws_ibfk_3` FOREIGN KEY (`scheme_payment_id`) REFERENCES `scheme_payments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `scheme_members`
--
ALTER TABLE `scheme_members`
  ADD CONSTRAINT `scheme_members_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `scheme_members_scheme_id_foreign` FOREIGN KEY (`scheme_id`) REFERENCES `schemes` (`id`);

--
-- Constraints for table `scheme_payments`
--
ALTER TABLE `scheme_payments`
  ADD CONSTRAINT `scheme_payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
