-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2018 at 02:00 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone_leave_application`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `account_type_id` int(11) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `school_id` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `change_password_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_type_id`, `employee_id`, `school_id`, `username`, `password`, `change_password_code`) VALUES
(1, 5, '470', '2', 'mariantonjoc-admin', 'a4cadda5cec14530fd0778187f8501a1', NULL),
(2, 4, '470', '2', 'mariantonjoc-sds', '1a1dc91c907325c69271ddf0c944bc72', NULL),
(3, 3, '470', '3', 'mariantonjoc-hr', '13324516e0a5ea05c13bf6f1748ac0e0', NULL),
(4, 2, '470', '5', 'mariantonjoc-principal', '1a1dc91c907325c69271ddf0c944bc72', NULL),
(5, 1, '470', '6', 'mariantonjoc', '1a1dc91c907325c69271ddf0c944bc72', NULL),
(6, 5, '1247', '1', 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL),
(10, 3, '1247', '1', 'tester', 'f5d1278e8109edd94e1e4197e04873b9', NULL),
(11, 3, '1247', '1', 'tester1', 'fc5e038d38a57032085441e7fe7010b0', NULL),
(12, 5, '1247', '1', 'tester4', 'd1af5dfeec69e0133969744c2cb8deac', NULL),
(13, 1, '1', '', 'enelmamedidas', 'ed2a500beb59e736f46924e4b7425eaa', NULL),
(14, 1, '2', '', 'chrisalveluayon', 'af7628b96087f86a07166410a752a682', NULL),
(15, 1, '3', '', 'rosariolim', '7cf8bda8917cc415806b9bac6e94f1f3', NULL),
(16, 1, '4', '', 'rissanjadesanchez', 'ab389edf38b4069a08269749cf78bac6', NULL),
(17, 1, '5', '', 'ANNIELININEcasinillo', 'a498c629d41775df9c6955358775fb9b', NULL),
(18, 1, '6', '', 'maeannluces', 'a03b2ba66f00263306058b3ff7c59355', NULL),
(19, 1, '7', '', 'KENNLOURENmontera', 'a92cf10a2219eb8a132c112851e8bd92', NULL),
(20, 1, '8', '', 'lloyd', '27617d27802a9dea61e1b981f7033283', NULL),
(21, 1, '9', '', 'jerrcuadrado', '69384e87cbc062046ff9acff472076a9', NULL),
(22, 1, '10', '', 'MARKJESONnoval', '1f935b66de89a749b8541e949942e8bb', NULL),
(23, 1, '11', '', 'eugenealfietrillo', '004c1b60daa8c5fc6980b75520e101cc', NULL),
(24, 1, '12', '', 'marialevyluayon', '8b74721ebe572469988e109fe1b69559', NULL),
(25, 1, '13', '', 'floriza', '995bebb435637b6c2dbfeb780de880aa', NULL),
(26, 1, '14', '', 'ariesaguirre', '43a913318f7ce44fd7685f36e8f8b7a2', NULL),
(27, 1, '15', '', 'rubennoval', 'bb40809ee0c71816c9aa0d0ec9701ef2', NULL),
(28, 1, '16', '', 'laarniasis', '5253e19a8c33f9f93f788d43c81cc485', NULL),
(29, 1, '17', '', 'josephinebesin', '4137350ad32f7daa6dc8a2d36a175004', NULL),
(30, 1, '18', '', 'normaopena', 'e305256c3ac872ec1631873b0107b06b', NULL),
(31, 1, '19', '', 'femaloloy-on', '7e7510d93e2ab4e1d5284cc70184458d', NULL),
(32, 1, '20', '', 'wilmamamugay', 'd3600dfb6b13458fa6101bfc1429db2d', NULL),
(33, 1, '21', '', 'charmainecampos', 'ebd5b49ef868ce2fad817396f008abac', NULL),
(34, 1, '22', '', 'rhodaranara', 'b90ff03e895ba69533dda3e295f3e87d', NULL),
(35, 1, '23', '', 'jeanfranco', 'a89c0ac1eb6d8f11753c4b89475dcc83', NULL),
(36, 1, '24', '', 'gerlynsalazar', '2c71d176574aa8f560b4da2dfbe3951e', NULL),
(37, 1, '25', '', 'analoucordova', '98cf15e16be55b94aa675111f13a8e45', NULL),
(38, 1, '26', '', 'rinaortega', 'ccace84cf712309e4821d0762b327e96', NULL),
(39, 1, '1247', '', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `account_types`
--

CREATE TABLE `account_types` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_types`
--

