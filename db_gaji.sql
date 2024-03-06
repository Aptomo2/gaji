-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2024 at 04:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_gaji`
--

-- --------------------------------------------------------

--
-- Table structure for table `db_karyawan`
--

CREATE TABLE `db_karyawan` (
  `nip` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jabatan` varchar(15) NOT NULL,
  `gaji_pokok` int(11) NOT NULL,
  `tgl_gaji` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_karyawan`
--

INSERT INTO `db_karyawan` (`nip`, `nama`, `jabatan`, `gaji_pokok`, `tgl_gaji`) VALUES
('11500391', 'Andang Pratomo', 'Manager', 15000000, '2023-06-30'),
('11500392', 'Natasha Romanof', 'Manager', 10000000, '2023-05-30'),
('11500393', 'John Mayer', 'Supervisor', 7000000, '2023-04-22'),
('11500394', 'Steve Roger', 'Manager', 6000000, '2023-05-29'),
('11500397', 'Yami Sukehiro', 'Staff', 10000000, '2023-04-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `db_karyawan`
--
ALTER TABLE `db_karyawan`
  ADD PRIMARY KEY (`nip`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
