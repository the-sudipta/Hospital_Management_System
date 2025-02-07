-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2025 at 06:07 PM
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
-- Database: `hospital_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_log`
--

CREATE TABLE `access_log` (
  `id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `timestamp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `his_appointment`
--

CREATE TABLE `his_appointment` (
  `id` int(50) NOT NULL,
  `his_patient_id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `appointment_date` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `his_billing`
--

CREATE TABLE `his_billing` (
  `id` int(50) NOT NULL,
  `his_patient_id` int(50) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `his_message`
--

CREATE TABLE `his_message` (
  `id` int(50) NOT NULL,
  `sender_id` int(50) NOT NULL,
  `receiver_id` int(50) NOT NULL,
  `message` varchar(300) NOT NULL,
  `timestamp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `his_patient`
--

CREATE TABLE `his_patient` (
  `id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pacs_image`
--

CREATE TABLE `pacs_image` (
  `id` int(50) NOT NULL,
  `his_patient_id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `image_path` varchar(300) NOT NULL,
  `image_type` varchar(50) NOT NULL,
  `upload_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pacs_report`
--

CREATE TABLE `pacs_report` (
  `id` int(50) NOT NULL,
  `pacs_image_id` int(50) NOT NULL,
  `report_text` varchar(300) NOT NULL,
  `created_at` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ris_report`
--

CREATE TABLE `ris_report` (
  `id` int(50) NOT NULL,
  `ris_schedule_id` int(50) NOT NULL,
  `report_text` varchar(300) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ris_schedule`
--

CREATE TABLE `ris_schedule` (
  `id` int(50) NOT NULL,
  `his_patient_id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `exam_type` varchar(120) NOT NULL,
  `scheduled_date` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_log`
--
ALTER TABLE `access_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `his_appointment`
--
ALTER TABLE `his_appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `his_billing`
--
ALTER TABLE `his_billing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `his_message`
--
ALTER TABLE `his_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `his_patient`
--
ALTER TABLE `his_patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pacs_image`
--
ALTER TABLE `pacs_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pacs_report`
--
ALTER TABLE `pacs_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ris_report`
--
ALTER TABLE `ris_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ris_schedule`
--
ALTER TABLE `ris_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_log`
--
ALTER TABLE `access_log`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `his_appointment`
--
ALTER TABLE `his_appointment`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `his_billing`
--
ALTER TABLE `his_billing`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `his_message`
--
ALTER TABLE `his_message`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `his_patient`
--
ALTER TABLE `his_patient`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pacs_image`
--
ALTER TABLE `pacs_image`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pacs_report`
--
ALTER TABLE `pacs_report`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ris_report`
--
ALTER TABLE `ris_report`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ris_schedule`
--
ALTER TABLE `ris_schedule`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
