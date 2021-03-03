-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2020 at 05:33 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ntk`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_address`
--

CREATE TABLE `tb_address` (
  `address_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address_home` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'บ้านเลขที่',
  `address_swine` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'หมู่',
  `address_alley` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ซอย',
  `address_road` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ถนน',
  `address_subdistrict` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'แขวง/ตำบล',
  `address_district` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'เขต/อำเภอ',
  `address_province` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'จังหวัด',
  `address_zipcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'รหัสไปรษณีย์',
  `address_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ใช้งาน/ระงับ',
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `update_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_address`
--

INSERT INTO `tb_address` (`address_id`, `address_home`, `address_swine`, `address_alley`, `address_road`, `address_subdistrict`, `address_district`, `address_province`, `address_zipcode`, `address_status`, `created_by`, `created_at`, `update_by`, `update_at`) VALUES
('ADD630001', '246', '', 'สุขสวัสดิ์ 38', 'จอมทองบูรณะ', 'บางปะกอก', ' ราษฏรฺ์บูรณะ', ' กรุงเทพฯ', '10140', 'ใช้งาน', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-12', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-12'),
('ADD630002', '565', '65', 'บางนา', 'บางนา', 'บางนา', ' บางนา', ' กรุงเทพฯ', '10180', 'ใช้งาน', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-17', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-17'),
('ADD630003', '5445', '5', 'บางปะกอก', 'บางปะกอก', 'บางปะกอก', ' บางปะกอก', ' กรุงเทพฯ', '10140', 'ใช้งาน', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-17', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-17');

-- --------------------------------------------------------

--
-- Table structure for table `tb_drug`
--

CREATE TABLE `tb_drug` (
  `drug_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_detail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_group_drug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `update_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_drug`
--

INSERT INTO `tb_drug` (`drug_id`, `drug_name`, `drug_amount`, `drug_price`, `drug_detail`, `drug_status`, `picture`, `ref_group_drug`, `created_by`, `created_at`, `update_by`, `update_at`) VALUES
('DRU63001', 'แอสเซนต์', '1000', '400', 'eddtgsdgsdg', 'ปกติ', 'DR63001.jpg', 'GD6301', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-19', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-27'),
('DRU63002', 'borone', '1000', '600', 'sssssssssss', 'ปกติ', 'DRU63002.jpg', 'GD6303', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-21', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-22'),
('DRU63003', 'cabon', '2000', '300', 'fsdgsdsdhgd', 'ปกติ', 'DRU63003.jpg', 'GD6302', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-21', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-27');

-- --------------------------------------------------------

--
-- Table structure for table `tb_drug_detail`
--

CREATE TABLE `tb_drug_detail` (
  `drug_detail_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_detail_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `detail_size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_detail_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_drug_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `update_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_drug_detail`
--

INSERT INTO `tb_drug_detail` (`drug_detail_id`, `drug_detail_amount`, `detail_size`, `drug_detail_status`, `ref_drug_id`, `created_by`, `created_at`, `update_by`, `update_at`) VALUES
('DRU63001-01', '2000', 'M', 'ปกติ', 'DRU63001', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-27', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29'),
('DRU63002-01', '2000', '', 'ปกติ', 'DRU63002', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29'),
('DRU63002-02', '1000', '', 'ปกติ', 'DRU63002', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29'),
('DRU63003-01', '10000', '', 'ปกติ', 'DRU63003', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29');

-- --------------------------------------------------------

--
-- Table structure for table `tb_drug_formula`
--

CREATE TABLE `tb_drug_formula` (
  `drug_formula_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_formula_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_formula_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `update_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_drug_formula`
--

INSERT INTO `tb_drug_formula` (`drug_formula_id`, `drug_formula_name`, `drug_formula_status`, `created_by`, `created_at`, `update_by`, `update_at`) VALUES
('DF63001', 'สูตรยาเร่งรากโตไว', 'ปกติ', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29'),
('DF63002', 'สูตรยาเร่งรากโตไว M', 'ปกติ', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29'),
('DF63003', 'สูตรยาเร่งรากโตไว L', 'ปกติ', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `tb_drug_formula_detail`
--

CREATE TABLE `tb_drug_formula_detail` (
  `drug_formula_detail_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_drug_formula` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_formula_detail_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_formula_detail_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_drug_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `update_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_drug_formula_detail`
--

INSERT INTO `tb_drug_formula_detail` (`drug_formula_detail_id`, `ref_drug_formula`, `drug_formula_detail_amount`, `drug_formula_detail_status`, `ref_drug_id`, `created_by`, `created_at`, `update_by`, `update_at`) VALUES
('1', 'DF63001', '100', 'ปกติ', 'DRU63001', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-30'),
('2', 'DF63003', '1500', 'ปกติ', 'DRU63003', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-30'),
('3', 'DF63003', '2000', 'ปกติ', 'DRU63001', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29');

-- --------------------------------------------------------

--
-- Table structure for table `tb_drug_sm_unit`
--

CREATE TABLE `tb_drug_sm_unit` (
  `drug_sm_unit_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_sm_unit_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_sm_unit_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `update_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_drug_sm_unit`
--

INSERT INTO `tb_drug_sm_unit` (`drug_sm_unit_id`, `drug_sm_unit_name`, `drug_sm_unit_status`, `created_by`, `created_at`, `update_by`, `update_at`) VALUES
('SU6301', 'มิลลิลิตร', 'ปกติ', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-16', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-21'),
('SU6302', 'กรัม', 'ปกติ', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-16', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-21');

-- --------------------------------------------------------

--
-- Table structure for table `tb_drug_type`
--

CREATE TABLE `tb_drug_type` (
  `drug_typeid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_typename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_typestatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_drug_unit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `update_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_drug_type`
--

INSERT INTO `tb_drug_type` (`drug_typeid`, `drug_typename`, `drug_typestatus`, `ref_drug_unit`, `created_by`, `created_at`, `update_by`, `update_at`) VALUES
('DT6301', 'ยาเร่งราก', 'ปกติ', 'UD6301', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-14', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29'),
('DT6302', 'ยาฆ่าแมลง', 'ปกติ', 'UD6302', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-15', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-17'),
('DT6303', 'ยาฆ่าเชื้อรา', 'ปกติ', 'UD6302', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-16', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-29'),
('DT6304', 'ยาเร่งราก', 'ปกติ', 'UD6302', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-16', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-19'),
('DT6305', 'ยาฆ่าเชื้อรา', 'ปกติ', 'UD6303', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-19', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `tb_drug_unit`
--

CREATE TABLE `tb_drug_unit` (
  `drug_unit_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_unit_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drug_unit_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `update_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_drug_unit`
--

INSERT INTO `tb_drug_unit` (`drug_unit_id`, `drug_unit_name`, `drug_unit_status`, `created_by`, `created_at`, `update_by`, `update_at`) VALUES
('UD6301', 'ขวด', 'ปกติ', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-16', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-19'),
('UD6302', 'แกลลอน', 'ปกติ', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-16', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-19'),
('UD6303', 'ถุง', 'ปกติ', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-19', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `tb_group_drug`
--

CREATE TABLE `tb_group_drug` (
  `group_drug_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_drug_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_drug_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_drug_sunit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_drug_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `update_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_group_drug`
--

INSERT INTO `tb_group_drug` (`group_drug_id`, `group_drug_name`, `group_drug_status`, `ref_drug_sunit`, `ref_drug_type`, `created_by`, `created_at`, `update_by`, `update_at`) VALUES
('GD6301', 'Inorganic', 'ปกติ', 'SU6301', 'DT6304', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-17', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-19'),
('GD6302', 'dinamic', 'ปกติ', 'SU6302', 'DT6305', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-19', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-20'),
('GD6303', 'jotan', 'ปกติ', 'SU6301', 'DT6302', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-21', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-21');

-- --------------------------------------------------------

--
-- Table structure for table `tb_material`
--

CREATE TABLE `tb_material` (
  `material_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `material_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `material_detail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `material_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `update_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_material_detail`
--

CREATE TABLE `tb_material_detail` (
  `material_detail_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `material_detail_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `material_detail_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `material_detail_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_material_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `update_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tree`
--

CREATE TABLE `tb_tree` (
  `tree_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tree_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tree_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tree_detail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_tree_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` date NOT NULL,
  `update_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tree_type`
--

CREATE TABLE `tb_tree_type` (
  `type_treeid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tree_type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tree_type_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `update_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `emp_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `card_id` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `address_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `emp_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ปกติ/ลาออก',
  `status_login` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'อนุญาต/ไม่อนุญาต',
  `picture` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `update_by` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`emp_id`, `firstname`, `lastname`, `sex`, `card_id`, `telephone`, `address_id`, `emp_status`, `status_login`, `picture`, `created_by`, `created_at`, `update_by`, `update_at`) VALUES
('EMP630001', 'อภิสิทธิ์', 'ห่วงเอี่ยม', 'ชาย', '1103100530087', '0956387574', 'ADD630001', 'ปกติ', 'อนุญาต', 'EMP630001.jpg', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-12', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-12'),
('EMP630002', 'จรรยาพร', 'รอดน้อย', 'หญิง', '1660226598777', '0920492800', 'ADD630002', 'ปกติ', 'อนุญาต', 'EMP630002.jpg', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-17', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-19'),
('EMP630003', 'สุรวุฒิ', 'ดิษฐป้อม', 'ชาย', '9531216494979', '1234567890', 'ADD630003', 'ปกติ', 'ไม่อนุญาต', 'EMP630003.jpg', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-17', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-17');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_detail`
--

CREATE TABLE `tb_user_detail` (
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `userlevel` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ผู้ดูแลระบบ/พนักงาน',
  `status` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ใช้งาน/ถูกระงับ',
  `ref_emp_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `update_by` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_user_detail`
--

INSERT INTO `tb_user_detail` (`user_id`, `username`, `password`, `userlevel`, `status`, `ref_emp_id`, `created_by`, `created_at`, `update_by`, `update_at`) VALUES
('1', 'EMP630001', '1412', 'ผู้ดูแลระบบ', 'ใช้งาน', 'EMP630001', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-12', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-13'),
('2', 'EMP630002', '1412', 'พนักงาน', 'ใช้งาน', 'EMP630002', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-17', 'อภิสิทธิ์ ห่วงเอี่ยม', '2020-06-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_address`
--
ALTER TABLE `tb_address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `tb_drug`
--
ALTER TABLE `tb_drug`
  ADD PRIMARY KEY (`drug_id`);

--
-- Indexes for table `tb_drug_detail`
--
ALTER TABLE `tb_drug_detail`
  ADD PRIMARY KEY (`drug_detail_id`);

--
-- Indexes for table `tb_drug_formula`
--
ALTER TABLE `tb_drug_formula`
  ADD PRIMARY KEY (`drug_formula_id`);

--
-- Indexes for table `tb_drug_formula_detail`
--
ALTER TABLE `tb_drug_formula_detail`
  ADD PRIMARY KEY (`drug_formula_detail_id`);

--
-- Indexes for table `tb_drug_sm_unit`
--
ALTER TABLE `tb_drug_sm_unit`
  ADD PRIMARY KEY (`drug_sm_unit_id`);

--
-- Indexes for table `tb_drug_type`
--
ALTER TABLE `tb_drug_type`
  ADD PRIMARY KEY (`drug_typeid`);

--
-- Indexes for table `tb_drug_unit`
--
ALTER TABLE `tb_drug_unit`
  ADD PRIMARY KEY (`drug_unit_id`);

--
-- Indexes for table `tb_group_drug`
--
ALTER TABLE `tb_group_drug`
  ADD PRIMARY KEY (`group_drug_id`);

--
-- Indexes for table `tb_material`
--
ALTER TABLE `tb_material`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `tb_material_detail`
--
ALTER TABLE `tb_material_detail`
  ADD PRIMARY KEY (`material_detail_id`);

--
-- Indexes for table `tb_tree`
--
ALTER TABLE `tb_tree`
  ADD PRIMARY KEY (`tree_id`);

--
-- Indexes for table `tb_tree_type`
--
ALTER TABLE `tb_tree_type`
  ADD PRIMARY KEY (`type_treeid`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `tb_user_detail`
--
ALTER TABLE `tb_user_detail`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `ref_emp_id` (`ref_emp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
