-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 20, 2025 lúc 05:16 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `droppy`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id`, `email`, `fullname`, `phone`, `password`, `verification_token`, `is_verified`, `role`, `created_at`) VALUES
(7, 'huynhoc22@gmail.com', 'Nguyễn Anh Huy', '0988888776', '$2y$10$UEPTlahSwBqeQZlpw9RhV.0MnI2715D/6TK2Mj.uzxj1yHg.5E6ve', NULL, 0, 'user', '2025-04-07 09:47:22'),
(13, 'hung1911@gmail.com', 'Lâm Tấn Hùng', '0345602818', '$2y$10$8rQ0.M6qzfHf4LU4WqV4m.LwmfqFFegTV58Tco5EmVMP/kJqI6oTq', NULL, 0, 'user', '2025-04-13 03:04:16'),
(14, 'lan123@gmail.com', 'Nguyễn Như Lan', '0336765498', '$2y$10$dc5Cj6wqJaq6bFguyCU7Se093AJFiB/E7zq9YiQoi2OPOzThu5dKe', NULL, 0, 'user', '2025-04-13 15:28:04'),
(38, 'Trit42961@gmail.com', 'Tran Huu tri', '09653066922', '$2y$10$jgV47na1Cd.5suGMux8EiuUcoBienWNsN0b5LdGs9f4D0LuDzEm2C', NULL, 0, 'user', '2025-05-19 00:57:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loginadmin`
--

CREATE TABLE `loginadmin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loginadmin`
--

