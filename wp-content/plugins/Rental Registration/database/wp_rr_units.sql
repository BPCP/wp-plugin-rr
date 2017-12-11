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
-- Table structure for table `wp_rr_units`
--

CREATE TABLE `wp_rr_units` (
  `idx` int(11) NOT NULL,
  `registration_id` int(11) DEFAULT NULL,
  `street_address` char(40) DEFAULT NULL,
  `unit_type` char(10) DEFAULT NULL,
  `unit_designation` char(10) DEFAULT NULL,
  `is_occupied` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_rr_units`
--

INSERT INTO `wp_rr_units` (`idx`, `registration_id`, `street_address`, `unit_type`, `unit_designation`, `is_occupied`) VALUES
(1, 1, '411 Dimmick St', 'Apartment', '2', b'0'),
(2, 1, '411 Dimmick St', 'Apartment', 'B', b'0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_rr_units`
--
ALTER TABLE `wp_rr_units`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `wp_rr_units_registration_id_idx` (`registration_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_rr_units`
--
ALTER TABLE `wp_rr_units`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
