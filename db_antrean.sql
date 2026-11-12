-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2026 at 05:27 PM
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
-- Database: `db_antrean`
--

-- --------------------------------------------------------

--
-- Table structure for table `hari_tutup`
--

CREATE TABLE `hari_tutup` (
  `id` bigint(20) NOT NULL,
  `lokasi_id` bigint(20) NOT NULL,
  `tanggal` date NOT NULL,
  `alasan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` bigint(20) NOT NULL,
  `layanan_lokasi_id` bigint(20) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kuota` int(11) NOT NULL,
  `jumlah_terpesan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_rutin`
--

CREATE TABLE `jadwal_rutin` (
  `id` bigint(20) NOT NULL,
  `layanan_lokasi_id` bigint(20) NOT NULL,
  `hari` int(11) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `interval_menit` int(11) NOT NULL,
  `kuota_per_slot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` bigint(20) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `catatan_persiapan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `layanan_lokasi`
--

CREATE TABLE `layanan_lokasi` (
  `id` bigint(20) NOT NULL,
  `lokasi_id` bigint(20) NOT NULL,
  `layanan_id` bigint(20) NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `durasi_menit` int(11) NOT NULL,
  `aktif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `lintang` decimal(10,8) NOT NULL,
  `bujur` decimal(11,8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` bigint(20) NOT NULL,
  `pengguna_id` bigint(20) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint(20) NOT NULL,
  `reservasi_id` bigint(20) NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `metode` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `dibayar_pada` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `kata_sandi_hash` varchar(255) NOT NULL,
  `peran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `id` bigint(20) NOT NULL,
  `kode_booking` varchar(50) NOT NULL,
  `pasien_id` bigint(20) NOT NULL,
  `jadwal_id` bigint(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `catatan` text NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hari_tutup`
--
ALTER TABLE `hari_tutup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lokasi_id` (`lokasi_id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `layanan_lokasi_id` (`layanan_lokasi_id`);

--
-- Indexes for table `jadwal_rutin`
--
ALTER TABLE `jadwal_rutin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `layanan_lokasi_id` (`layanan_lokasi_id`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layanan_lokasi`
--
ALTER TABLE `layanan_lokasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lokasi_id` (`lokasi_id`),
  ADD KEY `layanan_id` (`layanan_id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengguna_id` (`pengguna_id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservasi_id` (`reservasi_id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasien_id` (`pasien_id`),
  ADD KEY `jadwal_id` (`jadwal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hari_tutup`
--
ALTER TABLE `hari_tutup`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_rutin`
--
ALTER TABLE `jadwal_rutin`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `layanan_lokasi`
--
ALTER TABLE `layanan_lokasi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hari_tutup`
--
ALTER TABLE `hari_tutup`
  ADD CONSTRAINT `hari_tutup_ibfk_1` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`layanan_lokasi_id`) REFERENCES `layanan_lokasi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jadwal_rutin`
--
ALTER TABLE `jadwal_rutin`
  ADD CONSTRAINT `jadwal_rutin_ibfk_1` FOREIGN KEY (`layanan_lokasi_id`) REFERENCES `layanan_lokasi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `layanan_lokasi`
--
ALTER TABLE `layanan_lokasi`
  ADD CONSTRAINT `layanan_lokasi_ibfk_1` FOREIGN KEY (`layanan_id`) REFERENCES `layanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `layanan_lokasi_ibfk_2` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pasien`
--
ALTER TABLE `pasien`
  ADD CONSTRAINT `pasien_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`reservasi_id`) REFERENCES `reservasi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`),
  ADD CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
