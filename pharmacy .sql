-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2024 at 06:04 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `activitymanagement`
--

CREATE TABLE `activitymanagement` (
  `id` int(11) NOT NULL,
  `activity` varchar(100) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activitymanagement`
--

INSERT INTO `activitymanagement` (`id`, `activity`, `userId`, `created_at`, `updated_at`) VALUES
(1, 'Lgoin Activity', 24, '2024-10-31 18:16:42', '2024-10-31 18:16:42'),
(2, 'Lgoin Activity', 24, '2024-10-31 19:00:15', '2024-10-31 19:00:15'),
(3, 'Lgoin Activity', 24, '2024-10-31 19:00:44', '2024-10-31 19:00:44'),
(4, 'Lgoin Activity', 24, '2024-10-31 19:02:59', '2024-10-31 19:02:59'),
(6, 'Add user activity', 24, '2024-10-31 19:09:27', '2024-10-31 19:09:27'),
(7, 'Delete user activity', 24, '2024-10-31 19:11:21', '2024-10-31 19:11:21'),
(8, 'Add user activity', 24, '2024-10-31 19:16:48', '2024-10-31 19:16:48'),
(9, 'Logout activity', 24, '2024-10-31 19:18:52', '2024-10-31 19:18:52'),
(10, 'Login Activity', 24, '2024-10-31 19:19:06', '2024-10-31 19:19:06'),
(11, 'Add user activity', NULL, '2024-10-31 19:23:07', '2024-10-31 19:23:07'),
(12, 'Report generation activity', NULL, '2024-10-31 19:28:10', '2024-10-31 19:28:10'),
(13, 'Report generation activity', NULL, '2024-10-31 19:31:13', '2024-10-31 19:31:13'),
(14, 'Report generation activity', NULL, '2024-10-31 19:31:26', '2024-10-31 19:31:26'),
(15, 'Report generation activity', NULL, '2024-10-31 19:32:14', '2024-10-31 19:32:14'),
(16, 'Report generation activity', NULL, '2024-10-31 19:33:49', '2024-10-31 19:33:49'),
(17, 'Report generation activity', NULL, '2024-10-31 19:33:56', '2024-10-31 19:33:56'),
(18, 'Report generation activity', NULL, '2024-10-31 19:38:08', '2024-10-31 19:38:08'),
(19, 'Report generation activity', NULL, '2024-10-31 19:38:45', '2024-10-31 19:38:45'),
(20, 'Report generation activity', NULL, '2024-10-31 19:40:06', '2024-10-31 19:40:06'),
(21, 'Report generation activity', NULL, '2024-10-31 19:40:54', '2024-10-31 19:40:54'),
(22, 'Report generation activity', NULL, '2024-10-31 19:41:05', '2024-10-31 19:41:05'),
(23, 'Report generation activity', NULL, '2024-10-31 19:41:12', '2024-10-31 19:41:12'),
(24, 'Report generation activity', NULL, '2024-10-31 19:43:54', '2024-10-31 19:43:54'),
(25, 'Report generation activity', NULL, '2024-10-31 19:44:04', '2024-10-31 19:44:04'),
(26, 'Report generation activity', NULL, '2024-10-31 19:45:06', '2024-10-31 19:45:06'),
(27, 'Report generation activity', NULL, '2024-10-31 19:46:15', '2024-10-31 19:46:15'),
(28, 'Report generation activity', NULL, '2024-10-31 19:47:30', '2024-10-31 19:47:30'),
(29, 'Report generation activity', NULL, '2024-10-31 19:49:39', '2024-10-31 19:49:39'),
(30, 'Report generation activity', NULL, '2024-10-31 19:50:58', '2024-10-31 19:50:58'),
(31, 'Report generation activity', NULL, '2024-10-31 19:51:07', '2024-10-31 19:51:07'),
(32, 'Report generation activity', NULL, '2024-10-31 19:53:17', '2024-10-31 19:53:17'),
(33, 'Report generation activity', NULL, '2024-10-31 19:53:57', '2024-10-31 19:53:57'),
(34, 'Report generation activity', NULL, '2024-10-31 19:54:18', '2024-10-31 19:54:18'),
(35, 'Report generation activity', NULL, '2024-10-31 19:56:25', '2024-10-31 19:56:25'),
(36, 'Report generation activity', NULL, '2024-10-31 19:56:51', '2024-10-31 19:56:51'),
(37, 'Report generation activity', NULL, '2024-10-31 19:59:47', '2024-10-31 19:59:47'),
(38, 'Report generation activity', NULL, '2024-10-31 20:00:36', '2024-10-31 20:00:36'),
(39, 'Report generation activity', NULL, '2024-10-31 20:00:42', '2024-10-31 20:00:42'),
(40, 'Report generation activity', NULL, '2024-10-31 20:03:21', '2024-10-31 20:03:21'),
(41, 'Report generation activity', NULL, '2024-10-31 20:04:43', '2024-10-31 20:04:43'),
(42, 'Report generation activity', NULL, '2024-10-31 20:05:51', '2024-10-31 20:05:51'),
(43, 'Report generation activity', NULL, '2024-10-31 20:07:46', '2024-10-31 20:07:46'),
(44, 'Report generation activity', NULL, '2024-10-31 20:09:16', '2024-10-31 20:09:16'),
(45, 'Report generation activity', NULL, '2024-10-31 20:10:23', '2024-10-31 20:10:23'),
(46, 'Report generation activity', NULL, '2024-10-31 20:10:52', '2024-10-31 20:10:52'),
(47, 'Report generation activity', NULL, '2024-10-31 20:13:48', '2024-10-31 20:13:48'),
(48, 'Report generation activity', NULL, '2024-10-31 20:14:50', '2024-10-31 20:14:50'),
(49, 'Report generation activity', NULL, '2024-10-31 20:15:12', '2024-10-31 20:15:12'),
(50, 'Report generation activity', NULL, '2024-10-31 20:15:59', '2024-10-31 20:15:59'),
(51, 'Report generation activity', NULL, '2024-10-31 20:16:41', '2024-10-31 20:16:41'),
(52, 'Report generation activity', NULL, '2024-10-31 20:16:51', '2024-10-31 20:16:51'),
(53, 'Report generation activity', NULL, '2024-10-31 20:18:00', '2024-10-31 20:18:00'),
(54, 'Report generation activity', NULL, '2024-10-31 20:18:13', '2024-10-31 20:18:13'),
(55, 'Report generation activity', NULL, '2024-10-31 20:18:19', '2024-10-31 20:18:19'),
(56, 'Report generation activity', NULL, '2024-10-31 20:18:32', '2024-10-31 20:18:32'),
(57, 'Report generation activity', NULL, '2024-10-31 20:38:01', '2024-10-31 20:38:01'),
(58, 'Report generation activity', NULL, '2024-10-31 20:39:09', '2024-10-31 20:39:09'),
(59, 'Report generation activity', NULL, '2024-10-31 20:40:45', '2024-10-31 20:40:45'),
(60, 'Report generation activity', NULL, '2024-10-31 20:41:00', '2024-10-31 20:41:00'),
(61, 'Report generation activity', NULL, '2024-10-31 20:41:16', '2024-10-31 20:41:16'),
(62, 'Report generation activity', NULL, '2024-10-31 20:41:35', '2024-10-31 20:41:35'),
(63, 'Report generation activity', NULL, '2024-10-31 20:41:51', '2024-10-31 20:41:51'),
(64, 'Report generation activity', NULL, '2024-10-31 20:42:53', '2024-10-31 20:42:53'),
(65, 'Report generation activity', NULL, '2024-10-31 20:44:19', '2024-10-31 20:44:19'),
(66, 'Report generation activity', NULL, '2024-10-31 20:44:52', '2024-10-31 20:44:52'),
(67, 'Report generation activity', NULL, '2024-10-31 20:46:28', '2024-10-31 20:46:28'),
(68, 'Report generation activity', NULL, '2024-10-31 20:46:37', '2024-10-31 20:46:37'),
(69, 'Report generation activity', NULL, '2024-10-31 23:15:09', '2024-10-31 23:15:09'),
(70, 'Report generation activity', NULL, '2024-10-31 23:15:18', '2024-10-31 23:15:18'),
(71, 'Report generation activity', NULL, '2024-10-31 23:18:11', '2024-10-31 23:18:11'),
(72, 'Report generation activity', NULL, '2024-10-31 23:20:39', '2024-10-31 23:20:39'),
(73, 'Report generation activity', NULL, '2024-10-31 23:28:11', '2024-10-31 23:28:11'),
(74, 'Report generation activity', NULL, '2024-10-31 23:28:52', '2024-10-31 23:28:52'),
(75, 'Report generation activity', NULL, '2024-10-31 23:29:09', '2024-10-31 23:29:09'),
(76, 'Report generation activity', NULL, '2024-10-31 23:29:21', '2024-10-31 23:29:21'),
(77, 'Report generation activity', NULL, '2024-10-31 23:31:31', '2024-10-31 23:31:31'),
(78, 'Report generation activity', NULL, '2024-10-31 23:32:05', '2024-10-31 23:32:05'),
(79, 'Report generation activity', NULL, '2024-10-31 23:36:01', '2024-10-31 23:36:01'),
(80, 'Report generation activity', NULL, '2024-10-31 23:38:18', '2024-10-31 23:38:18'),
(81, 'Report generation activity', NULL, '2024-10-31 23:38:29', '2024-10-31 23:38:29'),
(82, 'Report generation activity', NULL, '2024-10-31 23:39:19', '2024-10-31 23:39:19'),
(83, 'Report generation activity', NULL, '2024-10-31 23:39:25', '2024-10-31 23:39:25'),
(84, 'Report generation activity', NULL, '2024-10-31 23:39:51', '2024-10-31 23:39:51'),
(85, 'Report generation activity', NULL, '2024-10-31 23:52:05', '2024-10-31 23:52:05'),
(86, 'Report generation activity', NULL, '2024-11-01 00:06:04', '2024-11-01 00:06:04'),
(87, 'Report generation activity', NULL, '2024-11-01 00:10:40', '2024-11-01 00:10:40'),
(88, 'Report generation activity', NULL, '2024-11-01 00:13:34', '2024-11-01 00:13:34'),
(89, 'Report generation activity', NULL, '2024-11-01 00:13:51', '2024-11-01 00:13:51'),
(90, 'Report generation activity', NULL, '2024-11-01 00:14:19', '2024-11-01 00:14:19'),
(91, 'Report generation activity', NULL, '2024-11-01 00:20:45', '2024-11-01 00:20:45'),
(92, 'Report generation activity', NULL, '2024-11-01 00:21:14', '2024-11-01 00:21:14'),
(93, 'Report generation activity', NULL, '2024-11-01 00:22:30', '2024-11-01 00:22:30'),
(94, 'Report generation activity', NULL, '2024-11-01 00:23:11', '2024-11-01 00:23:11'),
(95, 'Report generation activity', NULL, '2024-11-01 00:25:35', '2024-11-01 00:25:35'),
(96, 'Report generation activity', NULL, '2024-11-01 00:25:42', '2024-11-01 00:25:42'),
(97, 'Report generation activity', NULL, '2024-11-01 00:26:00', '2024-11-01 00:26:00'),
(98, 'Report generation activity', NULL, '2024-11-01 00:26:18', '2024-11-01 00:26:18'),
(99, 'Report generation activity', NULL, '2024-11-01 00:27:19', '2024-11-01 00:27:19'),
(100, 'Report generation activity', NULL, '2024-11-01 00:27:50', '2024-11-01 00:27:50'),
(101, 'Report generation activity', NULL, '2024-11-01 00:28:36', '2024-11-01 00:28:36'),
(102, 'Report generation activity', NULL, '2024-11-01 00:31:24', '2024-11-01 00:31:24'),
(103, 'Report generation activity', NULL, '2024-11-01 00:31:53', '2024-11-01 00:31:53'),
(104, 'Report generation activity', NULL, '2024-11-01 00:32:44', '2024-11-01 00:32:44'),
(105, 'Report generation activity', NULL, '2024-11-01 00:33:34', '2024-11-01 00:33:34'),
(106, 'Report generation activity', NULL, '2024-11-01 00:34:52', '2024-11-01 00:34:52'),
(107, 'Report generation activity', NULL, '2024-11-01 00:35:22', '2024-11-01 00:35:22'),
(108, 'Report generation activity', NULL, '2024-11-01 00:35:47', '2024-11-01 00:35:47'),
(109, 'Report generation activity', NULL, '2024-11-01 00:38:56', '2024-11-01 00:38:56'),
(110, 'Report generation activity', NULL, '2024-11-01 00:45:20', '2024-11-01 00:45:20'),
(111, 'Report generation activity', NULL, '2024-11-01 00:46:54', '2024-11-01 00:46:54'),
(112, 'Report generation activity', NULL, '2024-11-01 00:48:19', '2024-11-01 00:48:19'),
(113, 'Report generation activity', NULL, '2024-11-01 00:49:00', '2024-11-01 00:49:00'),
(114, 'Report generation activity', NULL, '2024-11-01 00:49:22', '2024-11-01 00:49:22'),
(115, 'Report generation activity', NULL, '2024-11-01 00:49:30', '2024-11-01 00:49:30'),
(116, 'Report generation activity', NULL, '2024-11-01 00:50:50', '2024-11-01 00:50:50'),
(117, 'Report generation activity', NULL, '2024-11-01 00:51:08', '2024-11-01 00:51:08'),
(118, 'Report generation activity', NULL, '2024-11-01 00:51:54', '2024-11-01 00:51:54'),
(119, 'Report generation activity', NULL, '2024-11-01 00:52:23', '2024-11-01 00:52:23'),
(120, 'Report generation activity', NULL, '2024-11-01 00:55:07', '2024-11-01 00:55:07'),
(121, 'Report generation activity', NULL, '2024-11-01 00:55:24', '2024-11-01 00:55:24'),
(122, 'Login Activity', 24, '2024-11-01 01:34:42', '2024-11-01 01:34:42'),
(123, 'Logout activity', 24, '2024-11-01 01:37:14', '2024-11-01 01:37:14'),
(124, 'Login Activity', 24, '2024-11-01 01:37:30', '2024-11-01 01:37:30'),
(125, 'Report generation activity', NULL, '2024-11-01 01:41:10', '2024-11-01 01:41:10'),
(126, 'Logout activity', 24, '2024-11-01 01:41:58', '2024-11-01 01:41:58'),
(127, 'Login Activity', 24, '2024-11-01 01:42:08', '2024-11-01 01:42:08'),
(128, 'Login Activity', NULL, '2024-11-01 01:45:57', '2024-11-01 01:45:57'),
(129, 'Logout activity', 24, '2024-11-01 01:46:07', '2024-11-01 01:46:07'),
(130, 'Login Activity', NULL, '2024-11-01 01:46:16', '2024-11-01 01:46:16'),
(131, 'Logout activity', 24, '2024-11-01 01:49:14', '2024-11-01 01:49:14'),
(132, 'Login Activity', 24, '2024-11-01 01:49:23', '2024-11-01 01:49:23'),
(133, 'Report generation activity', NULL, '2024-11-01 09:03:30', '2024-11-01 09:03:30'),
(134, 'Report generation activity', NULL, '2024-11-01 09:03:47', '2024-11-01 09:03:47'),
(135, 'Report generation activity', NULL, '2024-11-01 13:56:18', '2024-11-01 13:56:18'),
(136, 'Report generation activity', NULL, '2024-11-01 14:10:32', '2024-11-01 14:10:32'),
(137, 'Report generation activity', NULL, '2024-11-01 14:10:39', '2024-11-01 14:10:39'),
(138, 'Report generation activity', NULL, '2024-11-01 14:11:51', '2024-11-01 14:11:51'),
(139, 'Report generation activity', NULL, '2024-11-01 14:12:41', '2024-11-01 14:12:41'),
(140, 'Report generation activity', NULL, '2024-11-01 14:16:30', '2024-11-01 14:16:30'),
(141, 'Report generation activity', NULL, '2024-11-01 14:18:32', '2024-11-01 14:18:32'),
(142, 'Report generation activity', NULL, '2024-11-01 14:19:26', '2024-11-01 14:19:26'),
(143, 'Report generation activity', NULL, '2024-11-01 14:21:32', '2024-11-01 14:21:32'),
(144, 'Report generation activity', NULL, '2024-11-01 14:22:33', '2024-11-01 14:22:33'),
(145, 'Report generation activity', NULL, '2024-11-01 14:22:51', '2024-11-01 14:22:51'),
(146, 'Report generation activity', NULL, '2024-11-01 14:23:39', '2024-11-01 14:23:39'),
(147, 'Report generation activity', NULL, '2024-11-01 14:24:07', '2024-11-01 14:24:07'),
(148, 'Report generation activity', NULL, '2024-11-01 14:24:18', '2024-11-01 14:24:18'),
(149, 'Report generation activity', NULL, '2024-11-01 14:25:56', '2024-11-01 14:25:56'),
(150, 'Report generation activity', NULL, '2024-11-01 14:26:02', '2024-11-01 14:26:02'),
(151, 'Report generation activity', NULL, '2024-11-01 14:27:23', '2024-11-01 14:27:23'),
(152, 'Report generation activity', NULL, '2024-11-01 14:28:07', '2024-11-01 14:28:07'),
(153, 'Report generation activity', NULL, '2024-11-01 15:17:41', '2024-11-01 15:17:41'),
(154, 'Report generation activity', NULL, '2024-11-01 15:19:51', '2024-11-01 15:19:51'),
(155, 'Logout activity', 24, '2024-11-01 15:47:25', '2024-11-01 15:47:25'),
(156, 'Login Activity', 24, '2024-11-01 15:47:42', '2024-11-01 15:47:42'),
(157, 'Report generation activity', NULL, '2024-11-01 15:50:10', '2024-11-01 15:50:10'),
(158, 'Logout activity', 24, '2024-11-01 16:01:59', '2024-11-01 16:01:59'),
(159, 'Login Activity', 24, '2024-11-01 16:09:23', '2024-11-01 16:09:23'),
(160, 'Report generation activity', NULL, '2024-11-01 16:25:53', '2024-11-01 16:25:53'),
(161, 'Logout activity', 24, '2024-11-01 17:33:41', '2024-11-01 17:33:41'),
(162, 'Login Activity', 47, '2024-11-01 17:34:11', '2024-11-01 17:34:11'),
(163, 'Report generation activity', NULL, '2024-11-01 18:11:56', '2024-11-01 18:11:56'),
(164, 'Report generation activity', NULL, '2024-11-01 18:24:57', '2024-11-01 18:24:57'),
(165, 'Report generation activity', NULL, '2024-11-01 18:25:11', '2024-11-01 18:25:11'),
(166, 'Report generation activity', NULL, '2024-11-01 18:26:17', '2024-11-01 18:26:17'),
(167, 'Report generation activity', NULL, '2024-11-01 18:27:19', '2024-11-01 18:27:19'),
(168, 'Report generation activity', NULL, '2024-11-01 18:27:48', '2024-11-01 18:27:48'),
(169, 'Report generation activity', NULL, '2024-11-01 18:57:11', '2024-11-01 18:57:11'),
(170, 'Report generation activity', NULL, '2024-11-01 18:58:40', '2024-11-01 18:58:40'),
(171, 'Report generation activity', NULL, '2024-11-01 19:00:26', '2024-11-01 19:00:26'),
(172, 'Report generation activity', NULL, '2024-11-01 19:00:55', '2024-11-01 19:00:55'),
(173, 'Report generation activity', NULL, '2024-11-01 19:01:48', '2024-11-01 19:01:48'),
(174, 'Report generation activity', NULL, '2024-11-01 19:03:07', '2024-11-01 19:03:07'),
(175, 'Report generation activity', NULL, '2024-11-01 19:05:48', '2024-11-01 19:05:48'),
(176, 'Report generation activity', NULL, '2024-11-01 19:06:42', '2024-11-01 19:06:42'),
(177, 'Report generation activity', NULL, '2024-11-01 19:08:57', '2024-11-01 19:08:57'),
(178, 'Report generation activity', NULL, '2024-11-01 19:09:07', '2024-11-01 19:09:07'),
(179, 'Report generation activity', NULL, '2024-11-01 19:09:24', '2024-11-01 19:09:24'),
(180, 'Report generation activity', NULL, '2024-11-01 19:11:27', '2024-11-01 19:11:27'),
(181, 'Report generation activity', NULL, '2024-11-01 19:17:38', '2024-11-01 19:17:38'),
(182, 'Report generation activity', NULL, '2024-11-01 19:18:04', '2024-11-01 19:18:04'),
(183, 'Report generation activity', NULL, '2024-11-01 19:18:35', '2024-11-01 19:18:35'),
(184, 'Report generation activity', NULL, '2024-11-01 19:18:57', '2024-11-01 19:18:57'),
(185, 'Report generation activity', NULL, '2024-11-01 19:20:30', '2024-11-01 19:20:30'),
(186, 'Report generation activity', NULL, '2024-11-01 19:20:41', '2024-11-01 19:20:41'),
(187, 'Report generation activity', NULL, '2024-11-01 19:21:16', '2024-11-01 19:21:16'),
(188, 'Report generation activity', NULL, '2024-11-01 19:21:21', '2024-11-01 19:21:21'),
(189, 'Report generation activity', NULL, '2024-11-01 19:21:34', '2024-11-01 19:21:34'),
(190, 'Report generation activity', NULL, '2024-11-01 19:22:12', '2024-11-01 19:22:12'),
(191, 'Report generation activity', NULL, '2024-11-01 19:22:25', '2024-11-01 19:22:25'),
(192, 'Report generation activity', NULL, '2024-11-01 19:22:37', '2024-11-01 19:22:37'),
(193, 'Report generation activity', NULL, '2024-11-01 19:52:13', '2024-11-01 19:52:13'),
(194, 'Report generation activity', NULL, '2024-11-01 19:52:22', '2024-11-01 19:52:22'),
(195, 'Report generation activity', NULL, '2024-11-01 19:54:27', '2024-11-01 19:54:27'),
(196, 'Report generation activity', NULL, '2024-11-01 19:54:52', '2024-11-01 19:54:52'),
(197, 'Report generation activity', NULL, '2024-11-01 19:56:33', '2024-11-01 19:56:33'),
(198, 'Report generation activity', NULL, '2024-11-01 19:58:04', '2024-11-01 19:58:04'),
(199, 'Report generation activity', NULL, '2024-11-01 19:59:30', '2024-11-01 19:59:30'),
(200, 'Report generation activity', NULL, '2024-11-01 20:00:52', '2024-11-01 20:00:52'),
(201, 'Report generation activity', NULL, '2024-11-01 20:01:09', '2024-11-01 20:01:09'),
(202, 'Report generation activity', NULL, '2024-11-01 20:01:19', '2024-11-01 20:01:19'),
(203, 'Report generation activity', NULL, '2024-11-01 20:07:50', '2024-11-01 20:07:50'),
(204, 'Report generation activity', NULL, '2024-11-01 20:10:04', '2024-11-01 20:10:04'),
(205, 'Report generation activity', NULL, '2024-11-01 20:10:12', '2024-11-01 20:10:12'),
(206, 'Report generation activity', NULL, '2024-11-01 20:10:48', '2024-11-01 20:10:48'),
(207, 'Report generation activity', NULL, '2024-11-01 20:11:07', '2024-11-01 20:11:07'),
(208, 'Report generation activity', NULL, '2024-11-01 20:11:29', '2024-11-01 20:11:29'),
(209, 'Report generation activity', NULL, '2024-11-01 20:12:30', '2024-11-01 20:12:30'),
(210, 'Report generation activity', NULL, '2024-11-01 20:12:51', '2024-11-01 20:12:51'),
(211, 'Report generation activity', NULL, '2024-11-01 20:16:03', '2024-11-01 20:16:03'),
(212, 'Report generation activity', NULL, '2024-11-01 20:16:30', '2024-11-01 20:16:30'),
(213, 'Report generation activity', NULL, '2024-11-01 20:16:58', '2024-11-01 20:16:58'),
(214, 'Report generation activity', NULL, '2024-11-01 20:18:04', '2024-11-01 20:18:04'),
(215, 'Report generation activity', NULL, '2024-11-01 20:18:48', '2024-11-01 20:18:48'),
(216, 'Report generation activity', NULL, '2024-11-01 20:19:27', '2024-11-01 20:19:27'),
(217, 'Report generation activity', NULL, '2024-11-01 20:20:21', '2024-11-01 20:20:21'),
(218, 'Report generation activity', NULL, '2024-11-01 20:21:13', '2024-11-01 20:21:13'),
(219, 'Report generation activity', NULL, '2024-11-01 20:21:57', '2024-11-01 20:21:57'),
(220, 'Report generation activity', NULL, '2024-11-01 20:22:42', '2024-11-01 20:22:42'),
(221, 'Report generation activity', NULL, '2024-11-01 20:23:01', '2024-11-01 20:23:01'),
(222, 'Report generation activity', NULL, '2024-11-01 20:23:19', '2024-11-01 20:23:19'),
(223, 'Report generation activity', NULL, '2024-11-01 20:23:38', '2024-11-01 20:23:38'),
(224, 'Report generation activity', NULL, '2024-11-01 20:23:53', '2024-11-01 20:23:53'),
(225, 'Report generation activity', NULL, '2024-11-01 20:24:14', '2024-11-01 20:24:14'),
(226, 'Report generation activity', NULL, '2024-11-01 20:24:29', '2024-11-01 20:24:29'),
(227, 'Report generation activity', NULL, '2024-11-01 20:24:45', '2024-11-01 20:24:45'),
(228, 'Report generation activity', NULL, '2024-11-01 20:25:06', '2024-11-01 20:25:06'),
(229, 'Report generation activity', NULL, '2024-11-01 20:25:26', '2024-11-01 20:25:26'),
(230, 'Report generation activity', NULL, '2024-11-01 20:25:40', '2024-11-01 20:25:40'),
(231, 'Report generation activity', NULL, '2024-11-01 20:25:56', '2024-11-01 20:25:56'),
(232, 'Report generation activity', NULL, '2024-11-01 20:26:22', '2024-11-01 20:26:22'),
(233, 'Report generation activity', NULL, '2024-11-01 20:26:40', '2024-11-01 20:26:40'),
(234, 'Report generation activity', NULL, '2024-11-01 20:28:01', '2024-11-01 20:28:01'),
(235, 'Report generation activity', NULL, '2024-11-01 20:28:50', '2024-11-01 20:28:50'),
(236, 'Report generation activity', NULL, '2024-11-01 20:29:06', '2024-11-01 20:29:06'),
(237, 'Report generation activity', NULL, '2024-11-01 20:29:22', '2024-11-01 20:29:22'),
(238, 'Report generation activity', NULL, '2024-11-01 20:29:57', '2024-11-01 20:29:57'),
(239, 'Report generation activity', NULL, '2024-11-01 20:30:18', '2024-11-01 20:30:18'),
(240, 'Report generation activity', NULL, '2024-11-01 20:30:49', '2024-11-01 20:30:49'),
(241, 'Report generation activity', NULL, '2024-11-01 20:34:21', '2024-11-01 20:34:21'),
(242, 'Report generation activity', NULL, '2024-11-01 20:35:16', '2024-11-01 20:35:16'),
(243, 'Report generation activity', NULL, '2024-11-01 20:35:25', '2024-11-01 20:35:25'),
(244, 'Report generation activity', NULL, '2024-11-01 20:35:47', '2024-11-01 20:35:47'),
(245, 'Report generation activity', NULL, '2024-11-01 20:35:55', '2024-11-01 20:35:55'),
(246, 'Report generation activity', NULL, '2024-11-01 20:36:03', '2024-11-01 20:36:03'),
(247, 'Report generation activity', NULL, '2024-11-01 20:38:55', '2024-11-01 20:38:55'),
(248, 'Report generation activity', NULL, '2024-11-01 20:39:09', '2024-11-01 20:39:09'),
(249, 'Report generation activity', NULL, '2024-11-01 20:39:36', '2024-11-01 20:39:36'),
(250, 'Report generation activity', NULL, '2024-11-01 20:40:42', '2024-11-01 20:40:42'),
(251, 'Report generation activity', NULL, '2024-11-01 20:41:39', '2024-11-01 20:41:39'),
(252, 'Report generation activity', NULL, '2024-11-01 20:41:46', '2024-11-01 20:41:46'),
(253, 'Report generation activity', NULL, '2024-11-01 20:43:12', '2024-11-01 20:43:12'),
(254, 'Report generation activity', NULL, '2024-11-01 20:43:20', '2024-11-01 20:43:20'),
(255, 'Report generation activity', NULL, '2024-11-01 20:43:26', '2024-11-01 20:43:26'),
(256, 'Report generation activity', NULL, '2024-11-01 20:44:43', '2024-11-01 20:44:43'),
(257, 'Report generation activity', NULL, '2024-11-01 20:54:19', '2024-11-01 20:54:19'),
(258, 'Report generation activity', NULL, '2024-11-01 20:55:12', '2024-11-01 20:55:12'),
(259, 'Report generation activity', NULL, '2024-11-01 20:55:55', '2024-11-01 20:55:55'),
(260, 'Report generation activity', NULL, '2024-11-01 20:57:25', '2024-11-01 20:57:25'),
(261, 'Report generation activity', NULL, '2024-11-01 20:57:51', '2024-11-01 20:57:51'),
(262, 'Report generation activity', NULL, '2024-11-01 20:58:48', '2024-11-01 20:58:48'),
(263, 'Report generation activity', NULL, '2024-11-01 21:02:06', '2024-11-01 21:02:06'),
(264, 'Report generation activity', NULL, '2024-11-01 21:02:50', '2024-11-01 21:02:50'),
(265, 'Report generation activity', NULL, '2024-11-01 21:05:19', '2024-11-01 21:05:19'),
(266, 'Report generation activity', NULL, '2024-11-01 21:05:52', '2024-11-01 21:05:52'),
(267, 'Report generation activity', NULL, '2024-11-01 21:08:50', '2024-11-01 21:08:50'),
(268, 'Report generation activity', NULL, '2024-11-01 21:10:05', '2024-11-01 21:10:05'),
(269, 'Report generation activity', NULL, '2024-11-01 21:11:35', '2024-11-01 21:11:35'),
(270, 'Report generation activity', NULL, '2024-11-01 21:12:17', '2024-11-01 21:12:17'),
(271, 'Report generation activity', NULL, '2024-11-01 21:13:09', '2024-11-01 21:13:09'),
(272, 'Report generation activity', NULL, '2024-11-01 21:13:29', '2024-11-01 21:13:29'),
(273, 'Report generation activity', NULL, '2024-11-01 21:14:16', '2024-11-01 21:14:16'),
(274, 'Report generation activity', NULL, '2024-11-01 21:14:31', '2024-11-01 21:14:31'),
(275, 'Report generation activity', NULL, '2024-11-01 21:14:46', '2024-11-01 21:14:46'),
(276, 'Report generation activity', NULL, '2024-11-01 21:16:14', '2024-11-01 21:16:14'),
(277, 'Report generation activity', NULL, '2024-11-01 21:16:51', '2024-11-01 21:16:51'),
(278, 'Report generation activity', NULL, '2024-11-01 21:17:49', '2024-11-01 21:17:49'),
(279, 'Report generation activity', NULL, '2024-11-01 21:18:03', '2024-11-01 21:18:03'),
(280, 'Report generation activity', NULL, '2024-11-01 21:18:19', '2024-11-01 21:18:19'),
(281, 'Report generation activity', NULL, '2024-11-01 21:18:32', '2024-11-01 21:18:32'),
(282, 'Report generation activity', NULL, '2024-11-01 21:18:50', '2024-11-01 21:18:50'),
(283, 'Report generation activity', NULL, '2024-11-01 21:19:03', '2024-11-01 21:19:03'),
(284, 'Report generation activity', NULL, '2024-11-01 21:19:14', '2024-11-01 21:19:14'),
(285, 'Report generation activity', NULL, '2024-11-01 21:20:01', '2024-11-01 21:20:01'),
(286, 'Report generation activity', NULL, '2024-11-01 21:20:21', '2024-11-01 21:20:21'),
(287, 'Report generation activity', NULL, '2024-11-01 21:20:35', '2024-11-01 21:20:35'),
(288, 'Report generation activity', NULL, '2024-11-01 21:21:26', '2024-11-01 21:21:26'),
(289, 'Report generation activity', NULL, '2024-11-01 21:22:17', '2024-11-01 21:22:17'),
(290, 'Report generation activity', NULL, '2024-11-01 21:23:10', '2024-11-01 21:23:10'),
(291, 'Report generation activity', NULL, '2024-11-01 21:25:05', '2024-11-01 21:25:05'),
(292, 'Report generation activity', NULL, '2024-11-01 21:26:46', '2024-11-01 21:26:46'),
(293, 'Report generation activity', NULL, '2024-11-01 21:26:57', '2024-11-01 21:26:57'),
(294, 'Report generation activity', NULL, '2024-11-01 21:27:43', '2024-11-01 21:27:43'),
(295, 'Report generation activity', NULL, '2024-11-01 21:29:06', '2024-11-01 21:29:06'),
(296, 'Report generation activity', NULL, '2024-11-01 21:29:36', '2024-11-01 21:29:36'),
(297, 'Report generation activity', NULL, '2024-11-01 21:30:15', '2024-11-01 21:30:15'),
(298, 'Report generation activity', NULL, '2024-11-01 21:30:29', '2024-11-01 21:30:29'),
(299, 'Report generation activity', NULL, '2024-11-01 21:31:16', '2024-11-01 21:31:16'),
(300, 'Report generation activity', NULL, '2024-11-01 21:32:10', '2024-11-01 21:32:10'),
(301, 'Report generation activity', NULL, '2024-11-01 21:32:55', '2024-11-01 21:32:55'),
(302, 'Report generation activity', NULL, '2024-11-01 21:34:02', '2024-11-01 21:34:02'),
(303, 'Report generation activity', NULL, '2024-11-01 21:35:01', '2024-11-01 21:35:01'),
(304, 'Report generation activity', NULL, '2024-11-01 21:35:51', '2024-11-01 21:35:51'),
(305, 'Report generation activity', NULL, '2024-11-01 21:36:27', '2024-11-01 21:36:27'),
(306, 'Report generation activity', NULL, '2024-11-01 21:36:45', '2024-11-01 21:36:45'),
(307, 'Report generation activity', NULL, '2024-11-01 21:37:44', '2024-11-01 21:37:44'),
(308, 'Report generation activity', NULL, '2024-11-01 21:38:19', '2024-11-01 21:38:19'),
(309, 'Report generation activity', NULL, '2024-11-01 21:43:58', '2024-11-01 21:43:58'),
(310, 'Report generation activity', NULL, '2024-11-01 21:46:04', '2024-11-01 21:46:04'),
(311, 'Report generation activity', NULL, '2024-11-01 21:47:06', '2024-11-01 21:47:06'),
(312, 'Report generation activity', NULL, '2024-11-01 21:47:26', '2024-11-01 21:47:26'),
(313, 'Report generation activity', NULL, '2024-11-01 21:50:49', '2024-11-01 21:50:49'),
(314, 'Report generation activity', NULL, '2024-11-01 21:53:45', '2024-11-01 21:53:45'),
(315, 'Report generation activity', NULL, '2024-11-01 21:59:28', '2024-11-01 21:59:28'),
(316, 'Report generation activity', NULL, '2024-11-01 22:01:22', '2024-11-01 22:01:22'),
(317, 'Report generation activity', NULL, '2024-11-01 22:02:33', '2024-11-01 22:02:33'),
(318, 'Report generation activity', NULL, '2024-11-01 22:02:54', '2024-11-01 22:02:54'),
(319, 'Report generation activity', NULL, '2024-11-01 22:03:15', '2024-11-01 22:03:15'),
(320, 'Report generation activity', NULL, '2024-11-01 22:06:18', '2024-11-01 22:06:18'),
(321, 'Report generation activity', NULL, '2024-11-01 22:09:24', '2024-11-01 22:09:24'),
(322, 'Report generation activity', NULL, '2024-11-01 22:11:29', '2024-11-01 22:11:29'),
(323, 'Report generation activity', NULL, '2024-11-01 22:12:20', '2024-11-01 22:12:20'),
(324, 'Report generation activity', NULL, '2024-11-01 22:13:28', '2024-11-01 22:13:28'),
(325, 'Report generation activity', NULL, '2024-11-01 22:13:50', '2024-11-01 22:13:50'),
(326, 'Report generation activity', NULL, '2024-11-01 22:14:41', '2024-11-01 22:14:41'),
(327, 'Report generation activity', NULL, '2024-11-01 22:15:31', '2024-11-01 22:15:31'),
(328, 'Report generation activity', NULL, '2024-11-01 22:16:44', '2024-11-01 22:16:44'),
(329, 'Report generation activity', NULL, '2024-11-01 22:17:14', '2024-11-01 22:17:14'),
(330, 'Report generation activity', NULL, '2024-11-01 22:17:25', '2024-11-01 22:17:25'),
(331, 'Report generation activity', NULL, '2024-11-01 22:17:53', '2024-11-01 22:17:53'),
(332, 'Report generation activity', NULL, '2024-11-01 22:18:21', '2024-11-01 22:18:21'),
(333, 'Report generation activity', NULL, '2024-11-01 22:18:30', '2024-11-01 22:18:30'),
(334, 'Report generation activity', NULL, '2024-11-01 22:19:53', '2024-11-01 22:19:53'),
(335, 'Report generation activity', NULL, '2024-11-01 22:20:08', '2024-11-01 22:20:08'),
(336, 'Report generation activity', NULL, '2024-11-01 22:20:15', '2024-11-01 22:20:15'),
(337, 'Report generation activity', NULL, '2024-11-01 22:20:25', '2024-11-01 22:20:25'),
(338, 'Report generation activity', NULL, '2024-11-01 22:21:14', '2024-11-01 22:21:14'),
(339, 'Report generation activity', NULL, '2024-11-01 22:22:35', '2024-11-01 22:22:35'),
(340, 'Report generation activity', NULL, '2024-11-01 22:24:24', '2024-11-01 22:24:24'),
(341, 'Report generation activity', NULL, '2024-11-01 22:24:30', '2024-11-01 22:24:30'),
(342, 'Report generation activity', NULL, '2024-11-01 22:27:12', '2024-11-01 22:27:12'),
(343, 'Report generation activity', NULL, '2024-11-01 22:27:50', '2024-11-01 22:27:50'),
(344, 'Report generation activity', NULL, '2024-11-01 22:28:25', '2024-11-01 22:28:25'),
(345, 'Report generation activity', NULL, '2024-11-01 22:28:47', '2024-11-01 22:28:47'),
(346, 'Report generation activity', NULL, '2024-11-01 22:29:44', '2024-11-01 22:29:44'),
(347, 'Report generation activity', NULL, '2024-11-01 22:30:59', '2024-11-01 22:30:59'),
(348, 'Report generation activity', NULL, '2024-11-01 22:32:00', '2024-11-01 22:32:00'),
(349, 'Report generation activity', NULL, '2024-11-01 22:32:26', '2024-11-01 22:32:26'),
(350, 'Report generation activity', NULL, '2024-11-01 22:49:34', '2024-11-01 22:49:34'),
(351, 'Report generation activity', NULL, '2024-11-01 22:50:41', '2024-11-01 22:50:41'),
(352, 'Report generation activity', NULL, '2024-11-01 22:51:10', '2024-11-01 22:51:10'),
(353, 'Report generation activity', NULL, '2024-11-01 22:51:29', '2024-11-01 22:51:29'),
(354, 'Report generation activity', NULL, '2024-11-01 22:51:51', '2024-11-01 22:51:51'),
(355, 'Report generation activity', NULL, '2024-11-01 22:55:51', '2024-11-01 22:55:51'),
(356, 'Report generation activity', NULL, '2024-11-01 23:01:59', '2024-11-01 23:01:59'),
(357, 'Login Activity', 24, '2024-11-01 23:24:10', '2024-11-01 23:24:10'),
(358, 'Report generation activity', NULL, '2024-11-01 23:25:01', '2024-11-01 23:25:01'),
(359, 'Report generation activity', NULL, '2024-11-01 23:27:29', '2024-11-01 23:27:29'),
(360, 'Report generation activity', NULL, '2024-11-02 08:34:20', '2024-11-02 08:34:20'),
(361, 'Report generation activity', NULL, '2024-11-02 08:34:37', '2024-11-02 08:34:37'),
(362, 'Report generation activity', NULL, '2024-11-02 09:50:10', '2024-11-02 09:50:10'),
(363, 'Report generation activity', NULL, '2024-11-02 09:55:42', '2024-11-02 09:55:42'),
(364, 'Report generation activity', NULL, '2024-11-02 19:00:47', '2024-11-02 19:00:47'),
(365, 'Login Activity', 24, '2024-11-03 09:58:49', '2024-11-03 09:58:49'),
(366, 'Report generation activity', NULL, '2024-11-03 14:48:35', '2024-11-03 14:48:35'),
(367, 'Report generation activity', NULL, '2024-11-03 15:37:21', '2024-11-03 15:37:21'),
(368, 'Report generation activity', NULL, '2024-11-03 15:38:06', '2024-11-03 15:38:06'),
(369, 'Report generation activity', NULL, '2024-11-03 15:38:23', '2024-11-03 15:38:23'),
(370, 'Report generation activity', NULL, '2024-11-03 23:23:54', '2024-11-03 23:23:54'),
(371, 'Report generation activity', NULL, '2024-11-04 00:25:34', '2024-11-04 00:25:34'),
(372, 'Report generation activity', NULL, '2024-11-04 11:13:52', '2024-11-04 11:13:52'),
(373, 'Report generation activity', NULL, '2024-11-04 11:13:58', '2024-11-04 11:13:58'),
(374, 'Report generation activity', NULL, '2024-11-04 11:14:04', '2024-11-04 11:14:04'),
(375, 'Report generation activity', NULL, '2024-11-04 11:14:17', '2024-11-04 11:14:17');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `categoryname` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `categoryname`, `created_at`, `updated_at`) VALUES
(15, 'Pain Killer', 'Pain', '2024-10-23 21:38:20', '2024-10-23 21:38:20');

-- --------------------------------------------------------

--
-- Table structure for table `expensecategory`
--

CREATE TABLE `expensecategory` (
  `id` int(11) NOT NULL,
  `categoryname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expensecategory`
--

INSERT INTO `expensecategory` (`id`, `categoryname`) VALUES
(1, 'Utility'),
(3, 'Maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `expensedate` date DEFAULT NULL,
  `expensecategory` varchar(100) DEFAULT NULL,
  `purpose` varchar(100) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `actiontaker` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expensedate`, `expensecategory`, `purpose`, `total`, `description`, `created_at`, `updated_at`, `actiontaker`) VALUES
