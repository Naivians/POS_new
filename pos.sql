-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql312.byetcluster.com
-- Generation Time: Jan 01, 2023 at 08:51 AM
-- Server version: 10.3.27-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_32714703_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(10) NOT NULL,
  `date_added` varchar(50) NOT NULL,
  `date_edited` varchar(50) NOT NULL,
  `date_retrieved` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `fullname`, `username`, `password`, `role`, `date_added`, `date_edited`, `date_retrieved`) VALUES
(54, 'Marvin Madera', 'naiv@05', 'naiv@kelly05', 'admin', '2022/09/19', '2022/12/01', '2022/09/26'),
(55, 'Cherry Guinoo', 'cherry@05', 'Cherryaguinoo@05', 'admin', '2022/09/25', '', '2022/09/26'),
(56, 'Hervi', 'mcps@05', '@mcpsJesus', 'user', '2022/09/25', '2022/10/03', '2022/09/26');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `date_added` varchar(50) NOT NULL,
  `date_edited` varchar(50) NOT NULL,
  `date_retrieved` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`, `date_added`, `date_edited`, `date_retrieved`) VALUES
(1, 'print', '2022/09/25', '2022/09/25', ''),
(2, 'Xerox', '2022/09/25', '', ''),
(3, 'Laminate', '2022/09/25', '', ''),
(4, 'scan', '2022/09/25', '', ''),
(5, 'photo', '2022/09/25', '2022/10/01', ''),
(10, 'Mug', '2022/10/01', '2022/10/01', ''),
(11, 'sticker', '2022/10/06', '', ''),
(12, 'toppers', '2022/10/08', '', ''),
(13, 'TCR', '2022/10/26', '', ''),
(15, 'Brilliant', '2022/12/01', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_account`
--

CREATE TABLE `deleted_account` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(10) NOT NULL,
  `date_added` varchar(50) NOT NULL,
  `deleted_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deleted_account`
--

