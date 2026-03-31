-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2026 at 04:05 PM
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
-- Database: `klinik_amikom_fixed`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_dokter`
--

CREATE TABLE `jadwal_dokter` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dokter_id` bigint(20) UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `poli` enum('Poli Umum','Poli Gigi') NOT NULL,
  `kuota` int(10) UNSIGNED NOT NULL DEFAULT 20,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_klinik`
--

CREATE TABLE `jadwal_klinik` (
  `id_jadwal` int(11) NOT NULL,
  `hari` varchar(50) NOT NULL,
  `jam_buka` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_klinik`
--

INSERT INTO `jadwal_klinik` (`id_jadwal`, `hari`, `jam_buka`, `created_at`, `updated_at`) VALUES
(2, 'Senin, Selasa, Rabu, Kamis, Jumat', '09:00 - 15:00', '2026-03-11 08:56:26', '2026-03-11 05:01:16'),
(3, 'Sabtu, Minggu', 'TUTUP', '2026-03-11 04:09:58', '2026-03-11 05:04:03');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_identity`
--

CREATE TABLE `master_identity` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identity_number` varchar(20) NOT NULL,
  `identity_type` enum('mahasiswa','dosen','karyawan') NOT NULL,
  `name` varchar(100) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('L','P') NOT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_identity`
--

INSERT INTO `master_identity` (`id`, `identity_number`, `identity_type`, `name`, `birth_date`, `gender`, `no_telp`, `email`, `address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1985010120101234', 'karyawan', 'Ahmad Fauzi', '1986-02-14', 'L', '082135224733', 'devisetya559@gmail.com', 'Jl. Ringroad Utara, Yogyakarta', '2026-02-01 22:57:38', '2026-02-01 22:57:38', NULL),
(2, '1982031519981234', 'dosen', 'Dr. Siti Nurhaliza', '2006-03-24', 'P', '082135224733', 'rasyythaya@gmail.com', 'Jl. Kaliurang KM 14, Sleman', '2026-02-01 22:57:38', '2026-02-01 22:57:38', NULL),
(3, '1987072020054567', 'dosen', 'drg. Budi Santoso', '1987-02-03', 'L', NULL, NULL, 'Jl. Seturan Raya, Sleman', '2026-02-01 22:57:38', '2026-02-01 22:57:38', NULL),
(4, '1990010520153216', 'karyawan', 'Apt. Dewi Lestari', '1998-03-04', 'P', '082134567891', 'rasyythaya@gmail.com', 'Jl. Affandi, Yogyakarta', '2026-02-01 22:57:38', '2026-02-01 22:57:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_02_26_191033_add_no_antrian_to_pasien_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_obat` varchar(10) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `stok` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `harga` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `tanggal_kadaluarsa` date NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `kode_obat`, `nama_obat`, `stok`, `harga`, `tanggal_kadaluarsa`, `deskripsi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'OBT001', 'Paracetamol', 65, 0.00, '2030-11-28', 'Untuk demam dan migrain', '2026-02-23 08:39:58', '2026-02-23 08:39:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identity_id` bigint(20) UNSIGNED NOT NULL,
  `kode_pasien` varchar(10) NOT NULL,
  `poli` enum('Poli Umum','Poli Gigi') NOT NULL,
  `queue_number` varchar(11) DEFAULT NULL,
  `estimasi_jam` time DEFAULT NULL,
  `visit_date` datetime DEFAULT NULL,
  `status` enum('menunggu_konfirmasi','terdaftar','diperiksa','menunggu_obat','selesai') DEFAULT 'menunggu_konfirmasi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `identity_id`, `kode_pasien`, `poli`, `queue_number`, `estimasi_jam`, `visit_date`, `status`, `created_at`, `updated_at`) VALUES
(62, 4, 'P001', 'Poli Umum', 'PU-001', '13:26:57', '2026-03-30 00:00:00', 'selesai', '2026-03-30 06:26:57', '2026-03-30 06:48:00'),
(63, 1, 'P002', 'Poli Gigi', 'PG-001', '13:29:06', '2026-03-30 00:00:00', 'selesai', '2026-03-30 06:29:06', '2026-03-30 06:42:42');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position` varchar(30) NOT NULL,
  `code` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `position`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'ADM', '2026-02-01 22:57:37', '2026-02-01 22:57:37'),
(2, 'Dokter', 'DOK', '2026-02-01 22:57:37', '2026-02-01 22:57:37'),
(3, 'Apoteker', 'APT', '2026-02-01 22:57:37', '2026-02-01 22:57:37');

-- --------------------------------------------------------

--
-- Table structure for table `rekam_medis`
--

