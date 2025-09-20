-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 31, 2025 at 03:01 PM
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
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`id`, `name`, `dob`, `gender`, `parent_id`) VALUES
(16, 'medha', '2024-05-12', 'Female', 5),
(24, 'netu', '2018-06-11', 'Female', 5),
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
  PRIMARY KEY (`id`),
  KEY `child_id` (`child_id`),
  KEY `vaccine_id` (`vaccine_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vaccinationschedules`
--

INSERT INTO `vaccinationschedules` (`id`, `child_id`, `vaccine_id`, `parent_id`, `scheduled_date`, `status`, `reminder_sent`) VALUES
(57, 11, 15, 4, '2025-03-31', 'Scheduled', 0),
(58, 11, 17, 4, '2025-03-31', 'Scheduled', 0),
(59, 14, 1, 7, '2025-03-31', 'Completed', 1),
(60, 12, 13, 4, '2025-04-05', 'Completed', 1),
(74, 20, 35, 8, '2025-04-08', 'Scheduled', 0),
(62, 14, 3, 7, '2025-04-05', 'Scheduled', 0),
(65, 12, 19, 4, '2025-04-12', 'Scheduled', 0),
(66, 18, 19, 7, '2025-04-08', 'Scheduled', 0),
(67, 20, 1, 8, '2025-04-01', 'Scheduled', 0),
(68, 11, 24, 4, '2025-04-05', 'Scheduled', 0),
(75, 16, 26, 5, '2025-04-05', 'Scheduled', 0),
(73, 14, 26, 7, '2025-04-05', 'Completed', 1);

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