INSERT INTO `deleted_account` (`id`, `fullname`, `username`, `password`, `role`, `date_added`, `deleted_date`) VALUES
(39, 'sample', 'sample', '111111', 'user', '2022/10/31', '2022/10/31');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `pName` varchar(50) NOT NULL,
  `pPrice` varchar(50) NOT NULL,
  `pQTY` varchar(50) NOT NULL,
  `subtotal` varchar(50) NOT NULL,
  `date_added` varchar(50) NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `date_paid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `category`, `pName`, `pPrice`, `pQTY`, `subtotal`, `date_added`, `order_status`, `date_paid`) VALUES
(1, 'print', 'Black and White', '3.00', '2', '6', '2022/12/01', 'paid', '2022/12/01'),
(2, 'Brilliant', 'Brialliant Whitening', '250.00', '1', '250', '2022/12/01', 'paid', '2022/12/01'),
(3, 'print', 'Colored Image', '8.00', '1', '8', '2022/12/02', 'paid', '2022/12/02'),
(4, 'Mug', 'White Mug (W-10pcs)', '75.00', '10', '750', '2022/12/02', 'paid', '2022/12/02'),
(5, 'print', 'Colored Image', '8.00', '1', '8', '2022/12/02', 'paid', '2022/12/02'),
(6, 'print', 'Colored Text', '4.00', '1', '4', '2022/12/02', 'paid', '2022/12/02'),
(7, 'print', 'Black and White', '3.00', '4', '12', '2022/12/02', 'paid', '2022/12/02'),
(8, 'print', 'Colored Text', '4.00', '1', '4', '2022/12/02', 'paid', '2022/12/02'),
(9, 'toppers', 'toppers (no edit)', '15.00', '2', '30', '2022/12/03', 'paid', '2022/12/03'),
(10, 'Mug', 'White Mug (W-10pcs)', '75.00', '13', '975', '2022/12/03', 'paid', '2022/12/03'),
(11, 'photo', 'wallet size', '5.00', '5', '25', '2022/12/03', 'paid', '2022/12/03'),
(12, 'print', 'Colored Text', '4.00', '1', '4', '2022/12/03', 'paid', '2022/12/03'),
(13, 'Xerox', 'Colored Image', '3.00', '2', '6', '2022/12/03', 'paid', '2022/12/03'),
(14, 'Mug', 'White Mug (R)', '80.00', '2', '160', '2022/12/03', 'paid', '2022/12/03'),
(15, 'Xerox', 'Colored Image', '3.00', '30', '90', '2022/12/03', 'paid', '2022/12/03'),
(16, 'Mug', 'Magic Mug (wholesale)', '120.00', '1', '120', '2022/12/03', 'paid', '2022/12/03'),
(17, 'Mug', 'White Mug (W-20pcs)', '70.00', '4', '280', '2022/12/03', 'paid', '2022/12/03'),
(18, 'Mug', 'White Mug (R)', '80.00', '3', '240', '2022/12/03', 'paid', '2022/12/03'),
(19, 'Xerox', 'Colored Image', '3.00', '1', '3', '2022/12/04', 'paid', '2022/12/04'),
(20, 'print', 'Colored Image', '8.00', '3', '24', '2022/12/04', 'paid', '2022/12/04'),
(21, 'print', 'Colored Image', '8.00', '1', '8', '2022/12/04', 'paid', '2022/12/04'),
(22, 'TCR', 'ID-BIG', '30.00', '1', '30', '2022/12/04', 'paid', '2022/12/04'),
(23, 'Laminate', '4R size', '25.00', '1', '25', '2022/12/04', 'paid', '2022/12/04'),
(24, 'TCR', 'ID-BIG', '30.00', '1', '30', '2022/12/05', 'paid', '2022/12/05'),
(25, 'Xerox', 'Colored Image', '3.00', '1', '3', '2022/12/05', 'paid', '2022/12/05'),
(26, 'print', 'Black and White', '3.00', '3', '9', '2022/12/05', 'paid', '2022/12/05'),
(27, 'Mug', 'White Mug (W-20pcs)', '70.00', '35', '2450', '2022/12/06', 'paid', '2022/12/06'),
(28, 'print', 'Black and White', '3.00', '1', '3', '2022/12/06', 'paid', '2022/12/06'),
(29, 'Mug', 'White Mug (W-10pcs)', '75.00', '10', '750', '2022/12/07', 'paid', '2022/12/07'),
(30, 'sticker', 'Sticker (R)', '30.00', '1', '30', '2022/12/07', 'paid', '2022/12/07'),
(31, 'Xerox', 'Colored Image', '3.00', '1', '3', '2022/12/07', 'paid', '2022/12/07'),
(32, 'print', 'Black and White', '3.00', '10', '30', '2022/12/08', 'paid', '2022/12/08'),
(33, 'print', 'Colored Text', '4.00', '24', '96', '2022/12/08', 'paid', '2022/12/08'),
(34, 'print', 'Black and White', '3.00', '1', '3', '2022/12/08', 'paid', '2022/12/08'),
(35, 'Xerox', 'Colored Image', '3.00', '30', '90', '2022/12/08', 'paid', '2022/12/08'),
(36, 'sticker', 'Sticker (W)', '25.00', '6', '150', '2022/12/08', 'paid', '2022/12/08'),
(37, 'Mug', 'White Mug (W-20pcs)', '70.00', '8', '560', '2022/12/08', 'paid', '2022/12/08'),
(38, 'Mug', 'Magic Mug (wholesale)', '120.00', '5', '600', '2022/12/08', 'paid', '2022/12/08'),
(39, 'print', 'Black and White', '3.00', '1', '3', '2022/12/08', 'paid', '2022/12/08'),
(41, 'Mug', 'White Mug (W-10pcs)', '75.00', '17', '1275', '2022/12/10', 'paid', '2022/12/10'),
(42, 'Mug', 'White Mug (R)', '80.00', '2', '160', '2022/12/10', 'paid', '2022/12/10'),
(43, 'print', 'Black and White', '3.00', '1', '3', '2022/12/10', 'paid', '2022/12/10'),
(44, 'Mug', 'White Mug (R)', '80.00', '2', '160', '2022/12/10', 'paid', '2022/12/10'),
(45, 'Mug', 'White Mug (R)', '80.00', '4', '320', '2022/12/10', 'paid', '2022/12/10'),
(46, 'Laminate', 'wallet size', '10.00', '1', '10', '2022/12/10', 'paid', '2022/12/10'),
(47, 'print', 'Black and White', '3.00', '4', '12', '2022/12/10', 'paid', '2022/12/10'),
(48, 'Brilliant', 'Brialliant Rejuv', '210', '1', '210', '2022/12/10', 'paid', '2022/12/10'),
(49, 'Brilliant', 'Brialliant Whitening', '250.00', '2', '500', '2022/12/10', 'paid', '2022/12/10'),
(50, 'Mug', 'White Mug (W-10pcs)', '75.00', '15', '1125', '2022/12/10', 'paid', '2022/12/10'),
(51, 'Mug', 'Magic Mug (retail)', '135.00', '1', '135', '2022/12/10', 'paid', '2022/12/10'),
(52, 'print', 'Black and White', '3.00', '2', '6', '2022/12/10', 'paid', '2022/12/10'),
(53, 'print', 'Colored Text', '4.00', '2', '8', '2022/12/10', 'paid', '2022/12/10'),
(54, 'Mug', 'Magic Mug (retail)', '140.00', '1', '140', '2022/12/11', 'paid', '2022/12/11'),
(55, 'Brilliant', 'Brialliant Whitening', '250.00', '1', '250', '2022/12/11', 'paid', '2022/12/11'),
(56, 'Mug', 'White Mug (R)', '80.00', '1', '80', '2022/12/11', 'paid', '2022/12/11'),
(57, 'Mug', 'White Mug Only', '30.00', '3', '90', '2022/12/11', 'paid', '2022/12/11'),
(58, 'Mug', 'Mug Box Only', '5.00', '2', '10', '2022/12/11', 'paid', '2022/12/11'),
(59, 'print', 'Black and White', '3.00', '2', '6', '2022/12/11', 'paid', '2022/12/11'),
(60, 'print', 'Black and White', '3.00', '9', '27', '2022/12/11', 'paid', '2022/12/11'),
(61, 'print', 'Colored Image', '8.00', '1', '8', '2022/12/11', 'paid', '2022/12/11'),
(62, 'print', 'Black and White', '3.00', '1', '3', '2022/12/11', 'paid', '2022/12/11'),
(63, 'print', 'Colored Text', '4.00', '1', '4', '2022/12/11', 'paid', '2022/12/11'),
(64, 'Xerox', 'Black & White', '2.00', '5', '10', '2022/12/11', 'paid', '2022/12/11'),
(65, 'print', 'Black and White', '3.00', '2', '6', '2022/12/11', 'paid', '2022/12/11'),
(66, 'Xerox', 'Black & White', '2.00', '8', '16', '2022/12/12', 'paid', '2022/12/12'),
(67, 'photo', 'pkg 2', '25.00', '1', '25', '2022/12/12', 'paid', '2022/12/12'),
(68, 'Laminate', '3R size', '15.00', '1', '15', '2022/12/12', 'paid', '2022/12/12'),
(69, 'print', 'Black and White', '3.00', '1', '3', '2022/12/13', 'paid', '2022/12/13'),
(70, 'print', 'Colored Text', '4.00', '1', '4', '2022/12/13', 'paid', '2022/12/13'),
(71, 'Mug', 'White Mug (Min. of 100pcs)', '73.00', '100', '7300', '2022/12/13', 'paid', '2022/12/13'),
(72, 'sticker', 'Sticker (R)', '30.00', '1', '30', '2022/12/13', 'paid', '2022/12/13'),
(73, 'print', 'Colored Image', '8.00', '1', '8', '2022/12/12', 'paid', '2022/12/12'),
(74, 'print', 'Black and White', '3.00', '8', '24', '2022/12/13', 'paid', '2022/12/13'),
(75, 'print', 'Colored Text', '4.00', '7', '28', '2022/12/13', 'paid', '2022/12/13'),
(76, 'print', 'Black and White', '3.00', '2', '6', '2022/12/13', 'paid', '2022/12/13'),
(77, 'print', 'Black and White', '3.00', '2', '6', '2022/12/13', 'paid', '2022/12/13'),
(78, 'print', 'Colored Image', '8.00', '1', '8', '2022/12/13', 'paid', '2022/12/13'),
(79, 'Mug', 'White Mug (R)', '80.00', '1', '80', '2022/12/13', 'paid', '2022/12/13'),
(80, 'Mug', 'White Mug (R)', '80.00', '2', '160', '2022/12/13', 'paid', '2022/12/13'),
(81, 'Mug', 'Magic Mug (retail)', '140.00', '1', '140', '2022/12/13', 'paid', '2022/12/13'),
(82, 'photo', 'pkg 2', '25.00', '3', '75', '2022/12/14', 'paid', '2022/12/14'),
(83, 'print', 'Black and White', '3.00', '5', '15', '2022/12/14', 'paid', '2022/12/14'),
(84, 'print', 'Colored Image', '8.00', '2', '16', '2022/12/14', 'paid', '2022/12/14'),
(85, 'print', 'Colored Text', '4.00', '2', '8', '2022/12/14', 'paid', '2022/12/14'),
(86, 'Mug', 'White Mug (W-10pcs)', '75.00', '20', '1500', '2022/12/14', 'paid', '2022/12/14'),
(87, 'Mug', 'Magic Mug (Wholesale)', '135.00', '1', '135', '2022/12/14', 'paid', '2022/12/14'),
(88, 'Mug', 'Magic Mug (retail)', '140.00', '1', '140', '2022/12/14', 'paid', '2022/12/14'),
(89, 'Mug', 'Magic Mug (Wholesale)', '135.00', '15', '2025', '2022/12/14', 'paid', '2022/12/14'),
(90, 'photo', '8R', '20.00', '2', '40', '2022/12/15', 'paid', '2022/12/15'),
(91, 'Mug', 'White Mug (W-20pcs)', '70.00', '14', '980', '2022/12/15', 'paid', '2022/12/15'),
(92, 'Mug', 'Magic Mug (retail)', '140.00', '2', '280', '2022/12/15', 'paid', '2022/12/15'),
(93, 'Laminate', 'wallet size', '10.00', '1', '10', '2022/12/16', 'paid', '2022/12/16'),
(94, 'photo', 'pkg 2', '25.00', '1', '25', '2022/12/16', 'paid', '2022/12/16'),
(95, 'photo', 'wallet size', '5.00', '2', '10', '2022/12/16', 'paid', '2022/12/16'),
(96, 'Mug', 'White Mug (W-10pcs)', '75.00', '220', '16500', '2022/12/16', 'paid', '2022/12/16'),
(97, 'print', 'Black and White', '3.00', '22', '66', '2022/12/18', 'paid', '2022/12/18'),
(98, 'print', 'Colored Text', '4.00', '1', '4', '2022/12/18', 'paid', '2022/12/18'),
(99, 'Laminate', 'wallet size', '10.00', '2', '20', '2022/12/17', 'paid', '2022/12/17'),
(100, 'Mug', 'Magic Mug (retail)', '140.00', '2', '280', '2022/12/17', 'paid', '2022/12/17'),
(101, 'Mug', 'Magic Mug (retail)', '140.00', '4', '560', '2022/12/17', 'paid', '2022/12/17'),
(102, 'Mug', 'White Mug (old price)', '60.00', '19', '1140', '2022/12/17', 'paid', '2022/12/17'),
(103, 'Brilliant', 'Kayakukayamu Soap', '28.00', '1', '28', '2022/12/18', 'paid', '2022/12/18'),
(104, 'Mug', 'Magic Mug (Wholesale)', '135.00', '3', '405', '2022/12/19', 'paid', '2022/12/19'),
(105, 'Mug', 'Magic Mug (retail)', '140.00', '2', '280', '2022/12/20', 'paid', '2022/12/20'),
(106, 'Mug', 'White Mug (W-10pcs)', '75.00', '17', '1275', '2022/12/18', 'paid', '2022/12/18'),
(108, 'Mug', 'White Mug (R)', '80.00', '8', '640', '2022/12/21', 'paid', '2022/12/21'),
(109, 'Laminate', 'wallet size', '10.00', '2', '20', '2022/12/21', 'paid', '2022/12/21'),
(110, 'Xerox', 'Black & White', '2.00', '2', '4', '2022/12/21', 'paid', '2022/12/21'),
(111, 'Xerox', 'Colored Image', '3.00', '2', '6', '2022/12/21', 'paid', '2022/12/21'),
(112, 'Brilliant', 'Brialliant Whitening', '250.00', '1', '250', '2022/12/20', 'paid', '2022/12/20'),
(114, 'Mug', 'Magic Mug (retail)', '120.00', '2', '240', '2022/12/22', 'paid', '2022/12/22'),
(115, 'Mug', 'White Mug (R)', '80.00', '4', '320', '2022/12/22', 'paid', '2022/12/22'),
(116, 'Mug', 'White Mug (W-20pcs)', '70.00', '100', '7000', '2022/12/24', 'paid', '2022/12/24'),
(117, 'Mug', 'White Mug (R)', '80.00', '11', '880', '2022/12/24', 'paid', '2022/12/24'),
(118, 'Mug', 'White Mug (W-10pcs)', '75.00', '10', '750', '2022/12/24', 'paid', '2022/12/24'),
(119, 'Mug', 'White Mug (R)', '80.00', '7', '560', '2022/12/24', 'paid', '2022/12/24'),
(120, 'Mug', 'Magic Mug (retail)', '140.00', '1', '140', '2022/12/24', 'paid', '2022/12/24'),
(121, 'Mug', 'White Mug (W-10pcs)', '75.00', '12', '900', '2022/12/24', 'paid', '2022/12/24'),
(122, 'Mug', 'White Mug (Min. of 100pcs)', '73.00', '40', '2920', '2022/12/24', 'paid', '2022/12/24'),
(123, 'Mug', 'White Mug (W-20pcs)', '70.00', '5', '350', '2022/12/24', 'paid', '2022/12/24'),
(124, 'Brilliant', 'Brialliant Whitening', '250.00', '1', '250', '2022/12/24', 'paid', '2022/12/24'),
(125, 'Mug', 'White Mug (R)', '80.00', '3', '240', '2022/12/24', 'paid', '2022/12/24'),
(126, 'Mug', 'Magic Mug (retail)', '140.00', '1', '140', '2022/12/26', 'paid', '2022/12/26'),
(127, 'Mug', 'White Mug (R)', '80.00', '2', '160', '2022/12/26', 'paid', '2022/12/26'),
(128, 'Mug', 'Magic Mug (Reseller)', '120.00', '4', '480', '2022/12/26', 'paid', '2022/12/26'),
(129, 'Mug', 'White Mug (W-20pcs)', '70.00', '23', '1610', '2022/12/26', 'paid', '2022/12/26'),
(130, 'Brilliant', 'Brialliant Rejuv', '210', '1', '210', '2022/12/26', 'paid', '2022/12/26'),
(131, 'Mug', 'White Mug (R)', '80.00', '1', '80', '2022/12/26', 'paid', '2022/12/26'),
(132, 'Mug', 'White Mug (W-10pcs)', '75.00', '50', '3750', '2022/12/27', 'paid', '2022/12/27'),
(133, 'Mug', 'White Mug (W-10pcs)', '75.00', '29', '2175', '2022/12/28', 'paid', '2022/12/28'),
(134, 'Mug', 'White Mug (W-10pcs)', '75.00', '13', '975', '2022/12/28', 'paid', '2022/12/28'),
(135, 'Mug', 'White Mug (R)', '80.00', '3', '240', '2022/12/28', 'paid', '2022/12/28'),
(136, 'Mug', 'White Mug (W-10pcs)', '80.00', '10', '800', '2022/12/29', 'paid', '2022/12/29'),
(137, 'Mug', 'Magic Mug (retail)', '140.00', '5', '700', '2022/12/29', 'paid', '2022/12/29'),
(138, 'Mug', 'White Mug (W-10pcs)', '75.00', '37', '2775', '2022/12/30', 'paid', '2022/12/30'),
(139, 'Mug', 'White Mug (W-20pcs)', '70.00', '2', '140', '2022/12/30', 'paid', '2022/12/30'),
(140, 'Mug', 'White Mug (W-20pcs)', '70.00', '1', '70', '2022/12/28', 'paid', '2022/12/28'),
(141, 'photo', 'wallet size', '5.00', '2', '10', '2022/12/29', 'paid', '2022/12/29'),
(142, 'Brilliant', 'MVE', '150.00', '3', '450', '2022/12/29', 'paid', '2022/12/29'),
(143, 'Mug', 'Magic Mug (retail)', '140.00', '1', '140', '2022/12/24', 'paid', '2022/12/24'),
(144, 'Mug', 'White Mug (W-20pcs)', '70.00', '3', '210', '2022/12/24', 'paid', '2022/12/24'),
(145, 'Mug', 'White Mug (R)', '80.00', '1', '80', '2022/12/24', 'paid', '2022/12/24'),
(146, 'Mug', 'White Mug (R)', '80.00', '5', '400', '2023/01/01', 'paid', '2023/01/01'),
(147, 'Mug', 'White Mug (W-20pcs)', '70.00', '5', '350', '2023/01/01', 'paid', '2023/01/01'),
(148, 'Mug', 'Magic Mug (Reseller)', '120.00', '2', '240', '2023/01/01', 'paid', '2023/01/01');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(10) NOT NULL,
  `category` varchar(50) NOT NULL,
  `prodName` varchar(50) NOT NULL,
  `prodPrice` varchar(50) NOT NULL,
  `date_added` varchar(50) NOT NULL,
  `date_edited` varchar(50) NOT NULL,
  `date_retrieved` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category`, `prodName`, `prodPrice`, `date_added`, `date_edited`, `date_retrieved`) VALUES
