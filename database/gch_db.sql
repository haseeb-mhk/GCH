-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2024 at 07:31 PM
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
-- Database: `gch_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_id`, `account_status`) VALUES
(1, 15, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'draft',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `content`, `user_id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2, 'qwerqwert', 'this is for testing the image', 17, 'IMG-20240708-WA0092-Photoroom.jpg', 'published', '2024-07-21 12:41:05', '2024-07-21 12:53:52');

-- --------------------------------------------------------

--
-- Table structure for table `buyers`
--

CREATE TABLE `buyers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `photo` varchar(20) DEFAULT NULL,
  `account_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buyers`
--

INSERT INTO `buyers` (`id`, `user_id`, `full_name`, `address`, `photo`, `account_status`) VALUES
(1, 3, 'Muhammad haseeb', 'this is for checking the update query ', 'Muhammad_haseeb.jpg', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `total_price` float DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `buyer_id`, `total_price`, `created_at`, `updated_at`) VALUES
(3, 1, 0, '2024-07-20 15:29:27', '2024-07-20 15:49:28');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Fashion & apparel', 'FandA.jpeg', 'This is for checking the update query', '2024-07-07 22:01:17', '2024-07-20 22:51:39'),
(6, 'Baby & Kids', 'BandK2.webp', '', '2024-07-18 12:50:29', '2024-07-20 23:09:41'),
(7, 'Jewelry & Accessories', 'jewellary3.jpeg', '', '2024-07-18 12:51:04', '2024-07-20 23:15:30'),
(8, 'Pottery', 'pottery.jpg', '', '2024-07-18 12:51:18', '2024-07-20 23:17:31'),
(9, 'Furnitures', 'furnitures2.jpg', '', '2024-07-18 12:51:35', '2024-07-20 23:21:23');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` varchar(200) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `user_id`, `name`, `email`, `message`, `date`) VALUES
(1, 13, 'izhar', 'askdjf', 'askdj;f', '2024-07-14');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_amount` float NOT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `status` enum('pending','shipped','delivered','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_status` enum('active','inactive') DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `seller_id`, `category_id`, `sub_category_id`, `description`, `price`, `quantity`, `image1`, `image2`, `image3`, `created_at`, `updated_at`, `product_status`) VALUES
(23, 'Frock', 2, 1, 11, 'Beautiful Ladies frok', 3000, 1, 'IMG-20240708-WA0136-Photoroom.jpg', 'IMG-20240708-WA0133-Photoroom.jpg', 'IMG-20240708-WA0137-Photoroom.jpg', '2024-07-20 22:06:40', '2024-07-20 22:18:31', 'active'),
(24, 'Woolen Blanket', 2, 6, 18, 'Beautiful Handmade Baby blanket ', 4000, 1, 'IMG-20240708-WA0166-Photoroom.jpg', 'IMG-20240708-WA0168-Photoroom.jpg', 'IMG-20240708-WA0167-Photoroom.jpg', '2024-07-20 22:08:20', '2024-07-20 22:18:34', 'active'),
(25, 'Woolen Gloves', 2, 1, 14, 'Beautiful Handmade woolen gloves.\r\nWarm you hands with beautiful woolen Gloves.', 500, 1, 'IMG-20240708-WA0073-Photoroom.jpg', 'IMG-20240708-WA0070-Photoroom.jpg', 'IMG-20240708-WA0067-Photoroom.jpg', '2024-07-20 22:10:05', '2024-07-20 22:18:35', 'active'),
(26, 'Woolen Gloves', 2, 1, 14, 'wear something special on this winter.\r\n', 600, 1, 'IMG-20240708-WA0081-Photoroom.jpg', 'IMG-20240708-WA0078-Photoroom.jpg', 'IMG-20240708-WA0079-Photoroom.jpg', '2024-07-20 22:11:16', '2024-07-20 22:18:36', 'active'),
(27, 'Baby Hat', 2, 6, 16, 'An amazing good looking baby Hat for your Sweet children.\r\nOrder now.....', 1000, 1, 'hat-image1.jpg', 'IMG-20240708-WA0086-Photoroom.jpg', 'IMG-20240708-WA0087-Photoroom.jpg', '2024-07-20 22:13:07', '2024-07-20 22:18:37', 'active'),
(28, 'Baby Hat with moon', 2, 6, 17, '', 2000, 1, 'IMG-20240708-WA0093-Photoroom.jpg', 'IMG-20240708-WA0092-Photoroom.jpg', 'IMG-20240708-WA0091-Photoroom.jpg', '2024-07-20 22:14:29', '2024-07-20 22:18:38', 'active'),
(29, 'Baby knit hat for girls', 2, 6, 16, '', 499, 1, 'IMG-20240708-WA0160-Photoroom.jpg', 'IMG-20240708-WA0163-Photoroom.jpg', 'IMG-20240708-WA0165-Photoroom.jpg', '2024-07-20 22:16:14', '2024-07-20 22:18:38', 'active'),
(30, 'Women Shawl with craftmanship ', 2, 1, 12, '', 2199, 1, 'IMG-20240708-WA0104-Photoroom.jpg', 'IMG-20240708-WA0103-Photoroom.jpg', 'IMG-20240708-WA0099-Photoroom.jpg', '2024-07-20 22:18:17', '2024-07-20 22:18:39', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `review_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `business_type` varchar(255) DEFAULT NULL,
  `account_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `user_id`, `business_name`, `business_type`, `account_status`) VALUES
(1, 13, 'Izhar Shawls', 'Boutique Shop', 'active'),
(2, 17, 'atif furnitures', 'Craftsperson_Artisan', 'active'),
(4, 26, 'ghufran shawls', 'Boutique Shop', 'active'),
(5, 27, 'jibran Handicrafts', 'home_base_business', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `start_date` datetime DEFAULT current_timestamp(),
  `end_date` datetime DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'inactive',
  `is_new` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `seller_id`, `start_date`, `end_date`, `status`, `is_new`) VALUES
(12, 2, '2024-07-14 00:00:00', '2025-01-01 00:00:00', 'active', 0),
(14, 1, '2024-07-14 00:00:00', '2025-01-01 00:00:00', 'active', 0),
(16, 5, '2024-07-17 00:00:00', '2025-01-01 00:00:00', 'active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `parent_category_id`, `description`, `created_at`, `updated_at`) VALUES
(11, 'Handmade cloths', 1, '', '2024-07-18 12:51:59', '2024-07-18 12:51:59'),
(12, 'Shawls', 1, '', '2024-07-18 12:52:17', '2024-07-18 12:52:17'),
(13, 'Caps & Hats', 1, '', '2024-07-18 12:52:38', '2024-07-18 12:52:38'),
(14, 'Gloves', 1, '', '2024-07-18 12:52:52', '2024-07-18 12:52:52'),
(15, 'Purse & Bags', 1, '', '2024-07-18 12:53:05', '2024-07-18 12:53:05'),
(16, 'Baby Clothing', 6, '', '2024-07-18 14:03:47', '2024-07-18 14:03:47'),
(17, 'Kids Clothing', 6, '', '2024-07-20 21:59:56', '2024-07-20 21:59:56'),
(18, 'Blankets', 6, '', '2024-07-20 22:00:22', '2024-07-20 22:00:22'),
(19, 'Baby Toys', 6, '', '2024-07-20 22:01:38', '2024-07-20 22:01:38'),
(20, 'Necklace', 7, '', '2024-07-20 22:02:01', '2024-07-20 22:02:01'),
(21, 'Braceletes', 7, '', '2024-07-20 22:02:10', '2024-07-20 22:02:10'),
(22, 'Earings', 7, '', '2024-07-20 22:02:19', '2024-07-20 22:02:19'),
(23, 'Beds', 9, '', '2024-07-20 22:02:35', '2024-07-20 22:02:35'),
(24, 'Tables', 9, '', '2024-07-20 22:02:42', '2024-07-20 22:02:42'),
(25, 'Cupboards', 9, '', '2024-07-20 22:02:51', '2024-07-20 22:02:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('buyer','seller','admin') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`, `updated_at`) VALUES
(3, 'haseeb', 'haseeb259', 'h@gmail.com', 'buyer', '2024-07-09 15:42:13', '2024-07-09 15:42:13'),
(13, 'izhar', 'izhar259', 'izhar@gmail.com', 'seller', '2024-07-09 15:58:31', '2024-07-09 15:58:31'),
(15, 'admin', 'admin123', 'admin123@gmail.com', 'admin', '2024-07-09 16:35:00', '2024-07-16 22:15:01'),
(17, 'atif', 'atif123', 'atif@gmail.com', 'seller', '2024-07-14 17:55:38', '2024-07-14 17:55:38'),
(26, 'ghufran', 'ghufra123', 'ghufran@gmal.com', 'seller', '2024-07-17 15:19:11', '2024-07-17 15:19:11'),
(27, 'jibran', 'jibran123', 'jibran@gmail.com', 'seller', '2024-07-17 18:36:32', '2024-07-17 18:36:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `buyers`
--
ALTER TABLE `buyers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_ibfk_1` (`buyer_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_ibfk_1` (`cart_id`),
  ADD KEY `cart_items_ibfk_2` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `products_ibfk_3` (`sub_category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_ibfk_1` (`product_id`),
  ADD KEY `reviews_ibfk_2` (`user_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_ibfk_1` (`parent_category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `buyers`
--
ALTER TABLE `buyers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buyers`
--
ALTER TABLE `buyers`
  ADD CONSTRAINT `buyers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sellers`
--
ALTER TABLE `sellers`
  ADD CONSTRAINT `sellers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`);

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_ibfk_1` FOREIGN KEY (`parent_category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
