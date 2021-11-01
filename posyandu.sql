-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2021 at 09:16 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posyandu`
--

-- --------------------------------------------------------

--
-- Table structure for table `list_anak`
--

CREATE TABLE `list_anak` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tanggal_lahir` datetime NOT NULL,
  `orang_tua` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `gender` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `umur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `list_anak`
--

INSERT INTO `list_anak` (`id`, `nama`, `tanggal_lahir`, `orang_tua`, `created_at`, `gender`, `alamat`, `umur`) VALUES
(28690, 'Rimadinda', '2000-02-15 00:00:00', 'Ridwan', '2021-01-15 18:28:18', 'Perempuan', 'Depok 2', 20),
(59275, 'Bagas Satria Nurwinanto', '1998-08-30 00:00:00', 'Wiwit Hariyanto', '2021-09-01 21:48:32', 'Laki-laki', 'Cimanggis', 23);

-- --------------------------------------------------------

--
-- Table structure for table `perkembangan_anak`
--

CREATE TABLE `perkembangan_anak` (
  `id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `umur` int(11) NOT NULL,
  `tinggi_badan` int(11) NOT NULL,
  `berat_badan` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perkembangan_anak`
--

INSERT INTO `perkembangan_anak` (`id`, `child_id`, `nama`, `umur`, `tinggi_badan`, `berat_badan`, `created_at`) VALUES
(19, 28690, 'Rima', 20, 178, 55, '2021-01-15 18:29:57'),
(20, 28690, 'Rima', 20, 250, 75, '2021-01-15 18:32:25'),
(21, 28690, 'Rima', 21, 999, 999, '2021-09-01 20:40:33'),
(22, 59275, 'Bagas Satria Nurwinanto', 23, 177, 85, '2021-09-01 21:56:13');

-- --------------------------------------------------------

--
-- Table structure for table `vaksin`
--

CREATE TABLE `vaksin` (
  `id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nama_vaksin` varchar(255) NOT NULL,
  `is_injected` tinyint(1) NOT NULL,
  `injected_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaksin`
--

INSERT INTO `vaksin` (`id`, `child_id`, `nama`, `nama_vaksin`, `is_injected`, `injected_at`, `created_at`) VALUES
(14, 28690, 'Rima', 'Tuberkulosis', 1, '2021-01-23 00:00:00', '2021-01-15 18:32:59'),
(21, 28690, 'Rima', 'Tuberkulosis', 0, '2021-09-09 00:00:00', '2021-09-01 20:39:37'),
(22, 28690, 'Rima', 'Tuberkulosis', 0, '2021-09-08 00:00:00', '2021-09-01 20:39:55'),
(23, 28690, 'Rima', 'Difteri Pertusis Tetanus', 0, '2021-09-16 00:00:00', '2021-09-01 20:40:04'),
(24, 28690, 'Rima', 'Tetanus', 0, '2021-09-14 00:00:00', '2021-09-01 20:40:46'),
(25, 28690, 'Rima', 'Hepatitis B', 1, '2021-09-06 00:00:00', '2021-09-01 20:44:52'),
(26, 59275, 'Bagas Satria Nurwinanto', 'Tuberkulosis', 1, '2021-09-03 00:00:00', '2021-09-01 21:57:21'),
(27, 59275, 'Bagas Satria Nurwinanto', 'Polio', 1, '2021-09-08 00:00:00', '2021-09-01 21:58:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `list_anak`
--
ALTER TABLE `list_anak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perkembangan_anak`
--
ALTER TABLE `perkembangan_anak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vaksin`
--
ALTER TABLE `vaksin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `perkembangan_anak`
--
ALTER TABLE `perkembangan_anak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `vaksin`
--
ALTER TABLE `vaksin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
