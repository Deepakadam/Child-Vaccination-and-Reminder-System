-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 30, 2025 at 07:17 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vaccination_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

DROP TABLE IF EXISTS `children`;
CREATE TABLE IF NOT EXISTS `children` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`id`, `name`, `dob`, `gender`, `parent_id`) VALUES
(12, 'ram ', '2024-03-03', 'Male', 4),
(11, 'sonu', '2021-12-02', 'Male', 4),
(9, 'ritu', '2020-05-12', 'Female', 4),
(14, 'Shabaz', '2024-06-06', 'Male', 7),
(20, 'soni', '2021-01-02', 'Female', 8),
(16, 'medha', '2024-05-12', 'Female', 5),
(18, 'ayush', '2024-07-12', 'Male', 7),
(24, 'netu', '2018-06-11', 'Female', 5),
(26, 'fiyaz', '2018-12-05', 'Male', 7),
(27, 'ridhan', '2024-08-01', 'Male', 9);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

DROP TABLE IF EXISTS `reminders`;
CREATE TABLE IF NOT EXISTS `reminders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `vaccine_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `reminder_date` date NOT NULL,
  `status` enum('Pending','Sent') DEFAULT 'Pending',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `child_id` (`child_id`),
  KEY `vaccine_id` (`vaccine_id`),
  KEY `schedule_id` (`schedule_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('parent','admin') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`) VALUES
(1, 'leo', 'leo@gmail.com', '8874596587', 'leo@123', 'admin'),
(4, 'sandy g', 'jyotibakadam99@gmail.com', '8569874582', 'sandy@123', 'parent'),
(5, 'zara ', 'zara@gmail.com', '8745875968', 'zara@123', 'parent'),
(6, 'amir', 'amir@gmail.com', '9858965874', 'amir@123', 'parent'),
(7, 'Rizwan', 'riz@gmail.com', '9900445676', '123456', 'parent'),
(8, 'paru', 'paru@gmail.com', '9875894786', 'paru@123', 'parent'),
(9, 'pooja', 'pooja@gmail.com', '8569874589', 'pooja@123', 'parent');

-- --------------------------------------------------------

--
-- Table structure for table `vaccinationschedules`
--

