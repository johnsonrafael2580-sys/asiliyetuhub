-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql309.infinityfree.com
-- Generation Time: Sep 28, 2026 at 06:17 AM
-- Server version: 11.4.13-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_42927505_asiliyetuhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('asiliyetuhub-cache-amini@gmail.com|196.249.123.138', 'i:1;', 1790330161),
('asiliyetuhub-cache-amini@gmail.com|196.249.123.138:timer', 'i:1790330161;', 1790330161),
('asiliyetuhub-cache-gillianmarcel18@gmail.com|41.223.6.84', 'i:1;', 1790345198),
('asiliyetuhub-cache-gillianmarcel18@gmail.com|41.223.6.84:timer', 'i:1790345198;', 1790345198);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commissions`
--

CREATE TABLE `commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artisan_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_amount` decimal(12,2) NOT NULL,
  `commission_rate` decimal(5,2) NOT NULL DEFAULT 10.00,
  `commission_amount` decimal(12,2) NOT NULL,
  `status` enum('pending','completed') NOT NULL DEFAULT 'pending',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commissions`
--

INSERT INTO `commissions` (`id`, `artisan_id`, `order_id`, `order_item_id`, `product_id`, `order_amount`, `commission_rate`, `commission_amount`, `status`, `completed_at`, `created_at`, `updated_at`) VALUES
(11, 12, 22, NULL, 30, '45000.00', '10.00', '40500.00', 'completed', '2026-09-28 14:43:22', '2026-09-25 13:55:55', '2026-09-28 14:45:51');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_tracking`
--

CREATE TABLE `delivery_tracking` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fulfillment_id` bigint(20) UNSIGNED NOT NULL,
  `event_type` enum('pending','packaged','dispatched','pickup_scheduled','picked_up','in_transit','out_for_delivery','delivered','failed','failed_attempt','returned') NOT NULL DEFAULT 'pending',
  `description` text NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_tracking`
--

INSERT INTO `delivery_tracking` (`id`, `fulfillment_id`, `event_type`, `description`, `location`, `updated_by`, `created_at`, `updated_at`) VALUES
(17, 9, 'pending', 'Fulfillment initiated from Kijiji cha Kilimahewa', NULL, 'Johnson Mwacha', '2026-09-25 13:50:09', '2026-09-25 13:50:09'),
(18, 9, 'packaged', 'Imebebwa na Arusha express', NULL, 'Johnson Mwacha', '2026-09-25 13:53:28', '2026-09-25 13:53:28'),
(19, 9, 'in_transit', 'Status updated to in_transit', NULL, 'Johnson Mwacha', '2026-09-25 13:55:12', '2026-09-25 13:55:12'),
(20, 9, 'delivered', 'Order delivered successfully', NULL, 'Johnson Mwacha', '2026-09-25 13:55:55', '2026-09-25 13:55:55');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fulfillments`
--

