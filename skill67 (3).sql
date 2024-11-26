-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 03:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skill67`
--

-- --------------------------------------------------------

--
-- Table structure for table `food_cate`
--

CREATE TABLE `food_cate` (
  `cate_id` int(11) NOT NULL,
  `cate_name` varchar(50) NOT NULL,
  `cate_sid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_cate`
--

INSERT INTO `food_cate` (`cate_id`, `cate_name`, `cate_sid`) VALUES
(1, 'โคตรใหญ่', 1),
(2, 'โคตรกลาง', 1),
(3, 'เตี๋ยวเส้นเล็ก', 2),
(4, 'โคตรเล็ก', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail`
--

CREATE TABLE `tb_detail` (
  `detail_id` int(11) NOT NULL,
  `food_name` varchar(50) NOT NULL,
  `food_price` int(11) NOT NULL,
  `food_qty` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_detail`
--

INSERT INTO `tb_detail` (`detail_id`, `food_name`, `food_price`, `food_qty`, `order_id`, `type_id`) VALUES
(5, 'กะเพราจิงๆ', 59, 3, 4, 1),
(6, 'กะเพราใหญ่', 94, 2, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_food`
--

CREATE TABLE `tb_food` (
  `food_id` int(11) NOT NULL,
  `food_name` varchar(50) NOT NULL,
  `food_price` int(11) NOT NULL,
  `food_discount` int(11) NOT NULL,
  `food_type` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `food_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_food`
--

INSERT INTO `tb_food` (`food_id`, `food_name`, `food_price`, `food_discount`, `food_type`, `res_id`, `food_img`) VALUES
(1, 'กะเพราจิงๆ', 59, 10, 1, 9, '../img/20247295941697824757-128.png'),
(2, 'กะเพราใหญ่', 99, 5, 1, 9, '../img/2cc482f6-9e80-488f-9e0a-87103f16b40d.jpg'),
(4, 'เตี๋ยวเส้นเล็ก', 59, 0, 3, 1, '../img/ed4e96ec-3cb1-47cf-9eac-f5363b060a0e.jpg'),
(5, 'ข้าวผัด', 100, 0, 7, 1, 'pic_412248392_864157059050665_232283678390047132_n.jpg'),
(8, 'dsa', 0, 0, 1, 23, 'pic_Screenshot 2024-11-16 191936.png');

-- --------------------------------------------------------

--
-- Table structure for table `tb_order`
--

CREATE TABLE `tb_order` (
  `order_id` int(11) NOT NULL,
  `order_fname` varchar(50) NOT NULL,
  `order_total` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `order_status` int(11) NOT NULL,
  `order_pay` int(11) NOT NULL,
  `order_uid` int(11) NOT NULL,
  `order_address` varchar(50) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `review` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_order`
--

INSERT INTO `tb_order` (`order_id`, `order_fname`, `order_total`, `res_id`, `order_status`, `order_pay`, `order_uid`, `order_address`, `order_date`, `review`) VALUES
(4, 'admin', 375, 1, 1, 1, 22, 'asdasdasdasd', '0000-00-00 00:00:00', 1),
(5, 'admin', 118, 1, 2, 1, 1, 'เขาค้อ\r\n', '0000-00-00 00:00:00', 1),
(6, 'admin', 99, 1, 2, 1, 1, 'asdada', '0000-00-00 00:00:00', 1),
(7, 'admin2', 177, 2, 0, 0, 1, 'dadasdad', '0000-00-00 00:00:00', 0),
(8, 'tqwreq', 354, 2, 0, 1, 5, 'gsagsfdgafs', '0000-00-00 00:00:00', 1),
(9, 'admin2', 59, 2, 1, 0, 1, 'asdasd', '0000-00-00 00:00:00', 1),
(10, 'anatta', 59, 12, 1, 1, 7, 'fdsafasdf', '2023-12-14 04:16:25', 0),
(11, 'adminfasdd', 118, 1, 3, 1, 1, 'ที่อยู่', '2023-12-14 04:23:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_res`
--

CREATE TABLE `tb_res` (
  `res_id` int(11) NOT NULL,
  `res_name` varchar(50) NOT NULL,
  `res_detail` varchar(50) NOT NULL,
  `res_type` int(11) NOT NULL,
  `res_address` text NOT NULL,
  `res_owner` int(11) NOT NULL,
  `res_status` int(11) NOT NULL,
  `res_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_res`
--

INSERT INTO `tb_res` (`res_id`, `res_name`, `res_detail`, `res_type`, `res_address`, `res_owner`, `res_status`, `res_img`) VALUES
(1, 'ร้านนี้ดี', 'อร่อยๆๆๆ', 2, '', 13, 0, 'pic_soda (7).jpg'),
(9, 'ร้านนี้ดีๆ', 'ร้านนี้ดีๆร้านนี้ดีๆ', 4, '', 22, 1, 'pic_time (13).jpg'),
(10, 'ร้านนี้ดีๆมาก', 'ร้านนี้ดีๆมากๆๆๆๆ', 7, '', 15, 1, 'pic_d6941e8c-7ac9-4df7-9880-7744fe39cfad.jpg'),
(11, 'บิวตามสั่้ง', 'อร่อยยยย', 2, '', 23, 1, 'pic_Screenshot 2024-11-16 201109.png');

-- --------------------------------------------------------

--
-- Table structure for table `tb_review`
--

CREATE TABLE `tb_review` (
  `review_id` int(11) NOT NULL,
  `review_name` varchar(50) NOT NULL,
  `review_text` text NOT NULL,
  `review_rate` int(11) NOT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `review_oid` int(11) NOT NULL,
  `review_sid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_review`
--

INSERT INTO `tb_review` (`review_id`, `review_name`, `review_text`, `review_rate`, `review_date`, `review_oid`, `review_sid`) VALUES
(4, 'admin', 'อร่อยเฉย ชิมเบิ่ง\r\n', 5, '2023-12-13 08:42:40', 4, 1),
(5, 'admin', 'asdasd', 1, '2023-12-13 08:54:03', 5, 2),
(6, 'admin', 'พ่อค้าทำหรอย', 1, '2023-12-13 08:54:34', 6, 1),
(7, 'tqwreq', 'อร่อยเฉยยยยยยย (ผมไม่ได้กิน หมากินแทน)', 5, '0000-00-00 00:00:00', 8, 2),
(8, 'admin2', 'asdasd', 5, '2023-12-13 16:47:03', 9, 1),
(9, 'adminfasdd', 'qwerwerttd', 5, '2023-12-14 04:21:44', 5, 2),
(10, 'adminfasdd', 'fgasdgsgs', 2, '2023-12-14 04:26:34', 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_type`
--

CREATE TABLE `tb_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_type`
--

INSERT INTO `tb_type` (`type_id`, `type_name`) VALUES
(2, 'เมนูข้าว'),
(27, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `uid` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `userimg` text NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`uid`, `fname`, `lname`, `email`, `password`, `userimg`, `role`) VALUES
(13, 'champx', 'adsaad', 'admin@gmail.com', '12', 'pic_348318015_2673753469433967_3887051065377692243_n.jpg', 'admin'),
(14, 'prangxaz', 'vapee', 'rider@gmail.com', '12', '', 'rider'),
(15, 'biewx', 'sdada', 'member@gmail.com', '12', 'pic_hackler__httpss.mj.runOFZTafD91LM_simple_avataranime_3d_rende_3ffcf3e4-8796-4801-a049-704417901bb4_1.png', 'admin'),
(22, 'adds', 'owner', 'ownerx@gmail.com', '12', '', 'owner'),
(23, 'owner2', 'owner2', 'owner2@gmail.com', '12', 'pic_Screenshot 2024-11-16 191936.png', 'owner');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `food_cate`
--
ALTER TABLE `food_cate`
  ADD PRIMARY KEY (`cate_id`);

--
-- Indexes for table `tb_detail`
--
ALTER TABLE `tb_detail`
  ADD PRIMARY KEY (`detail_id`);

--
-- Indexes for table `tb_food`
--
ALTER TABLE `tb_food`
  ADD PRIMARY KEY (`food_id`);

--
-- Indexes for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tb_res`
--
ALTER TABLE `tb_res`
  ADD PRIMARY KEY (`res_id`);

--
-- Indexes for table `tb_review`
--
ALTER TABLE `tb_review`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `tb_type`
--
ALTER TABLE `tb_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `food_cate`
--
ALTER TABLE `food_cate`
  MODIFY `cate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_detail`
--
ALTER TABLE `tb_detail`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_food`
--
ALTER TABLE `tb_food`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_res`
--
ALTER TABLE `tb_res`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_review`
--
ALTER TABLE `tb_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_type`
--
ALTER TABLE `tb_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
