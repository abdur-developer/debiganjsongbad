-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 09, 2026 at 03:33 PM
-- Server version: 10.11.18-MariaDB
-- PHP Version: 8.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `debigan1_news`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `user_id`, `action`, `details`, `ip_address`, `created_at`) VALUES
(1, 2, 'login', 'User logged in', '27.147.200.148', '2026-03-13 12:57:14'),
(2, 2, 'login', 'User logged in', '27.147.200.148', '2026-03-13 13:52:34'),
(3, 1, 'login', 'User logged in', '27.147.200.148', '2026-03-14 12:41:01'),
(4, 1, 'login', 'User logged in', '37.111.229.34', '2026-03-14 17:59:16'),
(5, 1, 'login', 'User logged in', '103.72.61.184', '2026-03-14 20:03:28'),
(6, 2, 'login', 'User logged in', '27.147.200.150', '2026-03-14 20:21:44'),
(7, 1, 'login', 'User logged in', '103.72.61.184', '2026-03-14 23:26:54'),
(8, 1, 'login', 'User logged in', '103.72.61.184', '2026-03-14 23:38:39'),
(9, 2, 'login', 'User logged in', '27.147.200.150', '2026-03-15 08:29:08'),
(10, 2, 'login', 'User logged in', '27.147.200.150', '2026-03-15 08:47:13'),
(11, 2, 'login', 'User logged in', '27.147.200.150', '2026-03-15 10:09:58'),
(12, 2, 'login', 'User logged in', '27.147.200.150', '2026-03-15 13:06:28'),
(13, 1, 'login', 'User logged in', '37.111.229.180', '2026-03-15 19:51:44'),
(14, 2, 'login', 'User logged in', '27.147.200.150', '2026-03-15 20:04:48'),
(15, 2, 'login', 'User logged in', '27.147.200.150', '2026-03-15 20:50:07'),
(16, 2, 'login', 'User logged in', '27.147.200.150', '2026-03-15 20:55:45'),
(17, 2, 'login', 'User logged in', '27.147.200.150', '2026-03-16 07:02:38'),
(18, 1, 'login', 'User logged in', '37.111.229.124', '2026-03-17 07:35:59'),
(19, 1, 'login', 'User logged in', '103.72.61.184', '2026-03-17 07:36:35'),
(20, 1, 'logout', 'User logged out', '103.72.61.184', '2026-03-17 07:44:39'),
(21, 1, 'login', 'User logged in', '103.72.61.184', '2026-03-17 07:45:11'),
(22, 1, 'login', 'User logged in', '103.72.61.184', '2026-03-26 20:12:36'),
(23, 1, 'login', 'User logged in', '103.72.61.184', '2026-03-28 19:38:07'),
(24, 1, 'login', 'User logged in', '103.72.61.184', '2026-03-29 09:35:16'),
(25, 1, 'login', 'User logged in', '103.72.61.184', '2026-03-29 10:28:12'),
(26, 2, 'login', 'User logged in', '27.147.200.148', '2026-03-29 10:32:51'),
(27, 2, 'logout', 'User logged out', '27.147.200.148', '2026-03-29 10:33:26'),
(28, 2, 'login', 'User logged in', '27.147.200.148', '2026-03-29 11:53:35'),
(29, 2, 'logout', 'User logged out', '27.147.200.148', '2026-03-29 12:22:45'),
(30, 2, 'login', 'User logged in', '27.147.200.148', '2026-03-29 12:22:48'),
(31, 1, 'login', 'User logged in', '37.111.229.9', '2026-03-29 15:09:59'),
(32, 1, 'login', 'User logged in', '37.111.229.9', '2026-03-29 16:30:02'),
(33, 1, 'login', 'User logged in', '103.72.61.184', '2026-03-29 18:35:31'),
(34, 1, 'logout', 'User logged out', '103.72.61.184', '2026-03-29 18:37:49'),
(35, 1, 'login', 'User logged in', '103.72.61.184', '2026-03-29 18:38:47'),
(36, 1, 'login', 'User logged in', '103.72.61.184', '2026-03-29 19:04:17'),
(37, 1, 'login', 'User logged in', '37.111.231.21', '2026-03-30 08:10:12'),
(38, 1, 'login', 'User logged in', '37.111.231.21', '2026-03-30 12:21:31'),
(39, 1, 'login', 'User logged in', '37.111.231.21', '2026-03-30 12:49:35'),
(40, 2, 'login', 'User logged in', '103.72.61.184', '2026-03-30 12:52:38'),
(41, 1, 'login', 'User logged in', '37.111.230.131', '2026-03-31 14:29:11'),
(42, 1, 'login', 'User logged in', '103.230.106.50', '2026-04-09 09:02:28'),
(43, 1, 'login', 'User logged in', '103.65.134.31', '2026-04-12 19:20:55'),
(44, 1, 'login', 'User logged in', '103.230.107.18', '2026-04-13 06:19:15'),
(45, 1, 'login', 'User logged in', '37.111.229.93', '2026-04-19 16:50:18'),
(46, 1, 'login', 'User logged in', '103.190.204.189', '2026-05-27 08:04:54'),
(47, 1, 'login', 'User logged in', '180.148.214.70', '2026-06-22 17:02:19'),
(48, 1, 'login', 'User logged in', '103.151.213.42', '2026-07-03 13:02:22'),
(49, 1, 'login', 'User logged in', '180.148.214.174', '2026-08-03 13:32:32'),
(50, 1, 'login', 'User logged in', '180.148.214.174', '2026-08-03 13:51:03'),
(51, 1, 'login', 'User logged in', '180.148.214.174', '2026-08-03 14:33:09'),
(52, 1, 'login', 'User logged in', '180.148.214.174', '2026-08-03 15:33:14'),
(53, 1, 'logout', 'User logged out', '103.230.104.16', '2026-08-03 17:28:08'),
(54, 1, 'login', 'User logged in', '103.230.104.16', '2026-08-03 17:28:12'),
(55, 1, 'logout', 'User logged out', '103.230.104.16', '2026-08-03 17:30:31'),
(56, 1, 'login', 'User logged in', '103.230.104.16', '2026-08-03 17:33:07'),
(57, 1, 'logout', 'User logged out', '103.230.104.16', '2026-08-03 17:37:03');

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `ad_name` varchar(255) NOT NULL,
  `ad_code` text NOT NULL,
  `ad_position` varchar(100) NOT NULL COMMENT 'header, sidebar, content_top, content_middle, content_bottom, footer',
  `ad_size` varchar(50) DEFAULT NULL,
  `device_type` enum('all','desktop','mobile') DEFAULT 'all',
  `max_impressions` int(11) DEFAULT 0 COMMENT '0 = আনলিমিটেড',
  `max_clicks` int(11) DEFAULT 0 COMMENT '0 = আনলিমিটেড',
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `ad_name`, `ad_code`, `ad_position`, `ad_size`, `device_type`, `max_impressions`, `max_clicks`, `status`, `created_at`) VALUES
(1, 'Header Banner', ' <div id=\"ds-ad-banner\">\r\n    <div class=\"ds-ad-left\">\r\n        <div class=\"ds-ad-title\">দেবীগঞ্জ সংবাদ</div>\r\n\r\n        <div class=\"ds-ad-text\">\r\n            আপনার ব্যবসা প্রতিষ্ঠান, শিক্ষা প্রতিষ্ঠান, ক্লিনিক সহ যেকোনো প্রতিষ্ঠানের\r\n            প্রচারে আমাদের সাথে যোগাযোগ করুন।\r\n        </div>\r\n\r\n        <div class=\"ds-ad-phone\">\r\n            📞 01517800573\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"ds-ad-right\">\r\n        <div class=\"ds-ad-icon\">📢</div>\r\n        <div class=\"ds-ad-service\">ডিজিটাল বিজ্ঞাপন</div>\r\n    </div>\r\n</div>\r\n\r\n<style>\r\n#ds-ad-banner{\r\n    width:728px;\r\n    max-width:100%;\r\n    min-height:90px;\r\n    background:linear-gradient(90deg,#0b7a3b,#118d49);\r\n    border-radius:8px;\r\n    display:flex;\r\n    align-items:center;\r\n    justify-content:space-between;\r\n    padding:10px 15px;\r\n    box-sizing:border-box;\r\n    margin:15px auto;\r\n    font-family:SolaimanLipi,\"Hind Siliguri\",sans-serif;\r\n}\r\n\r\n#ds-ad-banner *{\r\n    box-sizing:border-box;\r\n}\r\n\r\n#ds-ad-banner .ds-ad-left{\r\n    width:80%;\r\n}\r\n\r\n#ds-ad-banner .ds-ad-title{\r\n    color:#ffd700;\r\n    font-size:22px;\r\n    font-weight:bold;\r\n    margin-bottom:4px;\r\n}\r\n\r\n#ds-ad-banner .ds-ad-text{\r\n    color:#fff;\r\n    font-size:12px;\r\n    line-height:1.4;\r\n}\r\n\r\n#ds-ad-banner .ds-ad-phone{\r\n    display:inline-block;\r\n    margin-top:6px;\r\n    background:#fff;\r\n    color:#0b7a3b;\r\n    padding:4px 12px;\r\n    border-radius:20px;\r\n    font-size:15px;\r\n    font-weight:bold;\r\n}\r\n\r\n#ds-ad-banner .ds-ad-right{\r\n    width:18%;\r\n    text-align:center;\r\n    color:#fff;\r\n}\r\n\r\n#ds-ad-banner .ds-ad-icon{\r\n    font-size:32px;\r\n    margin-bottom:4px;\r\n}\r\n\r\n#ds-ad-banner .ds-ad-service{\r\n    font-size:13px;\r\n    font-weight:bold;\r\n}\r\n\r\n@media(max-width:768px){\r\n\r\n#ds-ad-banner{\r\n    width:100%;\r\n    padding:10px;\r\n}\r\n\r\n#ds-ad-banner .ds-ad-title{\r\n    font-size:18px;\r\n}\r\n\r\n#ds-ad-banner .ds-ad-text{\r\n    font-size:11px;\r\n}\r\n\r\n#ds-ad-banner .ds-ad-phone{\r\n    font-size:13px;\r\n}\r\n\r\n#ds-ad-banner .ds-ad-icon{\r\n    font-size:26px;\r\n}\r\n\r\n#ds-ad-banner .ds-ad-service{\r\n    font-size:11px;\r\n}\r\n\r\n}\r\n</style>', 'header', '728x90', 'all', 20, 5, 1, '2026-03-27 06:22:30'),
(2, 'Sidebar Ad', ' <div id=\"ds-ad-300\">\r\n\r\n    <div class=\"ds-title\">\r\n        দেবীগঞ্জ সংবাদ\r\n    </div>\r\n\r\n    <div class=\"ds-text\">\r\n        আপনার ব্যবসা প্রতিষ্ঠান, শিক্ষা প্রতিষ্ঠান, ক্লিনিক সহ যেকোনো প্রতিষ্ঠানের প্রচারে আমাদের সাথে যোগাযোগ করুন।\r\n    </div>\r\n\r\n    <div class=\"ds-phone\">\r\n        📞 01517800573\r\n    </div>\r\n\r\n    <div class=\"ds-icon\">\r\n        📢\r\n    </div>\r\n\r\n    <div class=\"ds-service\">\r\n        ডিজিটাল বিজ্ঞাপন\r\n    </div>\r\n\r\n</div>\r\n\r\n<style>\r\n#ds-ad-300{\r\n    width:300px;\r\n    height:250px;\r\n    background:linear-gradient(180deg,#0b7a3b,#15954d);\r\n    border-radius:10px;\r\n    padding:18px;\r\n    box-sizing:border-box;\r\n    text-align:center;\r\n    color:#fff;\r\n    font-family:SolaimanLipi,\"Hind Siliguri\",sans-serif;\r\n}\r\n\r\n#ds-ad-300 *{\r\n    box-sizing:border-box;\r\n}\r\n\r\n#ds-ad-300 .ds-title{\r\n    color:#FFD700;\r\n    font-size:28px;\r\n    font-weight:bold;\r\n    margin-bottom:12px;\r\n}\r\n\r\n#ds-ad-300 .ds-text{\r\n    font-size:15px;\r\n    line-height:1.7;\r\n    margin-bottom:18px;\r\n}\r\n\r\n#ds-ad-300 .ds-phone{\r\n    display:inline-block;\r\n    background:#fff;\r\n    color:#0b7a3b;\r\n    padding:8px 18px;\r\n    border-radius:30px;\r\n    font-size:18px;\r\n    font-weight:bold;\r\n    margin-bottom:18px;\r\n}\r\n\r\n#ds-ad-300 .ds-icon{\r\n    font-size:42px;\r\n}\r\n\r\n#ds-ad-300 .ds-service{\r\n    margin-top:8px;\r\n    font-size:18px;\r\n    font-weight:bold;\r\n}\r\n</style>', 'sidebar', '300x250', 'all', 20, 5, 0, '2026-03-27 06:22:30'),
(4, 'Content Ad', '<div id=\"ds728banner\">\r\n\r\n    <div class=\"ds-left\">\r\n        <div class=\"ds-title\">দেবীগঞ্জ সংবাদ</div>\r\n        <div class=\"ds-desc\">\r\n            আপনার ব্যবসা প্রতিষ্ঠান, শিক্ষা প্রতিষ্ঠান, ক্লিনিকসহ\r\n            যেকোনো প্রতিষ্ঠানের প্রচারে আজই বিজ্ঞাপন দিন।\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"ds-right\">\r\n        <div class=\"ds-call\">📞 01517800573</div>\r\n        <div class=\"ds-btn\">আজই যোগাযোগ করুন</div>\r\n    </div>\r\n\r\n</div>\r\n\r\n<style>\r\n#ds728banner{\r\n    width:728px;\r\n    height:90px;\r\n    margin:auto;\r\n    display:flex;\r\n    justify-content:space-between;\r\n    align-items:center;\r\n    padding:12px 20px;\r\n    background:linear-gradient(90deg,#005f2f,#1da851);\r\n    border-radius:8px;\r\n    box-sizing:border-box;\r\n    font-family:SolaimanLipi,\"Hind Siliguri\",sans-serif;\r\n}\r\n\r\n#ds728banner *{\r\n    box-sizing:border-box;\r\n}\r\n\r\n#ds728banner .ds-left{\r\n    width:70%;\r\n}\r\n\r\n#ds728banner .ds-title{\r\n    color:#FFD700;\r\n    font-size:24px;\r\n    font-weight:bold;\r\n    margin-bottom:5px;\r\n}\r\n\r\n#ds728banner .ds-desc{\r\n    color:#fff;\r\n    font-size:13px;\r\n    line-height:1.4;\r\n}\r\n\r\n#ds728banner .ds-right{\r\n    width:28%;\r\n    text-align:right;\r\n}\r\n\r\n#ds728banner .ds-call{\r\n    background:#fff;\r\n    color:#0a6d35;\r\n    padding:6px 14px;\r\n    border-radius:30px;\r\n    display:inline-block;\r\n    font-size:16px;\r\n    font-weight:bold;\r\n}\r\n\r\n#ds728banner .ds-btn{\r\n    margin-top:8px;\r\n    background:#FFD700;\r\n    color:#222;\r\n    display:inline-block;\r\n    padding:5px 14px;\r\n    border-radius:20px;\r\n    font-size:13px;\r\n    font-weight:bold;\r\n}\r\n\r\n@media(max-width:768px){\r\n#ds728banner{\r\n    width:100%;\r\n    height:auto;\r\n    flex-direction:column;\r\n    text-align:center;\r\n    padding:12px;\r\n}\r\n#ds728banner .ds-left,\r\n#ds728banner .ds-right{\r\n    width:100%;\r\n}\r\n#ds728banner .ds-right{\r\n    margin-top:10px;\r\n    text-align:center;\r\n}\r\n}\r\n</style>', 'content_middle', '728x90', 'all', 20, 5, 1, '2026-03-27 06:22:30'),
(5, 'Footer Ad', ' <div id=\"ds728banner\">\r\n\r\n    <div class=\"ds-left\">\r\n        <div class=\"ds-title\">দেবীগঞ্জ সংবাদ</div>\r\n        <div class=\"ds-desc\">\r\n            আপনার ব্যবসা প্রতিষ্ঠান, শিক্ষা প্রতিষ্ঠান, ক্লিনিকসহ\r\n            যেকোনো প্রতিষ্ঠানের প্রচারে আজই বিজ্ঞাপন দিন।\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"ds-right\">\r\n        <div class=\"ds-call\">📞 01517800573</div>\r\n        <div class=\"ds-btn\">আজই যোগাযোগ করুন</div>\r\n    </div>\r\n\r\n</div>\r\n\r\n<style>\r\n#ds728banner{\r\n    width:728px;\r\n    height:90px;\r\n    margin:auto;\r\n    display:flex;\r\n    justify-content:space-between;\r\n    align-items:center;\r\n    padding:12px 20px;\r\n    background:linear-gradient(90deg,#005f2f,#1da851);\r\n    border-radius:8px;\r\n    box-sizing:border-box;\r\n    font-family:SolaimanLipi,\"Hind Siliguri\",sans-serif;\r\n}\r\n\r\n#ds728banner *{\r\n    box-sizing:border-box;\r\n}\r\n\r\n#ds728banner .ds-left{\r\n    width:70%;\r\n}\r\n\r\n#ds728banner .ds-title{\r\n    color:#FFD700;\r\n    font-size:24px;\r\n    font-weight:bold;\r\n    margin-bottom:5px;\r\n}\r\n\r\n#ds728banner .ds-desc{\r\n    color:#fff;\r\n    font-size:13px;\r\n    line-height:1.4;\r\n}\r\n\r\n#ds728banner .ds-right{\r\n    width:28%;\r\n    text-align:right;\r\n}\r\n\r\n#ds728banner .ds-call{\r\n    background:#fff;\r\n    color:#0a6d35;\r\n    padding:6px 14px;\r\n    border-radius:30px;\r\n    display:inline-block;\r\n    font-size:16px;\r\n    font-weight:bold;\r\n}\r\n\r\n#ds728banner .ds-btn{\r\n    margin-top:8px;\r\n    background:#FFD700;\r\n    color:#222;\r\n    display:inline-block;\r\n    padding:5px 14px;\r\n    border-radius:20px;\r\n    font-size:13px;\r\n    font-weight:bold;\r\n}\r\n\r\n@media(max-width:768px){\r\n#ds728banner{\r\n    width:100%;\r\n    height:auto;\r\n    flex-direction:column;\r\n    text-align:center;\r\n    padding:12px;\r\n}\r\n#ds728banner .ds-left,\r\n#ds728banner .ds-right{\r\n    width:100%;\r\n}\r\n#ds728banner .ds-right{\r\n    margin-top:10px;\r\n    text-align:center;\r\n}\r\n}\r\n</style>', 'footer', '728x90', 'all', 20, 5, 1, '2026-03-27 06:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('banner','sidebar','popup','video') DEFAULT 'banner',
  `position` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `code` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `clicks` int(11) DEFAULT 0,
  `impressions` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name_bn` varchar(100) NOT NULL,
  `name_en` varchar(100) DEFAULT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `icon` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_bn`, `name_en`, `slug`, `description`, `parent_id`, `icon`, `sort_order`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'জাতীয়', 'National', 'national', NULL, 0, NULL, 1, 'active', NULL, '2026-03-10 20:02:19', '2026-03-12 09:56:49'),