CREATE TABLE `fulfillments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_request_id` bigint(20) UNSIGNED NOT NULL,
  `artisan_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','packaged','dispatched','in_transit','delivered','failed') NOT NULL DEFAULT 'pending',
  `tracking_number` varchar(255) DEFAULT NULL,
  `courier_partner` varchar(255) DEFAULT NULL,
  `packaging_notes` text DEFAULT NULL,
  `pickup_location` varchar(255) DEFAULT NULL,
  `delivery_location` varchar(255) DEFAULT NULL,
  `special_instructions` text DEFAULT NULL,
  `packaged_at` timestamp NULL DEFAULT NULL,
  `dispatched_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fulfillments`
--

INSERT INTO `fulfillments` (`id`, `product_request_id`, `artisan_id`, `status`, `tracking_number`, `courier_partner`, `packaging_notes`, `pickup_location`, `delivery_location`, `special_instructions`, `packaged_at`, `dispatched_at`, `delivered_at`, `created_at`, `updated_at`) VALUES
(9, 22, 12, 'delivered', 'Namba ya Mzigo 45768', 'Boda', 'Weka ndani ya Boksi', 'Kijiji cha Kilimahewa', 'Arusha Cultural heritage', 'Fragile handcrafted art. Handle with care.', '2026-09-25 13:53:28', NULL, '2026-09-25 13:55:55', '2026-09-25 13:50:09', '2026-09-25 13:55:55');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
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
(4, '2026_09_15_183507_add_payment_fields_to_users_table', 2),
(5, '2026_09_15_185403_create_product_requests_table', 3),
(6, '2026_09_15_185403_add_customer_details_to_product_requests_table', 4),
(7, '2026_09_22_203420_create_reviews_table', 5),
(8, '2026_09_22_220000_create_commissions_table', 6),
(10, '2026_09_22_220002_create_fulfillments_table', 7),
(11, '2026_09_22_220003_create_delivery_tracking_table', 8),
(12, '2026_09_22_220004_create_whatsapp_settings_table', 9),
(13, '2026_09_22_220005_create_whatsapp_messages_table', 10),
(14, '2026_09_22_220006_update_product_requests_table', 11),
(15, '2026_09_22_220007_remove_upfront_registration_fees', 12),
(16, '2026_09_23_000001_add_inventory_and_pricing_to_products_table', 13),
(17, '2026_09_23_000000_create_orders_and_order_items_tables', 14),
(18, '2026_09_23_000004_add_wallet_balance_to_users_table', 15),
(19, '2026_09_23_000005_add_story_to_products_table', 16),
(20, '2026_09_23_000006_create_notifications_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
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

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `payment_method` enum('mobile_money','bank_transfer','card','other') NOT NULL DEFAULT 'mobile_money' COMMENT 'Payment method used',
  `escrow_status` enum('awaiting_payment','escrowed','held_pending_delivery','released_to_fulfillment','released_to_artisan') NOT NULL DEFAULT 'awaiting_payment' COMMENT 'Payment lifecycle; delivery releases 90% to artisan and 10% to platform',
  `platform_reserved_commission` decimal(12,2) NOT NULL DEFAULT 0.00 COMMENT 'Total platform commission reserved from this order',
  `logistics_pool_amount` decimal(12,2) NOT NULL DEFAULT 0.00 COMMENT 'Total logistics/shipping amount for this order',
  `payment_received_at` timestamp NULL DEFAULT NULL COMMENT 'When payment was received in escrow',
  `customer_hidden_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `customer_name`, `customer_phone`, `customer_email`, `total_amount`, `status`, `payment_method`, `escrow_status`, `platform_reserved_commission`, `logistics_pool_amount`, `payment_received_at`, `customer_hidden_at`, `created_at`, `updated_at`) VALUES
