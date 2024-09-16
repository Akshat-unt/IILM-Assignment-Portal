-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 15, 2024 at 11:59 PM
-- Server version: 10.6.19-MariaDB-cll-lve
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eajlbarx_assignmentiilm`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--

CREATE TABLE `Admins` (
  `Admin_id` int(11) NOT NULL,
  `Admin_name` varchar(255) NOT NULL,
  `Admin_email` varchar(255) NOT NULL,
  `Admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Admins`
--

INSERT INTO `Admins` (`Admin_id`, `Admin_name`, `Admin_email`, `Admin_password`) VALUES
(2, 'Shivansh', 'shivansh.cs28@iilm.edu', '$2y$10$qM0iLfAyu/klq8i0SmHz8.w/HH9pPDH2pG6mfelbB2cOQjW3LAD/S');

-- --------------------------------------------------------

--
-- Table structure for table `Assignments`
--

CREATE TABLE `Assignments` (
  `Assign_id` int(11) NOT NULL,
  `Fac_id` int(11) NOT NULL,
  `Course_id` int(11) NOT NULL,
  `Sub_id` int(11) NOT NULL,
  `Assign_Title` varchar(255) NOT NULL,
  `Assign_des` text NOT NULL,
  `Assign_date` date NOT NULL,
  `Assign_due` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Assignments`
--

INSERT INTO `Assignments` (`Assign_id`, `Fac_id`, `Course_id`, `Sub_id`, `Assign_Title`, `Assign_des`, `Assign_date`, `Assign_due`) VALUES
(4, 1, 2, 6, 'Unit 1', 'Do it', '2024-09-01', '2024-12-21');

-- --------------------------------------------------------

--
-- Table structure for table `Courses`
--

CREATE TABLE `Courses` (
  `Course_id` int(11) NOT NULL,
  `Course_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Courses`
--

INSERT INTO `Courses` (`Course_id`, `Course_name`) VALUES
(2, 'B.Tech CSE - 1CSE4'),
(3, 'B.Tech CSE - 1CSE5'),
(4, 'B.Tech CSE - 1CSE6'),
(5, 'B.Tech CSE - 1CSE7'),
(6, 'B.Tech CSE - 1CSE8'),
(7, 'B.Tech CSE - 1CSE9'),
(8, 'B.Tech CSE - 1CSE10'),
(9, 'B.Tech CSE - 1CSE12'),
(10, 'B.Tech CSE - 1CSE13'),
(11, 'B.Tech CSE - 1CSE14'),
(12, 'B.Tech CSE - 1CSE15'),
(13, 'B.Tech CSE - 1CSE15'),
(14, 'B.Tech CSE - 1CSE16');

-- --------------------------------------------------------

--
-- Table structure for table `Faculty`
--

CREATE TABLE `Faculty` (
  `Fac_id` int(11) NOT NULL,
  `Fac_name` varchar(100) NOT NULL,
  `Fac_email` varchar(100) NOT NULL,
  `Fac_subjects` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`Fac_subjects`)),
  `Fac_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Faculty`
--

INSERT INTO `Faculty` (`Fac_id`, `Fac_name`, `Fac_email`, `Fac_subjects`, `Fac_password`) VALUES
(1, 'Soumya Aggarwal ', 'shivansh.cs28@iilm.edu', '6', '$2y$10$5qx.IEQpTRNC/TLLsUoTVepI34hAX6Jk3L6w/XzHnIayCGbjGXEha');

-- --------------------------------------------------------

--
-- Table structure for table `Grades`
--

CREATE TABLE `Grades` (
  `Grade_id` int(11) NOT NULL,
  `Stu_id` int(11) NOT NULL,
  `Course_id` int(11) NOT NULL,
  `Subject_id` int(11) NOT NULL,
  `Grade` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE `Students` (
  `Stu_id` int(11) NOT NULL,
  `Stu_name` varchar(100) NOT NULL,
  `Stu_email` varchar(100) NOT NULL,
  `Stu_password` varchar(255) NOT NULL,
  `Stu_course` int(11) NOT NULL,
  `Stu_subjects` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`Stu_subjects`))
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`Stu_id`, `Stu_name`, `Stu_email`, `Stu_password`, `Stu_course`, `Stu_subjects`) VALUES
(23, 'Akshat Kumar Singh', 'akshat.singh.cs28@iilm.edu', '$2y$10$xz4wGF4IbQfH9z/LiVm7X.UyrO05DOh/DxDrT2mEjrYlNX/uZPJTK', 2, '[5,6,7,8,9,10]'),
(24, 'Shivansh', 'shivansh.cs28@iilm.edu', '$2y$10$gcDI2UI9ZKb3t1MAE4ZJdOwMVJn5u205yNRI0Qrn7p74Sc2NY2oru', 2, '[5,6,7,8,9,10]');

-- --------------------------------------------------------

--
-- Table structure for table `Subjects`
--

