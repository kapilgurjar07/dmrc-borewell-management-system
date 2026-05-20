-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2026 at 01:20 PM
-- Server version: 8.0.44
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dmrc_borewell`
--

-- --------------------------------------------------------

--
-- Table structure for table `borewell`
--

CREATE TABLE `borewell` (
  `borewell_id` int NOT NULL,
  `station` int DEFAULT NULL,
  `borewell_code` varchar(50) DEFAULT NULL,
  `num_of_borewells` int DEFAULT NULL,
  `capacity` varchar(50) DEFAULT NULL,
  `range_area` varchar(100) DEFAULT NULL,
  `distance` varchar(50) DEFAULT NULL,
  `diameter` varchar(50) DEFAULT NULL,
  `depth` varchar(50) DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `validity_years` int DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `borewell`
--

INSERT INTO `borewell` (`borewell_id`, `station`, `borewell_code`, `num_of_borewells`, `capacity`, `range_area`, `distance`, `diameter`, `depth`, `approval_date`, `validity_years`, `expiry_date`, `photo`, `created_by`, `latitude`, `longitude`, `created_at`) VALUES
(1, 1, 'BL01-BW-01', 1, '5000l', '5', '5', '5', '7', '2026-05-13', 5, '2031-05-13', 'work-2.png', 'ram', '57.576.89756', '345.897.78', '2026-05-19 17:59:41'),
(2, 1, 'BL01-BW-02', 2, '5000l', '5', '5', '5', '7', '2026-05-13', 5, '2031-05-13', '', 'ram', '57.576.89756', '345.897.78', '2026-05-20 10:17:44'),
(3, 4, 'BL02-BW-01', 2, '6000L', '5', '5', '5', '567', '2024-01-29', 2, '2026-01-29', 'logojpeg.jpeg', 'ram', '57.576.89756', '345.897.78', '2026-05-20 10:57:08');

-- --------------------------------------------------------

--
-- Table structure for table `line`
--

CREATE TABLE `line` (
  `line_id` int NOT NULL,
  `line_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `line`
--

INSERT INTO `line` (`line_id`, `line_name`) VALUES
(1, 'Blue Line'),
(2, 'Yellow Line'),
(3, 'Red Line');

-- --------------------------------------------------------

--
-- Table structure for table `station`
--

CREATE TABLE `station` (
  `station_id` int NOT NULL,
  `station_code` varchar(20) DEFAULT NULL,
  `station_name` varchar(100) DEFAULT NULL,
  `line_id` int DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `station`
--

INSERT INTO `station` (`station_id`, `station_code`, `station_name`, `line_id`, `latitude`, `longitude`, `created_at`) VALUES
(1, 'BL01', 'Rajiv Chowk', 1, NULL, NULL, '2026-05-19 16:53:49'),
(2, 'YL01', 'Kashmere Gate', 2, NULL, NULL, '2026-05-19 16:53:49'),
(4, 'BL02', 'Karol bagh', 2, '24.98.0', '45.89.0', '2026-05-20 10:22:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Admin', 'admin@gmail.com', '12345', 'admin'),
(2, 'Super Admin', 'super@dmrc.com', '12345', 'super_admin'),
(3, 'Station Admin', 'station@dmrc.com', '12345', 'admin'),
(4, 'Operator', 'operator@dmrc.com', '12345', 'operator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borewell`
--
ALTER TABLE `borewell`
  ADD PRIMARY KEY (`borewell_id`);

--
-- Indexes for table `line`
--
ALTER TABLE `line`
  ADD PRIMARY KEY (`line_id`);

--
-- Indexes for table `station`
--
ALTER TABLE `station`
  ADD PRIMARY KEY (`station_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borewell`
--
ALTER TABLE `borewell`
  MODIFY `borewell_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `line`
--
ALTER TABLE `line`
  MODIFY `line_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `station`
--
ALTER TABLE `station`
  MODIFY `station_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
