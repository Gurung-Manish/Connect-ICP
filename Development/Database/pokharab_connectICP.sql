-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 19, 2021 at 05:43 AM
-- Server version: 10.3.29-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pokharab_connectICP`
--

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `donation_id` int(11) NOT NULL COMMENT 'I holds the ID number of the donation.',
  `unique_id` varchar(255) NOT NULL COMMENT 'It holds the unique id of the user.',
  `donation_amount` decimal(7,2) NOT NULL COMMENT 'It holds the total donation amount.',
  `remarks` varchar(1000) NOT NULL COMMENT 'It holds the remarks for the donation.',
  `payment_method` varchar(50) NOT NULL COMMENT 'It holds the method of payment.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`donation_id`, `unique_id`, `donation_amount`, `remarks`, `payment_method`) VALUES
(2, '45d703286bd89196f8fb72f6ab27b227', 10.00, 'Best wishes', 'khalti'),
(3, '45d703286bd89196f8fb72f6ab27b227', 50.00, 'adgsdg', 'Khalti'),
(4, '45d703286bd89196f8fb72f6ab27b227', 100.00, 'Hello', 'Khalti'),
(5, 'ca2446d675f105bcb8541af5413db756', 10.00, 'Best of luck for FYP!', 'Khalti');

-- --------------------------------------------------------

--
-- Table structure for table `followTable`
--

CREATE TABLE `followTable` (
  `follow_id` int(11) NOT NULL COMMENT 'It holds the Follow Id number.',
  `user_id` varchar(255) NOT NULL COMMENT 'It holds the ID number of the user.',
  `following_id` varchar(255) NOT NULL COMMENT 'It holds the Id of the user to be followed.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followTable`
--

INSERT INTO `followTable` (`follow_id`, `user_id`, `following_id`) VALUES
(7, '45d703286bd89196f8fb72f6ab27b227', 'ca2446d675f105bcb8541af5413db756'),
(13, 'ca2446d675f105bcb8541af5413db756', 'ca2446d675f105bcb8541af5413db756'),
(18, '170505049e623c71d62d6cc2169ba085', 'ca2446d675f105bcb8541af5413db756');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL COMMENT 'It holds the Id number of the liked post.',
  `post_id` int(11) NOT NULL COMMENT 'It holds the Id number of the post.',
  `unique_id` varchar(255) NOT NULL COMMENT 'It holds the unique id of the user.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `post_id`, `unique_id`) VALUES
