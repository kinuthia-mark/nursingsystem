-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
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
-- Table structure for table `arv_therapy`
--

CREATE TABLE `arv_therapy` (
  `id` int(11) NOT NULL,
  `drug_1` varchar(100) DEFAULT NULL,
  `drug_2` varchar(100) DEFAULT NULL,
  `drug_3` varchar(100) DEFAULT NULL,
  `date_started` date DEFAULT NULL,
  `date_stopped` date DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `regimen` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `arv_therapy`
--

INSERT INTO `arv_therapy` (`id`, `drug_1`, `drug_2`, `drug_3`, `date_started`, `date_stopped`, `reason`, `regimen`, `created_at`) VALUES
(1, 'tumov', 'yedh', 'ydshg', '2025-07-01', '2025-07-17', 'fghjjklgk', 'hhjdsfg', '2025-07-01 12:42:52'),
(2, '24', 'fgh', 'vb', '2025-07-03', '2025-07-05', 'dxfgvhuj', 'tffgyu', '2025-07-03 12:20:58');

-- --------------------------------------------------------

--
-- Table structure for table `hiv_test`
--

CREATE TABLE `hiv_test` (
  `id` int(11) NOT NULL,
  `test_no` varchar(50) DEFAULT NULL,
  `date_tested` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `result` varchar(20) DEFAULT NULL,
  `agency` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hiv_test`
--

INSERT INTO `hiv_test` (`id`, `test_no`, `date_tested`, `age`, `result`, `agency`, `created_at`) VALUES
(1, '123', '2025-07-01', 10, 'Positive', 'fgjhfdhjd', '2025-07-01 12:32:45'),
(2, '2', '2025-07-03', 12, 'Positive', 'ghghe', '2025-07-03 12:50:55');

-- --------------------------------------------------------

--
-- Table structure for table `laboratory_results`
--

CREATE TABLE `laboratory_results` (
  `id` int(11) NOT NULL,
  `test_date` date DEFAULT NULL,
  `cd4_count` int(11) DEFAULT NULL,
  `cd4_perc` decimal(5,2) DEFAULT NULL,
  `viral_load` int(11) DEFAULT NULL,
  `hb` decimal(5,2) DEFAULT NULL,
  `ast` int(11) DEFAULT NULL,
  `alt` int(11) DEFAULT NULL,
  `total_trigly` int(11) DEFAULT NULL,
  `total_cholest` int(11) DEFAULT NULL,
  `ldl` int(11) DEFAULT NULL,
  `hdl` int(11) DEFAULT NULL,
  `creat` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laboratory_results`
--

INSERT INTO `laboratory_results` (`id`, `test_date`, `cd4_count`, `cd4_perc`, `viral_load`, `hb`, `ast`, `alt`, `total_trigly`, `total_cholest`, `ldl`, `hdl`, `creat`, `created_at`) VALUES
(1, '2025-07-01', -1, 20.00, -1, 0.10, 1, 1, -2, 4, -2, -2, 1, '2025-07-01 12:18:03'),
(2, '2025-07-01', -1, 20.00, -1, 0.10, 1, 1, -2, 4, -2, -2, 1, '2025-07-01 12:18:22'),
(3, '2025-07-03', 1, -0.20, -2, -0.10, 1, 1, -1, -1, -1, -1, -3, '2025-07-03 12:55:59');

-- --------------------------------------------------------

--
-- Table structure for table `medical_progress`
--

CREATE TABLE `medical_progress` (
  `id` int(11) NOT NULL,
  `report_date` date DEFAULT NULL,
  `school` varchar(100) DEFAULT NULL,
  `problems_last_review` text DEFAULT NULL,
  `adherence` varchar(50) DEFAULT NULL,
  `missed_doses` varchar(50) DEFAULT NULL,
  `counselling_on_adherence` text DEFAULT NULL,
  `present_problems` text DEFAULT NULL,
  `arv_therapy` varchar(100) DEFAULT NULL,
  `date_started` date DEFAULT NULL,
  `age_at_start` int(11) DEFAULT NULL,
  `duration_therapy` varchar(50) DEFAULT NULL,
  `current_drugs` text DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `height` float DEFAULT NULL,
  `z_score` varchar(20) DEFAULT NULL,
  `bmi` varchar(20) DEFAULT NULL,
  `pallor` varchar(50) DEFAULT NULL,
  `jaundice` varchar(50) DEFAULT NULL,
  `cyanosis` varchar(50) DEFAULT NULL,
  `clubbing` varchar(50) DEFAULT NULL,
  `oedema` varchar(50) DEFAULT NULL,
  `wasting` varchar(50) DEFAULT NULL,
  `parotids` varchar(50) DEFAULT NULL,
  `lymph_nodes` varchar(100) DEFAULT NULL,
  `eyes` varchar(100) DEFAULT NULL,
  `ears_discharge` varchar(100) DEFAULT NULL,
  `hearing_test` varchar(100) DEFAULT NULL,
  `throat` varchar(100) DEFAULT NULL,
  `mouth` varchar(100) DEFAULT NULL,
  `thrush` varchar(100) DEFAULT NULL,
  `ulcers` varchar(100) DEFAULT NULL,
  `teeth` varchar(100) DEFAULT NULL,
  `describe_teeth` text DEFAULT NULL,
  `skin` varchar(100) DEFAULT NULL,
  `describe_skin` text DEFAULT NULL,
  `normal_rs` varchar(100) DEFAULT NULL,
  `rs_rate` int(11) DEFAULT NULL,
  `recession` varchar(100) DEFAULT NULL,
  `percussion` varchar(100) DEFAULT NULL,
  `breath_sounds` varchar(100) DEFAULT NULL,
  `creps` varchar(100) DEFAULT NULL,
  `rhonchi` varchar(100) DEFAULT NULL,
  `state_location` text DEFAULT NULL,
  `normal_cvs` varchar(100) DEFAULT NULL,
  `cvs_rate` int(11) DEFAULT NULL,
  `apex` varchar(100) DEFAULT NULL,
  `precordium` varchar(100) DEFAULT NULL,
  `heart_sounds` varchar(100) DEFAULT NULL,
  `murmurs` varchar(100) DEFAULT NULL,
  `describe_heart` text DEFAULT NULL,
  `abdomen_normal` varchar(100) DEFAULT NULL,
  `gas` varchar(100) DEFAULT NULL,
  `ascites` varchar(100) DEFAULT NULL,
  `masses` varchar(100) DEFAULT NULL,
  `describe_abdomen` text DEFAULT NULL,
  `liver_cm` int(11) DEFAULT NULL,
  `spleen_cm` int(11) DEFAULT NULL,
  `normal_cns` varchar(100) DEFAULT NULL,
  `tone` varchar(100) DEFAULT NULL,
  `tendon_reflexes` varchar(100) DEFAULT NULL,
  `affected_parts` text DEFAULT NULL,
  `joints` varchar(100) DEFAULT NULL,
  `describe_joints` text DEFAULT NULL,
  `development` varchar(100) DEFAULT NULL,
  `motor` varchar(100) DEFAULT NULL,
  `tanner_stage` varchar(50) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `clinical` varchar(100) DEFAULT NULL,
  `immunological` varchar(100) DEFAULT NULL,
  `other_lab` varchar(100) DEFAULT NULL,
  `plan` varchar(255) DEFAULT NULL,
  `lab` varchar(100) DEFAULT NULL,
  `xray` varchar(100) DEFAULT NULL,
  `adjust_arv` varchar(100) DEFAULT NULL,
  `change_arv` varchar(100) DEFAULT NULL,
  `additional_drugs` varchar(100) DEFAULT NULL,
  `refer` varchar(100) DEFAULT NULL,
  `clinician_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_progress`
--

INSERT INTO `medical_progress` (`id`, `report_date`, `school`, `problems_last_review`, `adherence`, `missed_doses`, `counselling_on_adherence`, `present_problems`, `arv_therapy`, `date_started`, `age_at_start`, `duration_therapy`, `current_drugs`, `weight`, `height`, `z_score`, `bmi`, `pallor`, `jaundice`, `cyanosis`, `clubbing`, `oedema`, `wasting`, `parotids`, `lymph_nodes`, `eyes`, `ears_discharge`, `hearing_test`, `throat`, `mouth`, `thrush`, `ulcers`, `teeth`, `describe_teeth`, `skin`, `describe_skin`, `normal_rs`, `rs_rate`, `recession`, `percussion`, `breath_sounds`, `creps`, `rhonchi`, `state_location`, `normal_cvs`, `cvs_rate`, `apex`, `precordium`, `heart_sounds`, `murmurs`, `describe_heart`, `abdomen_normal`, `gas`, `ascites`, `masses`, `describe_abdomen`, `liver_cm`, `spleen_cm`, `normal_cns`, `tone`, `tendon_reflexes`, `affected_parts`, `joints`, `describe_joints`, `development`, `motor`, `tanner_stage`, `summary`, `clinical`, `immunological`, `other_lab`, `plan`, `lab`, `xray`, `adjust_arv`, `change_arv`, `additional_drugs`, `refer`, `clinician_name`, `created_at`) VALUES
(3, '2025-07-01', 'lask', 'heaadach', 'not full', '6', 'none', 'stomachache', 'fghsj', '2025-07-01', 10, '0y 0m', 'mara moja', 25, 5, 'hgjkj', '10000.00', 'hghjcv', 'xcjn', 'hjh', 'jgjh', 'kkjb', 'jh', 'knkb', 'kknb', 'bbjnk', 'vbjk', 'hjk', 'hjkl', 'lkjh', 'bnm', 'llkj', 'ghj', 'hjghjj', 'lkjskf', 'hjgjdk', 'kjkfiu', 2, 'jhdff', 'dgd', 'dgg', 'dshf', 'dg', 'sdfg', 'sdfgh', 1, 'sdg', 'sfdgf', 'aert', 'ytr', 'ertfxch', 'hgdfn', 'noefds', 'asfdg', 'asdfg', 'asdfgytrdd', 12, 10, '11', 'wasd', 'asgd', 'aegd', 'aefb', 'adsresadz', NULL, 'sgrdvs', 'sgsdvs', 'ageevad', 'gbsv', 'agvsd', 'sbdsvz', 'sbds ', 'asbdvav', 'sbfdx', 'dbvsvb', 'sbdx ', 'bsd z', 'zbdc x', 'bsvs ', '2025-07-01 13:43:03');

-- --------------------------------------------------------

--
-- Table structure for table `recurring_medical_history`
--

CREATE TABLE `recurring_medical_history` (
  `id` int(11) NOT NULL,
  `child_name` varchar(100) DEFAULT NULL,
  `child_id` varchar(50) DEFAULT NULL,
  `room_no` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `review_date` date DEFAULT NULL,
  `reviewed_by` varchar(100) DEFAULT NULL,
  `new_diagnoses` text DEFAULT NULL,
  `allergy_changes` text DEFAULT NULL,
  `medication_updates` text DEFAULT NULL,
  `hospitalizations` text DEFAULT NULL,
  `disabilities` text DEFAULT NULL,
  `new_vaccines` text DEFAULT NULL,
  `booster_doses` text DEFAULT NULL,
  `vaccine_dates` text DEFAULT NULL,
  `weight` varchar(20) DEFAULT NULL,
  `height` varchar(20) DEFAULT NULL,
  `blood_pressure` varchar(20) DEFAULT NULL,
  `temperature` varchar(20) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `mood_changes` text DEFAULT NULL,
  `incidents` text DEFAULT NULL,
  `referrals` text DEFAULT NULL,
  `social_notes` text DEFAULT NULL,
  `referred` varchar(100) DEFAULT NULL,
  `referral_purpose` text DEFAULT NULL,
  `next_appointment` date DEFAULT NULL,
  `nurse_signature` varchar(100) DEFAULT NULL,
  `social_signature` varchar(100) DEFAULT NULL,
  `completion_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recurring_medical_history`
--

INSERT INTO `recurring_medical_history` (`id`, `child_name`, `child_id`, `room_no`, `dob`, `review_date`, `reviewed_by`, `new_diagnoses`, `allergy_changes`, `medication_updates`, `hospitalizations`, `disabilities`, `new_vaccines`, `booster_doses`, `vaccine_dates`, `weight`, `height`, `blood_pressure`, `temperature`, `observations`, `mood_changes`, `incidents`, `referrals`, `social_notes`, `referred`, `referral_purpose`, `next_appointment`, `nurse_signature`, `social_signature`, `completion_date`) VALUES
(1, 'Joe Mango', '120', '2E', '2006-10-24', '2025-06-24', 'Dr Jane', 'Normal', 'None', 'Fit', 'None', 'None', 'None', 'None', 'None', '48', '4.2', '120/80 mm Hg', '98.6°F (37°C) ', 'Healthy and Fit', 'great', 'Better', 'None', 'Excellent', 'None', 'None', '2025-07-24', 'DrJane', 'Gacheri', '2025-06-24');

-- --------------------------------------------------------

--
-- Table structure for table `treatment_regimen`
--

CREATE TABLE `treatment_regimen` (
  `id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `medication` varchar(100) NOT NULL,
  `dosage` varchar(50) NOT NULL,
  `frequency` varchar(50) NOT NULL,
  `route` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `doctor` varchar(100) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment_regimen`
--

INSERT INTO `treatment_regimen` (`id`, `patient_name`, `medication`, `dosage`, `frequency`, `route`, `start_date`, `end_date`, `doctor`, `notes`, `created_at`) VALUES
(1, 'Joe Mango', 'Paracetamol', '250mg', 'Once a day', 'Oral', '2025-06-24', '2025-06-27', 'Dr Jane', 'Take as prescribed!', '2025-06-24 12:40:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `role` enum('Admin','Nurse','Doctor','Social Worker') NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `phone`, `gender`, `role`, `password`, `created_at`) VALUES
(1, 'Christine Mkamba', 'Christine M', 'christinem@gmail.com', '0768283571', 'Female', 'Social Worker', '$2y$10$.YVPdl7slyKfxKTT0QSjWunEl32ihpI4obugzGFB6DdcWXv/yLHze', '2025-06-24 12:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `user_level_id` int(11) NOT NULL,
  `userlevelname` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`user_level_id`, `userlevelname`) VALUES
(3, 'nurse'),
(4, 'social worker'),
(7, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `vaccination`
--

CREATE TABLE `vaccination` (
  `id` int(11) NOT NULL,
  `vaccine_no` varchar(50) DEFAULT NULL,
  `vaccine` varchar(100) DEFAULT NULL,
  `date_given` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccination`
--

INSERT INTO `vaccination` (`id`, `vaccine_no`, `vaccine`, `date_given`, `created_at`) VALUES
(1, '24', 'hgsdgh', '2025-07-01', '2025-07-01 13:48:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arv_therapy`
--
ALTER TABLE `arv_therapy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hiv_test`
--
ALTER TABLE `hiv_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laboratory_results`
--
ALTER TABLE `laboratory_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_progress`
--
ALTER TABLE `medical_progress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recurring_medical_history`
--
ALTER TABLE `recurring_medical_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treatment_regimen`
--
ALTER TABLE `treatment_regimen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`user_level_id`);

--
-- Indexes for table `vaccination`
--
ALTER TABLE `vaccination`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arv_therapy`
--
ALTER TABLE `arv_therapy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hiv_test`
--
ALTER TABLE `hiv_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `laboratory_results`
--
ALTER TABLE `laboratory_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `medical_progress`
--
ALTER TABLE `medical_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `recurring_medical_history`
--
ALTER TABLE `recurring_medical_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `treatment_regimen`
--
ALTER TABLE `treatment_regimen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_level`
--
ALTER TABLE `user_level`
  MODIFY `user_level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vaccination`
--
ALTER TABLE `vaccination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