(7, NULL, 'Allan THomas', '0675674534', NULL, '100000.00', 'pending', 'mobile_money', 'escrowed', '8330.00', '16700.00', '2026-09-24 04:54:48', NULL, '2026-09-24 04:54:48', '2026-09-24 04:54:48'),
(8, NULL, 'Salimu Idd', '0768974532', NULL, '45000.00', 'pending', 'mobile_money', 'escrowed', '3748.50', '7515.00', '2026-09-24 06:20:13', NULL, '2026-09-24 06:20:12', '2026-09-24 06:20:13'),
(9, NULL, 'Asimwe Juma', '0786543528', NULL, '45000.00', 'pending', 'mobile_money', 'escrowed', '3748.50', '7515.00', '2026-09-24 07:19:05', NULL, '2026-09-24 07:19:05', '2026-09-24 07:19:05'),
(10, NULL, 'Ally Juma', '0786543245', NULL, '50000.00', 'pending', 'mobile_money', 'escrowed', '4165.00', '8350.00', '2026-09-24 11:48:26', NULL, '2026-09-24 11:48:26', '2026-09-24 11:48:26'),
(11, NULL, 'Shabani Juma', '0756734537', NULL, '50000.00', 'pending', 'mobile_money', 'escrowed', '4165.00', '8350.00', '2026-09-24 16:33:02', NULL, '2026-09-24 16:33:02', '2026-09-24 16:33:02'),
(12, NULL, 'Almasi Kasongo', '0657867456', NULL, '45000.00', 'pending', 'mobile_money', 'escrowed', '3748.50', '7515.00', '2026-09-25 13:37:10', NULL, '2026-09-25 13:37:10', '2026-09-25 13:37:10');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `artisan_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL COMMENT 'Total price per item (base + shipping)',
  `quantity` int(11) NOT NULL DEFAULT 1,
  `subtotal` decimal(12,2) NOT NULL COMMENT 'price * quantity',
  `base_product_price` decimal(12,2) NOT NULL DEFAULT 0.00 COMMENT 'Base product price per unit',
  `shipping_fee_per_item` decimal(12,2) NOT NULL DEFAULT 0.00 COMMENT 'Shipping fee allocated to this item',
  `platform_commission` decimal(12,2) NOT NULL DEFAULT 0.00 COMMENT '10% platform commission from base price',
  `artisan_earnings` decimal(12,2) NOT NULL DEFAULT 0.00 COMMENT '90% of base product price (artisan net earnings)',
  `payment_status` enum('pending','escrowed','settled') NOT NULL DEFAULT 'pending' COMMENT 'Payment settlement status',
  `payment_settled_at` timestamp NULL DEFAULT NULL COMMENT 'When the automatic delivery settlement credited the artisan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `artisan_id`, `product_id`, `product_title`, `price`, `quantity`, `subtotal`, `base_product_price`, `shipping_fee_per_item`, `platform_commission`, `artisan_earnings`, `payment_status`, `payment_settled_at`, `created_at`, `updated_at`) VALUES
(12, 12, 12, 30, 'Mashuka Ya Kimaasai', '45000.00', 1, '45000.00', '37485.00', '7515.00', '3748.50', '33736.50', 'escrowed', NULL, '2026-09-25 13:37:10', '2026-09-25 13:37:10');

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `story` text DEFAULT NULL COMMENT 'Artisan story or provenance',
  `price` decimal(10,2) NOT NULL,
  `base_price` decimal(12,2) DEFAULT NULL COMMENT 'Base product price without shipping',
  `shipping_fee` decimal(12,2) NOT NULL DEFAULT 0.00 COMMENT 'Shipping/logistics cost',
  `platform_commission_rate` decimal(5,2) NOT NULL DEFAULT 10.00 COMMENT 'Fixed platform commission percentage; artisan receives 90% of base product price',
  `category` enum('Carvings','Fabrics','Pottery','Jewelry','Beadwork','Painting','Textiles') NOT NULL DEFAULT 'Carvings',
  `image_path` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `stock_quantity` int(11) NOT NULL DEFAULT 0 COMMENT 'Number of items available in stock',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `title`, `description`, `story`, `price`, `base_price`, `shipping_fee`, `platform_commission_rate`, `category`, `image_path`, `is_available`, `stock_quantity`, `created_at`, `updated_at`) VALUES
(3, 3, 'Fine Art Painting', 'A detailed wildlife potrait of a spotted King of the Juggle \"Lion\", hand-painted on canvas showcasing expressive textures and warm tones', NULL, '80000.00', NULL, '0.00', '10.00', 'Painting', 'products/ctfOjhPc2JxtiY7eF1sQJVwWE4vGAqLM4NxUKgic.jpg', 1, 0, '2026-09-15 04:30:49', '2026-09-15 04:30:49'),
(4, 3, 'Fine Art Painting', 'A detailed wildlife potrait of the King of the jugle \"Lion\", hand-painted on the canvas showcasing expressive textures and warm tones.', NULL, '80000.00', NULL, '0.00', '10.00', 'Painting', 'products/CeQJ9K662RBkQIm1CRSrIRfGsU0rUfoXKMIhZaO3.jpg', 1, 0, '2026-09-15 04:36:05', '2026-09-15 04:36:05'),
(6, 3, 'Fine Art Painnting', 'A detailed wildlife potrait of a spotted hyena characterized by its rounded ears, spoted coat pattern, and robust build, hand-painted on canvas', NULL, '80000.00', NULL, '0.00', '10.00', 'Painting', 'products/c4TNN2TzOgvRTGAuwpMfQMyt3wY36WiV7zomHEsN.jpg', 1, 0, '2026-09-15 04:40:23', '2026-09-15 04:40:23'),
(8, 3, 'Fine Art', 'A detailed wildlife potrait, hand-painted on canvas.', NULL, '80000.00', NULL, '0.00', '10.00', 'Painting', 'products/l3jXCp65xnWUF0mqCOBT3UtSGScMId7XfLyepuLv.jpg', 1, 0, '2026-09-15 04:46:27', '2026-09-15 04:46:27'),
(9, 3, 'Fine Arts Painting', 'A detailed wildlife potrait, hand-painted on canvas.', NULL, '80000.00', NULL, '0.00', '10.00', 'Painting', 'products/pm2okH1qbHWU9sal5bS7qEIiOOV4RFXNR8rXaGki.jpg', 1, 0, '2026-09-15 05:01:02', '2026-09-15 05:01:02'),
(11, 3, 'Fine Arts Painting', 'A detailed wildlife potrait, hand-painted on canvas.', NULL, '80000.00', NULL, '0.00', '10.00', 'Painting', 'products/MOAtwfl5uPNYFFPXChO64GQQa6YUuCbzhwpM0RdK.jpg', 1, 0, '2026-09-15 05:04:13', '2026-09-15 05:04:13'),
(12, 3, 'Fine Arts Painting', 'A detailed wildlife potrait, hand-painted on canvas.', NULL, '80000.00', NULL, '0.00', '10.00', 'Painting', 'products/CrZz6OGw739AIaVSeL9RfF5MZSCemZuosQ3Urhy0.jpg', 1, 0, '2026-09-15 05:05:23', '2026-09-15 05:05:23'),
(13, 3, 'Fine Arts Painting', 'A detailed wildlife potrait, hand-painted on canvas.', NULL, '80000.00', NULL, '0.00', '10.00', 'Painting', 'products/Ow3Zzi6biaxOxm1Lg4SKvSjnfQgvanjZtwWIj3fG.jpg', 1, 0, '2026-09-15 05:06:37', '2026-09-15 05:06:37'),
(14, 3, 'Fine Arts Painting', 'A detailed wildlife potrait, hand-painted on canvas.', NULL, '80000.00', NULL, '0.00', '10.00', 'Painting', 'products/z709PWqbvx4mpsap52n3CmjZTQyxVusm5MQ9N0ds.jpg', 1, 0, '2026-09-15 05:09:30', '2026-09-15 05:09:30'),
(15, 3, 'Fine Arts Painting', 'A detailed wildlife potrait, hand-painted on canvas.', NULL, '80000.00', NULL, '0.00', '10.00', 'Painting', 'products/wPFiNgBUPlckBhFvVLHQdHE7XgLm2HgbK3IXUe46.jpg', 1, 0, '2026-09-15 05:11:56', '2026-09-15 05:11:56'),
(16, 3, 'Fine Arts', 'A detailed wildlife potrait, hand-painted on canvas.', NULL, '80000.00', NULL, '0.00', '10.00', 'Painting', 'products/ctT411c1sEEC0Rz4uZCvDps8YrfpCtJZXgEUca7w.jpg', 1, 0, '2026-09-15 05:14:19', '2026-09-15 05:14:19'),
(30, 12, 'Mashuka Ya Kimaasai', 'Haya Ni Mashuka ya Kimaasai Ambayo hupendwa na takribani asilimia 45 ya Watanzania, Yanaelezea Chimbuko na Asili nzima ya Kabila la Kimaasai wanaopatikana ndani ya Mkoa Wa Arusha na Baadhi ya mikoa ya kaskazini mwa Arusha.', NULL, '45000.00', '37485.00', '7515.00', '10.00', 'Beadwork', '1790317551_6ab613ef8a65c.jpg', 1, 49, '2026-09-25 13:25:51', '2026-09-25 13:37:10'),
(31, 12, 'Vikapu vya Kusuka', 'Vikapu vya Kusuka vinatoa Historia nzima ya Utamaduni Wa Kitanzania.', NULL, '20000.00', '16660.00', '3340.00', '10.00', 'Pottery', '1790317809_6ab614f16e5a5.jpg', 1, 20, '2026-09-25 13:30:09', '2026-09-25 13:30:09'),
(32, 12, 'Art Drawing', 'Kijana Wa Kiafrika', NULL, '80000.00', '66640.00', '13360.00', '10.00', 'Painting', '1790330387_6ab6461384883.jpg', 1, 1, '2026-09-25 16:59:47', '2026-09-25 16:59:47'),
(33, 12, 'Mwanamke Wa Kiafrika', 'Mwanamke Asili ya Afrika', NULL, '80000.00', '66640.00', '13360.00', '10.00', 'Painting', '1790330813_6ab647bde5266.jpg', 1, 1, '2026-09-25 17:06:53', '2026-09-25 17:06:53'),
(34, 12, 'Mwanamke Wa Kiafrika', 'Mwanamke Asili ya Afrika', NULL, '80000.00', '66640.00', '13360.00', '10.00', 'Painting', '1790330926_6ab6482e78dbb.jpg', 1, 1, '2026-09-25 17:08:46', '2026-09-25 17:08:46'),
(36, 12, 'Mwanamke Wa Kiafrika', 'Mwanamke Asili ya Afrika', NULL, '80000.00', '66640.00', '13360.00', '10.00', 'Painting', '1790331085_6ab648cd80c91.jpg', 1, 1, '2026-09-25 17:11:25', '2026-09-25 17:11:25'),
(37, 12, 'Mwanamke Wa Kiafrika', 'Mwanamke Asili ya Kiafrika', NULL, '80000.00', '66640.00', '13360.00', '10.00', 'Painting', '1790331156_6ab64914c138c.jpg', 1, 1, '2026-09-25 17:12:36', '2026-09-25 17:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `product_requests`
--

CREATE TABLE `product_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `cancellation_reason` text DEFAULT NULL,
  `delivery_location` varchar(255) DEFAULT NULL,
  `delivery_note` varchar(255) DEFAULT NULL,
  `tourist_phone` varchar(255) DEFAULT NULL,
  `tourist_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_requests`
