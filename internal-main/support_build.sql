-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: danfran77.com.customers.tigertech.net
-- Generation Time: Jan 19, 2022 at 06:00 PM
-- Server version: 10.5.12-MariaDB-1+tigertech2-log
-- PHP Version: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `support_build`
--

-- --------------------------------------------------------

--
-- Table structure for table `ContentType`
--

CREATE TABLE `ContentType` (
  `content_type_id` int(11) NOT NULL,
  `content_type` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`customer_id`, `first_name`, `last_name`, `email`, `phone_number`, `password`) VALUES
(1, 'Jon', 'Doe', 'jondoe@example.com', 2147483647, '$2y$10$ycE4oZjWMFZqMI.EFAjR9OPpwveB9guDE64HlHi9SwVki8oyhPh42'),
(2, 'Jane', 'Doe', 'janedoe@example.com', 2147483647, '$2y$10$gY30ttIqZTlOhhZj7Q5W0.wcijQFhI0tK8b8E0HPfn3AyQ8onUNdG');

-- --------------------------------------------------------

--
-- Table structure for table `Employee`
--

CREATE TABLE `Employee` (
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Employee`
--

INSERT INTO `Employee` (`employee_id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'Bill', 'Smith', 'bsmith@yourlocalhost.com', '$2y$10$I1mDoCzGMobnGiXdwnckDu9i8Orq1POJLOonOD.JYQqz8Hw6j7vkm');

-- --------------------------------------------------------

--
-- Table structure for table `Notification`
--