INSERT INTO `account_types` (`id`, `type`) VALUES
(1, 'user'),
(2, 'principal'),
(3, 'hr'),
(4, 'sds'),
(5, 'account_manager');

-- --------------------------------------------------------

--
-- Table structure for table `action_on_applications`
--

CREATE TABLE `action_on_applications` (
  `id` int(11) NOT NULL,
  `leave_application_id` int(11) NOT NULL,
  `school_head_approved` tinyint(1) DEFAULT NULL,
  `hr_approved` tinyint(1) DEFAULT NULL,
  `division_head_approved` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `action_on_applications`
--

INSERT INTO `action_on_applications` (`id`, `leave_application_id`, `school_head_approved`, `hr_approved`, `division_head_approved`) VALUES
(11, 54, 1, 0, NULL),
(12, 55, 1, 1, 0),
(13, 56, 1, 1, 1),
(14, 57, 0, NULL, NULL),
(15, 58, 0, NULL, NULL),
(16, 59, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `certification_of_leave_credits`
--

CREATE TABLE `certification_of_leave_credits` (
  `id` int(11) NOT NULL,
  `action_on_applications_id` int(11) NOT NULL,
  `as_of` date DEFAULT NULL,
  `remaining_days` int(4) DEFAULT NULL,
  `vacation_days` int(3) DEFAULT NULL,
  `sick_days` int(3) DEFAULT NULL,
  `total` int(4) DEFAULT NULL,
  `approved_for` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `certification_of_leave_credits`
--

INSERT INTO `certification_of_leave_credits` (`id`, `action_on_applications_id`, `as_of`, `remaining_days`, `vacation_days`, `sick_days`, `total`, `approved_for`) VALUES
(1, 11, '2018-06-10', NULL, NULL, NULL, NULL, 'Maternity Leave, 60 days.');

-- --------------------------------------------------------

--
-- Table structure for table `leave_applications`
--

CREATE TABLE `leave_applications` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `office` varchar(100) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `date_filed` date NOT NULL,
  `type_of_leave` varchar(256) NOT NULL,
  `number_days_applied` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `place_stay` varchar(50) DEFAULT NULL,
  `place_stay_specify` text,
  `commutation_requested` tinyint(1) NOT NULL DEFAULT '0',
  `cancelled` tinyint(1) NOT NULL DEFAULT '0',
  `filename` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_applications`
--

INSERT INTO `leave_applications` (`id`, `account_id`, `office`, `school_id`, `date_filed`, `type_of_leave`, `number_days_applied`, `from_date`, `place_stay`, `place_stay_specify`, `commutation_requested`, `cancelled`, `filename`) VALUES
(54, 39, '', 56, '2018-06-10', 'Maternity', 60, '2018-11-14', '', '', 0, 0, ''),
(55, 39, '', 56, '2018-06-10', 'Sick', 4, '2018-06-11', 'in_hospital', 'Bayugan Doctors Hospital', 0, 0, ''),
(56, 39, '', 56, '2018-06-10', 'Sick', 7, '2018-06-12', 'out_patient', 'In House', 0, 0, '2018-06-10 20-11-53 f1e89e0496068ad6d202d63e11cccd4a'),
(57, 39, '', 56, '2018-06-10', 'Sick', 8, '2018-06-11', 'out_patient', 'In House, Taglatawan Bayugan', 0, 0, '2018-06-10 22-22-00 4fb63740e5caba2a01e2356389079c06'),
(58, 39, '', 56, '2018-06-10', 'Sick', 7, '2018-06-11', 'in_hospital', 'Bayugan Doctors Hospital', 0, 0, '2018-06-10 22-35-29 5b2fd10a38d5495e7b8c0abcdbf40b64'),
(59, 39, '', 56, '2018-06-10', 'Sick', 6, '2018-06-11', 'in_hospital', 'Bayugan Hospital', 0, 0, '2018-06-10 22-39-47 dc641cba7ed1bfddc8b8a528b37f2130');

--
-- Triggers `leave_applications`
--
DELIMITER $$
CREATE TRIGGER `leave_applications_insert_trigger` AFTER INSERT ON `leave_applications` FOR EACH ROW BEGIN 
		INSERT INTO action_on_applications (leave_application_id) VALUES(new.id) ;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `osds_action`
--

CREATE TABLE `osds_action` (
  `id` int(11) NOT NULL,
  `action_on_applications_id` int(11) NOT NULL,
  `as_of` date DEFAULT NULL,
  `days_with_pay` varchar(10) DEFAULT NULL,
  `days_without_pay` varchar(10) DEFAULT NULL,
  `others_days` varchar(10) DEFAULT NULL,
  `others_description` varchar(100) DEFAULT NULL,
  `disapproved_due_to` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `recommendation`
--

CREATE TABLE `recommendation` (
  `id` int(11) NOT NULL,
  `action_on_applications_id` int(11) NOT NULL,
  `as_of` date DEFAULT NULL,
  `disapproval_due_to` text,
  `recommendation` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recommendation`
--

INSERT INTO `recommendation` (`id`, `action_on_applications_id`, `as_of`, `disapproval_due_to`, `recommendation`) VALUES
(1, 11, '2018-06-10', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_account_type_id` (`account_type_id`);

--
-- Indexes for table `account_types`
--
ALTER TABLE `account_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `action_on_applications`
--
ALTER TABLE `action_on_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `action_on_applications_leave_application_id` (`leave_application_id`);

--
-- Indexes for table `certification_of_leave_credits`
--
ALTER TABLE `certification_of_leave_credits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certification_of_leave_credits_action_on_applications_id` (`action_on_applications_id`);

--
-- Indexes for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_applications_account_id` (`account_id`);

--
-- Indexes for table `osds_action`
--
ALTER TABLE `osds_action`
  ADD PRIMARY KEY (`id`),
  ADD KEY `osds_action_action_on_applications_id` (`action_on_applications_id`);

--
-- Indexes for table `recommendation`
--
ALTER TABLE `recommendation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recommendation_action_on_applications_id` (`action_on_applications_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `account_types`
--
ALTER TABLE `account_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `action_on_applications`
--
ALTER TABLE `action_on_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `certification_of_leave_credits`
--
ALTER TABLE `certification_of_leave_credits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leave_applications`
--
ALTER TABLE `leave_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `osds_action`
--
ALTER TABLE `osds_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recommendation`
--
ALTER TABLE `recommendation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `account_account_type_id` FOREIGN KEY (`account_type_id`) REFERENCES `account_types` (`id`);

--
-- Constraints for table `action_on_applications`
--
ALTER TABLE `action_on_applications`
  ADD CONSTRAINT `action_on_applications_leave_application_id` FOREIGN KEY (`leave_application_id`) REFERENCES `leave_applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certification_of_leave_credits`
--
ALTER TABLE `certification_of_leave_credits`
  ADD CONSTRAINT `certification_of_leave_credits_action_on_applications_id` FOREIGN KEY (`action_on_applications_id`) REFERENCES `action_on_applications` (`id`);

--
-- Constraints for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD CONSTRAINT `leave_applications_account_id` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `osds_action`
--
ALTER TABLE `osds_action`
  ADD CONSTRAINT `osds_action_action_on_applications_id` FOREIGN KEY (`action_on_applications_id`) REFERENCES `action_on_applications` (`id`);

--
-- Constraints for table `recommendation`
--
ALTER TABLE `recommendation`
  ADD CONSTRAINT `recommendation_action_on_applications_id` FOREIGN KEY (`action_on_applications_id`) REFERENCES `action_on_applications` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