--

INSERT INTO `product_requests` (`id`, `order_id`, `product_id`, `user_id`, `customer_name`, `customer_phone`, `message`, `status`, `cancellation_reason`, `delivery_location`, `delivery_note`, `tourist_phone`, `tourist_email`, `created_at`, `updated_at`) VALUES
(22, 12, 30, 12, 'Almasi Kasongo', '0657867456', 'Order #12', 'cancelled', NULL, NULL, NULL, NULL, NULL, '2026-09-25 13:37:10', '2026-09-28 14:43:22');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewer_name` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `reviewer_name`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(4, 16, 12, 'Johnson Mwacha', 5, 'Well Done...❤️‍🩹 ❤️‍🩹 ❤️‍🩹', '2026-09-25 19:14:53', '2026-09-25 19:14:53'),
(5, 32, 12, 'Johnson Mwacha', 5, 'Umeupiga mwingi Sana Mwanetuu..', '2026-09-25 21:43:22', '2026-09-25 21:43:22'),
(6, 15, NULL, 'Mteja / Customer', 3, 'good', '2026-09-26 03:00:59', '2026-09-26 03:00:59');

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
('0TMFIHhNyKBFb7kA19UdbwzI6X8lxBl6h2bseCvQ', NULL, '66.249.93.226', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'eyJfdG9rZW4iOiJFZHN5Q1V1OUY5dm1ObnNRTEU5VTI0cXBHdWpzZXNYQkhtak9FOWRpIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cHM6XC9cL2FzaWxpeWV0dWh1Yi5sb3Zlc3RvYmxvZy5jb21cL3doYXRzYXBwXC9jb25maWd1cmUifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9hc2lsaXlldHVodWIubG92ZXN0b2Jsb2cuY29tXC93aGF0c2FwcFwvY29uZmlndXJlIiwicm91dGUiOiJ3aGF0c2FwcC5jb25maWd1cmUifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1790586739),
('2zsoJDEVCBvA2tQR4QpIS4aW8N74pgegv3VORElp', NULL, '66.249.93.225', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'eyJfdG9rZW4iOiJRY1l6VnJBVUFLWXE2T1E5dXJPT3NIYXdOUTNPV0ZnRXk0a29BVWY0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9hc2lsaXlldHVodWIubG92ZXN0b2Jsb2cuY29tXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1790582647),
('4c0WdIre5earmBMjslufxazZxDeU2DcFMmvcRQy8', NULL, '66.249.93.226', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'eyJfdG9rZW4iOiJ6a0s2Y2tLVU83bmU2MnZ4MXJJZjdTSHdJbHdKU0RzZ210cUxHbmtHIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cHM6XC9cL2FzaWxpeWV0dWh1Yi5sb3Zlc3RvYmxvZy5jb21cL2Z1bGZpbGxtZW50cyJ9LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cHM6XC9cL2FzaWxpeWV0dWh1Yi5sb3Zlc3RvYmxvZy5jb21cL2Z1bGZpbGxtZW50cyIsInJvdXRlIjoiZnVsZmlsbG1lbnRzLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1790582647),
('8SY347XzHm6I8Qvrkef1C9ZBl5OmsgBwy8f1zmXZ', 12, '41.223.6.84', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Mobile Safari/537.36', 'eyJfdG9rZW4iOiJKRm5zdEx4WkZrallVc01rR0NPVFJyVmxrOEUwY0NLOUxEeVlWREpoIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEyLCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cHM6XC9cL2FzaWxpeWV0dWh1Yi5sb3Zlc3RvYmxvZy5jb21cL3Byb2R1Y3RzXC8zNyIsInJvdXRlIjoicHJvZHVjdHMuc2hvdyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvY2FsZSI6ImVuIn0=', 1790587095),
('dfvPmhptTWxEsg84DXQb1T7gMKz3AZrseYzUakgY', NULL, '66.249.93.225', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'eyJfdG9rZW4iOiJqcFJrZnJuRkphQVgwVk1Sc3VlSzNLOWF2RWQ3dzhkbFJaWFNJWldFIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9hc2lsaXlldHVodWIubG92ZXN0b2Jsb2cuY29tXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1790586740),
('JVk3rTUGg7s1hq30nCuE8BxDnlJoHGPLpKQ6pdfr', NULL, '66.249.93.226', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'eyJfdG9rZW4iOiJ0eGNsWW9sbDdwRHExdHJDeVVJR1RnTnBPZW1YNk9qSXNyVVZHeXRYIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9hc2lsaXlldHVodWIubG92ZXN0b2Jsb2cuY29tIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1790586761),
('k9CckAbPJx4On7UjVJs07BIFQdFy5Gb33lwGDLJ8', 12, '196.192.78.26', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJOeGF0WFNzRU10d1pGNGE4QzVtcFBhVzNsbkZZOGtSVkdXZ3ZPektyIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvYXNpbGl5ZXR1aHViLmxvdmVzdG9ibG9nLmNvbVwvY2FydCIsInJvdXRlIjoiY2FydC5pbmRleCJ9LCJsb2NhbGUiOiJzdyIsImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxMiwiY2FydCI6eyIzNyI6eyJ0aXRsZSI6Ik13YW5hbWtlIFdhIEtpYWZyaWthIiwicXVhbnRpdHkiOjEsInByaWNlIjoiODAwMDAuMDAiLCJiYXNlX3ByaWNlIjoiNjY2NDAuMDAiLCJzaGlwcGluZ19mZWUiOiIxMzM2MC4wMCIsImltYWdlIjoiMTc5MDMzMTE1Nl82YWI2NDkxNGMxMzhjLmpwZyJ9fX0=', 1790590228),
('NPBTET4b7gY6WvqoaUu8m7AdHFcRTaz42FFlXQ44', NULL, '66.249.93.226', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'eyJfdG9rZW4iOiJnVEt3akN6eTBLZFg4b0hZMjh1QnhpdXhHVjM3RkhxWGV6UHZweXBCIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9hc2lsaXlldHVodWIubG92ZXN0b2Jsb2cuY29tIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1790586760),
('PkgJ47CPW5vLAx8AstckLpRvmRM17gPGIHiUnD60', NULL, '66.249.93.226', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'eyJfdG9rZW4iOiJhVGJYOWRBbk5zWk5nbU1yMkVXZzNIQXo0ODRLaExjTjBoZXdmdkdJIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9hc2lsaXlldHVodWIubG92ZXN0b2Jsb2cuY29tIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1790586761);

-- --------------------------------------------------------

--
-- Table structure for table `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `phone_number` varchar(30) DEFAULT NULL,
  `message` text NOT NULL,
  `provider` varchar(50) DEFAULT 'africastalking',
  `status` varchar(50) DEFAULT 'pending',
  `response` text DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price_per_person` decimal(10,2) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` enum('admin','artisan','customer') NOT NULL DEFAULT 'customer',
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `wallet_balance` decimal(12,2) NOT NULL DEFAULT 0.00 COMMENT 'Artisan earned balance; credited automatically when an order is delivered',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `is_approved`, `wallet_balance`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Alfa', 'alfa@gmail.com', '+255698088657', 'artisan', '1', '0.00', NULL, '$2y$12$9Wi.LDRe5pLdd9rHHk0L1.s.xPqFa/n73IXrQcDhHrqlK6ahRtLrG', 'OH179DNIt6S5ETaSIawCtb9AaI6OOe6RkuV6DipS57rt2H4jOsxugOq09cRR', '2026-09-14 16:57:31', '2026-09-25 14:12:01'),
(12, 'Johnson Mwacha', 'johnson@gmail.com', '+255767890876', 'artisan', '1', '40500.00', NULL, '$2y$12$a5kFgnvt0/kwJ.engEs13enKT5eVroqd2p0jQraUhWPXNqrQ/8A.i', 'IGQrRmxVRkTsriRMa6yLmbb4PvNUGEob1oiUyaLZJpHF7QPllmQ1MI0DPeUs', '2026-09-24 05:59:32', '2026-09-28 15:26:05'),
(13, 'amini', 'amini@gmail.com', '+255697789403', 'artisan', '1', '0.00', NULL, '$2y$12$gir8AKf5SxELLEI61qGaFOcWmWBFNueW1akVLM5Cdkk2Osv3c6PG6', NULL, '2026-09-25 16:57:01', '2026-09-25 17:10:24'),
(14, 'Bariki', 'bariki@gmail.com', '0757832474', 'artisan', '1', '0.00', NULL, '$2y$12$Cl1Bd/08T4Tb7PGg4wmJReIjyU96a2qMgLDfnfHGuptMJbtpYMK4.', NULL, '2026-09-25 20:12:35', '2026-09-25 20:13:09'),
(15, 'Gillian Marcel', 'gillianmarcel18@gmail.com', '+255754595008', 'artisan', '1', '0.00', NULL, '$2y$12$XXRJEmscUDXDQ6NBs7U3hu7ebekF6hMMrfH9gH5Xxi2F9eIxSCmfm', NULL, '2026-09-25 21:06:37', '2026-09-25 21:06:59');

