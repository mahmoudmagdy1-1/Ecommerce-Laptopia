-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 12, 2025 at 01:45 AM
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
-- Table structure for table `Cart`
--

CREATE TABLE `Cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Cart`
--

INSERT INTO `Cart` (`cart_id`, `user_id`, `created_at`, `updated_at`) VALUES
(54, 8, '2025-03-11 22:06:21', '2025-03-11 22:06:21'),
(55, 12, '2025-03-11 23:15:21', '2025-03-11 23:15:21');

-- --------------------------------------------------------

--
-- Table structure for table `CartItems`
--

CREATE TABLE `CartItems` (
  `item_id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE `Categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`category_id`, `name`) VALUES
(5, 'Laptops'),
(6, 'Accessories'),
(7, 'Computer Components'),
(9, 'Laptop Components');

-- --------------------------------------------------------

--
-- Table structure for table `OrderItems`
--

CREATE TABLE `OrderItems` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `OrderItems`
--

INSERT INTO `OrderItems` (`order_item_id`, `order_id`, `product_id`, `quantity`) VALUES
(8, 24, 73, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`order_id`, `user_id`, `created_at`) VALUES
(24, 12, '2025-03-12 01:16:28');

-- --------------------------------------------------------

--
-- Table structure for table `Payments`
--