(2, 'আন্তর্জাতিক', 'International', 'international', NULL, 0, NULL, 2, 'active', NULL, '2026-03-10 20:02:19', '2026-03-12 09:56:49'),
(3, 'রাজনীতি', 'Politics', 'politics', '', 0, NULL, 11, 'active', NULL, '2026-03-10 20:02:19', '2026-03-15 20:08:41'),
(4, 'অর্থনীতি', 'Economy', 'economy', NULL, 0, NULL, 4, 'active', NULL, '2026-03-10 20:02:19', '2026-03-12 09:56:49'),
(5, 'খেলাধুলা', 'Sports', 'sports', NULL, 0, NULL, 5, 'active', NULL, '2026-03-10 20:02:19', '2026-03-12 09:56:49'),
(6, 'বিনোদন', 'Entertainment', 'entertainment', NULL, 0, NULL, 6, 'active', NULL, '2026-03-10 20:02:19', '2026-03-12 09:56:49'),
(7, 'প্রযুক্তি', 'Technology', 'technology', NULL, 0, NULL, 7, 'active', NULL, '2026-03-10 20:02:19', '2026-03-12 09:56:49'),
(8, 'শিক্ষা', 'Education', 'education', '', 0, NULL, 8, 'active', NULL, '2026-03-10 20:02:19', '2026-03-15 20:07:41'),
(9, 'স্বাস্থ্য', 'Health', 'health', '', 0, NULL, 9, 'active', NULL, '2026-03-10 20:02:19', '2026-03-15 20:07:30'),
(10, 'দেবীগঞ্জ', 'Debiganj', 'debiganj', '', 0, NULL, 10, 'active', NULL, '2026-03-10 20:02:19', '2026-03-15 20:07:10'),
(13, 'লাইফস্টাইল', 'Lifestyle', 'lifestyle', NULL, 0, NULL, 13, 'active', NULL, '2026-03-10 20:02:19', '2026-03-12 09:56:49'),
(14, 'ধর্ম', 'Religion', 'religion', NULL, 0, NULL, 14, 'active', NULL, '2026-03-10 20:02:19', '2026-03-12 09:56:49'),
(15, 'ফিচার ', 'Feature', 'feature', '', 0, NULL, 15, 'active', NULL, '2026-03-10 20:02:19', '2026-03-29 19:26:59'),
(16, 'মতামত', 'Opinion', 'opinion', NULL, 0, NULL, 16, 'active', NULL, '2026-03-10 20:02:19', '2026-03-12 09:56:49'),
(17, 'চাকরি', 'Jobs', 'jobs', NULL, 0, NULL, 17, 'active', NULL, '2026-03-10 20:02:19', '2026-03-12 09:56:49'),
(20, 'সারাদেশ', 'Full Country', 'full-country', '', 0, NULL, 3, 'active', 2, '2026-03-15 20:06:23', '2026-03-15 20:06:23');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `comment` text NOT NULL,
  `status` enum('pending','approved','spam') DEFAULT 'pending',
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `news_id`, `user_id`, `name`, `email`, `comment`, `status`, `ip_address`, `created_at`) VALUES
(1, 9, NULL, 'Md Abdur Rahman', 'abdur09266@gmail.com', 'সঠিক সিদ্ধান্ত', 'spam', '27.147.200.150', '2026-03-15 20:55:34');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title_bn` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title_bn` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `summary` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `gallery_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery_images`)),
  `video_url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `author_id` int(11) DEFAULT NULL,
  `editor_id` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `is_breaking` tinyint(1) DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_trending` tinyint(1) DEFAULT 0,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `published_at` datetime DEFAULT NULL,
  `scheduled_at` datetime DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title_bn`, `title_en`, `slug`, `content`, `summary`, `featured_image`, `gallery_images`, `video_url`, `category_id`, `tags`, `author_id`, `editor_id`, `views`, `is_breaking`, `is_featured`, `is_trending`, `status`, `published_at`, `scheduled_at`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(4, 'আগে ঘর ঠিক করুন, তারপর দলীয় পদে থাকুন- পানিসম্পদ প্রতিমন্ত্রী ', 'Fix your house first, then stay in party positions - State Minister for Water Resources', 'fix-your-house-first-then-stay-in-party-positions-state-minister-for-water-resources', '<p>গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের পানিসম্পদ প্রতিমন্ত্রী ফরহাদ হোসেন আজাদ (এমপি) বলেছেন, আমার সামনে ও মঞ্চে অনেকেই বসে আছেন যারা বিএনপির রাজনীতি করেন, কিন্তু আপনার বউ অন্য মার্কায় ভোট দিয়েছেন। এ ক্ষেত্রে আমি বিনয়ের সঙ্গে বলতে চাই, আগে ঘর কে ঠিক করবেন তারপর সেই পদের পুনর্বহাল হবেন। প্রয়োজনে পদত্যাগ করে আগে নিজের ঘরকে ঠিক করে আবার ফিরে এসে দায়িত্ব গ্রহণ করবেন।</p><p>&nbsp;</p><p>শনিবার (১৪ মার্চ) বিকেলে পঞ্চগড়ের দেবীগঞ্জ সরকারি কলেজ প্রাঙ্গণে উপজেলা বিএনপি\'র আয়োজিত &nbsp;ইফতার মাহফিলে প্রধান অতিথির বক্তব্যে তিনি এসব কথা বলেন।</p><p>&nbsp;</p><p>প্রতিমন্ত্রী বলেন, রমজান শেষে ইউনিয়ন ও উপজেলা পর্যায়ের সংগঠনগুলো পুনর্গঠন করে আরও শক্তিশালী করা হবে। দলের মান ও মর্যাদা রক্ষায় সবাইকে নিষ্ঠার সঙ্গে মাঠে থেকে কাজ করতে হবে এবং কোনো ধরনের অনিয়মের অভিযোগ ওঠার আগেই সবাইকে সতর্ক থাকতে হবে।</p><p>&nbsp;</p><p>সনাতন ধর্মাবলম্বী ভোটারদের প্রতি কৃতজ্ঞতা প্রকাশ করে তিনি বলেন, আপনারা শুধু আমাকে সংসদ সদস্য ও প্রতিমন্ত্রী বানাননি, দলের চেয়ারম্যান তারেক রহমানকে প্রধানমন্ত্রী বানিয়েছেন।</p><p>তিনি সনাতন ধর্মাবলম্বীদের বিএনপির রাজনীতিতে আরও সক্রিয় হওয়ার আহ্বান জানান এবং তাদের যথাযথ মূল্যায়নের আশ্বাস দেন।</p><p>&nbsp;</p><p>ইফতার মাহফিলে এসময় উপস্থিত ছিলেন দেবীগঞ্জ উপজেলা বিএনপির সভাপতি আব্দুল গণি বসুনিয়া ও সাধারণ সম্পাদক আবুল হোসেন মোঃ তোবারক হ্যাপি, পৌর বিএনপির সভাপতি সরকার ফরিদুল ইসলাম ও সাধারণ সম্পাদক আশরাফুল আলম সোহেল প্রমুখ।</p><p>&nbsp;</p><p>আলোচনা শেষে ইফতারের আগে দেশ ও জাতির কল্যাণ কামনা করে বিশেষ দোয়া ও মোনাজাত করা হয়। &nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>', 'গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের পানিসম্পদ প্রতিমন্ত্রী ফরহাদ হোসেন আজাদ (এমপি) বলেছেন, আমার সামনে ও মঞ্চে অনেকেই বসে আছেন যারা বিএনপির রাজনীতি করেন, কিন্তু আপনার বউ অন্য মার্কায় ভোট দিয়েছেন।  ', '/uploads/news/1773531680_InShot_20260314_211507734.jpg', '[]', NULL, 3, '[\"পানিসম্পদ প্রতিমন্ত্রী\",\"রাজনীতি\",\"বিএনপি\",\"পঞ্চগড়\"]', 1, NULL, 67, 1, 1, 1, 'published', '2026-03-14 19:41:20', NULL, 'পানিসম্পদ প্রতিমন্ত্রী ', '', 'পানিসম্পদ প্রতিমন্ত্রী ফরহাদ হোসেন আজাদ ', '2026-03-14 23:41:20', '2026-06-23 09:53:02'),
(5, 'পাকিস্তানের বিপক্ষে সিরিজ জয়ে ঈদের আনন্দ বাংলাদেশের', 'Bangladesh\'s Eid joy in winning the series against Pakistan', 'bangladesh-s-eid-joy-in-winning-the-series-against-pakistan', '<p>তৃতীয় একদিনের ম্যাচেও রুদ্ধশ্বাস জয় পেয়েছে বাংলাদেশ। সিরিজ নির্ধারণী ম্যাচে আজ ২৯১ রানের টার্গেট দিয়ে শুরুতেই পাকিস্তানের ব্যাটিং স্তম্ভ ভেঙে দেন বাংলাদেশের পেসাররা। এরপর একাই দলকে টানেন সালমান আলি আগা। দুর্দান্ত ব্যাট করে পাকিস্তানকে জয়ের দ্বারপ্রান্তেই নিয়ে যাচ্ছিলেন তিনি। কিন্তু শেষদিকের রোমাঞ্চে ১১ রানে জিতে যায় বাংলাদেশ। এর ফলে তিন ম্যাচের সিরিজ ২-১ ব্যবধানে জিতে নেয় মেহেদী হাসান মিরাজের দল।</p><p>&nbsp;</p><p>এর মাধ্যমে পাকিস্তানের বিপক্ষে ওয়ানডে-তে টানা সিরিজ জেতার নজিরও গড়ল বাংলাদেশ। সবশেষ ২০১৫ সালে একে অপরের বিপক্ষে দ্বিপাক্ষিক সিরিজ খেলেছিল বাংলাদেশ-পাকিস্তান। সেবার পাকিস্তানকে ৩-০ ব্যবধানে হোয়াইটওয়াশ করেছিল বাংলাদেশ।</p><p>&nbsp;</p><p>রান তাড়া করতে নেমে শুরুটাই ভালো হয়নি পাকিস্তানের। বাংলাদেশের দুই পেসার তাসকিন আহমেদ ও নাহিদ রানার দাপুটে বোলিংয়ে শুরুতেই তিন উইকেট হারিয়ে চাপে পড়ে সফরকারীরা। মাত্র ১৭ রানেই হারায় প্রথম তিন উইকেট। ইনিংসের প্রথম ওভারেই সাহিবজাদা ফারহানকে (৬) ফেরান তাসকিন। পরের ওভারে নাহিদ রানা আউট করেন মাজ সাদাকাতকে (৬)। আর নিজের দ্বিতীয় ওভারে এসে রিজওয়ানকে (৪) ফেরান তাসকিন।</p><p>চাপে পড়া দলের হাল ধরার চেষ্টা চালান গাজি ঘুরি ও আব্দুল সামাদ। তবে প্রতিরোধটা ভালোভাবে করতে পারেননি তারা। ৩৯ বলে ২৯ রানে ঘোরি ও ৪৫ বলে ৩৪ রানে সামাদ আউট হন।</p><p>&nbsp;</p><p>একশ’র আগেই ৫ উইকেট হারিয়েছিল পাকিস্তান। বিপদের সময় দলের হাল ধরেন সালমান আলি আগা। তাকে সঙ্গ দিয়ে যাচ্ছিলেন সাদ মাসুদ। অভিষিক্ত এই ব্যাটার দারুণ শুরু পেয়েছিলেন। তবে ৩৮ রানে তাকে থামিয়েছেন মুস্তাফিজ। দুর্দান্ত ডেলিভারিতে বোল্ড করেন এই বাঁহাতি পেসার। তাতেই ৭৯ রানে থামে সালমান-মাসুদ।</p><p>&nbsp;</p><p>ক্রিজে নেমে দেখে-শুনেই খেলছিলেন ফাহিম আশরাফ। সালমানের সঙ্গে আরেকটি জুটি গড়ার প্রয়াস চালান তিনি। কিন্তু সেই সুযোগ দেননি তাসকিন আহমেদ। বাঁহাতি এই ব্যাটারকে বোল্ড করে সাজঘরে পাঠান তিনি। আউট হওয়ার আগে ৯ রান করেন ফাহিম।</p><p>&nbsp;</p><p>এর আগে মিরপুর শের-ই বাংলা জাতীয় ক্রিকেট স্টেডিয়ামে টস জিতে বাংলাদেশকে ব্যাট করার আমন্ত্রণ জানান পাকিস্তানের অধিনায়ক শাহীন শাহ আফ্রিদি। ব্যাট করতে নেমে উড়ন্ত সূচনা পায় বাংলাদেশ। উদ্বোধনী জুটিতে আসে ১০৫ রান। ইনিংসের ১৯তম ওভারে শাহীন আফ্রিদিকে এগিয়ে এসে খেলতে গিয়ে বলের লাইন মিস করে বোল্ড হন সাইফ। সাজঘরে ফেরার আগে তার ব্যাট থেকে এসেছে ৫৫ বলে ৩৬ রান।</p><p>&nbsp;</p><p>দুর্দান্ত শুরুর পর সাইফের মতো ইনিংস বড় করতে পারলেন না নাজমুল হোসেন শান্ত। হারিস রউফের করা বলে আউট হওয়ার আগে করেন ২৭ রান।</p><p>&nbsp;</p><p>এদিকে অভিষেক সেঞ্চুরির দেখা পেয়েছেন ওপেনার তানজিদ হাসান তামিম। মাত্র ৪৭ বলে ফিফটি করেছিলেন তিনি। পরের ফিফটি করতে খেলেছেন ৪৯ বল। সবমিলিয়ে ৯৮ বলে তিন অঙ্ক ছুঁয়েছেন। ক্যারিয়ারের প্রথম সেঞ্চুরির পর আর বেশিক্ষণ টিকতে পারেননি তামিম। আবরারের কিছুটা খাটো লেংথের বলে কাট করতে গিয়ে কাভারে শাহিন আফ্রিদির হাতে ধরা পড়েন তিনি। তার ব্যাট থেকে এসেছে ১০৭ বলে ১০৭ রান। ইনিংসে ৬টি চার ও ৭টি ছক্কার মার ছিল।</p><p>&nbsp;</p><p>চতুর্থ উইকেটে দারুণ জুটি উপহার দেন লিটন কুমার দাস ও তাওহীদ হৃদয়। এসময় দুজন মিলে তোলেন ৬৮ রান। তাতেই বড় সংগ্রহের দিকে এগিয়ে যায় দল। হারিস রউফের বলে আউট হওয়ার আগে ৪১ রান করেন লিটন দাস। আর পরের উইকেটে নেমে রানের দেখা পাননি রিশাদ হোসেন। প্রথম বলেই বোল্ড হন তিনি।এরপর আফিফকে নিয়ে ইনিংস শেষ করেন তাওহীদ হৃদয়। তিনি অপরাজিত থাকেন ৪৪ বলে ৪৮ রানে। আর ৫ রানে অপরাজিত থাকেন আফিফ।</p><p>&nbsp;</p><p>পাকিস্তানের হয়ে সর্বোচ্চ তিনটি উইকেট নেন হারিস রউফ। আবরার ও শাহিন শাহ আফ্রিদি নেন একটি করে উইকেট।</p><p>&nbsp;</p><p>&nbsp;</p>', 'পাকিস্তানের বিপক্ষে ওয়ানডে-তে টানা সিরিজ জেতার নজিরও গড়ল বাংলাদেশ। ', '/uploads/news/1773604870_image_274435_1773593116.jpg', '[]', NULL, 5, '[\"বাংলাদেশের সিরিজ জয়\",\"পাকিস্তানের বিপক্ষে\",\"\"]', 1, NULL, 74, 1, 1, 1, 'published', '2026-03-15 16:01:10', NULL, 'পাকিস্তানের বিপক্ষে সিরিজ জয় ', '', '', '2026-03-15 20:01:10', '2026-08-08 16:57:48'),
(6, 'নেতানিয়াহুর মৃত্যুর গুঞ্জন, অবশেষে সত্য প্রকাশ', 'Rumors of Netanyahu\'s death, finally the truth revealed', 'rumors-of-netanyahu-s-death-finally-the-truth-revealed', '<p>&nbsp;ইরানের হামলায় ইসরাইলের প্রধানমন্ত্রী বেনিয়ামিন নেতানিয়াহু নিহত হয়েছেন- ইরানি গণমাধ্যমসহ সামাজিক যোগাযোগমাধ্যমে ছড়িয়ে পড়া এমন দাবিকে ‘ভুয়া খবর’ বলে দাবি করেছে উগ্র ইহুদিবাদী ভূখণ্ডটির প্রধানমন্ত্রীর কার্যালয়।</p><p>তুরস্কের সংবাদ সংস্থা আনাদোলুর একজন সাংবাদিক যখন সামাজিকমাধ্যমে ছড়িয়ে পড়া ‘নেতানিয়াহু নিহত’ হওয়ার দাবির বিষয়ে প্রশ্ন করেন, তখন ইসরাইলের প্রধানমন্ত্রীর দফতর জানায়, ‘এগুলো ভুয়া খবর। প্রধানমন্ত্রী ভালো আছেন।’</p><p>তবে নেতানিয়াহু ভালো আছেন এমন কোনো প্রমাণ দেয়নি তার কার্যালয়। ইরানের সঙ্গে যুদ্ধ শুরু হওয়ার পর গত ৩ মার্চ সবশেষ নেতানিয়াহুকে জনসমক্ষে দেখা গিয়েছিল।</p><p>শনিবার (১৪ মার্চ) সামাজিক যোগাযোগমাধ্যমে ইসরাইলের প্রধানমন্ত্রী বেনিয়ামিন নেতানিয়াহুর অবস্থান নিয়ে নানা প্রশ্ন উঠেছে। ব্যবহারকারীরা শুক্রবারের (১৩ মার্চ) সর্বশেষ ভিডিওতে নেতানিয়াহুর একটি বিশেষ অসঙ্গতি লক্ষ্য করেন। &nbsp;ভিডিওতে নেতানিয়াহুর এক হাতে ছয়টি আঙুল আছে বলে ধারণা করা হচ্ছে। &nbsp;বিষয়টি ভিডিওটি এআই দিয়ে তৈরি করার সন্দেহ আরও বাড়িয়ে তুলেছে।</p><p>&nbsp;</p><p>শুক্রবার সামাজিক যোগাযোগমাধ্যম এক্সে একটি ভিডিও শেয়ার করেন নেতানিয়াহু। ভিডিওতে তিনি ইরান ও যুক্তরাষ্ট্রের মধ্যকার যুদ্ধ নিয়ে বক্তব্য দিচ্ছিলেন, যা বর্তমানে পুরো মধ্যপ্রাচ্যে ছড়িয়ে পড়েছে।</p><p>সামাজিক যোগাযোগমাধ্যমের ব্যবহারকারীরা দাবি করেন, নেতানিয়াহুর ওই ভিডিও বক্তব্যে তার ডান হাতে ছয়টি আঙুল দেখা যাচ্ছে। ‘ক্ল্যাসিক এআই ফিঙ্গার গ্লিচ’ লিখে পোস্ট করা এই ভিডিওগুলো লাখ লাখ মানুষ দেখছেন। অনেক ব্যবহারকারী দাবি করছেন, তিনি আসলে মারা গেছেন। যদিও এক্সের এআই চ্যাটবট ‘গ্রোক’ ফ্যাক্ট চেক করে এসব মন্তব্যকে ভুয়া বলে উল্লেখ করেছে।</p>', 'ইসরাইলের প্রধানমন্ত্রী বেনিয়ামিন নেতানিয়াহু নিহত হয়েছেন- ইরানি গণমাধ্যমসহ সামাজিক যোগাযোগমাধ্যমে ছড়িয়ে পড়া এমন দাবিকে ‘ভুয়া খবর’ বলে দাবি  ', '/uploads/news/1773605380_b1ab63ff5646f56c72f7ee14f2ae3dc6.webp', '[]', NULL, 2, '[\"মৃত্যু\",\"নেতানিয়াহু\",\"ইজরায়েল প্রধানমন্ত্রী\",\"\"]', 1, NULL, 61, 1, 1, 1, 'published', '2026-03-15 16:09:40', NULL, 'নেতানিয়াহুর মৃত্যু', '', 'ইসরায়েলের প্রধানমন্ত্রী নেতানিয়াহুর মৃত্যু ', '2026-03-15 20:09:40', '2026-08-08 16:57:52'),
(7, 'জাতিসংঘ সাধারণ পরিষদের সভাপতি পদে রাশিয়ার সমর্থন চেয়েছে বাংলাদেশ', 'Bangladesh has sought Russia\'s support for the post of President of the UN General Assembly', 'bangladesh-has-sought-russia-s-support-for-the-post-of-president-of-the-un-general-assembly', '<p>পররাষ্ট্র প্রতিমন্ত্রী শামা ওবায়েদ ইসলামের সঙ্গে সৌজন্য সাক্ষাৎ করেছেন বাংলাদেশে নিযুক্ত রাশিয়ার রাষ্ট্রদূত আলেকজেন্ডার গ্রিগরিয়েভিচ খোজিন। এসময় জাতিসংঘ সাধারণ পরিষদের (ইউএনজিএ) ৮১তম অধিবেশনের সভাপতির পদে বাংলাদেশের প্রার্থিতায় রাশিয়ার সমর্থন চেয়েছেন পররাষ্ট্র প্রতিমন্ত্রী।</p><p>&nbsp;</p><p>রোববার (১৫ মার্চ) পররাষ্ট্র মন্ত্রণালয়ে এ বৈঠক অনুষ্ঠিত হয়। মন্ত্রণালয়ের এক বিজ্ঞপ্তিতে এ তথ্য জানানো হয়।</p><p>&nbsp;</p><p>বাংলাদেশে নিযুক্ত রাশিয়ার রাষ্ট্রদূত আলেকজান্ডার গ্রিগোরিভিচ খোজিন আজ পররাষ্ট্র মন্ত্রণালয়ে প্রতিমন্ত্রী শামা ওবায়েদ ইসলামের সঙ্গে সৌজন্য সাক্ষাৎ করেন। রাষ্ট্রদূত প্রতিমন্ত্রীকে তার দায়িত্ব গ্রহণের জন্য অভিনন্দন জানান এবং বাংলাদেশ ও রাশিয়ার মধ্যে সম্পর্ক আরও দৃঢ় হবে বলে আশা প্রকাশ করেন।</p><p>&nbsp;</p><p>প্রতিমন্ত্রী দুই দেশের মধ্যে দীর্ঘস্থায়ী ও বন্ধুত্বপূর্ণ সম্পর্কের ওপর জোর দেন এবং উল্লেখ করেন যে জ্বালানি, বাণিজ্য ও বিনিয়োগ, বিজ্ঞান ও প্রযুক্তি, শিক্ষা এবং দক্ষ অভিবাসনের মতো ক্ষেত্রে অংশীদারত্ব আরও প্রসারিত হচ্ছে। রাষ্ট্রদূত দ্বিপক্ষীয় সহযোগিতা আরও জোরদার করার জন্য রাশিয়ার প্রতিশ্রুতি পুনর্ব্যক্ত করেন এবং রাশিয়ার সঙ্গে বাংলাদেশের অব্যাহত সম্পৃক্ততার প্রশংসা করেন।</p><p>&nbsp;</p><p>প্রতিমন্ত্রী ২০২৬-২৭ মেয়াদে জাতিসংঘের সাধারণ পরিষদের ৮১তম অধিবেশনে সভাপতিত্বের জন্য বাংলাদেশের প্রার্থিতার প্রতি রাশিয়ার সমর্থন চান। দ্বিপক্ষীয় সম্পর্কের ধারাবাহিক অগ্রগতিতে উভয় পক্ষ সন্তুষ্টি জানিয়ে দুই দেশের মধ্যে দীর্ঘস্থায়ী ও পারস্পরিকভাবে উপকারী অংশীদারত্বকে আরও এগিয়ে নেওয়ার প্রতিশ্রুতি পুনর্ব্যক্ত করে।</p>', 'জাতিসংঘ সাধারণ পরিষদের (ইউএনজিএ) ৮১তম অধিবেশনের সভাপতির পদে বাংলাদেশের প্রার্থিতায় রাশিয়ার সমর্থন চেয়েছেন পররাষ্ট্র প্রতিমন্ত্রী।', '/uploads/news/1773606708_images.jpg', '[]', NULL, 1, '[\"জাতিসংঘ\",\"সাধারণ পরিষদের সভাপতি\",\"বাংলাদেশ\",\"রাশিয়ার সমর্থন\"]', 1, NULL, 8, 0, 0, 0, 'published', '2026-03-15 16:18:35', NULL, 'জাতিসংঘের সাধারণ পরিষদের সভাপতি ', '', 'জাতিসংঘের সাধারণ পরিষদের সভাপতি ', '2026-03-15 20:18:35', '2026-08-03 21:59:52'),
(8, '২৯ মার্চ পর্যন্ত সংসদ অধিবেশন মুলতবি ', 'Parliament session adjourned till 29 March', 'parliament-session-adjourned-till-29-march', '<p>ত্রয়োদশ জাতীয় সংসদের প্রথম অধিবেশন আগামী ২৯ মার্চ পর্যন্ত মুলতবি ঘোষণা করা হয়েছে। প্রথম অধিবেশনের দ্বিতীয় দিন শেষে স্পিকার এ মুলতবি ঘোষণা করেন।</p><p>&nbsp;</p><p>স্পিকার বলেন, সংসদর বৈঠক আগামী ২৯ মার্চ (রোববার) বিকেল ৩টা পর্যন্ত মুলতবি করা হলো। আপনাদের সহযোগিতা করার জন্য ধন্যবাদ। সবাইকে আগাম ঈদ মোবারক জানান স্পিকার।</p><p>&nbsp;</p><p>জানা গেছে, এই প্রথম অধিবেশন আগামী ৩০ এপ্রিল পর্যন্ত চলবে বলে সিদ্ধান্ত হয়েছে। অধিবেশনে রাষ্ট্রপতির ভাষণের ওপর ধন্যবাদ প্রস্তাব এবং তার ওপর প্রায় ৫০ ঘণ্টা আলোচনার সিদ্ধান্ত নেওয়া হয়েছে। এছাড়া বিভিন্ন মন্ত্রণালয়ের প্রশ্নোত্তর পর্ব এবং জরুরি জনগুরুত্বপূর্ণ নোটিশগুলো নিয়েও আলোচনা হবে।</p><p>&nbsp;</p><p>উল্লেখ্য, রোববার (১৫ মার্চ) বেলা ১১টায় স্পিকার মেজর (অব.) হাফিজ উদ্দিন আহমেদের (বীর বিক্রম) সভাপতিত্বে অধিবেশন শুরু হয়েছিল।</p>', 'ত্রয়োদশ জাতীয় সংসদের প্রথম অধিবেশন আগামী ২৯ মার্চ পর্যন্ত মুলতবি ঘোষণা করা হয়েছে। ', '/uploads/news/1773606087_image_274337_1773567443.webp', '[]', NULL, 3, '[\"সংসদ অধিবেশন\",\"মুলতবি\",\"ত্রয়োদশ জাতীয় সংসদ\",\"\"]', 1, NULL, 161, 1, 1, 1, 'published', '2026-03-15 16:21:27', NULL, 'সংসদ অধিবেশন মুলতবি ', '', 'সংসদ অধিবেশন মুলতবি ', '2026-03-15 20:21:27', '2026-08-08 16:57:56'),
(9, 'শিক্ষা প্রতিষ্ঠানে র‍্যাগ ডে বন্ধে কঠোর নির্দেশনা ', 'Strict directives to ban \'Rag Day\' in educational institutions', 'strict-directives-to-ban-rag-day-in-educational-institutions', '<p>দেশের মাধ্যমিক ও উচ্চমাধ্যমিক পর্যায়ের শিক্ষাপ্রতিষ্ঠানগুলোতে ‘র‍্যাগ ডে’র নামে বিশৃঙ্খলা, অশ্লীলতা ও ইভটিজিং রোধে কঠোর অবস্থান নিয়েছে মাধ্যমিক ও উচ্চশিক্ষা অধিদপ্তর (মাউশি)। একইসঙ্গে শিক্ষার্থীদের মাদকের কুফল সম্পর্কে সচেতন করা এবং রাতে পড়াশোনায় মনোযোগী করার লক্ষ্যে গৃহীত পদক্ষেপগুলোর অগ্রগতির প্রতিবেদন তলব করা হয়েছে।</p><p>আগামী ৩০ মার্চের মধ্যে নির্দিষ্ট ছক মোতাবেক এই প্রতিবেদন মাউশির মনিটরিং অ্যান্ড ইভালুয়েশন উইংয়ে পাঠানোর জন্য দেশের সকল আঞ্চলিক পরিচালক ও উপ-পরিচালকদের নির্দেশ দেওয়া হয়েছে।</p><p>রোববার (১৫ মার্চ) মাধ্যমিক ও উচ্চ শিক্ষা (মাউশি) অধিদপ্তরের এক চিঠিতে এ তথ্য জানানো হয়েছে।</p><p>এতে বলা হয়, গত ২৫ ফেব্রুয়ারি শিক্ষা মন্ত্রণালয়ের আওতাধীন দপ্তর/সংস্থার সঙ্গে সচিব, মাধ্যমিক ও উচ্চ শিক্ষা বিভাগ-এর সভাপতিত্বে অনুষ্ঠিত আইন-শৃঙ্খলা সংক্রান্ত সভার গৃহীত সিদ্ধান্তের আলোকে মাদকের কুফল সংক্রান্ত প্রচার প্রচারণা বৃদ্ধি ও মাদকের বিরুদ্ধে সামাজিক আন্দোলন গড়ে তোলার লক্ষ্যে মাদকদ্রব্য নিয়ন্ত্রণ অধিদপ্তর কর্তৃক নির্মিত মাদকবিরোধী ডকুমেন্ট্রি ও মাদকবিরোধী থিম সং প্রদর্শনের প্রয়োজনীয় ব্যবস্থা গ্রহণ এবং শিক্ষা প্রতিষ্ঠানসমূহে ইভটিজিং প্রতিরোধ ও র‍্যাগ ডে-এর নামে বিশৃঙ্খলা রোধে গৃহীত পদক্ষেপগুলোর বাস্তবায়নের অগ্রগতির পাশাপাশি ছাত্র-ছাত্রীদের রাতে পড়াশোনায় মনোযোগী হওয়ার জন্য সচেতনতা বৃদ্ধি সম্পর্কিত তথ্য আগামী ৩০ মার্চের মধ্যে ই-মেইলে (director.mew@gmail.com) প্রেরণ করা প্রয়োজন।</p><p>&nbsp;</p><p>এমতাবস্থায় তার আওতাধীন অঞ্চলের জেলা/উপজেলার সকল শিক্ষা প্রতিষ্ঠানের বর্ণিত পদক্ষেপগুলোর বাস্তবায়নের অগ্রগতি প্রতিবেদনের সার-সংক্ষেপ একসঙ্গে কম্পাইল করে উল্লিখিত তারিখের মধ্যে নিম্নোক্ত ছক মোতাবেক প্রেরণের জন্য নির্দেশ ক্রমে অনুরোধ করা হল।</p><p>ছকের মধ্যে রয়েছে-অঞ্চলের নাম, অঞ্চলের আওতাধীন প্রতিষ্ঠান, প্রতিবেদনের বিষয় বাস্তবায়নকৃত প্রতিষ্ঠানের শতকরা হার, প্রতিবেদনের বিষয় বাস্তবায়ন করতে না পারা প্রতিষ্ঠানের শতকরা হার (যদি থাকে) এবং না পারার কারণ এবং মন্তব্য।</p><p>&nbsp;</p><p>জানা গেছে, ২০২২ সালের ৩ জুলাই ‘র‍্যাগ ডে’ উদ্‌যাপনের নামে অশোভন আচরণ, অশ্লীলতা, নগ্নতা, ডিজে পার্টি, নিষিদ্ধ ও নিষ্ঠুর কর্মকাণ্ড এবং বুলিং (উত্ত্যক্ত করা) বন্ধে ব্যবস্থা নিতে বিশ্ববিদ্যালয়গুলোর প্রতি নির্দেশ দিয়েছিল ইউজিসি। কমিশনের এক চিঠিতে বিশ্ববিদ্যালয়গুলোকে এই নির্দেশ দেয়। উচ্চ আদালতের আদেশের পরিপ্রেক্ষিতে এ বিষয়ে প্রয়োজনীয় ব্যবস্থা নেওয়ার কথা বলা হয়েছিল চিঠিতে।</p><p>&nbsp;</p><p>এর আগে, একই বছরের ৭ এপ্রিল দেশের বিভিন্ন শিক্ষাপ্রতিষ্ঠানে র‌্যাগ ডের নামে ডিজে পার্টি, উদ্দাম নৃত্য, বুলিং, অশ্লীলতা ও নগ্নতা বন্ধের নির্দেশনা চেয়ে হাইকোর্টে একটি রিট দায়ের করেন সুপ্রিম কোর্টের আইনজীবী মোহাম্মদ কামরুল হাসান। পরে ১৭ এপ্রিল ৩০ দিনের মধ্যে র‌্যাগ ডের নামে শিক্ষাপ্রতিষ্ঠানে বুলিং, নগ্নতা ও অপসংস্কৃতি বন্ধের নির্দেশ দেয় হাইকোর্ট।</p>', 'মাধ্যমিক ও উচ্চমাধ্যমিক পর্যায়ের শিক্ষাপ্রতিষ্ঠানগুলোতে ‘র‍্যাগ ডে’র নামে বিশৃঙ্খলা, অশ্লীলতা ও ইভটিজিং রোধে কঠোর অবস্থান নিয়েছে মাধ্যমিক ও উচ্চশিক্ষা অধিদপ্তর (মাউশি)।', '/uploads/news/1773606478_image_274410_1773585275.webp', '[]', NULL, 8, '[\"শিক্ষা প্রতিষ্ঠান\",\"র‍্যাগ ডে\",\"বন্ধে\",\"কঠোর নির্দেশনা\"]', 1, NULL, 223, 1, 1, 1, 'published', '2026-03-15 16:27:58', NULL, 'র‍্যাগ ডে বন্ধে কঠোর নির্দেশনা ', '', 'র‍্যাগ ডে বন্ধে কঠোর নির্দেশনা ', '2026-03-15 20:27:58', '2026-08-08 16:57:58'),
(10, 'এক যুগ পর একসঙ্গে বড় পর্দায় চঞ্চল-মোশাররফ', 'Chanchal and Mosharraf together on the big screen after a decade ', 'chanchal-and-mosharraf-together-on-the-big-screen-after-a-decade', '<p>দেশের অভিনয় জগতের দুই অনন্য প্রতিভাবান অভিনেতা চঞ্চল চৌধুরী ও মোশাররফ করিম। ছোট পর্দায় তাদের একসঙ্গে দেখা মানেই দর্শকের জন্য অভিনয়ের এক অনন্য উৎসব। তবে বড় পর্দায় এই জনপ্রিয় জুটির উপস্থিতি যেন দীর্ঘদিন ধরেই ছিল অধরা। অবশেষে সেই অপেক্ষার অবসান হতে চলেছে। প্রায় ১২ বছরের বিরতি ভেঙে আবারও একসঙ্গে বড় পর্দায় ফিরছেন এই দুই শক্তিমান অভিনেতা। নির্মাতা তানিম নূর-এর নতুন সিনেমা বনলতা এক্সপ্রেস-এ তাদের যুগল উপস্থিতি নিয়ে ইতোমধ্যেই দর্শকদের মাঝে তৈরি হয়েছে তুমুল কৌতূহল ও উত্তেজনা। প্রিয় দুই তারকাকে আবার একসঙ্গে বড় পর্দায় দেখার আশায় দিন গুনছেন ভক্তরা।</p><p>সম্প্রতি এক সংবাদ সম্মেলনে চঞ্চল চৌধুরী বলেন, ‘প্রায় এক যুগ পর আমরা চলচ্চিত্রের পর্দায় একসঙ্গে স্ক্রিন শেয়ার করছি। সর্বশেষ কাজ করেছিলাম মোস্তফা সরয়ার ফারুকীর ‘টেলিভিশন’ সিনেমায়। তারপর আর এক যুগের মতো আমাদের বড় পর্দায় কাজ হয়নি। তাই আমার মধ্যে এক ধরনের এক্সাইটমেন্ট কাজ করছিল।’</p><p>চঞ্চল চৌধুরী এই বড় চমকের পেছনের কারিগর হিসেবে পরিচালক তানিম নূরকে ধন্যবাদ দিয়ে বলেন, ‘তানিম নূর আমাদের দুজনকে হাজির করেছেন। অবশ্যই এটার জন্য আমি তানিমকে অনেক বড় একটা ধন্যবাদ জানাই।’</p><p>&nbsp;</p><p>সিনেমাটির মূল ভিত্তি কিংবদন্তি কথাশিল্পী হুমায়ূন আহমেদের গল্প। চঞ্চলের কথাং, ‘হুমায়ূন স্যার, উনার গল্পের ও লেখার মধ্যে জাদু আছে এটা আমরা সবাই জানি ও বিশ্বাস করি। আমার ব্যক্তিগত অভিজ্ঞতা হলো উনার কোনো বই পড়তে গেলে এক লাইন পড়লে পরের লাইন পড়তে ইচ্ছে করে।</p><p>&nbsp;</p><p>‘প্রত্যেক মোমেন্টে চুম্বকের মতো টান অনুভব করা যায়। সেই গল্প থেকে যখন তানিম নূর সিনেমা বানান, তখন বড় ধরণের কিছু একটা ঘটতে চলেছে বলেই আমি আশা করছি।’</p><p>&nbsp;</p><p>সিনেমায় শুধু মোশাররফ-চঞ্চল নন, একঝাঁক তারকা শিল্পীর সমাগম ঘটেছে। বাঁধন, মম, শরীফুল রাজ, শ্যামল মাওলা, সাবিলা নূর ও ইন্তেখাব দীনারের মতো বলিষ্ঠ অভিনয়শিল্পীদের উপস্থিতিকেই এই সিনেমার ‘সবচাইতে বড় চমক’ হিসেবে দেখছেন চঞ্চল চৌধুরী। তার মতে, নিজের জায়গায় প্রত্যেকেই অত্যন্ত শক্তিশালী অভিনেতা, যাদের একই পর্দায় দেখা যাওয়াটা দর্শকদের জন্য বিশেষ উপহার হতে যাচ্ছে।</p><p>&nbsp;</p>', '১২ বছরের বিরতি ভেঙে আবারও একসঙ্গে বড় পর্দায় ফিরছেন  দুই শক্তিমান অভিনেতা চঞ্চল চৌধুরী ও মোশাররফ করিম।', '/uploads/news/1773606906_image_274385_1773580055.webp', '[]', NULL, 6, '[\"এক যুগ\",\"বড় পর্দায়\",\"একসঙ্গে\",\"চঞ্চল চৌধুরী\",\"মোশাররফ করিম\"]', 1, NULL, 3, 0, 0, 1, 'published', '2026-03-15 16:35:06', NULL, 'এক যুগ পর একসঙ্গে বড় পর্দায় চঞ্চল-মোশাররফ', '', 'এক যুগ পর একসঙ্গে বড় পর্দায় চঞ্চল-মোশাররফ', '2026-03-15 20:35:06', '2026-07-23 13:10:45'),
(11, 'দেশের ৮০লাখ মানুষ চোখে গ্লুকোমাজনিত সমস্যায় ভুগছেন', '8 million people in the country are suffering from glaucoma-related eye problems.', '8-million-people-in-the-country-are-suffering-from-glaucoma-related-eye-problems', '<p>বর্তমানে দেশে গ্লুকোমা আক্রান্ত রোগীর সংখ্যা ২০ লাখ এবং সন্দেহভাজন রোগী ৬০ লাখ। সবমিলে প্রায় ৮০ লাখ মানুষ চোখের গ্লুকোমাজনিত সমস্যায় ভুগছেন। গ্লুকোমা চোখের এক নীরব ঘাতক রোগ। যা চোখ ও মস্তিষ্কের মধ্যে সংযোগকারী অপটিক স্নায়ুর ক্ষতি করে। গ্লুকোমায় আক্রান্ত হলে অপটিক স্নায়ু ধীরে ধীরে ক্ষতিগ্রস্ত হয়। দৃষ্টিশক্তি কমতে শুরু করে। সময়মতো চিকিৎসা না নিলে অন্ধত্বের কারণ হতে পারে।&nbsp;</p><p>বিশ্ব গ্লুকোমা সপ্তাহ- ২০২৬ উপলক্ষ্যে রোববার (১৪ মার্চ) রাজধানীর ধামনন্ডিতে বাংলাদেশ গ্লকোমা সোসাইটি আয়োজিত এক আলোচনা সভায় বিশেষজ্ঞরা এসব তথ্য জানান।</p><p>অনুষ্ঠানে সোসাইটির মহাসচিব ডা. শাহনাজ বেগম গ্লুকোমা রোগ সম্পর্কে বিস্তারিত তুলে ধরেন। তিনি বলেন, গ্লুকোমা নিয়ন্ত্রণে রাখা সম্ভব। কিন্তু নিরাময় করা সম্ভব নয়। ডায়াবেটিস এবং উচ্চ রক্তচাপ রোগীর মত সুনিয়ন্ত্রিত জীবনযাপন এবং নিয়মিত চক্ষু বিশেষজ্ঞের পরামর্শ নিলে গ্লুকোমা নিয়ন্ত্রণ করা যায়।</p><p>২০২৪ সালের দেশব্যাপী এক জরিপে দেখা গেছে, ৩৫ বছর বা তার বেশি বয়সী বাংলাদেশীদের মধ্যে গ্লুকোমার প্রবণতা ৩ দশমিক ২ শতাংশ, যার মধ্যে আনুমানিক ২০ লাখ আক্রান্ত এবং ৬০ লাখ সন্দেহভাজন রোগী। প্রাথমিক ওপেন-এঙ্গেল গ্লুকোমা সবচেয়ে সাধারণ ধরণ (৭৮ শতাংশ) যার প্রকোপ বয়স্ক পুরুষদের মধ্যে বেশি।</p><p>আরেকটি গবেষণায় দেখা গেছে, আক্রান্তদের মধ্যে ৫০ শতাংশই রোগটি সম্পর্কে সচেতনতা নয়, যার ফলে রোগ নির্ণয় বিলম্বিত হয়।</p><p>তিনি আরও বলেন, গ্লকোমা বিশ্বে স্থায়ী অন্ধত্বের অন্যতম প্রধান কারণ। বিশ্বের ৮ কোটি মানুষ গ্লকোমায় আক্রান্ত যার মধ্যে সারে ৪৫ লাখ গ্লকোমার কারণে অন্ধ। বিশ্বে ৯০ ভাগ মানুষ এ রোগ সম্পর্কে জানেনা, যার মধ্যে বেশীরভাগ স্বল্পন্নোত দেশগুলোতে। ২০৪০ সাল নাগাদ প্রায় ১২ কোটি মানুষ গ্লকোমায় আক্রান্ত হবে।</p><p>&nbsp;</p><p>&nbsp;</p>', 'বর্তমানে দেশে গ্লুকোমা আক্রান্ত রোগীর সংখ্যা ২০ লাখ এবং সন্দেহভাজন রোগী ৬০ লাখ। সবমিলে প্রায় ৮০ লাখ মানুষ চোখের গ্লুকোমাজনিত সমস্যায় ভুগছেন। ', '/uploads/news/1773607536_image_274390_1773581235.webp', '[]', NULL, 9, '[\"চোখের গ্লুকোমাজনিত\",\"৮০ লাখ মানুষ ভুগছেন\",\"স্বাস্থ্য সংবাদ\"]', 1, NULL, 0, 0, 0, 1, 'published', '2026-03-15 16:45:36', NULL, '৮০ লাখ মানুষ চোখের গ্লুকোমাজনিত সমস্যায় ভুগছেন। ', '', '৮০ লাখ মানুষ চোখের গ্লুকোমাজনিত সমস্যায় ভুগছেন। ', '2026-03-15 20:45:36', '2026-03-15 20:45:36'),
(13, 'চুল পড়া কমাতে নিয়মিত  যে  খাবার খাবেন', 'Foods to eat regularly to reduce hair loss', 'foods-to-eat-regularly-to-reduce-hair-loss', '<p>অল্প বয়সেই চুল পাতলা হয়ে যাওয়া বা অতিরিক্ত চুল পড়া, এ সমস্যা এখন আর বিরল নয়। কর্মব্যস্ত জীবন, অনিয়মিত খাবার, মানসিক চাপ আর ঘুমের ঘাটতির প্রভাব পড়ছে সরাসরি চুলের স্বাস্থ্যে। চুল পড়া শুরু হলেই অনেকেই ভরসা করেন নানা রাসায়নিক ট্রিটমেন্ট, সিরাম বা ওষুধে। কিন্তু এসবের পার্শ্বপ্রতিক্রিয়ায় চুল আরও দুর্বল হয়ে যাওয়ার ঘটনাও কম নয়।</p><p>&nbsp;</p><p>বিশেষজ্ঞদের মতে, চুলের গোড়া মজবুত রাখতে সবচেয়ে জরুরি হলো ভেতর থেকে পুষ্টি জোগানো। আর সেই পুষ্টির বড় একটি অংশ আসে আমাদের প্রতিদিনের খাবার থেকেই। সামান্য খাদ্যাভ্যাসে পরিবর্তন আনলে, নিয়মিত কিছু পুষ্টিকর খাবার রাখলে চুল পড়া অনেকটাই নিয়ন্ত্রণে আনা সম্ভব। তাহলে জেনে নেওয়া যাক, চুল পড়া কমাতে ও চুল ঘন করতে কোন খাবারগুলো নিয়মিত খাওয়া উচিত।</p><p>বাদাম</p><p>চুল নিয়ে দুশ্চিন্তায় ভুগছেন? তাহলে প্রতিদিনের খাদ্যতালিকায় রাখুন আখরোট, আমন্ড ও কাজুর মতো বাদাম। এসব বাদামে রয়েছে প্রয়োজনীয় ফ্যাটি অ্যাসিড, ভিটামিন ও মিনারেল, যা চুলের গোড়া মজবুত করতে সহায়তা করে এবং চুলের স্বাভাবিক উজ্জ্বলতা বজায় রাখে।</p><p>&nbsp;</p><p>&nbsp;চিয়া বীজ</p><p>চিয়া বীজে রয়েছে প্রচুর পরিমাণে ওমেগা-৩ ফ্যাটি অ্যাসিড, যা চুলের পুষ্টির জন্য অত্যন্ত গুরুত্বপূর্ণ। দই বা সালাদের সঙ্গে নিয়মিত চিয়া বীজ খেলে চুলের স্বাস্থ্য ভালো থাকে এবং চুল পড়া কমাতে সাহায্য করে।</p><p>&nbsp;</p><p>শিমের বীজ</p><p>চুল পড়া আটকাতে চান, একই সঙ্গে চুল ঘন করতে চান? সে ক্ষেত্রে শিমের বীজ হতে পারে দারুণ উপকারী। এতে রয়েছে প্রচুর প্রোটিন, যা চুলের গঠন ও বৃদ্ধিতে গুরুত্বপূর্ণ ভূমিকা রাখে। নিয়মিত খেলে চুলের শক্তি বাড়ে।</p><p>&nbsp;</p><p>পালং শাক</p><p>পালং শাকে রয়েছে ভিটামিন এ-এর ভালো উৎস। এই ভিটামিন চুলের বৃদ্ধিতে সহায়তা করে এবং মাথার ত্বককে সুস্থ রাখে। চুল পড়া কমাতেও পালং শাক বেশ কার্যকর।</p><p>&nbsp;</p><p>আমলকি</p><p>প্রতিদিন অল্প পরিমাণে আমলকি খেলে চুল পড়ার সমস্যা অনেকটাই কমে যেতে পারে। আমলকিতে থাকা ভিটামিন সি ও অ্যান্টিঅক্সিডেন্ট চুলের গোড়ায় পুষ্টি জোগায় এবং চুলকে ভেতর থেকে শক্তিশালী করে।</p><p>&nbsp;</p><p>চুলের যত্ন মানেই শুধু তেল বা শ্যাম্পু নয়, ভালো চুলের জন্য প্রয়োজন সঠিক খাবার আর নিয়মিত অভ্যাস। তাই বাইরে থেকে যত্নের পাশাপাশি ভেতর থেকেও চুলকে সুস্থ রাখতে আজ থেকেই খাদ্যতালিকায় এসব পুষ্টিকর খাবার যোগ করুন।</p><p>&nbsp;</p>', 'সামান্য খাদ্যাভ্যাসে পরিবর্তন আনলে, নিয়মিত কিছু পুষ্টিকর খাবার রাখলে চুল পড়া অনেকটাই নিয়ন্ত্রণে আনা সম্ভব। তাহলে জেনে নেওয়া যাক, চুল পড়া কমাতে ও চুল ঘন করতে কোন খাবারগুলো নিয়মিত খাওয়া উচিত।', '/uploads/news/1773608151_image_261060_1769521188.webp', '[]', NULL, 13, '[\"চুল পড়া কমাতে\",\"যে পাঁচটি খাবার খাবেন\",\"লাইফস্টাইল\"]', 2, NULL, 2, 0, 0, 1, 'published', '2026-03-15 16:55:51', NULL, 'চুল পড়া কমাতে ও চুল ঘন করতে কোন খাবারগুলো নিয়মিত খাওয়া উচিত', '', 'চুল পড়া কমাতে ও চুল ঘন করতে কোন খাবারগুলো নিয়মিত খাওয়া উচিত', '2026-03-15 20:55:51', '2026-07-22 22:54:02'),
(14, 'সংসদ সদস্যদের ব্যবহৃত হেডফোনের দাম ৮ হাজার টাকা!', 'The headphones used by the MPs cost 8,000 taka!', 'the-headphones-used-by-the-mps-cost-8-000-taka', '<p>সংসদে ব্যবহৃত হেডফোনটি যুক্তরাষ্ট্রের জনপ্রিয় অডিও ব্র্যান্ড ‘Shure’-এর তৈরি। মাইক্রোফোন, ওয়্যারলেস অডিও সিস্টেম ও হেডফোন উৎপাদনের জন্য বিশ্বজুড়ে পরিচিত এই প্রতিষ্ঠান।</p><p>&nbsp;</p><p>সংসদ সদস্যদের ব্যবহারের জন্য দেওয়া হেডফোনটি ‘SRH240A’ মডেলের। Shure–এর অফিসিয়াল ওয়েবসাইট অনুযায়ী, এই সিরিজে আরও কয়েকটি মডেলের হেডফোন রয়েছে, যার মধ্যে দামের দিক থেকে SRH240A তুলনামূলকভাবে কম মূল্যের।</p><p>ই-কমার্স প্ল্যাটফর্ম অ্যামাজনের তথ্য অনুযায়ী, SRH240A মডেলের হেডফোনটির দাম ৬৯ মার্কিন ডলার, যা বাংলাদেশি মুদ্রায় প্রায় ৮ হাজার ৪৫৭ টাকা। এ ছাড়া একই ব্র্যান্ডের অন্যান্য মডেলের মধ্যে ‘AONIC 50 Gen 2’ হেডফোনের দাম প্রায় ৩৮৯ ডলার, যা বাংলাদেশি টাকায় প্রায় ৪৭ হাজার ৭৫০ টাকা। ‘SRH840A’ মডেলের দাম প্রায় ১৬৯ ডলার বা প্রায় ২০ হাজার ৭৩৭ টাকা।</p><p>&nbsp;</p><p>অন্যদিকে ‘SRH440A’ মডেলের হেডফোনের দাম প্রায় ১০৯ ডলার, যা বাংলাদেশি টাকায় প্রায় ১৩ হাজার ৩৭৪ টাকা। ‘SRH1540’ মডেলের দাম প্রায় ৫০০ ডলার বা প্রায় ৬১ হাজার ৩৭৫ টাকা এবং ‘SRH1840’ মডেলের দাম প্রায় ৫৪৯ ডলার, যা বাংলাদেশি টাকায় প্রায় ৬৭ হাজার ৩৩২ টাকা।</p><p>&nbsp;</p><p>ত্রয়োদশ জাতীয় সংসদের উদ্বোধনী অধিবেশনে ব্যবহৃত হেডফোনের মান নিয়ে সমালোচনা করেছেন ঢাকা-১৪ আসনের সংসদ সদস্য মীর আহমেদ বিন কাসেম। অধিবেশন চলাকালে বেশ কয়েকজন সংসদ সদস্য অভিযোগ করেন, তাদের ব্যবহৃত হেডফোন ঠিকভাবে কাজ করছিল না।</p><p>বৃহস্পতিবার (১২ মার্চ) ব্যারিস্টার আরমান ফেসবুকে লিখেছিলেন, নিম্নমানের এই হেডফোন ব্যবহার করতে গিয়ে তার কান থেকে মাথা পর্যন্ত ব্যথা শুরু হয়েছে।</p><p>তিনি আরও লেখেন, সংসদে দেওয়া হেডফোনের মান এতটাই খারাপ যে, তা ব্যবহার করতে গিয়ে কান থেকে মাথা পর্যন্ত ব্যথা ধরেছে। সাউন্ড কোয়ালিটিও অত্যন্ত নিম্নমানের। তার দাবি, সংসদের পুরোনো ডিভাইসগুলোও সম্ভবত এর চেয়ে পরিষ্কার অডিও দিত। পুরো বিষয়টি তাকে হতাশ করেছে।</p>', 'সংসদ সদস্যদের ব্যবহারের জন্য দেওয়া হেডফোনটি ‘SRH240A’ মডেলের। Shure–এর অফিসিয়াল ওয়েবসাইট অনুযায়ী, এই সিরিজে আরও কয়েকটি মডেলের হেডফোন রয়েছে, যার মধ্যে দামের দিক থেকে SRH240A তুলনামূলকভাবে কম মূল্যের।\r\n\r\nই-কমার্স প্ল্যাটফর্ম অ্যামাজনের তথ্য অনুযায়ী, SRH240A মডেলের হেডফোনটির দাম ৬৯ মার্কিন ডলার, যা বাংলাদেশি মুদ্রায় প্রায় ৮ হাজার ৪৫৭ টাকা।', '/uploads/news/1773608765_image_273802_1773391427.webp', '[]', NULL, 7, '[\"হেডফোন\",\"সংসদ সদস্য\",\"সংসদ অধিবেশন\",\"প্রযুক্তি\",\"দেবীগঞ্জ সংবাদ\"]', 2, NULL, 0, 0, 0, 1, 'published', '2026-03-15 17:06:05', NULL, 'সংসদ সদস্যদের ব্যবহৃত হেডফোনের দাম ৮ হাজার টাকা!', '', 'সংসদ সদস্যদের ব্যবহৃত হেডফোনের দাম ৮ হাজার টাকা!', '2026-03-15 21:06:05', '2026-03-15 21:06:05'),
(15, '৬০ হাজার টাকা বেতনে রূপায়ণ গ্রুপে চাকরি', 'Rupayan Group offers jobs with 60,000 Taka salary', 'rupayan-group-offers-jobs-with-60-000-taka-salary', '<p>শীর্ষস্থানীয় শিল্পপ্রতিষ্ঠান রূপায়ণ গ্রুপে ‘অ্যাসিস্ট্যান্ট ম্যানেজার’ পদে জনবল নিয়োগ দেওয়া হবে। প্রার্থীদের অবশ্যই ব্যাচেলর অব আর্কিটেকচার অথবা বিবিএ ডিগ্রিধারী হতে হবে। মাসিক বেতন ৫০ থেকে ৬০ হাজার টাকা। আগ্রহীরা আগামী ১৩ এপ্রিল পর্যন্ত আবেদন করতে পারবেন।</p><p>&nbsp;</p><p>প্রতিষ্ঠানের নাম: রূপায়ণ গ্রুপ</p><p>বিভাগের নাম: বিল্ডিং ডিজাইন সেলস</p><p>পদের নাম: অ্যাসিস্ট্যান্ট ম্যানেজার</p><p>পদসংখ্যা: ৫ জন</p><p>শিক্ষাগত যোগ্যতা: ব্যাচেলর অব আর্কিটেকচার অথবা বিবিএ (মার্কেটিং)</p><p>অভিজ্ঞতা: ৬-৮ বছর</p><p>বেতন: ৫০,০০০-৬০,০০০ টাকা</p><p>প্রার্থীর ধরন: নারী-পুরুষ</p><p>বয়স: ৩০-৩৫ বছর</p><p>কর্মস্থল: ঢাকা (উত্তরা সেক্টর ১২)</p><p>আবেদনের শেষ সময়: ১৩ এপ্রিল ২০২৬</p>', 'শীর্ষস্থানীয় শিল্পপ্রতিষ্ঠান রূপায়ণ গ্রুপে ‘অ্যাসিস্ট্যান্ট ম্যানেজার’ পদে জনবল নিয়োগ দেওয়া হবে।  ', '/uploads/news/1773609325_Rupayon-696b5cedd511f-69b62ee9d1817.jpg', '[]', NULL, 17, '[\"চাকরি\",\"রুপায়ণ গ্ৰুপ\",\"দেবীগঞ্জ সংবাদ\"]', 2, NULL, 21, 0, 0, 1, 'published', '2026-03-15 17:15:25', NULL, '৬০ হাজার টাকা বেতনে রূপায়ণ গ্রুপে চাকরি', '', '৬০ হাজার টাকা বেতনে রূপায়ণ গ্রুপে চাকরি', '2026-03-15 21:15:25', '2026-06-30 07:27:51'),
(16, 'অনলাইন রিটার্ন দাখিলের সময়সীমা বাড়াল এনবিআর', 'NBR extends deadline for online return submission', 'nbr-extends-deadline-for-online-return-submission', '<p>&nbsp;ই-ভ্যাট সিস্টেমে অনলাইন রিটার্ন দাখিলের সময়সীমা আগামী ২৯ মার্চ পর্যন্ত বাড়িয়েছে জাতীয় রাজস্ব বোর্ড (এনবিআর)।</p><p>&nbsp;</p><p>রোববার (১৫ মার্চ) এনবিআরের প্রথম সচিব (অতিরিক্ত দায়িত্ব) নাহিদ নওশাদ মুকুল স্বাক্ষরিত এক চিঠিতে এ তথ্য জানানো হয়েছে।</p><p>&nbsp;</p><p>চিঠিতে বলা হয়, পবিত্র ঈদুল ফিতর ও মহান স্বাধীনতা দিবস উপলক্ষে দীর্ঘ সময় সরকারি ছুটি থাকায় এবং ই-ভ্যাট সিস্টেমের সেবা কিছুটা ধীরগতির হওয়ায় জনস্বার্থে এই সিদ্ধান্ত নেওয়া হয়েছে।</p><p>&nbsp;</p><p>জাতীয় রাজস্ব বোর্ড মূল্য সংযোজন কর ও সম্পূরক শুল্ক আইন, ২০১২-এর ধারা ৬৪-এর উপধারা (১ক)-এ প্রদত্ত ক্ষমতাবলে ই-ভ্যাট সিস্টেমে ফেব্রুয়ারি ২০২৬ কর মেয়াদের অনলাইন রিটার্ন দাখিলের সময়সীমা আগামী ২৯ মার্চ ২০২৬ পর্যন্ত বৃদ্ধি করেছে।</p>', ' ই-ভ্যাট সিস্টেমে অনলাইন রিটার্ন দাখিলের সময়সীমা আগামী ২৯ মার্চ পর্যন্ত বাড়িয়েছে জাতীয় রাজস্ব বোর্ড (এনবিআর)।', '/uploads/news/1773609708_NBR-69b664f692721.jpg', '[]', NULL, 4, '[\"ই-রিটার্ণ\",\"আয়কর\",\"এনবিআর\",\"দেবীগঞ্জ সংবাদ\"]', 2, NULL, 13, 0, 0, 0, 'published', '2026-03-15 17:21:48', NULL, 'অনলাইন রিটার্ন দাখিলের সময়সীমা বাড়াল এনবিআর', '', 'অনলাইন রিটার্ন দাখিলের সময়সীমা বাড়াল এনবিআর', '2026-03-15 21:21:48', '2026-06-21 02:40:33'),
(17, 'দেবীগঞ্জে শ্রমিক কল্যাণ ফেডারেশনের উদ্যোগে বৃদ্ধ চালককে ব্যাটারিচালিত ভ্যান প্রদান', 'Sramik Kalyan Federation provides battery-run van to elderly driver in Debiganj', 'sramik-kalyan-federation-provides-battery-run-van-to-elderly-driver-in-debiganj', '<p>পঞ্চগড়ের দেবীগঞ্জে বাংলাদেশ শ্রমিক কল্যাণ ফেডারেশন (দিনাজ-৬৪) দেবীগঞ্জ পৌরসভা শাখার উদ্যোগে এক অসচ্ছল ভ্যানচালককে ব্যাটারিচালিত ভ্যান প্রদান করা হয়েছে।</p><p>&nbsp;</p><p>রবিবার (১৫ মার্চ) বিকেলে দেবীগঞ্জ উপজেলা মডেল মসজিদ প্রাঙ্গণে আয়োজিত অনুষ্ঠানে পৌরসভার হঠাৎপাড়া এলাকার বাসিন্দা ৭৫ বছর বয়সী ভ্যানচালক মো. সুলতান আলীর হাতে এই ভ্যান তুলে দেওয়া হয়।</p><p>&nbsp;</p><p>আয়োজকরা জানান, সুলতান আলী দীর্ঘদিন ধরে প্যাডেল চালিত ভ্যান চালিয়ে জীবিকা নির্বাহ করে আসছিলেন। বয়সের ভারে সেই ভ্যান চালানো তার জন্য অত্যন্ত কষ্টকর হয়ে উঠেছিল। এছাড়া এলাকায় অধিকাংশ ভ্যান এখন ব্যাটারিচালিত হওয়ায় তিনি যাত্রীও কম পেতেন এবং ভাড়াও কম পেতেন। এতে তার পরিবারের ব্যয় নির্বাহ করা কঠিন হয়ে পড়েছিল। এ অবস্থায় তার জীবিকা সহজ করতে মানবিক সহায়তার অংশ হিসেবে তাকে একটি ব্যাটারিচালিত ভ্যান প্রদান করা হয়।</p><p>&nbsp;</p><p>অনুষ্ঠানে প্রধান অতিথি হিসেবে উপস্থিত ছিলেন বাংলাদেশ জামায়াতে ইসলামী পঞ্চগড় জেলা শাখার আমির মাওলানা মো. ইকবাল হোসাইন। বিশেষ অতিথি হিসেবে উপস্থিত ছিলেন বাংলাদেশ শ্রমিক কল্যাণ ফেডারেশন পঞ্চগড় জেলা শাখার সভাপতি আবুল বাশার বসুনিয়া। দেবীগঞ্জ উপজেলা রিক্সা-ভ্যান শ্রমিক ইউনিয়ন এর সাধারণ সম্পাদক মশিউর রহমানের সৌজন্যে ভ্যানটি প্রদান করা হয়।</p><p>&nbsp;</p><p>ভ্যানটি পেয়ে সুলতান আলী আয়োজকদের প্রতি কৃতজ্ঞতা প্রকাশ করেন এবং বলেন, নতুন এই ভ্যান তার জীবিকা নির্বাহকে সহজ করবে।</p><p>&nbsp;</p><p>&nbsp;</p>', 'পঞ্চগড়ের দেবীগঞ্জে বাংলাদেশ শ্রমিক কল্যাণ ফেডারেশন (দিনাজ-৬৪) দেবীগঞ্জ পৌরসভা শাখার উদ্যোগে এক অসচ্ছল ভ্যানচালককে ব্যাটারিচালিত ভ্যান প্রদান করা হয়েছে।', '/uploads/news/1773610078_InShot_20260315_201554325.jpg', '[\"/uploads/gallery/1773610078_InShot_20260315_201625675.jpg\"]', NULL, 10, '[\"বৃদ্ধ ভ্যান চালক\",\"ব্যাটারি চালিত ভ্যান\",\"শ্রমিক কল্যাণ ফেডারেশন\",\"দেবীগঞ্জ\",\"পঞ্চগড়\"]', 2, NULL, 6, 1, 0, 1, 'draft', NULL, NULL, '', '', '', '2026-03-15 21:27:58', '2026-06-03 08:06:45'),
(18, 'ফিলিং স্টেশনে তেল নিতে এসে প্রাণ গেল দুই জনের', 'Two killed at filling station while refuelling.', 'two-killed-at-filling-station-while-refuelling', '<p>&nbsp;রাজবাড়ীর সদর উপজেলায় ফিলিং স্টেশনে তেল নিতে এসে বেপরোয়া ট্রাকের চাপায় দুইজন নিহত হয়েছেন।</p><p>&nbsp;</p><p>রোববার (১৫ মার্চ) সন্ধ্যার পর সদর উপজেলার গোয়ালন্দ মোড় এলাকায় সপ্তবর্ণা ফিলিং স্টেশনে এ দুর্ঘটনা ঘটে।</p><p>নিহতরা হলেন- রাজবাড়ী সদর উপজেলার খানখানাপুর ব্রাকপাড়া এলাকার ইদ্রিস পাটোয়ারীর ছেলে (ট্রাক মালিক) সোবাহান পাটোয়ারী (৪৫) এবং ঢাকার ধামরাই উপজেলার নান্নার গ্রামের সরল মিয়ার ছেলে স্বপন মিয়া (২২)।</p><p>&nbsp;</p><p>স্থানীয় বিএনপি নেতা মো. সোবাহান জানান, ড্রাম ট্রাকের মালিক সোবাহান পাটোয়ারী তার ট্রাকে তেল নেওয়ার জন্য সপ্তবর্ণা ফিলিং স্টেশনে এসে ট্রাক থেকে নেমে ডিজেল সরবরাহকারী ফুয়েল ডিসপেনসার মেশিনের সামনে দাঁড়িয়ে ছিলেন। একই সময় ঢাকা থেকে বেনাপোলগামী একটি ট্রাকের হেলপার স্বপন মিয়া ট্রাকটি সিরিয়ালে রেখে মেশিনের সামনে দাঁড়ান। এসময় একটি মাহেন্দ্র গাড়ি ফুয়েল ডিসপেনসার থেকে তেল নিচ্ছিল। হঠাৎ একটি ট্রাক বেপরোয়া গতিতে পাম্পে ঢুকে পেছন দিক থেকে মাহেন্দ্র গাড়িটিকে ধাক্কা দেয়। এতে মাহেন্দ্রটির সামনে দাঁড়িয়ে থাকা সোবাহান পাটোয়ারী ও স্বপন মিয়া ট্রাকের চাপায় গুরুতর আহত হন।</p><p>&nbsp;</p><p>পরে স্থানীয়রা তাদের উদ্ধার করে ফরিদপুর মেডিকেল কলেজ হাসপাতালে নিয়ে গেলে কর্তব্যরত চিকিৎসক দুজনকেই মৃত ঘোষণা করেন।</p><p>&nbsp;</p><p>রাজবাড়ীর খানখানাপুর পুলিশ তদন্তকেন্দ্রের ইনচার্জ হারুন-অর-রশিদ জানান, দুর্ঘটনায় জড়িত ট্রাকটি জব্দ করা হয়েছে। তবে ট্রাকের চালক ও হেলপার পালিয়ে গেছে। নিহতদের মরদেহ ফরিদপুর মেডিকেল কলেজ হাসপাতালের মর্গে রয়েছে। ময়নাতদন্ত শেষে পরিবারের কাছে মরদেহ হস্তান্তর করা হবে।</p><p>&nbsp;</p><p>এ ঘটনায় পরবর্তী আইনগত ব্যবস্থা প্রক্রিয়াধীন বলেও জানান তিনি।</p>', 'রাজবাড়ীর সদর উপজেলায় ফিলিং স্টেশনে তেল নিতে এসে বেপরোয়া ট্রাকের চাপায় দুইজন নিহত হয়েছেন।', '/uploads/news/1773610442_image_274441_1773604394.webp', '[]', NULL, 20, '[\"ফিলিং স্টেশন\",\"তেল\",\"নিহত\",\"\"]', 1, NULL, 218, 1, 0, 1, 'published', '2026-03-15 17:34:02', NULL, ' তেল নিতে এসে প্রাণ গেল দুই জনের', '', 'ফিলিং স্টেশনে তেল নিতে এসে প্রাণ গেল দুই জনের', '2026-03-15 21:34:02', '2026-08-08 16:57:17'),
(19, 'ঈদুল ফিতরের তারিখ জানাল অস্ট্রেলিয়া', 'Australia has announced the date for Eid-ul-Fitr', 'australia-has-announced-the-date-for-eid-ul-fitr', '<p>স্থানীয় ও আন্তর্জাতিক জ্যোতির্বিজ্ঞানীদের সঙ্গে পরামর্শ এবং বৈশ্বিক মানমন্দিরের হিসাব-নিকাশ বিশ্লেষণ করে ঈদুল ফিতরের তারিখ ঘোষণার সিদ্ধান্ত নিয়েছে অস্ট্রেলিয়ার ফাতওয়া কাউন্সিল। সে হিসেবে আগামী ২০ মার্চ শুক্রবার অস্ট্রেলিয়ায় পবিত্র ঈদুল ফিতর উদযাপিত হবে।</p><p>&nbsp;</p><p>অস্ট্রেলিয়ার ফাতওয়া কাউন্সিলের সিদ্ধান্ত অনুযায়ী, অস্ট্রেলিয়ায় রমজান মাস শেষ হচ্ছে আগামী ১৯ মার্চ বৃহস্পতিবার। সেই হিসেবে ২০ মার্চ শুক্রবার দেশটিতে পবিত্র ঈদুল ফিতর এবং ১৪৪৭ হিজরি সালের শাওয়াল মাসের প্রথম দিন পালিত হবে। শনিবার (১৪ মার্চ) এক বিজ্ঞপ্তির মাধ্যমে দেশটির জাতীয় ইমাম পরিষদ ও ফাতওয়া কাউন্সিল এই ঘোষণা দিয়েছে।</p><p>&nbsp;</p><p>কাউন্সিল জানিয়েছে, নতুন চাঁদের জন্ম, সূর্যাস্ত এবং অস্ট্রেলিয়া ও এর আশপাশের অঞ্চলে চাঁদের দৃশ্যমানতা সংক্রান্ত গাণিতিক হিসাব পুঙ্খানুপুঙ্খভাবে বিশ্লেষণ করে এই তারিখ নির্ধারণ করা হয়েছে। বিশ্বজুড়ে প্রখ্যাত আলেমদের অনুমোদিত পদ্ধতি অনুসরণ করেই এই সিদ্ধান্ত নেওয়া হয়েছে বলে জানানো হয়।</p><p>&nbsp;</p><p>তবে চাঁদ দেখার বিষয়ে অন্যান্য ইমাম বা আলেমদের ভিন্ন মত থাকতে পারে বলে স্বীকার করেছে ইমাম পরিষদ। তারা এই পার্থক্যগুলোকে সম্মান জানিয়ে মুসলিমদের ঐক্যবদ্ধ থাকার এবং নিজেদের মূল্যবোধ বজায় রাখার আহ্বান জানিয়েছেন।</p><p>&nbsp;</p><p>অস্ট্রেলিয়ার গ্র্যান্ড মুফতি ড. ইব্রাহিম আবু মোহাম্মদ এবং জাতীয় ইমাম পরিষদের সদস্যরা দেশটির মুসলিমদের ঈদের আগাম শুভেচ্ছা জানিয়েছেন। ঈদ উদযাপনের পাশাপাশি অস্ট্রেলীয় মুসলিমদের প্রতি তারা বিশেষ কিছু আহ্বান জানিয়েছেন।</p><p>ঈদ উদযাপনের পাশাপাশি তারা গাজার ফিলিস্তিনি ভাই-বোনদের জন্য দোয়া করতে &nbsp;এবং সামর্থ্য অনুযায়ী তাদের সাহায্যার্থে অনুদান দেওয়ার আহ্বান জানিয়েছেন।</p><p>&nbsp;</p><p>&nbsp;একইসঙ্গে প্রতিবেশী ও বন্ধুদের সঙ্গে মেলামেশার মাধ্যমে ইসলামের শান্তির বার্তা ও সঠিক ভাবমূর্তি তুলে ধরতে বলেছেন।</p><p>জ্যোতির্বিজ্ঞানের বৈশ্বিক মানদণ্ড অনুযায়ী শাওয়াল মাসের সূচনার এই নিখুঁত হিসাব নিশ্চিত করা হয়েছে। এর মাধ্যমে মতভেদ থাকলেও মুসলিমদের মধ্যে একটি সুশৃঙ্খল ও নির্ভুলভাবে ঈদ উদযাপনের পরিবেশ তৈরি হবে বলে আশা প্রকাশ করেছে কাউন্সিল।</p><p>সূত্র : গালফ নিউজ</p>', 'জ্যোতির্বিজ্ঞানীদের সঙ্গে পরামর্শ এবং বৈশ্বিক মানমন্দিরের হিসাব-নিকাশ বিশ্লেষণ করে ঈদুল ফিতরের তারিখ ঘোষণার সিদ্ধান্ত নিয়েছে অস্ট্রেলিয়ার ফাতওয়া কাউন্সিল। সে হিসেবে আগামী ২০ মার্চ শুক্রবার অস্ট্রেলিয়ায় পবিত্র ঈদুল ফিতর উদযাপিত হবে।', '/uploads/news/1773610896_Eid-69b57759b9fe3.jpg', '[]', NULL, 14, '[\"ইদুল ফিতর\",\"তারিখ\",\"অস্ট্রেলিয়া\",\"\"]', 2, NULL, 9, 1, 0, 1, 'draft', NULL, NULL, 'ঈদুল ফিতরের তারিখ জানাল অস্ট্রেলিয়া', '', 'ঈদুল ফিতরের তারিখ জানাল অস্ট্রেলিয়া', '2026-03-15 21:41:36', '2026-06-01 06:26:36'),
(20, 'নিজেদের আকাশসীমা বন্ধ করে দিল আরব আমিরাত', 'UAE closes its airspace', 'uae-closes-its-airspace', '<p>অস্থায়ীভাবে নিজেদের পুরো আকাশসীমা বন্ধ করে দিয়েছে সংযুক্ত আরব আমিরাত। আজ মঙ্গলবার বাংলাদেশ সময় ভোর ৫টা ১০ মিনিটের দিকে আমিরাত জানায় ইরান তাদের লক্ষ্য করে নতুন করে মিসাইল ও ড্রোন নিক্ষেপ করেছে। এর কিছুক্ষণ পরই পুরো আকাশসীমা বন্ধের তথ্য দিলো দেশটি।</p><p>&nbsp;</p><p>আমিরাতের বেসামরিক বিমান চলাচল কর্তৃপক্ষ এ ঘোষণা দিয়েছে। দেশটির সরকারি সংবাদমাধ্যম জানিয়েছে, বিমানের ফ্লাইট ও ক্রুদের নিরাপত্তা এবং আমিরাতের ভূখণ্ডের কথা বিবেচনা করে এ সিদ্ধান্ত নেওয়া হয়েছে।</p><p>ইরানের সঙ্গে যুদ্ধ শুরু হওয়ার পর এখন পর্যন্ত ১৩ মার্কিন সেনা নিহত হয়েছেন। আহত হয়েছেন ২০০ জন, এদের মধ্যে ১০ জন গুরুতর আহত হয়েছেন। মার্কিন সেন্ট্রাল কমান্ডের মুখপাত্র ক্যাপ্টেন টিম হকিন্স এ তথ্য জানিয়েছেন।</p><p>হকিন্স বলেছেন, ১৮০ সেনাসদস্য ইতোমধ্যেই কাজে ফিরে এসেছেন। আহতদের মধ্যে দগ্ধ হওয়া, আঘাতজনিত মস্তিষ্কের ক্ষতি এবং বিস্ফোরণের টুকরো দ্বারা আঘাত অন্তর্ভুক্ত।</p><p>সামরিক কর্মকর্তারা বলেছেন, অনেক আক্রমণ ইরানের ‘একমুখী’ ড্রোন হামলার কারণে ঘটেছে। মার্কিন বাহিনীর যৌথ চিফস অব স্টাফ চেয়ারম্যান জেনারেল ড্যান কেইন গত সপ্তাহে বলেছিলেন, এই ধরনের ড্রোন বেশিরভাগ হতাহতের জন্য দায়ী।</p><p>গত ২৮ ফেব্রুয়ারি ইরানে যৌথ আগ্রাসন শুরু করে যুক্তরাষ্ট্র ও ইসরাইল। ইরানও ইসরাইল ও যুক্তরাষ্ট্রের মিত্র হিসেবে পরিচিত কয়েকটি উপসাগরীয় দেশে পালটা হামলা চালাচ্ছে।</p><p>সূত্র: আলজাজিরা</p><p>&nbsp;</p>', '', '/uploads/news/1773736225_Emirat.jpg', '[]', NULL, 2, '[\"ইরান\",\"আমিরাত\",\"\"]', 1, NULL, 37, 0, 0, 1, 'published', '2026-03-17 04:30:25', NULL, '', '', '', '2026-03-17 08:30:25', '2026-08-08 16:57:18'),
(21, ' ফুলবাড়ীতে বেড়েছে কুকুরের উৎপাত;  স্কুলগামী শিশুদের চলাচলে বাধা', '\"Increased stray dog activity in Phulbari is obstructing the commute of school students', 'increased-stray-dog-activity-in-phulbari-is-obstructing-the-commute-of-school-students', '<p>দেবীগঞ্জ উপজেলার চিলাহাটি ইউনিয়নের ফুলবাড়ি এলাকায় সাম্প্রতিক সময়ে রাস্তার কুকুরের উৎপাত আশঙ্কাজনক হারে বেড়ে যাওয়ায় জনজীবনে দেখা দিয়েছে চরম ভোগান্তি। কুকুরের ভয়ে ভোর ও রাতের বেলায় অনেকেই একা বাইরে বের হতে পারছেন না।</p><p>&nbsp;</p><p>স্থানীয় সূত্রে জানা যায়, ফজরের নামাজ আদায়ে মসজিদমুখী মুসল্লিদের সবচেয়ে বেশি সমস্যায় পড়তে হচ্ছে। ভোরবেলায় বিভিন্ন সড়কে কুকুরের দল অবস্থান নিয়ে পথচারীদের তাড়া দিচ্ছে। এতে অনেক মুসল্লি একা মসজিদে যেতে ভয় পাচ্ছেন।</p><p>একই পরিস্থিতির শিকার হচ্ছে স্কুলগামী শিক্ষার্থীরাও। কুকুরের ভয়ে অনেক শিশু একা স্কুলে যেতে পারছে না। ফলে অভিভাবকদের তাদের সঙ্গে করে স্কুলে নিয়ে যেতে হচ্ছে। এতে অভিভাবকদের দৈনন্দিন কাজে বিঘ্ন সৃষ্টি হচ্ছে।</p><p>&nbsp;</p><p>কুকুরের উৎপাতের প্রভাব পড়েছে গবাদিপশু পালনেও। স্থানীয় খামারিরা জানান, কুকুরের আক্রমণের আশঙ্কায় ছাগলসহ অন্যান্য গবাদিপশু বাইরে ছেড়ে দেওয়া যাচ্ছে না। বাধ্য হয়ে সার্বক্ষণিক নজরদারিতে রাখতে হচ্ছে, যা সময় ও শ্রম—দুটোরই বাড়তি চাপ তৈরি করছে।</p><p>&nbsp;</p><p>এলাকাবাসীর দাবি, ইতোমধ্যে কয়েকটি কামড়ের ঘটনাও ঘটেছে। কয়েকদিন আগে আকবর আলী (৩০) নামে এক ব্যক্তি এবং মাসুম (৯) নামে এক শিশু কুকুরের কামড়ে আহত হয়েছেন। এসব ঘটনার পর এলাকায় আতঙ্ক আরও বেড়েছে।</p><p>&nbsp;</p><p>স্থানীয় বাসিন্দাদের ভাষ্য, সন্ধ্যা ও রাতের বেলায় কুকুরের দল সড়কে জড়ো হয়ে আক্রমণাত্মক আচরণ করছে। হঠাৎ করে পথচারীদের দিকে ছুটে আসার ঘটনায় নারী, শিশু ও বয়স্করা সবচেয়ে বেশি ঝুঁকিতে রয়েছেন।</p><p>&nbsp;</p><p>এ বিষয়ে দ্রুত কার্যকর ব্যবস্থা গ্রহণের দাবি জানিয়েছেন এলাকাবাসী। তাদের মতে, সময়মতো উদ্যোগ না নিলে বড় ধরনের দুর্ঘটনার আশঙ্কা রয়েছে।</p><p>&nbsp;</p><p>এ ব্যাপারে স্থানীয় জনপ্রতিনিধি ও সংশ্লিষ্ট প্রশাসনের সঙ্গে যোগাযোগের চেষ্টা করা হলেও তাৎক্ষণিক কোনো বক্তব্য পাওয়া যায়নি।</p>', 'দেবীগঞ্জ উপজেলার চিলাহাটি ইউনিয়নের ফুলবাড়ি এলাকায় সাম্প্রতিক সময়ে রাস্তার কুকুরের উৎপাত আশঙ্কাজনক হারে বেড়ে যাওয়ায় জনজীবনে দেখা দিয়েছে চরম ভোগান্তি।', '/uploads/news/1774811597_dog-1713705229.jpg', '[]', NULL, 10, '[\"কুকুর\",\"উৎপাত\",\"শিশু\",\"দূর্ভোগ\",\"চিলাহাটি ইউনিয়নের\",\"ফুলবাড়ী\",\"দেবীগঞ্জ সংবাদ\",\"\"]', 4, NULL, 21, 0, 0, 0, 'published', '2026-03-29 15:13:17', NULL, 'ফুলবাড়ীতে বেড়েছে কুকুরের উৎপাত; স্কুলগামী শিশুদের চলাচলে বাধা | \"Increased stray dog activity in Phulbari is obstructing the commute of school students', 'দেবীগঞ্জ উপজেলার চিলাহাটি ইউনিয়নের ফুলবাড়ি এলাকায় সাম্প্রতিক সময়ে রাস্তার কুকুরের উৎপাত আশঙ্কাজনক হারে বেড়ে যাওয়ায় জনজীবনে দেখা দিয়েছে চরম ভোগান্তি।', 'Increased, stray, activity, Phulbari, obstructing, commute, school, students', '2026-03-29 19:13:17', '2026-07-29 19:03:03'),
(22, 'গাছের বন্ধু কাঠশালিক', 'Woodpeckers: The Guardians of Our Trees', 'woodpeckers-the-guardians-of-our-trees', '<p>কাঠশালিক পরিবেশবান্ধব এক প্রজাতির উপকারী পাখি। খয়রালেজ- কাঠশালিক আমাদের দেশের সুলভ আবাসিক পাখি। এর ইংরেজি নাম Chestnut-tailed Starling এবং বৈজ্ঞানিক নাম Sturnia malabarica।</p><p>কাঠ শালিক অন্যান্য পাখি আমাদের প্রতিবেশী হলেও এদের ভেতর মানুষকে এড়িয়ে চলার প্রবণতা দেখা যায় বেশি। যার ফলে পরিচিত এ পাখি সর্বসাধারণের কাছে অপরিচিত রয়ে গেছে অদ্যাবধি।</p><p>&nbsp;</p><p>বাংলাদেশ বার্ড ক্লাবের প্রতিষ্ঠাতা এবং প্রখ্যাত পাখি বিশেষজ্ঞ ইনাম আল হক বলেন, খয়রালেজ-কাঠশালিক গাছের পাতা ফাঁকে ফাঁকে ঘুরে পোকা ধরে খায়। তারা আমাদের দেশের গাছের বড় বন্ধু। চা বাগানের ছোট ছোট গাছে বা আমাদের সবজি ক্ষেতে আমরা নানা জাতে কীটনাশক দিয়ে পাতাগুলোকে রক্ষা করি। কিন্তু আমাদের চারপাশের বড় বড় গাছগুলোতে তো আমরা কীটনাশক দিতে পারি না। এই যে এতো এতো গাছ রয়েছে; যারা অক্সিজেন তৈরি করে বলে আমরা বেঁচে আছি। সেইসব অক্সিজেন সরবরাহকারী গাছদের প্রধান শত্রু হলো পাতার নিচে ঘুড়ে বেড়ানো নানা জাতের পোকা-কীটপতঙ্গ। কারণ এ সকল পোকাই প্রতিদিন তাদের পাতা খেয়ে ফেলে। সেই সব ক্ষতিকর পোকাদের ধ্বংস করার জন্য প্রকৃতিতে পাখিদের যে বিশাল বাহিনী রয়েছে তার মধ্যে অন্যতম ‘খয়রালেজ-কাঠশালিক’।</p><p>&nbsp;</p>', 'খয়রালেজ-কাঠশালিক গাছের পাতা ফাঁকে ফাঁকে ঘুরে পোকা ধরে খায়। তারা আমাদের দেশের গাছের বড় বন্ধু। ', '/uploads/news/1774813181_InShot_20260330_013918436.jpg', '[]', NULL, 15, '[\"কাঠ শালিক\",\"গাছের বন্ধু\",\"প্রাণ ও প্রকৃতি\",\"ফিচার\",\"দেবীগঞ্জ সংবাদ\",\"প\"]', 5, NULL, 24, 0, 1, 1, 'published', '2026-03-29 15:36:35', NULL, 'গাছের বন্ধু কাঠশালিক | Woodpeckers: The Guardians of Our Trees', 'খয়রালেজ-কাঠশালিক গাছের পাতা ফাঁকে ফাঁকে ঘুরে পোকা ধরে খায়। তারা আমাদের দেশের গাছের বড় বন্ধু।', 'Woodpeckers, Guardians, Trees', '2026-03-29 19:36:35', '2026-08-08 16:57:20'),
(23, 'ঢাকা-বরিশাল মহাসড়কে বাস খাদে; নিহত-১ আহত-৩', 'Bus plunges into ditch on Dhaka-Barisal highway; 1 killed, 3 injured', 'bus-plunges-into-ditch-on-dhaka-barisal-highway-1-killed-3-injured', '<p>ঢাকা-বরিশাল মহাসড়কের গৌরনদী উপজেলার বাটাজোর এলাকায় যাত্রীবাহী বাস নিয়ন্ত্রণ হারিয়ে খাদে পড়ে এক নারী নিহত হয়েছেন। এ ঘটনায় আরও তিনজন যাত্রী গুরুতর আহত হয়েছেন।</p><p>&nbsp;</p><p>রোববার (২৯ মার্চ) ভোর প্রায় ৫টার দিকে এ দুর্ঘটনা ঘটে।</p><p>&nbsp;</p><p>নিহত ইতি চক্রবর্তী (৩৫) বরিশাল নগরীর কাউনিয়া এলাকার গুরুদাস চক্রবর্তীর স্ত্রী।</p><p>গৌরনদী ফায়ার সার্ভিস সূত্র জানায়, দুর্ঘটনার খবর পেয়ে ফায়ার সার্ভিসের একটি উদ্ধারকারী দল দ্রুত ঘটনাস্থলে পৌঁছে বাসের ভেতর থেকে আহতদের উদ্ধার করে স্থানীয় হাসপাতালে পাঠায়।</p><p>&nbsp;</p><p>গৌরনদী হাইওয়ে থানার ওসি মো. শামীম শেখ জানান, বরিশালগামী যাত্রীবাহী গ্রীনভিউ পরিবহনের একটি বাস নিয়ন্ত্রণ হারিয়ে মহাসড়কের পাশের খাদে পড়ে যায়। এতে বাসের অন্তত চারজন যাত্রী আহত হন।</p><p>আহতদের উদ্ধার করে গৌরনদী উপজেলা স্বাস্থ্য কমপ্লেক্সে নেওয়া হলে কর্তব্যরত চিকিৎসক ইতি চক্রবর্তীকে মৃত ঘোষণা করেন। পরে গুরুতর আহত অন্যদের বরিশাল শের-ই বাংলা মেডিক্যাল কলেজ হাসপাতালে পাঠানো হয়।</p><p>&nbsp;</p><p>পুলিশ জানায়, দুর্ঘটনাকবলিত বাসটি জব্দ করা হয়েছে এবং এ ঘটনায় আইনগত ব্যবস্থা নেওয়ার প্রক্রিয়া চলছে। দুর্ঘটনার পর কিছু সময় মহাসড়কে যান চলাচল ধীরগতির হলেও পরে পরিস্থিতি স্বাভাবিক হয়।</p>', 'ঢাকা-বরিশাল মহাসড়কের গৌরনদী উপজেলার বাটাজোর এলাকায় যাত্রীবাহী বাস নিয়ন্ত্রণ হারিয়ে খাদে পড়ে এক নারী নিহত হয়েছেন। এ ঘটনায় আরও তিনজন যাত্রী গুরুতর আহত হয়েছেন।', '/uploads/news/1774858900_IMG-20260330-WA0004.jpg', '[]', NULL, 20, '[\"সড়ক দুর্ঘটনা\",\"বাস\",\"মৃত্যু\",\"বরিশাল\",\"দেবীগঞ্জ সংবাদ\"]', 1, NULL, 208, 1, 0, 0, 'published', '2026-03-30 04:21:40', NULL, 'ঢাকা-বরিশাল মহাসড়কে বাস খাদে; নিহত-১ আহত-৩ | Bus plunges into ditch on Dhaka-Barisal highway; 1 killed, 3 injured', 'ঢাকা-বরিশাল মহাসড়কের গৌরনদী উপজেলার বাটাজোর এলাকায় যাত্রীবাহী বাস নিয়ন্ত্রণ হারিয়ে খাদে পড়ে এক নারী নিহত হয়েছেন। এ ঘটনায় আরও তিনজন যাত্রী গুরুতর আহত হয়েছেন।', 'plunges, into, ditch, Dhaka, Barisal, highway, killed, injured', '2026-03-30 08:21:40', '2026-08-08 16:57:22'),
(24, 'পঞ্চগড়ে ফুয়েল কার্ড ছাড়া মিলবে না তেল', 'Fuel supply in Panchagarh restricted to fuel card holders only', 'fuel-supply-in-panchagarh-restricted-to-fuel-card-holders-only', '<p>পঞ্চগড়ের পাঁচ উপজেলায় জ্বালানি তেলের সরবরাহ নিয়ন্ত্রণ ও সুশৃঙ্খল করতে ফুয়েল কার্ড চালুর সিদ্ধান্ত নিয়েছে জেলা প্রশাসন।&nbsp;</p><p>&nbsp;</p><p>&nbsp;সোমবার (৩০ মার্চ) জেলা প্রশাসনের পক্ষ থেকে এই সিদ্ধান্তের বিষয়টি জানানো হয়। নতুন এ ব্যবস্থার আওতায় মোটরসাইকেলে তেল নিতে হলে নির্ধারিত ফুয়েল কার্ড বাধ্যতামূলক করা হয়েছে।</p><p>&nbsp;</p><p>জেলা প্রশাসনের নির্দেশনায় বলা হয়েছে, মোটরসাইকেলের বৈধ কাগজপত্র যেমন ড্রাইভিং লাইসেন্স, রেজিস্ট্রেশন ও ট্যাক্স টোকেন এবং হেলমেট ছাড়া কোনো মোটরসাইকেলে তেল দেওয়া হবে না। শুধুমাত্র মোটরসাইকেলের জন্য সকাল ৯টা থেকে সন্ধ্যা ৬টা পর্যন্ত জেলার সব ফিলিং স্টেশন থেকে জ্বালানি তেল সরবরাহ করা হবে।</p><p>&nbsp;</p><p>আবেদনকারীদের ফুয়েল কার্ড সংগ্রহের জন্য উপজেলা প্রশাসন বা জেলা প্রশাসনের ওয়েবসাইট কিংবা “জেলা প্রশাসন পঞ্চগড়” ফেসবুক পেজ থেকে ফরম ডাউনলোড করে প্রিন্ট করতে হবে। এরপর সংশ্লিষ্ট উপজেলা নির্বাহী কর্মকর্তা অথবা পঞ্চগড় সদর পৌরসভার ক্ষেত্রে বিআরটিএ ইন্সপেক্টরের স্বাক্ষর নিতে হবে। এই কার্ড ছাড়া কোনো ফিলিং স্টেশন বা ডিলার পয়েন্ট থেকে তেল দেওয়া হবে না।</p><p>&nbsp;</p><p>এছাড়া প্লাস্টিক বোতল, ড্রাম বা অন্য কোনো কন্টেইনারে তেল সরবরাহ সম্পূর্ণ নিষিদ্ধ করা হয়েছে। ফিলিং স্টেশন ও অনুমোদিত ডিলার পয়েন্ট ছাড়া খোলা বাজারে জ্বালানি তেল ক্রয়-বিক্রয়ও বন্ধ থাকবে।</p><p>একজন গ্রাহক দিনে সর্বোচ্চ ৩০০ টাকার জ্বালানি তেল সংগ্রহ করতে পারবেন বলে জানানো হয়েছে। একইসঙ্গে সুশৃঙ্খলভাবে লাইনে দাঁড়িয়ে তেল নেওয়ার জন্য অনুরোধ জানিয়েছে প্রশাসন।</p><p>&nbsp;</p><p>অতিরিক্ত জেলা প্রশাসক (সার্বিক) সুমন চন্দ্র দাশ বিষয়টি নিশ্চিত করে বলেন, এপ্রিলের ২ তারিখের পর থেকে ফুয়েল কার্ড ব্যতীত কাউকে ফুয়েল দেওয়া হবে না।</p><p>&nbsp;</p><p><br>&nbsp;</p>', 'পঞ্চগড়ের পাঁচ উপজেলায় জ্বালানি তেলের সরবরাহ নিয়ন্ত্রণ ও সুশৃঙ্খল করতে ফুয়েল কার্ড চালুর সিদ্ধান্ত নিয়েছে জেলা প্রশাসন। ', '/uploads/news/1774875159_InShot_20260330_183050131.jpg', '[]', NULL, 20, '[\"ফুয়েল কার্ড\",\"জ্বালানি তেল\",\"পেট্রোল পাম্প\",\"পঞ্চগড়\",\"দেবীগঞ্জ সংবাদ\"]', 2, NULL, 239, 1, 1, 1, 'published', '2026-03-30 08:52:13', NULL, 'পঞ্চগড়ে ফুয়েল কার্ড ছাড়া মিলবে না তেল | Fuel supply in Panchagarh restricted to fuel card holders only', 'পঞ্চগড়ের পাঁচ উপজেলায় জ্বালানি তেলের সরবরাহ নিয়ন্ত্রণ ও সুশৃঙ্খল করতে ফুয়েল কার্ড চালুর সিদ্ধান্ত নিয়েছে জেলা প্রশাসন।', 'Fuel, supply, Panchagarh, restricted, fuel, card, holders, only, সরবর', '2026-03-30 12:29:19', '2026-08-08 16:57:28'),
(25, 'দেবীগঞ্জে অর্ধবার্ষিক পরীক্ষার আগেই শিক্ষার্থীর হোয়াটসঅ্যাপে প্রশ্ন পাঠানোর অভিযোগ শিক্ষকের বিরুদ্ধে ', 'Sending questions to a student\'s WhatsApp before the half-yearly exam in Debiganj.', 'sending-questions-to-a-student-s-whatsapp-before-the-half-yearly-exam-in-debiganj', '<p>পঞ্চগড়ের দেবীগঞ্জ উপজেলার নৃপেন্দ্র নারায়ন সরকারি উচ্চ বিদ্যালয়ের সহকারী শিক্ষক (ইংরেজি) মহাদেব রায়ের বিরুদ্ধে অর্ধবার্ষিক পরীক্ষার আগেই একজন শিক্ষার্থীর হোয়াটসঅ্যাপে দশম শ্রেণির ইংরেজি প্রথম পত্রের প্রশ্নের অংশ পাঠানোর অভিযোগ উঠেছে।&nbsp;</p><p>বুধবার (১ জুলাই) সকাল সাড়ে ১০টায় সরেজমিনে বিদ্যালয়ে গিয়ে চলমান অর্ধবার্ষিক পরীক্ষার দশম শ্রেণির ইংরেজি প্রথম পত্রের প্রশ্নপত্রের সঙ্গে প্রতিবেদকের হাতে থাকা একটি হোয়াটসঅ্যাপ স্ক্রিনশট মিলিয়ে দেখা যায়, স্ক্রিনশটে থাকা প্রশ্নের অংশটির সঙ্গে পরীক্ষার প্রশ্নপত্রের হুবহু মিল রয়েছে।</p><p>প্রতিবেদকের হাতে আসা স্ক্রিনশটে দেখা যায়, \"Mahadev Sir\" &nbsp;নামে সংরক্ষিত একটি হোয়াটসঅ্যাপ অ্যাকাউন্ট থেকে একজন শিক্ষার্থীর কাছে ইংরেজি প্রথম পত্রের ২ নম্বর প্রশ্ন পাঠানো হয়েছে। সেখানে লেখা ছিল- &nbsp;\"Answer the following questions:</p><p>a. What is Mainul Islam\'s profession?**</p><p>b. Why did Mainul Islam choose farming instead of a city job ?</p><p>c. How do Mainul Islam and his brothers challenge the common belief about educated people\'s careers ?</p><p>d. Why does the writer call Mainul Islam and his brothers \'torch bearers\' ?</p><p>e. What message does the passage convey to educated young people?\"</p><p>&nbsp;</p><p>পরীক্ষার প্রশ্নপত্রে একই প্রশ্ন হুবহু পাওয়া যায়।</p><p>বিদ্যালয় সূত্রে জানা গেছে, চলতি অর্ধবার্ষিক পরীক্ষার দশম শ্রেণির ইংরেজি প্রথম পত্রের প্রশ্ন প্রণয়ন করেন বিদ্যালয়ের সহকারী শিক্ষক (ইংরেজি) মহাদেব রায়। বিদ্যালয় সূত্রে আরও জানা গেছে, বিদ্যালয়ের প্রচলিত নিয়ম অনুযায়ী যে শিক্ষক যে বিষয়ে ক্লাস নেন তিনি প্রশ্ন প্রণয়ন করেন, তিনিই প্রশ্নপত্র প্রিন্ট করে খামে সিলগালা করে ভারপ্রাপ্ত প্রধান শিক্ষকের কাছে জমা দেন। পরীক্ষা শুরুর নির্ধারিত সময়ে সেই সিলগালা খাম খুলে শিক্ষার্থীদের মধ্যে প্রশ্নপত্র বিতরণ করা হয়। ফলে পরীক্ষা শুরুর আগেই কোনো প্রশ্নপত্র বাইরে চলে গেলে বা ফাঁসের ঘটনা ঘটলে তার দায় সংশ্লিষ্ট প্রশ্ন প্রণয়নকারী শিক্ষকের ওপর বর্তায় বলে বিদ্যালয় সূত্রের দাবি।</p><p>অভিযুক্ত সহকারী শিক্ষক মহাদেব রায়ের বক্তব্য জানতে একাধিকবার মুঠোফোনে যোগাযোগ করা হলেও ফোন রিসিভ না করায় তার বক্তব্য পাওয়া যায়নি।</p><p>এ বিষয়ে বিদ্যালয়ের ভারপ্রাপ্ত প্রধান শিক্ষক জি এম রুহুল আমিন বলেন, মহাদেব বাবুর প্রশ্ন ফাঁসের বিষয়টি নিয়ে আমাদের নজরে এসেছে। আমরা অভ্যন্তরীণভাবে তদন্ত করবো। তদন্ত স্বাপেক্ষে প্রয়োজনীয় যে ব্যবস্থা গ্রহণ করা দরকার তা করা হবে।</p><p>&nbsp;</p><p>দেবীগঞ্জ উপজেলা নির্বাহী কর্মকর্তা ইন্দ্রজিত সাহা বলেন, আপনাদের মাধ্যমে এই বিষয়টি আমাদের নজরে এসেছে। আমরা বিদ্যালয় পরিদর্শন করে তদন্ত সাপেক্ষে প্রয়োজনীয় ব্যবস্থা গ্রহণ করবো।</p><p>এ বিষয়ে মাধ্যমিক ও উচ্চ শিক্ষা অধিদপ্তরের রংপুর অঞ্চলের উপ-পরিচালক মোছা. রোকসানা বেগম বলেন, একজন শিক্ষক যদি প্রশ্ন ফাঁস করে তাহলে মানসম্পন্ন শিক্ষা কীভাবে নিশ্চিত হবে। প্রশ্ন ফাঁসের বিষয়ে তদন্ত করে প্রয়োজনীয় ব্যবস্থা নিতে উর্ধ্বতন কর্তৃপক্ষকে জানাবো।</p><p>উল্লেখ্য, এর আগেও সহকারী শিক্ষক মহাদেব রায়ের বিরুদ্ধে শিক্ষার্থীদের নিজ বাসায় প্রাইভেট পড়তে ও বিশেষ কোচিং ক্লাসে বাধ্য করার অভিযোগ ওঠে। অভিযোগ ছিল, তার কাছে প্রাইভেট না পড়লে পরীক্ষায় নম্বর কম দেওয়া হতো। বিষয়টি সে সময় জাতীয় ও স্থানীয় একাধিক গণমাধ্যমে গুরুত্বের সঙ্গে প্রকাশিত হয়ে ব্যাপক আলোচনার জন্ম দেয়।</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>', '', '/uploads/news/1783083960_1000399056.jpg', '[]', NULL, 8, '[\"প্রশ্ন ফাঁস\",\"শিক্ষক\",\"দেবীগঞ্জ\"]', 3, NULL, 101, 1, 1, 1, 'published', '2026-07-03 19:07:24', NULL, 'দেবীগঞ্জে অর্ধবার্ষিক পরীক্ষার আগেই শিক্ষার্থীর হোয়াটসঅ্যাপে প্রশ্ন পাঠানোর অভিযোগ শিক্ষকের বিরুদ্ধে | Sending questions to a student\'s WhatsApp before the half-yearly exam in Debiganj.', '', 'Sending, questions, student, WhatsApp, before, half, yearly, exam, Debiganj', '2026-07-03 13:06:00', '2026-08-08 20:09:20');

-- --------------------------------------------------------

--
-- Table structure for table `reporters`
--

CREATE TABLE `reporters` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reporters`
--