(18, 20, 'ca2446d675f105bcb8541af5413db756'),
(19, 20, '3f72c65182943c08e590aefecc161359'),
(20, 19, 'ca2446d675f105bcb8541af5413db756'),
(21, 20, '45d703286bd89196f8fb72f6ab27b227'),
(22, 19, '45d703286bd89196f8fb72f6ab27b227'),
(24, 17, '45d703286bd89196f8fb72f6ab27b227'),
(25, 18, '45d703286bd89196f8fb72f6ab27b227'),
(26, 22, 'ca2446d675f105bcb8541af5413db756'),
(29, 23, '170505049e623c71d62d6cc2169ba085'),
(31, 18, 'ca2446d675f105bcb8541af5413db756');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL COMMENT 'It holds the ID number of post.',
  `post_description` varchar(1000) DEFAULT NULL COMMENT 'It holds the description of the post.',
  `post_image` varchar(255) DEFAULT NULL COMMENT 'It holds the url of the post picture.',
  `post_last_updated` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'It holds the date of the post updated.',
  `post_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'It holds the date of post.',
  `unique_id` varchar(255) NOT NULL COMMENT 'It holds the unique id of the user.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `post_description`, `post_image`, `post_last_updated`, `post_date`, `unique_id`) VALUES
(17, 'teacher try 1', '', '2021-03-31 09:43:37', '2021-03-31 09:43:37', '3f72c65182943c08e590aefecc161359'),
(18, 'student try post 1', '', '2021-03-31 09:44:31', '2021-03-31 09:44:31', '3f72c65182943c08e590aefecc161359'),
(19, 'student try post 1', '', '2021-03-31 09:46:24', '2021-03-31 09:46:24', 'ca2446d675f105bcb8541af5413db756'),
(20, 'my new post', '', '2021-04-04 10:32:36', '2021-04-04 10:32:36', 'ca2446d675f105bcb8541af5413db756'),
(21, 'anish new post. hello im new here', '', '2021-04-07 06:31:46', '2021-04-07 06:31:46', '45d703286bd89196f8fb72f6ab27b227'),
(22, 'fh gdgvdbdhdh hhbdbdhhd badri shambles tttryt vccgxc. \n', '', '2021-04-08 03:56:41', '2021-04-08 03:56:41', 'ab8e5b2c8b284fc9f52609b8aa594378'),
(23, 'Today I am testing the post feature.', '', '2021-04-10 16:21:09', '2021-04-10 16:21:09', 'ca2446d675f105bcb8541af5413db756'),
(25, 'with photo\n', 'https://www.gurungmanish.com.np/postPictures/2021/04/IMG_20200926_150727_1617178056862_1619251898_ca2446d675f105bcb8541af5413db756.jpg', '2021-04-24 09:11:38', '2021-04-24 09:11:38', 'ca2446d675f105bcb8541af5413db756');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL COMMENT 'It holds the Id number of the schedule.',
  `subject` varchar(4) NOT NULL COMMENT 'It holds the name of the subject.',
  `day` varchar(10) NOT NULL COMMENT 'It holds the day of the classes.',
  `time` varchar(20) NOT NULL COMMENT 'It holds the time of the classes.',
  `class_type` varchar(20) NOT NULL COMMENT 'It holds the type of the class.',
  `module_code` varchar(10) NOT NULL COMMENT 'It holds the code of the module. ',
  `module_title` varchar(100) NOT NULL COMMENT 'It holds the title of the module.',
  `lecturer` varchar(100) NOT NULL COMMENT 'It holds the name of the lecturer.',
  `year` varchar(4) NOT NULL COMMENT 'It holds the year.',
  `section` varchar(4) NOT NULL COMMENT 'It holds the name of the section.'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `subject`, `day`, `time`, `class_type`, `module_code`, `module_title`, `lecturer`, `year`, `section`) VALUES
(1, 'BIT', 'SUN', '7-8:30 AM', 'Lecture', 'CS6004NP', 'Application Development', 'Sachin Subdedi', '3', 'C1'),
(2, 'BIT', 'SUN', '7-8:30 AM', 'Lecture', 'CS6004NP', 'Application Development', 'Sachin Subdedi', '3', 'C2'),
(3, 'BIT', 'SUN', '7-8:30 AM', 'Lecture', 'CC6001NP', 'Advanced Database Systems', 'Pratibha Gurung', '3', 'C3'),
(4, 'BIT', 'SUN', '7-8:30 AM', 'Lecture', 'CC6001NP', 'Advanced Database Systems', 'Pratibha Gurung', '3', 'C4'),
(5, 'BIT', 'SUN', '8:30-10 AM', 'Lecture', 'CU6051NP', 'Artificial Intelligence', 'Sushil Paudel', '3', 'C1'),
(7, 'BIT', 'MON', '8:30-10 AM', 'Lecture', 'CS6004NP', 'Application Development', 'Sachin Subedi', '3', 'C3'),
(6, 'BIT', 'SUN', '8:30-10 AM', 'Lecture', 'CU6051NP', 'Artificial Intelligence', 'Sushil Paudel', '3', 'C2'),
(9, 'BIT', 'MON', '8:30-10 AM', 'Lecture', 'CS6004NP', 'Application Development', 'Sachin Subedi', '3', 'C4'),
(10, 'BIT', 'MON', '7-8:30 AM', 'Lecture', 'CC6001NP', 'Advanced Database Systems', 'Pratibha Gurung', '3', 'C1'),
(11, 'BIT', 'MON', '7-8:30 AM', 'Lecture', 'CC6001NP', 'Advanced Database Systems', 'Pratibha Gurung', '3', 'C2'),
(12, 'BIT', 'FRI', '8:30-10 AM', 'Workshop', 'CU6051NP', 'Artificial Intelligence', 'Sushil Paudel', '3', 'C2'),
(13, 'BBA', 'TUE', '8-9:30 AM', 'Tutorial', 'MC5051NP', 'Brand Management', 'Bibek Shrestha', '3', 'B1'),
(14, 'BBA', 'TUE', '10-11:30 AM', 'Tutorial', 'MC5055NP', 'Digital Marketing', 'Bipul Raj Manandhar', '3', 'M1'),
(15, 'BBA', 'THU', '10:30-12:30 PM', 'Tutorial', 'AC5002NP', 'Management Accounting', 'Samjhana Gorkhali', '3', 'F1'),
(16, 'BBA', 'MON', '10:30-12:30 PM', 'Lecture', 'AC5001NP', 'International Financial Reporting', 'Sinja Poudyal', '3', 'F1'),
(17, 'BBA', 'FRI', '10:30-12 PM', 'Workshop', 'MN6P00NP', 'Management Investigation and Dissertation', 'Arjun Sapkota', '3', 'B1'),
(18, 'BBA', 'FRI', '1-2:30 PM', 'Workshop', 'MN6003NP', 'Strategy: Choices and Change', 'Nabin Raj Pandit', '3', 'B1'),
(19, 'BIT', 'FRI', '2-3 PM', 'Tutorial', 'CC6001NP', 'Advance Database', 'Pratibha Gurung', '3', 'C1');

-- --------------------------------------------------------

--
-- Table structure for table `staff_user`
--

CREATE TABLE `staff_user` (
  `staff_id` int(11) NOT NULL COMMENT 'I holds the ID number of the staff user..',
  `email` varchar(100) NOT NULL COMMENT 'It holds the email Id of the staff user.',
  `full_name` varchar(100) NOT NULL COMMENT 'It holds the full_name of the staff user.',
  `password` text NOT NULL COMMENT 'It holds the password of the staff user.',
  `subject1` varchar(100) DEFAULT NULL COMMENT 'It holds the subject name of the first subject of staff.',
  `subject2` varchar(100) DEFAULT NULL COMMENT 'It holds the subject name of the second subject of staff.',
  `subject3` varchar(100) DEFAULT NULL COMMENT 'It holds the subject name of the third subject of staff.',
  `api_key` varchar(32) NOT NULL COMMENT 'It holds the api key of the staff user. ',
  `is_staff` tinyint(1) DEFAULT 1 COMMENT 'It holds the value to check if the user is staff or not.',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'It holds the date of staff user creation.',
  `profile_pic` varchar(255) DEFAULT NULL COMMENT 'It holds the url of the profile picture of the staff.',
  `unique_id` varchar(255) NOT NULL COMMENT 'It holds the unique id of the staff user.'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_user`