CREATE TABLE `Notification` (
  `notification_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `notification_type` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `seen` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Notification`
--

INSERT INTO `Notification` (`notification_id`, `ticket_id`, `created`, `notification_type`, `employee_id`, `customer_id`, `seen`) VALUES
(1, 10, '2021-11-14 00:51:25', 2, 1, 1, 1),
(2, 10, '2021-11-14 00:55:37', 1, 1, 1, 1),
(3, 13, '2021-11-14 14:42:30', 1, 1, 2, 1),
(4, 13, '2021-11-14 14:43:28', 2, 1, 2, 1),
(5, 14, '2021-11-14 20:44:00', 1, 1, 1, 1),
(6, 6, '2021-11-14 20:57:50', 1, 1, 1, 0),
(7, 3, '2021-11-14 20:59:44', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `NotificationType`
--

CREATE TABLE `NotificationType` (
  `notificationtype_id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `NotificationType`
--

INSERT INTO `NotificationType` (`notificationtype_id`, `description`) VALUES
(1, 'Notification indicating a reply has been made by a YourLocalHost employee'),
(2, 'Notification indicating a file upload has been requested.');

-- --------------------------------------------------------

--
-- Table structure for table `Priority`
--

CREATE TABLE `Priority` (
  `priority_id` int(11) NOT NULL,
  `priority` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Priority`
--

INSERT INTO `Priority` (`priority_id`, `priority`) VALUES
(1, 'Low'),
(2, 'Medium'),
(3, 'High');

-- --------------------------------------------------------

--
-- Table structure for table `Queue`
--

CREATE TABLE `Queue` (
  `queue_id` int(11) NOT NULL,
  `queue` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Queue`
--

INSERT INTO `Queue` (`queue_id`, `queue`) VALUES
(1, 'Support'),
(2, 'Billing'),
(3, 'Sales');

-- --------------------------------------------------------

--
-- Table structure for table `Status`
--

CREATE TABLE `Status` (
  `status_id` int(11) NOT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Status`
--

INSERT INTO `Status` (`status_id`, `status`) VALUES
(1, 'Open'),
(2, 'Closed'),
(3, 'Resolved');

-- --------------------------------------------------------

--
-- Table structure for table `Ticket`
--

CREATE TABLE `Ticket` (
  `ticket_id` int(11) NOT NULL,
  `opened` datetime NOT NULL DEFAULT current_timestamp(),
  `subject` varchar(35) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `priority_id` int(11) NOT NULL DEFAULT 1,
  `queue_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Ticket`
--

INSERT INTO `Ticket` (`ticket_id`, `opened`, `subject`, `customer_id`, `employee_id`, `status_id`, `priority_id`, `queue_id`) VALUES
(2, '2021-09-24 13:49:20', 'This is the first ticket test', 1, NULL, 1, 1, 1),
(3, '2021-09-26 14:00:24', 'Login Test 2', 1, NULL, 1, 1, 1),
(5, '2021-09-26 14:16:01', 'Test 3', 1, NULL, 1, 1, 1),
(6, '2021-09-26 14:32:57', 'Test 4', 1, NULL, 1, 1, 1),
(7, '2021-09-26 14:39:01', 'Testing employee ticket submission', 1, NULL, 1, 1, 1),
(8, '2021-09-26 18:57:25', 'Test ticket', 1, NULL, 1, 2, 2),
(9, '2021-09-26 19:25:21', 'Jane Doe Ticket', 2, NULL, 1, 3, 2),
(10, '2021-09-26 19:35:41', 'Test 6', 1, NULL, 1, 2, 3),
(11, '2021-10-16 13:47:05', 'Email Down', 1, NULL, 3, 1, 1),
(12, '2021-11-14 14:28:30', 'upload test ticket', 2, NULL, 3, 2, 1),
(13, '2021-11-14 14:38:50', 'upload test ticket', 2, NULL, 1, 3, 1),
(14, '2021-11-14 20:41:07', 'Email is down', 1, NULL, 3, 3, 1),
(15, '2021-11-14 20:49:48', 'Having prop with email', 1, NULL, 3, 3, 1),
(16, '2022-01-19 15:04:14', 'Test 2', 1, NULL, 1, 2, 2),
(17, '2022-01-19 15:42:26', 'Email', 1, NULL, 1, 1, 1),
(18, '2022-01-19 17:01:21', 'nre', 1, NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `TicketContent`
--

CREATE TABLE `TicketContent` (
  `content_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `content_type` int(11) NOT NULL,
  `content` text NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `TicketContent`
--

INSERT INTO `TicketContent` (`content_id`, `ticket_id`, `created`, `content_type`, `content`, `customer_id`, `employee_id`) VALUES
(1, 2, '2021-09-24 13:49:20', 1, 'Testing the functionality of submitting a ticket as customer.', 1, NULL),
(2, 2, '2021-09-25 00:49:09', 1, 'Testing if sending a reply sets ticket status to open and shows new reply.', 1, NULL),
(3, 2, '2021-09-25 00:52:54', 1, 'First test worked for reply, but did not work for setting the status to open. Testing again now.', 1, NULL),
(4, 2, '2021-09-25 13:33:47', 1, 'Testing first employee reply', NULL, 1),
(5, 3, '2021-09-26 14:00:24', 1, 'Second login test', 1, NULL),
(6, 4, '2021-09-26 14:00:52', 1, 'Second login test', 1, NULL),
(7, 3, '2021-09-26 14:03:38', 1, 'Awesome', NULL, 1),
(8, 5, '2021-09-26 14:16:01', 1, 'Test 3', 1, NULL),
(9, 6, '2021-09-26 14:32:57', 1, 'Test 4', 1, NULL),
(10, 7, '2021-09-26 14:39:01', 1, 'This is a test', NULL, NULL),
(11, 7, '2021-09-26 14:39:25', 1, 'testing employee reply', NULL, 1),
(12, 8, '2021-09-26 18:57:25', 1, 'video test ticket', 1, NULL),
(13, 8, '2021-09-26 18:57:49', 1, 'test reply', 1, NULL),
(14, 9, '2021-09-26 19:25:21', 1, 'Had a Billing issue with my account TEST', 2, NULL),
(15, 6, '2021-09-26 19:32:13', 1, 'Test 4 reply\r\n', NULL, 1),
(16, 10, '2021-09-26 19:35:41', 1, 'Test 6', NULL, NULL),
(17, 11, '2021-10-16 13:47:05', 1, 'hey', NULL, NULL),
(18, 5, '2021-10-17 17:28:28', 1, 'A file was uploaded with the description \"Screenshot of upload feature\" here https://support.danfran77.com/uploads/Screen Shot 2021-10-17 at 5.27.38 PM.png', 1, NULL),
(19, 5, '2021-10-17 17:30:00', 1, 'A file was uploaded with the description \"Second test, renaming it with spaces\" here https://support.danfran77.com/uploads/screenshot.png', 1, NULL),
(20, 5, '2021-10-17 17:33:42', 1, 'A file was uploaded with the description \"Third try, testing link within reply to uploaded file and renaming existing file.\" <a href=\"https://support.danfran77.com/uploads/screenshot.png\">here</a>', 1, NULL),
(21, 5, '2021-10-17 19:23:30', 1, 'A file was uploaded with the description \"4th test to remove html tags\" here: https://support.danfran77.com/uploads/screenshot2.png', 1, NULL),
(22, 8, '2021-10-17 20:05:17', 1, 'A file was uploaded with the description \"Video screenshot test\" here: https://support.danfran77.com/uploads/screenshot_for_video.png', 1, NULL),
(23, 7, '2021-10-17 20:23:36', 1, 'A file was uploaded with the description \"video test\" here: https://support.danfran77.com/uploads/videoscreenshot.png', 1, NULL),
(24, 2, '2021-11-12 12:53:36', 1, 'Hey', 1, NULL),
(25, 2, '2021-11-12 12:54:27', 1, 'Yo', NULL, 1),
(26, 2, '2021-11-12 12:54:37', 1, 'Yo', 1, NULL),
(27, 2, '2021-11-13 19:30:13', 1, 'A file was uploaded with the description \"test screenshot\" <a href=\"https://support.danfran77.com/uploads/testscreenshot.png\">here</a>', 1, NULL),
(28, 3, '2021-11-13 19:57:39', 1, 'A file was uploaded with the description \"testing txt file upload\" <a href=\"https://support.danfran77.com/uploads/testingtxtupload.txt\">here</a>', 1, NULL),
(29, 11, '2021-11-13 20:02:05', 1, 'A file was uploaded with the description \"testing docx upload\" <a href=\"https://support.danfran77.com/uploads/first_test_docx_file.docx\">here</a>', 1, NULL),
(30, 10, '2021-11-14 00:51:25', 1, 'Please upload a screenshot', NULL, 1),
(31, 10, '2021-11-14 00:52:17', 1, 'testing ticket update without requesting upload', NULL, 1),
(32, 10, '2021-11-14 00:55:37', 1, 'Second test of update with out upload request', NULL, 1),
(33, 12, '2021-11-14 14:28:30', 1, 'testing upload capabilities', 2, NULL),
(34, 12, '2021-11-14 14:29:32', 1, 'A file was uploaded with the description \"testing screenshot\" <a href=\"https://support.danfran77.com/uploads/screenshot.png\">here</a>', 2, NULL),
(35, 13, '2021-11-14 14:38:50', 1, 'this is a test ticket', 2, NULL),
(36, 13, '2021-11-14 14:39:40', 1, 'A file was uploaded with the description \"Video screenshot test\" <a href=\"https://support.danfran77.com/uploads/screnshot2.png\">here</a>', 2, NULL),
(37, 13, '2021-11-14 14:40:43', 1, 'A file was uploaded with the description \"test txt file\" <a href=\"https://support.danfran77.com/uploads/testingtxtupload.txt\">here</a>', 2, NULL),
(38, 13, '2021-11-14 14:42:30', 1, 'Test employee reply', NULL, 1),
(39, 13, '2021-11-14 14:43:28', 1, 'can you upload a screenshot of the error?', NULL, 1),
(40, 14, '2021-11-14 20:41:07', 1, 'Our email is down', 1, NULL),
(41, 14, '2021-11-14 20:44:00', 1, 'Working on it', NULL, 1),
(42, 15, '2021-11-14 20:49:48', 1, 'Email is down', 1, NULL),
(43, 6, '2021-11-14 20:53:59', 1, 'reply', 1, NULL),
(44, 6, '2021-11-14 20:57:50', 1, 'Reply', NULL, 1),
(45, 3, '2021-11-14 20:59:27', 1, 'Reply', 1, NULL),
(46, 3, '2021-11-14 20:59:44', 1, 'all fixed', NULL, 1),
(47, 16, '2022-01-19 15:04:14', 1, 'hr', 1, NULL),
(48, 17, '2022-01-19 15:42:26', 1, 'bgbf', 1, NULL),
(49, 18, '2022-01-19 17:01:21', 1, 'vhjhnh', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ContentType`
--
ALTER TABLE `ContentType`
  ADD PRIMARY KEY (`content_type_id`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `Employee`
--
ALTER TABLE `Employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `Notification`
--
ALTER TABLE `Notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `NotificationType`
--
ALTER TABLE `NotificationType`
  ADD PRIMARY KEY (`notificationtype_id`);

--
-- Indexes for table `Priority`
--
ALTER TABLE `Priority`
  ADD PRIMARY KEY (`priority_id`);

--
-- Indexes for table `Queue`
--
ALTER TABLE `Queue`
  ADD PRIMARY KEY (`queue_id`);

--
-- Indexes for table `Status`
--
ALTER TABLE `Status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `Ticket`
--
ALTER TABLE `Ticket`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `TicketContent`
--
ALTER TABLE `TicketContent`
  ADD PRIMARY KEY (`content_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Employee`
--
ALTER TABLE `Employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Notification`
--
ALTER TABLE `Notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Ticket`
--
ALTER TABLE `Ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `TicketContent`
--
ALTER TABLE `TicketContent`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
