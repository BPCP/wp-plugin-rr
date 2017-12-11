-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 11, 2017 at 01:52 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bitnami_wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_rr_properties`
--

CREATE TABLE `wp_rr_properties` (
  `idx` int(20) NOT NULL,
  `user` varchar(50) NOT NULL,
  `parcel_id` int(11) NOT NULL,
  `Print_Key` varchar(30) DEFAULT NULL,
  `Address` varchar(40) DEFAULT NULL,
  `num_units` int(11) DEFAULT NULL,
  `occupied_units` int(11) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `property_manager_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_rr_properties`
--

INSERT INTO `wp_rr_properties` (`idx`, `user`, `parcel_id`, `Print_Key`, `Address`, `num_units`, `occupied_units`, `status`, `expiration_date`, `property_manager_id`) VALUES
(1, 'bphelps', 5666, '10-13-115.000', '411 Dimmick St', 4, NULL, 'Incomplete', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_rr_properties`
--
ALTER TABLE `wp_rr_properties`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `Address` (`Address`),
  ADD KEY `user` (`user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_rr_properties`
--
ALTER TABLE `wp_rr_properties`
  MODIFY `idx` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
