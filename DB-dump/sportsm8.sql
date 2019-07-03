-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2019 at 05:04 PM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportsm8`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` bigint(20) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Sports category details';

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `created_on`) VALUES
(1, 'football', '2019-06-24 08:22:27'),
(2, 'volleyball', '2019-06-24 08:22:27');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` bigint(20) NOT NULL,
  `event_created_by_uid` bigint(20) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_type` enum('0','1') NOT NULL COMMENT '0:public,1:private',
  `event_desc` varchar(255) NOT NULL,
  `event_location` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `gender_rqd` enum('0','1','2') NOT NULL COMMENT '0:male,1:female,2:mixed',
  `event_photo` varchar(255) NOT NULL,
  `event_category` bigint(20) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Event details';

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_created_by_uid`, `event_name`, `event_type`, `event_desc`, `event_location`, `event_date`, `event_time`, `gender_rqd`, `event_photo`, `event_category`, `created_on`) VALUES
(1, 1, 'salsaa', '1', 'following is the demo event', 'connecticut', '2019-06-24', '11:16:00', '0', '', 1, '2019-06-24 08:36:48'),
(2, 1, 'salsaa', '1', 'آسف!! لم يتم حذف الحدث!', 'connecticut', '2019-06-24', '11:16:00', '0', '', 1, '2019-06-24 09:23:00'),
(4, 2, 'abc31', '0', 'my life, my rules', 'udr', '2019-06-24', '13:02:00', '1', '', 1, '2019-06-24 10:03:07');

-- --------------------------------------------------------

--
-- Table structure for table `event_comment`
--

CREATE TABLE `event_comment` (
  `comment_id` bigint(10) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `comment` longtext NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='comments posted by user for events';

--
-- Dumping data for table `event_comment`
--

INSERT INTO `event_comment` (`comment_id`, `user_id`, `event_id`, `comment`, `created_on`, `updated_on`) VALUES
(1, 1, 1, 'This is my first comment', '2019-06-26 07:36:39', '2019-06-26 07:36:39'),
(2, 1, 1, 'This is my first comment', '2019-06-26 07:44:54', '2019-06-26 07:44:54'),
(4, 5, 1, 'This is my first comment', '2019-07-02 12:02:54', '2019-07-02 12:02:54'),
(5, 5, 1, 'This is my second comment', '2019-07-02 12:03:49', '2019-07-02 12:03:49');

-- --------------------------------------------------------

--
-- Table structure for table `event_like`
--

CREATE TABLE `event_like` (
  `like_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `event_id` bigint(10) NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '1=like,0=unlike',
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event_like`
--

INSERT INTO `event_like` (`like_id`, `user_id`, `event_id`, `status`, `created_on`) VALUES
(3, 5, 2, '1', '2019-07-02 09:56:14'),
(4, 6, 2, '1', '2019-07-03 06:33:23');

-- --------------------------------------------------------

--
-- Table structure for table `event_report`
--

CREATE TABLE `event_report` (
  `event_report_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `event_id` bigint(10) NOT NULL,
  `report` enum('0','1','2','3') NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='event reported by user';

--
-- Dumping data for table `event_report`
--

INSERT INTO `event_report` (`event_report_id`, `user_id`, `event_id`, `report`, `created_on`, `updated_on`) VALUES
(1, 2, 1, '1', '2019-06-26 12:39:20', '2019-06-26 12:39:20');

-- --------------------------------------------------------

--
-- Table structure for table `event_share`
--

