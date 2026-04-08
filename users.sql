-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2026 at 08:09 PM
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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

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
