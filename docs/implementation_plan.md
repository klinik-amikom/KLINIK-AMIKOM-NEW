# Implementation Plan: Database Schema Fixes untuk Klinik AMIKOM

## Overview

Memperbaiki database schema `klinik_amikom_new.sql` agar kompatibel dengan Laravel 11 dan mengikuti best practices. Total ada 10 masalah yang teridentifikasi, dengan 5 masalah kritis yang harus diperbaiki.

## User Review Required

> [!WARNING]
> **Breaking Changes:**
> - Tabel `users` akan diubah strukturnya (menambah kolom `name`, `email`, `email_verified_at`, `remember_token` dan menghapus kolom `gender`)
> - Beberapa foreign key akan ditambahkan `ON DELETE CASCADE` yang bisa menyebabkan data terhapus otomatis
> - Soft deletes akan ditambahkan ke beberapa tabel (menambah kolom `deleted_at`)

> [!IMPORTANT]
> **Data Migration Required:**
> - Data existing di tabel `users` perlu dimigrasikan untuk mengisi kolom `name` dan `email` yang baru
> - Kolom `gender` di `users` akan dihapus karena redundan (sudah ada di `master_identity`)

## Proposed Changes

### Database Schema Fixes

#### [NEW] [klinik_amikom_fixed.sql](file:///e:/penting/aca/KA%20NGULANG/klinik_amikom_fixed.sql)
SQL script lengkap dengan semua perbaikan yang sudah diterapkan. File ini bisa langsung digunakan untuk fresh installation.

**Perubahan yang diterapkan:**
1. ✅ Fix tabel `users` - tambah kolom Laravel required fields
2. ✅ Tambah timestamps ke `resep_obat` dan `positions`
3. ✅ Tambah soft deletes (`deleted_at`) ke tabel penting
4. ✅ Fix foreign key constraints dengan ON DELETE/UPDATE
5. ✅ Tambah constraint UNSIGNED untuk stok dan jumlah
6. ✅ Tambah tabel `transaksi` untuk billing system
7. ✅ Tambah tabel `jadwal_dokter` untuk scheduling
8. ✅ Tambah kolom `harga` di tabel `obat`
9. ✅ Tambah kolom `biaya_pemeriksaan` di tabel `rekam_medis`

---

#### [NEW] [migration_fixes.sql](file:///e:/penting/aca/KA%20NGULANG/migration_fixes.sql)
SQL script untuk migrasi dari schema lama ke schema baru. File ini untuk existing database yang sudah ada datanya.

**Isi script:**
- ALTER TABLE statements untuk modifikasi struktur existing
- Data migration queries untuk populate kolom baru
- Backup recommendations sebelum execute

---

### Laravel Migration Files

#### [NEW] [2026_02_02_000001_fix_users_table_for_laravel.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000001_fix_users_table_for_laravel.php)
Migration untuk fix tabel `users` agar kompatibel dengan Laravel 11 authentication.

**Changes:**
- Tambah kolom `name`, `email`, `email_verified_at`, `remember_token`
- Hapus kolom `gender` (redundant)
- Tambah unique index untuk `email`

---

#### [NEW] [2026_02_02_000002_add_timestamps_to_tables.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000002_add_timestamps_to_tables.php)
Migration untuk menambahkan timestamps ke tabel yang belum punya.

**Changes:**
- Tambah `created_at` dan `updated_at` ke `resep_obat`
- Tambah `created_at` dan `updated_at` ke `positions`

---

#### [NEW] [2026_02_02_000003_add_soft_deletes_to_tables.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000003_add_soft_deletes_to_tables.php)
Migration untuk menambahkan soft delete functionality.

**Changes:**
- Tambah `deleted_at` ke `users`, `pasien`, `rekam_medis`, `obat`, `master_identity`

---

#### [NEW] [2026_02_02_000004_fix_foreign_key_constraints.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000004_fix_foreign_key_constraints.php)
Migration untuk memperbaiki foreign key constraints.

**Changes:**
- Drop existing foreign keys
- Recreate dengan ON DELETE CASCADE/RESTRICT yang tepat

---

#### [NEW] [2026_02_02_000005_add_unsigned_constraints.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000005_add_unsigned_constraints.php)
Migration untuk menambahkan UNSIGNED constraint.

**Changes:**
- Ubah kolom `stok` di `obat` menjadi UNSIGNED
- Ubah kolom `jumlah` di `resep_obat` menjadi UNSIGNED

---

#### [NEW] [2026_02_02_000006_create_transaksi_table.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000006_create_transaksi_table.php)
Migration untuk membuat tabel transaksi/pembayaran.

**Changes:**
- Buat tabel `transaksi` dengan kolom: kode_transaksi, rekam_medis_id, total_biaya, metode_pembayaran, status_pembayaran, tanggal_bayar

---

#### [NEW] [2026_02_02_000007_create_jadwal_dokter_table.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000007_create_jadwal_dokter_table.php)
Migration untuk membuat tabel jadwal dokter.

**Changes:**
- Buat tabel `jadwal_dokter` dengan kolom: dokter_id, hari, jam_mulai, jam_selesai, poli, kuota

---

#### [NEW] [2026_02_02_000008_add_harga_to_obat_table.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000008_add_harga_to_obat_table.php)
Migration untuk menambahkan kolom harga di tabel obat.

**Changes:**
- Tambah kolom `harga` (decimal) di tabel `obat`

---

#### [NEW] [2026_02_02_000009_add_biaya_to_rekam_medis_table.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000009_add_biaya_to_rekam_medis_table.php)
Migration untuk menambahkan kolom biaya pemeriksaan.

**Changes:**
- Tambah kolom `biaya_pemeriksaan` (decimal) di tabel `rekam_medis`

---

### Documentation

#### [NEW] [DATABASE_CHANGES.md](file:///C:/Users/PINNNRU/.gemini/antigravity/brain/d824d86b-7b7d-45ce-95cc-039af86266d3/DATABASE_CHANGES.md)
Dokumentasi lengkap semua perubahan database schema.

**Contents:**
- Daftar masalah yang ditemukan
- Solusi untuk setiap masalah
- Breaking changes dan impact analysis
- Migration guide step-by-step
- Rollback procedures
- Testing checklist

---

## Verification Plan

### Automated Tests

Karena ini adalah database schema fixes, tidak ada automated tests yang bisa dijalankan. Verification akan dilakukan melalui:

1. **SQL Syntax Validation:**
   ```bash
   # Validate SQL syntax
   mysql -u root -p --execute="source e:/penting/aca/KA NGULANG/klinik_amikom_fixed.sql"
   ```

2. **Laravel Migration Test:**
   ```bash
   # Test migrations
   cd "e:/penting/aca/KA NGULANG"
   php artisan migrate:fresh
   ```

### Manual Verification

> [!NOTE]
> User perlu melakukan manual verification untuk memastikan:

1. **Database Structure Check:**
   - Import `klinik_amikom_fixed.sql` ke database baru
   - Verify semua tabel terbuat dengan benar
   - Check foreign key constraints dengan `SHOW CREATE TABLE`

2. **Laravel Compatibility Check:**
   - Run migrations di Laravel project
   - Test Laravel authentication (login/register)
   - Test Eloquent models dengan timestamps dan soft deletes

3. **Data Integrity Check:**
   - Jika migrasi dari database lama, verify data tidak hilang
   - Check foreign key relationships masih intact
   - Verify UNSIGNED constraints tidak menyebabkan error

**User akan diminta untuk:**
- Backup database existing sebelum apply migration
- Test di development environment dulu
- Confirm semua functionality masih berjalan normal