CREATE TABLE `Subjects` (
  `Sub_id` int(11) NOT NULL,
  `Course_id` int(11) NOT NULL,
  `Sub_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Subjects`
--

INSERT INTO `Subjects` (`Sub_id`, `Course_id`, `Sub_name`) VALUES
(5, 2, 'Mathematics'),
(6, 2, 'EVS'),
(7, 2, 'Programming in C'),
(8, 2, 'Intro. to AIML'),
(9, 2, 'Communication Skills'),
(10, 2, 'Physics');

-- --------------------------------------------------------

--
-- Table structure for table `Submissions`
--

CREATE TABLE `Submissions` (
  `Submission_id` int(11) NOT NULL,
  `Assign_id` int(11) NOT NULL,
  `Stu_id` int(11) NOT NULL,
  `Submission_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `Submission_file` varchar(255) NOT NULL,
  `grades` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`Admin_id`),
  ADD UNIQUE KEY `Admin_email` (`Admin_email`);

--
-- Indexes for table `Assignments`
--
ALTER TABLE `Assignments`
  ADD PRIMARY KEY (`Assign_id`),
  ADD KEY `Fac_id` (`Fac_id`),
  ADD KEY `Course_id` (`Course_id`),
  ADD KEY `Sub_id` (`Sub_id`);

--
-- Indexes for table `Courses`
--
ALTER TABLE `Courses`
  ADD PRIMARY KEY (`Course_id`);

--
-- Indexes for table `Faculty`
--
ALTER TABLE `Faculty`
  ADD PRIMARY KEY (`Fac_id`),
  ADD UNIQUE KEY `Fac_email` (`Fac_email`);

--
-- Indexes for table `Grades`
--
ALTER TABLE `Grades`
  ADD PRIMARY KEY (`Grade_id`),
  ADD KEY `Stu_id` (`Stu_id`),
  ADD KEY `Course_id` (`Course_id`),
  ADD KEY `Subject_id` (`Subject_id`);

--
-- Indexes for table `Students`
--
ALTER TABLE `Students`
  ADD PRIMARY KEY (`Stu_id`),
  ADD UNIQUE KEY `Stu_email` (`Stu_email`);

--
-- Indexes for table `Subjects`
--
ALTER TABLE `Subjects`
  ADD PRIMARY KEY (`Sub_id`),
  ADD KEY `Course_id` (`Course_id`);

--
-- Indexes for table `Submissions`
--
ALTER TABLE `Submissions`
  ADD PRIMARY KEY (`Submission_id`),
  ADD KEY `Assign_id` (`Assign_id`),
  ADD KEY `Stu_id` (`Stu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admins`
--
ALTER TABLE `Admins`
  MODIFY `Admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Assignments`
--
ALTER TABLE `Assignments`
  MODIFY `Assign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Courses`
--
ALTER TABLE `Courses`
  MODIFY `Course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `Faculty`
--
ALTER TABLE `Faculty`
  MODIFY `Fac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Grades`
--
ALTER TABLE `Grades`
  MODIFY `Grade_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Students`
--
ALTER TABLE `Students`
  MODIFY `Stu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `Subjects`
--
ALTER TABLE `Subjects`
  MODIFY `Sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Submissions`
--
ALTER TABLE `Submissions`
  MODIFY `Submission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Assignments`
--
ALTER TABLE `Assignments`
  ADD CONSTRAINT `Assignments_ibfk_1` FOREIGN KEY (`Fac_id`) REFERENCES `Faculty` (`Fac_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Assignments_ibfk_2` FOREIGN KEY (`Course_id`) REFERENCES `Courses` (`Course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Assignments_ibfk_3` FOREIGN KEY (`Sub_id`) REFERENCES `Subjects` (`Sub_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Grades`
--
ALTER TABLE `Grades`
  ADD CONSTRAINT `Grades_ibfk_1` FOREIGN KEY (`Stu_id`) REFERENCES `Students` (`Stu_id`),
  ADD CONSTRAINT `Grades_ibfk_2` FOREIGN KEY (`Course_id`) REFERENCES `Courses` (`Course_id`),
  ADD CONSTRAINT `Grades_ibfk_3` FOREIGN KEY (`Subject_id`) REFERENCES `Subjects` (`Sub_id`);

--
-- Constraints for table `Students`
--
ALTER TABLE `Students`
  ADD CONSTRAINT `Students_ibfk_1` FOREIGN KEY (`Stu_course`) REFERENCES `Courses` (`Course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Subjects`
--
ALTER TABLE `Subjects`
  ADD CONSTRAINT `Subjects_ibfk_1` FOREIGN KEY (`Course_id`) REFERENCES `Courses` (`Course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Submissions`
--
ALTER TABLE `Submissions`
  ADD CONSTRAINT `Submissions_ibfk_1` FOREIGN KEY (`Assign_id`) REFERENCES `Assignments` (`Assign_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Submissions_ibfk_2` FOREIGN KEY (`Stu_id`) REFERENCES `Students` (`Stu_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