(4, '2024-10-29', 'Utility', 'test', 123, 'test ', '2024-10-29 21:15:47', '2024-10-30 09:35:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `dateofsale` date DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`items`)),
  `actiontaker` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `subtotal` float DEFAULT NULL,
  `totalprofit` float DEFAULT NULL,
  `invoicenumber` varchar(100) DEFAULT NULL,
  `paymentmode` varchar(20) DEFAULT NULL,
  `amountpaid` float DEFAULT NULL,
  `balance` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `dateofsale`, `items`, `actiontaker`, `created_at`, `updated_at`, `subtotal`, `totalprofit`, `invoicenumber`, `paymentmode`, `amountpaid`, `balance`) VALUES
(36, '2024-10-27', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"3558472\",\"oldQuantity\":\"1\"},{\"item_information\":\"Panadol\",\"unitPrice\":1.5,\"total\":3,\"quantity\":2,\"date\":\"Pain Killer\",\"batchId\":\"mg\",\"productId\":\"9590285\",\"category\":\"Pain Killer\",\"oldQuantity\":1}]', '', '2024-10-27 20:40:52', '2024-10-30 11:49:02', 6, NULL, 'INV5797145', NULL, NULL, NULL),
(39, '2024-10-31', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"6889808\"}]', 'dpalmer', '2024-10-31 00:43:12', '2024-10-31 00:43:12', 3, 1, 'INV7897254', 'momo', NULL, NULL),
(40, '2024-11-01', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"2401532\"},{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"0952560\"}]', 'dpalmer', '2024-11-01 15:48:20', '2024-11-01 15:48:20', 5.5, 2, 'INV2405893', 'cash', NULL, NULL),
(41, '2024-11-02', '[{\"unit\":\"mg\",\"quantity\":4,\"category\":\"Pain Killer\",\"unitPrice\":3,\"total\":12,\"item_information\":\"Paracetamol\",\"productId\":\"3953256\",\"oldQuantity\":3},{\"unit\":\"mg\",\"quantity\":16,\"category\":\"Pain Killer\",\"unitPrice\":2.5,\"total\":40,\"item_information\":\"Panadol\",\"productId\":\"1620685\",\"oldQuantity\":16}]', '', '2024-11-02 21:39:21', '2024-11-02 22:30:03', 52, 20, 'INV1315197', 'cash', NULL, NULL),
(42, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"8279073\"}]', '', '2024-11-03 13:25:29', '2024-11-03 13:25:29', 3, 1, 'INV7364055', 'cash', 5, 2),
(43, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"5176314\"}]', '', '2024-11-03 14:13:31', '2024-11-03 14:13:31', 3, 1, 'INV0553654', 'cash', 5, 2),
(44, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"5753004\"}]', '', '2024-11-03 14:14:29', '2024-11-03 14:14:29', 3, 1, 'INV0624055', 'cash', 5, 2),
(45, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"1149248\"}]', '', '2024-11-03 14:16:22', '2024-11-03 14:16:22', 2.5, 1, 'INV5881115', 'cash', 3, 0.5),
(46, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"7911932\"}]', '', '2024-11-03 14:17:57', '2024-11-03 14:17:57', 2.5, 1, 'INV1558833', 'cash', 3, 0.5),
(47, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"5179378\"}]', '', '2024-11-03 14:18:51', '2024-11-03 14:18:51', 2.5, 1, 'INV6278811', 'cash', 3, 0.5),
(48, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"9350740\"}]', '', '2024-11-03 14:19:27', '2024-11-03 14:19:27', 2.5, 1, 'INV5591745', 'cash', 3, 0.5),
(49, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"5899175\"}]', '', '2024-11-03 14:21:28', '2024-11-03 14:21:28', 2.5, 1, 'INV7583951', 'momo', 3, 0.5),
(50, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"2994195\"}]', '', '2024-11-03 14:27:34', '2024-11-03 14:27:34', 2.5, 1, 'INV3227090', 'momo', 5, 2.5),
(51, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"1268427\"}]', '', '2024-11-03 14:28:47', '2024-11-03 14:28:47', 2.5, 1, 'INV0232751', 'momo', 10, 7.5),
(52, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"1191078\"},{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"0470602\"}]', '', '2024-11-03 14:31:03', '2024-11-03 14:31:03', 5.5, 2, 'INV0097878', 'momo', 20, 14.5),
(53, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"7060624\"}]', '', '2024-11-03 14:38:44', '2024-11-03 14:38:44', 3, 1, 'INV3023535', 'momo', 5, 2),
(54, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"0997507\"}]', '', '2024-11-03 14:40:24', '2024-11-03 14:40:24', 3, 1, 'INV7061257', 'momo', 10, 7),
(55, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"1973745\"}]', '', '2024-11-03 14:41:13', '2024-11-03 14:41:13', 3, 1, 'INV2357083', 'momo', 20, 17),
(56, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"7028434\"}]', '', '2024-11-03 14:42:11', '2024-11-03 14:42:11', 2.5, 1, 'INV4740831', 'momo', 10, 7.5),
(57, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"2\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"5.00\",\"item_information\":\"Panadol\",\"productId\":\"3164332\"}]', '', '2024-11-03 14:43:05', '2024-11-03 14:43:05', 5, 2, 'INV8053422', 'momo', 10, 5),
(58, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"9188260\"}]', 'dpalmer', '2024-11-03 14:52:23', '2024-11-03 14:52:23', 3, 1, 'INV1083874', 'cash', 10, 7),
(59, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"6611972\"}]', '', '2024-11-03 14:54:28', '2024-11-03 14:54:28', 3, 1, 'INV1705678', 'momo', 5, 2),
(60, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"4252303\"}]', '', '2024-11-03 14:58:26', '2024-11-03 14:58:26', 2.5, 1, 'INV1390801', 'cash', 10, 7.5),
(61, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"5257210\"},{\"unit\":\"mg\",\"quantity\":\"2\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"6.00\",\"item_information\":\"Paracetamol\",\"productId\":\"3815772\"}]', '', '2024-11-03 15:00:57', '2024-11-03 15:00:57', 8.5, 3, 'INV8402954', 'momo', 10, 1.5),
(62, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"1097519\"},{\"unit\":\"mg\",\"quantity\":\"2\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"6.00\",\"item_information\":\"Paracetamol\",\"productId\":\"8119025\"}]', '', '2024-11-03 15:01:34', '2024-11-03 15:01:34', 8.5, 3, 'INV6330037', 'cash', 10, 1.5),
(63, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"2\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"6.00\",\"item_information\":\"Paracetamol\",\"productId\":\"9987242\"},{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.5\",\"total\":\"3.50\",\"item_information\":\"Panadol\",\"productId\":\"6221928\"}]', '', '2024-11-03 15:02:48', '2024-11-03 15:02:48', 9.5, 4, 'INV1311582', 'cash', 20, 14),
(64, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"5083339\"},{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"9846214\"}]', '', '2024-11-03 15:07:38', '2024-11-03 15:07:38', 5.5, 2, 'INV6654516', 'momo', 6, 0.5),
(65, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"2009350\"},{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"6990307\"}]', '', '2024-11-03 15:10:09', '2024-11-03 15:10:09', 5.5, 2, 'INV6349284', 'momo', 7, 1.5),
(66, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"9379091\"},{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"2.50\",\"total\":\"2.50\",\"item_information\":\"Panadol\",\"productId\":\"7454067\"}]', '', '2024-11-03 15:12:10', '2024-11-03 15:12:10', 5.5, 2, 'INV8550043', 'momo', 7, 1.5),
(67, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"1680238\"}]', '', '2024-11-03 15:18:27', '2024-11-03 15:18:27', 3, 1, 'INV3535644', 'momo', 4, 1),
(68, '2024-11-03', '[{\"unit\":\"mg\",\"quantity\":\"1\",\"category\":\"Pain Killer\",\"unitPrice\":\"3.00\",\"total\":\"3.00\",\"item_information\":\"Paracetamol\",\"productId\":\"7739186\"}]', 'dpalmer', '2024-11-03 20:39:30', '2024-11-03 20:39:30', 3, 1, 'INV6136214', 'momo', 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `medicinename` varchar(100) NOT NULL,
  `medicinecategory` varchar(100) NOT NULL,
  `medicineunit` varchar(100) NOT NULL,
  `medicinecostunitprice` float NOT NULL,
  `medicinesellingunitprice` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `medicineid` varchar(100) NOT NULL,
  `quantity` int(20) NOT NULL,
  `unitprofit` int(11) DEFAULT NULL,
  `qtysold` int(11) DEFAULT NULL,
  `collectedquantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `medicinename`, `medicinecategory`, `medicineunit`, `medicinecostunitprice`, `medicinesellingunitprice`, `created_at`, `updated_at`, `medicineid`, `quantity`, `unitprofit`, `qtysold`, `collectedquantity`) VALUES
(13, 'Paracetamol', 'Pain Killer', 'mg', 2, 3, '2024-10-23 15:56:02', '2024-11-03 20:39:30', '', 35, 1, 99, 200),
(14, 'Panadol', 'Pain Killer', 'mg', 1.5, 2.5, '2024-10-23 15:56:43', '2024-11-03 15:12:10', '', 49, 1, 129, 340);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`products`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date` date DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `paymentmode` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `products`, `created_at`, `updated_at`, `date`, `subtotal`, `paymentmode`) VALUES
(28, '[{\"date\":\"2024-10-24\",\"quantity\":\"20\",\"batchId\":\"PO098\",\"unitPrice\":\"1.5\",\"total\":\"30.00\",\"medicineName\":\"Paracetamol\",\"productId\":\"1395346\"},{\"date\":\"2024-10-24\",\"quantity\":\"15\",\"batchId\":\"POIU\",\"unitPrice\":\"2\",\"total\":\"30.00\",\"medicineName\":\"Panadol\",\"productId\":\"6958189\"}]', '2024-10-21 22:34:03', '2024-10-24 15:55:37', '1970-01-01', 60, NULL),
(33, '[{\"date\":\"2024-10-24\",\"quantity\":\"50\",\"batchId\":\"PO098\",\"unitPrice\":\"2\",\"total\":\"100.00\",\"medicineName\":\"Panadol\",\"productId\":\"5187124\"}]', '2024-10-24 15:52:34', '2024-10-24 15:52:34', '1970-01-01', 100, NULL),
(34, '[{\"date\":\"2024-11-01\",\"quantity\":\"16\",\"batchId\":\"poiu\",\"unitPrice\":\"3.00\",\"total\":\"48.00\",\"medicineName\":\"Panadol\",\"productId\":\"2025761\"}]', '2024-10-31 00:48:25', '2024-10-31 00:48:25', '2024-10-31', 48, 'cash'),
(35, '[{\"date\":\"2024-10-31\",\"quantity\":\"17\",\"batchId\":\"poiu\",\"unitPrice\":\"3\",\"total\":\"51.00\",\"medicineName\":\"Gebedol\",\"productId\":\"8223305\"}]', '2024-10-31 00:50:07', '2024-10-31 00:50:07', '2024-10-31', 51, 'momo');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `unitname` varchar(20) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unitname`, `unit`, `created_at`, `updated_at`) VALUES
(5, 'kilogram', 'kg', '2024-10-13 23:05:01', '2024-10-14 15:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `password` varchar(255) DEFAULT NULL,
  `avarta` varchar(300) DEFAULT NULL,
  `last_password_change` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `middlename`, `username`, `role`, `created_at`, `updated_at`, `password`, `avarta`, `last_password_change`) VALUES
(24, 'Daniel', 'Palmer', 'Bekoe', 'dpalmer', 'super_admin', '2024-10-29 23:06:18', '2024-10-30 21:26:52', '$2y$10$8QOgg9jBaOU25dv9URF9gOXzToCI1KiKOW3VDrbVxw7GdVAUuaDX2', '67229bb5c2c78-images.jpeg', '2024-10-30 22:16:28'),
(47, 'Mark', 'Odam', 'Markwei', 'mmodam', 'sales agent', '2024-10-31 19:16:48', '2024-10-31 19:16:48', '$2y$10$uDYxyq6zYbx.c/5oCNYn1eXNiAeqhK9PlXu.ai6426rE47V35Wp5e', NULL, '2024-10-31 19:16:48'),
(48, 'Darkosta', 'Aheto', 'kwame ', 'dkaheto', 'sales agent', '2024-11-01 17:32:59', '2024-11-01 17:32:59', '$2y$10$2/xDOH9Ftx599Xte1O1eW.390xjBPUequzMzwBJlXigD3RGGFGWpi', NULL, '2024-11-01 17:32:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activitymanagement`
--
ALTER TABLE `activitymanagement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`userId`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category` (`category`),
  ADD UNIQUE KEY `categoryname` (`categoryname`);

--
-- Indexes for table `expensecategory`
--
ALTER TABLE `expensecategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medicinename` (`medicinename`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unitname` (`unitname`),
  ADD UNIQUE KEY `unit` (`unit`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activitymanagement`
--
ALTER TABLE `activitymanagement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `expensecategory`
--
ALTER TABLE `expensecategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activitymanagement`
--
ALTER TABLE `activitymanagement`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
