-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Jun 2025 pada 12.43
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ekstrakurikuler`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `eskul`
--

CREATE TABLE `eskul` (
  `id_eskul` int(11) NOT NULL,
  `nama_eskul` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `pembina` varchar(100) NOT NULL,
  `hari_kegiatan` varchar(10) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `kuota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `eskul`
--

INSERT INTO `eskul` (`id_eskul`, `nama_eskul`, `deskripsi`, `pembina`, `hari_kegiatan`, `jam_mulai`, `jam_selesai`, `lokasi`, `kuota`) VALUES
(1, 'Pramuka', 'pramuka', 'Pak Somat', 'Sabtu', '15:00:00', '17:00:00', 'lapangan futsal', 30),
(2, 'Volly', 'ssds', 'Pak Mamang', 'selasa', '14:00:00', '16:00:00', 'lapangan volly', 32),
(3, 'Tari', 'omaga', 'Bu Esme', 'Minguu', '15:00:00', '17:00:00', 'lapangan', 22),
(4, 'Musik', 'bernyanyi bernyanyi', 'Pak Amba', 'Selasa', '15:00:00', '17:00:00', 'Ruang Musik', 22);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran_eskul`
--

CREATE TABLE `pendaftaran_eskul` (
  `id_pendaftaran` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_eskul` int(11) NOT NULL,
  `tanggal_daftar` date NOT NULL,
  `status` enum('tunda','diterima','ditolak') NOT NULL DEFAULT 'tunda',
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendaftaran_eskul`
--

INSERT INTO `pendaftaran_eskul` (`id_pendaftaran`, `id_siswa`, `id_eskul`, `tanggal_daftar`, `status`, `keterangan`) VALUES
(1, 1, 1, '2025-06-08', 'diterima', 'fomo'),
(2, 1, 2, '2025-02-12', 'diterima', 'DMKSMA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('admin','pembina','pelatih') NOT NULL,
  `terakhir_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `username`, `password`, `nama_lengkap`, `role`, `terakhir_login`) VALUES
(3, 'admin', '$2y$10$UOM/SpzOkbG8LztJ9CAMWO5/cPzGbpOkqFUmaV2p/BzUGOIJMz1F6', 'Administrator', 'admin', NULL),  ---pw nya admin123----
(4, 'Dimas', '$2y$10$l8NjkiAytfWMoHh3oMK4S.JvF6d9DR291fiGQJYfI23rYZeQ5CeE2', '', 'admin', NULL),
(7, 'mamang', '$2y$10$ejJHOAU4p3qgmV0uwdl0AeDgi3mO.yaH99x2RttynP8dSMWzEPA8S', '', 'pelatih', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama_siswa` varchar(200) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nis`, `nama_siswa`, `kelas`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `no_telp`, `email`) VALUES
(1, '123456789', 'denis', 'X RPL 1', 'L', '2222-02-21', 'dwds', '09877272', 'denis@sanss.dds');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `eskul`
--
ALTER TABLE `eskul`
  ADD PRIMARY KEY (`id_eskul`);

--
-- Indeks untuk tabel `pendaftaran_eskul`
--
ALTER TABLE `pendaftaran_eskul`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_eskul` (`id_eskul`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nis` (`nis`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `eskul`
--
ALTER TABLE `eskul`
  MODIFY `id_eskul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran_eskul`
--
ALTER TABLE `pendaftaran_eskul`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pendaftaran_eskul`
--
ALTER TABLE `pendaftaran_eskul`
  ADD CONSTRAINT `pendaftaran_eskul_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftaran_eskul_ibfk_2` FOREIGN KEY (`id_eskul`) REFERENCES `eskul` (`id_eskul`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
