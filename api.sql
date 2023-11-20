-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2023 at 03:10 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `price` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `image`, `heading`, `content`, `price`) VALUES
(9, 'grass.png', 'Lawn mowing', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.	', '00'),
(11, 'lawnmower.png', 'Lawn', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.	', '00'),
(12, 'coverUp.png', 'Spring Clean Up', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ', '00'),
(13, 'service.png', 'Lawn Maintenance', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ', '00'),
(14, 'seeding.png', 'Seeding  Aeration', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.\r\n', '00'),
(15, 'snowplow.png', 'Snow Removal', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ', '00');

-- --------------------------------------------------------

--
-- Table structure for table `customer_images`
--

CREATE TABLE `customer_images` (
  `customer_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `provider_id` int(11) NOT NULL,
  `proposal_id` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_images`
--

INSERT INTO `customer_images` (`customer_id`, `image_path`, `provider_id`, `proposal_id`, `id`) VALUES
(64, 'uploads/gallery1.png', 65, 356, 241),
(64, 'uploads/gallery2.png', 65, 356, 242),
(64, 'uploads/gallery3.png', 65, 356, 243),
(64, 'uploads/gallery4.png', 65, 356, 244),
(64, 'uploads/hiring1.png', 65, 356, 245),
(64, 'uploads/project-1.jpg', 65, 357, 246),
(64, 'uploads/project-2.jpg', 65, 357, 247),
(64, 'uploads/project-3.jpg', 65, 357, 248),
(64, 'uploads/project-4.jpg', 65, 357, 249),
(64, 'uploads/project-5.jpg', 65, 357, 250),
(64, 'uploads/project-3.jpg', 65, 359, 251),
(64, 'uploads/project-4.jpg', 65, 359, 252),
(64, 'uploads/project-5.jpg', 65, 359, 253),
(64, 'uploads/project-6.jpg', 65, 359, 254),
(64, 'uploads/project-7.jpg', 65, 359, 255),
(69, 'uploads/Grass.png', 65, 360, 256),
(69, 'uploads/provider1.png', 65, 360, 257),
(69, 'uploads/providerimage.png', 65, 360, 258),
(69, 'uploads/recent1.png', 65, 360, 259),
(69, 'uploads/Snow Plow.png', 65, 360, 260),
(64, 'uploads/Grass.png', 68, 361, 261),
(64, 'uploads/provider1.png', 68, 361, 262),
(64, 'uploads/provider1.png', 68, 361, 263),
(64, 'uploads/providerimage.png', 68, 361, 264),
(64, 'uploads/recent1.png', 68, 361, 265),
(64, 'uploads/Grass.png', 68, 362, 266),
(64, 'uploads/provider1.png', 68, 362, 267),
(64, 'uploads/provider1.png', 68, 362, 268),
(64, 'uploads/providerimage.png', 68, 362, 269),
(64, 'uploads/providerimage.png', 68, 362, 270),
(69, 'uploads/Cover Up.png', 68, 363, 271),
(69, 'uploads/Cover Up.png', 68, 363, 272),
(69, 'uploads/Grass.png', 68, 363, 273),
(69, 'uploads/Grass.png', 68, 363, 274),
(69, 'uploads/provider1.png', 68, 363, 275),
(64, 'uploads/background.jpg', 65, 364, 276),
(64, 'uploads/earth.png', 65, 364, 277),
(64, 'uploads/placeholder.jpg', 65, 364, 278),
(64, 'uploads/placeholder-vertical.jpg', 65, 364, 279),
(64, 'uploads/simation.jpeg', 65, 364, 280),
(64, 'uploads/background.jpg', 65, 365, 281),
(64, 'uploads/earth.png', 65, 365, 282),
(64, 'uploads/placeholder.jpg', 65, 365, 283),
(64, 'uploads/placeholder-vertical.jpg', 65, 365, 284),
(64, 'uploads/simation.jpeg', 65, 365, 285),
(64, 'uploads/earth.png', 65, 366, 286),
(64, 'uploads/earth.png', 65, 366, 287),
(64, 'uploads/placeholder.jpg', 65, 366, 288),
(64, 'uploads/placeholder.jpg', 65, 366, 289),
(64, 'uploads/placeholder-vertical.jpg', 65, 366, 290),
(64, 'uploads/earth.png', 65, 367, 291),
(64, 'uploads/earth.png', 65, 367, 292),
(64, 'uploads/placeholder.jpg', 65, 367, 293),
(64, 'uploads/placeholder.jpg', 65, 367, 294),
(64, 'uploads/placeholder-vertical.jpg', 65, 367, 295),
(64, 'uploads/earth.png', 65, 370, 296),
(64, 'uploads/earth.png', 65, 370, 297),
(64, 'uploads/placeholder.jpg', 65, 370, 298),
(64, 'uploads/placeholder.jpg', 65, 370, 299),
(64, 'uploads/placeholder-vertical.jpg', 65, 370, 300);

-- --------------------------------------------------------

--
-- Table structure for table `customer_proposal`
--

CREATE TABLE `customer_proposal` (
  `id` int(11) NOT NULL,
  `year` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `selected_time` text DEFAULT NULL,
  `user_content` varchar(255) DEFAULT NULL,
  `selected_services` varchar(255) DEFAULT NULL,
  `total_amount` varchar(255) DEFAULT NULL,
  `provider_id` int(11) NOT NULL,
  `current_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` text NOT NULL DEFAULT 'new_offer',
  `counter_totall` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_proposal`
--

INSERT INTO `customer_proposal` (`id`, `year`, `month`, `day`, `customer_id`, `selected_time`, `user_content`, `selected_services`, `total_amount`, `provider_id`, `current_time`, `status`, `counter_totall`) VALUES
(356, '2023', '10', '29', 64, '03:02 PM', 'IKJUHSXDCFVBGHN', 'Lawn mowing, Lawn', '132', 65, '2023-10-27 19:00:00', 'scheduled_offer', '332'),
(357, '2023', '10', '28', 64, '02:01 PM', 'newone', 'Lawn mowing, Lawn, Seeding  Aeration, Snow Removal', '112', 65, '2023-10-27 19:00:00', 'scheduled_offer', '512'),
(358, '2023', '10', '30', 64, '02:01 PM', 'ssdad', 'Seeding  Aeration', '100', 65, '2023-10-29 19:00:00', 'reject_offer', '200'),
(359, '2023', '10', '31', 64, '03:02 PM', 'GHGHGHGH', 'Lawn mowing, Lawn, Seeding  Aeration, Snow Removal', '855', 65, '2023-10-29 19:00:00', 'reject_offer', '2155'),
(360, '2023', '11', '1', 69, '02:01 AM', 'rtrtrt', 'Lawn mowing, Lawn, Seeding  Aeration', '378', 65, '2023-10-30 19:00:00', 'replied_offer', '3378'),
(361, '2023', '10', '31', 64, '02:01 PM', 'swdc ', 'Lawn mowing', '22', 68, '2023-10-30 19:00:00', 'scheduled_offer', NULL),
(362, '2023', '11', '1', 64, '02:01 PM', 'qasxd', 'Lawn mowing', '1111', 68, '2023-10-30 19:00:00', 'reject_offer', NULL),
(363, '2023', '10', '31', 69, '03:02 PM', 'wsed', 'Lawn mowing', '344', 68, '2023-10-30 19:00:00', 'replied_offer', '1344'),
(364, '2023', '11', '2', 64, '04:01 PM', 'edcfv ', 'Lawn mowing, Lawn', '222', 65, '2023-10-31 19:00:00', 'order_in_progress', NULL),
(365, '2023', '11', '4', 64, '05:02 PM', 'aqsxdc', 'Lawn mowing, Lawn, Spring Clean Up, Lawn Maintenance, Seeding  Aeration, Snow Removal', '2100', 65, '2023-11-01 19:00:00', 'order_in_progress', NULL),
(366, '2023', '11', '3', 64, '02:01 AM', 'qaszdc', 'Lawn mowing, Lawn, Lawn Maintenance', '5700', 65, '2023-11-03 07:23:00', 'scheduled_offer', '53700'),
(367, '2023', '11', '4', 64, '03:02 PM', 'testerodho', 'Lawn mowing', '1000', 65, '2023-11-02 19:00:00', 'order_in_progress', '11000'),
(368, '2023', '11', '4', 64, '03:02 PM', 'rocket', 'Lawn, Lawn Maintenance', '200', 65, '2023-11-03 23:06:19', 'order_in_progress', '2200'),
(369, '2023', '11', '4', 64, '02:00 AM', 'kingdom', 'Lawn mowing, Lawn', '600', 65, '2023-11-03 23:09:21', 'new_offer', NULL),
(370, '2023', '11', '4', 64, '02:01 PM', 'hlw kingdom', 'Lawn mowing, Lawn, Lawn Maintenance', '600', 65, '2023-11-03 23:10:23', 'replied_offer', '3600');

-- --------------------------------------------------------

--
-- Table structure for table `customer_services`
--

CREATE TABLE `customer_services` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `provider_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `proposal_id` int(11) NOT NULL,
  `counter_price` varchar(255) DEFAULT NULL,
  `counter_totall` varchar(255) DEFAULT NULL,
  `counter_note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_services`
--

INSERT INTO `customer_services` (`id`, `customer_id`, `provider_id`, `service_id`, `service_name`, `price`, `total_amount`, `proposal_id`, `counter_price`, `counter_totall`, `counter_note`) VALUES
(246, 64, 65, 0, 'Lawn mowing', 56.00, 132.00, 356, '156', '332', 'swxd'),
(247, 64, 65, 0, 'Lawn', 76.00, 132.00, 356, '176', '332', 'swxd'),
(248, 64, 65, 0, 'Lawn mowing', 12.00, 112.00, 357, '112', '512', 'edcfv'),
(249, 64, 65, 0, 'Lawn', 23.00, 112.00, 357, '123', '512', 'edcfv'),
(250, 64, 65, 0, 'Seeding  Aeration', 34.00, 112.00, 357, '134', '512', 'edcfv'),
(251, 64, 65, 0, 'Snow Removal', 43.00, 112.00, 357, '143', '512', 'edcfv'),
(252, 64, 65, 0, 'Seeding  Aeration', 100.00, 100.00, 358, '200', '200', '200'),
(253, 64, 65, 0, 'Lawn mowing', 56.00, 855.00, 359, '156', '2155', 'frsd'),
(254, 64, 65, 0, 'Lawn', 55.00, 855.00, 359, '155', '2155', 'frsd'),
(255, 64, 65, 0, 'Seeding  Aeration', 77.00, 855.00, 359, '177', '2155', 'frsd'),
(256, 64, 65, 0, 'Snow Removal', 667.00, 855.00, 359, '1667', '2155', 'frsd'),
(257, 69, 65, 0, 'Lawn mowing', 122.00, 378.00, 360, '1122', '3378', 'd'),
(258, 69, 65, 0, 'Lawn', 145.00, 378.00, 360, '1145', '3378', 'd'),
(259, 69, 65, 0, 'Seeding  Aeration', 111.00, 378.00, 360, '1111', '3378', 'd'),
(260, 64, 68, 0, 'Lawn mowing', 22.00, 22.00, 361, NULL, NULL, NULL),
(261, 64, 68, 0, 'Lawn mowing', 1111.00, 1111.00, 362, NULL, NULL, NULL),
(262, 69, 68, 0, 'Lawn mowing', 344.00, 344.00, 363, '1344', '1344', 'new'),
(263, 64, 65, 0, 'Lawn mowing', 111.00, 222.00, 364, NULL, NULL, NULL),
(264, 64, 65, 0, 'Lawn', 111.00, 222.00, 364, NULL, NULL, NULL),
(265, 64, 65, 0, 'Lawn mowing', 100.00, 2100.00, 365, NULL, NULL, NULL),
(266, 64, 65, 0, 'Lawn', 200.00, 2100.00, 365, NULL, NULL, NULL),
(267, 64, 65, 0, 'Spring Clean Up', 300.00, 2100.00, 365, NULL, NULL, NULL),
(268, 64, 65, 0, 'Lawn Maintenance', 400.00, 2100.00, 365, NULL, NULL, NULL),
(269, 64, 65, 0, 'Seeding  Aeration', 500.00, 2100.00, 365, NULL, NULL, NULL),
(270, 64, 65, 0, 'Snow Removal', 600.00, 2100.00, 365, NULL, NULL, NULL),
(271, 64, 65, 0, 'Lawn mowing', 100.00, 5700.00, 366, '1100', '53700', 'aqzsx'),
(272, 64, 65, 0, 'Lawn', 5400.00, 5700.00, 366, '51400', '53700', 'aqzsx'),
(273, 64, 65, 0, 'Lawn Maintenance', 200.00, 5700.00, 366, '1200', '53700', 'aqzsx'),
(274, 64, 65, 0, 'Lawn mowing', 1000.00, 1000.00, 367, '11000', '11000', ''),
(275, 64, 65, 0, 'Lawn', 100.00, 200.00, 368, '1100', '2200', 'rocket counter'),
(276, 64, 65, 0, 'Lawn Maintenance', 100.00, 200.00, 368, '1100', '2200', 'rocket counter'),
(277, 64, 65, 0, 'Lawn mowing', 300.00, 600.00, 369, NULL, NULL, NULL),
(278, 64, 65, 0, 'Lawn', 300.00, 600.00, 369, NULL, NULL, NULL),
(279, 64, 65, 0, 'Lawn mowing', 200.00, 600.00, 370, '1200', '3600', ''),
(280, 64, 65, 0, 'Lawn', 200.00, 600.00, 370, '1200', '3600', ''),
(281, 64, 65, 0, 'Lawn Maintenance', 200.00, 600.00, 370, '1200', '3600', '');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `local_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `filename`, `local_path`) VALUES
(1, 'AirportService.png', 'images/AirportService.png'),
(2, 'AirportService.png', 'images/AirportService.png'),
(3, 'airoplane.png', 'images/airoplane.png'),
(4, 'client.png', 'images/client.png');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `proposal_id` int(11) DEFAULT NULL,
  `provider_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `provider_name` varchar(255) DEFAULT NULL,
  `message_content` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `proposal_id`, `provider_id`, `customer_id`, `provider_name`, `message_content`, `status`, `time`) VALUES
(17, 359, 65, 64, '0', 'provider has accepted your offer.', 'customer_send', '2023-11-03 19:37:24'),
(18, 359, 65, 64, '0', 'provider has rejected your offer.', 'customer_send', '2023-11-03 19:37:24'),
(19, 360, 65, 69, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 19:37:24'),
(20, 361, 68, 64, '0', 'Customer has Accepted your Counter offer.', 'customer_send', '2023-11-03 19:37:24'),
(21, 362, 68, 64, '0', 'Customer has rejected your Counter offer.', 'customer_send', '2023-11-03 19:37:24'),
(22, 361, 68, 64, '0', 'Customer has Accepted your Counter offer.', 'customer_send', '2023-11-03 19:37:24'),
(23, 362, 68, 64, '0', 'Customer has rejected your Counter offer.', 'provider_send', '2023-11-03 19:37:24'),
(24, 358, 65, 64, '0', 'Customer has Accepted your Counter offer.', 'customer_send', '2023-11-03 19:37:24'),
(25, 360, 65, 69, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 19:37:24'),
(26, 357, 65, 64, '0', 'Customer has Accepted your Counter offer.', 'customer_send', '2023-11-03 19:37:24'),
(27, 358, 65, 64, '0', 'Customer has rejected your Counter offer.', 'customer_send', '2023-11-03 19:37:24'),
(28, 364, 65, 64, '0', 'provider has accepted your offer.', 'provider_send', '2023-11-03 19:37:24'),
(29, 364, 65, 64, '0', 'provider has accepted your offer.', 'provider_send', '2023-11-03 19:37:24'),
(30, 364, 65, 64, '0', 'provider has accepted your offer.', 'provider_send', '2023-11-03 19:37:24'),
(31, 364, 65, 64, '0', 'provider has accepted your offer.', 'provider_send', '2023-11-03 19:37:24'),
(32, 364, 65, 64, '0', 'provider has accepted your offer.', 'provider_send', '2023-11-03 19:37:24'),
(33, 364, 65, 64, '0', 'provider has accepted your offer.', 'provider_send', '2023-11-03 19:37:24'),
(34, 365, 65, 64, '0', 'provider has accepted your offer.', 'provider_send', '2023-11-03 19:37:24'),
(35, 367, 65, 64, NULL, 'You recive a new order from Customer', 'customer_send', '2023-11-03 19:37:24'),
(36, 367, 65, 64, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 19:37:24'),
(37, 367, 65, 64, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 19:37:24'),
(38, 367, 65, 64, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 19:37:24'),
(39, 367, 65, 64, '0', 'Customer has Accepted your Counter offer.', 'customer_send', '2023-11-03 19:37:24'),
(40, 367, 65, 64, '0', 'provider has accepted your offer.', 'provider_send', '2023-11-03 19:37:24'),
(41, 367, 65, 64, '0', 'provider has accepted your offer.', 'provider_send', '2023-11-03 19:37:24'),
(42, 366, 65, 64, '0', 'provider has accepted your offer.', 'provider_send', '2023-11-03 19:39:38'),
(43, 366, 65, 64, '0', 'Customer has Accepted your Counter offer.', 'customer_send', '2023-11-03 19:44:47'),
(44, 366, 65, 64, '0', 'Customer has Accepted your Counter offer.', 'customer_send', '2023-11-03 20:41:41'),
(45, 366, 65, 64, '0', 'Customer has rejected your Counter offer.', 'customer_send', '2023-11-03 20:42:00'),
(46, 366, 65, 64, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 21:05:53'),
(47, 366, 65, 64, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 21:12:26'),
(48, 366, 65, 64, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 21:20:39'),
(49, 366, 65, 64, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 21:21:09'),
(50, 366, 65, 64, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 21:23:20'),
(51, 366, 65, 64, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 21:24:53'),
(52, 366, 65, 64, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 21:26:05'),
(53, 366, 65, 64, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 22:15:41'),
(54, 366, 65, 64, '0', 'Customer has Accepted your Counter offer.', 'customer_send', '2023-11-03 22:18:30'),
(55, 366, 65, 64, '0', 'Customer has Accepted your Counter offer.', 'customer_send', '2023-11-03 22:32:29'),
(56, 366, 65, 64, '0', 'Customer has Accepted your Counter offer.', 'customer_send', '2023-11-03 22:32:50'),
(57, 366, 65, 64, '0', 'Customer has rejected your Counter offer.', 'customer_send', '2023-11-03 22:33:10'),
(58, 366, 65, 64, '0', 'Customer has Accepted your Counter offer.', 'customer_send', '2023-11-03 22:33:45'),
(59, 366, 65, 64, '0', 'Customer has rejected your Counter offer.', 'customer_send', '2023-11-03 22:34:04'),
(60, 366, 65, 64, '0', 'Customer has rejected your Counter offer.', 'customer_send', '2023-11-03 22:34:23'),
(61, 365, 65, 64, '0', 'provider has accepted your offer.', 'provider_send', '2023-11-03 22:41:15'),
(62, 366, 65, 64, '0', 'Customer has Accepted your Counter offer.', 'customer_send', '2023-11-03 22:45:58'),
(63, 368, 65, 64, NULL, 'You recive a new order from Customer', 'customer_send', '2023-11-03 23:06:19'),
(64, 368, 65, 64, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 23:07:08'),
(65, 368, 65, 64, '0', 'Customer has Accepted your Counter offer.', 'customer_send', '2023-11-03 23:07:51'),
(66, 368, 65, 64, '0', 'provider has accepted your offer.', 'provider_send', '2023-11-03 23:08:04'),
(67, 369, 65, 64, NULL, 'You recive a new order from Customer', 'customer_send', '2023-11-03 23:09:21'),
(68, 370, 65, 64, NULL, 'You recive a new order from Customer', 'customer_send', '2023-11-03 23:10:23'),
(69, 370, 65, 64, '0', 'provider has made a counter offer.', 'provider_send', '2023-11-03 23:10:46');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `package_name` text DEFAULT NULL,
  `package_limit` text DEFAULT NULL,
  `package_description` text DEFAULT NULL,
  `package_price` double DEFAULT NULL,
  `package_status` text DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `package_name`, `package_limit`, `package_description`, `package_price`, `package_status`) VALUES
(14, 'Basic Seller Package', 'Month', 'Lorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing', 4.99, 'Enabled'),
(15, 'Pro Seller Package', 'Month', 'Lorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing', 6.99, 'Enabled'),
(16, 'Business Seller Package', 'Month', 'Lorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing\r\nLorem Ipsum is simply dummy text of the printing', 9.99, 'Disabled');

-- --------------------------------------------------------

--
-- Table structure for table `provider_images`
--

CREATE TABLE `provider_images` (
  `id` int(11) NOT NULL,
  `provider_services_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provider_images`
--

INSERT INTO `provider_images` (`id`, `provider_services_id`, `image_path`, `created_at`) VALUES
(49, 165, 'uploads/gallery1.png', '2023-10-10 21:44:04'),
(50, 165, 'uploads/gallery2.png', '2023-10-10 21:44:04'),
(51, 165, 'uploads/gallery3.png', '2023-10-10 21:44:04'),
(52, 165, 'uploads/gallery4.png', '2023-10-10 21:44:04'),
(53, 165, 'uploads/hiring1.png', '2023-10-10 21:44:04'),
(89, 158, 'uploads/coverUp.png', '2023-10-17 22:20:38'),
(90, 158, 'uploads/grass.png', '2023-10-17 22:20:38'),
(91, 158, 'uploads/lawnmower.png', '2023-10-17 22:20:38'),
(92, 158, 'uploads/seeding.png', '2023-10-17 22:20:38'),
(93, 158, 'uploads/service.png', '2023-10-17 22:20:38'),
(99, 166, 'uploads/gallery1.png', '2023-10-25 20:38:37'),
(100, 166, 'uploads/gallery2.png', '2023-10-25 20:38:37'),
(101, 166, 'uploads/gallery3.png', '2023-10-25 20:38:37'),
(102, 166, 'uploads/gallery4.png', '2023-10-25 20:38:37'),
(103, 166, 'uploads/hiring1.png', '2023-10-25 20:38:37'),
(176, 159, 'uploads/earth.png', '2023-11-03 16:50:15'),
(177, 159, 'uploads/earth.png', '2023-11-03 16:50:15'),
(178, 159, 'uploads/placeholder.jpg', '2023-11-03 16:50:15'),
(179, 159, 'uploads/placeholder.jpg', '2023-11-03 16:50:15'),
(180, 159, 'uploads/placeholder-vertical.jpg', '2023-11-03 16:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `provider_registration`
--

CREATE TABLE `provider_registration` (
  `id` int(100) NOT NULL,
  `fullname` text NOT NULL,
  `email` text NOT NULL,
  `phone` int(15) NOT NULL,
  `address` text NOT NULL,
  `country` text NOT NULL,
  `region` text NOT NULL,
  `city` text NOT NULL,
  `zipcode` text NOT NULL,
  `password` text NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `verification_code` int(11) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `id_card_image` varchar(100) NOT NULL,
  `profile_picture` varchar(100) NOT NULL,
  `local_path` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provider_registration`
--

INSERT INTO `provider_registration` (`id`, `fullname`, `email`, `phone`, `address`, `country`, `region`, `city`, `zipcode`, `password`, `role_id`, `verification_code`, `is_verified`, `id_card_image`, `profile_picture`, `local_path`, `status`) VALUES
(62, 'Customer', 'king@gmail.com', 123, 'shikago usa', '', '', '', 'none', '$2y$10$7o7Qn2o8B8S8duLH1kHXje.Fsochdw.nVQw7aNWGiGXB.fr41avr.', 2, 6895, 0, 'application_images/aqua.png', 'application_images/gold.png', '', NULL),
(63, 'Customer', 'admin@gmail.com', 123, 'shikago usa', 'Belarus', 'Azad Kashmir', 'Muzaffarabad District', 'none', '$2y$10$IVlseCGGdQ9tva/C3KLj/OrzR8GbLas18cCbkQk49WqCupEG3VX.y', 1, 8737, 0, 'application_images/client.png', 'application_images/client.png', '', NULL),
(64, 'Customer', 'customer@gmail.com', 1234, 'shikago', 'Bangladesh', 'Sylhet Division', 'Maulvibazar', '234576', '$2y$10$KJ149cxf44BbnnryGuReRuSojSz5Mik/PqcJG8KIEjJMbaz5wguQi', 3, 1600, 0, '', 'profile_pictures/lawnmoving.png', '', NULL),
(65, 'provider', 'provider@gmail.com', 1234, 'united state america shikago', 'Belgium', 'Flanders', 'Provincie Limburg', 'none', '$2y$10$60/ukxJftalRl75d5yB0n.TXwtXuRDgZUNQCMrHBr1Ipvw6sACDOW', 2, 3227, 0, 'application_images/gallery1.png', 'application_images/provider.jpg', '', 'feature'),
(68, 'Customer2', 'provider2@gmail.com', 123, 'shikago usa', 'Belarus', 'Hawaii', 'Hawaii County', 'none', '$2y$10$UHzUa05sOJybcyJwWU.5W.9vyhEleiWYx/5QRGz03Rk2eXWAJMT.a', 2, 1559, 0, 'application_images/gallery1.png', 'application_images/hiring3.png', '', NULL),
(69, 'Customer', 'customer2@gmail.com', 123, 'shikago usa', 'Belarus', 'Azad Kashmir', 'Rawalakot Division', 'none', '$2y$10$bUMpFWoWWSlR6zdrkN9tJOzCNEABBD4j0wSiDZpGcGLol2beMUgsu', 3, 3517, 0, '', 'profile_pictures/customer.jpg', '', NULL),
(73, 'testerpro', 'test@gmail.com', 2147483647, 'uhgfd', 'Belarus', 'Minsk Oblast', 'Minski Rayon', '356', '$2y$10$J6CAcptnEkXi2WV.riAD2.pQHzwJ/56s/etK3NCFKnjhstT5In9Ye', 2, 1861, 0, 'application_images/gallery3.png', 'application_images/hiring4.png', '', NULL),
(74, 'frnd', 'friend@gmail.com', 2147483647, 'gtjgvhnmjnm,l', 'Australia', 'State of Victoria', 'Darebin', '72500', '$2y$10$KAlt589j9AP4m7Q463Bb9.ONf9h23ZZkAD91nZfFi1UezOtfkYiUu', 3, 4476, 0, '', 'profile_pictures/hiring2.png', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `provider_services`
--

CREATE TABLE `provider_services` (
  `id` int(11) NOT NULL,
  `provider_id` int(11) DEFAULT NULL,
  `shop_working_day` varchar(255) DEFAULT NULL,
  `working_timings_from` time DEFAULT NULL,
  `working_timings_to` time DEFAULT NULL,
  `shop_working_day_to` varchar(255) DEFAULT NULL,
  `services` text DEFAULT NULL,
  `commercial_services` text DEFAULT NULL,
  `selectedPackage` varchar(255) DEFAULT NULL,
  `additional_content` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provider_services`
--

INSERT INTO `provider_services` (`id`, `provider_id`, `shop_working_day`, `working_timings_from`, `working_timings_to`, `shop_working_day_to`, `services`, `commercial_services`, `selectedPackage`, `additional_content`) VALUES
(158, 62, 'Monday', '03:20:00', '15:20:00', 'Saturday', 'Lawn, Spring Clean Up, Lawn Maintenance, Snow Removal', 'Lawn, Spring Clean Up, Lawn Maintenance, Snow Removal', 'Pro Package', 'none one'),
(159, 65, 'Thursday', '08:00:00', '20:00:00', 'Friday', 'Lawn mowing, Lawn, Lawn Maintenance', 'Lawn mowing, Seeding  Aeration', 'Basic Package', 'newone'),
(165, 68, 'Monday', '02:43:00', '14:43:00', 'Friday', 'Lawn mowing', 'Lawn mowing', 'Pro Package', NULL),
(166, 73, 'Monday', '01:38:00', '13:38:00', 'Friday', 'Lawn mowing, Lawn, Seeding  Aeration, Snow Removal', 'Lawn mowing, Lawn, Seeding  Aeration, Snow Removal', 'Pro Package', 'sxdc sxd');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(100) NOT NULL,
  `fullname` text NOT NULL,
  `email` text NOT NULL,
  `phone` int(15) NOT NULL,
  `address` text NOT NULL,
  `country` text NOT NULL,
  `region` text NOT NULL,
  `city` text NOT NULL,
  `zipcode` text NOT NULL,
  `password` text NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `verification_code` int(11) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `fullname`, `email`, `phone`, `address`, `country`, `region`, `city`, `zipcode`, `password`, `role_id`, `verification_code`, `is_verified`) VALUES
(34, 'mubashir odho', 'odho@gmail.com', 2147483647, 'Shah faisal town malir halt', 'pk', 'Balochistan', 'Chagai District', 'odho', '$2y$10$2RR6tmLc8SpH6IOOOU.3U.kNpmiZq0Z0i5.D6EW2JAqX8a2f6sKl2', 3, 6180, 0),
(35, 'mubashir odho', 'aaa@gmail.com', 2147483647, 'shah faysal town C/32 malir halt', 'pk', 'Sindh', 'Ghotki District', '72500', '$2y$10$KcncfIaWPNkI1XcOF15DTuq76cB4xjBdXgdVT3Xa1WP1ivKnwHFmK', 3, 2784, 0),
(36, 'mubashir odho', 'sss@gmail.com', 2147483647, 'Shah faisal town malir halt', 'pk', 'Balochistan', 'Chagai District', 'odho', '$2y$10$RHHS273e98DZAcqJumdXB.j298vcwblm5B.UqeaFc5owkCBGv5g0i', 3, 8616, 0),
(37, 'mubashir odho', 'mubashirodho@gmail.com', 2147483647, 'Shah faisal town malir halt', 'pk', 'Azad Kashmir', 'Bhimbar District', 'odho', '$2y$10$Q2VKOTa5QAkf/HVVgHdsne1025ruZb4cszIxCv9CizK8r0q28EH5S', 3, 4857, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_images`
--
ALTER TABLE `customer_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_customer_images_customer_proposal` (`proposal_id`);

--
-- Indexes for table `customer_proposal`
--
ALTER TABLE `customer_proposal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_services`
--
ALTER TABLE `customer_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_customer_proposal_customer_services` (`proposal_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provider_images`
--
ALTER TABLE `provider_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provider_services_id` (`provider_services_id`);

--
-- Indexes for table `provider_registration`
--
ALTER TABLE `provider_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provider_services`
--
ALTER TABLE `provider_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provider_id` (`provider_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `customer_images`
--
ALTER TABLE `customer_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT for table `customer_proposal`
--
ALTER TABLE `customer_proposal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=371;

--
-- AUTO_INCREMENT for table `customer_services`
--
ALTER TABLE `customer_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=282;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `provider_images`
--
ALTER TABLE `provider_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `provider_registration`
--
ALTER TABLE `provider_registration`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `provider_services`
--
ALTER TABLE `provider_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_images`
--
ALTER TABLE `customer_images`
  ADD CONSTRAINT `FK_customer_images_customer_proposal` FOREIGN KEY (`proposal_id`) REFERENCES `customer_proposal` (`id`);

--
-- Constraints for table `customer_services`
--
ALTER TABLE `customer_services`
  ADD CONSTRAINT `FK_customer_proposal_customer_services` FOREIGN KEY (`proposal_id`) REFERENCES `customer_proposal` (`id`);

--
-- Constraints for table `provider_images`
--
ALTER TABLE `provider_images`
  ADD CONSTRAINT `provider_images_ibfk_1` FOREIGN KEY (`provider_services_id`) REFERENCES `provider_services` (`id`);

--
-- Constraints for table `provider_services`
--
ALTER TABLE `provider_services`
  ADD CONSTRAINT `provider_services_ibfk_1` FOREIGN KEY (`provider_id`) REFERENCES `provider_registration` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2023 at 03:22 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api`
--

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `proposal_id` int(11) DEFAULT NULL,
  `provider_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `Feedback` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `proposal_id`, `provider_id`, `user_id`, `rating`, `created_at`, `updated_at`, `Feedback`) VALUES
(1, 423, 65, 64, '4', '2023-11-14 18:17:02', '2023-11-14 18:17:02', 'xzcc'),
(12, 423, 65, 64, '3', '2023-11-14 18:34:10', '2023-11-14 18:34:10', 'helo this is retingg'),
(13, 423, 65, 64, '4', '2023-11-14 18:35:03', '2023-11-14 18:35:03', 'hello world'),
(14, 423, 65, 64, '2', '2023-11-14 19:01:20', '2023-11-14 19:01:20', 'sasa'),
(15, 423, 65, 64, '2', '2023-11-14 19:08:02', '2023-11-14 19:08:02', 'sasa'),
(17, 422, 65, 64, '3', '2023-11-14 19:12:09', '2023-11-14 19:12:09', 'dsdsds'),
(18, 422, 65, 64, '2', '2023-11-15 13:29:02', '2023-11-15 13:29:02', 'assaasas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `provider_id` (`provider_id`),
  ADD KEY `proposal_id` (`proposal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `provider_registration` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`provider_id`) REFERENCES `provider_registration` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_3` FOREIGN KEY (`provider_id`) REFERENCES `provider_registration` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_4` FOREIGN KEY (`proposal_id`) REFERENCES `customer_proposal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/* update 20-11-2023 */
alter table `provider_registration` add isAccountVerified boolean DEFAULT false;
alter table `provider_registration` add stripe_customerId varchar(100)	 DEFAULT 'Stripe Customer ID For User is Null at this Time	';
alter table `provider_registration` add stripe_accountId varchar(100)	 DEFAULT 'Stripe Account For User is Null at this Time	';

create table provider_bank(
    id int primary key AUTO_INCREMENT,
    provider_id int  not null,
    country_registered varchar(100) not null,
    bank_name varchar(250) not null,
    account_no varchar(250) not null,
    routing_no varchar(250) not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN key (provider_id) REFERENCES `provider_registration`(`id`)
)