--

INSERT INTO `staff_user` (`staff_id`, `email`, `full_name`, `password`, `subject1`, `subject2`, `subject3`, `api_key`, `is_staff`, `created_at`, `profile_pic`, `unique_id`) VALUES
(1, 'g.manish007.mg@gmail.com', 'Manish Gurung teacher', '$2a$10$54187700ffaeaba01c62euTEFa3fxid3pIGIw3UAZZrps04DvnICa', 'java', 'java 2', 'java 3', '86ec98f781004bdfefbbd64eb26b383f', 1, '2021-03-31 08:42:34', 'https://gurungmanish.com.np/postPictures/defaultuser.jpg', '3f72c65182943c08e590aefecc161359'),
(2, 'badri.lamichhane@icp.edu.np', 'Badri Lamichhane', '$2a$10$8e7b7bb0b3347653ed86ceLsUntHzEy5JUaUzbBHHMwWaE2mBeK.W', NULL, NULL, NULL, 'babcaf0a22b4fa8b735c1b9b20c757af', 1, '2021-04-08 02:54:41', 'https://gurungmanish.com.np/postPictures/defaultuser.jpg', 'ab8e5b2c8b284fc9f52609b8aa594378'),
(3, 'samir.baniya1048@gmail.com', 'Samir Baniya', '$2a$10$a18cb60ea5315797d4de8up.U2084VIMLISplcs/buybp7DUmUfYe', 'Java', NULL, NULL, '5cfe8d2f501d111bc97e3d955b240f77', 1, '2021-04-10 14:53:18', 'https://gurungmanish.com.np/postPictures/defaultuser.jpg', '2dd834b6193db5946323c0e04333d512'),
(4, '123aneetachhetri@gmail.com', 'Anita Chhetri', '$2a$10$ab6cff0c465831ee8916butfUKNoYKEuxpmaHBuPrx5D.vYq9u4mi', 'Introduction to Android', 'Advanced Android Development', NULL, 'ce7ea7fbf5d3f2f41bd257a47994e45f', 1, '2021-04-12 09:26:11', 'https://gurungmanish.com.np/postPictures/defaultuser.jpg', 'c39e84191ec2d3e65c8f3d130b9cb085');

