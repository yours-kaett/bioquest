-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 18, 2023 at 09:36 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bioquest`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admin_id` varchar(50) NOT NULL,
  `auth_code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `admin_id`, `auth_code`) VALUES
(1, 'd587f39fa514a8b9b227a6bdba0aa86c', '123');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_logs`
--

DROP TABLE IF EXISTS `tbl_admin_logs`;
CREATE TABLE IF NOT EXISTS `tbl_admin_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `activity_logs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `admin_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_admin_logs`
--

INSERT INTO `tbl_admin_logs` (`id`, `activity_logs`, `admin_id`) VALUES
(1, 'You logged in on December 18, 2023 | Monday - 09 :', 1),
(2, 'You logged in on December 18, 2023 | Monday - 09 : 21 : 09 am ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_auth`
--

DROP TABLE IF EXISTS `tbl_auth`;
CREATE TABLE IF NOT EXISTS `tbl_auth` (
  `id` int NOT NULL AUTO_INCREMENT,
  `auth` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_auth`
--

INSERT INTO `tbl_auth` (`id`, `auth`) VALUES
(1, 'NONESCOST_2023');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quiz`
--

DROP TABLE IF EXISTS `tbl_quiz`;
CREATE TABLE IF NOT EXISTS `tbl_quiz` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year_level` int NOT NULL,
  `section_id` int NOT NULL,
  `room_number` int NOT NULL,
  `direction` text NOT NULL,
  `item_number` int NOT NULL,
  `question` text NOT NULL,
  `choice1` text NOT NULL,
  `choice2` text NOT NULL,
  `choice3` text NOT NULL,
  `choice4` text NOT NULL,
  `correct_answer` text NOT NULL,
  `teacher_id` int NOT NULL,
  `created_at` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `updated_at` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_quiz`
--

INSERT INTO `tbl_quiz` (`id`, `year_level`, `section_id`, `room_number`, `direction`, `item_number`, `question`, `choice1`, `choice2`, `choice3`, `choice4`, `correct_answer`, `teacher_id`, `created_at`, `updated_at`) VALUES
(61, 2, 2, 111, 'qwerty', 2, 'q2', 'aaa', 'sss', 'ddd', 'fff', 'sss', 1, 'December 18, 2023 | Monday - 11 : 41 : 46 am', ''),
(60, 2, 2, 111, 'qwerty', 1, 'q1?', 'qq', 'ww', 'ee', 'rr', 'rr', 1, 'December 18, 2023 | Monday - 11 : 29 : 01 am', 'December 18, 2023 | Monday - 11:40:05 am');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quiz_ranking`
--

DROP TABLE IF EXISTS `tbl_quiz_ranking`;
CREATE TABLE IF NOT EXISTS `tbl_quiz_ranking` (
  `id` int NOT NULL AUTO_INCREMENT,
  `room_number` int NOT NULL,
  `score` int NOT NULL,
  `student_id` int NOT NULL,
  `img_url` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_quiz_ranking`
--

INSERT INTO `tbl_quiz_ranking` (`id`, `room_number`, `score`, `student_id`, `img_url`) VALUES
(29, 111, 2, 11, 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quiz_student`
--

DROP TABLE IF EXISTS `tbl_quiz_student`;
CREATE TABLE IF NOT EXISTS `tbl_quiz_student` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `room_number` int NOT NULL,
  `direction` text NOT NULL,
  `item_number` int NOT NULL,
  `question` text NOT NULL,
  `choice1` text NOT NULL,
  `choice2` text NOT NULL,
  `choice3` text NOT NULL,
  `choice4` text NOT NULL,
  `correct_answer` text NOT NULL,
  `student_answer` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=183 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_quiz_student`
--

INSERT INTO `tbl_quiz_student` (`id`, `student_id`, `room_number`, `direction`, `item_number`, `question`, `choice1`, `choice2`, `choice3`, `choice4`, `correct_answer`, `student_answer`) VALUES
(182, 11, 111, 'qwerty', 1, 'q1?', 'qq', 'ww', 'ee', 'rr', 'rr', 'rr'),
(181, 11, 111, 'qwerty', 2, 'q2', 'aaa', 'sss', 'ddd', 'fff', 'sss', 'sss');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

DROP TABLE IF EXISTS `tbl_section`;
CREATE TABLE IF NOT EXISTS `tbl_section` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_section`
--

INSERT INTO `tbl_section` (`id`, `section`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

DROP TABLE IF EXISTS `tbl_student`;
CREATE TABLE IF NOT EXISTS `tbl_student` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `student_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `year_level` int NOT NULL,
  `section` int NOT NULL,
  `img_url` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `year_level` (`year_level`),
  KEY `section` (`section`),
  KEY `section_2` (`section`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`id`, `email`, `student_id`, `password`, `firstname`, `middlename`, `lastname`, `year_level`, `section`, `img_url`, `created_at`) VALUES
(11, 'ronil@gmail.com', 'ronil', 'd587f39fa514a8b9b227a6bdba0aa86c', 'Ronil', '', '', 2, 2, 'default.jpg', 'November 29, 2023 | Wednesday - 12 : 16 : 48 am'),
(1, 'jelly@gmail.com', 'jelly', '328356824c8487cf314aa350d11ae145', 'Jelly', 'Mendoza', 'Romagos', 2, 2, 'default.jpg', 'November 28, 2023 | Tuesday - 09 : 43 : 13 pm'),
(2, 'grace@gmail.com', 'grace', '15e5c87b18c1289d45bb4a72961b58e8', 'Ivy Grace', '', 'Sayam', 2, 2, 'default.jpg', 'November 28, 2023 | Tuesday - 11 : 11 : 18 pm');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_logs`
--

DROP TABLE IF EXISTS `tbl_student_logs`;
CREATE TABLE IF NOT EXISTS `tbl_student_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `activity_logs` varchar(255) NOT NULL,
  `student_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_student_logs`
--

INSERT INTO `tbl_student_logs` (`id`, `activity_logs`, `student_id`) VALUES
(73, 'You logged out on November 28, 2023 | Tuesday - 10 : 36 : 45 pm ', 3),
(74, 'You logged in on November 28, 2023 | Tuesday - 10 : 36 : 58 pm ', 2),
(75, 'You logged out on November 28, 2023 | Tuesday - 10 : 38 : 13 pm ', 2),
(76, 'You logged in on November 28, 2023 | Tuesday - 10 : 38 : 20 pm ', 1),
(77, 'You logged out on November 28, 2023 | Tuesday - 10 : 39 : 12 pm ', 1),
(78, 'You logged in on November 28, 2023 | Tuesday - 10 : 52 : 26 pm ', 1),
(79, 'You logged out on November 28, 2023 | Tuesday - 10 : 57 : 00 pm ', 1),
(80, 'You logged in on November 28, 2023 | Tuesday - 10 : 59 : 24 pm ', 1),
(81, 'You logged in on November 28, 2023 | Tuesday - 11 : 00 : 39 pm ', 1),
(82, 'You logged out on November 28, 2023 | Tuesday - 11 : 03 : 08 pm ', 1),
(83, 'You logged in on November 28, 2023 | Tuesday - 11 : 03 : 37 pm ', 1),
(84, 'You logged out on November 28, 2023 | Tuesday - 11 : 05 : 58 pm ', 1),
(85, 'You logged in on November 28, 2023 | Tuesday - 11 : 08 : 36 pm ', 1),
(86, 'You logged out on November 28, 2023 | Tuesday - 11 : 11 : 04 pm ', 1),
(87, 'You logged in on November 28, 2023 | Tuesday - 11 : 11 : 22 pm ', 10),
(88, 'You logged out on November 28, 2023 | Tuesday - 11 : 37 : 58 pm ', 10),
(89, 'You logged in on November 28, 2023 | Tuesday - 11 : 38 : 09 pm ', 1),
(90, 'You logged out on November 28, 2023 | Tuesday - 11 : 43 : 12 pm ', 1),
(91, 'You logged in on November 28, 2023 | Tuesday - 11 : 44 : 36 pm ', 1),
(92, 'You logged in on November 28, 2023 | Tuesday - 11 : 54 : 44 pm ', 1),
(93, 'You logged out on November 28, 2023 | Tuesday - 11 : 58 : 29 pm ', 1),
(94, 'You logged in on November 29, 2023 | Wednesday - 12 : 05 : 13 am ', 1),
(95, 'You logged out on November 29, 2023 | Wednesday - 12 : 05 : 53 am ', 1),
(96, 'You logged in on November 29, 2023 | Wednesday - 12 : 14 : 01 am ', 2),
(97, 'You logged out on November 29, 2023 | Wednesday - 12 : 16 : 36 am ', 2),
(98, 'You logged in on November 29, 2023 | Wednesday - 12 : 17 : 03 am ', 11),
(99, 'You logged out on November 29, 2023 | Wednesday - 12 : 48 : 18 am ', 1),
(100, 'You logged in on November 29, 2023 | Wednesday - 12 : 49 : 06 am ', 2),
(101, 'You logged out on November 29, 2023 | Wednesday - 12 : 59 : 52 am ', 2),
(102, 'You logged in on November 29, 2023 | Wednesday - 01 : 00 : 06 am ', 11),
(103, 'You logged out on November 29, 2023 | Wednesday - 01 : 15 : 20 am ', 11),
(104, 'You logged in on December 13, 2023 | Wednesday - 03 : 15 : 35 pm ', 11),
(105, 'You logged in on December 15, 2023 | Friday - 08 : 12 : 00 am ', 11),
(106, 'You logged out on December 15, 2023 | Friday - 08 : 18 : 18 am ', 11),
(107, 'You logged in on December 15, 2023 | Friday - 08 : 18 : 23 am ', 1),
(108, 'You logged out on December 15, 2023 | Friday - 08 : 27 : 21 am ', 1),
(109, 'You logged in on December 15, 2023 | Friday - 08 : 27 : 30 am ', 11),
(110, 'You logged out on December 15, 2023 | Friday - 08 : 38 : 57 am ', 11),
(111, 'You logged in on December 15, 2023 | Friday - 08 : 39 : 04 am ', 1),
(112, 'You logged in on December 15, 2023 | Friday - 09 : 35 : 20 am ', 11),
(113, 'You logged in on December 15, 2023 | Friday - 09 : 55 : 31 am ', 11),
(114, 'You logged in on December 15, 2023 | Friday - 10 : 04 : 39 am ', 11),
(115, 'You logged out on December 15, 2023 | Friday - 10 : 04 : 50 am ', 11),
(116, 'You logged in on December 15, 2023 | Friday - 10 : 05 : 08 am ', 11),
(117, 'You logged out on December 15, 2023 | Friday - 10 : 52 : 40 am ', 11),
(118, 'You logged in on December 15, 2023 | Friday - 10 : 53 : 27 am ', 11),
(119, 'You logged out on December 15, 2023 | Friday - 10 : 54 : 14 am ', 11),
(120, 'You logged in on December 15, 2023 | Friday - 11 : 03 : 45 am ', 11),
(121, 'You logged in on December 15, 2023 | Friday - 11 : 06 : 57 am ', 11),
(122, 'You logged out on December 15, 2023 | Friday - 11 : 13 : 42 am ', 11),
(123, 'You logged in on December 15, 2023 | Friday - 11 : 13 : 53 am ', 11),
(124, 'You logged out on December 15, 2023 | Friday - 11 : 48 : 26 am ', 11),
(125, 'You logged in on December 15, 2023 | Friday - 11 : 48 : 33 am ', 11),
(126, 'You logged in on December 15, 2023 | Friday - 01 : 26 : 59 pm ', 11),
(127, 'You logged out on December 15, 2023 | Friday - 02 : 44 : 54 pm ', 11),
(128, 'You logged in on December 15, 2023 | Friday - 02 : 45 : 03 pm ', 11),
(129, 'You logged in on December 15, 2023 | Friday - 04 : 16 : 22 pm ', 11),
(130, 'You logged out on December 15, 2023 | Friday - 04 : 45 : 26 pm ', 11),
(131, 'You logged in on December 15, 2023 | Friday - 04 : 46 : 06 pm ', 11),
(132, 'You logged out on December 15, 2023 | Friday - 04 : 46 : 15 pm ', 11),
(133, 'You logged in on December 15, 2023 | Friday - 05 : 01 : 16 pm ', 11),
(134, 'You logged in on December 18, 2023 | Monday - 09 : 22 : 12 am ', 11),
(135, 'You logged out on December 18, 2023 | Monday - 09 : 41 : 43 am ', 11),
(136, 'You logged in on December 18, 2023 | Monday - 11 : 48 : 37 am ', 11),
(137, 'You logged in on December 18, 2023 | Monday - 12 : 56 : 40 pm ', 11),
(138, 'You logged out on December 18, 2023 | Monday - 01 : 49 : 36 pm ', 11);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_topics`
--

DROP TABLE IF EXISTS `tbl_sub_topics`;
CREATE TABLE IF NOT EXISTS `tbl_sub_topics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `topic_id` int NOT NULL,
  `lesson_number` varchar(50) NOT NULL,
  `lesson_title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `section_title` varchar(255) NOT NULL,
  `discussion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `teacher_id` int NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `updated_at` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_sub_topics`
--

INSERT INTO `tbl_sub_topics` (`id`, `topic_id`, `lesson_number`, `lesson_title`, `section_title`, `discussion`, `teacher_id`, `created_at`, `updated_at`) VALUES
(23, 17, '1', 'test2', 'Body', 'qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm,', 6, 'November 16, 2023 | Thursday - 10 : 56 : 54 pm', ''),
(22, 17, '1', 'test1', 'Intro', 'qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm,', 6, 'November 16, 2023 | Thursday - 10 : 56 : 54 pm', ''),
(24, 17, '1', 'test3', 'Summary', 'qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm, qwertyuiop asdfghjkl zxcvbnm,', 6, 'November 16, 2023 | Thursday - 10 : 56 : 54 pm', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher`
--

DROP TABLE IF EXISTS `tbl_teacher`;
CREATE TABLE IF NOT EXISTS `tbl_teacher` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `img_url` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `year_level` int NOT NULL,
  `section` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_teacher`
--

INSERT INTO `tbl_teacher` (`id`, `email`, `username`, `password`, `firstname`, `middlename`, `lastname`, `img_url`, `created_at`, `year_level`, `section`) VALUES
(1, 'teacher1@test.com', 'teacher1', '41c8949aa55b8cb5dbec662f34b62df3', 'Juan', '', 'Dela Cruz', 'default.jpg', 'October 22, 2023 | Sunday - 08 : 55 : 51 pm', 2, 2),
(2, 'teacher2@test.com', 'teacher2', 'ccffb0bb993eeb79059b31e1611ec353', 'first_name', 'middle_name', 'last_name', 'default.jpg', 'October 24, 2023 | Tuesday - 09 : 00 : 25 pm', 0, 0),
(3, 'teacher3@test.com', 'teacher3', '82470256ea4b80343b27afccbca1015b', 'first_name', 'middle_name', 'last_name', 'default.jpg', 'October 26, 2023 | Thursday - 08 : 49 : 34 pm', 0, 0),
(4, 'teacher4@teacher4.com', 'teacher4', '93dacda950b1dd917079440788af3321', 'first_name', 'middle_name', 'last_name', 'default.jpg', 'November 6, 2023 | Monday - 07 : 13 : 53 pm', 0, 0),
(6, 'teacher5@teacher5.com', 'teacher5', 'ea105f0d381e790cdadc6a41eb611c77', 'first_name', 'middle_name', 'last_name', 'default.jpg', 'November 16, 2023 | Thursday - 10 : 46 : 35 pm', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher_logs`
--

DROP TABLE IF EXISTS `tbl_teacher_logs`;
CREATE TABLE IF NOT EXISTS `tbl_teacher_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `activity_logs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `teacher_id` int NOT NULL,
  `account_status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_teacher_logs`
--

INSERT INTO `tbl_teacher_logs` (`id`, `activity_logs`, `teacher_id`, `account_status`) VALUES
(62, 'You logged in on November 28, 2023 | Tuesday - 10 : 39 : 21 pm ', 1, ''),
(63, 'You logged out on November 28, 2023 | Tuesday - 10 : 52 : 16 pm ', 1, ''),
(64, 'You logged in on November 28, 2023 | Tuesday - 10 : 57 : 07 pm ', 1, ''),
(65, 'You logged out on November 28, 2023 | Tuesday - 10 : 59 : 18 pm ', 1, ''),
(66, 'You logged in on November 28, 2023 | Tuesday - 11 : 06 : 06 pm ', 1, ''),
(67, 'You logged out on November 28, 2023 | Tuesday - 11 : 08 : 22 pm ', 1, ''),
(68, 'You logged in on November 28, 2023 | Tuesday - 11 : 43 : 19 pm ', 1, ''),
(69, 'You logged out on November 28, 2023 | Tuesday - 11 : 44 : 20 pm ', 1, ''),
(70, 'You logged in on November 28, 2023 | Tuesday - 11 : 58 : 35 pm ', 1, ''),
(71, 'You logged out on November 29, 2023 | Wednesday - 12 : 05 : 03 am ', 1, ''),
(72, 'You logged in on November 29, 2023 | Wednesday - 12 : 06 : 00 am ', 1, ''),
(73, 'You logged out on November 29, 2023 | Wednesday - 12 : 13 : 55 am ', 1, ''),
(74, 'You logged in on November 29, 2023 | Wednesday - 01 : 15 : 26 am ', 1, ''),
(75, 'You logged out on November 29, 2023 | Wednesday - 01 : 15 : 40 am ', 1, ''),
(76, 'You logged in on December 18, 2023 | Monday - 09 : 41 : 54 am ', 1, ''),
(77, 'You logged in on December 18, 2023 | Monday - 09 : 51 : 27 am ', 1, ''),
(78, 'You logged in on December 18, 2023 | Monday - 09 : 54 : 17 am ', 1, ''),
(79, 'You logged out on December 18, 2023 | Monday - 11 : 48 : 30 am ', 1, ''),
(80, 'You logged in on December 18, 2023 | Monday - 01 : 49 : 52 pm ', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_topics`
--

DROP TABLE IF EXISTS `tbl_topics`;
CREATE TABLE IF NOT EXISTS `tbl_topics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `topic_title` varchar(50) NOT NULL,
  `filename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `filepath` varchar(50) NOT NULL,
  `teacher_id` int NOT NULL,
  `created_at` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_topics`
--

INSERT INTO `tbl_topics` (`id`, `topic_title`, `filename`, `filepath`, `teacher_id`, `created_at`) VALUES
(15, 'Genetics', '', '', 1, 'November 15, 2023 | Wednesday - 09 : 45 : 10 pm'),
(14, 'Cell Biology', '', '', 1, 'November 15, 2023 | Wednesday - 09 : 45 : 00 pm'),
(16, 'Evolutionary Biology', '', '', 1, 'November 15, 2023 | Wednesday - 09 : 45 : 18 pm'),
(17, 'Ecology', '', '', 1, 'November 15, 2023 | Wednesday - 09 : 45 : 25 pm');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_year_level`
--

DROP TABLE IF EXISTS `tbl_year_level`;
CREATE TABLE IF NOT EXISTS `tbl_year_level` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year_level` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_year_level`
--

INSERT INTO `tbl_year_level` (`id`, `year_level`) VALUES
(1, '1st year'),
(2, '2nd year'),
(3, '3rd year'),
(4, '4th year'),
(5, '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
