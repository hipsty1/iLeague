-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2025 at 04:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `super_league`
--

-- --------------------------------------------------------

--
-- Table structure for table `klasemen`
--

CREATE TABLE `klasemen` (
  `id_klasemen` int(9) NOT NULL,
  `id_tim` int(9) NOT NULL,
  `main` int(10) NOT NULL,
  `menang` int(10) NOT NULL,
  `seri` int(10) NOT NULL,
  `kalah` int(10) NOT NULL,
  `gol_masuk` int(10) NOT NULL,
  `gol_kemasukan` int(10) NOT NULL,
  `selisih_gol` int(10) NOT NULL,
  `poin` int(10) NOT NULL,
  `peringkat` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klasemen`
--

INSERT INTO `klasemen` (`id_klasemen`, `id_tim`, `main`, `menang`, `seri`, `kalah`, `gol_masuk`, `gol_kemasukan`, `selisih_gol`, `poin`, `peringkat`) VALUES
(1, 10, 33, 29, 2, 2, 82, 32, 50, 89, 1),
(2, 16, 34, 17, 8, 9, 55, 46, 9, 59, 2),
(3, 4, 32, 18, 4, 10, 60, 45, 15, 58, 3),
(4, 1, 34, 16, 9, 9, 58, 48, 10, 57, 4),
(5, 8, 32, 16, 7, 9, 46, 33, 13, 55, 5),
(6, 5, 33, 15, 6, 12, 54, 50, 4, 51, 6),
(7, 14, 32, 13, 9, 10, 57, 50, 7, 48, 7),
(8, 7, 31, 12, 9, 10, 47, 44, 3, 45, 8),
(9, 2, 32, 12, 9, 11, 54, 57, -3, 45, 9),
(10, 3, 32, 12, 7, 13, 41, 39, 2, 43, 10),
(11, 9, 32, 12, 6, 14, 43, 46, -3, 42, 11),
(12, 12, 32, 10, 8, 14, 47, 54, -7, 38, 12),
(13, 6, 33, 8, 10, 15, 39, 51, -12, 34, 13),
(14, 15, 32, 8, 9, 15, 38, 53, -15, 33, 14),
(15, 11, 33, 7, 9, 17, 31, 50, -19, 30, 15),
(16, 17, 31, 5, 14, 12, 34, 48, -14, 29, 16),
(17, 18, 33, 7, 6, 20, 40, 58, -18, 27, 17),
(18, 13, 33, 4, 10, 19, 39, 61, -22, 22, 18);

-- --------------------------------------------------------

--
-- Table structure for table `pertandingan`
--

CREATE TABLE `pertandingan` (
  `id_pertandingan` int(9) NOT NULL,
  `tanggal_pertandingan` date NOT NULL,
  `tim_home` int(9) NOT NULL,
  `tim_away` int(9) NOT NULL,
  `skor_tim_home` int(2) NOT NULL,
  `skor_tim_away` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pertandingan`
--

INSERT INTO `pertandingan` (`id_pertandingan`, `tanggal_pertandingan`, `tim_home`, `tim_away`, `skor_tim_home`, `skor_tim_away`) VALUES
(101, '2025-08-08', 4, 3, 1, 0),
(102, '2025-08-08', 8, 16, 0, 1),
(103, '2025-08-08', 17, 11, 1, 1),
(104, '2025-08-09', 9, 18, 2, 0),
(105, '2025-08-09', 5, 7, 1, 3),
(106, '2025-08-09', 6, 13, 1, 2),
(107, '2025-08-10', 2, 12, 1, 1),
(108, '2025-08-10', 10, 14, 4, 0),
(109, '2025-08-11', 1, 15, 4, 1),
(110, '2025-08-15', 18, 5, 2, 0),
(111, '2025-08-15', 7, 2, 3, 3),
(112, '2025-08-16', 12, 6, 1, 2),
(113, '2025-08-16', 14, 8, 0, 1),
(114, '2025-08-16', 16, 1, 1, 1),
(115, '2025-08-16', 3, 17, 1, 1),
(116, '2025-08-16', 13, 10, 0, 3),
(117, '2025-08-18', 15, 4, 0, 1),
(118, '2025-08-18', 11, 9, 2, 1),
(119, '2025-08-22', 18, 17, 1, 1),
(120, '2025-08-22', 1, 3, 2, 1),
(121, '2025-08-22', 5, 12, 3, 1),
(122, '2025-08-23', 10, 7, 1, 1),
(123, '2025-08-23', 15, 13, 2, 2),
(124, '2025-08-23', 8, 2, 5, 2),
(125, '2025-08-24', 16, 9, 1, 1),
(126, '2025-08-24', 4, 11, 3, 1),
(127, '2025-08-24', 6, 14, 1, 1),
(128, '2025-08-29', 3, 13, 2, 0),
(129, '2025-08-29', 15, 12, 1, 2),
(130, '2025-08-29', 5, 10, 1, 3),
(131, '2025-08-30', 11, 1, 0, 0),
(132, '2025-08-30', 2, 6, 1, 0),
(133, '2025-08-30', 7, 16, 0, 2),
(134, '2025-09-11', 18, 15, 1, 2),
(135, '2025-09-11', 14, 17, 2, 1),
(136, '2025-09-12', 9, 8, 1, 0),
(137, '2025-09-12', 6, 3, 0, 0),
(138, '2025-09-13', 1, 5, 1, 2),
(139, '2025-09-13', 13, 11, 1, 2),
(140, '2025-09-14', 16, 4, 1, 3),
(141, '2025-09-14', 10, 2, 1, 1),
(142, '2025-09-19', 3, 12, 1, 0),
(143, '2025-09-19', 7, 6, 4, 1),
(145, '2025-09-19', 8, 18, 1, 0),
(146, '2025-09-20', 5, 15, 3, 1),
(147, '2025-09-20', 2, 16, 1, 3),
(148, '2025-09-21', 11, 14, 1, 2),
(149, '2025-09-21', 17, 10, 2, 0),
(150, '2025-09-22', 1, 9, 1, 2),
(151, '2025-09-22', 4, 13, 1, 0),
(152, '2025-09-25', 3, 7, 0, 1),
(153, '2025-09-25', 15, 6, 0, 0),
(154, '2025-09-26', 18, 2, 1, 3),
(155, '2025-09-26', 5, 8, 1, 1),
(156, '2025-09-27', 17, 16, 0, 0),
(157, '2025-09-27', 11, 12, 0, 2),
(158, '2025-09-27', 14, 9, 2, 1),
(159, '2025-09-28', 13, 1, 2, 2),
(160, '2025-09-28', 4, 10, 3, 1),
(161, '2025-10-04', 14, 18, 2, 0),
(162, '2025-10-16', 5, 6, 0, 2),
(163, '2025-10-17', 14, 16, 4, 0),
(164, '2025-10-17', 15, 9, 0, 3),
(165, '2025-10-18', 4, 12, 2, 0),
(166, '2025-10-18', 8, 10, 1, 3),
(167, '2025-10-19', 17, 1, 1, 2),
(168, '2025-10-19', 11, 2, 1, 2),
(169, '2025-10-20', 18, 3, 0, 1),
(170, '2025-10-20', 13, 7, 1, 3),
(171, '2025-10-22', 16, 5, 2, 0),
(172, '2025-10-24', 15, 8, 0, 0),
(173, '2025-10-24', 6, 10, 0, 1),
(174, '2025-10-25', 12, 17, 1, 1),
(175, '2025-10-25', 2, 14, 0, 0),
(176, '2025-10-26', 1, 4, 1, 3),
(177, '2025-10-26', 7, 18, 1, 0),
(178, '2025-10-27', 3, 11, 2, 0),
(179, '2025-10-27', 9, 13, 2, 0),
(180, '2025-10-31', 16, 12, 2, 1),
(181, '2025-10-31', 10, 15, 3, 1),
(182, '2025-11-01', 2, 9, 0, 1),
(183, '2025-11-02', 17, 6, 1, 1),
(184, '2025-11-02', 8, 13, 2, 1),
(185, '2025-11-03', 11, 7, 1, 2),
(186, '2025-11-03', 18, 1, 1, 2),
(187, '2025-11-05', 4, 5, 4, 0),
(188, '2025-11-06', 15, 14, 2, 1),
(189, '2025-11-07', 3, 2, 2, 1),
(190, '2025-11-07', 12, 8, 1, 1),
(191, '2025-11-08', 1, 10, 1, 2),
(192, '2025-11-08', 13, 16, 2, 2),
(193, '2025-11-09', 5, 17, 0, 1),
(194, '2025-11-09', 6, 11, 2, 1),
(195, '2025-11-09', 18, 4, 0, 2),
(196, '2025-11-20', 11, 18, 2, 1),
(197, '2025-12-14', 7, 9, 2, 1),
(198, '2025-11-20', 10, 12, 2, 0),
(199, '2025-11-21', 17, 15, 1, 2),
(200, '2025-11-21', 9, 5, 0, 1),
(201, '2025-11-22', 8, 1, 0, 1),
(202, '2025-11-22', 16, 3, 3, 1),
(203, '2025-11-22', 4, 6, 0, 1),
(204, '2025-11-23', 14, 7, 2, 2),
(205, '2025-11-23', 2, 13, 2, 1),
(206, '2025-11-27', 15, 11, 1, 1),
(207, '2025-11-27', 12, 18, 0, 2),
(208, '2025-11-28', 3, 8, 1, 3),
(209, '2025-11-28', 10, 16, 3, 0),
(210, '2025-11-29', 5, 14, 1, 3),
(211, '2025-11-29', 7, 1, 1, 2),
(212, '2025-11-29', 13, 17, 3, 0),
(213, '2025-11-30', 4, 2, 2, 0),
(214, '2025-11-30', 6, 9, 1, 1),
(215, '2025-12-23', 11, 16, 0, 3),
(216, '2025-12-20', 5, 13, 2, 0),
(217, '2025-12-20', 8, 4, 2, 1),
(218, '2025-12-21', 14, 12, 1, 2),
(219, '2025-12-21', 9, 3, 1, 0),
(220, '2025-12-21', 15, 2, 1, 3),
(221, '2025-12-22', 18, 10, 0, 4),
(222, '2026-01-05', 12, 9, 2, 1),
(223, '2025-12-23', 1, 6, 2, 1),
(224, '2026-01-03', 10, 11, 2, 0),
(225, '2026-01-03', 4, 17, 1, 1),
(226, '2026-01-03', 6, 8, 1, 2),
(227, '2026-01-04', 13, 14, 1, 3),
(228, '2026-01-04', 16, 18, 1, 1),
(229, '2026-01-04', 2, 1, 1, 2),
(230, '2026-01-04', 7, 15, 2, 1),
(231, '2026-01-05', 3, 5, 1, 2),
(232, '2026-01-09', 14, 4, 1, 0),
(233, '2026-01-09', 17, 2, 1, 3),
(234, '2026-01-10', 8, 7, 2, 1),
(235, '2026-01-10', 6, 16, 1, 2),
(236, '2026-01-11', 9, 10, 1, 2),
(237, '2026-01-11', 1, 12, 1, 2),
(238, '2026-01-11', 18, 13, 2, 1),
(239, '2026-01-12', 15, 3, 1, 3),
(240, '2026-01-12', 11, 5, 1, 2),
(241, '2025-11-01', 3, 14, 1, 1),
(242, '2026-01-23', 13, 4, 2, 1),
(243, '2026-01-23', 10, 6, 1, 0),
(244, '2026-01-24', 2, 18, 2, 1),
(245, '2026-01-24', 11, 17, 1, 2),
(246, '2026-01-24', 7, 12, 1, 1),
(247, '2026-01-25', 16, 8, 1, 0),
(248, '2026-01-25', 9, 15, 2, 1),
(249, '2026-01-26', 5, 1, 3, 0),
(250, '2026-01-30', 12, 2, 1, 2),
(251, '2026-01-30', 14, 10, 1, 2),
(252, '2026-01-31', 13, 9, 1, 1),
(253, '2026-01-31', 7, 3, 0, 0),
(254, '2026-01-31', 6, 15, 1, 2),
(255, '2026-02-01', 4, 16, 0, 2),
(256, '2026-01-01', 8, 5, 2, 0),
(257, '2026-02-02', 1, 11, 0, 0),
(258, '2026-02-02', 17, 18, 2, 2),
(259, '2026-02-06', 16, 13, 1, 0),
(260, '2026-02-06', 9, 7, 1, 0),
(261, '2026-02-07', 12, 5, 2, 2),
(262, '2026-02-07', 3, 4, 1, 2),
(263, '2026-02-07', 11, 6, 1, 0),
(264, '2026-02-07', 2, 8, 2, 1),
(265, '2026-02-08', 18, 14, 1, 3),
(266, '2026-02-08', 15, 17, 1, 0),
(267, '2026-02-08', 10, 1, 2, 0),
(268, '2026-02-13', 12, 16, 1, 2),
(269, '2026-02-13', 13, 6, 2, 2),
(270, '2026-02-13', 7, 11, 1, 2),
(271, '2026-02-14', 17, 5, 1, 1),
(272, '2026-02-14', 8, 3, 2, 0),
(273, '2026-02-15', 1, 18, 2, 0),
(274, '2026-02-15', 2, 10, 2, 4),
(275, '2026-02-16', 14, 15, 2, 4),
(276, '2026-02-16', 4, 9, 2, 1),
(277, '2026-02-20', 12, 3, 2, 1),
(278, '2026-02-20', 18, 7, 1, 2),
(279, '2026-02-20', 10, 17, 2, 0),
(280, '2026-02-21', 11, 8, 1, 2),
(281, '2026-02-21', 13, 15, 1, 2),
(282, '2026-02-21', 6, 1, 1, 3),
(283, '2026-02-22', 9, 14, 4, 4),
(284, '2026-02-22', 5, 4, 5, 3),
(285, '2026-02-23', 16, 2, 4, 3),
(286, '2026-02-24', 7, 10, 1, 3),
(287, '2026-02-24', 3, 18, 2, 1),
(288, '2026-02-25', 8, 17, 1, 1),
(289, '2026-02-26', 4, 1, 1, 3),
(290, '2026-02-26', 9, 6, 3, 1),
(291, '2026-02-26', 14, 5, 2, 1),
(292, '2026-02-27', 15, 16, 1, 3),
(293, '2026-02-28', 2, 11, 2, 1),
(294, '2026-03-01', 13, 12, 1, 2),
(295, '2026-03-02', 17, 14, 2, 1),
(296, '2026-03-02', 5, 3, 2, 1),
(297, '2026-03-02', 8, 9, 2, 1),
(298, '2026-03-03', 10, 4, 4, 3),
(299, '2026-03-03', 6, 7, 2, 1),
(300, '2026-03-04', 18, 16, 2, 1),
(301, '2026-03-05', 11, 13, 2, 1),
(302, '2026-03-05', 12, 15, 2, 1),
(303, '2026-03-06', 1, 2, 2, 1),
(304, '2026-03-07', 7, 17, 1, 0),
(305, '2026-03-07', 14, 6, 1, 2),
(306, '2026-03-07', 4, 8, 2, 1),
(307, '2026-03-08', 10, 5, 4, 2),
(308, '2026-03-09', 15, 18, 2, 2),
(309, '2026-03-09', 9, 12, 2, 4),
(310, '2026-03-10', 3, 1, 1, 3),
(311, '2026-03-11', 16, 11, 1, 2),
(312, '2026-03-12', 13, 2, 1, 1),
(314, '2026-04-03', 1, 7, 2, 0),
(315, '2026-04-03', 5, 16, 4, 2),
(316, '2026-04-04', 17, 13, 1, 1),
(317, '2026-04-04', 8, 14, 2, 2),
(318, '2026-04-05', 3, 10, 2, 3),
(319, '2026-04-05', 6, 4, 2, 1),
(320, '2026-04-05', 18, 9, 3, 0),
(321, '2026-04-06', 12, 11, 3, 0),
(322, '2026-04-06', 2, 15, 1, 1),
(323, '2026-04-10', 16, 17, 1, 0),
(324, '2026-04-10', 14, 1, 2, 2),
(325, '2026-04-11', 4, 15, 0, 0),
(326, '2026-04-11', 6, 12, 3, 3),
(327, '2026-04-11', 10, 8, 2, 1),
(328, '2026-04-11', 11, 3, 1, 1),
(329, '2026-04-12', 13, 18, 3, 3),
(330, '2026-04-12', 7, 5, 2, 2),
(331, '2026-04-12', 9, 2, 2, 2),
(332, '2026-04-17', 3, 16, 2, 1),
(333, '2026-04-17', 8, 6, 2, 1),
(334, '2026-04-18', 1, 13, 2, 2),
(335, '2026-04-18', 15, 10, 1, 2),
(336, '2026-04-18', 17, 4, 2, 2),
(337, '2026-04-19', 12, 14, 1, 2),
(338, '2026-04-19', 2, 7, 2, 1),
(339, '2026-04-20', 18, 11, 2, 2),
(340, '2026-04-20', 5, 9, 2, 1),
(341, '2026-04-22', 13, 3, 1, 2),
(342, '2026-04-22', 16, 10, 1, 3),
(343, '2026-04-23', 7, 8, 1, 0),
(344, '2026-04-23', 17, 12, 1, 1),
(345, '2026-04-23', 14, 2, 2, 1),
(346, '2026-04-24', 11, 16, 1, 1),
(347, '2026-04-24', 9, 1, 2, 1),
(348, '2026-04-25', 4, 18, 2, 1),
(349, '2026-04-25', 6, 5, 0, 0),
(350, '2026-04-27', 2, 17, 3, 3),
(351, '2026-04-27', 10, 13, 2, 1),
(352, '2026-04-28', 1, 8, 1, 1),
(353, '2026-04-28', 15, 7, 1, 1),
(354, '2026-04-29', 18, 6, 1, 2),
(355, '2026-04-29', 12, 4, 2, 3),
(356, '2026-04-29', 5, 11, 1, 1),
(357, '2026-04-30', 16, 14, 1, 1),
(358, '2026-04-30', 3, 9, 1, 0),
(359, '2026-05-02', 8, 15, 1, 1),
(360, '2026-05-02', 7, 13, 2, 2),
(361, '2026-05-03', 12, 1, 2, 2),
(362, '2026-05-03', 5, 18, 1, 2),
(363, '2026-05-04', 9, 16, 1, 3),
(364, '2026-05-04', 17, 3, 1, 6),
(365, '2026-05-04', 11, 10, 1, 2),
(366, '2026-05-05', 4, 14, 3, 3),
(367, '2026-05-05', 6, 1, 3, 3),
(368, '2026-05-08', 18, 12, 3, 1),
(369, '2026-05-08', 15, 5, 0, 2),
(370, '2026-05-09', 1, 17, 2, 0),
(371, '2026-05-09', 13, 8, 0, 1),
(372, '2026-05-10', 14, 11, 2, 0),
(373, '2026-05-10', 10, 9, 4, 0),
(374, '2026-05-10', 16, 7, 2, 2),
(375, '2026-05-11', 3, 6, 2, 2),
(376, '2026-05-11', 2, 4, 4, 3),
(377, '2026-05-15', 18, 8, 0, 2),
(378, '2026-05-15', 15, 1, 4, 2),
(379, '2026-05-16', 12, 10, 1, 3),
(380, '2026-05-16', 13, 5, 0, 3),
(381, '2026-05-16', 7, 14, 3, 2),
(382, '2026-05-17', 2, 3, 1, 1),
(383, '2026-05-17', 17, 9, 1, 3),
(384, '2026-05-17', 11, 4, 1, 2),
(385, '2026-05-17', 16, 6, 2, 1),
(386, '2026-05-23', 3, 15, 1, 0),
(387, '2026-05-23', 14, 13, 2, 3),
(388, '2026-05-23', 8, 12, 4, 2),
(389, '2026-05-23', 5, 2, 4, 1),
(390, '2026-05-23', 10, 18, 4, 3),
(391, '2026-05-23', 6, 17, 1, 4),
(392, '2026-05-23', 9, 11, 0, 0),
(394, '2026-05-23', 1, 16, 3, 2),
(395, '2026-05-23', 4, 7, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tim`
--

CREATE TABLE `tim` (
  `id_tim` int(9) NOT NULL,
  `nama_tim` varchar(30) DEFAULT NULL,
  `kotaAsal` varchar(30) DEFAULT NULL,
  `pelatih` varchar(30) DEFAULT NULL,
  `stadion` varchar(30) DEFAULT NULL,
  `Logo Tim` text DEFAULT NULL,
  `foto_tim` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tim`
--

INSERT INTO `tim` (`id_tim`, `nama_tim`, `kotaAsal`, `pelatih`, `stadion`, `Logo Tim`, `foto_tim`) VALUES
(1, 'AREMA FC', 'MALANG', 'MARCOS VINICIUS SANTOS GONCALV', 'KANJURUHAN', 'https://upload.wikimedia.org/wikipedia/id/thumb/4/40/Logo_Arema_FC_2017_logo.svg/270px-Logo_Arema_FC_2017_logo.svg.png', 'https://assets.ligaindonesiabaru.com/uploads/images/club/lineup_AREMA_FC_1758695072.JPG'),
(2, 'BALI UNITED FC', 'BALI', 'JAN JANSEN', 'KAPTEN I WAYAN DIPTA', 'https://upload.wikimedia.org/wikipedia/id/thumb/5/5e/Bali_United_logo.svg/270px-Bali_United_logo.svg.png', 'https://baliutd.oss-ap-southeast-5.aliyuncs.com//files/uploads/news/image/2025/Sep/25/68d517d52076b/whatsapp-image-2025-09-25-at-16-45-55-1.jpeg'),
(3, 'BHAYANGKARA PRESISI LAMPUNG FC', 'BANDAR LAMPUNG', 'PAUL CHRISTOPHER MUNSTER', 'PKOR SUMPAH PEMUDA', 'https://upload.wikimedia.org/wikipedia/id/thumb/f/f3/Logo_Bhayangkara_FC.png/500px-Logo_Bhayangkara_FC.png', 'https://assets.ligaindonesiabaru.com/uploads/images/news/Bhayangkara-Presisi-Aktif-Pada-Bursa-Transfer-Putaran-Kedua-1699686948.JPG'),
(4, 'BORNEO FC ', 'SAMARINDA', 'FABIO ARAUJO LEFUNDES', 'SEGIRI', 'https://upload.wikimedia.org/wikipedia/id/thumb/4/4d/Logo_Borneo_FC.svg/300px-Logo_Borneo_FC.svg.png', 'https://cdn.grid.id/crop/0x0:0x0/700x465/photo/2025/01/16/borneo-fcjpg-20250116075929.jpg'),
(5, 'DEWA UNITED FC', 'TANGERANG', 'JOHANNES HENDRIKUS OLDE RIEKER', 'BANTEN INTERNATIONAL STADIUM', 'https://upload.wikimedia.org/wikipedia/id/thumb/5/53/Dewa_United_FC.png/500px-Dewa_United_FC.png', 'https://assets.ligaindonesiabaru.com/uploads/images/club/lineup_DEWA_UNITED_FC_1731051214.jpg'),
(6, 'MADURA UNITED FC', 'MADURA', 'ANGEL ALFREDO VERA', 'GELORA MADURA RATU PAMELINGAN', 'https://upload.wikimedia.org/wikipedia/id/8/8a/Madura_United_FC.png', 'https://cdn0-production-images-kly.akamaized.net/6V9qX5L1PP44sW6tEkuqgWQVq0c=/0x0:0x0/1200x675/filters:quality(75):strip_icc():format(jpeg):watermark(kly-media-production/assets/images/watermarks/bola/watermark-color-landscape-new.png,1125,20,0)/kly-media-production/medias/4543802/original/031684000_1692437271-20230819AA_BRI_Liga_1_Persikabo_Vs_Madura_United-51.jpg'),
(7, 'MALUT UNITED FC', 'TERNATE', 'HENDRI SUSILO', 'KIE RAHA', 'https://upload.wikimedia.org/wikipedia/id/thumb/6/62/Malut_fc.png/250px-Malut_fc.png', 'https://cdn.grid.id/crop/0x0:0x0/700x465/photo/2024/08/25/000_apw2001011564643jpg-20240825091941.jpg'),
(8, 'PERSEBAYA SURABAYA', 'SURABAYA', 'EDUARDO PEREZ MORAN', 'GELORA BUNG TOMO', 'https://upload.wikimedia.org/wikipedia/id/thumb/a/a1/Persebaya_logo.svg/300px-Persebaya_logo.svg.png', 'https://www.persebaya.id/thumbs/extra-large/uploads/post/2018/11/16/IMG-20181116-WA00101.jpg'),
(9, 'PERSIB BANDUNG', 'BANDUNG', 'BOJAN HODAK', 'GELORA BANDUNG LAUTAN API', 'https://upload.wikimedia.org/wikipedia/id/thumb/0/0d/Logo_Persib_Bandung.png/500px-Logo_Persib_Bandung.png', 'https://assets.ligaindonesiabaru.com/uploads/images/club/lineup_PERSIB_BANDUNG_1754842168.jpg'),
(10, 'PERSIJA JAKARTA', 'JAKARTA', 'MAURICIO FERREIRA DE SOUZA', 'JAKARTA INTERNATIONAL STADIUM', 'https://upload.wikimedia.org/wikipedia/id/9/94/Persija_Jakarta_logo.png', 'https://assets.ligaindonesiabaru.com/uploads/images/club/lineup_PERSIJA_JAKARTA_1758695753.JPG'),
(11, 'PERSIJAP JEPARA', 'JEPARA', 'MARIO LICINIO GUERREIRO LEMOS', 'GELORA BUMI KARTINI', 'https://upload.wikimedia.org/wikipedia/id/b/bc/Persijap.png', 'https://static.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/p2/224/2025/10/03/skuad-persijap-jepara-alexis-gomez-instagram-1414191465.jpg'),
(12, 'PERSIK KEDIRI', 'KEDIRI', 'ONG KIM SWEE', 'BRAWIJAYA', 'https://upload.wikimedia.org/wikipedia/id/thumb/c/cd/Logo_Persik_Kediri.png/500px-Logo_Persik_Kediri.png', 'https://assets.ligaindonesiabaru.com/uploads/images/news/Sempat-Terpuruk-di-Liga-3--Persik-Kediri-Selangkah-Lagi-ke-Liga-1-1574327802.jpg'),
(13, 'PERSIS SOLO', 'SOLO', 'PETER DE ROO', 'MANAHAN', 'https://upload.wikimedia.org/wikipedia/id/thumb/d/d6/Persis_Solo_logo.svg/300px-Persis_Solo_logo.svg.png', 'https://assets.ligaindonesiabaru.com/uploads/images/news/Stadion-Manahan-Lebih-Angker-Buat-Persis-Solo-1744281964.JPG'),
(14, 'PERSITA', 'TANGERANG', 'CARLOS GONZALES PENA', 'INDOMILK ARENA', 'https://upload.wikimedia.org/wikipedia/id/thumb/9/95/Persita_logo_%282020%29.svg/250px-Persita_logo_%282020%29.svg.png', 'https://wartatangerang.com/content/uploads/2025/01/pasukan-persita-tangerang.jpg'),
(15, 'PSBS BIAK', 'BIAK', 'DIVALDO DA SILVA TEIXEIRA ALVE', 'STADION CENDRAWASIH', 'https://upload.wikimedia.org/wikipedia/id/thumb/9/9b/Logo_PSBS_Biak_baru.png/300px-Logo_PSBS_Biak_baru.png', 'https://cdn.grid.id/crop/0x0:0x0/700x465/photo/2025/02/04/whatsapp-image-2025-02-02-at-20-20250204090709.jpeg'),
(16, 'PSIM YOGYAKARTA', 'YOGYAKARTA', 'JACOBUS JOHANNES MARTINUS PAUL', 'SULTAN AGUNG', 'https://upload.wikimedia.org/wikipedia/id/9/9c/Logo_PSIM_Yogyakarta.png', 'https://assets.ligaindonesiabaru.com/uploads/images/news/Tanpa-Kiper-Andalan--PSIM-Boyong-24-Pemain-ke-Ternate-1756373484.jpg'),
(17, 'PSM MAKASSAR', 'MAKASSAR', 'BERNARDO TAVARES', 'GELORA B. J. HABIBIE', 'https://upload.wikimedia.org/wikipedia/id/thumb/b/b8/Logo_PSM_Makasar_Baru.png/250px-Logo_PSM_Makasar_Baru.png', 'https://assets.goal.com/images/v3/bltcce3ff30b4307790/2a072506001f97565bc740c1b0c196211103bb7e.jpg?auto=webp&format=pjpg&width=3840&quality=60'),
(18, 'SEMEN PADANG FC', 'PADANG', 'DEJAN ANTONIC', 'H. AGUS SALIM', 'https://upload.wikimedia.org/wikipedia/id/thumb/1/1e/Semen_Padang_FC.png/330px-Semen_Padang_FC.png', 'https://cdn.antaranews.com/cache/1200x800/2025/07/08/IMG_0511.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(9) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `klasemen`
--
ALTER TABLE `klasemen`
  ADD PRIMARY KEY (`id_klasemen`),
  ADD KEY `fk_tim` (`id_tim`);

--
-- Indexes for table `pertandingan`
--
ALTER TABLE `pertandingan`
  ADD PRIMARY KEY (`id_pertandingan`),
  ADD KEY `fk_home` (`tim_home`),
  ADD KEY `fk_away` (`tim_away`);

--
-- Indexes for table `tim`
--
ALTER TABLE `tim`
  ADD PRIMARY KEY (`id_tim`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `klasemen`
--
ALTER TABLE `klasemen`
  MODIFY `id_klasemen` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `klasemen`
--
ALTER TABLE `klasemen`
  ADD CONSTRAINT `fk_tim` FOREIGN KEY (`id_tim`) REFERENCES `tim` (`id_tim`);

--
-- Constraints for table `pertandingan`
--
ALTER TABLE `pertandingan`
  ADD CONSTRAINT `fk_away` FOREIGN KEY (`tim_away`) REFERENCES `tim` (`id_tim`),
  ADD CONSTRAINT `fk_home` FOREIGN KEY (`tim_home`) REFERENCES `tim` (`id_tim`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
