-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2025 at 10:22 PM
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
-- Database: `carbdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aid`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `bid` int(11) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `phone` double NOT NULL,
  `email` varchar(50) NOT NULL,
  `sdate` date NOT NULL,
  `dtime` varchar(5) NOT NULL,
  `vehicle` varchar(50) NOT NULL,
  `vehiclenum` varchar(15) NOT NULL,
  `services` text NOT NULL,
  `comments` text NOT NULL,
  `status` varchar(7) NOT NULL,
  `repair_comment` varchar(30) NOT NULL,
  `mechanic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive`
--

INSERT INTO `archive` (`bid`, `mname`, `phone`, `email`, `sdate`, `dtime`, `vehicle`, `vehiclenum`, `services`, `comments`, `status`, `repair_comment`, `mechanic_id`) VALUES
(40, 'ben', 741465656, 'ben@gmail.com', '2025-03-31', '9 AM', 'toyota vitz', 'y', 'Basic Servicing', '', 'Repaire', 'reapierd', 30);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `bid` int(11) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `phone` double NOT NULL,
  `email` varchar(50) NOT NULL,
  `sdate` date NOT NULL,
  `dtime` varchar(5) NOT NULL,
  `vehicle` varchar(50) NOT NULL,
  `vehiclenum` varchar(15) NOT NULL,
  `services` text NOT NULL,
  `comments` text NOT NULL,
  `status` varchar(7) NOT NULL DEFAULT 'Pending',
  `mechanic_id` int(11) NOT NULL DEFAULT 0,
  `repair_comment` varchar(30) NOT NULL,
  `mechanic_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`bid`, `mname`, `phone`, `email`, `sdate`, `dtime`, `vehicle`, `vehiclenum`, `services`, `comments`, `status`, `mechanic_id`, `repair_comment`, `mechanic_name`) VALUES
(41, 'ben', 741465656, 'ben@gmail.com', '2025-03-31', '9 AM', 'range rover range rover', 'htht', 'Full Servicing', '', 'Active', 29, 'done', 'Benjamin Maosa Mosweta'),
(42, 'ben', 741465656, 'ben@gmail.com', '2025-04-01', '4 PM', 'toyota CROWN', 'kdd', 'Full Servicing', 'noice', 'Pending', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cancellations`
--

CREATE TABLE `cancellations` (
  `bid` int(11) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `phone` double NOT NULL,
  `email` varchar(50) NOT NULL,
  `sdate` date NOT NULL,
  `dtime` varchar(5) NOT NULL,
  `vehicle` varchar(50) NOT NULL,
  `vehiclenum` varchar(15) NOT NULL,
  `services` text NOT NULL,
  `comments` text NOT NULL,
  `status` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cancellations`
--

INSERT INTO `cancellations` (`bid`, `mname`, `phone`, `email`, `sdate`, `dtime`, `vehicle`, `vehiclenum`, `services`, `comments`, `status`) VALUES
(5, 'abu', 798458270, 'abuga@gmail.com', '2024-04-18', '11 AM', 'toyota vitz', 'kcc9', 'Full Servicing', '', 0),
(12, 'k', 203312147, 'k@gmail.com', '2024-04-18', '9 AM', 'toyota CROWN', 'kcc9', 'Front Brake', '', 0),
(13, 'admin', 712204176, 'admin@gmail.com', '2024-04-21', '9 AM', 'toyota vitztoyota', 'KCB2563', 'Front Brake', '', 0),
(19, 'admin', 0, 'admin@gmail.com', '2024-04-29', '2 PM', 'toyota CROWN', '1', 'Full Servicing', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `eid` int(11) NOT NULL,
  `ename` varchar(50) NOT NULL,
  `ephone` double NOT NULL,
  `epassword` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`eid`, `ename`, `ephone`, `epassword`) VALUES
(1, 'admin', 712204179, 'admin'),
(3, 'Benson', 798458270, 'ben'),
(4, 'admin', 712202475, 'admin'),
(5, 'admin', 0, 'admin'),
(6, 'admin', 0, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `mechanic`
--

CREATE TABLE `mechanic` (
  `id` int(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `address` int(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mechanic`
--

INSERT INTO `mechanic` (`id`, `name`, `email`, `address`, `password`) VALUES
(29, 'Benjamin Maosa Mosweta', 'admin@admin.com', 6566, 'admin123'),
(30, 'john', 'john@gmail.com', 6566, 'john');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `mid` int(11) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` double NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`mid`, `mname`, `email`, `phone`, `password`) VALUES
(26, 'ben', 'ben@gmail.com', 741465656, 'cad682baddcbd9afdf9170f6de3fcb6e');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `rid` int(11) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` double NOT NULL,
  `rcontent` text NOT NULL,
  `rdate` varchar(10) NOT NULL,
  `score` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`rid`, `mname`, `email`, `phone`, `rcontent`, `rdate`, `score`) VALUES
(1, 'John ', 'john@gmail.com', 798458270, 'ju', '2024-04-18', NULL),
(2, 'Benjamin Maosa Mosweta', 'benjaminmosweta@gmail.com', 712204176, 'great', '2024-04-18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vid` int(11) NOT NULL,
  `vmake` varchar(15) NOT NULL,
  `vmodel` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vid`, `vmake`, `vmodel`) VALUES
(48, 'toyota', 'vitz'),
(50, 'toyota', 'CROWN'),
(52, 'range rover', 'range rover');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `cancellations`
--
ALTER TABLE `cancellations`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`eid`);

--
-- Indexes for table `mechanic`
--
ALTER TABLE `mechanic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mechanic`
--
ALTER TABLE `mechanic`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
