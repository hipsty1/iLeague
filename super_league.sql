-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2025 at 02:22 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `tim`
--

CREATE TABLE `tim` (
  `id_tim` int(9) NOT NULL,
  `nama_tim` varchar(30) DEFAULT NULL,
  `kotaAsal` varchar(30) DEFAULT NULL,
  `pelatih` varchar(30) DEFAULT NULL,
  `stadion` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tim`
--

INSERT INTO `tim` (`id_tim`, `nama_tim`, `kotaAsal`, `pelatih`, `stadion`) VALUES
(1, 'AREMA FC', 'MALANG', 'MARCOS VINICIUS SANTOS GONCALV', 'KANJURUHAN'),
(2, 'BALI UNITED FC', 'BALI', 'JAN JANSEN', 'KAPTEN I WAYAN DIPTA'),
(3, 'BHAYANGKARA PRESISI LAMPUNG FC', 'BANDAR LAMPUNG', 'PAUL CHRISTOPHER MUNSTER', 'PKOR SUMPAH PEMUDA'),
(4, 'BORNEO FC ', 'SAMARINDA', 'FABIO ARAUJO LEFUNDES', 'SEGIRI'),
(5, 'DEWA UNITED FC', 'TANGERANG', 'JOHANNES HENDRIKUS OLDE RIEKER', 'BANTEN INTERNATIONAL STADIUM'),
(6, 'MADURA UNITED FC', 'MADURA', 'ANGEL ALFREDO VERA', 'GELORA MADURA RATU PAMELINGAN'),
(7, 'MALUT UNITED FC', 'TERNATE', 'HENDRI SUSILO', 'KIE RAHA'),
(8, 'PERSEBAYA SURABAYA', 'SURABAYA', 'EDUARDO PEREZ MORAN', 'GELORA BUNG TOMO'),
(9, 'PERSIB BANDUNG', 'BANDUNG', 'BOJAN HODAK', 'GELORA BANDUNG LAUTAN API'),
(10, 'PERSIJA JAKARTA', 'JAKARTA', 'MAURICIO FERREIRA DE SOUZA', 'JAKARTA INTERNATIONAL STADIUM'),
(11, 'PERSIJAP JEPARA', 'JEPARA', 'MARIO LICINIO GUERREIRO LEMOS', 'GELORA BUMI KARTINI'),
(12, 'PERSIK KEDIRI', 'KEDIRI', 'ONG KIM SWEE', 'BRAWIJAYA'),
(13, 'PERSIS SOLO', 'SOLO', 'PETER DE ROO', 'MANAHAN'),
(14, 'PERSITA', 'TANGERANG', 'CARLOS GONZALES PENA', 'INDOMILK ARENA'),
(15, 'PSBS BIAK', 'BIAK', 'DIVALDO DA SILVA TEIXEIRA ALVE', 'STADION CENDRAWASIH'),
(16, 'PSIM YOGYAKARTA', 'YOGYAKARTA', 'JACOBUS JOHANNES MARTINUS PAUL', 'SULTAN AGUNG'),
(17, 'PSM MAKASSAR', 'MAKASSAR', 'BERNARDO TAVARES', 'GELORA B. J. HABIBIE'),
(18, 'SEMEN PADANG FC', 'PADANG', 'DEJAN ANTONIC', 'H. AGUS SALIM');

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