INSERT INTO `loginadmin` (`id`, `username`, `password`, `fullname`, `last_login`, `created_at`) VALUES
(1, 'admin', '$2y$10$examplehashedpassword...', 'Tri_AD', NULL, '2025-04-12 14:35:49'),
(3, 'admin1', '$2y$10$Y38unMeNUtVADCbgooJyGu/vd6FeYwi8xuP5HFctZk1UOiP6kIwvK', 'Tri_AD', '2025-05-19 09:33:13', '2025-04-12 14:48:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `momo_payments`
--

CREATE TABLE `momo_payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `status` enum('PENDING','PAID','CANCELLED') DEFAULT 'PENDING',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `momo_payments`
--

INSERT INTO `momo_payments` (`id`, `order_id`, `total`, `status`, `created_at`, `updated_at`) VALUES
(1, 142, 0.00, 'PENDING', '2025-05-19 14:29:28', NULL),
(2, 144, 4500000.00, 'PENDING', '2025-05-19 14:30:09', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `id_account` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` int(11) NOT NULL DEFAULT 0,
  `status` enum('Chờ xử lý','Đã chuyển khoản','Đã thanh toán','Đã gửi hàng','Đã giao','Đã huỷ') DEFAULT 'Chờ xử lý',
  `payment_method` enum('COD','MOMO_QR') DEFAULT 'COD',
  `momo_transaction_code` varchar(255) DEFAULT NULL,
  `discount` decimal(15,2) DEFAULT 0.00,
  `voucher_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `id_account`, `name`, `phone`, `address`, `created_at`, `total`, `status`, `payment_method`, `momo_transaction_code`, `discount`, `voucher_code`) VALUES
(23, 13, '55', '55', '55', '2025-04-13 05:21:38', 108000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(24, 13, '55', '55', '55', '2025-04-13 05:21:58', 26000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(25, 13, '5', '5', '5', '2025-04-13 05:35:29', 38500000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(26, 13, '5', '5', '5', '2025-04-13 07:11:15', 54000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(27, 13, '7', '7', '7', '2025-04-13 07:12:44', 15900000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(28, 13, 'tri', '55', '555', '2025-04-13 07:26:59', 13800000, 'Đã huỷ', 'COD', NULL, 0.00, NULL),
(29, 13, '5', '5', '5', '2025-04-13 07:34:01', 6800000, 'Đã thanh toán', 'COD', NULL, 0.00, NULL),
(32, NULL, '', '', ', , ', '2025-04-13 03:42:45', 6500000, 'Đã thanh toán', 'COD', NULL, 0.00, NULL),
(33, NULL, '', '', ', , ', '2025-04-13 03:45:24', 6500000, 'Đã thanh toán', 'COD', NULL, 0.00, NULL),
(34, NULL, '', '', ', , ', '2025-04-13 03:46:08', 6500000, 'Đã thanh toán', 'COD', NULL, 0.00, NULL),
(35, NULL, '', '', ', , ', '2025-04-13 03:47:30', 6500000, 'Đã thanh toán', 'COD', NULL, 0.00, NULL),
(36, NULL, '', '', ', , ', '2025-04-13 03:48:13', 6500000, 'Đã thanh toán', 'COD', NULL, 0.00, NULL),
(37, NULL, '5', '5', '5', '2025-04-13 08:50:29', 6500000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(38, NULL, '44444', '4444', '444444', '2025-04-13 08:51:26', 33000000, 'Đã thanh toán', 'COD', NULL, 0.00, NULL),
(39, NULL, 'Trần Hữu Trí', '099888999', 'TPHCM', '2025-04-13 16:20:19', 182000000, 'Đã thanh toán', 'COD', NULL, 0.00, NULL),
(40, NULL, 'Trần Hữu Trí', '0965306692', 'Tp HCM', '2025-04-13 20:24:21', 56300000, 'Đã thanh toán', 'COD', NULL, 0.00, NULL),
(41, NULL, 'Trần Hữu Trí', '0965306692', 'Tp.HCM', '2025-04-14 08:40:19', 5300000, 'Đã huỷ', 'COD', NULL, 0.00, NULL),
(42, NULL, 'Trí', '0965306692', 'Tp.HCM', '2025-04-14 08:53:46', 2300000, 'Đã gửi hàng', 'COD', NULL, 0.00, NULL),
(43, NULL, 'Tri', '0988766776', 'Tp.HN', '2025-04-14 09:12:34', 5300000, 'Đã thanh toán', 'COD', NULL, 0.00, NULL),
(44, NULL, 'Tri', '00', 'Tp.HCM', '2025-04-14 09:21:27', 66000000, 'Đã huỷ', 'COD', NULL, 0.00, NULL),
(45, NULL, 'Hung', '0965306692', 'HN', '2025-04-14 09:22:05', 33000000, 'Đã thanh toán', 'COD', NULL, 0.00, NULL),
(46, NULL, 'Trí', '0965306692', 'TP.HCM', '2025-04-14 17:24:01', 4500000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(47, NULL, 'Trí Trần', '0965306692', 'HCM', '2025-04-14 17:27:10', 108000000, 'Đã huỷ', 'COD', NULL, 0.00, NULL),
(48, NULL, 'Tri', '097777', '555', '2025-04-14 17:52:45', 15900000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(49, NULL, 'Tri', '0965306692', 'ttt', '2025-04-14 17:57:13', 54000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(50, NULL, 'ttt', '000', 'ttt', '2025-04-14 17:58:59', 61500000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(51, NULL, '55', '55', '55', '2025-04-14 18:01:21', 33000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(52, NULL, '555', '55', '555555', '2025-04-14 18:05:58', 32000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(53, NULL, '11', '11', '11', '2025-04-14 18:13:11', 27000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(54, NULL, 'cc', '88', 'cccc', '2025-04-14 18:13:43', 450000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(55, NULL, '55', '55555', '999', '2025-04-14 18:15:20', 2600000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(56, NULL, '55', '55', 'tttt', '2025-04-14 18:26:56', 6500000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(57, NULL, '555', '5555', '5555', '2025-04-14 18:28:14', 55000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(58, NULL, '1111', '1111', '1111', '2025-04-14 18:34:19', 2500000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(59, NULL, '111', '111', '111', '2025-04-14 18:38:21', 54000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(60, NULL, '555', '777', '5555', '2025-04-14 18:43:59', 54000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(61, NULL, '999', '999', '9999', '2025-04-14 18:44:38', 8100000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(62, NULL, '5', '55', '55', '2025-04-14 19:11:51', 9000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(63, NULL, '55', '5555', '5555', '2025-04-14 19:12:39', 55000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(64, NULL, '99', '99', '99', '2025-04-14 19:17:48', 34000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(65, NULL, '00', '00', '00', '2025-04-14 19:18:38', 450000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(66, NULL, '99', '99', '99', '2025-04-14 19:20:00', 800000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(67, NULL, '000', '0000', '0000', '2025-04-14 19:20:49', 160000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(68, NULL, '9', '9', '9', '2025-04-14 19:33:59', 34000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(69, NULL, '6', '6', '6', '2025-04-14 19:37:46', 27000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(70, NULL, '6', '6', '6', '2025-04-14 19:42:41', 60000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(71, NULL, '9', '9', '9', '2025-04-14 19:44:13', 250000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(72, NULL, '11', '333', '333', '2025-04-14 20:04:33', 1600000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(73, NULL, '88', '88', '88', '2025-04-14 20:10:19', 27000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(74, NULL, '99', '999', '9999', '2025-04-14 20:10:49', 61000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(75, NULL, '888', '888', '88', '2025-04-14 20:11:42', -445000000, 'Chờ xử lý', 'COD', NULL, 99999999.99, 'VIP50'),
(76, NULL, '777', '777', '777', '2025-04-14 20:13:55', 200000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(77, NULL, '99', '999', '9999', '2025-04-14 20:14:24', 33000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(78, NULL, '1', '1', '1', '2025-04-14 20:20:06', 4500000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(79, NULL, '000', '0000', '000', '2025-04-14 20:20:27', 200000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(80, NULL, '1', '1', '1', '2025-04-14 20:22:38', 18500000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(81, NULL, '6', '6', '6', '2025-04-14 20:23:05', 160000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(82, NULL, '9', '9', '9', '2025-04-14 20:23:22', 190000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(83, NULL, '1', '1', '1', '2025-04-14 20:34:11', 59500000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(84, NULL, '7', '7', '7', '2025-04-14 20:41:17', 250000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(85, NULL, '8', '8', '8', '2025-04-14 20:41:37', 450000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(86, NULL, '9', '9', '9', '2025-04-14 20:42:19', 250000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(87, NULL, '9', '9', '9', '2025-04-14 20:43:03', 190000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(88, NULL, '3', '3', '3', '2025-04-14 20:45:05', 800000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(89, NULL, '3', '3', '3', '2025-04-14 20:52:33', 33000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(90, NULL, '4', '4', '4', '2025-04-14 20:53:29', 27000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(91, NULL, '7', '7', '7', '2025-04-14 20:54:02', 200000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(92, NULL, '3', '3', '3', '2025-04-14 20:56:46', 33000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(93, NULL, '3', '3', '3', '2025-04-14 20:57:09', 55000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(94, NULL, '4', '4', '4', '2025-04-14 20:59:36', 190000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(95, NULL, '3', '3', '3', '2025-04-14 21:01:25', 34000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(96, NULL, '222', '222', '222', '2025-04-14 21:06:22', 57500000, 'Đã thanh toán', 'COD', NULL, 0.00, NULL),
(97, NULL, '1', '1', '1', '2025-04-14 21:07:21', 33000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(98, NULL, '1', '1', '1', '2025-04-14 21:08:03', 33000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(99, NULL, '1', '1', '1', '2025-04-14 21:09:08', 3700000, 'Đã huỷ', 'COD', NULL, 0.00, NULL),
(100, NULL, '1', '1', '2', '2025-04-14 21:09:33', 4500000, 'Đã thanh toán', 'COD', NULL, 0.00, NULL),
(102, NULL, '1', '1', '1', '2025-04-14 21:17:27', 27000000, 'Đã gửi hàng', 'COD', NULL, 0.00, NULL),
(103, NULL, '333', '333', '333', '2025-04-14 21:18:21', 450000, 'Đã gửi hàng', 'COD', NULL, 0.00, NULL),
(104, NULL, '7', '7', '7', '2025-04-14 21:19:06', -43500000, 'Đã huỷ', 'COD', NULL, 50000000.00, 'FREESHIP'),
(107, NULL, '111', '1111', '111', '2025-04-14 21:58:02', 33000000, 'Đã gửi hàng', 'COD', NULL, 0.00, NULL),
(108, NULL, '11', '111', '11111', '2025-04-14 21:59:34', 2500000, 'Đã huỷ', 'COD', NULL, 0.00, NULL),
(109, NULL, '1', '1', '1', '2025-04-14 22:18:19', 900000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(110, NULL, '1', '1', '1', '2025-04-14 22:19:11', 4200000, 'Đã gửi hàng', 'COD', NULL, 0.00, NULL),
(111, NULL, '1', '11', '11', '2025-04-14 22:20:05', 17500000, 'Đã huỷ', 'COD', NULL, 0.00, NULL),
(112, NULL, 'thịnh ngu', '0123456', '7a ggg', '2025-04-15 01:41:44', 25200000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(113, NULL, '11', '111', '111', '2025-04-15 01:53:55', 33000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(114, NULL, '111', '111', '11111', '2025-04-15 01:54:37', -43500000, 'Chờ xử lý', 'COD', NULL, 50000000.00, 'FREESHIP'),
(115, NULL, '00', '000', '00000', '2025-04-15 07:20:53', 34000000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(116, NULL, 'ttt', '000000', '00', '2025-04-15 07:23:34', 900000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(117, NULL, '44', '444', '444', '2025-04-21 14:47:47', 2500000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(118, NULL, 'ttt', '555', '555', '2025-05-16 14:28:32', 1600000, 'Đã huỷ', 'COD', NULL, 0.00, NULL),
(122, NULL, '55', '555', '555', '2025-05-16 16:19:42', 6950000, 'Chờ xử lý', 'COD', NULL, 50000.00, '55555'),
(123, 38, '555', '555', '5555', '2025-05-19 00:59:23', -3100000, 'Chờ xử lý', 'COD', NULL, 5000000.00, '11111111'),
(124, 38, '666', '666', '666', '2025-05-19 02:40:46', 6800000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(125, 38, '6666', '6666666', '6666', '2025-05-19 08:55:24', 1600000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(126, 38, '666', '666', '666', '2025-05-19 09:12:32', 2300000, '', 'MOMO_QR', NULL, 0.00, NULL),
(127, 38, '777', '777', '7777', '2025-05-19 09:14:40', 2300000, '', 'MOMO_QR', NULL, 0.00, NULL),
(128, 38, '666', '666666', '666666', '2025-05-19 09:14:56', 2300000, '', 'MOMO_QR', NULL, 0.00, NULL),
(129, 38, '6', '6', '6', '2025-05-19 09:23:29', 2300000, '', 'MOMO_QR', NULL, 0.00, NULL),
(132, 38, '55', '555', '555', '2025-05-19 09:31:59', 2300000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(133, 38, '77', '77777', '77777777', '2025-05-19 09:32:41', 2500000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(135, 38, '666', '6666', '666666', '2025-05-19 14:04:15', 2300000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(137, 38, '1', '1', '1', '2025-05-19 14:07:15', 5200000, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(140, 38, '55', '555555', '5555', '2025-05-19 14:16:48', 1600000, '', 'MOMO_QR', NULL, 0.00, NULL),
(141, 38, '44', '444', '444', '2025-05-19 14:22:28', 0, '', 'MOMO_QR', NULL, 0.00, NULL),
(142, 38, '44', '444', '444', '2025-05-19 14:29:28', 0, '', 'MOMO_QR', NULL, 0.00, NULL),
(143, 38, 'tri', '0985575555', 'tp hcm', '2025-05-19 14:29:53', 0, 'Chờ xử lý', 'COD', NULL, 0.00, NULL),
(144, 38, 'tri', '094884449', 'tp ba ria', '2025-05-19 14:30:09', 4500000, '', 'MOMO_QR', NULL, 0.00, NULL),
(145, 38, '555', '55555', '44444', '2025-05-19 14:44:20', 4500000, 'Đã gửi hàng', 'MOMO_QR', NULL, 0.00, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(21, 23, 43, 2, 54000000.00),
(22, 24, 49, 4, 6500000.00),
(23, 25, 48, 1, 4500000.00),
(24, 25, 45, 1, 34000000.00),
(25, 26, 43, 1, 54000000.00),
(26, 27, 47, 3, 5300000.00),
(27, 28, 46, 6, 2300000.00),
(28, 29, 46, 1, 2300000.00),
(29, 29, 48, 1, 4500000.00),
(30, 37, 49, 1, 6500000.00),
(31, 38, 42, 1, 33000000.00),
(32, 39, 43, 1, 54000000.00),
(33, 39, 87, 4, 32000000.00),
(34, 40, 46, 1, 2300000.00),
(35, 40, 43, 1, 54000000.00),
(36, 41, 47, 1, 5300000.00),
(37, 42, 46, 1, 2300000.00),
(38, 43, 47, 1, 5300000.00),
(39, 44, 42, 2, 33000000.00),
(40, 45, 42, 1, 33000000.00),
(41, 46, 48, 1, 4500000.00),
(42, 47, 43, 2, 54000000.00),
(43, 48, 47, 3, 5300000.00),
(44, 49, 43, 1, 54000000.00),
(45, 50, 44, 1, 55000000.00),
(46, 50, 49, 1, 6500000.00),
(47, 51, 42, 1, 33000000.00),
(48, 52, 87, 1, 32000000.00),
(49, 53, 88, 1, 27000000.00),
(50, 54, 66, 1, 450000.00),
(51, 55, 70, 1, 2600000.00),
(52, 56, 49, 1, 6500000.00),
(53, 57, 44, 1, 55000000.00),
(54, 58, 69, 1, 2500000.00),
(55, 59, 43, 1, 54000000.00),
(56, 60, 43, 1, 54000000.00),
(57, 61, 51, 1, 1600000.00),
(58, 61, 49, 1, 6500000.00),
(59, 62, 50, 2, 4500000.00),
(60, 63, 44, 1, 55000000.00),
(61, 64, 45, 1, 34000000.00),
(62, 65, 66, 1, 450000.00),
(63, 66, 68, 1, 800000.00),
(64, 67, 64, 1, 160000.00),
(65, 68, 45, 1, 34000000.00),
(66, 69, 88, 1, 27000000.00),
(67, 70, 88, 1, 27000000.00),
(68, 70, 42, 1, 33000000.00),
(69, 71, 54, 1, 250000.00),
(70, 72, 51, 1, 1600000.00),
(71, 73, 88, 1, 27000000.00),
(72, 74, 90, 1, 27000000.00),
(73, 74, 45, 1, 34000000.00),
(74, 75, 44, 1, 55000000.00),
(75, 76, 65, 1, 200000.00),
(76, 77, 42, 1, 33000000.00),
(77, 78, 50, 1, 4500000.00),
(78, 79, 65, 1, 200000.00),
(79, 80, 81, 1, 18500000.00),
(80, 81, 64, 1, 160000.00),
(81, 82, 53, 1, 190000.00),
(82, 83, 48, 1, 4500000.00),
(83, 83, 44, 1, 55000000.00),
(84, 84, 54, 1, 250000.00),
(85, 85, 66, 1, 450000.00),
(86, 86, 54, 1, 250000.00),
(87, 87, 53, 1, 190000.00),
(88, 88, 68, 1, 800000.00),
(89, 89, 89, 1, 33000000.00),
(90, 90, 88, 1, 27000000.00),
(91, 91, 65, 1, 200000.00),
(92, 92, 89, 1, 33000000.00),
(93, 93, 44, 1, 55000000.00),
(94, 94, 53, 1, 190000.00),
(95, 95, 45, 1, 34000000.00),
(96, 96, 44, 1, 55000000.00),
(97, 96, 69, 1, 2500000.00),
(98, 97, 89, 1, 33000000.00),
(99, 98, 89, 1, 33000000.00),
(100, 99, 57, 1, 3700000.00),
(101, 100, 50, 1, 4500000.00),
(103, 102, 90, 1, 27000000.00),
(104, 103, 66, 1, 450000.00),
(105, 104, 49, 1, 6500000.00),
(108, 107, 42, 1, 33000000.00),
(109, 108, 69, 1, 2500000.00),
(110, 109, 79, 1, 900000.00),
(111, 110, 56, 1, 4200000.00),
(112, 111, 80, 1, 17500000.00),
(113, 112, 70, 1, 2600000.00),
(114, 112, 82, 1, 21000000.00),
(115, 112, 51, 1, 1600000.00),
(116, 113, 89, 1, 33000000.00),
(117, 114, 49, 1, 6500000.00),
(118, 115, 45, 1, 34000000.00),
(119, 116, 79, 1, 900000.00),
(120, 117, 69, 1, 2500000.00),
(121, 118, 51, 1, 1600000.00),
(126, 122, 69, 1, 2500000.00),
(127, 122, 48, 1, 4500000.00),
(128, 123, 72, 1, 1900000.00),
(129, 124, 48, 1, 4500000.00),
(130, 124, 73, 1, 2300000.00),
(131, 125, 51, 1, 1600000.00),
(132, 126, 73, 1, 2300000.00),
(133, 127, 73, 1, 2300000.00),
(134, 128, 73, 1, 2300000.00),
(135, 129, 73, 1, 2300000.00),
(138, 132, 73, 1, 2300000.00),
(139, 133, 69, 1, 2500000.00),
(141, 135, 73, 1, 2300000.00),
(143, 137, 70, 2, 2600000.00),
(146, 140, 51, 1, 1600000.00),
(147, 141, 55, 1, 0.00),
(148, 142, 55, 1, 0.00),
(149, 143, 55, 1, 0.00),
(150, 144, 48, 1, 4500000.00),
(151, 145, 48, 1, 4500000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `otp_code`, `expires_at`, `created_at`) VALUES
(3, 'trit42961@gmail.com', '1cb46d76dc4f134324b3a5f4e3e35d7c', '525706', '2025-05-15 23:34:04', '2025-05-15 23:29:04'),
(4, 'trit42961@gmail.com', 'aaf0f6f7add3a7912a05a998af2c413d', '667236', '2025-05-15 23:34:39', '2025-05-15 23:29:39'),
(5, 'trit42961@gmail.com', 'de75aa2e3eb2622ab5811db4dd43f5ee', '884136', '2025-05-15 23:35:03', '2025-05-15 23:30:03'),
(6, 'trit42961@gmail.com', 'c261d1b78ec351fdb13d63fb535f2d59', '600190', '2025-05-15 23:35:38', '2025-05-15 23:30:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `register_user`
--

CREATE TABLE `register_user` (
  `register_user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_activation_code` varchar(250) NOT NULL,
  `user_email_status` enum('not verified','verified') NOT NULL,
  `user_otp` int(11) NOT NULL,
  `user_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_avatar` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `otp_expires_at` datetime DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `otp_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_brand`
--

CREATE TABLE `tbl_brand` (
  `brand_id` int(11) NOT NULL,
  `cartegory_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_brand`
--

INSERT INTO `tbl_brand` (`brand_id`, `cartegory_id`, `brand_name`) VALUES
(35, 25, 'Bao Cơ'),
(36, 25, 'Lơ'),
(37, 24, 'Cơ Mộc'),
(38, 24, 'Cơ Carbon'),
(39, 23, 'Bàn Lỗ'),
(40, 23, 'Bàn Phăng'),
(41, 24, 'Cơ Phá Nhảy');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_cartegory`
--

CREATE TABLE `tbl_cartegory` (
  `cartegory_id` int(11) NOT NULL,
  `cartegory_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_cartegory`
--

INSERT INTO `tbl_cartegory` (`cartegory_id`, `cartegory_name`) VALUES
(23, 'Bàn Bida'),
(24, 'Cơ Bida'),
(25, 'Phụ Kiện');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `cartegory_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_desc` varchar(5000) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `stock` int(11) DEFAULT 10,
  `sold` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `product_name`, `cartegory_id`, `brand_id`, `product_price`, `product_desc`, `product_img`, `stock`, `sold`) VALUES
(42, 'Bàn Bida Aileex 9024 ', 23, 39, 33000000, 'Mã sản phẩm: Aileex 9023 Nhập Trung\r\nKích thước: 1m65x2m9x82cm\r\n', 'ban-aileex-9023-nhap-trung-720x720.webp', 2, 10),
(43, 'Bàn Bida WINNPOOL RENEW', 23, 39, 54000000, 'OK', 'ban-bida-winpon-1-720x720.jpg', 0, 11),
(44, 'Bàn Samurai 9024', 23, 39, 55000000, '– Tên sản phẩm: Samurai 9022\r\n\r\n– Màu sắc: xám vân gỗ, Nâu trắng\r\n– Kết cấu khung chân: Được cấu tạo từ gỗ Plywood chịu lực. Liên kết khung chân ốc đa điểm vững chắc – khử rung, Độ bền cao.\r\n', 'ban-samurai-9023-720x720.webp', 3, 7),
(45, ' Bàn Bida Mr-Sung Nhập Trung', 23, 39, 34000000, '  Tình trạng: Còn hàng\r\nBàn Mr Sung nhập trung sản xuất hầu hết tại Việt Nam\r\nKích thước bàn: 290 x 163 cm (9 feet)\r\nKích thước phòng tối thiểu : 560 x 450 cm\r\nChiều cao:  82 cm\r\nBề mặt chơi: 254cm x 127cm\r\nĐộ dày phiến đá: 2.5 cm', 'ban-bida-mr-sung-xam-720x721.webp', 4, 6),
(46, ' Gậy LeadSuper V1', 24, 38, 2300000, 'Đầu Cơ: Đầu lớp da bò 12.8mm\r\nCân nặng: 19oz (530-550g)\r\nNgọn: Full carbon lõi foam\r\nRen 3-8/10\r\nChiều Dài: 147cm\r\nChuôi: Tay cầm da simili\r\nCó tem check hàng chính hãng đầy đủ', 'leadsuper-v1-5.webp', 0, 11),
(47, 'Gậy ZOKUE Elite ', 24, 38, 5300000, 'Thương hiệu: Zokue\r\nTẩy: Zokue M\r\n Size ngọn: 12.5mm\r\nNgọn: Full carbon\r\nPhíp: XTC\r\nTay cầm: Da bò dập vân kì đà đen\r\nHọa tiết: Sơn mờ\r\nRen: Radial\r\nChuôi: Carbon composite', 'zokue-carbon-0.webp', 0, 12),
(48, ' Gậy Cuppa Asura ', 24, 38, 4500000, 'Tên: Cuppa Asura\r\nThương Hiệu : Cuppa\r\nNgọn : Cuppa -S1- Full Carbon\r\nPhíp : Cpa-Carbon\r\nTẩy : Eagle\r\nRen :Radial 3/8*8\r\nTrọng lượng : 18-19.5oz ( có ốc tăng chỉnh trọng lượng )', 'co-cuppa-acula-3.webp', 2, 10),
(49, 'Gậy Dragon Legend', 24, 38, 6500000, 'Tip: Tip F1 Crystal\r\nRen: Radial (3/8-8)\r\nTay cầm: Tay da cao cấp\r\nCổ chuôi: 21.5 mm (Đường kính)\r\nSize ngọn: 12.8 mm\r\nSản phẩm bao gồm: Cơ 2 khúc, hộp đựng, Nối Dragon, Găng Tay, 3 ốc tăng giảm trong lượng', 'dragon-legend-1.jpg', 0, 10),
(50, 'Cơ Bida Rhino RC23', 24, 37, 4500000, 'Chất liệu chuôi : Gỗ phong cao cấp\r\nChất liệu ngọn: Mộc\r\nRen: Radial\r\nNgọn: Mộc\r\nKích thước ngọn: 12.75mm\r\nTay cầm: Tay bọc da\r\nTrọng lượng: 19oz', 'rhino-rc23.jpg', 5, 5),
(51, ' Cơ Mộc Rhino RC23', 24, 37, 1600000, 'Chất liệu chuôi : Gỗ phong cao cấp\r\nChất liệu ngọn: Mộc\r\nRen: Radian\r\nNgọn: Mộc\r\nKích thước ngọn: 12.75mm\r\nTay cầm: Tay bọc da\r\nTrọng lượng: 19oz\r\nPhụ Kiện : 1 bao cơ, 1 găng tay, 2 viên lơ ', 'co-rhino-lo-1.jpg', 1, 9),
(52, 'Bao Cơ Bida 1×1', 25, 35, 150000, 'Bao Cơ Bida 1×1\r\nKích Thước: 80cm\r\nChất Lượng Cao với chất liệu Da siêu bền kết hợp nhiều hoa văn hoạ tiết đẹp mắt,\r\n\r\n\r\n', 'bao-co-1x1-1 (1).webp', 10, 0),
(53, 'Bao Cơ Da Mềm BA', 25, 35, 190000, 'Kích thước: 80x9cm (Bao da đựng 01 chuôi + 01 ngọn ) thiết kế phù hợp.\r\n\r\nBảo vệ cơ khỏi các tác động của thời tiết , bụi bẩn . Tăng tuổi thọ cho cơ bida .', 'bao-co-da-mem-ba.webp', 7, 3),
(54, 'Bao Da Đựng Cơ Cao Cấp 1×1', 25, 35, 250000, 'Màu sắc: Vàng, Trắng, Xanh, Hồng\r\nBao cơ 1×2: đựng 1 chuôi + 2 ngọn\r\nKích thước: 80x10x6cm. Vừa vặn với hầu hết các loại các loại gậy bi-a lỗ 2 khúc\r\n', 'bao-da-cao-cap-1x1-1.webp', 7, 3),
(55, 'Bao Đựng Cơ Bida Jinchuan 02', 25, 35, 0, 'Bao Đựng Cơ Bida JINCHUAN 02 ngăn 1×1\r\n\r\n– Thương Hiệu: Jinchuan\r\n\r\n– Kích thước: 77cm\r\n\r\n– Màu sắc: Đen – Xanh-Cam\r\n\r\n– Bao bảo vệ cơ cao cấp với 1 chuôi và1 ngọn.', 'bao-dung-co-jinchuan-02.webp', 6, 4),
(56, 'Bao Cơ Peri White Kylin', 25, 35, 4200000, 'Dòng sản phẩm: Bao Đựng Cơ  chống chầy xước, ẩm mốc, cong vênh\r\nKích thước: 4” x 21” x 1.5”\r\nVỏ: Da cao cấp\r\nRuột: Vải cao cấp', 'bao-co-peri-white-kylin.webp', 9, 1),
(57, 'Bao Cơ Peri Shalow', 25, 35, 3700000, 'Dòng sản phẩm: Bao Đựng Cơ chống chầy xước, ẩm mốc, cong vênh\r\nKích thước: 4” x 21” x 1.5”\r\nVỏ: Da cao cấp\r\nRuột: Vải cao cấp', 'bao-co-peri-shadow (1).webp', 9, 1),
(58, 'Bao Cơ KONLLEN Macaron', 25, 35, 3200000, ' Thương Hiệu: KONLLEN\r\n  Kích thước: 86x14x10\r\n Chất liệu: Da\r\n Trọng lượng: 1kg', 'bao-konllen-macaron-2x4-6.webp', 10, 0),
(59, 'Bao Đựng Cơ KONLLEN Oxford', 25, 35, 2700000, 'Chất liệu vải thêu chắc chắn\r\nBao đựng đuọc một chuôi hai ngọn\r\nTay cầm,quai đeo may chắc chắn,siêu bền\r\nKích Thước: Dài 32 inch x rộng 3,9 inch x dày 2,4 inch', 'bao-konllen-OXFORD-1x2-1.webp', 10, 0),
(60, ' Bao Cứng PELOVE HQ', 25, 35, 250000, 'Thương hiệu: Pelove\r\n\r\nKhích thước: 2 chuôi , 3 ngọn\r\n\r\nChất liệu: Vải catton chông nước cao cấp\r\n\r\nRuột: Bọc nỉ cao cấp', 'bao-PELOVE-1x2-1.webp', 10, 0),
(61, 'Bao Đựng Cơ Bida Jinchuan 03', 25, 35, 340000, 'Bao Đựng Cơ Bida JINCHUAN 03 Ngăn 3×4\r\n\r\n– Thương Hiệu: Jinchuan\r\n\r\n– Kích thước: 88x18x10cm\r\n\r\n– Trọng lượng: 1,0kg\r\n\r\n– Màu sắc: Đen – Xanh', 'bao-dung-co-jinchuan-03-1 (1).jpg', 10, 0),
(62, ' Bao Da Đựng Cơ Bida Cao Cấp 2×2', 25, 35, 300000, 'Vật liệu vỏ da PU cao cấp\r\nTổng chiều dài: 80cm\r\nChất lượng tốt, bền bỉ\r\nThiết kế đơn giản, gọn nhẹ, dễ sử dụng\r\nTiện lợi, dễ mang đi khi di chuyển', 'bao-da-cao-cap-den-trang-2x2-1.webp', 10, 0),
(63, 'Bao Cơ Da 2×2 BC-05', 25, 35, 350000, 'Chất liệu: lõi cao su + vỏ da\r\nMàu sắc: Đen\r\nQuy cách: 2×2 ( 2 chuôi 2 ngọn)\r\nĐáy hộp: lò xo 4 lỗ\r\nQuai: đeo vai/xách tay', 'bao-co-da-2x2-1.webp', 10, 0),
(64, 'Lơ TP ( Turning ponit )', 25, 36, 160000, ' Hãng sản xuất : TP\r\n\r\n✔️Tăng độ ma sát giúp cho những cú ra cơ chính xác hơn.\r\n\r\n✔️Bảo vệ đầu cơ chống lại sự ăn mòn trong quá trình sử dụng.', 'lo-turning-pont (1).webp', 8, 2),
(65, 'Hộp Bảo Vệ Lơ Taom', 25, 36, 200000, 'Bộ sản phẩm gồm kẹp và hộp đựng lơ\r\n\r\nTác dụng là giữ lơ và bảo vệ lơ.\r\n\r\nCó thể kẹp ở túi quần tiện cho việc sử dụng\r\n\r\nThuận tiện cho việc đánh Bida dễ dàng hơn', 'kep-lo-taom.jpg', 7, 3),
(66, ' Lơ Bida Cá Nhân Cao Cấp Taom', 25, 36, 450000, '– Lơ cực bám, dùng tốt với tất cả các tẩy hiện nay.\r\n– Thích hợp với tất cả các bộ môn Biliard ( Bida lỗ, Snooker, Carom,…)\r\n– Cực ít bụi, sạch và không bám vào bi cái.', 'lo-taom.jpg', 6, 4),
(67, 'Lơ ROKU 6', 25, 36, 250000, '\r\nThương hiệu	Kamui\r\nHình dạng	Lục giác', 'lo-roku.webp', 10, 0),
(68, 'Hộp Đựng Lơ Cao Cấp', 25, 36, 800000, 'Thông Tin Sản Phẩm: Hàng Oder Trước\r\n\r\nChất liệu: Kim loại\r\nCấu tạo: 2 phần gồm nắp+đế\r\nPhù hợp với những mẫu lơ hinh vuông', 'hop-dung-lo-1.jpg', 8, 2),
(69, ' Cơ Maple Leaf CPD', 24, 37, 2500000, 'Ren : radial\r\nKích thước ngọn : 12,75mm\r\nChất liệu : gỗ phong\r\nĐầu tẩy : Maple tip', 'gay-maple-leaf-cpd-1-1.jpg', 4, 6),
(70, ' Cơ Fury TY RK', 24, 37, 2600000, 'Hãng: TY thuộc FURY\r\nChất liệu: Cue Gỗ Maple\r\nChất liệu ngọn: Promaple maple\r\nCông nghệ ngọn: T1 knight\r\nRen: Radial', 'co-ty-rk.webp', 3, 7),
(71, 'Cơ Bida CUPPA MT-01', 24, 37, 2900000, 'Chất liệu : gỗ phong\r\nRen : radial\r\nKích thước ngọn : 12.5mm\r\nPhíp XTC\r\nTay cầm : da kỳ đà', 'co-cuppa-mt01.webp', 10, 0),
(72, ' Cơ Bida CUPPA X5 Cơ Bida CUPPA X5', 24, 37, 1900000, 'Đầu tẩy : 12,5mm\r\nTay cầm : Da\r\nChiều dài : 147cm\r\nRen : True-loc\r\nTrọng lượng : 18.5-19oz', 'cuppa-x5.jpg', 9, 1),
(73, 'Cơ LCBA A01/A02 By Peri', 24, 37, 2300000, 'Loại Ren: 3/8-10\r\nĐầu Cơ Dán Kèm: Peri\r\nThông Số Ngọn : 12.5 mm\r\nCông nghệ ngọn: Maple\r\nTay Cầm: Tay trơn', 'gay-lcba-a01-a02.webp', 3, 7),
(74, 'Gậy Mit Demon DF 1', 24, 37, 4300000, 'Trọng lượng: 530 đến 550g\r\nTay cầm: Cuốn chỉ\r\nNgọn: Gỗ Maple\r\nTổng chiều dài cơ: 148.3 cm\r\nChiều dài cán: 76.8 cm\r\nChiều dài ngọn: 74.8 cm', 'mit-ma-22-3.webp', 10, 0),
(75, ' Cơ Bida Rhino RC23 Carbon', 24, 37, 2900000, 'Chất liệu chuôi : Gỗ phong cao cấp\r\nChất liệu ngọn: Mộc\r\nRen: Radial\r\nNgọn: Mộc\r\nKích thước ngọn: 12.75mm', 'rhino-rc23.jpg', 10, 0),
(76, 'Gậy OMIN XF-C01', 24, 37, 2800000, 'Tên Sản Phẩm: OMIN XF_C01\r\nChuôi : Làm từ gỗ mun,bọc da,dán decanl họa tiết\r\nNgọn : Làm từ gỗ mapel già chọn lọc\r\nSize ngọn : 12.8 mm\r\nRen : Radial', 'omin-XF-C01-2.webp', 10, 0),
(77, 'Cơ Mit DF22', 24, 37, 2800000, 'Ren: Radian\r\nNgọn: 12.75mm\r\nMàu sắc: trắng, xanh, nâu đỏ, đen\r\nTẩy: Everet', 'co-bida-mit-df22-2-1.webp', 10, 0),
(78, 'Cơ Bida Peri R-D (01-02-03-04-05)', 24, 37, 600000, 'Thương hiệu: PERI\r\nChuôi: Được làm từ gỗ phong già cao cấp\r\nngọn: Ngọn p20 công nghệ rỗng siêu khỏe\r\nRen: Radial phổ thông\r\nTay cầm: Bọc da có in dập logo PERI chống trơn trượt', 'peri-trang-den-0.webp', 10, 0),
(79, 'Gậy Carbon KONLLEN AMG – 2F', 24, 38, 900000, 'Thương hiệu: Konllen\r\nChuôi : Ghép trục carbon 4 trục\r\nDáng ngọn: Pro Taper\r\nSize ngọn: 12.5mm Full carbon\r\nTẩy: Konllen hellfire size M', 'cc.webp', 7, 3),
(80, 'Cơ Cuetec Cynergy Ghost Edition 95-134', 24, 38, 17500000, 'Thương hiệu: Cuetec\r\nNgọn: Cynergy 15K\r\nChiều dài ngọn: 29 inch\r\nKích cỡ ngọn: 12.5mm\r\nĐầu tẩy tiêu chuẩn: Tiger Sniper (mềm\r\nRen: 3/8×14', 'co-cutec-cynergy-svb-gen-one-xam2.webp', 9, 1),
(81, 'Cơ Cuetec Cynergy SVB Gen One White Trắng', 24, 38, 18500000, 'Ngọn: Cynergy 15K\r\nChiều dài ngọn: 29 inch\r\nKích cỡ ngọn: 12.5mm', 'cuetec-svb (1).jpg', 9, 1),
(82, ' Cơ Jflower JF20-21F Full Carbon', 24, 38, 21000000, ' Ren nối: RADIAL\r\n Ngọn: Carbon JFlower (1 trong những ngọn giảm bạt tốt nhất thế giới)\r\n Đầu tẩy: Moori', 'co-jf-20-21f-4.webp', 9, 1),
(83, 'Cơ Phá/Nhảy OMIN', 24, 41, 850000, 'Tay cầm: tay sần- 3Khúc\r\n\r\nRen nối: ren iNOX không gỉ\r\n\r\nNgọn mộc: 14 mm', 'co-pha-nhay-omin.webp', 10, 0),
(84, 'Gậy Phá Nhảy LCBA L-B1', 24, 41, 900000, '— Thể loại: PHÁ + NHẢY\r\n\r\n— Hoạ tiết: Sơn nhám xanh-đen\r\n\r\n— Tay cầm: Trơn – Ren: Quick-joint', 'pha-nhay-lcba (1).webp', 10, 0),
(85, ' Cơ Nhảy  Monster Carbon', 24, 41, 1200000, 'Thương hiệu: Litter Monster\r\nLoại cơ: Cơ nhảy 2 khúc\r\nTẩy: LM Break tip, 12.5mm', 'nhay-crack-little-monster.jpg', 10, 0),
(86, ' Gậy Nhảy Dragon Carbon 3 Khúc', 24, 41, 3000000, 'Tên sản phẩm : Nhảy Dragon Carbon 3 Khúc\r\nChất liệu : Carbon Comprosite\r\nChiều dài : 430mm ( 280mm – 150mm)', 'nhay-dragon-4.webp', 10, 0),
(87, 'Bàn Phăng PBA-L', 23, 40, 32000000, 'Nguồn gốc – Xuất xứ: Việt Nam\r\nMã sản phẩm: Bàn bida Min\r\nMặt đá: Đá nhập khẩu Trung Quốc', 'ban-phang-pba.webp', 5, 5),
(88, 'Bàn Phăng Min', 23, 40, 27000000, 'Nguồn gốc – Xuất xứ: Việt Nam\r\nMã sản phẩm: Bàn bida Min\r\nMặt đá: Đá nhập khẩu Trung Quốc', 'ban-bida-phang-min.webp', 5, 5),
(89, ' Bàn bida 3 băng Hollywood', 23, 40, 33000000, 'Nguồn gốc – Xuất xứ: Việt Nam\r\nMã sản phẩm: Bàn bida Min\r\nMặt đá: Đá nhập khẩu Trung Quốc', 'ban-phang-signature.webp', 5, 5),
(90, 'Bàn Phăng Signature', 23, 40, 27000000, 'Nguồn gốc – Xuất xứ: Việt Nam\r\nMã sản phẩm: Bàn bida Min\r\nMặt đá: Đá nhập khẩu Trung Quốc', 'ban-bida-phang-pba.jpg', 8, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product_img_desc`
--

CREATE TABLE `tbl_product_img_desc` (
  `product_id` int(11) NOT NULL,
  `product_img_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product_img_desc`
--

INSERT INTO `tbl_product_img_desc` (`product_id`, `product_img_desc`) VALUES
(10, 'z5561452029493_ea94ba3ff350b8e560cfd4e8bf60c520.jpg'),
(10, 'z5561452039636_c0185f23aeb4603e6ccf7a5b51fc14b8.jpg'),
(10, 'z5561452041114_dcd3f0fd294a8c7afc0f048abf7dff85.jpg'),
(11, 'z5561452029493_ea94ba3ff350b8e560cfd4e8bf60c520.jpg'),
(11, 'z5561452039636_c0185f23aeb4603e6ccf7a5b51fc14b8.jpg'),
(11, 'z5561452041114_dcd3f0fd294a8c7afc0f048abf7dff85.jpg'),
(12, 'z5561452016449_135532b06bafc283390251a65541f15b.jpg'),
(12, 'z5561452029493_ea94ba3ff350b8e560cfd4e8bf60c520.jpg'),
(13, 'z5561452016449_135532b06bafc283390251a65541f15b.jpg'),
(13, 'z5561452029493_ea94ba3ff350b8e560cfd4e8bf60c520.jpg'),
(14, 'z5561452029493_ea94ba3ff350b8e560cfd4e8bf60c520.jpg'),
(14, 'z5561452039636_c0185f23aeb4603e6ccf7a5b51fc14b8.jpg'),
(14, 'z5561452041114_dcd3f0fd294a8c7afc0f048abf7dff85.jpg'),
(15, 'z5666676157728_07e81165c169208abb86eb4b6f78efb3.jpg'),
(15, 'z5666683620542_cccca1e978ce855ad67aa4c36f415834.jpg'),
(15, 'z5666731403320_431cc01dcb6eb992eba3fb53e6bc03e6.jpg'),
(16, ''),
(17, ''),
(18, ''),
(19, ''),
(20, ''),
(21, ''),
(22, ''),
(34, ''),
(35, ''),
(42, 'ban-bida-aileex-9022-nhap-trung.webp'),
(42, 'ban-bida-aileex-9022-nhap-trung-1.webp'),
(42, 'ban-bida-aileex-9022-nhap-trung-2.webp'),
(42, 'ban-bida-aileex-9022-nhap-trung-5.webp'),
(43, 'ban-bida-winpon-1-720x720.webp'),
(43, 'ban-bida-winpon-3-720x720.webp'),
(43, 'ban-bida-winpon-4-720x720.webp'),
(44, 'ban-bida-samurai-9022-hang-nhap-khau.jpg'),
(44, 'ban-bida-samurai-9022-hang-nhap-khau-1.jpg'),
(44, 'ban-bida-samurai-9022-hang-nhap-khau-2.jpg'),
(45, 'ban-bida-mr-sung-den-720x720.webp'),
(45, 'ban-bida-mr-sung-xam-720x721 (1).webp'),
(46, 'leadsuper-v1-1.webp'),
(46, 'leadsuper-v1-2.webp'),
(46, 'leadsuper-v1-4.webp'),
(47, 'zokue-carbon-2.webp'),
(47, 'zokue-carbon-4.webp'),
(48, 'co-cuppa-acula.webp'),
(48, 'co-cuppa-acula-1.webp'),
(48, 'co-cuppa-acula-2.webp'),
(49, 'dragon-legend-2-1-1.jpg'),
(49, 'dragon-legend-2-2-1.jpg'),
(49, 'phu-kien-co-bida.webp'),
(50, 'rhino-rc23.jpg'),
(50, 'rhino-rc23-1.jpg'),
(50, 'rhino-rc23-2.jpg'),
(50, 'rhino-rc23-3.jpg'),
(51, 'co-rhino-lo-2.jpg'),
(51, 'co-rhino-lo-4.jpg'),
(51, 'co-rhino-lo-5.jpg'),
(52, 'bao-co-1x1-1 (1).webp'),
(52, 'bao-co-1x1-1.webp'),
(53, 'bao-co-da-mem-ba1.webp'),
(53, 'bao-co-da-mem-ba-3.webp'),
(53, 'bao-co-da-mem-ba-4.webp'),
(54, 'bao-da-cao-cap-1x1-hong-1.webp'),
(54, 'bao-da-cao-cap-1x1-trang-den-1.webp'),
(54, 'bao-da-cao-cap-1x1-vang-den-1.webp'),
(54, 'bao-da-cao-cap-1x1-xanh-den-1.webp'),
(55, 'bao-dung-co-jinchuan-02 (1).webp'),
(55, 'bao-dung-co-jinchuan-02.jpg'),
(56, 'bao-co-peri-white-kylin.webp'),
(57, 'bao-co-peri-shadow.webp'),
(57, 'bao-co-peri-shadow1.webp'),
(58, 'bao-konllen-macaron-2x4-1.webp'),
(58, 'bao-konllen-macaron-2x4-2.webp'),
(58, 'bao-konllen-macaron-2x4-3.webp'),
(58, 'bao-konllen-macaron-2x4-4.webp'),
(58, 'bao-konllen-macaron-2x4-5.webp'),
(59, 'bao-konllen-OXFORD-1x2-2.webp'),
(59, 'bao-konllen-OXFORD-1x2-3.webp'),
(59, 'bao-konllen-OXFORD-1x2-4.webp'),
(60, 'bao-da-cao-cap-1x1-hong-1.webp'),
(60, 'bao-da-cao-cap-1x1-trang-den-1.webp'),
(60, 'bao-da-cao-cap-1x1-vang-den-1.webp'),
(60, 'bao-da-cao-cap-1x1-xanh-den-1.webp'),
(61, 'bao-dung-co-jinchuan-03.jpg'),
(61, 'bao-dung-co-jinchuan-03-1 (1).jpg'),
(62, 'bao-da-cao-cap-den-trang-2x2-2.webp'),
(63, 'bao-co-da-2x2-1-1.webp'),
(63, 'bao-co-da-2x2-2.webp'),
(63, 'bao-co-da-2x2-3.webp'),
(64, 'lo-turning-pont-1.webp'),
(64, 'lo-turning-pont-2.webp'),
(64, 'lo-turning-pont-3.webp'),
(65, 'kep-lo-taom-1.jpg'),
(65, 'kep-lo-taom-3.jpg'),
(65, 'kep-lo-taom-4.jpg'),
(66, 'lo-taom1.jpg'),
(66, 'lo-taom2.jpg'),
(67, 'lo-roku-1.webp'),
(67, 'lo-roku-2.webp'),
(67, 'lo-roku-3.webp'),
(68, 'hop-dung-lo-2.jpg'),
(68, 'hop-dung-lo-3.jpg'),
(68, 'hop-dung-lo-4.jpg'),
(69, 'maple-leaf.jpg'),
(69, 'maple-leaf-1.jpg'),
(69, 'rhino-rc23-3.jpg'),
(70, 'co-ty-rk-1.webp'),
(70, 'co-ty-rk-2.webp'),
(70, 'co-ty-rk-3.webp'),
(70, 'co-ty-rk-4.webp'),
(71, 'co-cuppa-mt01-1.webp'),
(71, 'co-cuppa-mt01-2.webp'),
(71, 'co-cuppa-mt01-3.webp'),
(71, 'co-cuppa-mt01-4.webp'),
(72, 'cuppa-x5-1.webp'),
(72, 'cuppa-x5-2.webp'),
(72, 'cuppa-x5-3.webp'),
(72, 'cuppa-x5-4.webp'),
(73, 'gay-lcba-a01-a02-1.webp'),
(73, 'gay-lcba-a01-a02-2.webp'),
(73, 'gay-lcba-a01-a02-3.webp'),
(73, 'gay-lcba-a01-a02-4.webp'),
(74, 'mit-ma-22.webp'),
(74, 'mit-ma-22-1.webp'),
(74, 'mit-ma-22-2.webp'),
(75, 'rhino-rc23-1.jpg'),
(75, 'rhino-rc23-2.jpg'),
(75, 'rhino-rc23-3 (1).jpg'),
(75, 'rhino-rc23-3.jpg'),
(76, 'omin-XF-C01-3.webp'),
(76, 'omin-XF-C01-4.webp'),
(76, 'phu-kien-co-bida.webp'),
(77, 'co-bida-mit-df22-1.webp'),
(77, 'co-bida-mit-df22-1-1.webp'),
(78, 'peri-trang-den-1-1.webp'),
(78, 'peri-trang-den-3-1.webp'),
(78, 'peri-xanh-den (1).webp'),
(78, 'peri-xanh-den.webp'),
(79, 'cc2.webp'),
(79, 'cc3.webp'),
(80, 'co-cutec-cynergy-svb-gen-one-xam.webp'),
(80, 'co-cutec-cynergy-svb-gen-one-xam1.webp'),
(80, 'co-ty-rk-3.webp'),
(81, 'cuetec-svb.jpg'),
(81, 'cuetec-svb-1.jpg'),
(81, 'cuetec-svb-2.jpg'),
(81, 'cuetec-svb-3.jpg'),
(82, 'co-jf-20-21f.webp'),
(82, 'co-jf-20-21f-1.webp'),
(82, 'co-jf-20-21f-2.webp'),
(82, 'co-jf-20-21f-3.webp'),
(83, 'co-pha-nhay-omin-1.webp'),
(83, 'co-pha-nhay-omin-2.webp'),
(83, 'co-pha-nhay-omin-3.webp'),
(83, 'co-pha-nhay-omin-4.webp'),
(84, 'pha-nhay-lcba-2.webp'),
(84, 'pha-nhay-lcba-4.webp'),
(84, 'pha-nhay-lcba.webp'),
(85, 'nhay-crack-little-monster-1.jpg'),
(85, 'nhay-crack-little-monster-2.jpg'),
(86, 'nhay-dragon-5.webp'),
(86, 'nhay-dragon-7.webp'),
(86, 'nhay-dragon-8.webp'),
(87, 'ban-bida-phang-pba.jpg'),
(87, 'ban-bida-phang-pba-2.jpg'),
(87, 'ban-bida-phang-pba-3.jpg'),
(87, 'ban-bida-phang-pba-5.jpg'),
(87, 'ban-bida-phang-pba-6.jpg'),
(88, 'ban-bida-phang-min.jpg'),
(88, 'ban-bida-phang-min-2.jpg'),
(88, 'ban-bida-phang-min-3.jpg'),
(88, 'ban-bida-phang-min-4.jpg'),
(88, 'ban-bida-phang-min-5.jpg'),
(89, 'ban-bida-phang-co-he-thong-suoi.webp'),
(90, 'ban-bida-phang-signature-4.jpg'),
(90, 'ban-bida-signature-2.jpg'),
(90, 'ban-bida-signature-da-trung-quoc-1.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `vnp_transaction_id` varchar(50) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `vnp_response_code` varchar(10) NOT NULL,
  `vnp_transaction_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_vouchers`
--

CREATE TABLE `user_vouchers` (
  `id` int(11) NOT NULL,
  `voucher_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_used` tinyint(1) DEFAULT 0,
  `used_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_vouchers`
--

INSERT INTO `user_vouchers` (`id`, `voucher_id`, `user_id`, `is_used`, `used_at`, `created_at`) VALUES
(1, 5, 7, 0, NULL, '2025-05-16 15:55:59'),
(2, 5, 13, 0, NULL, '2025-05-16 15:55:59'),
(3, 5, 14, 0, NULL, '2025-05-16 15:55:59'),
(5, 6, 38, 1, '2025-05-19 07:59:23', '2025-05-19 00:58:47'),
(6, 7, 38, 0, NULL, '2025-05-19 02:38:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) DEFAULT 0.00,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `usage_limit` int(11) DEFAULT 0,
  `used_count` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `discount_type`, `discount_value`, `min_order_amount`, `start_date`, `end_date`, `usage_limit`, `used_count`, `status`, `description`, `created_at`) VALUES
(5, '55555', 'fixed', 50000.00, 0.00, '2025-05-16 17:49:00', '2025-05-23 17:49:00', 1, 1, 'active', '5555', '2025-05-16 15:49:32'),
(6, '11111111', 'fixed', 5000000.00, 0.00, '2025-05-19 02:57:00', '2025-05-26 02:57:00', 2, 1, 'active', 'cccc', '2025-05-19 00:58:29'),
(7, '5555555555', 'fixed', 500000.00, 0.00, '2025-05-19 04:38:00', '2025-05-26 04:38:00', 2, 0, 'active', '', '2025-05-19 02:38:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `voucher_logs`
--

CREATE TABLE `voucher_logs` (
  `id` int(11) NOT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `admin_id` int(11) NOT NULL,
  `action` enum('create','update','delete','send') NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `voucher_logs`
--

INSERT INTO `voucher_logs` (`id`, `voucher_id`, `admin_id`, `action`, `details`, `created_at`) VALUES
(1, NULL, 3, 'create', 'Created voucher: 33333', '2025-05-16 15:40:07'),
(2, NULL, 3, 'update', 'Updated voucher: 33333', '2025-05-16 15:41:14'),
(4, NULL, 3, 'create', 'Created voucher: 5544444', '2025-05-16 15:43:24'),
(6, NULL, 3, 'create', 'Created voucher: 4444', '2025-05-16 15:44:44'),
(8, NULL, 3, 'create', 'Created voucher: 5555', '2025-05-16 15:48:47'),
(9, NULL, 3, 'delete', 'Deleted voucher: 5555', '2025-05-16 15:48:55'),
(10, 5, 3, 'create', 'Created voucher: 55555', '2025-05-16 15:49:32'),
(11, 5, 3, 'send', 'Sent voucher 55555 to user ID: 7', '2025-05-16 15:55:59'),
(12, 5, 3, 'send', 'Sent voucher 55555 to user ID: 13', '2025-05-16 15:55:59'),
(13, 5, 3, 'send', 'Sent voucher 55555 to user ID: 14', '2025-05-16 15:55:59'),
(14, 5, 3, 'send', 'Sent voucher 55555 to user ID: 37', '2025-05-16 15:55:59'),
(15, 5, 3, 'update', 'Updated voucher: 55555', '2025-05-16 16:22:12'),
(16, 5, 3, 'update', 'Updated voucher: 55555', '2025-05-16 16:22:21'),
(17, 6, 3, 'create', 'Created voucher: 11111111', '2025-05-19 00:58:29'),
(18, 6, 3, 'send', 'Sent voucher 11111111 to user ID: 38', '2025-05-19 00:58:47'),
(19, 7, 3, 'create', 'Created voucher: 5555555555', '2025-05-19 02:38:42'),
(20, 7, 3, 'send', 'Sent voucher 5555555555 to user ID: 38', '2025-05-19 02:38:52');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`email`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `loginadmin`
--
ALTER TABLE `loginadmin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `momo_payments`
--
ALTER TABLE `momo_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_account` (`id_account`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_details_order` (`order_id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Chỉ mục cho bảng `register_user`
--
ALTER TABLE `register_user`
  ADD PRIMARY KEY (`register_user_id`);

--
-- Chỉ mục cho bảng `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Chỉ mục cho bảng `tbl_cartegory`
--
ALTER TABLE `tbl_cartegory`
  ADD PRIMARY KEY (`cartegory_id`);

--
-- Chỉ mục cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `user_vouchers`
--
ALTER TABLE `user_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `voucher_user` (`voucher_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `voucher_logs`
--
ALTER TABLE `voucher_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voucher_id` (`voucher_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `loginadmin`
--
ALTER TABLE `loginadmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `momo_payments`
--
ALTER TABLE `momo_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `register_user`
--
ALTER TABLE `register_user`
  MODIFY `register_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `tbl_brand`
--
ALTER TABLE `tbl_brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `tbl_cartegory`
--
ALTER TABLE `tbl_cartegory`
  MODIFY `cartegory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT cho bảng `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `user_vouchers`
--
ALTER TABLE `user_vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `voucher_logs`
--
ALTER TABLE `voucher_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_id_account` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_order_details_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Các ràng buộc cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user_vouchers`
--
ALTER TABLE `user_vouchers`
  ADD CONSTRAINT `user_vouchers_ibfk_1` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_vouchers_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `account` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `voucher_logs`
--
ALTER TABLE `voucher_logs`
  ADD CONSTRAINT `voucher_logs_ibfk_1` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `voucher_logs_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `loginadmin` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
