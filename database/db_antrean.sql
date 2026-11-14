-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Nov 2026 pada 17.23
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

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
-- Struktur dari tabel `jadwal_rutin`
--

CREATE TABLE `jadwal_rutin` (
  `id` bigint(20) NOT NULL,
  `layanan_lokasi_id` bigint(20) NOT NULL,
  `hari` int(11) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal_rutin`
--

INSERT INTO `jadwal_rutin` (`id`, `layanan_lokasi_id`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(1, 20, 1, '08:00:00', '17:00:00'),
(2, 20, 2, '08:00:00', '17:00:00'),
(3, 20, 3, '08:00:00', '17:00:00'),
(4, 20, 4, '08:00:00', '17:00:00'),
(5, 20, 5, '08:30:00', '15:00:00'),
(6, 20, 6, '08:30:00', '15:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `layanan`
--

CREATE TABLE `layanan` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `layanan`
--

INSERT INTO `layanan` (`id`, `nama`) VALUES
(1, 'Pemeriksaan Umum'),
(2, 'Periksa Mata'),
(3, 'Periksa Telinga'),
(4, 'Periksa Hidung dan Tenggorokan'),
(5, 'Tes darah'),
(6, 'Rontgen tulang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `layanan_lokasi`
--

CREATE TABLE `layanan_lokasi` (
  `id` bigint(20) NOT NULL,
  `lokasi_id` bigint(20) NOT NULL,
  `layanan_id` bigint(20) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `durasi_menit` int(11) NOT NULL,
  `aktif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `layanan_lokasi`
--

INSERT INTO `layanan_lokasi` (`id`, `lokasi_id`, `layanan_id`, `harga`, `durasi_menit`, `aktif`) VALUES
(20, 1, 1, 20000, 60, 1),
(21, 1, 2, 40000, 90, 1),
(22, 1, 5, 40000, 45, 1),
(23, 2, 1, 25000, 30, 1),
(24, 2, 3, 30000, 60, 1),
(25, 2, 4, 50000, 90, 1),
(26, 2, 5, 30000, 60, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi`
--

CREATE TABLE `lokasi` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lokasi`
--

INSERT INTO `lokasi` (`id`, `nama`, `alamat`, `gambar`, `deskripsi`) VALUES
(1, 'Klinik Sehat Sentosa', 'Jl. Merdeka No. 12', 'gambar/lokasi/lokasi_1.png', 'Klinik Sehat Sentosa merupakan fasilitas kesehatan yang menyediakan berbagai layanan pemeriksaan dan pengobatan untuk masyarakat umum. Klinik ini melayani konsultasi dokter umum, pemeriksaan tekanan darah, pemeriksaan kondisi kesehatan rutin, serta penanganan berbagai keluhan penyakit ringan. Dengan lingkungan yang nyaman dan pelayanan yang ramah, Klinik Sehat Sentosa berupaya memberikan pengalaman berobat yang mudah, cepat, dan terjangkau bagi pasien dari berbagai kalangan.'),
(2, 'Klinik Medika Prima', 'Jl. Diponegoro No. 45', 'gambar/lokasi/lokasi_2.png', 'Klinik Medika Prima merupakan fasilitas pelayanan kesehatan yang berfokus pada kesehatan individu dan keluarga. Klinik ini menyediakan layanan konsultasi medis, pemeriksaan kesehatan berkala, pengobatan penyakit umum, serta pemberian resep sesuai hasil pemeriksaan dokter. Selain itu, klinik ini mengutamakan kenyamanan pasien melalui proses pendaftaran yang mudah dan pelayanan tenaga medis yang profesional. Klinik Medika Prima menjadi salah satu pilihan bagi masyarakat yang membutuhkan pelayanan kesehatan dasar secara praktis.'),
(3, 'RS Harapan Bangsa', 'Jl. Sudirman No. 88', 'gambar/lokasi/lokasi_3.png', 'RS Harapan Bangsa merupakan rumah sakit umum yang menyediakan pelayanan kesehatan dengan berbagai fasilitas penunjang medis. Layanan yang tersedia meliputi pemeriksaan rawat jalan, rawat inap, unit gawat darurat, pemeriksaan laboratorium, serta konsultasi dengan dokter dari berbagai bidang spesialisasi. Rumah sakit ini berupaya memberikan pelayanan kesehatan yang menyeluruh dengan mengutamakan keselamatan, kenyamanan, dan kebutuhan setiap pasien. Didukung oleh tenaga medis dan fasilitas kesehatan yang memadai, RS Harapan Bangsa melayani berbagai kebutuhan pemeriksaan dan perawatan kesehatan masyarakat.'),
(4, 'RS Bhakti Husada', 'Jl. Ahmad Yani No. 21', 'gambar/lokasi/lokasi_4.png', 'RS Bhakti Husada merupakan rumah sakit umum yang menyediakan pelayanan kesehatan bagi masyarakat dengan berbagai kebutuhan medis. Fasilitas yang tersedia mencakup konsultasi dokter umum dan spesialis, pemeriksaan laboratorium, layanan persalinan, rawat inap, serta penanganan kondisi darurat. Rumah sakit ini mengutamakan kualitas pelayanan melalui tenaga kesehatan yang kompeten dan fasilitas penunjang yang dirancang untuk mendukung proses diagnosis maupun perawatan pasien. RS Bhakti Husada juga berkomitmen memberikan pelayanan yang memperhatikan keselamatan dan kenyamanan pasien selama menjalani perawatan.'),
(5, 'RS Mitra Keluarga', 'Jl. Gatot Subroto No. 30', 'gambar/lokasi/lokasi_5.png', 'RS Mitra Keluarga merupakan fasilitas pelayanan kesehatan terpadu yang menyediakan berbagai layanan medis untuk memenuhi kebutuhan masyarakat. Rumah sakit ini menawarkan pemeriksaan kesehatan umum, konsultasi dokter spesialis, layanan rawat jalan dan rawat inap, pemeriksaan laboratorium, serta unit gawat darurat. Dengan dukungan tenaga medis dan fasilitas penunjang kesehatan, rumah sakit ini berupaya memberikan pelayanan yang menyeluruh mulai dari pemeriksaan awal hingga proses pemulihan pasien. Kenyamanan, keselamatan, dan kepuasan pasien menjadi bagian penting dalam penyelenggaraan pelayanan kesehatan.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint(20) NOT NULL,
  `reservasi_id` bigint(20) NOT NULL,
  `jumlah` bigint(20) NOT NULL,
  `metode` varchar(50) NOT NULL,
  `dibayar_pada` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profil` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `email`, `no_hp`, `password`, `foto_profil`) VALUES
(1, 'flynn', 'bijeanggoroseto@gmail.com', '081227591049', '123', ''),
(3, 'yuvin', 'mydenyoi@gmail.com', '08888666', '666', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservasi`
--

CREATE TABLE `reservasi` (
  `id` bigint(20) NOT NULL,
  `pengguna_id` bigint(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `layanan_lokasi_id` bigint(20) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `jadwal` date NOT NULL,
  `status_pembayaran` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reservasi`
--

INSERT INTO `reservasi` (`id`, `pengguna_id`, `nama`, `tanggal_lahir`, `jenis_kelamin`, `dibuat_pada`, `layanan_lokasi_id`, `jam_mulai`, `jam_selesai`, `jadwal`, `status_pembayaran`) VALUES
(16, 1, 'bije', '2026-11-04', 'laki-laki', '2026-11-14 14:43:42', 20, '08:00:00', '09:00:00', '2026-11-16', 1),
(19, 1, 'yuvin', '2026-11-04', 'laki-laki', '2026-11-14 14:43:42', 20, '10:00:00', '11:00:00', '2026-11-16', 1),
(21, 1, 'yuvin', '2026-11-04', 'laki-laki', '2026-11-14 14:43:42', 20, '11:00:00', '12:00:00', '2026-11-16', 1),
(22, 1, 'yuvin', '2026-11-04', 'laki-laki', '2026-11-14 14:43:42', 20, '16:00:00', '17:00:00', '2026-11-16', 1),
(23, 1, 'yuvin', '2026-11-04', 'laki-laki', '2026-11-14 14:43:42', 20, '12:00:00', '13:00:00', '2026-11-16', 1),
(24, 1, 'yuvin', '2026-11-04', 'laki-laki', '2026-11-14 14:43:42', 20, '13:00:00', '14:00:00', '2026-11-16', 1),
(25, 1, 'yuvin', '2026-11-04', 'laki-laki', '2026-11-14 14:43:42', 20, '14:00:00', '15:00:00', '2026-11-16', 1),
(26, 1, 'yuvin', '2026-11-04', 'laki-laki', '2026-11-14 14:43:42', 20, '15:00:00', '16:00:00', '2026-11-16', 1),
(29, 1, 'sdfsdf', '2026-11-03', 'male', '2026-11-14 16:18:00', 20, '08:00:00', '09:00:00', '2026-11-17', 0),
(30, 1, 'fsdv', '2026-11-19', 'female', '2026-11-14 16:18:31', 20, '16:00:00', '17:00:00', '2026-11-17', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jadwal_rutin`
--
ALTER TABLE `jadwal_rutin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `layanan_lokasi_id` (`layanan_lokasi_id`);

--
-- Indeks untuk tabel `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `layanan_lokasi`
--
ALTER TABLE `layanan_lokasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lokasi_id` (`lokasi_id`),
  ADD KEY `layanan_id` (`layanan_id`);

--
-- Indeks untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservasi_id` (`reservasi_id`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasien_id` (`pengguna_id`),
  ADD KEY `reservasi_ibfk_2` (`layanan_lokasi_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jadwal_rutin`
--
ALTER TABLE `jadwal_rutin`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `layanan_lokasi`
--
ALTER TABLE `layanan_lokasi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal_rutin`
--
ALTER TABLE `jadwal_rutin`
  ADD CONSTRAINT `jadwal_rutin_ibfk_1` FOREIGN KEY (`layanan_lokasi_id`) REFERENCES `layanan_lokasi` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `layanan_lokasi`
--
ALTER TABLE `layanan_lokasi`
  ADD CONSTRAINT `layanan_lokasi_ibfk_1` FOREIGN KEY (`layanan_id`) REFERENCES `layanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `layanan_lokasi_ibfk_2` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasi` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`reservasi_id`) REFERENCES `reservasi` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`),
  ADD CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`layanan_lokasi_id`) REFERENCES `layanan_lokasi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
