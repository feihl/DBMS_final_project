-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2023 at 04:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movies`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_new_customer` (IN `id` INT(11), IN `email` VARCHAR(255), IN `fName` VARCHAR(255), IN `mName` VARCHAR(255), IN `lName` VARCHAR(255), IN `address` VARCHAR(255), IN `contactNo` VARCHAR(255), IN `created_at` INT(255))   INSERT INTO tbl_movie_inventory_info (id, email, fName,  mName, lName, address, contactNo, created_at) VALUES(id,(SELECT MAX(id) FROM tbl_movie_inventory_info), price,qty, available, borrowed)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(11) NOT NULL,
  `migration_name` varchar(255) DEFAULT NULL,
  `migrated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration_name`, `migrated_at`) VALUES
(1, 'table1', '2023-05-20 23:37:29'),
(2, 'table2', '2023-05-20 23:37:29'),
(3, 'table3', '2023-05-20 23:37:29'),
(4, 'table4', '2023-05-20 23:37:30'),
(5, 'table5', '2023-05-20 23:37:30'),
(6, 'table6', '2023-05-20 23:37:30'),
(7, 'table7', '2023-05-20 23:37:30'),
(8, 'table8', '2023-05-20 23:37:30'),
(9, 'table9', '2023-05-20 23:37:30');

-- --------------------------------------------------------