CREATE TABLE `rekam_medis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_rekam_medis` varchar(10) NOT NULL,
  `pasien_id` bigint(20) UNSIGNED NOT NULL,
  `dokter_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_periksa` date NOT NULL,
  `diagnosis` text NOT NULL,
  `catatan` text DEFAULT NULL,
  `biaya_pemeriksaan` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `status` enum('menunggu_pemeriksaan','diperiksa','menunggu_obat','selesai') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekam_medis`
--

INSERT INTO `rekam_medis` (`id`, `kode_rekam_medis`, `pasien_id`, `dokter_id`, `tanggal_periksa`, `diagnosis`, `catatan`, `biaya_pemeriksaan`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 'RM001', 62, 1, '2026-03-30', 'BAPIL', NULL, 0.00, 'selesai', '2026-03-30 06:27:11', '2026-03-30 06:48:00', NULL),
(7, 'RM002', 63, 1, '2026-03-30', 'PILEK', NULL, 0.00, 'selesai', '2026-03-30 06:29:21', '2026-03-30 06:42:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `resep_obat`
--

CREATE TABLE `resep_obat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rekam_medis_id` bigint(20) UNSIGNED NOT NULL,
  `obat_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `aturan_pakai` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resep_obat`
--

INSERT INTO `resep_obat` (`id`, `rekam_medis_id`, `obat_id`, `jumlah`, `aturan_pakai`, `created_at`, `updated_at`) VALUES
(5, 6, 1, 12, '3 kali sehari setelah makan', '2026-03-30 06:27:27', '2026-03-30 06:27:27'),
(6, 7, 1, 12, '3 kali sehari setelah makan', '2026-03-30 06:40:16', '2026-03-30 06:40:16');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('MqzCMDjKclwiEc0dJ4qifTzMWEydSv7Ys2fusqM2', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibGFpSkhJTUdvR0lPWmdlSVhkRWlYbzhFWUJpS1Zmd0tZMU82TGljUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWthbS1tZWRpcyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1774879414);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_transaksi` varchar(20) NOT NULL,
  `rekam_medis_id` bigint(20) UNSIGNED NOT NULL,
  `total_biaya` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `metode_pembayaran` enum('tunai','transfer','kartu_debit','kartu_kredit','asuransi') NOT NULL DEFAULT 'tunai',
  `status_pembayaran` enum('belum_bayar','lunas','dibatalkan') NOT NULL DEFAULT 'belum_bayar',
  `tanggal_bayar` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identity_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `position_id` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `identity_id`, `name`, `username`, `email`, `email_verified_at`, `password`, `position_id`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Ahmad Fauzin', 'admin', 'admin@klinik.amikom.ac.id', '2026-02-01 22:57:38', '$2y$12$TJ/CccYWu846isemQ03OuuSCzuk.xZbgHu5RBHryZgFo1vq.5Js0m', 1, NULL, '2026-02-01 22:57:39', '2026-02-09 23:50:43', NULL),
(2, 2, 'Dr. Siti Nurhaliza', 'dr.siti', 'siti.nurhaliza@amikom.ac.id', '2026-02-01 22:57:39', '$2y$12$vl0w5avbQYRqjKC293TibeXU1EW.dKAo14G.Rxid5hsPteDSAFi9q', 2, NULL, '2026-02-01 22:57:39', '2026-02-09 16:28:32', '2026-02-09 16:28:32'),
(3, 3, 'drg. Budi Santoso', 'drg.budi', 'budi.santoso@amikom.ac.id', '2026-02-01 22:57:39', '$2y$12$JsmBk.kXF//Jk5nptTNG9.v8DBG0KsiaU9VPQRqkgCdpy7WHpS9eK', 2, NULL, '2026-02-01 22:57:39', '2026-02-09 16:15:44', '2026-02-09 16:15:44'),
(4, 4, 'Apt. Dewi Lestari', 'apt.dewi', 'dewi.lestari@klinik.amikom.ac.id', '2026-02-01 22:57:39', '$2y$12$YzLgulrxkLyu68GTz7ab0O4bQ4X3d5rNxOSFh7Sjw0hfdyJdUGDAu', 3, NULL, '2026-02-01 22:57:40', '2026-02-09 16:59:43', '2026-02-09 16:59:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokter_id` (`dokter_id`),
  ADD KEY `jadwal_dokter_hari_index` (`hari`),
  ADD KEY `jadwal_dokter_poli_index` (`poli`);

--
-- Indexes for table `jadwal_klinik`
--
ALTER TABLE `jadwal_klinik`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_identity`
--
ALTER TABLE `master_identity`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identity_number` (`identity_number`),
  ADD KEY `master_identity_deleted_at_index` (`deleted_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_obat` (`kode_obat`),
  ADD KEY `obat_deleted_at_index` (`deleted_at`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_pasien` (`kode_pasien`),
  ADD KEY `identity_id` (`identity_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_rekam_medis` (`kode_rekam_medis`),
  ADD KEY `pasien_id` (`pasien_id`),
  ADD KEY `dokter_id` (`dokter_id`),
  ADD KEY `rekam_medis_deleted_at_index` (`deleted_at`);

--
-- Indexes for table `resep_obat`
--
ALTER TABLE `resep_obat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rekam_medis_id` (`rekam_medis_id`),
  ADD KEY `obat_id` (`obat_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `rekam_medis_id` (`rekam_medis_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `identity_id` (`identity_id`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `users_deleted_at_index` (`deleted_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_identity`
--
ALTER TABLE `master_identity`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `resep_obat`
--
ALTER TABLE `resep_obat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD CONSTRAINT `jadwal_dokter_ibfk_1` FOREIGN KEY (`dokter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pasien`
--
ALTER TABLE `pasien`
  ADD CONSTRAINT `pasien_ibfk_1` FOREIGN KEY (`identity_id`) REFERENCES `master_identity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `rekam_medis_ibfk_1` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rekam_medis_ibfk_2` FOREIGN KEY (`dokter_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `resep_obat`
--
ALTER TABLE `resep_obat`
  ADD CONSTRAINT `resep_obat_ibfk_1` FOREIGN KEY (`rekam_medis_id`) REFERENCES `rekam_medis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resep_obat_ibfk_2` FOREIGN KEY (`obat_id`) REFERENCES `obat` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`rekam_medis_id`) REFERENCES `rekam_medis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`identity_id`) REFERENCES `master_identity` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
