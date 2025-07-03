-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 03, 2025 at 03:46 PM
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
-- Database: `nursing`
--

-- --------------------------------------------------------

--
-- Table structure for table `admissionformtp`
--

CREATE TABLE `admissionformtp` (
  `id` int(11) NOT NULL,
  `family_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `sex` enum('Male','Female','Other') NOT NULL,
  `dob` date NOT NULL,
  `birth_weight` double NOT NULL,
  `breastfed` varchar(10) NOT NULL,
  `date_of_admission` date NOT NULL,
  `age_of_admission` varchar(50) NOT NULL,
  `weight_on_admission` double NOT NULL,
  `referral_source` varchar(255) NOT NULL,
  `mother_name` varchar(100) NOT NULL,
  `mother_life_status` varchar(50) NOT NULL,
  `mother_hiv_status` varchar(50) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `father_life_status` varchar(50) NOT NULL,
  `father_hiv_status` varchar(50) NOT NULL,
  `birth_order` int(11) NOT NULL,
  `no_of_siblings` int(11) NOT NULL,
  `no_of_hiv_positive` int(11) NOT NULL,
  `no_of_hiv_negative` int(11) NOT NULL,
  `child_life_status` varchar(50) NOT NULL,
  `present_caretaker` varchar(100) NOT NULL,
  `age_of_death` int(11) DEFAULT NULL,
  `cause_of_death` varchar(255) DEFAULT NULL,
  `date_of_death` date DEFAULT NULL,
  `child_left` varchar(255) DEFAULT NULL,
  `record_added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discharge_abstract`
--

CREATE TABLE `discharge_abstract` (
  `id` int(11) NOT NULL,
  `discharge_date` date NOT NULL,
  `discharge_weight` double NOT NULL,
  `discharge_height` double NOT NULL,
  `adherence` varchar(255) NOT NULL,
  `ccc_name` varchar(255) NOT NULL,
  `discharge_doctor` varchar(255) NOT NULL,
  `admission` text NOT NULL,
  `clinical_progress` text NOT NULL,
  `condition_at_discharge` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discharge_abstract`
--

INSERT INTO `discharge_abstract` (`id`, `discharge_date`, `discharge_weight`, `discharge_height`, `adherence`, `ccc_name`, `discharge_doctor`, `admission`, `clinical_progress`, `condition_at_discharge`) VALUES
(1, '2025-07-15', 50, 180, 'good', 'panadol', 'claire njeri', 'good', 'good', 'good'),
(2, '2025-07-03', 34, 54, 'dfdf', 'frfrere', '4rererer', 'erererererr', 'ererrr', 'ererrer');

-- --------------------------------------------------------

--
-- Table structure for table `hiv_positive_siblings`
--

CREATE TABLE `hiv_positive_siblings` (
  `id` int(11) NOT NULL,
  `siblings_no` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` enum('Male','Female','Other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hiv_positive_siblings`
--

INSERT INTO `hiv_positive_siblings` (`id`, `siblings_no`, `first_name`, `last_name`, `age`, `sex`) VALUES
(2, 2, 'joe', 'kinyanjui', 20, 'Male'),
(3, 1, 'dsdsd', 'sdsdd', 10, 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `medical_forms`
--

CREATE TABLE `medical_forms` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `admissiondate` date DEFAULT NULL,
  `guardianname` varchar(100) DEFAULT NULL,
  `relationship` varchar(50) DEFAULT NULL,
  `guardianphone` varchar(20) DEFAULT NULL,
  `emergencycontactperson` varchar(100) DEFAULT NULL,
  `emergencycontactphone` varchar(20) DEFAULT NULL,
  `medicalhistory` text DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `currentmedications` text DEFAULT NULL,
  `vaccinationstatus` varchar(100) DEFAULT NULL,
  `specialneeds` text DEFAULT NULL,
  `additionalinfo` text DEFAULT NULL,
  `immunization` text DEFAULT NULL,
  `bcg_date` date DEFAULT NULL,
  `polio_date` date DEFAULT NULL,
  `dpt_date` date DEFAULT NULL,
  `hepatitisb_date` date DEFAULT NULL,
  `measles_date` date DEFAULT NULL,
  `others_specify` varchar(100) DEFAULT NULL,
  `others_date` date DEFAULT NULL,
  `weight` varchar(10) DEFAULT NULL,
  `height` varchar(10) DEFAULT NULL,
  `bloodpressure` varchar(20) DEFAULT NULL,
  `temperature` varchar(10) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `nurse_name` varchar(100) DEFAULT NULL,
  `nurse_signature` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_forms`
--

INSERT INTO `medical_forms` (`id`, `fullname`, `dob`, `gender`, `admissiondate`, `guardianname`, `relationship`, `guardianphone`, `emergencycontactperson`, `emergencycontactphone`, `medicalhistory`, `allergies`, `currentmedications`, `vaccinationstatus`, `specialneeds`, `additionalinfo`, `immunization`, `bcg_date`, `polio_date`, `dpt_date`, `hepatitisb_date`, `measles_date`, `others_specify`, `others_date`, `weight`, `height`, `bloodpressure`, `temperature`, `observations`, `nurse_name`, `nurse_signature`, `date`, `created_at`) VALUES
(1, 'joe mwago', '2025-06-26', 'male', '2025-06-26', 'joe mwago', 'brother', '0789898989', 'mbuvi sonko', '0798989898', 'none', 'none', 'none', 'none', 'none', 'none', 'BCG, POLIO, DPT, HEPATITIS B, MEASLES, OTHERS', '2025-06-26', '2025-06-26', '2025-06-26', '2025-06-26', '2025-06-26', 'none', '2025-06-26', '75', '180', '130mm/hg', '37', 'none', 'gasheri', 'gasheri 123', '2025-06-26', '2025-06-26 08:48:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admissionformtp`
--
ALTER TABLE `admissionformtp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discharge_abstract`
--
ALTER TABLE `discharge_abstract`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hiv_positive_siblings`
--
ALTER TABLE `hiv_positive_siblings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_forms`
--
ALTER TABLE `medical_forms`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admissionformtp`
--
ALTER TABLE `admissionformtp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `discharge_abstract`
--
ALTER TABLE `discharge_abstract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hiv_positive_siblings`
--
ALTER TABLE `hiv_positive_siblings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `medical_forms`
--
ALTER TABLE `medical_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