CREATE TABLE `Payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` enum('Success','Failed','Pending') DEFAULT 'Pending',
  `method` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Payments`
--

INSERT INTO `Payments` (`payment_id`, `order_id`, `status`, `method`) VALUES
(7, 24, 'Success', 'Cash On Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `ProductImages`
--

CREATE TABLE `ProductImages` (
  `product_image_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ProductImages`
--

INSERT INTO `ProductImages` (`product_image_id`, `product_id`, `image_url`, `alt_text`) VALUES
(75, 72, 'LD0006079509.jpg', 'Apple MacBook Pro 16'),
(76, 72, 'LD0006079508.jpg', 'Apple MacBook Pro 16'),
(77, 72, 'LD0006079507.jpg', 'Apple MacBook Pro 16'),
(78, 81, 'LD0004863463_2_0004863769.jpg', 'MSI GS66 Stealth'),
(79, 81, 'LD0004863468_2_0004863773.jpg', 'MSI GS66 Stealth'),
(80, 81, 'LD0004863448_2_0004863757.jpg', 'MSI GS66 Stealth'),
(81, 80, 'LD0006171442.jpg', 'Gigabyte AERO 15 OLED'),
(82, 80, 'LD0006171441.jpg', 'Gigabyte AERO 15 OLED'),
(83, 80, 'LD0006171440.jpg', 'Gigabyte AERO 15 OLED'),
(84, 79, 'LD0006142537_0006195081.jpg', 'Acer Predator Helios 300'),
(85, 79, 'LD0006138304_0006142510_0006142534_0006195078.jpg', 'Acer Predator Helios 300'),
(86, 79, 'LD0006138303_0006142509_0006142533_0006195077.jpg', 'Acer Predator Helios 300'),
(87, 78, 'LD0006219656.jpg', 'Razer Blade 15'),
(88, 78, 'LD0006219655.jpg', 'Razer Blade 15'),
(89, 78, 'LD0006219654.jpg', 'Razer Blade 15'),
(90, 77, 'LD0006089788_0006100944.jpg', 'Microsoft Surface Laptop 4'),
(91, 77, 'LD0006089787_0006100943.jpg', 'Microsoft Surface Laptop 4'),
(92, 77, 'LD0006089786_0006100942.jpg', 'Microsoft Surface Laptop 4'),
(93, 76, 'LD0006056125.jpg', 'Asus ROG Zephyrus G14'),
(94, 76, 'LD0006056124.jpg', 'Asus ROG Zephyrus G14'),
(95, 76, 'LD0006056123.jpg', 'Asus ROG Zephyrus G14'),
(96, 75, 'LD0006133107_0006133155.jpg', 'Lenovo ThinkPad X1 Carbon'),
(97, 75, 'LD0006133106_0006133154.jpg', 'Lenovo ThinkPad X1 Carbon'),
(98, 75, 'LD0006133105_0006133153.jpg', 'Lenovo ThinkPad X1 Carbon'),
(99, 74, 'LD0006220085.jpg', 'HP Spectre x360'),
(100, 74, 'LD0006220084.jpg', 'HP Spectre x360'),
(101, 74, 'LD0006220083.jpg', 'HP Spectre x360'),
(102, 73, '4f6e2aaba51045659af92c305b7a907a.webp', 'Dell XPS 13'),
(103, 83, 'LD0006206365.jpg', 'Samsung Galaxy Book Pro 360'),
(104, 83, 'LD0006206367.jpg', 'Samsung Galaxy Book Pro 360'),
(105, 83, 'LD0006206366.jpg', 'Samsung Galaxy Book Pro 360');

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `discount_percentage` tinyint(3) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`product_id`, `name`, `description`, `price`, `quantity`, `category_id`, `created_at`, `discount_percentage`) VALUES
(72, 'Apple MacBook Pro 16', 'The Apple MacBook Pro 16&quot; is designed for professionals who need incredible performance, stunning visuals, and industry-leading capabilities. Equipped with the latest Apple M1 Pro chip, 16GB RAM, and a 512GB SSD, this powerhouse is built to handle any task you throw at it. The Retina display ensures stunning visuals, while its battery life keeps you working for hours. Ideal for professionals and content creators.', 2399.99, 50, 5, '2025-03-12 00:12:20', 10),
(73, 'Dell XPS 13', 'The Dell XPS 13 is a premium ultrabook designed for professionals and students who need a balance of power and portability. Featuring an Intel Core i7 processor, 16GB RAM, and a 512GB SSD, this laptop offers ultra-fast performance. Its near bezel-less 4K display makes it one of the most immersive laptops on the market.', 1499.99, 100, 5, '2025-03-12 00:12:20', 15),
(74, 'HP Spectre x360', 'The HP Spectre x360 is a high-end 2-in-1 laptop that combines powerful performance with stunning design. Featuring an Intel Core i7 processor, 16GB RAM, and a 512GB SSD, this laptop is perfect for both work and entertainment. The 360-degree hinge allows for multiple modes, including laptop and tablet configurations.', 1399.99, 80, 5, '2025-03-12 00:12:20', 12),
(75, 'Lenovo ThinkPad X1 Carbon', 'The Lenovo ThinkPad X1 Carbon is an ultra-lightweight business laptop designed for professionals. Equipped with an Intel Core i7 processor, 16GB RAM, and a 512GB SSD, this laptop offers enterprise-grade security features like a fingerprint sensor and facial recognition. With its long battery life and durable carbon fiber chassis, it is ideal for business travelers.', 1699.99, 60, 5, '2025-03-12 00:12:20', 8),
(76, 'Asus ROG Zephyrus G14', 'The Asus ROG Zephyrus G14 is a powerful gaming laptop designed for performance enthusiasts. Featuring an AMD Ryzen 9 processor, 32GB RAM, and a 1TB SSD, this laptop provides top-tier gaming experiences. The 14-inch Full HD display boasts a 120Hz refresh rate for ultra-smooth gameplay, and its advanced cooling system keeps temperatures low even during intense gaming.', 1999.99, 40, 5, '2025-03-12 00:12:20', 20),
(77, 'Microsoft Surface Laptop 4', 'The Microsoft Surface Laptop 4 is a stylish and powerful laptop ideal for professionals and students alike. Equipped with an Intel Core i7 processor, 16GB RAM, and a 512GB SSD, it ensures smooth multitasking. The PixelSense touchscreen display offers vibrant colors and crystal-clear visuals, making it perfect for presentations and media consumption.', 1799.99, 90, 5, '2025-03-12 00:12:20', 5),
(78, 'Razer Blade 15', 'The Razer Blade 15 is the ultimate gaming laptop featuring an Intel Core i9 processor, NVIDIA GeForce RTX 3080 GPU, 32GB RAM, and a 1TB SSD. With a high refresh rate 240Hz display, this laptop ensures smooth, lag-free gaming. The CNC aluminum build adds to its durability, making it a premium choice for gamers.', 2599.99, 45, 5, '2025-03-12 00:12:20', 18),
(79, 'Acer Predator Helios 300', 'The Acer Predator Helios 300 is a high-performance gaming laptop that delivers incredible value for money. Powered by an Intel Core i7 processor, NVIDIA RTX 3060 GPU, 16GB RAM, and a 512GB SSD, this laptop is perfect for competitive gaming. Its 144Hz display provides ultra-smooth gameplay, and its advanced cooling system prevents overheating.', 1299.99, 70, 5, '2025-03-12 00:12:20', 22),
(80, 'Gigabyte AERO 15 OLED', 'The Gigabyte AERO 15 OLED is a premium laptop designed for content creators and designers. Featuring an Intel Core i9 processor, NVIDIA RTX 3070 GPU, 32GB RAM, and a 1TB SSD, this laptop is a powerhouse for video editing and 3D rendering. Its 15.6-inch 4K OLED display offers exceptional color accuracy and stunning detail.', 2299.99, 55, 5, '2025-03-12 00:12:20', 10),
(81, 'MSI GS66 Stealth', 'The MSI GS66 Stealth is a stealthy yet powerful gaming laptop built for high-performance computing. Featuring an Intel Core i7 processor, NVIDIA RTX 3070 GPU, 16GB RAM, and a 1TB SSD, this laptop delivers top-tier gaming and productivity performance. With a 300Hz refresh rate display, it provides an ultra-responsive gaming experience.', 2199.99, 50, 5, '2025-03-12 00:12:20', 14),
(83, 'Samsung Galaxy Book Pro 360', 'The Samsung Galaxy Book Pro 360 is an ultra-thin 2-in-1 convertible laptop featuring a 15.6-inch AMOLED touchscreen display. Powered by an Intel Core i7 processor, 16GB RAM, and a 512GB SSD, this laptop is perfect for digital artists and professionals. The S-Pen support and flexible hinge make it an excellent device for drawing and note-taking.', 1599.99, 75, 5, '2025-03-12 00:12:20', 9);

-- --------------------------------------------------------

--
-- Table structure for table `Reviews`
--

CREATE TABLE `Reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` mediumtext DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Shipping`
--

