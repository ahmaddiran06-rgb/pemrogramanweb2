-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Okt 2026 pada 15.02
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
-- Database: `lat_dbase`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran_mhs`
--

CREATE TABLE `pendaftaran_mhs` (
  `id` int(11) NOT NULL,
  `tgl_input` date NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jk` varchar(20) NOT NULL,
  `asal_sekolah` varchar(150) NOT NULL,
  `pekerjaan_ortu` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `mat` tinyint(3) UNSIGNED NOT NULL,
  `bing` tinyint(3) UNSIGNED NOT NULL,
  `umum` tinyint(3) UNSIGNED NOT NULL,
  `rata` decimal(5,2) NOT NULL,
  `tempat_tes` varchar(50) NOT NULL,
  `keterangan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendaftaran_mhs`
--

INSERT INTO `pendaftaran_mhs` (`id`, `tgl_input`, `kode`, `nama`, `jk`, `asal_sekolah`, `pekerjaan_ortu`, `tempat_lahir`, `tgl_lahir`, `mat`, `bing`, `umum`, `rata`, `tempat_tes`, `keterangan`) VALUES
(1, '2021-03-12', 'B1', 'diran', 'Laki-Laki', 'SMKN 2 SAWANGAN', 'Pilot', 'labuan bajo', '1832-08-14', 80, 75, 85, 80.00, 'Gedung B', 'Lulus'),
(2, '2021-03-01', 'B1', 'suparta', 'Laki-Laki', 'SMKN 2 SAWANGAN', 'Pilot', 'labuan bajo', '1832-08-14', 80, 75, 85, 80.00, 'Gedung B', 'Lulus'),
(3, '2010-07-23', 'B1', 'sunarti', 'Perempuan', 'SMKN 2 SAWANGAN', 'Pilot', 'labuan bajo', '1832-08-14', 80, 75, 85, 80.00, 'Gedung B', 'Lulus'),
(4, '2001-05-12', 'B1', 'sulman', 'Laki-Laki', 'SMKN 2 SAWANGAN', 'Pilot', 'labuan bajo', '1832-08-14', 80, 75, 85, 80.00, 'Gedung B', 'Lulus'),
(5, '2019-03-21', 'B1', 'sulman', 'Laki-Laki', 'SMKN 2 SAWANGAN', 'Pilot', 'labuan bajo', '1832-08-14', 80, 75, 85, 80.00, 'Gedung B', 'Lulus'),
(6, '2012-03-12', 'B1', 'pato', 'Laki-Laki', 'SMKN 2 SAWANGAN', 'Pilot', 'labuan bajo', '1832-08-14', 80, 75, 85, 80.00, 'Gedung B', 'Lulus');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pendaftaran_mhs`
--
ALTER TABLE `pendaftaran_mhs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pendaftaran_mhs`
--
ALTER TABLE `pendaftaran_mhs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