-- --------------------------------------------------------

--
-- Table structure for table `student_user`
--

CREATE TABLE `student_user` (
  `student_id` int(11) NOT NULL COMMENT 'It holds the ID number of the student.',
  `email` varchar(100) NOT NULL COMMENT 'It holds the email Id of the student.',
  `full_name` varchar(100) NOT NULL COMMENT 'It holds the full name of the student.',
  `password` text NOT NULL COMMENT 'It holds the password of the student..',
  `subject` varchar(5) NOT NULL COMMENT 'It holds the subject of the student..',
  `year` varchar(5) NOT NULL COMMENT 'It holds the current year of the student.',
  `section` varchar(5) NOT NULL COMMENT 'It holds the section of the user.',
  `api_key` varchar(32) NOT NULL COMMENT 'It holds the api key of the student ',
  `is_staff` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'It holds the value to check if the user is staff or not.',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'It holds the date of the student creation.',
  `profile_pic` varchar(255) DEFAULT 'https://www.gurungmanish.com.np/postPictures/defaultuser.jpg' COMMENT 'It holds the Url of the students profile picture.',
  `unique_id` varchar(255) NOT NULL COMMENT 'It holds the unique id of the user.'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_user`
--

INSERT INTO `student_user` (`student_id`, `email`, `full_name`, `password`, `subject`, `year`, `section`, `api_key`, `is_staff`, `created_at`, `profile_pic`, `unique_id`) VALUES
(1, 'mg@gmail.com', 'Manish Gurung 2', '$2a$10$84c437884521e2d8c6bcdetzcRR6.H6m8Un6d94YHo3bA.rRcHcTq', 'BIT', '3', 'C1', 'e6822f43f14e9c6b8e649e899fd45967', 0, '2021-03-31 08:44:12', 'https://www.gurungmanish.com.np/postPictures/2021/03/IMG_20200513_095717_1617182626_ca2446d675f105bcb8541af5413db756.jpg', 'ca2446d675f105bcb8541af5413db756'),
(2, 'ag@gmail.com', 'Anish Gurung', '$2a$10$416a86aa337c6c27aff0bOaKsq9x.hn6Z8rssWzhuQtLyXn/ugdfW', 'BIT', '3', 'C2', 'dc6ea2973fa080563e49e998aa6009c8', 0, '2021-04-07 05:15:30', 'https://gurungmanish.com.np/postPictures/defaultuser.jpg', '45d703286bd89196f8fb72f6ab27b227'),
(3, 'anmol@gmail.com', 'Anmol Jung Baral', '$2a$10$88cd148b8a00bdbd06775uFhNA9ULxI1QIQKgeL747wfOtLITtCbW', 'BBA', '3', 'F1', '331ce41f22f184e2a346dc9155b01c2b', 0, '2021-04-12 09:32:53', 'https://www.gurungmanish.com.np/postPictures/2021/04/IMG_20210412_161512_1618223459_170505049e623c71d62d6cc2169ba085.jpg', '170505049e623c71d62d6cc2169ba085');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`donation_id`);

--
-- Indexes for table `followTable`
--
ALTER TABLE `followTable`
  ADD PRIMARY KEY (`follow_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_user`
--
ALTER TABLE `staff_user`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_user`
--
ALTER TABLE `student_user`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'I holds the ID number of the donation.', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `followTable`
--
ALTER TABLE `followTable`
  MODIFY `follow_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'It holds the Follow Id number.', AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'It holds the Id number of the liked post.', AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'It holds the ID number of post.', AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'It holds the Id number of the schedule.', AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `staff_user`
--
ALTER TABLE `staff_user`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'I holds the ID number of the staff user..', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student_user`
--
ALTER TABLE `student_user`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'It holds the ID number of the student.', AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
