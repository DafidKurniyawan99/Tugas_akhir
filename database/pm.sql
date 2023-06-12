-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Nov 2022 pada 17.24
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pm_bobot`
--

CREATE TABLE `pm_bobot` (
  `selisih` int(11) NOT NULL,
  `bobot` float NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pm_bobot`
--

INSERT INTO `pm_bobot` (`selisih`, `bobot`, `keterangan`) VALUES
(0, 5, 'Tidak ada selisih (kompetensi sesuai dgn yg dibutuhkan)'),
(1, 4.5, 'Kompetensi individu kelebihan 1 tingkat'),
(-1, 4, 'Kompetensi individu kekurangan 1 tingkat'),
(2, 3.5, 'Kompetensi individu kelebihan 2 tingkat'),
(-2, 3, 'Kompetensi individu kekurangan 2 tingkat'),
(3, 2.5, 'Kompetensi individu  kelebihan 3 tingkat'),
(-3, 2, 'Kompetensi individu  kekurangan 3 tingkat'),
(4, 1.5, 'Kompetensi individu kelebihan 4 tingkat'),
(-4, 1, 'Kompetensi individu kekurangan 4 tingkat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pm_faktor`
--

CREATE TABLE `pm_faktor` (
  `id_faktor` int(11) UNSIGNED NOT NULL,
  `id_kriteria` int(11) UNSIGNED NOT NULL,
  `faktor` varchar(50) NOT NULL,
  `nilai_target` int(11) NOT NULL,
  `jenis_faktor` set('core','secondary') DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pm_faktor`
--

INSERT INTO `pm_faktor` (`id_faktor`, `id_kriteria`, `faktor`, `nilai_target`, `jenis_faktor`) VALUES
(1, 1, 'Nilai Pengetahuan', 5, 'core'),
(2, 1, 'Nilai Keterampilan', 5, 'secondary'),
(7, 2, 'Kehadiran', 4, 'secondary'),
(8, 2, 'Tugas', 4, 'core'),
(9, 3, 'Tingkat Provinsi', 4, 'core'),
(10, 3, 'Tingkat Kabupaten', 4, 'secondary'),
(11, 3, 'Tingkat Kecamatan', 4, 'secondary');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pm_kriteria`
--

CREATE TABLE `pm_kriteria` (
  `id_kriteria` int(11) UNSIGNED NOT NULL,
  `kriteria` varchar(100) NOT NULL,
  `prosentase` float NOT NULL,
  `bobot_core` float NOT NULL,
  `bobot_secondary` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pm_kriteria`
--

INSERT INTO `pm_kriteria` (`id_kriteria`, `kriteria`, `prosentase`, `bobot_core`, `bobot_secondary`) VALUES
(1, 'Nilai', 50, 60, 40),
(2, 'Kedisiplinan', 25, 60, 40),
(3, 'Prestasi', 25, 60, 40);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pm_nilai`
--

CREATE TABLE `pm_nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_faktor` int(11) NOT NULL,
  `bobot_nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pm_nilai`
--

INSERT INTO `pm_nilai` (`id_nilai`, `id_siswa`, `id_faktor`, `bobot_nilai`) VALUES
(1, 1, 1, 3),
(2, 1, 2, 3),
(3, 1, 7, 3),
(4, 1, 8, 3),
(5, 1, 9, 1),
(6, 1, 10, 1),
(7, 1, 11, 1),
(8, 2, 1, 4),
(9, 2, 2, 4),
(10, 2, 7, 4),
(11, 2, 8, 3),
(12, 2, 9, 1),
(13, 2, 10, 1),
(14, 2, 11, 1),
(15, 3, 1, 4),
(16, 3, 2, 4),
(17, 3, 9, 1),
(18, 3, 10, 1),
(19, 3, 11, 1),
(20, 3, 7, 4),
(21, 3, 8, 3),
(22, 4, 1, 4),
(23, 4, 2, 4),
(24, 4, 7, 4),
(25, 4, 8, 3),
(26, 4, 9, 1),
(27, 4, 10, 1),
(28, 4, 11, 1),
(29, 5, 1, 4),
(30, 5, 2, 5),
(31, 5, 7, 4),
(32, 5, 8, 3),
(33, 5, 9, 1),
(34, 5, 10, 1),
(35, 5, 11, 1),
(36, 6, 1, 4),
(37, 6, 2, 4),
(38, 6, 7, 4),
(39, 6, 8, 3),
(40, 6, 9, 1),
(41, 6, 10, 1),
(42, 6, 11, 1),
(43, 7, 1, 4),
(44, 7, 2, 4),
(45, 7, 7, 3),
(46, 7, 8, 3),
(47, 7, 9, 1),
(48, 7, 10, 1),
(49, 7, 11, 1),
(50, 8, 1, 5),
(51, 8, 2, 5),
(52, 8, 7, 4),
(53, 8, 8, 3),
(54, 8, 9, 1),
(55, 8, 10, 1),
(56, 8, 11, 1),
(57, 9, 1, 4),
(58, 9, 2, 4),
(59, 9, 7, 3),
(60, 9, 8, 3),
(61, 9, 9, 1),
(62, 9, 10, 1),
(63, 9, 11, 1),
(64, 10, 1, 5),
(65, 10, 2, 5),
(66, 10, 7, 3),
(67, 10, 8, 3),
(68, 10, 9, 1),
(69, 10, 10, 1),
(70, 10, 11, 1),
(71, 11, 7, 4),
(72, 11, 8, 3),
(73, 11, 9, 1),
(74, 11, 10, 1),
(75, 11, 11, 1),
(76, 11, 1, 3),
(77, 11, 2, 3),
(78, 12, 1, 3),
(79, 12, 2, 3),
(80, 12, 7, 2),
(81, 12, 8, 3),
(82, 12, 9, 1),
(83, 12, 10, 1),
(84, 12, 11, 1),
(85, 13, 9, 1),
(86, 13, 10, 1),
(87, 13, 11, 1),
(88, 13, 7, 4),
(89, 13, 8, 3),
(90, 13, 1, 3),
(91, 13, 2, 3),
(92, 14, 1, 1),
(93, 14, 2, 1),
(94, 14, 7, 1),
(95, 14, 8, 1),
(96, 14, 9, 1),
(97, 14, 10, 1),
(98, 14, 11, 1),
(99, 15, 1, 3),
(100, 15, 2, 3),
(101, 15, 7, 4),
(102, 15, 8, 3),
(103, 15, 9, 1),
(104, 15, 10, 1),
(105, 15, 11, 1),
(106, 16, 1, 3),
(107, 16, 2, 3),
(108, 16, 9, 1),
(109, 16, 10, 1),
(110, 16, 11, 1),
(111, 17, 1, 3),
(112, 17, 2, 3),
(113, 17, 7, 4),
(114, 17, 8, 3),
(115, 17, 9, 1),
(116, 17, 10, 1),
(117, 17, 11, 1),
(118, 18, 1, 3),
(119, 18, 2, 3),
(120, 18, 7, 4),
(121, 18, 8, 3),
(122, 18, 9, 1),
(123, 18, 10, 1),
(124, 18, 11, 1),
(125, 19, 1, 3),
(126, 19, 2, 3),
(127, 19, 7, 2),
(128, 19, 8, 3),
(129, 19, 9, 1),
(130, 19, 10, 1),
(131, 19, 11, 1),
(132, 20, 1, 3),
(133, 20, 2, 3),
(134, 20, 7, 2),
(135, 20, 8, 3),
(136, 20, 9, 1),
(137, 20, 10, 1),
(138, 20, 11, 1),
(139, 16, 7, 4),
(140, 16, 8, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pm_ranking`
--

CREATE TABLE `pm_ranking` (
  `id_siswa` int(11) NOT NULL,
  `nilai_akhir` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pm_ranking`
--

INSERT INTO `pm_ranking` (`id_siswa`, `nilai_akhir`) VALUES
(1, 3),
(2, 3.6),
(3, 3.6),
(4, 3.6),
(5, 3.8),
(6, 3.6),
(7, 3.5),
(8, 4.1),
(9, 3.5),
(10, 3),
(11, 3.1),
(12, 2.9),
(13, 3.1),
(14, 1.5),
(15, 3.1),
(16, 3.1),
(18, 3.1),
(19, 2.9),
(20, 2.9),
(17, 3.1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis_siswa` int(11) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `kelas` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nis_siswa`, `nama_siswa`, `kelas`) VALUES
(1, 1912, 'Aldo Bakti Prayoga', '9B'),
(2, 1935, 'Alya Zulaika', '9C'),
(3, 1893, 'Aini Khoirin Nisa', '9A'),
(4, 1930, 'Wahdaniyah', '9B'),
(5, 1955, 'Zubaidatun Al K', '9C'),
(6, 1938, 'Cantika Gadis F.', '9C'),
(7, 1918, 'Fardan Adianto', '9B'),
(8, 1910, 'Yofa Bariandra Armain', '9A'),
(9, 1924, 'Nida Ul Khoiroh', '9B'),
(10, 1911, 'Ahmad Yunus', '9B'),
(11, 1891, 'Ahmad Ferdiansyah', '9A'),
(12, 1925, 'Radit Saputra', '9B'),
(13, 1933, 'A Jae Alfia', '9C'),
(14, 1892, 'Ahmat Hamim', '9A'),
(15, 1897, 'Ass Syhifau Bayu Azli', '9A'),
(16, 1953, 'Torik Arifin', '9C'),
(17, 1899, 'Dika Saputra', '9A'),
(18, 1889, 'Adis Meikhan S', '9A'),
(19, 1923, 'Nanang Setiawan', '9B'),
(20, 1927, 'Tama Adiyansyah', '9B');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`) VALUES
(2, 'Dafid', 'admin', '$2y$10$udDRYfaaUtS500p3/WU0EOjgDQ9MH1eHJ2eGCXlwsDjZ2A/IE36.G'),
(3, 'iqbal', 'iqbal', '$2y$10$0dRgmJ0sQzcLA0UTnw9y/ulyXQGMYGfS.kA9JssVXrk9Pwnjhazoe');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pm_bobot`
--
ALTER TABLE `pm_bobot`
  ADD PRIMARY KEY (`selisih`);

--
-- Indeks untuk tabel `pm_faktor`
--
ALTER TABLE `pm_faktor`
  ADD PRIMARY KEY (`id_faktor`);

--
-- Indeks untuk tabel `pm_kriteria`
--
ALTER TABLE `pm_kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `pm_nilai`
--
ALTER TABLE `pm_nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pm_faktor`
--
ALTER TABLE `pm_faktor`
  MODIFY `id_faktor` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `pm_kriteria`
--
ALTER TABLE `pm_kriteria`
  MODIFY `id_kriteria` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pm_nilai`
--
ALTER TABLE `pm_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
