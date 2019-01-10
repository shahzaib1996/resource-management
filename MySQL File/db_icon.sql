-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2019 at 09:17 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_icon`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `aid` int(10) UNSIGNED NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `filepath` varchar(1000) DEFAULT NULL,
  `contents` varchar(60000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tab_resources`
--

CREATE TABLE `tab_resources` (
  `id` int(11) NOT NULL,
  `level` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `module` varchar(100) NOT NULL,
  `module_title` varchar(100) NOT NULL,
  `lesson` varchar(100) NOT NULL,
  `lesson_title` varchar(500) NOT NULL,
  `main_idea` varchar(2000) NOT NULL,
  `vocabulary` varchar(1000) NOT NULL,
  `key_concept` varchar(1000) NOT NULL,
  `attachments` varchar(1000) NOT NULL,
  `created_date` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_resources`
--

INSERT INTO `tab_resources` (`id`, `level`, `subject`, `course`, `module`, `module_title`, `lesson`, `lesson_title`, `main_idea`, `vocabulary`, `key_concept`, `attachments`, `created_date`) VALUES
(1, 'kindergarten', 'english', 'adad', 'ada', 'asdasd', 'asdsad', 'asdsad', 'sad', 'asdasd', 'asda', '1,', '2019-01-10 21:08:35');

-- --------------------------------------------------------

--
-- Table structure for table `tab_users`
--

CREATE TABLE `tab_users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `email` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_users`
--

INSERT INTO `tab_users` (`id`, `username`, `password`, `email`, `type`) VALUES
(1, 'iconadmin', 'admin', 'admin@iconeducate.com', '1'),
(3, 'user', 'user', 'user@user.com', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`aid`);
ALTER TABLE `attachments` ADD FULLTEXT KEY `search_index` (`contents`);

--
-- Indexes for table `tab_resources`
--
ALTER TABLE `tab_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tab_users`
--
ALTER TABLE `tab_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `aid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tab_resources`
--
ALTER TABLE `tab_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tab_users`
--
ALTER TABLE `tab_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
