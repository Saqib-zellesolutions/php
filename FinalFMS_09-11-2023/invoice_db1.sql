-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2023 at 05:10 PM
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
-- Database: `invoice_db1`
--
CREATE DATABASE IF NOT EXISTS `invoice_db1` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `invoice_db1`;

-- --------------------------------------------------------
--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `SID` int(11) NOT NULL,
  `INVOICE_NO` int(11) NOT NULL,
  `INVOICE_DATE` date NOT NULL,
  `CNAME` varchar(50) NOT NULL,
  `CADDRESS` varchar(150) NOT NULL,
  `CCITY` varchar(50) NOT NULL,
  `TQty` int(11) NOT NULL,
  `GRAND_TOTAL` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`SID`, `INVOICE_NO`, `INVOICE_DATE`, `CNAME`, `CADDRESS`, `CCITY`, `TQty`, `GRAND_TOTAL`) VALUES
(45, 10, '2023-11-11', 'Zubair', 'Kareem Textile', 'Saim', 0, 43875.00),
(46, 1, '2023-11-09', 'Ibraheem', 'ABC', 'Abdul', 0, 300675.00),
(47, 2, '2023-11-09', 'abc', 'def', 'ghi', 0, 2664125.00),
(48, 3, '2023-11-09', 'abc', 'def', 'ghhi', 0, 1205.00),
(49, 3, '2023-11-10', 'dg', 'sdfg', 'sdfg', 0, 109152.00),
(50, 4, '2023-11-10', 'Sohail', 'Samad Enterprises', 'Saim', 0, 4368000.00),
(51, 5, '2023-11-10', 'Sohail', 'Abbas Groups', 'Abdul Saim', 15, 129675.00),
(52, 5, '2023-11-10', 'Sohail', 'Abbas Groups', 'Abdul Saim', 15, 129675.00),
(53, 5, '2023-11-10', 'Sohail', 'Abbas Groups', 'Abdul Saim', 15, 129675.00),
(54, 5, '2023-11-10', 'Sohail', 'Abbas Groups', 'Abdul Saim', 15, 129675.00),
(55, 6, '2023-11-11', 'Abdul Saboor', 'Abc Solutions', 'Usama', 150, 27156250.00),
(56, 7, '2023-11-11', 'Abdul Rashid', 'Nexzell', 'Abdul Sami', 5, 641550.00),
(57, 7, '2023-11-11', 'Abdul Rashid', 'Nexzell', 'Abdul Sami', 5, 641550.00),
(58, 7, '2023-11-11', 'Abdul Rashid', 'Nexzell', 'Abdul Sami', 5, 641550.00),
(59, 7, '2023-11-11', 'Abdul Rashid', 'Nexzell', 'Abdul Sami', 5, 641550.00),
(60, 7, '2023-11-11', 'Abdul Rashid', 'Nexzell', 'Abdul Sami', 5, 641550.00),
(61, 7, '2023-11-11', 'Abdul Rashid', 'Nexzell', 'Abdul Sami', 5, 641550.00),
(62, 7, '2023-11-11', 'Abdul Rashid', 'Nexzell', 'Abdul Sami', 5, 641550.00),
(63, 7, '2023-11-11', 'Abdul Rashid', 'Nexzell', 'Abdul Sami', 5, 641550.00),
(64, 7, '2023-11-11', 'Abdul Rashid', 'Nexzell', 'Abdul Sami', 5, 641550.00),
(65, 7, '2023-11-11', 'Abdul Rashid', 'Nexzell', 'Abdul Sami', 5, 641550.00);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_products`
--

CREATE TABLE `invoice_products` (
  `ID` int(11) NOT NULL,
  `SID` int(11) NOT NULL,
  `PNAME` varchar(100) NOT NULL,
  `PRICE` double(10,2) NOT NULL,
  `QTY` int(11) NOT NULL,
  `TOTAL` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `invoice_products`
--

INSERT INTO `invoice_products` (`ID`, `SID`, `PNAME`, `PRICE`, `QTY`, `TOTAL`) VALUES
(90, 45, 'House Keeping', 5.00, 5, 125.00),
(91, 45, 'Rental', 25.00, 125, 43750.00),
(92, 46, 'Rental Services', 25.00, 25, 170625.00),
(93, 46, 'House Hold Service', 30.00, 15, 130050.00),
(94, 47, 'House Services', 125.00, 25, 753125.00),
(95, 47, 'Rent', 700.00, 10, 1911000.00),
(96, 48, 'abvc', 5.00, 5, 125.00),
(97, 48, 'rgh', 2.00, 36, 1080.00),
(98, 49, 'sfgsdg', 12.00, 34, 103632.00),
(99, 49, 'wererwt', 23.00, 12, 5520.00),
(100, 50, 'Rent', 700.00, 5, 955500.00),
(101, 50, 'Designing', 500.00, 25, 3412500.00),
(102, 51, 'SMM', 25.00, 5, 34125.00),
(103, 51, 'Designing', 35.00, 10, 95550.00),
(104, 52, 'SMM', 25.00, 5, 34125.00),
(105, 52, 'Designing', 35.00, 10, 95550.00),
(106, 53, 'SMM', 25.00, 5, 34125.00),
(107, 53, 'Designing', 35.00, 10, 95550.00),
(108, 54, 'SMM', 25.00, 5, 34125.00),
(109, 54, 'Designing', 35.00, 10, 95550.00),
(110, 55, 'Designing', 500.00, 25, 1562500.00),
(111, 55, 'Web Development', 750.00, 125, 25593750.00),
(112, 56, 'Backend Development Php', 500.00, 2, 273000.00),
(113, 56, 'Front End Designing', 450.00, 3, 368550.00),
(114, 57, 'Backend Development Php', 500.00, 2, 273000.00),
(115, 57, 'Front End Designing', 450.00, 3, 368550.00),
(116, 58, 'Backend Development Php', 500.00, 2, 273000.00),
(117, 58, 'Front End Designing', 450.00, 3, 368550.00),
(118, 59, 'Backend Development Php', 500.00, 2, 273000.00),
(119, 59, 'Front End Designing', 450.00, 3, 368550.00),
(120, 60, 'Backend Development Php', 500.00, 2, 273000.00),
(121, 60, 'Front End Designing', 450.00, 3, 368550.00),
(122, 61, 'Backend Development Php', 500.00, 2, 273000.00),
(123, 61, 'Front End Designing', 450.00, 3, 368550.00),
(124, 62, 'Backend Development Php', 500.00, 2, 273000.00),
(125, 62, 'Front End Designing', 450.00, 3, 368550.00),
(126, 63, 'Backend Development Php', 500.00, 2, 273000.00),
(127, 63, 'Front End Designing', 450.00, 3, 368550.00),
(128, 64, 'Backend Development Php', 500.00, 2, 273000.00),
(129, 64, 'Front End Designing', 450.00, 3, 368550.00),
(130, 65, 'Backend Development Php', 500.00, 2, 273000.00),
(131, 65, 'Front End Designing', 450.00, 3, 368550.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`SID`);

--
-- Indexes for table `invoice_products`
--
ALTER TABLE `invoice_products`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `SID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `invoice_products`
--
ALTER TABLE `invoice_products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
