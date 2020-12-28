-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 28, 2020 at 05:50 PM
-- Server version: 5.5.68-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs_queue`
--

CREATE TABLE IF NOT EXISTS `jobs_queue` (
  `jobId` int(11) NOT NULL,
  `submitterId` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `enteredQueue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) NOT NULL DEFAULT 'waiting',
  `lastUpdated` varchar(32) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `jobs_queue`
--

INSERT INTO `jobs_queue` (`jobId`, `submitterId`, `priority`, `name`, `enteredQueue`, `status`, `lastUpdated`) VALUES
(25, 1, 5, 'Software Engineer 1', '2020-12-25 17:43:03', 'waiting', '2020-12-28 12:48:55'),
(26, 2, 5, 'Software Engineer 2', '2020-12-25 17:43:10', 'waiting', '2020-12-28 12:48:56'),
(27, 3, 2, 'Software Engineer 3', '2020-12-25 17:43:21', 'waiting', '2020-12-28 12:48:35'),
(29, 20, 12, 'Software Engineer 5', '2020-12-25 17:43:43', 'waiting', '2020-12-28 12:48:56'),
(30, 20, 12, 'Software Engineer 4', '2020-12-25 18:41:36', 'waiting', '2020-12-28 12:48:57'),
(31, 20, 12, 'Software Engineer 4', '2020-12-25 18:53:01', 'waiting', '2020-12-25 13:53:01'),
(32, 13, 0, 'Test Engineer 2', '2020-12-28 16:11:36', 'waiting', '2020-12-28 12:48:34'),
(33, 5, 1, 'Test Engineer 5', '2020-12-28 16:50:18', 'waiting', '2020-12-28 12:48:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs_queue`
--
ALTER TABLE `jobs_queue`
  ADD PRIMARY KEY (`jobId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs_queue`
--
ALTER TABLE `jobs_queue`
  MODIFY `jobId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
