-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 21, 2023 at 04:46 PM
-- Server version: 8.0.34-0ubuntu0.22.04.1
-- PHP Version: 8.1.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lumen_crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `path` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_id` int NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `profile_image`, `path`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ashok', 'ashokcustomer@gmail.com', '8521479630', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'images.jpeg', 'images/', 230, '1', '2023-07-25 06:30:07', '2023-07-25 06:30:07'),
(3, 'Chetan Sharma', 'chetan@arcsinfotech.com', '9876543210', 'Plot #434, Industrial Area\r\nPhase 9, Mohali', 'images.jpeg', 'images/', 230, '1', '2023-07-25 07:40:35', '2023-07-25 07:40:35'),
(4, 'zfdsfd', 'fdsfds@gmail.com', '6546554454', 'gfdgfdgfd', NULL, NULL, 230, '1', '2023-07-25 09:29:20', '2023-07-25 09:29:20'),
(5, 'dadad', 'dsadas2@GMAIL.COM', '23323213123', 'FDSFDSFDSFF', NULL, NULL, 230, '1', '2023-07-25 10:58:43', '2023-07-25 10:58:43'),
(6, 'ddasd', 'asdsadasd@gmail.com', '6546546465654', 'kjgjjkjkh', NULL, NULL, 230, '1', '2023-07-25 11:58:40', '2023-07-25 11:58:40'),
(7, '22222222', '22222222@gmail.com', '2222222222', '22222222222222', NULL, NULL, 230, '1', '2023-07-25 11:59:04', '2023-07-25 11:59:04');

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
(1, '2023_07_05_125136_create_users_table', 1),
(2, '2023_07_05_125440_create_posts_table', 1),
(3, '2023_07_05_132607_update_phone_field__user_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_description` text NOT NULL,
  `product_price` varchar(200) NOT NULL,
  `user_id` int NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `product_id`, `product_description`, `product_price`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '(Orange Shimmer, 8GB RAM, 128GB Storage) with No Cost EMI/Additional Exchange Offers', '19999', 230, '1', '2023-07-25 06:41:37', '2023-07-25 06:41:37'),
(2, 1, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '15000', 230, '1', '2023-07-25 06:45:08', '2023-07-25 06:45:08'),
(3, 3, 3, 'M1 chip, 256GB NVME, 8GB RAM, 8 CORE CPU ', '85000', 230, '1', '2023-07-25 07:45:41', '2023-07-25 07:45:41'),
(4, 3, 3, 'M1 chip, 256GB NVME, 8GB RAM, 8 CORE CPU ', '86000', 230, '1', '2023-07-25 07:46:32', '2023-07-25 07:46:32'),
(5, 8, 7, 'dsadsadasd', '3432432', 230, '1', '2023-07-25 12:16:50', '2023-07-25 12:16:50'),
(6, 7, 7, 'dsadsadasd', '3432432', 230, '1', '2023-07-25 12:18:46', '2023-07-25 12:18:46'),
(8, 1, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '15000', 230, '1', '2023-07-25 12:23:02', '2023-07-25 12:23:02'),
(10, 1, 7, 'dsadsadasd', '3432432', 230, '1', '2023-07-25 12:51:52', '2023-07-25 12:51:52'),
(11, 6, 7, 'dsadsadasd', '3432432', 230, '1', '2023-07-25 13:06:59', '2023-07-25 13:06:59'),
(12, 3, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '15000', 230, '1', '2023-07-26 05:41:03', '2023-07-26 05:41:03'),
(13, 1, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '15000', 230, '1', '2023-07-26 14:54:37', '2023-07-26 14:54:37'),
(14, 4, 3, 'M2 chip, 256GB NVME, 8GB RAM, 8 CORE CPU ', '87000', 230, '1', '2023-08-14 07:08:41', '2023-08-14 07:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Lorem Ipsum', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 230, '2023-07-25 06:23:34', '2023-07-25 06:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `path` varchar(200) DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_id` int NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `path`, `image`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Mobile', '15000', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'images/products/', 'pexels-hammad-khalid-1786433.jpg', 230, '1', '2023-07-25 06:31:50', '2023-07-25 06:31:50'),
(3, 'Macbook Pro', '87000', 'M2 chip, 256GB NVME, 8GB RAM, 8 CORE CPU ', 'images/products/', 'vivo.jpg', 230, '1', '2023-07-25 07:44:02', '2023-07-25 07:44:02'),
(5, '22222222', '222222', '22222222', NULL, NULL, 230, '1', '2023-07-25 12:05:57', '2023-07-25 12:05:57'),
(6, 'dasdasd', '43234', 'dsdasdsad', NULL, NULL, 230, '1', '2023-07-25 12:07:54', '2023-07-25 12:07:54'),
(7, '1111dsadsd', '3432432', 'dsadsadasd', 'images/products/', 'images.png', 230, '1', '2023-07-25 12:08:12', '2023-07-25 12:08:12'),
(8, '44411111', '444', '44', 'images/products/', 'images.jpeg', 230, '1', '2023-07-25 12:11:08', '2023-07-25 12:11:08'),
(9, 'qwq', '32131', 'dsadsadsad', NULL, NULL, 230, '1', '2023-08-11 08:15:09', '2023-08-11 08:15:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reset_token` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `reset_token`, `created_at`, `updated_at`) VALUES
(230, 'Ashok', 'ashok@gmail.com', '8529631470', '$2y$10$8XY1R8uj5Sj0baG./1U9p.6SZNGKau1iKBq5QejHGvpVabVSuj8Ya', '29c2158edd30bde8776e43447d54dba7', '2023-07-25 06:21:44', '2023-07-25 06:21:44'),
(231, 'chetansharma', 'chetan@arcsinfotech.com', '9876543210', '$2y$10$ZikBHRSwC7Pk2lBttqJsLOtJ.Z.vzcJWbqutxD2CcOwa/Z03WQgIW', 'ebf3957b35ba6ebe91389091e52f9fc5', '2023-07-25 07:48:51', '2023-07-25 07:52:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
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
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
