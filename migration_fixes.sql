-- ============================================================================
-- MIGRATION SCRIPT: From Old Schema to Fixed Schema
-- Database: klinik_amikom_new
-- Purpose: Migrate existing database to Laravel 11 compatible schema
-- ============================================================================
-- 
-- IMPORTANT: BACKUP YOUR DATABASE BEFORE RUNNING THIS SCRIPT!
-- Command: mysqldump -u root -p klinik_amikom_new > backup_before_migration.sql
--
-- ============================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ============================================================================
-- STEP 1: Add soft deletes to tables
-- ============================================================================

ALTER TABLE `master_identity` 
  ADD COLUMN `deleted_at` timestamp NULL DEFAULT NULL AFTER `updated_at`,
  ADD INDEX `master_identity_deleted_at_index` (`deleted_at`);

ALTER TABLE `obat` 
  ADD COLUMN `deleted_at` timestamp NULL DEFAULT NULL AFTER `updated_at`,
  ADD INDEX `obat_deleted_at_index` (`deleted_at`);

ALTER TABLE `pasien` 
  ADD COLUMN `deleted_at` timestamp NULL DEFAULT NULL AFTER `updated_at`,
  ADD INDEX `pasien_deleted_at_index` (`deleted_at`);

ALTER TABLE `rekam_medis` 
  ADD COLUMN `deleted_at` timestamp NULL DEFAULT NULL AFTER `updated_at`,
  ADD INDEX `rekam_medis_deleted_at_index` (`deleted_at`);

-- ============================================================================
-- STEP 2: Add timestamps to tables that don't have them
-- ============================================================================

ALTER TABLE `positions` 
  ADD COLUMN `created_at` timestamp NULL DEFAULT NULL AFTER `code`,
  ADD COLUMN `updated_at` timestamp NULL DEFAULT NULL AFTER `created_at`;

ALTER TABLE `resep_obat` 
  ADD COLUMN `created_at` timestamp NULL DEFAULT NULL AFTER `aturan_pakai`,
  ADD COLUMN `updated_at` timestamp NULL DEFAULT NULL AFTER `created_at`;

-- ============================================================================
-- STEP 3: Fix users table for Laravel 11 compatibility
-- ============================================================================

-- Add new required columns for Laravel authentication
ALTER TABLE `users` 
  ADD COLUMN `name` varchar(255) NOT NULL AFTER `identity_id`,
  ADD COLUMN `email` varchar(255) NOT NULL AFTER `username`,
  ADD COLUMN `email_verified_at` timestamp NULL DEFAULT NULL AFTER `email`,
  ADD COLUMN `remember_token` varchar(100) DEFAULT NULL AFTER `password`,
  ADD COLUMN `deleted_at` timestamp NULL DEFAULT NULL AFTER `updated_at`;

-- Migrate data: populate name from master_identity
UPDATE `users` u
INNER JOIN `master_identity` mi ON u.identity_id = mi.id
SET u.name = mi.name;

-- Migrate data: generate email from username (you may need to customize this)
UPDATE `users` 
SET email = CONCAT(username, '@klinik.amikom.ac.id')
WHERE email = '';

-- Add unique constraint for email
ALTER TABLE `users` 
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD INDEX `users_deleted_at_index` (`deleted_at`);

-- Remove redundant gender column (already exists in master_identity)
ALTER TABLE `users` 
  DROP COLUMN `gender`;

-- ============================================================================
-- STEP 4: Add UNSIGNED constraints to prevent negative values
-- ============================================================================

ALTER TABLE `obat` 
  MODIFY COLUMN `stok` int(10) UNSIGNED NOT NULL DEFAULT 0;

ALTER TABLE `resep_obat` 
  MODIFY COLUMN `jumlah` int(10) UNSIGNED NOT NULL DEFAULT 1;

-- ============================================================================
-- STEP 5: Add new columns for business logic
-- ============================================================================

-- Add harga to obat table
ALTER TABLE `obat` 
  ADD COLUMN `harga` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 AFTER `stok`;

-- Add biaya_pemeriksaan to rekam_medis table
ALTER TABLE `rekam_medis` 
  ADD COLUMN `biaya_pemeriksaan` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 AFTER `catatan`;

-- ============================================================================
-- STEP 6: Fix foreign key constraints
-- ============================================================================

