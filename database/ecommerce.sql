-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2026 at 08:17 PM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'T-shirts', NULL, NULL, '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
(11, 'Hoodie', NULL, NULL, '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
(22, 'Jeans', NULL, NULL, '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
(33, 'Shirts', NULL, NULL, '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
(45, 'Shorts', NULL, NULL, '2026-09-01 11:41:05', '2026-09-01 11:41:05');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(150) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `payment_method` enum('cash_on_delivery','card') NOT NULL DEFAULT 'cash_on_delivery',
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `delivery_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `brand_id` int(10) UNSIGNED DEFAULT NULL,
  `style` varchar(50) DEFAULT NULL,
  `gender` varchar(30) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `discount` decimal(5,2) DEFAULT 0.00,
  `rating` decimal(2,1) DEFAULT 0.0,
  `review_count` int(10) UNSIGNED DEFAULT 0,
  `description` text DEFAULT NULL,
  `details` text DEFAULT NULL,
  `stock` int(10) UNSIGNED DEFAULT 0,
  `main_image` varchar(255) DEFAULT NULL,
  `colors` varchar(500) DEFAULT NULL,
  `sizes` varchar(255) DEFAULT NULL,
  `tags` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `brand_id`, `style`, `gender`, `price`, `original_price`, `discount`, `rating`, `review_count`, `description`, `details`, `stock`, `main_image`, `colors`, `sizes`, `tags`, `created_at`, `updated_at`) VALUES
('black-casual-shorts', 'Black Casual Shorts', 45, NULL, 'Casual', 'Men', 145.00, 180.00, 19.00, 4.4, 182, 'A casual short designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 11, 'assets/images/products/Pic47.jpg', 'Black', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('black-denim-shorts', 'Black Denim Shorts', 45, NULL, 'Casual', 'Men', 165.00, 205.00, 20.00, 4.6, 244, 'A casual short designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 23, 'assets/images/products/Pic51.jpg', 'Black', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('black-graphic-tshirt', 'Black Graphic T-Shirt', 1, NULL, 'Casual', 'Men', 110.00, 140.00, 21.00, 4.3, 286, 'A casual t-shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 16, 'assets/images/products/Pic2.jpg', 'Black', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('black-jeans', 'Black Straight Jeans', 22, NULL, 'Casual', 'Men', 245.00, 305.00, 20.00, 4.7, 425, 'A casual jean designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 21, 'assets/images/products/Pic27.jpg', 'Black', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('black-overshirt', 'Black Overshirt', 33, NULL, 'Casual', 'Men', 205.00, 255.00, 20.00, 4.5, 278, 'A casual shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 34, 'assets/images/products/Pic43.jpg', 'Black', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('black-pocket-shirt', 'Black Pocket Shirt', 33, NULL, 'Casual', 'Men', 195.00, 245.00, 20.00, 4.4, 198, 'A casual shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 37, 'assets/images/products/Pic44.jpg', 'Black', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('black-print-tshirt', 'Black Print T-Shirt', 1, NULL, 'Casual', 'Men', 120.00, 150.00, 20.00, 4.5, 241, 'A casual t-shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 28, 'assets/images/products/Pic6.jpg', 'Black', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('black-red-graphic-tshirt', 'Black Red Graphic T-Shirt', 1, NULL, 'Casual', 'Men', 125.00, 155.00, 19.00, 4.6, 289, 'A casual t-shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 34, 'assets/images/products/Pic8.jpg', 'Black', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('black-shirt', 'Black Button Shirt', 33, NULL, 'Formal', 'Men', 190.00, 240.00, 21.00, 4.7, 354, 'A formal shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 22, 'assets/images/products/Pic39.jpg', 'Black', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('black-shorts', 'Black Casual Shorts', 45, NULL, 'Casual', 'Men', 150.00, 190.00, 21.00, 4.5, 211, 'A casual short designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 40, 'assets/images/products/Pic45.jpg', 'Black', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('black-sport-shorts', 'Black Sport Shorts', 45, NULL, 'Gym', 'Men', 145.00, 180.00, 19.00, 4.4, 173, 'A gym short designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 20, 'assets/images/products/Pic50.jpg', 'Black', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('black-striped-shirt', 'Black Striped Shirt', 33, NULL, 'Formal', 'Men', 195.00, 245.00, 20.00, 4.5, 241, 'A formal shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 28, 'assets/images/products/Pic41.jpg', 'Black', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('black-wide-jeans', 'Black Wide Jeans', 22, NULL, 'Casual', 'Men', 255.00, 320.00, 20.00, 4.5, 274, 'A casual jean designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 36, 'assets/images/products/Pic32.jpg', 'Black', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('blue-denim-shorts', 'Blue Denim Shorts', 45, NULL, 'Casual', 'Men', 160.00, 200.00, 20.00, 4.6, 265, 'A casual short designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 14, 'assets/images/products/Pic48.jpg', 'Blue', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('blue-hoodie', 'Light Blue Hoodie', 11, NULL, 'Casual', 'Men', 225.00, 280.00, 20.00, 4.5, 221, 'A casual hoodie designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 17, 'assets/images/products/Pic14.jpg', 'Blue', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('blue-print-tshirt', 'Blue Print T-Shirt', 1, NULL, 'Casual', 'Men', 115.00, 145.00, 21.00, 4.4, 198, 'A casual t-shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 22, 'assets/images/products/Pic4.jpg', 'Blue', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('blue-text-tshirt', 'Blue Text T-Shirt', 1, NULL, 'Casual', 'Men', 110.00, 135.00, 19.00, 4.3, 154, 'A casual t-shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 37, 'assets/images/products/Pic9.jpg', 'Blue', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('blue-zip-hoodie', 'Blue Zip Hoodie', 11, NULL, 'Casual', 'Men', 220.00, 275.00, 20.00, 4.3, 165, 'A casual hoodie designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 26, 'assets/images/products/Pic17.jpg', 'Blue', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('brown-casual-shirt', 'Brown Casual Shirt', 33, NULL, 'Casual', 'Men', 185.00, 230.00, 20.00, 4.3, 151, 'A casual shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 31, 'assets/images/products/Pic42.jpg', 'Brown', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('brown-shirt', 'Brown Button Shirt', 33, NULL, 'Formal', 'Men', 195.00, 245.00, 20.00, 4.5, 219, 'A formal shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 16, 'assets/images/products/Pic37.jpg', 'Brown', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('brown-trousers', 'Brown Straight Trousers', 22, NULL, 'Formal', 'Men', 270.00, 340.00, 21.00, 4.5, 218, 'A formal jean designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 15, 'assets/images/products/Pic25.jpg', 'Brown', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('burgundy-graphic-tshirt', 'Burgundy Graphic T-Shirt', 1, NULL, 'Casual', 'Men', 125.00, 160.00, 22.00, 4.6, 312, 'A casual t-shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 19, 'assets/images/products/Pic3.jpg', 'Burgundy', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('burgundy-hoodie', 'Burgundy Hoodie', 11, NULL, 'Casual', 'Men', 220.00, 280.00, 21.00, 4.6, 341, 'A casual hoodie designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 43, 'assets/images/products/Pic11.jpg', 'Burgundy', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('burgundy-shirt', 'Burgundy Polo Shirt', 33, NULL, 'Casual', 'Men', 170.00, 215.00, 21.00, 4.4, 192, 'A casual shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 19, 'assets/images/products/Pic38.jpg', 'Burgundy', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('burgundy-trousers', 'Burgundy Straight Trousers', 22, NULL, 'Formal', 'Men', 260.00, 320.00, 19.00, 4.3, 176, 'A formal jean designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 44, 'assets/images/products/Pic23.jpg', 'Burgundy', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('burgundy-zip-hoodie', 'Burgundy Zip Hoodie', 11, NULL, 'Casual', 'Men', 240.00, 300.00, 20.00, 4.4, 198, 'A casual hoodie designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 14, 'assets/images/products/Pic13.jpg', 'Burgundy', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('cream-graphic-hoodie', 'Cream Graphic Hoodie', 11, NULL, 'Casual', 'Men', 240.00, 300.00, 20.00, 4.6, 248, 'A casual hoodie designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 23, 'assets/images/products/Pic16.jpg', 'Cream', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('cream-graphic-tshirt', 'Cream Graphic T-Shirt', 1, NULL, 'Casual', 'Men', 120.00, 150.00, 20.00, 4.5, 203, 'A casual t-shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 40, 'assets/images/products/Pic10.jpg', 'Cream', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('cream-hoodie', 'Cream Hoodie', 11, NULL, 'Casual', 'Men', 235.00, 295.00, 20.00, 4.5, 213, 'A casual hoodie designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 35, 'assets/images/products/Pic20.jpg', 'Cream', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('cream-shirt', 'Cream Casual Shirt', 33, NULL, 'Casual', 'Men', 185.00, 230.00, 20.00, 4.3, 143, 'A casual shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 13, 'assets/images/products/Pic36.jpg', 'Cream', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('cream-shorts', 'Cream Relaxed Shorts', 45, NULL, 'Casual', 'Men', 155.00, 195.00, 21.00, 4.5, 193, 'A casual short designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 17, 'assets/images/products/Pic49.jpg', 'Cream', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('dark-blue-jeans', 'Dark Blue Jeans', 22, NULL, 'Casual', 'Men', 240.00, 300.00, 20.00, 4.5, 451, 'A casual jean designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 41, 'assets/images/products/Pic22.jpg', 'Blue', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('dark-graphic-tshirt', 'Dark Graphic T-Shirt', 1, NULL, 'Casual', 'Men', 130.00, 160.00, 19.00, 4.7, 367, 'A casual t-shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 25, 'assets/images/products/Pic5.jpg', 'Charcoal', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('dark-green-hoodie', 'Dark Green Hoodie', 11, NULL, 'Casual', 'Men', 245.00, 305.00, 20.00, 4.8, 356, 'A casual hoodie designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 32, 'assets/images/products/Pic19.jpg', 'Green', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('dark-wide-jeans', 'Dark Wide Jeans', 22, NULL, 'Casual', 'Men', 255.00, 320.00, 20.00, 4.5, 291, 'A casual jean designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 27, 'assets/images/products/Pic29.jpg', 'Black', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('faded-blue-jeans', 'Faded Blue Jeans', 22, NULL, 'Casual', 'Men', 240.00, 300.00, 20.00, 4.6, 318, 'A casual jean designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 33, 'assets/images/products/Pic31.jpg', 'Blue', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('graphic-blue-tshirt', 'Graphic Blue T-Shirt', 1, NULL, 'Casual', 'Men', 120.00, 150.00, 20.00, 4.5, 451, 'A casual t-shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 13, 'assets/images/products/Pic1.jpg', 'Blue', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('green-hoodie', 'Green Hoodie', 11, NULL, 'Casual', 'Men', 230.00, 290.00, 21.00, 4.5, 276, 'A casual hoodie designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 11, 'assets/images/products/Pic12.jpg', 'Green', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('green-shirt', 'Dark Green Shirt', 33, NULL, 'Formal', 'Men', 180.00, 225.00, 20.00, 4.4, 167, 'A formal shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 39, 'assets/images/products/Pic33.jpg', 'Green', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('green-trousers', 'Green Wide Trousers', 22, NULL, 'Casual', 'Men', 250.00, 310.00, 19.00, 4.4, 203, 'A casual jean designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 12, 'assets/images/products/Pic24.jpg', 'Green', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('grey-hoodie', 'Grey Printed Hoodie', 11, NULL, 'Casual', 'Men', 230.00, 285.00, 19.00, 4.4, 187, 'A casual hoodie designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 29, 'assets/images/products/Pic18.jpg', 'Grey', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('light-blue-jeans', 'Light Blue Jeans', 22, NULL, 'Casual', 'Men', 230.00, 290.00, 21.00, 4.6, 387, 'A casual jean designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 18, 'assets/images/products/Pic26.jpg', 'Blue', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('light-blue-shirt', 'Light Blue Shirt', 33, NULL, 'Formal', 'Men', 175.00, 220.00, 20.00, 4.5, 231, 'A formal shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 42, 'assets/images/products/Pic34.jpg', 'Blue', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('light-blue-wide-jeans', 'Light Blue Wide Jeans', 22, NULL, 'Casual', 'Men', 250.00, 315.00, 21.00, 4.4, 239, 'A casual jean designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 24, 'assets/images/products/Pic28.jpg', 'Blue', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('light-denim-shorts', 'Light Denim Shorts', 45, NULL, 'Casual', 'Men', 160.00, 200.00, 20.00, 4.5, 218, 'A casual short designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 26, 'assets/images/products/Pic52.jpg', 'Blue', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('navy-hoodie', 'Navy Hoodie', 11, NULL, 'Casual', 'Men', 225.00, 280.00, 20.00, 4.4, 194, 'A casual hoodie designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 38, 'assets/images/products/Pic21.jpg', 'Navy', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('navy-polo', 'Navy Polo Shirt', 33, NULL, 'Casual', 'Men', 175.00, 220.00, 20.00, 4.6, 267, 'A casual shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 25, 'assets/images/products/Pic40.jpg', 'Navy', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('pale-blue-jeans', 'Pale Blue Jeans', 22, NULL, 'Casual', 'Men', 235.00, 295.00, 20.00, 4.3, 183, 'A casual jean designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 30, 'assets/images/products/Pic30.jpg', 'Blue', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('pink-shorts', 'Pink Sport Shorts', 45, NULL, 'Gym', 'Men', 140.00, 175.00, 20.00, 4.3, 156, 'A gym short designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 43, 'assets/images/products/Pic46.jpg', 'Pink', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('striped-white-shirt', 'Striped White Shirt', 33, NULL, 'Formal', 'Men', 190.00, 240.00, 21.00, 4.6, 286, 'A formal shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 10, 'assets/images/products/Pic35.jpg', 'White', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('white-blue-print-tshirt', 'White Blue Print T-Shirt', 1, NULL, 'Casual', 'Men', 115.00, 140.00, 18.00, 4.2, 176, 'A casual t-shirt designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 31, 'assets/images/products/Pic7.jpg', 'White', 'Small, Medium, Large, X-Large', 'new', '2026-09-01 11:41:05', '2026-09-01 11:41:05'),
('white-print-hoodie', 'White Graphic Hoodie', 11, NULL, 'Casual', 'Men', 235.00, 295.00, 20.00, 4.7, 302, 'A casual hoodie designed for everyday wear.', 'Comfortable fit with a simple, versatile design.', 20, 'assets/images/products/Pic15.jpg', 'White', 'Small, Medium, Large, X-Large', 'top-selling', '2026-09-01 11:41:05', '2026-09-01 11:41:05');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'sama ayman', 'samaayman@gmail.com', '$2y$10$jBPA.xy.aW8wjaxGD9leju.8egqSyHcXrMwYa1J./MlQULgdEtb/e', 'customer', 'active', '2026-09-01 17:33:27', '2026-09-01 18:00:52'),
(2, 'admin', 'admin@gmail.com', '$2y$10$uO52/2Ki7Ts75thiCuIUEuQ5yiu9KZ5UXzceO8WEd2PoJjL2EQNti', 'admin', 'active', '2026-09-01 18:05:56', '2026-09-01 18:06:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_clients_user` (`user_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_client` (`client_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_items_order` (`order_id`),
  ADD KEY `fk_order_items_product` (`product_id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_category` (`category_id`),
  ADD KEY `fk_products_brand` (`brand_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `fk_clients_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