(3, 'print', 'Black and White', '3.00', '2022/09/26', '2022/12/01', ''),
(4, 'print', 'Colored Text', '4.00', '2022/09/26', '2022/12/01', ''),
(5, 'print', 'Colored Image', '8.00', '2022/09/26', '2022/12/01', ''),
(7, 'scan', 'Scan', '5.00', '2022/09/26', '', ''),
(8, 'Xerox', 'Black & White', '2.00', '2022/09/26', '2022/12/01', ''),
(9, 'Xerox', 'Colored Image', '3.00', '2022/09/26', '2022/12/01', ''),
(14, 'Laminate', 'wallet size', '10.00', '2022/09/26', '', ''),
(15, 'Laminate', '3R size', '15.00', '2022/09/26', '', ''),
(16, 'Laminate', '4R size', '25.00', '2022/09/26', '', ''),
(17, 'Laminate', '5R size ', '30.00', '2022/09/26', '', ''),
(18, 'Laminate', 'A4 (manipis)', '30.00', '2022/09/26', '', ''),
(19, 'photo', 'pkg 1', '13.00', '2022/09/26', '', ''),
(20, 'photo', 'pkg 2', '25.00', '2022/09/26', '2022/10/01', ''),
(21, 'photo', 'pkg 3', '25.00', '2022/09/26', '', ''),
(22, 'photo', 'pkg 4', '25.00', '2022/09/26', '', ''),
(24, 'photo', 'pkg 5', '18.00', '2022/10/01', '2022/10/01', ''),
(25, 'Mug', 'White Mug (R)', '80.00', '2022/10/01', '2022/10/22', ''),
(26, 'Mug', 'White Mug (W-10pcs)', '75.00', '2022/10/01', '2022/10/22', ''),
(29, 'Mug', 'Magic Mug (retail)', '140.00', '2022/10/03', '2022/12/11', ''),
(30, 'Mug', 'Magic Mug (Reseller)', '120.00', '2022/10/03', '2022/12/11', ''),
(31, 'photo', 'Lending Size', '25.00', '2022/10/06', '', ''),
(32, 'sticker', 'Sticker (R)', '30.00', '2022/10/06', '2022/10/14', ''),
(33, 'sticker', 'Homebaker Sticker', '20.00', '2022/10/07', '', ''),
(34, 'photo', 'wallet size', '5.00', '2022/10/08', '', ''),
(35, 'toppers', 'toppers (no edit)', '15.00', '2022/10/08', '', ''),
(36, 'toppers', 'toppers (with edit)', '20.00', '2022/10/08', '', ''),
(37, 'photo', 'TCR-ID', '30.00', '2022/10/10', '', ''),
(38, 'photo', '4R', '12.00', '2022/10/14', '', ''),
(39, 'sticker', 'Sticker (W)', '25.00', '2022/10/14', '', ''),
(40, 'photo', '5R ', '15.00', '2022/10/14', '', ''),
(41, 'Mug', 'White Mug (W-20pcs)', '70.00', '2022/10/22', '2022/10/22', ''),
(42, 'print', 'A4', '30.00', '2022/10/23', '', ''),
(43, 'TCR', 'ID-BIG', '30.00', '2022/10/26', '', ''),
(44, 'TCR', 'ID-Small', '20.00', '2022/10/26', '', ''),
(45, 'photo', '3R', '9.00', '2022/10/26', '', ''),
(48, 'Brilliant', 'Brialliant Whitening', '250.00', '2022/12/01', '', ''),
(49, 'Brilliant', 'Brialliant Rejuv', '210', '2022/12/01', '', ''),
(50, 'Brilliant', 'Kayakukayamu Soap', '28.00', '2022/12/01', '', ''),
(51, 'Brilliant', 'Kayakukayamu Soap', '28.00', '2022/12/01', '', ''),
(52, 'Mug', 'Magic Mug (Wholesale)', '135.00', '2022/12/11', '', ''),
(53, 'Mug', 'White Mug Only', '30.00', '2022/12/11', '', ''),
(54, 'Mug', 'Mug Box Only', '5.00', '2022/12/11', '', ''),
(55, 'Mug', 'White Mug (Min. of 100pcs)', '73.00', '2022/12/13', '', ''),
(56, 'photo', '8R', '20.00', '2022/12/15', '', ''),
(57, 'Mug', 'White Mug (old price)', '60.00', '2022/12/18', '', ''),
(58, 'Brilliant', 'Skin Magical ', '185.00', '2022/12/21', '', ''),
(59, 'Brilliant', 'MVE', '150.00', '2022/12/30', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `sales_today`
--

CREATE TABLE `sales_today` (
  `id` int(11) NOT NULL,
  `today_sales` varchar(50) NOT NULL,
  `date_added` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `temp_orders`
--

CREATE TABLE `temp_orders` (
  `id` int(11) NOT NULL,
  `pName` varchar(50) NOT NULL,
  `pPrice` varchar(50) NOT NULL,
  `pQTY` varchar(50) NOT NULL,
  `date_added` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `subtotal` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleted_account`
--
ALTER TABLE `deleted_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_today`
--
ALTER TABLE `sales_today`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_orders`
--
ALTER TABLE `temp_orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `deleted_account`
--
ALTER TABLE `deleted_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `sales_today`
--
ALTER TABLE `sales_today`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `temp_orders`
--
ALTER TABLE `temp_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=491;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