-- Drop existing foreign keys
ALTER TABLE `pasien` DROP FOREIGN KEY `pasien_ibfk_1`;
ALTER TABLE `rekam_medis` DROP FOREIGN KEY `rekam_medis_ibfk_1`;
ALTER TABLE `rekam_medis` DROP FOREIGN KEY `rekam_medis_ibfk_2`;
ALTER TABLE `resep_obat` DROP FOREIGN KEY `resep_obat_ibfk_1`;
ALTER TABLE `resep_obat` DROP FOREIGN KEY `resep_obat_ibfk_2`;
ALTER TABLE `users` DROP FOREIGN KEY `users_ibfk_1`;
ALTER TABLE `users` DROP FOREIGN KEY `users_ibfk_2`;

-- Recreate foreign keys with proper ON DELETE and ON UPDATE actions
ALTER TABLE `pasien`
  ADD CONSTRAINT `pasien_ibfk_1` FOREIGN KEY (`identity_id`) 
    REFERENCES `master_identity` (`id`) 
    ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `rekam_medis_ibfk_1` FOREIGN KEY (`pasien_id`) 
    REFERENCES `pasien` (`id`) 
    ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rekam_medis_ibfk_2` FOREIGN KEY (`dokter_id`) 
    REFERENCES `users` (`id`) 
    ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `resep_obat`
  ADD CONSTRAINT `resep_obat_ibfk_1` FOREIGN KEY (`rekam_medis_id`) 
    REFERENCES `rekam_medis` (`id`) 
    ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resep_obat_ibfk_2` FOREIGN KEY (`obat_id`) 
    REFERENCES `obat` (`id`) 
    ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`identity_id`) 
    REFERENCES `master_identity` (`id`) 
    ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`position_id`) 
    REFERENCES `positions` (`id`) 
    ON DELETE RESTRICT ON UPDATE CASCADE;

-- ============================================================================
-- STEP 7: Create new tables
-- ============================================================================

-- Create transaksi table for billing/payment management
CREATE TABLE `transaksi` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(20) NOT NULL,
  `rekam_medis_id` bigint(20) UNSIGNED NOT NULL,
  `total_biaya` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `metode_pembayaran` enum('tunai','transfer','kartu_debit','kartu_kredit','asuransi') NOT NULL DEFAULT 'tunai',
  `status_pembayaran` enum('belum_bayar','lunas','dibatalkan') NOT NULL DEFAULT 'belum_bayar',
  `tanggal_bayar` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  KEY `rekam_medis_id` (`rekam_medis_id`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`rekam_medis_id`) 
    REFERENCES `rekam_medis` (`id`) 
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create jadwal_dokter table for doctor scheduling
CREATE TABLE `jadwal_dokter` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dokter_id` bigint(20) UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `poli` enum('Poli Umum','Poli Gigi') NOT NULL,
  `kuota` int(10) UNSIGNED NOT NULL DEFAULT 20,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dokter_id` (`dokter_id`),
  KEY `jadwal_dokter_hari_index` (`hari`),
  KEY `jadwal_dokter_poli_index` (`poli`),
  CONSTRAINT `jadwal_dokter_ibfk_1` FOREIGN KEY (`dokter_id`) 
    REFERENCES `users` (`id`) 
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================================
-- STEP 8: Verify migration
-- ============================================================================

-- Check if all tables exist
SELECT 
  TABLE_NAME,
  TABLE_ROWS,
  CREATE_TIME,
  UPDATE_TIME
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = 'klinik_amikom_new'
  AND TABLE_NAME IN (
    'master_identity', 'users', 'pasien', 'rekam_medis', 
    'obat', 'resep_obat', 'positions', 'transaksi', 'jadwal_dokter'
  )
ORDER BY TABLE_NAME;

-- Check foreign key constraints
SELECT 
  TABLE_NAME,
  CONSTRAINT_NAME,
  REFERENCED_TABLE_NAME,
  DELETE_RULE,
  UPDATE_RULE
FROM information_schema.REFERENTIAL_CONSTRAINTS
WHERE CONSTRAINT_SCHEMA = 'klinik_amikom_new'
ORDER BY TABLE_NAME;

COMMIT;

-- ============================================================================
-- MIGRATION COMPLETED
-- ============================================================================
-- 
-- Next steps:
-- 1. Verify all data is intact
-- 2. Test Laravel authentication (login/register)
-- 3. Test Eloquent models with soft deletes
-- 4. Update your Laravel models to use SoftDeletes trait
-- 5. Test all CRUD operations
--
-- ============================================================================