-- --------------------------------------------------------

--
-- Table structure for table `whatsapp_messages`
--

CREATE TABLE `whatsapp_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artisan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message_type` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `message_content` text NOT NULL,
  `status` enum('sent','delivered','read','failed') NOT NULL DEFAULT 'sent',
  `whatsapp_message_id` varchar(255) DEFAULT NULL,
  `error_details` text DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `whatsapp_settings`
--

CREATE TABLE `whatsapp_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artisan_id` bigint(20) UNSIGNED NOT NULL,
  `whatsapp_number` varchar(255) NOT NULL,
  `whatsapp_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `receive_product_alerts` tinyint(1) NOT NULL DEFAULT 1,
  `upload_method` enum('whatsapp','ussd','sms','web','manager') NOT NULL DEFAULT 'whatsapp',
  `whatsapp_group_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `whatsapp_settings`
--

INSERT INTO `whatsapp_settings` (`id`, `artisan_id`, `whatsapp_number`, `whatsapp_enabled`, `receive_product_alerts`, `upload_method`, `whatsapp_group_link`, `created_at`, `updated_at`) VALUES
(2, 3, '+255698088657', 1, 1, 'whatsapp', NULL, '2026-09-23 18:37:40', '2026-09-25 13:07:00'),
(3, 12, '+255767890876', 1, 1, 'web', NULL, '2026-09-24 06:18:56', '2026-09-28 17:00:56'),
(4, 13, '+255697789403', 1, 1, 'whatsapp', NULL, '2026-09-25 16:58:35', '2026-09-25 16:58:35'),
(5, 14, '0757832474', 1, 1, 'whatsapp', NULL, '2026-09-25 20:15:32', '2026-09-25 20:15:32');

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
-- Indexes for table `commissions`
--
ALTER TABLE `commissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commissions_product_id_foreign` (`product_id`),
  ADD KEY `commissions_order_item_id_index` (`order_item_id`),
  ADD KEY `commissions_artisan_id_index` (`artisan_id`),
  ADD KEY `commissions_status_index` (`status`);