CREATE TABLE `Shipping` (
  `shipping_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `status` enum('Shipped','Delivered','Returned','Pending','Canceled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Shipping`
--

INSERT INTO `Shipping` (`shipping_id`, `order_id`, `address`, `city`, `state`, `status`) VALUES
(7, 24, '5 house', 'sadnfkl', 'sdfaniosad', 'Delivered');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `role` varchar(50) NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`user_id`, `name`, `phone`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'dsaf', '0112214124', 'example@email.com', '$2y$10$UMmSkcvDYoO./QoFTKLhwueHYxznPuSgFw3g.T9pj.5FWjuc/5U96', '2025-03-08 18:33:59', 'customer'),
(4, 'dsaf', '0112214124', 'example1@email.com', '$2y$10$K/7ZclYkR6xiRvqmONLeE.NMhk0UgS5ZhoD0nymDsgHkqbmbhtPY2', '2025-03-08 18:38:10', 'customer'),
(5, 'example', '123456', 'exampler1@email.com', '$2y$10$HU4YV7hPghpGUS8HSW9oYOagZJLvT.0L/SITtL45EWg.PBH0DKQHC', '2025-03-09 14:17:31', 'customer'),
(6, 'Karleigh Austin', '19552289578', 'tyxowery@mailinator.com', '$2y$10$rm6nSy3sBuB.IxUicl4kZu4Nlo1rKaN0cktbw4cbQdTtkoVft05Iq', '2025-03-09 14:18:37', 'customer'),
(7, 'Karleigh Austin', '19552289578', 'tyxowxry@mailinator.com', '$2y$10$JGkDPlilMlZ9REFdrjRaGu5rk.9EfbzAFgoUZDl4E/gwg3fAvkucO', '2025-03-09 14:24:51', 'customer'),
(8, 'Admin', '01234566121', 'admin@email.com', '$2y$10$UMmSkcvDYoO./QoFTKLhwueHYxznPuSgFw3g.T9pj.5FWjuc/5U96', '2025-03-09 15:16:10', 'admin'),
(9, 'mohamed', '0213123123', 'mohamed@email.com', '$2y$10$N6m9Jv17Pcea9efLCttudeTHr9JjXrcIGCeCiav4XhFBn/NWzUHAa', '2025-03-10 16:09:51', 'customer'),
(10, 'Mahmoud', '124412124', 'mahmoud@email.com', '$2y$10$itp2n3mkS9Jqu4pAb.PbGesI0VDPBhKQGJpQApMJEHewbg/4k7ZtC', '2025-03-11 22:01:22', 'customer'),
(11, 'ahmed', '123154', 'ahmed@email.com', '$2y$10$cAvmySKAY8CIGdt.hPNB6OH8nUeDUb.plv1B0hfBTBYoUZhpQzsFO', '2025-03-11 22:05:19', 'customer'),
(12, 'ziad', '123415', 'ziad@email.com', '$2y$10$AjkaVbg1xaPIZzOv8Cr30OWcz70ZkjIVQsghEJ0t.i6Ky1RS3s3.6', '2025-03-12 01:15:21', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `Wishlist`
--

CREATE TABLE `Wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Cart`
--
ALTER TABLE `Cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `CartItems`
--
ALTER TABLE `CartItems`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `OrderItems`
--
ALTER TABLE `OrderItems`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Payments`
--
ALTER TABLE `Payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `ProductImages`
--
ALTER TABLE `ProductImages`
  ADD PRIMARY KEY (`product_image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `Reviews`
--
ALTER TABLE `Reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Shipping`
--
ALTER TABLE `Shipping`
  ADD PRIMARY KEY (`shipping_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `Wishlist`
--
ALTER TABLE `Wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Cart`
--
ALTER TABLE `Cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `CartItems`
--
ALTER TABLE `CartItems`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `Categories`
--
ALTER TABLE `Categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `OrderItems`
--
ALTER TABLE `OrderItems`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `Payments`
--
ALTER TABLE `Payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ProductImages`
--
ALTER TABLE `ProductImages`
  MODIFY `product_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `Reviews`
--
ALTER TABLE `Reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Shipping`
--
ALTER TABLE `Shipping`
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Wishlist`
--
ALTER TABLE `Wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Cart`
--
ALTER TABLE `Cart`
  ADD CONSTRAINT `Cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Constraints for table `CartItems`
--
ALTER TABLE `CartItems`
  ADD CONSTRAINT `CartItems_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `Cart` (`cart_id`);

--
-- Constraints for table `OrderItems`
--
ALTER TABLE `OrderItems`
  ADD CONSTRAINT `OrderItems_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `Orders` (`order_id`),
  ADD CONSTRAINT `OrderItems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`product_id`);

--
-- Constraints for table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Constraints for table `Payments`
--
ALTER TABLE `Payments`
  ADD CONSTRAINT `Payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `Orders` (`order_id`);

--
-- Constraints for table `ProductImages`
--
ALTER TABLE `ProductImages`
  ADD CONSTRAINT `ProductImages_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Products` (`product_id`);

--
-- Constraints for table `Products`
--
ALTER TABLE `Products`
  ADD CONSTRAINT `Products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `Categories` (`category_id`);

--
-- Constraints for table `Reviews`
--
ALTER TABLE `Reviews`
  ADD CONSTRAINT `Reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Products` (`product_id`),
  ADD CONSTRAINT `Reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Constraints for table `Shipping`
--
ALTER TABLE `Shipping`
  ADD CONSTRAINT `Shipping_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `Orders` (`order_id`);

--
-- Constraints for table `Wishlist`
--
ALTER TABLE `Wishlist`
  ADD CONSTRAINT `Wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`),
  ADD CONSTRAINT `Wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