--
-- Stand-in structure for view `movie_list`
-- (See below for the actual view)
--
CREATE TABLE `movie_list` (
`tbl_movie_genre_id` int(11)
,`description` varchar(255)
,`genreType` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'House Rental Management System', 'info@sample.comm', '+6948 8542 623', '1603344720_1602738120_pngtree-purple-hd-business-banner-image_5493.jpg', '&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-weight: 400; text-align: justify;&quot;&gt;&amp;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&rsquo;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_info`
--

CREATE TABLE `tbl_customer_info` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fName` varchar(255) DEFAULT NULL,
  `mName` varchar(255) DEFAULT NULL,
  `lName` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contactNo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer_info`
--

INSERT INTO `tbl_customer_info` (`id`, `email`, `fName`, `mName`, `lName`, `address`, `contactNo`, `created_at`) VALUES
(18, 'aflizsuazo2006@gmail.com', 'Giuseppi', 'Feihl', 'Suazo', 'Buenavista agusan del norte', '98765432', '2023-06-08 13:18:43');

--
-- Triggers `tbl_customer_info`
--
DELIMITER $$
CREATE TRIGGER `try_mee` AFTER INSERT ON `tbl_customer_info` FOR EACH ROW INSERT INTO tbl_customer_info VALUES(New.id, New.email, New.fName, New.mName, New.lName, New.address, New.contactNo, New.created_at)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_movie_about`
--

CREATE TABLE `tbl_movie_about` (
  `id` int(11) NOT NULL,
  `tbl_movie_info_id` int(11) DEFAULT NULL,
  `tbl_movie_genre_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `year_release` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_movie_about`
--

INSERT INTO `tbl_movie_about` (`id`, `tbl_movie_info_id`, `tbl_movie_genre_id`, `description`, `duration`, `year_release`, `created_at`) VALUES
(47, 158, 9, 'descrip', '123', '2222', '2023-06-10 15:23:46'),
(48, 159, 9, 'descrip', '123', '2222', '2023-06-10 15:25:38'),
(49, 160, 11, 'description', '122', '1232', '2023-06-10 15:26:41'),
(50, 161, 11, 'sddsddda', '123', '2222', '2023-06-10 15:27:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_movie_genre`
--

CREATE TABLE `tbl_movie_genre` (
  `id` int(11) NOT NULL,
  `genreType` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_movie_genre`
--

INSERT INTO `tbl_movie_genre` (`id`, `genreType`, `created_at`) VALUES
(9, 'Action comedy (action and comedy)', '2023-06-09 13:18:27'),
(10, 'Comedy drama (comedy and drama)', '2023-06-09 13:21:06'),
(11, 'Action drama (action and drama)', '2023-06-09 13:21:18'),
(12, 'Comedy-horror (comedy and horror)', '2023-06-09 13:21:47'),
(13, 'Comic fantasy (comedy and fantasy)', '2023-06-09 13:21:56'),
(14, 'Comic science fiction (comedy and science fiction)', '2023-06-09 13:22:03');

--
-- Triggers `tbl_movie_genre`
--
DELIMITER $$
CREATE TRIGGER `try` AFTER INSERT ON `tbl_movie_genre` FOR EACH ROW INSERT INTO tbl_movie_genre VALUES(New.id, New.genreType)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_movie_info`
--

CREATE TABLE `tbl_movie_info` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `cast` varchar(255) DEFAULT NULL,
  `director` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_movie_info`
--

INSERT INTO `tbl_movie_info` (`id`, `title`, `cast`, `director`, `img`, `created_at`) VALUES
(158, 'Fast x', 'vin diesel, jason mamoa. brie larson', 'director', 'Storage/150033.webp', '2023-06-10 15:23:46'),
(159, 'the black panther ', 'chadweck booseman,michael b. jordan', 'dsadda', 'Storage/black-panther-web.jpg', '2023-06-10 15:25:38'),
(160, 'captain marvel', 'brie larson', 'director', 'Storage/rs_634x939-181202195654-634.captain-marvel.12418.webp', '2023-06-10 15:26:41'),
(161, 'title ', 'cast', 'director', 'Storage/d05a3f087fa57f6d41b865d53a42a5f5.jpg', '2023-06-10 15:27:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_movie_inventory_info`
--

CREATE TABLE `tbl_movie_inventory_info` (
  `id` int(11) NOT NULL,
  `tbl_movie_info_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `available` int(11) DEFAULT NULL,
  `borrowed` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_movie_inventory_info`
--

INSERT INTO `tbl_movie_inventory_info` (`id`, `tbl_movie_info_id`, `price`, `qty`, `available`, `borrowed`, `created_at`) VALUES
(10, 158, 12, 12, 12, 0, '2023-06-10 15:23:46'),
(11, 159, 12, 12, 12, 0, '2023-06-10 15:25:38'),
(12, 160, 12, 23, 23, 0, '2023-06-10 15:26:41'),
(13, 161, 23, 15, 15, 0, '2023-06-10 15:27:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rents_info`
--

CREATE TABLE `tbl_rents_info` (
  `id` int(11) NOT NULL,
  `tbl_user_information_id` int(11) NOT NULL,
  `tbl_movie_info_id` int(11) DEFAULT NULL,
  `tbl_customer_info_id` int(11) NOT NULL,
  `genereratedCode` varchar(500) NOT NULL,
  `requestedDate` date NOT NULL,
  `returnDate` date NOT NULL,
  `requestedQty` int(11) DEFAULT NULL,
  `requestedAmount` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_rents_info`
--

INSERT INTO `tbl_rents_info` (`id`, `tbl_user_information_id`, `tbl_movie_info_id`, `tbl_customer_info_id`, `genereratedCode`, `requestedDate`, `returnDate`, `requestedQty`, `requestedAmount`, `status`, `created_at`) VALUES
(53, 34, 103, 18, 'badce7f8a1210', '2023-06-10', '2023-06-29', 2, 4, 'Return', '2023-06-10 13:59:00'),
(54, 34, 103, 18, 'ff77acc1a3248', '2023-06-10', '2023-06-08', 1, 2, 'RENTED', '2023-06-10 14:01:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_information`
--

CREATE TABLE `tbl_user_information` (
  `id` int(11) NOT NULL,
  `user_account_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fName` varchar(255) DEFAULT NULL,
  `mName` varchar(255) DEFAULT NULL,
  `lName` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contactNo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user_information`
--

INSERT INTO `tbl_user_information` (`id`, `user_account_id`, `email`, `fName`, `mName`, `lName`, `address`, `contactNo`, `created_at`) VALUES
(35, 34, 'email@email.com', 'Admin', '', '', 'Buenavista agusan del norte', '090909', '2023-06-05 14:35:47'),
(39, 38, 'email@email.com', 'cashier1', '', '', 'Buenavista agusan del norte', '090909', '2023-06-09 13:15:32');

--
-- Triggers `tbl_user_information`
--
DELIMITER $$
CREATE TRIGGER `test_why` AFTER INSERT ON `tbl_user_information` FOR EACH ROW INSERT INTO tbl_user_information VALUES(null, New.id, 
New.user_account_id, New.email,	New.fName, New.mName, New.lName, New.address, New.contactNo, New.created_at)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `access` varchar(255) DEFAULT NULL,
  `active` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`id`, `username`, `password`, `access`, `active`, `created_at`) VALUES
(34, 'admin', 'admin', '1', '1', '2023-06-05 14:35:47'),
(38, 'cashier1', '123', '2', '1', '2023-06-09 13:15:32');

-- --------------------------------------------------------

--
-- Structure for view `movie_list`
--
DROP TABLE IF EXISTS `movie_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `movie_list`  AS SELECT `tbl_movie_about`.`tbl_movie_genre_id` AS `tbl_movie_genre_id`, `tbl_movie_about`.`description` AS `description`, `tbl_movie_genre`.`genreType` AS `genreType` FROM (`tbl_movie_about` join `tbl_movie_genre` on(`tbl_movie_about`.`tbl_movie_genre_id` = `tbl_movie_genre`.`id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer_info`
--
ALTER TABLE `tbl_customer_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_movie_about`
--
ALTER TABLE `tbl_movie_about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_movie_genre`
--
ALTER TABLE `tbl_movie_genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_movie_info`
--
ALTER TABLE `tbl_movie_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_movie_inventory_info`
--
ALTER TABLE `tbl_movie_inventory_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rents_info`
--
ALTER TABLE `tbl_rents_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_information`
--
ALTER TABLE `tbl_user_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_customer_info`
--
ALTER TABLE `tbl_customer_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_movie_about`
--
ALTER TABLE `tbl_movie_about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_movie_genre`
--
ALTER TABLE `tbl_movie_genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tbl_movie_info`
--
ALTER TABLE `tbl_movie_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `tbl_movie_inventory_info`
--
ALTER TABLE `tbl_movie_inventory_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_rents_info`
--
ALTER TABLE `tbl_rents_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `tbl_user_information`
--
ALTER TABLE `tbl_user_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
