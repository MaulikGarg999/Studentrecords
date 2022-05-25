-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2022 at 08:57 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student`
--

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Stu_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `DoB` date DEFAULT NULL,
  `class` int(11) DEFAULT NULL,
  `fees` int(11) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `contact` varchar(10) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Stu_id`, `name`, `DoB`, `class`, `fees`, `email`, `contact`, `address`) VALUES
(1, 'Ravi', '2010-08-01', 12, 1200, 'Ravi1234@gmail.com', '9045121234', 'Meerut City'),
(2, 'Rohit', '2007-05-09', 10, 1100, 'Rohit@gmail.com', '8524747410', 'Meerut'),
(3, 'Mukesh', '2002-02-07', 10, 1000, 'Mukesh@gmail.com', '8996332254', 'Meerut City'),
(4, 'Aakash Singhal', '2006-04-09', 10, 1200, 'Aakash@gmail.com', '7418529638', 'Noida'),
(5, 'Veer', '2002-03-09', 10, 1000, 'Veer@gmail.com', '7899658248', 'Mawana'),
(6, 'Naman', '2007-08-12', 10, 1000, 'Naman@gmail.com', '1234567890', 'Noida City'),
(7, 'Arjun', '2009-10-20', 7, 900, 'Arjun@gmail.com', '9897456452', 'Sardhana'),
(8, 'Rishabh', '2008-08-12', 10, 1000, 'Rishabh@gmail.com', '9897121156', 'Delhi'),
(9, 'Nishant', '2006-01-30', 10, 1000, 'Nishant@gmail.com', '8856789930', 'Noida City'),
(10, 'Mayank', '2005-06-03', 12, 1200, 'Mayank@gmail.com', '8879668512', 'Delhi'),
(11, 'Prateek', '2007-12-23', 11, 1100, 'Prateek@gmail.com', '7897990081', 'Delhi'),
(12, 'Ravi kumar', '2007-07-23', 10, 1000, 'RaviKumar@gmail.com', '9087667788', 'Meerut City'),
(13, 'Pankaj', '2005-07-11', 12, 1200, 'pankaj@gmail.com', '9087564567', 'New delhi'),
(14, 'Vaibhav', '2007-12-08', 11, 1100, 'Vaibhav@gmail.com', '9027409275', 'Delhi'),
(15, 'Maulik', '2007-12-23', 10, 1200, 'Maulik@gmail.com', '8630494563', 'Meerut'),
(16, 'Akshay Saini', '2008-09-17', 12, 1200, 'AkshaySainiJi@gmail.com', '8990899078', 'Meerut City'),
(17, 'deepak', '1995-01-15', 12, 1200, 'deepakrajvanshi@gmail.com', '8998795645', 'Sabun Godam'),
(18, 'Deepanshu', '2007-12-12', 11, 1100, 'deepanshu@gmail.com', '9045121234', 'Meerut');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Stu_id`),
  ADD UNIQUE KEY `email` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
