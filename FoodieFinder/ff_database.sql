z-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2025 at 11:39 AM
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
-- Database: `ff_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `bingo`
--

CREATE TABLE `bingo` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `item1` varchar(255) NOT NULL,
  `item2` varchar(255) NOT NULL,
  `item3` varchar(255) NOT NULL,
  `item4` varchar(255) NOT NULL,
  `item5` varchar(255) NOT NULL,
  `item6` varchar(255) NOT NULL,
  `item7` varchar(255) NOT NULL,
  `item8` varchar(255) NOT NULL,
  `item9` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bingo_status`
--

CREATE TABLE `bingo_status` (
  `id` int(11) NOT NULL,
  `bingo_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `status` enum('Completed','Pending') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `customer_id`, `product_id`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `shop_id`, `product_name`, `price`, `description`, `image`) VALUES
(2, 2, 'Fries', 999, 'hi', 'documents/67cc587fea554_remove_btn.png');

-- --------------------------------------------------------

--
-- Table structure for table `product_status`
--

CREATE TABLE `product_status` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` enum('Pending','In Transit','Completed') NOT NULL DEFAULT 'Pending',
  `completion` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_status`
--

INSERT INTO `product_status` (`id`, `shop_id`, `customer_id`, `product_id`, `status`, `completion`) VALUES
(1, 2, 2, 2, 'In Transit', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `shop_address` text NOT NULL,
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL,
  `shop_category` varchar(255) NOT NULL,
  `shop_description` text NOT NULL,
  `bir_certificate` varchar(255) NOT NULL,
  `mayors_permit` varchar(255) NOT NULL,
  `dti_certificate` varchar(255) NOT NULL,
  `official_logo` varchar(255) NOT NULL,
  `bank_account` varchar(255) NOT NULL,
  `collection_receipt` varchar(255) NOT NULL,
  `is_verified` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`id`, `owner_id`, `shop_name`, `shop_address`, `opening_time`, `closing_time`, `shop_category`, `shop_description`, `bir_certificate`, `mayors_permit`, `dti_certificate`, `official_logo`, `bank_account`, `collection_receipt`, `is_verified`) VALUES
(2, 1, 'April Joy', 'Pantal', '00:00:00', '00:00:00', 'meow', 'hi', '', '', '', '', '', '', 'yes'),
(3, 1, 'Sean Perick', 'Pantal', '08:00:00', '17:00:00', 'meow', 'hi', '', '', '', '', '', '', 'yes'),
(4, 2, 'John Paul', 'Gueset', '10:00:00', '17:00:00', 'Milktea', 'meowmeowmomew', 'documents/67cc404b4b987_png.png', 'documents/67cc404b4b990_png (1).png', 'documents/67cc404b4b992_png (2).png', 'documents/67cc404b4b993_png (1).png', 'documents/67cc404b4b994_png (2).png', 'documents/67cc404b4b995_png (1).png', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `shop_owners`
--

CREATE TABLE `shop_owners` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Pending','Approved','Declined') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shop_owners`
--

INSERT INTO `shop_owners` (`id`, `email`, `password`, `status`) VALUES
(1, 'richmond@gmail.com', '$2y$10$jJbkVT90l60mGtrxmtdk0.ex/Gh87QD7QCvx4CR80C5Qg5YOZN4OK', 'Pending'),
(2, 'ohso.lopez.up@phinmaed.com', '$2y$10$hCTQshbVG69.TJQ5xitZpuhw9jscHCrMDzojbNoha.sWbE51q55xG', 'Pending'),
(3, 'ohso1.lopez.up@phinmaed.com', '$2y$10$AACh6k3T1VTjyq7io.Rw1..Hy3c0ljZbTvITrwRKldXYyfF/Cuau2', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `profile_picture`) VALUES
(1, 'paullopez@gmail.com', '$2y$10$g9VfvF3NZLxeR7kJYVrHZ.iOlHyEvQKgjCqkIHvRR8e..bb/dFopu', ''),
(2, 'jp@gmail.com', '$2y$10$6/0nZAGInkAIaPC83NlqH.zC8JvrMFRgtQUGpl3kCpuKmirvvqe4q', ''),
(3, 'richmond@gmail.com', '$2y$10$DL0UrsPNpUsPJYvtZhsWCeJK2pM3qd2Ics8zjUDRvYH7B83J70LJy', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bingo`
--
ALTER TABLE `bingo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_id` (`shop_id`);

--
-- Indexes for table `bingo_status`
--
ALTER TABLE `bingo_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bingo_status_ibfk_1` (`bingo_id`),
  ADD KEY `bingo_status_ibfk_2` (`customer_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_ibfk_1` (`shop_id`);

--
-- Indexes for table `product_status`
--
ALTER TABLE `product_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_id` (`shop_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `shop_owners`
--
ALTER TABLE `shop_owners`
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
-- AUTO_INCREMENT for table `bingo`
--
ALTER TABLE `bingo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bingo_status`
--
ALTER TABLE `bingo_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_status`
--
ALTER TABLE `product_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shop_owners`
--
ALTER TABLE `shop_owners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bingo`
--
ALTER TABLE `bingo`
  ADD CONSTRAINT `bingo_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`);

--
-- Constraints for table `bingo_status`
--
ALTER TABLE `bingo_status`
  ADD CONSTRAINT `bingo_status_ibfk_1` FOREIGN KEY (`bingo_id`) REFERENCES `bingo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bingo_status_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `menu` (`id`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_status`
--
ALTER TABLE `product_status`
  ADD CONSTRAINT `product_status_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`id`),
  ADD CONSTRAINT `product_status_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `product_status_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `menu` (`id`);

--
-- Constraints for table `shop`
--
ALTER TABLE `shop`
  ADD CONSTRAINT `shop_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `shop_owners` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
