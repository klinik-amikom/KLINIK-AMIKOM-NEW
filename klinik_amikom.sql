-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2026 at 05:37 PM
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
-- Database: `klinik_amikom`
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
  `kuota` int(10) UNSIGNED NOT NULL DEFAULT 20,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `poli` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_dokter`
--

INSERT INTO `jadwal_dokter` (`id`, `dokter_id`, `hari`, `jam_mulai`, `jam_selesai`, `kuota`, `created_at`, `updated_at`, `poli`) VALUES
(15, 8, 'Senin', '08:00:00', '15:00:00', 20, '2026-04-08 03:13:03', '2026-04-08 03:13:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_klinik`
--

CREATE TABLE `jadwal_klinik` (
  `id_jadwal` bigint(20) UNSIGNED NOT NULL,
  `hari` varchar(255) NOT NULL,
  `jam_buka` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `poli` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_klinik`
--

INSERT INTO `jadwal_klinik` (`id_jadwal`, `hari`, `jam_buka`, `created_at`, `updated_at`, `poli`) VALUES
(1, 'Senin, Selasa, Rabu, Kamis, Jumat', '08:00 - 15:00', '2026-03-11 08:56:26', '2026-04-08 03:19:58', 1),
(8, 'Sabtu, Minggu', 'TUTUP', '2026-04-08 03:17:40', '2026-04-08 03:17:40', NULL);

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
  `identity_type` enum('mahasiswa','dosen','karyawan','karyawan_buma') NOT NULL,
  `name` varchar(100) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('L','P') NOT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_identity`
--

INSERT INTO `master_identity` (`id`, `identity_number`, `identity_type`, `name`, `birth_date`, `gender`, `no_telp`, `email`, `address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1985010120101234', 'karyawan', 'Ahmad Fauzi', '1986-02-14', 'L', '082135224733', 'devisetya559@gmail.com', 'Jl. Ringroad Utara, aaaaaaaaaaa', '2026-02-01 22:57:38', '2026-04-07 04:06:06', '2026-04-02 13:19:02'),
(2, '1982031519981234', 'karyawan', 'Dr. Micelyn Sona', '2006-03-24', 'P', '082135224733', 'rasyythaya@gmail.com', 'Jl. Kaliurang KM 14, Sleman', '2026-02-01 22:57:38', '2026-02-01 22:57:38', NULL),
(3, '1987072020054567', 'dosen', 'drg. Budi Santoso', '1987-02-03', 'L', NULL, NULL, 'Jl. Seturan Raya, Sleman', '2026-02-01 22:57:38', '2026-04-02 13:28:37', '2026-04-02 13:28:37'),
(4, '1990010520153216', 'karyawan', 'Apt. Dewi Lestari', '1998-03-04', 'P', '082134567891', 'rasyythaya@gmail.com', 'Jl. Affandi, Yogyakarta', '2026-02-01 22:57:38', '2026-02-01 22:57:38', NULL),
(5, '3404123456768912', 'mahasiswa', 'Rasya Asya', '2004-12-24', 'P', '082135224733', 'rasya24dezukra@gmail.com', 'Prambanan', NULL, NULL, NULL),
(6, '1111112343234545', 'mahasiswa', 'Devi Setyo we', NULL, 'P', '082135224733', 'devisetya@gmail.com', 'test', '2026-04-02 13:26:09', '2026-04-02 13:28:30', NULL),
(7, '099998989898222', 'dosen', 'dira.paaaaaaaaaa', NULL, 'P', '082135224733', 'devisetya@gmail.com', 'test', '2026-04-03 04:20:04', '2026-04-03 04:20:48', '2026-04-03 04:20:48');

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
  `nama_obat` varchar(50) NOT NULL,
  `stok` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `tanggal_kadaluarsa` date NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `kode_obat`, `nama_obat`, `stok`, `tanggal_kadaluarsa`, `deskripsi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'OBT001', 'Paracetamol', 34, '2030-11-28', 'Untuk demam dan migrain.', '2026-02-23 08:39:58', '2026-04-08 14:32:17', NULL),
(2, 'OBT002', 'Amoxcillin', 2046, '2030-10-31', 'Antibiotik', '2026-03-31 07:23:39', '2026-04-08 14:50:08', NULL),
(3, 'OBT003', 'Ibu Profen', 918, '2030-10-31', 'Pereda nyeri kepala dan haid.', '2026-03-31 07:24:23', '2026-04-08 14:50:08', NULL),
(5, 'OBT004', 'Freshcare', 100, '2030-10-31', 'Melegakan', '2026-04-05 13:28:38', '2026-04-05 13:43:48', NULL),
(8, 'CTR00', 'Ceterezine HCL', 121, '2026-12-30', 'Untuk alergi', '2026-04-07 04:00:18', '2026-04-08 14:37:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pasien_periksa`
--

CREATE TABLE `pasien_periksa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identity_id` bigint(20) UNSIGNED NOT NULL,
  `kode_pasien` varchar(10) NOT NULL,
  `queue_number` varchar(11) DEFAULT NULL,
  `estimasi_jam` time DEFAULT NULL,
  `visit_date` datetime DEFAULT NULL,
  `status` enum('menunggu_konfirmasi','terdaftar','diperiksa','menunggu_obat','selesai') DEFAULT 'menunggu_konfirmasi',
  `tensi` varchar(20) DEFAULT NULL,
  `berat_badan` int(11) DEFAULT NULL,
  `tinggi_badan` int(11) DEFAULT NULL,
  `keluhan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `poli` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pasien_periksa`
--

INSERT INTO `pasien_periksa` (`id`, `identity_id`, `kode_pasien`, `queue_number`, `estimasi_jam`, `visit_date`, `status`, `tensi`, `berat_badan`, `tinggi_badan`, `keluhan`, `created_at`, `updated_at`, `poli`) VALUES
(62, 4, 'P001', 'PU-001', '13:26:57', '2026-03-30 00:00:00', 'selesai', NULL, NULL, NULL, NULL, '2026-03-30 06:26:57', '2026-03-30 06:48:00', NULL),
(64, 2, 'P003', 'PG-001', '08:00:00', '2026-03-31 00:00:00', 'selesai', NULL, NULL, NULL, NULL, '2026-03-31 00:58:57', '2026-03-31 01:07:47', NULL),
(65, 5, 'P004', 'PG-002', '08:15:00', '2026-03-31 00:00:00', 'selesai', NULL, NULL, NULL, NULL, '2026-03-31 07:48:07', '2026-03-31 07:51:03', NULL),
(66, 5, 'P005', 'PU-001', '08:00:00', '2026-04-01 00:00:00', 'selesai', '120/80', 45, 150, 'kepala pusing', '2026-03-31 20:32:22', '2026-04-07 08:05:00', NULL),
(67, 5, 'P006', 'PG-001', '04:00:00', '2026-04-01 00:00:00', 'terdaftar', '120/80', 45, 150, 'ww', '2026-03-31 20:54:00', '2026-04-03 02:50:27', NULL),
(68, 5, 'P007', 'PG-002', '04:15:00', '2026-04-01 00:00:00', 'menunggu_konfirmasi', NULL, NULL, NULL, NULL, '2026-03-31 20:56:35', '2026-03-31 20:56:35', NULL),
(69, 5, 'P008', 'PG-003', '11:15:00', '2026-04-01 00:00:00', 'menunggu_konfirmasi', NULL, NULL, NULL, NULL, '2026-04-01 04:01:07', '2026-04-01 04:01:07', NULL),
(70, 5, 'P009', 'PG-004', '11:30:00', '2026-04-01 00:00:00', 'menunggu_konfirmasi', NULL, NULL, NULL, NULL, '2026-04-01 04:01:34', '2026-04-01 04:01:34', NULL),
(71, 2, 'P010', 'PU-001', '10:45:00', '2026-04-03 00:00:00', 'selesai', '120/80', 45, 150, 'aa', '2026-04-03 03:45:08', '2026-04-07 08:02:48', NULL),
(72, 2, 'P011', 'PU-001', '16:30:00', '2026-04-05 00:00:00', 'menunggu_konfirmasi', NULL, NULL, NULL, NULL, '2026-04-04 09:24:32', '2026-04-04 09:24:32', NULL),
(73, 2, 'P012', 'PU-002', '16:45:00', '2026-04-05 00:00:00', 'menunggu_konfirmasi', NULL, NULL, NULL, NULL, '2026-04-04 09:27:01', '2026-04-04 09:27:01', NULL),
(82, 2, 'P021', 'PU-003', '11:45:00', '2026-04-06 00:00:00', 'menunggu_konfirmasi', NULL, NULL, NULL, NULL, '2026-04-06 04:36:52', '2026-04-06 04:36:52', 1),
(94, 2, 'P033', 'PU-008', '12:45:00', '2026-04-06 00:00:00', 'menunggu_konfirmasi', NULL, NULL, NULL, NULL, '2026-04-06 05:16:07', '2026-04-06 05:16:07', 1),
(96, 2, 'P034', 'PU-013', '10:30:00', '2026-04-07 00:00:00', 'menunggu_konfirmasi', NULL, NULL, NULL, NULL, '2026-04-06 09:31:29', '2026-04-06 09:31:29', 1),
(98, 4, 'P036', 'PU-005', '11:00:00', '2026-04-07 00:00:00', 'selesai', '120/80', 77, 182, 'pilek', '2026-04-07 03:57:08', '2026-04-07 04:16:49', 1),
(99, 5, 'P037', 'PU-003', '12:15:00', '2026-04-07 00:00:00', 'menunggu_konfirmasi', NULL, NULL, NULL, NULL, '2026-04-07 05:11:30', '2026-04-07 05:11:30', 1),
(100, 5, 'P038', 'PU-004', '12:30:00', '2026-04-07 00:00:00', 'terdaftar', '120/80', 50, 160, 'm', '2026-04-07 05:14:21', '2026-04-07 09:34:46', 1),
(101, 5, 'P039', 'PU-005', '13:00:00', '2026-04-07 00:00:00', 'menunggu_obat', '120/80', 50, 160, 'Pusing', '2026-04-07 05:47:00', '2026-04-07 06:48:44', 1),
(102, 5, 'P040', 'PU-006', '14:15:00', '2026-04-07 00:00:00', 'selesai', '120/80', 50, 160, 'Pusing', '2026-04-07 07:03:30', '2026-04-07 07:44:14', 1),
(103, 5, 'P041', 'PU-001', '08:00:00', '2026-04-08 00:00:00', 'selesai', '120/80', 50, 160, 'AA', '2026-04-07 08:09:59', '2026-04-08 14:32:17', 1),
(104, 5, 'P042', 'PU-002', '10:00:00', '2026-04-08 00:00:00', 'selesai', '120/80', 50, 160, 'Pusing', '2026-04-08 02:54:17', '2026-04-08 02:57:14', 1),
(105, 5, 'P043', 'PU-001', '08:00:00', '2026-04-09 00:00:00', 'menunggu_konfirmasi', NULL, NULL, NULL, NULL, '2026-04-08 07:47:28', '2026-04-08 07:47:28', 1),
(106, 5, 'P044', 'PU-002', '08:15:00', '2026-04-09 00:00:00', 'selesai', '120/80', 50, 160, 'ngantuk', '2026-04-08 07:49:14', '2026-04-08 14:41:09', 1),
(107, 5, 'P045', 'PU-003', '08:30:00', '2026-04-09 00:00:00', 'selesai', '120/80', 50, 160, 'Tidak enak badan dan mual', '2026-04-08 13:15:07', '2026-04-08 14:37:39', 1),
(108, 5, 'P046', 'PU-004', '08:45:00', '2026-04-09 00:00:00', 'selesai', '120/80', 50, 160, 'mmm', '2026-04-08 14:10:17', '2026-04-08 14:50:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `poli`
--

CREATE TABLE `poli` (
  `id` bigint(20) NOT NULL,
  `nama_poli` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `created_at`, `updated_at`) VALUES
(1, 'Poli Umum', '2026-04-01 06:07:27', '2026-04-01 06:07:27');

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
(3, 'Apoteker', 'APT', '2026-02-01 22:57:37', '2026-02-01 22:57:37'),
(4, 'Admin Klinik', 'ADM_KL', '2026-04-01 09:34:30', '2026-04-01 09:34:30');

-- --------------------------------------------------------

--
-- Table structure for table `rekam_medis`
--

CREATE TABLE `rekam_medis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_rekam_medis` varchar(10) NOT NULL,
  `pasien_id` bigint(20) UNSIGNED NOT NULL,
  `dokter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal_periksa` date NOT NULL,
  `diagnosis` text NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('menunggu_pemeriksaan','diperiksa','menunggu_obat','selesai') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekam_medis`
--

INSERT INTO `rekam_medis` (`id`, `kode_rekam_medis`, `pasien_id`, `dokter_id`, `tanggal_periksa`, `diagnosis`, `catatan`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 'RM001', 62, 1, '2026-03-30', 'BAPIL', NULL, 'selesai', '2026-03-30 06:27:11', '2026-04-06 17:36:52', '2026-04-06 17:36:52'),
(8, 'RM003', 64, 1, '2026-03-31', 'Sakit kepala', NULL, 'selesai', '2026-03-31 01:04:41', '2026-04-08 03:56:29', '2026-04-08 03:56:29'),
(9, 'RM004', 65, 1, '2026-03-31', 'Gigi tumbuh', NULL, 'selesai', '2026-03-31 07:49:18', '2026-04-07 04:01:59', '2026-04-07 04:01:59'),
(10, 'RM005', 66, 1, '2026-04-02', 'ii', NULL, 'selesai', '2026-04-02 15:04:57', '2026-04-08 03:56:38', '2026-04-08 03:56:38'),
(11, 'RM006', 67, 1, '2026-04-03', '-', NULL, 'menunggu_pemeriksaan', '2026-04-03 02:50:27', '2026-04-03 04:17:37', '2026-04-03 04:17:37'),
(12, 'RM007', 71, 1, '2026-04-03', 'ddd', NULL, 'selesai', '2026-04-03 04:13:27', '2026-04-08 03:56:45', '2026-04-08 03:56:45'),
(16, 'RM008', 98, 1, '2026-04-07', 'ok', NULL, 'selesai', '2026-04-07 03:58:33', '2026-04-07 07:08:21', '2026-04-07 07:08:21'),
(17, 'RM009', 101, 1, '2026-04-07', 'Kelelahan', NULL, 'menunggu_obat', '2026-04-07 06:26:50', '2026-04-07 07:08:15', '2026-04-07 07:08:15'),
(18, 'RM010', 102, 1, '2026-04-07', 'Kelelahan menghadap layar laptop', NULL, 'selesai', '2026-04-07 07:07:02', '2026-04-07 07:44:14', NULL),
(19, 'RM011', 100, 1, '2026-04-07', '-', NULL, 'menunggu_pemeriksaan', '2026-04-07 09:34:46', '2026-04-07 09:34:46', NULL),
(20, 'RM012', 104, 1, '2026-04-08', 'Kurang istirahat', NULL, 'selesai', '2026-04-08 02:55:25', '2026-04-08 02:57:14', NULL),
(21, 'RM013', 103, 1, '2026-04-08', 'Magh', NULL, 'selesai', '2026-04-08 09:33:30', '2026-04-08 14:32:17', NULL),
(22, 'RM014', 107, 1, '2026-04-08', '-ds', NULL, 'selesai', '2026-04-08 13:16:46', '2026-04-08 14:37:39', NULL),
(23, 'RM015', 106, 8, '2026-04-08', 'turu', NULL, 'selesai', '2026-04-08 13:43:10', '2026-04-08 14:41:09', NULL),
(24, 'RM016', 108, 8, '2026-04-08', 'Demam karena kelelahan', NULL, 'selesai', '2026-04-08 14:23:32', '2026-04-08 14:50:08', NULL);

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
(12, 16, 3, 1, NULL, '2026-04-07 04:05:09', '2026-04-07 04:05:09'),
(13, 10, 3, 2, '3 x sesudah makan', '2026-04-07 04:08:11', '2026-04-07 04:08:11'),
(14, 17, 1, 3, '3 x sesudah makan', '2026-04-07 06:48:44', '2026-04-07 06:48:44'),
(15, 17, 2, 3, '1 x sesudah makan', '2026-04-07 06:48:44', '2026-04-07 06:48:44'),
(16, 18, 1, 3, '3 x sesudah makan', '2026-04-07 07:13:06', '2026-04-07 07:13:06'),
(17, 18, 2, 3, '1 x sesudah makan', '2026-04-07 07:13:06', '2026-04-07 07:13:06'),
(18, 20, 2, 3, '3 x 1 sesudah makan', '2026-04-08 02:56:38', '2026-04-08 02:56:38'),
(19, 21, 1, 6, '3 x 1 sesudah makan', '2026-04-08 12:55:12', '2026-04-08 12:55:12'),
(20, 22, 8, 2, '3 x 1 sesudah makan', '2026-04-08 14:31:34', '2026-04-08 14:31:34'),
(21, 23, 3, 3, '3 x 1 sesudah makan', '2026-04-08 14:40:46', '2026-04-08 14:40:46'),
(22, 24, 3, 6, '3 x 1 sesudah makan', '2026-04-08 14:49:33', '2026-04-08 14:49:33'),
(23, 24, 2, 3, '1 sesudah makan', '2026-04-08 14:49:33', '2026-04-08 14:49:33');

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
('YFfkagEn5mGhXrDybF9wDIJgrUF5KYO5ChrGyBPm', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMzdoT1NObFV1NlZmSWxYM0thUGJZajFKOTNYeDF6Q3NkR3FuS1R1aiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWthbS1tZWRpcy9leHBvcnQvcGFzaWVuLzEwOCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1775660181);

-- --------------------------------------------------------

--
-- Table structure for table `tim_medis`
--

CREATE TABLE `tim_medis` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tim_medis`
--

INSERT INTO `tim_medis` (`id`, `user_id`, `deskripsi`, `gambar`) VALUES
(4, 1, 'Admin Klinik Klinik Amikom', 'tim_medis/tCZZBk2m0kw8uQcAl5RFw5pIbgmpoaZQSRd0PJLE.jpg'),
(5, 8, 'Dokter Umum Klinik Amikom', 'tim_medis/ltTj3Jxcxia3etfEPALe9WAFzYMP9RPTtr5q7mHF.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identity_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
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
(1, 1, 'Ahmad Fauzin', 'admin', 'admin@klinik.amikom.ac.id', '2026-02-01 22:57:38', '$2y$12$DWDqCgU5TLv/N0HGBdQf1uLHWlJlYaNF.iEo0OLYV4rkVcfS8yFiK', 1, NULL, '2026-02-01 22:57:39', '2026-04-06 10:19:05', NULL),
(7, 4, 'Admin Klinik', 'admin.klinik', 'rasya24dezukra@gmail.com', NULL, '$2y$12$mF/4zNiyTQ5bVHxZWRfP1.NplgoDu6ELFQytRvzbgEV/Yap3gt5qS', 4, NULL, '2026-04-06 10:32:05', '2026-04-06 15:38:32', NULL),
(8, 2, 'Dr. Micelyn Sona', 'dokter', 'dokter@klinik.com', NULL, '$2y$12$81qfClMLgprAKN3vWwMofuvA5BX6y3ukbvEA5Owrc3iHuz5vkfAUy', 2, NULL, '2026-04-06 10:32:20', '2026-04-06 10:32:20', NULL),
(9, 3, 'Apoteker', 'apoteker', 'apoteker@klinik.com', NULL, '$2y$12$I.q69.SGX2mhcUBwCfqqFuPTuM.8/o0hxqvf48/7xp5HzzisKAm3m', 3, NULL, '2026-04-06 10:32:50', '2026-04-06 10:32:50', NULL);

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
  ADD KEY `fk_jadwal_poli` (`poli`);

--
-- Indexes for table `jadwal_klinik`
--
ALTER TABLE `jadwal_klinik`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `fk_jadwal_klinik_poli` (`poli`);

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
-- Indexes for table `pasien_periksa`
--
ALTER TABLE `pasien_periksa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_pasien` (`kode_pasien`),
  ADD KEY `identity_id` (`identity_id`),
  ADD KEY `fk_pasien_poli` (`poli`);

--
-- Indexes for table `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `tim_medis`
--
ALTER TABLE `tim_medis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tim_medis_user` (`user_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jadwal_klinik`
--
ALTER TABLE `jadwal_klinik`
  MODIFY `id_jadwal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_identity`
--
ALTER TABLE `master_identity`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pasien_periksa`
--
ALTER TABLE `pasien_periksa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `poli`
--
ALTER TABLE `poli`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `resep_obat`
--
ALTER TABLE `resep_obat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tim_medis`
--
ALTER TABLE `tim_medis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD CONSTRAINT `fk_jadwal_poli` FOREIGN KEY (`poli`) REFERENCES `poli` (`id`),
  ADD CONSTRAINT `jadwal_dokter_ibfk_1` FOREIGN KEY (`dokter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwal_klinik`
--
ALTER TABLE `jadwal_klinik`
  ADD CONSTRAINT `fk_jadwal_klinik_poli` FOREIGN KEY (`poli`) REFERENCES `poli` (`id`);

--
-- Constraints for table `pasien_periksa`
--
ALTER TABLE `pasien_periksa`
  ADD CONSTRAINT `fk_pasien_poli` FOREIGN KEY (`poli`) REFERENCES `poli` (`id`),
  ADD CONSTRAINT `pasien_periksa_ibfk_1` FOREIGN KEY (`identity_id`) REFERENCES `master_identity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `rekam_medis_ibfk_1` FOREIGN KEY (`pasien_id`) REFERENCES `pasien_periksa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rekam_medis_ibfk_2` FOREIGN KEY (`dokter_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `resep_obat`
--
ALTER TABLE `resep_obat`
  ADD CONSTRAINT `resep_obat_ibfk_1` FOREIGN KEY (`rekam_medis_id`) REFERENCES `rekam_medis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resep_obat_ibfk_2` FOREIGN KEY (`obat_id`) REFERENCES `obat` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tim_medis`
--
ALTER TABLE `tim_medis`
  ADD CONSTRAINT `fk_tim_medis_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
