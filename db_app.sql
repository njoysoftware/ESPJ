-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Jul 2025 pada 15.38
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
-- Database: `db_app`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_akun`
--

CREATE TABLE `t_akun` (
  `id_akun` int(11) NOT NULL,
  `kementerian` varchar(100) NOT NULL,
  `program` varchar(100) NOT NULL,
  `kegiatan` varchar(100) NOT NULL,
  `output` varchar(100) NOT NULL,
  `komponen` varchar(100) NOT NULL,
  `sub_komponen` varchar(100) NOT NULL,
  `kode_akun` varchar(100) NOT NULL,
  `akun` varchar(100) NOT NULL,
  `detail` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kecamatan`
--

CREATE TABLE `t_kecamatan` (
  `id_kecamatan` int(11) NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `alamat_kecamatan` varchar(200) NOT NULL,
  `telp_kecamatan` varchar(200) NOT NULL,
  `kab_kecamatan` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kuitansi`
--

CREATE TABLE `t_kuitansi` (
  `id_kuitansi` int(11) NOT NULL,
  `nomor` varchar(100) NOT NULL,
  `tahun_anggaran` int(11) NOT NULL,
  `akun` varchar(100) NOT NULL,
  `nama_toko` varchar(100) NOT NULL,
  `nama_penerima` varchar(250) NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `tanggal` date NOT NULL,
  `bruto` int(11) NOT NULL,
  `ppn` float NOT NULL,
  `pph` float NOT NULL,
  `netto` float NOT NULL,
  `id_kecamatan` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pejabat`
--

CREATE TABLE `t_pejabat` (
  `id_pejabat` int(11) NOT NULL,
  `id_kec` int(11) NOT NULL,
  `spk` varchar(100) NOT NULL,
  `nip_spk` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pembukuan`
--

CREATE TABLE `t_pembukuan` (
  `id_pembukuan` int(11) NOT NULL,
  `id_kecamatan` int(11) NOT NULL,
  `id_kuitansi` int(11) NOT NULL,
  `debet` int(11) NOT NULL,
  `kredit` int(11) NOT NULL,
  `keterangan_bku` varchar(250) NOT NULL,
  `bulan` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_ppk_bp`
--

CREATE TABLE `t_ppk_bp` (
  `id_ppk_bp` int(11) NOT NULL,
  `nama_ppk` varchar(250) NOT NULL,
  `nip_ppk` varchar(100) NOT NULL,
  `nama_bp` varchar(250) NOT NULL,
  `nip_bp` varchar(100) NOT NULL,
  `nama_kabupaten` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_rab`
--

CREATE TABLE `t_rab` (
  `id_rab` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `id_kecamatan` int(11) NOT NULL,
  `bulan` varchar(100) NOT NULL,
  `tahun_anggaran` int(11) NOT NULL,
  `jumlah` int(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_user`
--

CREATE TABLE `t_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(11) NOT NULL,
  `id_kecamatan` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_user`
--

INSERT INTO `t_user` (`id_user`, `username`, `password`, `role`, `id_kecamatan`, `created_at`, `updated_at`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_akun`
--
ALTER TABLE `t_akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indeks untuk tabel `t_kecamatan`
--
ALTER TABLE `t_kecamatan`
  ADD PRIMARY KEY (`id_kecamatan`);

--
-- Indeks untuk tabel `t_kuitansi`
--
ALTER TABLE `t_kuitansi`
  ADD PRIMARY KEY (`id_kuitansi`);

--
-- Indeks untuk tabel `t_pejabat`
--
ALTER TABLE `t_pejabat`
  ADD PRIMARY KEY (`id_pejabat`);

--
-- Indeks untuk tabel `t_pembukuan`
--
ALTER TABLE `t_pembukuan`
  ADD PRIMARY KEY (`id_pembukuan`);

--
-- Indeks untuk tabel `t_ppk_bp`
--
ALTER TABLE `t_ppk_bp`
  ADD PRIMARY KEY (`id_ppk_bp`);

--
-- Indeks untuk tabel `t_rab`
--
ALTER TABLE `t_rab`
  ADD PRIMARY KEY (`id_rab`);

--
-- Indeks untuk tabel `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_akun`
--
ALTER TABLE `t_akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_kecamatan`
--
ALTER TABLE `t_kecamatan`
  MODIFY `id_kecamatan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_kuitansi`
--
ALTER TABLE `t_kuitansi`
  MODIFY `id_kuitansi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_pejabat`
--
ALTER TABLE `t_pejabat`
  MODIFY `id_pejabat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_pembukuan`
--
ALTER TABLE `t_pembukuan`
  MODIFY `id_pembukuan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_ppk_bp`
--
ALTER TABLE `t_ppk_bp`
  MODIFY `id_ppk_bp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_rab`
--
ALTER TABLE `t_rab`
  MODIFY `id_rab` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
