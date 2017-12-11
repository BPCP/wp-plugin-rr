-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 11, 2017 at 01:51 PM
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
-- Table structure for table `wp_rr_owners`
--

CREATE TABLE `wp_rr_owners` (
  `idx` int(20) NOT NULL,
  `Owner Name` varchar(100) NOT NULL,
  `Address Line` varchar(100) NOT NULL,
  `City` varchar(30) NOT NULL,
  `State` varchar(2) NOT NULL,
  `Zip` varchar(12) NOT NULL,
  `Registration_ID` int(11) NOT NULL,
  `Signature` char(40) DEFAULT NULL,
  `signature_timestamp` datetime DEFAULT NULL,
  `is_applicant` bit(1) DEFAULT NULL,
  `title` char(20) DEFAULT NULL,
  `type` char(10) DEFAULT 'Individual',
  `phone_number` char(20) DEFAULT NULL,
  `e_mail_address` char(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_rr_owners`
--

INSERT INTO `wp_rr_owners` (`idx`, `Owner Name`, `Address Line`, `City`, `State`, `Zip`, `Registration_ID`, `Signature`, `signature_timestamp`, `is_applicant`, `title`, `type`, `phone_number`, `e_mail_address`) VALUES
(1, 'Brian S Phelps', '411 Dimmick St', 'Watertown', 'Fl', '13601', 1, 'Brian S Phelps', '2017-12-09 18:05:47', NULL, NULL, 'Individual', '3157735128', 'brian@racog.org'),
(2, 'Jennifer L Phelps', '411 Dimmick St', 'Watertown', 'NY', '13601', 1, 'Jenn', '2017-12-09 19:38:51', NULL, NULL, 'Individual', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_rr_owners`
--
ALTER TABLE `wp_rr_owners`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `Registration_ID` (`Registration_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_rr_owners`
--
ALTER TABLE `wp_rr_owners`
  MODIFY `idx` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