CREATE TABLE `event_share` (
  `event_share_id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `share_count` bigint(20) NOT NULL DEFAULT 0,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event_share`
--

INSERT INTO `event_share` (`event_share_id`, `event_id`, `share_count`, `created_on`, `updated_on`) VALUES
(1, 1, 2, '2019-06-30 12:09:28', '2019-06-30 12:09:43');

-- --------------------------------------------------------

--
-- Table structure for table `follow_user`
--

CREATE TABLE `follow_user` (
  `follow_user_id` bigint(20) NOT NULL,
  `follower_id` bigint(20) NOT NULL,
  `following_id` bigint(20) NOT NULL,
  `status` enum('1','2','3') NOT NULL COMMENT '1:requested,2:accepted,3:rejected',
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `follow_user`
--

INSERT INTO `follow_user` (`follow_user_id`, `follower_id`, `following_id`, `status`, `created_on`, `updated_on`) VALUES
(1, 2, 1, '2', '2019-06-25 06:55:11', '2019-06-26 13:14:56'),
(2, 2, 5, '2', '2019-06-25 06:55:11', '2019-06-26 12:54:36'),
(3, 5, 2, '2', '2019-06-26 13:03:13', '2019-06-26 13:03:20'),
(4, 6, 2, '2', '2019-06-26 13:04:40', '2019-06-26 13:04:51'),
(5, 1, 2, '2', '2019-06-26 13:04:40', '2019-06-26 13:04:51'),
(6, 1, 6, '2', '2019-06-26 13:16:25', '2019-06-26 13:16:25'),
(7, 1, 7, '2', '2019-06-26 13:16:25', '2019-06-26 13:16:41'),
(8, 5, 6, '2', '2019-06-26 13:18:34', '2019-06-26 13:18:34'),
(9, 5, 8, '2', '2019-06-26 13:18:34', '2019-06-26 13:18:34'),
(10, 7, 2, '2', '2019-07-02 12:10:50', '2019-07-02 12:11:11');

-- --------------------------------------------------------

--
-- Table structure for table `report_user`
--

CREATE TABLE `report_user` (
  `report_user_id` bigint(20) NOT NULL,
  `report_by_user` bigint(20) NOT NULL,
  `report_to_user` bigint(20) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1:report,2:block',
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `report_user`
--

INSERT INTO `report_user` (`report_user_id`, `report_by_user`, `report_to_user`, `status`, `created_on`, `updated_on`) VALUES
(1, 1, 2, '', '2019-06-25 07:22:55', '2019-06-25 07:22:55'),
(2, 1, 2, '', '2019-06-25 07:23:21', '2019-06-25 07:23:21'),
(3, 1, 2, '2', '2019-06-25 07:23:32', '2019-06-25 07:23:32'),
(4, 1, 2, '2', '2019-06-27 09:28:14', '2019-06-27 09:28:14'),
(5, 1, 2, '2', '2019-06-27 09:28:20', '2019-06-27 09:28:20');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_mobile` varchar(10) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_img` varchar(300) NOT NULL,
  `user_cover_img` varchar(255) NOT NULL,
  `user_dob` varchar(12) NOT NULL,
  `user_gender` enum('1','2') NOT NULL COMMENT '1=m,2=f',
  `user_bio` longtext NOT NULL,
  `user_interest` varchar(500) NOT NULL,
  `user_loc` varchar(255) NOT NULL,
  `user_status` int(1) NOT NULL COMMENT '0=unv,1=v',
  `admin_status` int(1) NOT NULL DEFAULT 1 COMMENT '0=un,1=v',
  `user_device_type` varchar(10) NOT NULL,
  `user_device_id` varchar(150) NOT NULL,
  `user_device_token` mediumtext NOT NULL,
  `v_code` varchar(50) NOT NULL,
  `m_code` varchar(4) NOT NULL,
  `user_token` varchar(200) NOT NULL,
  `account_mode` int(1) NOT NULL COMMENT '0=pub,1=priv',
  `notification_mode` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0:On,1:Off',
  `language_mode` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0:EN;1:AR',
  `pass_code` varchar(6) NOT NULL,
  `report_post` varchar(100) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User profile details';

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_mobile`, `user_email`, `user_password`, `user_img`, `user_cover_img`, `user_dob`, `user_gender`, `user_bio`, `user_interest`, `user_loc`, `user_status`, `admin_status`, `user_device_type`, `user_device_id`, `user_device_token`, `v_code`, `m_code`, `user_token`, `account_mode`, `notification_mode`, `language_mode`, `pass_code`, `report_post`, `created_on`, `updated_on`) VALUES
(1, 'xyz', '', 'xyz@gmail.com', '', '', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0, 0, '', '', '2019-06-27 12:33:54', '2019-06-30 06:58:18'),
(2, 'abc2', '123456789', 'abc2@gmail.com', '123456', '', '', '21/05/99', '1', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0, 0, '', '', '2019-06-16 14:17:11', '2019-06-30 06:58:18'),
(5, 'abc5', '123456789', 'abc5@gmail.com', '123456', '', '', '', '1', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0, 0, '', '', '2019-06-18 07:40:05', '2019-06-30 06:58:18'),
(6, 'abc5', '123456789', 'abc5@gmail.com', '123456', '', '', '', '1', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0, 0, '', '', '2019-06-18 12:23:12', '2019-06-30 06:58:18'),
(7, 'abc31', '123456789', 'abc33@gmail.com', '123456', '', '', '', '1', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0, 0, '', '', '2019-06-18 12:24:24', '2019-06-30 06:58:18'),
(8, 'abc8', '123456789', 'abc5@gmail.com', '123456', '', '', '', '1', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0, 0, '', '', '2019-06-20 13:59:11', '2019-07-02 13:20:13'),
(9, 'abc5', '123456789', 'abc5@gmail.com', '123456', '', '', '', '1', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0, 0, '', '', '2019-06-20 14:19:21', '2019-06-30 06:58:18'),
(10, 'abc5', '123456789', 'abc5@gmail.com', '123456', '', '', '', '1', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0, 0, '', '', '2019-06-24 13:02:39', '2019-06-30 06:58:18'),
(11, 'abc5', '123456789', 'abc5@gmail.com', '123456', '', '', '', '1', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0, 0, '', '', '2019-06-24 13:05:17', '2019-06-30 06:58:18'),
(12, 'abc31', '123456789', 'abc33@gmail.com', '123456', '1561993859.jpeg', '', '1990-04-22', '1', 'Lorem ipsum.Lorem ipsum.Lorem ipsum.Lorem ipsum.Lorem ipsum.Lorem ipsum.', '', 'udr', 0, 1, '', '', '', '', '', '', 0, 0, 0, '', '', '2019-06-30 06:56:53', '2019-07-01 15:10:59'),
(15, 'abc_new', '123456789', 'abc_new@gmail.com', '123456', '', '', '1999-02-23', '1', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0, 0, '', '', '2019-07-03 13:30:23', '2019-07-03 13:30:23'),
(16, 'abc_new', '123456789', 'abc_new@gmail.com', '123456', '', '', '1999-02-23', '1', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0, 0, '', '', '2019-07-03 13:31:53', '2019-07-03 13:31:53'),
(17, 'abc_new', '123456789', 'abc_new@gmail.com', '123456', '', '', '1999-02-23', '1', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0, 0, '', '', '2019-07-03 13:45:49', '2019-07-03 13:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `user_authentication`
--

CREATE TABLE `user_authentication` (
  `user_auth_id` bigint(20) NOT NULL,
  `token_id` varchar(255) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_authentication`
--

INSERT INTO `user_authentication` (`user_auth_id`, `token_id`, `user_id`, `created_on`, `updated_on`) VALUES
(2, 'YBdcfsLBZVBN3lUr0zc21w7ip2oSZUzQKy4U8VQ4gbGABDxie0B58tExM7WOUg3C', 15, '2019-07-03 13:30:23', '2019-07-03 13:30:23'),
(3, 'NbjiVWBEG43hmFW3qItFuQGG', 16, '2019-07-03 13:31:53', '2019-07-03 13:31:53'),
(4, 'MTdhYmNfbmV3MTIzNDU2YzcwMWM3MGVmZWQ1MDg4OTFmNDUwNjI0YmNlMDE3YTNhZDJmN2UzNg', 17, '2019-07-03 13:45:49', '2019-07-03 13:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `user_category`
--

CREATE TABLE `user_category` (
  `user_int_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `cat_id` bigint(20) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Categories selected by user OR user interests';

--
-- Dumping data for table `user_category`
--

INSERT INTO `user_category` (`user_int_id`, `user_id`, `cat_id`, `created_on`) VALUES
(14, 12, 1, '2019-07-01 15:10:59'),
(16, 15, 1, '2019-07-03 13:30:23'),
(17, 16, 1, '2019-07-03 13:31:53'),
(18, 17, 1, '2019-07-03 13:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_event`
--

CREATE TABLE `user_event` (
  `user_event_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `event_created_by_uid` bigint(20) NOT NULL,
  `status` enum('0','1','2') NOT NULL COMMENT '0:Pending,1:Accept,2:Reject',
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Events selected by user';

--
-- Dumping data for table `user_event`
--

INSERT INTO `user_event` (`user_event_id`, `user_id`, `event_id`, `event_created_by_uid`, `status`, `created_on`, `updated_on`) VALUES
(16, 5, 1, 1, '0', '2019-06-26 11:45:18', '2019-06-26 11:45:18'),
(17, 6, 1, 1, '0', '2019-06-26 12:06:26', '2019-06-26 12:06:26'),
(18, 7, 1, 1, '1', '2019-06-26 12:07:51', '2019-06-26 12:08:37'),
(21, 8, 1, 1, '1', '2019-07-02 09:55:36', '2019-07-02 11:19:01');

-- --------------------------------------------------------

--
-- Table structure for table `user_media`
--

CREATE TABLE `user_media` (
  `user_media_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `media_type` enum('1','2') NOT NULL COMMENT '1:image,2:video',
  `media_name` varchar(255) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_media`
--

INSERT INTO `user_media` (`user_media_id`, `user_id`, `media_type`, `media_name`, `created_on`) VALUES
(1, 1, '1', '1561284095.mp4', '2019-06-23 10:01:35'),
(2, 1, '1', '1561286800.mp4', '2019-06-23 10:46:41'),
(3, 1, '1', '1561286909.mp4', '2019-06-23 10:48:29');

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE `user_notification` (
  `user_notify_id` bigint(20) NOT NULL,
  `sender_id` bigint(20) NOT NULL,
  `receiver_id` bigint(20) NOT NULL,
  `type` enum('1','2','3','4','5','6','7','8') NOT NULL COMMENT '1:like_event,2:join_event,3:accept_event,4:follow_user_req,5:follow_user_accpt,6:comment_profile,7:comment_media,8:comment_event',
  `event_id` bigint(20) NOT NULL,
  `comment_id` bigint(20) NOT NULL,
  `read_status` enum('0','1') NOT NULL COMMENT '0=unread,1=read',
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='notification panel''s list';

--
-- Dumping data for table `user_notification`
--

INSERT INTO `user_notification` (`user_notify_id`, `sender_id`, `receiver_id`, `type`, `event_id`, `comment_id`, `read_status`, `created_on`, `updated_on`) VALUES
(4, 8, 1, '2', 1, 0, '0', '2019-07-02 09:55:36', '2019-07-02 09:55:36'),
(5, 5, 1, '1', 2, 0, '0', '2019-07-02 09:56:14', '2019-07-02 09:56:14'),
(6, 1, 8, '3', 1, 0, '0', '2019-07-02 11:19:01', '2019-07-02 11:19:01'),
(7, 5, 1, '8', 1, 4, '0', '2019-07-02 12:02:54', '2019-07-02 14:00:45'),
(8, 5, 1, '8', 1, 5, '0', '2019-07-02 12:03:49', '2019-07-02 14:00:48'),
(9, 7, 2, '4', 0, 0, '0', '2019-07-02 12:10:50', '2019-07-02 12:10:50'),
(10, 2, 7, '5', 0, 0, '0', '2019-07-02 12:11:11', '2019-07-02 12:11:11'),
(11, 6, 1, '1', 2, 0, '0', '2019-07-03 06:33:23', '2019-07-03 06:33:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `event_ibfk_2` (`event_category`),
  ADD KEY `event_ibfk_1` (`event_created_by_uid`);

--
-- Indexes for table `event_comment`
--
ALTER TABLE `event_comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `event_like`
--
ALTER TABLE `event_like`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `event_report`
--
ALTER TABLE `event_report`
  ADD PRIMARY KEY (`event_report_id`),
  ADD KEY `post_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `event_share`
--
ALTER TABLE `event_share`
  ADD PRIMARY KEY (`event_share_id`),
  ADD UNIQUE KEY `event_id` (`event_id`);

--
-- Indexes for table `follow_user`
--
ALTER TABLE `follow_user`
  ADD PRIMARY KEY (`follow_user_id`),
  ADD KEY `follower_id` (`follower_id`),
  ADD KEY `following_id` (`following_id`);

--
-- Indexes for table `report_user`
--
ALTER TABLE `report_user`
  ADD PRIMARY KEY (`report_user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_authentication`
--
ALTER TABLE `user_authentication`
  ADD KEY `user_auth_id` (`user_auth_id`),
  ADD KEY `user_authentication_ibfk_1` (`user_id`);

--
-- Indexes for table `user_category`
--
ALTER TABLE `user_category`
  ADD PRIMARY KEY (`user_int_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_event`
--
ALTER TABLE `user_event`
  ADD PRIMARY KEY (`user_event_id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`,`event_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_created_by_uid` (`event_created_by_uid`);

--
-- Indexes for table `user_media`
--
ALTER TABLE `user_media`
  ADD PRIMARY KEY (`user_media_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_notification`
--
ALTER TABLE `user_notification`
  ADD PRIMARY KEY (`user_notify_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `event_id` (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event_comment`
--
ALTER TABLE `event_comment`
  MODIFY `comment_id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event_like`
--
ALTER TABLE `event_like`
  MODIFY `like_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event_report`
--
ALTER TABLE `event_report`
  MODIFY `event_report_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_share`
--
ALTER TABLE `event_share`
  MODIFY `event_share_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `follow_user`
--
ALTER TABLE `follow_user`
  MODIFY `follow_user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `report_user`
--
ALTER TABLE `report_user`
  MODIFY `report_user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_authentication`
--
ALTER TABLE `user_authentication`
  MODIFY `user_auth_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_category`
--
ALTER TABLE `user_category`
  MODIFY `user_int_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_event`
--
ALTER TABLE `user_event`
  MODIFY `user_event_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_media`
--
ALTER TABLE `user_media`
  MODIFY `user_media_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_notification`
--
ALTER TABLE `user_notification`
  MODIFY `user_notify_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`event_created_by_uid`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`event_category`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `event_comment`
--
ALTER TABLE `event_comment`
  ADD CONSTRAINT `event_comment_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_report`
--
ALTER TABLE `event_report`
  ADD CONSTRAINT `event_report_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_report_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_share`
--
ALTER TABLE `event_share`
  ADD CONSTRAINT `event_share_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `follow_user`
--
ALTER TABLE `follow_user`
  ADD CONSTRAINT `follow_user_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `follow_user_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user_authentication`
--
ALTER TABLE `user_authentication`
  ADD CONSTRAINT `user_authentication_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_category`
--
ALTER TABLE `user_category`
  ADD CONSTRAINT `user_category_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_category_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_event`
--
ALTER TABLE `user_event`
  ADD CONSTRAINT `user_event_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_event_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_event_ibfk_3` FOREIGN KEY (`event_created_by_uid`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_media`
--
ALTER TABLE `user_media`
  ADD CONSTRAINT `user_media_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_notification`
--
ALTER TABLE `user_notification`
  ADD CONSTRAINT `user_notification_ibfk_1` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_notification_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