INSERT INTO `reporters` (`id`, `full_name`, `designation`, `email`, `phone`, `avatar`, `bio`, `created_at`, `updated_at`) VALUES
(1, 'ডেস্ক রিপোর্ট ', 'দেবীগঞ্জ সংবাদ ', 'desk.debiganjsongbad@gmail.com', '01517800573', '/uploads/avatars/1774858670_20260330_141402.png', 'ডেস্ক রিপোর্ট ', '2026-03-28 12:21:52', '2026-03-30 08:24:21'),
(2, 'নাজমুস সাকিব ', 'বিশেষ প্রতিবেদক ', 'nazmus.sakib@gmail.com', '', '/uploads/avatars/1774873591_1774873547707.png', 'দেবীগঞ্জ সংবাদ অনলাইন পত্রিকায় বিশেষ প্রতিবেদক হিসেবে কর্মরত রয়েছেন।', '2026-03-28 12:21:52', '2026-03-30 12:26:31'),
(3, 'রাকিবুল ইসলাম শান্ত ', 'নিজস্ব প্রতিবেদক ', 'rakibul.debiganj06@gmail.com', '', '/uploads/avatars/1774780692_1763059892055.jpg', '', '2026-03-29 10:38:12', '2026-03-29 10:38:12'),
(4, 'সালাউদ্দিন ', 'নিজস্ব প্রতিবেদক ', 'salauddin.debiganj@gmail.com', '', '/uploads/avatars/1774811399_1766427025898-01.jpeg', 'সালাউদ্দিন দেবীগঞ্জ সংবাদ অনলাইন পত্রিকায় নিজস্ব প্রতিবেদক হিসেবে কর্মরত রয়েছেন।', '2026-03-29 19:09:59', '2026-03-29 19:09:59'),
(5, 'রাশিনুর রহমান ', 'ফটো জার্নালিস্ট ', 'rasin@gmail.com', '', '/uploads/avatars/1774812745_InShot_20260330_013138790.jpg', '', '2026-03-29 19:32:25', '2026-03-29 19:32:25'),
(6, 'মুহাম্মদ সোহাগ হোসেন ', 'নিজস্ব প্রতিবেদক ', 'shojag@gmail.com', '', '/uploads/avatars/1785776555_1000302987.jpg', '', '2026-08-03 17:02:35', '2026-08-03 17:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`permissions`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`id`, `role`, `permissions`, `created_at`) VALUES
(1, 'super_admin', '{\"news\":\"all\",\"categories\":\"all\",\"users\":\"all\",\"settings\":\"all\",\"ads\":\"all\",\"comments\":\"all\",\"gallery\":\"all\"}', '2026-03-13 11:39:12'),
(2, 'admin', '{\"news\":\"all\",\"categories\":\"all\",\"users\":\"all\",\"settings\":\"all\",\"ads\":\"all\",\"comments\":\"all\",\"gallery\":\"all\"}', '2026-03-13 11:39:12'),
(3, 'editor', '{\"news\":\"all\",\"categories\":\"none\",\"users\":\"none\",\"settings\":\"none\",\"ads\":\"none\",\"comments\":\"none\",\"gallery\":\"none\"}', '2026-03-13 11:39:12');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key_name` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  `type` enum('text','textarea','image','json') DEFAULT 'text',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key_name`, `value`, `type`, `created_at`, `updated_at`) VALUES
(1, 'site_title', 'দেবীগঞ্জ সংবাদ', 'text', '2026-03-10 20:02:19', '2026-03-10 20:02:19'),
(2, 'site_url', 'http://debiganjsongbad.com', 'text', '2026-03-10 20:02:19', '2026-03-10 20:02:19'),
(3, 'site_description', 'দেবীগঞ্জের সর্বশেষ সংবাদ - বাংলা নিউজ পোর্টাল', 'textarea', '2026-03-10 20:02:19', '2026-03-10 20:02:19'),
(4, 'site_keywords', 'দেবীগঞ্জ, Debiganj, সংবাদ, নিউজ, বাংলা', 'text', '2026-03-10 20:02:19', '2026-03-10 20:02:19'),
(5, 'admin_email', 'admin@debiganjsongbad.com', 'text', '2026-03-10 20:02:19', '2026-03-10 20:02:19'),
(6, 'contact_email', 'contact@debiganjsongbad.com', 'text', '2026-03-10 20:02:19', '2026-03-10 20:02:19'),
(7, 'phone', '01517800573', 'text', '2026-03-10 20:02:19', '2026-03-29 10:35:57'),
(8, 'address', '২০১, দেবীগঞ্জ উপজেলা মুক্তিযোদ্ধা কমপ্লেক্স (২য় তলা), দেবীগঞ্জ, পঞ্চগড়।', 'text', '2026-03-10 20:02:19', '2026-04-12 19:22:10'),
(9, 'facebook_url', 'https://facebook.com/debiganjsongbad', 'text', '2026-03-10 20:02:19', '2026-03-10 20:02:19'),
(10, 'twitter_url', 'https://twitter.com/debiganjsongbad', 'text', '2026-03-10 20:02:19', '2026-03-10 20:02:19'),
(11, 'youtube_url', 'https://youtube.com/channel/UCzHd0DRqn5lVvPMty9Fuj1g?si=gP16MBY3aZNh_8H4', 'text', '2026-03-10 20:02:19', '2026-03-29 10:35:57'),
(12, 'instagram_url', 'https://instagram.com/debiganjsongbad', 'text', '2026-03-10 20:02:19', '2026-03-10 20:02:19'),
(13, 'logo', '/assets/images/logo.png', 'image', '2026-03-10 20:02:19', '2026-03-10 20:02:19'),
(14, 'favicon', '/uploads/settings/1773410221_favicon.png', 'image', '2026-03-10 20:02:19', '2026-03-13 13:57:01'),
(15, 'footer_text', '© ২০২৬ দেবীগঞ্জ সংবাদ। সর্বসত্ত্ব সংরক্ষিত।', 'text', '2026-03-10 20:02:19', '2026-03-10 20:02:19'),
(16, 'publisher', 'এ এইচ ইমরান ', 'text', '2026-03-29 06:26:54', '2026-06-22 17:02:57'),
(17, 'editor', 'এ এইচ ইমরান ', 'text', '2026-03-29 06:26:54', '2026-05-27 08:07:10'),
(18, 'online_inc', 'তাসনিম আলম', 'text', '2026-03-29 06:26:54', '2026-08-03 14:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` int(11) NOT NULL,
  `name_bn` varchar(100) NOT NULL,
  `name_en` varchar(100) DEFAULT NULL,
  `designation_bn` varchar(100) NOT NULL,
  `designation_en` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `name_bn`, `name_en`, `designation_bn`, `designation_en`, `department`, `image`, `email`, `phone`, `facebook`, `linkedin`, `twitter`, `bio`, `joining_date`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'এ এইচ ইমরান ', 'এ এইচ ইমরান ', 'প্রকাশক ও সম্পাদক ', 'Publisher and Editor ', 'Editorial', '/uploads/staff/1785771654_1000136752.jpg', '', '017********', '', '', '', '', '2022-03-26', 1, 'active', '2026-03-28 17:20:40', '2026-08-03 16:44:17'),
