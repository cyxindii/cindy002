-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1:3307
-- 產生時間： 2025-12-02 06:59:48
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `project`
--

-- --------------------------------------------------------

--
-- 資料表結構 `activity_signups`
--

CREATE TABLE `activity_signups` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `signed_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `activity_signups`
--

INSERT INTO `activity_signups` (`id`, `activity_id`, `resident_id`, `signed_at`) VALUES
(3, 1, 1, '2025-11-24 16:04:16');

-- --------------------------------------------------------

--
-- 資料表結構 `dorm_activities`
--

CREATE TABLE `dorm_activities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  `activity_date` datetime NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `dorm_activities`
--

INSERT INTO `dorm_activities` (`id`, `name`, `location`, `activity_date`, `description`, `created_at`) VALUES
(1, '南友會', '303', '2025-11-24 15:49:00', '好玩', '2025-11-24 15:49:10'),
(2, '123', '123', '2025-12-18 01:46:00', '123', '2025-11-25 01:46:13');

-- --------------------------------------------------------

--
-- 資料表結構 `drinks_lost`
--

CREATE TABLE `drinks_lost` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `resident_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `drinks_lost`
--

INSERT INTO `drinks_lost` (`id`, `name`, `amount`, `note`, `created_at`, `resident_id`) VALUES
(1, 'ada', 50, 'cola', '2025-12-02 05:56:50', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `repair_requests`
--

CREATE TABLE `repair_requests` (
  `id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `item` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('待處理','處理中','已完成') DEFAULT '待處理',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `repair_requests`
--

INSERT INTO `repair_requests` (`id`, `resident_id`, `location`, `item`, `description`, `status`, `created_at`) VALUES
(1, 1, '303', '1', '馬桶漏水', '已完成', '2025-11-21 00:44:53'),
(2, 1, '2', '2', '2', '待處理', '2025-11-25 15:14:09');

-- --------------------------------------------------------

--
-- 資料表結構 `residents`
--

CREATE TABLE `residents` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `role` enum('student','staff','admin') DEFAULT 'student',
  `account` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `residents`
--

INSERT INTO `residents` (`id`, `name`, `room_number`, `student_id`, `role`, `account`, `password`) VALUES
(1, '測試學生', '101', '12345', 'student', 's001', '1');

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `account` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `role` enum('M','student','teacher') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`id`, `account`, `password`, `name`, `role`) VALUES
(1, 'admin', 'a', '系統管理員', 'M');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `activity_signups`
--
ALTER TABLE `activity_signups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `activity_id` (`activity_id`,`resident_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- 資料表索引 `dorm_activities`
--
ALTER TABLE `dorm_activities`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `drinks_lost`
--
ALTER TABLE `drinks_lost`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `repair_requests`
--
ALTER TABLE `repair_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- 資料表索引 `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account` (`account`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account` (`account`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `activity_signups`
--
ALTER TABLE `activity_signups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `dorm_activities`
--
ALTER TABLE `dorm_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `drinks_lost`
--
ALTER TABLE `drinks_lost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `repair_requests`
--
ALTER TABLE `repair_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `residents`
--
ALTER TABLE `residents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `activity_signups`
--
ALTER TABLE `activity_signups`
  ADD CONSTRAINT `activity_signups_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `dorm_activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_signups_ibfk_2` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`);

--
-- 資料表的限制式 `repair_requests`
--
ALTER TABLE `repair_requests`
  ADD CONSTRAINT `repair_requests_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