--
-- Indexes for table `delivery_tracking`
--
ALTER TABLE `delivery_tracking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_tracking_fulfillment_id_index` (`fulfillment_id`),
  ADD KEY `delivery_tracking_event_type_index` (`event_type`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `fulfillments`
--
ALTER TABLE `fulfillments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fulfillments_product_request_id_foreign` (`product_request_id`),
  ADD KEY `fulfillments_artisan_id_foreign` (`artisan_id`),
  ADD KEY `fulfillments_status_index` (`status`),
  ADD KEY `fulfillments_tracking_number_index` (`tracking_number`);

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
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_index` (`customer_id`),
  ADD KEY `orders_status_index` (`status`),
  ADD KEY `orders_escrow_status_index` (`escrow_status`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_order_id_index` (`order_id`),
  ADD KEY `order_items_artisan_id_index` (`artisan_id`),
  ADD KEY `order_items_payment_status_index` (`payment_status`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_user_id_foreign` (`user_id`),
  ADD KEY `products_category_index` (`category`),
  ADD KEY `products_price_index` (`price`);

--
-- Indexes for table `product_requests`
--
ALTER TABLE `product_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_requests_order_id_index` (`order_id`),
  ADD KEY `product_requests_product_id_foreign` (`product_id`),
  ADD KEY `product_requests_user_id_foreign` (`user_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sms_logs_user_id_index` (`user_id`),
  ADD KEY `sms_logs_status_index` (`status`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tours_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `whatsapp_messages`
--
ALTER TABLE `whatsapp_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `whatsapp_messages_product_id_index` (`product_id`),
  ADD KEY `whatsapp_messages_artisan_id_index` (`artisan_id`),
  ADD KEY `whatsapp_messages_status_index` (`status`);

--
-- Indexes for table `whatsapp_settings`
--
ALTER TABLE `whatsapp_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `whatsapp_settings_artisan_id_unique` (`artisan_id`),
  ADD KEY `whatsapp_settings_whatsapp_enabled_index` (`whatsapp_enabled`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commissions`
--
ALTER TABLE `commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `delivery_tracking`
--
ALTER TABLE `delivery_tracking`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fulfillments`
--
ALTER TABLE `fulfillments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `product_requests`
--
ALTER TABLE `product_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `whatsapp_messages`
--
ALTER TABLE `whatsapp_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `whatsapp_settings`
--
ALTER TABLE `whatsapp_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commissions`
--
ALTER TABLE `commissions`
  ADD CONSTRAINT `commissions_artisan_id_foreign` FOREIGN KEY (`artisan_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commissions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `delivery_tracking`
--
ALTER TABLE `delivery_tracking`
  ADD CONSTRAINT `delivery_tracking_fulfillment_id_foreign` FOREIGN KEY (`fulfillment_id`) REFERENCES `fulfillments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fulfillments`
--
ALTER TABLE `fulfillments`
  ADD CONSTRAINT `fulfillments_artisan_id_foreign` FOREIGN KEY (`artisan_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fulfillments_product_request_id_foreign` FOREIGN KEY (`product_request_id`) REFERENCES `product_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_artisan_id_foreign` FOREIGN KEY (`artisan_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_requests`
--
ALTER TABLE `product_requests`
  ADD CONSTRAINT `product_requests_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_requests_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD CONSTRAINT `sms_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `whatsapp_messages`
--
ALTER TABLE `whatsapp_messages`
  ADD CONSTRAINT `whatsapp_messages_artisan_id_foreign` FOREIGN KEY (`artisan_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `whatsapp_messages_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `whatsapp_settings`
--
ALTER TABLE `whatsapp_settings`
  ADD CONSTRAINT `whatsapp_settings_artisan_id_foreign` FOREIGN KEY (`artisan_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