DROP TABLE IF EXISTS `vaccinationschedules`;
CREATE TABLE IF NOT EXISTS `vaccinationschedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_id` int(11) NOT NULL,
  `vaccine_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `scheduled_date` date NOT NULL,
  `status` enum('Scheduled','Completed') DEFAULT 'Scheduled',
  `reminder_sent` tinyint(1) DEFAULT '0',
  `administered` tinyint(1) DEFAULT '0',
  `recommended_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `child_id` (`child_id`),
  KEY `vaccine_id` (`vaccine_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vaccinationschedules`
--

INSERT INTO `vaccinationschedules` (`id`, `child_id`, `vaccine_id`, `parent_id`, `scheduled_date`, `status`, `reminder_sent`, `administered`, `recommended_date`) VALUES
(1, 11, 7, 4, '2023-01-02', 'Scheduled', 0, 0, NULL),
(2, 11, 7, 4, '2024-06-06', 'Scheduled', 0, 0, NULL),
(3, 9, 7, 4, '2025-03-16', 'Scheduled', 0, 0, NULL),
(4, 1, 1, 1, '2021-12-02', 'Scheduled', 0, 0, NULL),
(5, 1, 2, 1, '2021-12-02', 'Scheduled', 0, 0, NULL),
(6, 1, 3, 1, '2021-12-02', 'Scheduled', 0, 0, NULL),
(7, 1, 4, 1, '2022-02-02', 'Scheduled', 0, 0, NULL),
(8, 1, 5, 1, '2022-02-02', 'Scheduled', 0, 0, NULL),
(9, 1, 6, 1, '2022-02-02', 'Scheduled', 0, 0, NULL),
(10, 1, 7, 1, '2022-02-02', 'Scheduled', 0, 0, NULL),
(11, 1, 8, 1, '2022-02-02', 'Scheduled', 0, 0, NULL),
(12, 1, 9, 1, '2022-02-02', 'Scheduled', 0, 0, NULL),
(13, 1, 10, 1, '2022-03-02', 'Scheduled', 0, 0, NULL),
(14, 1, 11, 1, '2022-03-02', 'Scheduled', 0, 0, NULL),
(15, 1, 12, 1, '2022-03-02', 'Scheduled', 0, 0, NULL),
(16, 1, 13, 1, '2022-03-02', 'Scheduled', 0, 0, NULL),
(17, 1, 14, 1, '2022-03-02', 'Scheduled', 0, 0, NULL),
(18, 1, 15, 1, '2022-03-02', 'Scheduled', 0, 0, NULL),
(19, 1, 16, 1, '2022-04-02', 'Scheduled', 0, 0, NULL),
(20, 1, 17, 1, '2022-04-02', 'Scheduled', 0, 0, NULL),
(21, 1, 18, 1, '2022-04-02', 'Scheduled', 0, 0, NULL),
(22, 1, 19, 1, '2022-04-02', 'Scheduled', 0, 0, NULL),
(23, 1, 20, 1, '2022-04-02', 'Scheduled', 0, 0, NULL),
(24, 1, 21, 1, '2022-04-02', 'Scheduled', 0, 0, NULL),
(25, 1, 22, 1, '2022-06-02', 'Scheduled', 0, 0, NULL),
(26, 1, 23, 1, '2022-07-02', 'Scheduled', 0, 0, NULL),
(27, 1, 24, 1, '2022-08-02', 'Scheduled', 0, 0, NULL),
(28, 1, 25, 1, '2022-09-02', 'Scheduled', 0, 0, NULL),
(29, 1, 26, 1, '2022-12-02', 'Scheduled', 0, 0, NULL),
(30, 1, 27, 1, '2023-03-02', 'Scheduled', 0, 0, NULL),
(31, 1, 28, 1, '2023-03-02', 'Scheduled', 0, 0, NULL),
(32, 1, 29, 1, '2023-03-02', 'Scheduled', 0, 0, NULL),
(33, 1, 30, 1, '2023-05-02', 'Scheduled', 0, 0, NULL),
(34, 1, 31, 1, '2023-05-02', 'Scheduled', 0, 0, NULL),
(35, 1, 32, 1, '2023-05-02', 'Scheduled', 0, 0, NULL),
(36, 1, 33, 1, '2023-05-02', 'Scheduled', 0, 0, NULL),
(37, 1, 34, 1, '2023-12-02', 'Scheduled', 0, 0, NULL),
(38, 1, 35, 1, '2026-12-02', 'Scheduled', 0, 0, NULL),
(39, 1, 36, 1, '2026-12-02', 'Scheduled', 0, 0, NULL),
(40, 1, 37, 1, '2026-12-02', 'Scheduled', 0, 0, NULL),
(41, 1, 38, 1, '2032-12-02', 'Scheduled', 0, 0, NULL),
(42, 1, 39, 1, '2032-12-02', 'Scheduled', 0, 0, NULL),
(43, 1, 40, 1, '2037-12-02', 'Scheduled', 0, 0, NULL),
(44, 11, 7, 4, '2025-03-29', 'Scheduled', 0, 0, NULL),
(45, 9, 7, 4, '2025-03-30', 'Scheduled', 0, 0, NULL),
(46, 11, 10, 4, '2025-04-04', 'Scheduled', 0, 0, NULL),
(47, 11, 10, 4, '2025-04-04', 'Scheduled', 0, 0, NULL),
(48, 12, 25, 4, '2025-04-05', 'Completed', 0, 0, NULL),
(49, 12, 25, 4, '2025-04-05', 'Completed', 0, 0, NULL),
(50, 9, 2, 4, '2025-03-31', 'Scheduled', 0, 0, '2025-03-31'),
(51, 16, 19, 5, '2024-03-31', 'Scheduled', 0, 0, NULL),
(52, 14, 25, 7, '2025-04-04', 'Scheduled', 0, 0, NULL),
(53, 14, 25, 7, '2025-04-04', 'Scheduled', 0, 0, NULL),
(54, 11, 14, 4, '2025-04-05', 'Scheduled', 0, 0, NULL),
(55, 11, 14, 4, '2025-04-05', 'Scheduled', 0, 0, NULL),
(56, 11, 16, 4, '2025-03-31', 'Scheduled', 0, 0, NULL),
(57, 11, 15, 4, '2025-03-31', 'Scheduled', 0, 0, NULL),
(58, 11, 17, 4, '2025-03-31', 'Scheduled', 0, 0, NULL),
(59, 14, 1, 7, '2025-03-31', 'Scheduled', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vaccines`
--

DROP TABLE IF EXISTS `vaccines`;
CREATE TABLE IF NOT EXISTS `vaccines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `age_group` varchar(100) NOT NULL,
  `vaccine_name` varchar(255) NOT NULL,
  `age_in_months` int(11) NOT NULL,
  `due_days` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vaccines`
--

INSERT INTO `vaccines` (`id`, `age_group`, `vaccine_name`, `age_in_months`, `due_days`) VALUES
(1, 'Birth', 'BCG', 0, 0),
(2, 'Birth', 'OPV - O (Zero)', 0, 0),
(3, 'Birth', 'Hepatitis B - 1', 0, 0),
(4, '6 Weeks', 'DTwP - 1 / DTaP - 1', 2, 45),
(5, '6 Weeks', 'IPV - 1', 2, 45),
(6, '6 Weeks', 'Hib - 1', 2, 45),
(7, '6 Weeks', 'Hepatitis B - 2', 2, 45),
(8, '6 Weeks', 'Rotavirus - 1', 2, 45),
(9, '6 Weeks', 'PCV - 1', 2, 45),
(10, '10 Weeks', 'DTwP - 2 / DTaP - 2', 3, 75),
(11, '10 Weeks', 'IPV - 2', 3, 75),
(12, '10 Weeks', 'Hib - 2', 3, 75),
(13, '10 Weeks', 'Hepatitis B - 3', 3, 75),
(14, '10 Weeks', 'Rotavirus - 2', 3, 75),
(15, '10 Weeks', 'PCV - 2', 3, 75),
(16, '14 Weeks', 'DTwP - 3 / DTaP - 3', 4, 105),
(17, '14 Weeks', 'IPV - 3', 4, 105),
(18, '14 Weeks', 'Hib - 3', 4, 105),
(19, '14 Weeks', 'Hepatitis B - 4', 4, 105),
(20, '14 Weeks', 'Rotavirus - 3', 4, 105),
(21, '14 Weeks', 'PCV - 3', 4, 105),
(22, '6 Months', 'Influenza (IIV) - 1', 6, 180),
(23, '7 Months', 'Influenza (IIV) - 2', 7, 210),
(24, '6-9 Months', 'Typhoid conjugate', 8, 225),
(25, '9 Months', 'MMR - 1', 9, 270),
(26, '12 Months', 'Hepatitis A - 1', 12, 360),
(27, '15 Months', 'MMR - 2', 15, 450),
(28, '15 Months', 'Varicella', 15, 450),
(29, '15 Months', 'PCV Booster', 15, 450),
(30, '16-18 Months', 'DTwP/DTaP Booster - 1', 17, 510),
(31, '16-18 Months', 'Hib Booster', 17, 510),
(32, '16-18 Months', 'IPV Booster', 17, 510),
(33, '16-18 Months', 'Hepatitis A - 2', 17, 510),
(34, '2 Years', 'Typhoid Conjugate Booster', 24, 720),
(35, '4-6 Years', 'DTwP/DTaP Booster - 2', 60, 1800),
(36, '4-6 Years', 'OPV Booster', 60, 1800),
(37, '4-6 Years', 'Varicella - 2', 60, 1800),
(38, '10-12 Years', 'Tdap', 132, 3960),
(39, '10-12 Years', 'HPV (for girls, 2 doses)', 132, 3960),
(40, '16 Years', 'DT (Adult)', 192, 5760);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
