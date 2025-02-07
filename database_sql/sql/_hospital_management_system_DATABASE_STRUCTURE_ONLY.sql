-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2025 at 05:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `hospital_management_system`

-- Table structure for table `appointment`
CREATE TABLE `appointment` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `appointment_date` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `patient_id` int(50) NOT NULL,
  `booked_by_id` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `billing`
CREATE TABLE `billing` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `amount` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `patient_id` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `log`
CREATE TABLE `log` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `action` varchar(50) NOT NULL,
  `timestamp` varchar(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `message`
CREATE TABLE `message` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `message` varchar(300) NOT NULL,
  `timestamp` varchar(50) NOT NULL,
  `sender_id` int(50) NOT NULL,
  `receiver_id` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `patient`
CREATE TABLE `patient` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `address` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `report`
CREATE TABLE `report` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `report_text` varchar(300) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `patient_id` int(50) NOT NULL,
  `uploader_id` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `test_image`
CREATE TABLE `test_image` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `image` varchar(300) NOT NULL,
  `image_type` varchar(50) NOT NULL,
  `upload_date` varchar(50) NOT NULL,
  `patient_id` int(50) NOT NULL,
  `report_id` int(50) NOT NULL,
  `uploader_id` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `test_schedule`
CREATE TABLE `test_schedule` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `exam_type` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `patient_id` int(50) NOT NULL,
  `booked_by_id` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `user`
CREATE TABLE `user` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(300) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