(2, 'সিরাতুল মোস্তাকিম ', ' SIRATUL MOSTAKIM ', 'নির্বাহী সম্পাদক ', 'Publisher and Editor ', 'Editorial', '/uploads/staff/1785772184_1000232622.jpg', 'debiganjsangbad2712@gmail.com', '01517800573', '', '', '', '', '2022-03-26', 2, 'active', '2026-03-28 17:20:40', '2026-08-03 15:49:44'),
(3, 'তাসনিম আলম ', 'Tasnim Alom', 'মাল্টিমিডিয়া ইনচার্জ ', 'Multimedia incharge', 'Digital', '/uploads/staff/1785772448_1000419199.jpg', '', '01715993622', '', '', '', '', '2025-08-05', 3, 'active', '2026-03-28 17:20:40', '2026-08-03 16:44:51'),
(4, 'সজীব আহমেদ ', 'Sajib Ahmed ', 'পরিচালক, সেলস, মার্কেটিং ও এইচআর ', 'Director, Sales, Marketing and HR', 'Marketing', '/uploads/staff/1785773013_1000302995.jpg', '', '01871516177', '', '', '', '', '2022-03-26', 4, 'active', '2026-03-28 17:20:40', '2026-08-03 16:03:33'),
(5, 'শাহাদাত হোসেন ', 'Shadat Hossain ', 'ভিডিও ইডিটর ', 'Video Editor ', 'Video', '/uploads/staff/1785773357_1000419202.jpg', '', '01305838298', '', '', '', '', '2026-03-26', 5, 'active', '2026-03-28 17:20:40', '2026-08-03 16:45:21'),
(6, 'রাকিবুল ইসলাম শান্ত ', 'Rakibul Islam Santo ', 'আইটি এক্সিকিউটিভ', 'IT Executive ', 'Digital', '/uploads/staff/1785773818_1000301985.jpg', '', '01740555378', '', '', '', '', '2026-03-26', 6, 'active', '2026-03-28 17:20:40', '2026-08-03 16:45:48'),
(7, 'আব্দুর রহমান আতিক', 'Abdur Rahman Atik', 'সোশ্যাল মিডিয়া এক্সিকিউটি', 'Social Media Executive', 'Digital', '/uploads/staff/1785774241_1000419204.jpg', '', '01310962895', '', '', '', '', '2026-05-01', 7, 'active', '2026-03-28 17:20:40', '2026-08-03 16:47:50'),
(8, 'সালাউদ্দিন ', 'Salauddin', 'হেড অফ একাউন্টস ', 'Digital Editor', 'Marketing', '/uploads/staff/1785774437_1000291626.jpg', 'salauddin.debiganj@gmail.com', '01308310004', '', '', '', '', '2026-03-26', 8, 'active', '2026-03-28 17:20:40', '2026-08-03 16:47:14'),
(9, 'মোঃ রাইয়ান ', 'MD Raian', 'নিউজ এডিটর', 'NEWS Editor', 'News', '', '', '017*******', '', '', '', '', '2022-03-26', 9, 'active', '2026-03-28 17:20:40', '2026-08-03 16:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `role` enum('super_admin','admin','editor','reporter','moderator') DEFAULT 'reporter',
  `status` enum('active','inactive','banned') DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `phone`, `avatar`, `bio`, `role`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'admin@debiganjsongbad.com', '$2y$10$ibi0AodrmVTAZT9ud3xKOOFCkQUa7t0a7PgBGZSbnKxVq2C8Trc4S', 'সুপার অ্যাডমিন', '', '', 'HI \r\n', 'super_admin', 'active', '2026-08-03 23:33:07', '2026-03-10 20:02:19', '2026-08-03 17:33:07'),
(2, 'Editor', 'debiganjsongbad@gmail.com', '$2y$10$ESPSwfIgWKrbRLHJegwGaOJLvnNq3Uk3mD./gGy.W.lAEILEUL3uO', 'Siratul Mostakim ', '01517800573', '/uploads/avatars/1773406709_AgriXpert Smart Farming Solutions.jpg', 'Editor Debiganj Songbad ', 'editor', 'active', '2026-03-30 08:52:38', '2026-03-12 10:09:44', '2026-03-30 12:52:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ad_position` (`ad_position`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_id` (`news_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `editor_id` (`editor_id`);

--
-- Indexes for table `reporters`
--
ALTER TABLE `reporters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role` (`role`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_name` (`key_name`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `reporters`
--
ALTER TABLE `reporters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD CONSTRAINT `advertisements_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `news_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `reporters` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `news_ibfk_3` FOREIGN KEY (`editor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
