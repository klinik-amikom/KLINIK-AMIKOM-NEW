# Database Schema Changes Documentation
## Klinik AMIKOM - Laravel 11 Compatibility Fixes

> [!IMPORTANT]
> **Last Updated:** 2026-02-02  
> **Database:** `klinik_amikom_new`  
> **Laravel Version:** 11.x

---

## 📋 Executive Summary

This document outlines all changes made to the `klinik_amikom_new` database schema to ensure full compatibility with Laravel 11 and adherence to best practices. A total of **10 issues** were identified and resolved, including **5 critical issues** that would have caused system failures.

---

## 🔍 Problems Identified

### Critical Issues (Priority 1)

| # | Issue | Impact | Status |
|---|-------|--------|--------|
| 1 | Users table incompatible with Laravel 11 Auth | Authentication system won't work | ✅ Fixed |
| 2 | Missing timestamps in `resep_obat` and `positions` | Eloquent models won't work properly | ✅ Fixed |
| 3 | Redundant `gender` column in `users` table | Data inconsistency risk | ✅ Fixed |
| 4 | No soft deletes on important tables | Permanent data loss, no recovery | ✅ Fixed |
| 5 | Incomplete foreign key constraints | Orphaned records, data integrity issues | ✅ Fixed |

### Important Issues (Priority 2)

| # | Issue | Impact | Status |
|---|-------|--------|--------|
| 6 | No UNSIGNED constraint on stock/quantity | Negative values possible | ✅ Fixed |
| 7 | No billing/payment system | Cannot manage transactions | ✅ Fixed |
| 8 | No price column in `obat` table | Cannot calculate costs | ✅ Fixed |

### Nice to Have (Priority 3)

| # | Issue | Impact | Status |
|---|-------|--------|--------|
| 9 | No doctor scheduling system | Manual scheduling required | ✅ Fixed |
| 10 | No examination fee tracking | Incomplete billing data | ✅ Fixed |

---

## 🔧 Solutions Implemented

### 1. Fixed Users Table for Laravel 11

**Problem:** Missing required columns for Laravel authentication system.

**Solution:**
- ✅ Added `name` column (VARCHAR 255)
- ✅ Added `email` column (VARCHAR 255, UNIQUE)
- ✅ Added `email_verified_at` column (TIMESTAMP NULL)
- ✅ Added `remember_token` column (VARCHAR 100)
- ✅ Removed redundant `gender` column
- ✅ Added soft deletes (`deleted_at`)

**Migration File:** [2026_02_02_000001_fix_users_table_for_laravel.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000001_fix_users_table_for_laravel.php)

**Data Migration:**
```sql
-- Populate name from master_identity
UPDATE users u
INNER JOIN master_identity mi ON u.identity_id = mi.id
SET u.name = mi.name;

-- Generate email from username
UPDATE users 
SET email = CONCAT(username, '@klinik.amikom.ac.id');
```

---

### 2. Added Timestamps to Tables

**Problem:** `positions` and `resep_obat` tables missing `created_at` and `updated_at` columns.

**Solution:**
- ✅ Added timestamps to `positions` table
- ✅ Added timestamps to `resep_obat` table

**Migration File:** [2026_02_02_000002_add_timestamps_to_tables.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000002_add_timestamps_to_tables.php)

---

### 3. Added Soft Deletes

**Problem:** Deleted records are permanently removed, no recovery possible.

**Solution:** Added `deleted_at` column to:
- ✅ `master_identity`
- ✅ `users`
- ✅ `pasien`
- ✅ `rekam_medis`
- ✅ `obat`

**Migration File:** [2026_02_02_000003_add_soft_deletes_to_tables.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000003_add_soft_deletes_to_tables.php)

**Model Update Required:**
```php
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    // ...
}
```

---

### 4. Fixed Foreign Key Constraints

**Problem:** Missing `ON DELETE` and `ON UPDATE` actions causing orphaned records.

**Solution:** Updated all foreign keys with proper cascade rules:

| Table | Foreign Key | ON DELETE | ON UPDATE |
|-------|-------------|-----------|-----------|
| `pasien` | `identity_id` | CASCADE | CASCADE |
| `rekam_medis` | `pasien_id` | CASCADE | CASCADE |
| `rekam_medis` | `dokter_id` | RESTRICT | CASCADE |
| `resep_obat` | `rekam_medis_id` | CASCADE | CASCADE |
| `resep_obat` | `obat_id` | RESTRICT | CASCADE |
| `users` | `identity_id` | RESTRICT | CASCADE |
| `users` | `position_id` | RESTRICT | CASCADE |

**Migration File:** [2026_02_02_000004_fix_foreign_key_constraints.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000004_fix_foreign_key_constraints.php)

---

### 5. Added UNSIGNED Constraints

**Problem:** Stock and quantity can be negative, causing invalid data.

**Solution:**
- ✅ Changed `obat.stok` to `INT UNSIGNED`
- ✅ Changed `resep_obat.jumlah` to `INT UNSIGNED`

**Migration File:** [2026_02_02_000005_add_unsigned_constraints.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000005_add_unsigned_constraints.php)

---

### 6. Created Transaksi Table

**Problem:** No system to manage billing and payments.

**Solution:** Created new `transaksi` table with:
- `kode_transaksi` (unique transaction code)
- `rekam_medis_id` (link to medical record)
- `total_biaya` (total cost)
- `metode_pembayaran` (payment method: tunai, transfer, kartu_debit, kartu_kredit, asuransi)
- `status_pembayaran` (payment status: belum_bayar, lunas, dibatalkan)
- `tanggal_bayar` (payment date)

**Migration File:** [2026_02_02_000006_create_transaksi_table.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000006_create_transaksi_table.php)

---

### 7. Created Jadwal Dokter Table

**Problem:** No system to manage doctor schedules.

**Solution:** Created new `jadwal_dokter` table with:
- `dokter_id` (doctor reference)
- `hari` (day: Senin-Minggu)
- `jam_mulai` (start time)
- `jam_selesai` (end time)
- `poli` (clinic: Poli Umum, Poli Gigi)
- `kuota` (patient quota per session)

**Migration File:** [2026_02_02_000007_create_jadwal_dokter_table.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000007_create_jadwal_dokter_table.php)

---

### 8. Added Harga to Obat Table

**Problem:** No price information for medicines.

**Solution:**
- ✅ Added `harga` column (DECIMAL 10,2 UNSIGNED) to `obat` table

**Migration File:** [2026_02_02_000008_add_harga_to_obat_table.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000008_add_harga_to_obat_table.php)

---

### 9. Added Biaya Pemeriksaan to Rekam Medis

**Problem:** No examination fee tracking.

**Solution:**
- ✅ Added `biaya_pemeriksaan` column (DECIMAL 10,2 UNSIGNED) to `rekam_medis` table

**Migration File:** [2026_02_02_000009_add_biaya_to_rekam_medis_table.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000009_add_biaya_to_rekam_medis_table.php)

---

## ⚠️ Breaking Changes

> [!WARNING]
> **These changes require code updates in your Laravel application:**

### 1. Users Table Structure Change

**Before:**
```php
$user->gender; // Available
$user->email; // Not available
```

**After:**
```php
$user->gender; // ❌ No longer available (use $user->identity->gender)
$user->email; // ✅ Now available
$user->name; // ✅ Now available
```

### 2. Soft Deletes Behavior

**Before:**
```php
User::find(1)->delete(); // Permanently deletes
```

**After:**
```php
User::find(1)->delete(); // Soft deletes (sets deleted_at)
User::find(1)->forceDelete(); // Permanently deletes
User::withTrashed()->find(1); // Include soft deleted
```

### 3. Foreign Key Cascade

**Before:**
- Deleting `master_identity` would fail if referenced by `pasien`

**After:**
- Deleting `master_identity` will CASCADE delete related `pasien` records
- Deleting `pasien` will CASCADE delete related `rekam_medis` records

---

## 📦 Migration Guide

### Option 1: Fresh Installation (Recommended for New Projects)

```bash
# 1. Drop existing database
mysql -u root -p -e "DROP DATABASE IF EXISTS klinik_amikom_new;"

# 2. Create new database
mysql -u root -p -e "CREATE DATABASE klinik_amikom_new CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 3. Import fixed schema
mysql -u root -p klinik_amikom_new < klinik_amikom_fixed.sql

# 4. Run Laravel migrations (if needed)
php artisan migrate
```

### Option 2: Migrate Existing Database (For Production)

> [!CAUTION]
> **BACKUP YOUR DATABASE FIRST!**

```bash
# 1. Backup existing database
mysqldump -u root -p klinik_amikom_new > backup_$(date +%Y%m%d_%H%M%S).sql

# 2. Run migration script
mysql -u root -p klinik_amikom_new < migration_fixes.sql

# 3. Verify migration
mysql -u root -p klinik_amikom_new -e "SHOW TABLES;"
```

### Option 3: Laravel Migrations (For Laravel Projects)

```bash
# 1. Copy migration files to database/migrations/
cp database/migrations/*.php /path/to/laravel/database/migrations/

# 2. Run migrations
php artisan migrate

# 3. Verify
php artisan migrate:status
```

---

## 🧪 Testing Checklist

### Database Structure Tests

- [ ] All tables created successfully
- [ ] All columns have correct data types
- [ ] All indexes created (unique, foreign keys)
- [ ] All foreign key constraints working
- [ ] Soft delete columns exist and indexed

### Laravel Integration Tests

- [ ] User registration works
- [ ] User login works
- [ ] Email verification works (if enabled)
- [ ] "Remember me" functionality works
- [ ] Soft delete works on all models
- [ ] `withTrashed()` returns soft deleted records
- [ ] Timestamps auto-populate on create/update

### Data Integrity Tests

- [ ] Cannot insert negative stock values
- [ ] Cannot insert negative quantity values
- [ ] Deleting `master_identity` cascades to `pasien`
- [ ] Deleting `pasien` cascades to `rekam_medis`
- [ ] Deleting `rekam_medis` cascades to `resep_obat`
- [ ] Cannot delete `users` if referenced by `rekam_medis` (RESTRICT)

### Business Logic Tests

- [ ] Can create transactions with different payment methods
- [ ] Can create doctor schedules
- [ ] Medicine prices calculated correctly
- [ ] Examination fees tracked properly
- [ ] Total billing calculation includes medicine + examination

---

## 📁 Files Created

### SQL Scripts

1. [klinik_amikom_fixed.sql](file:///e:/penting/aca/KA%20NGULANG/klinik_amikom_fixed.sql) - Complete fixed schema for fresh installation
2. [migration_fixes.sql](file:///e:/penting/aca/KA%20NGULANG/migration_fixes.sql) - Migration script for existing databases

### Laravel Migration Files

1. [2026_02_02_000001_fix_users_table_for_laravel.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000001_fix_users_table_for_laravel.php)
2. [2026_02_02_000002_add_timestamps_to_tables.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000002_add_timestamps_to_tables.php)
3. [2026_02_02_000003_add_soft_deletes_to_tables.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000003_add_soft_deletes_to_tables.php)
4. [2026_02_02_000004_fix_foreign_key_constraints.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000004_fix_foreign_key_constraints.php)
5. [2026_02_02_000005_add_unsigned_constraints.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000005_add_unsigned_constraints.php)
6. [2026_02_02_000006_create_transaksi_table.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000006_create_transaksi_table.php)
7. [2026_02_02_000007_create_jadwal_dokter_table.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000007_create_jadwal_dokter_table.php)
8. [2026_02_02_000008_add_harga_to_obat_table.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000008_add_harga_to_obat_table.php)
9. [2026_02_02_000009_add_biaya_to_rekam_medis_table.php](file:///e:/penting/aca/KA%20NGULANG/database/migrations/2026_02_02_000009_add_biaya_to_rekam_medis_table.php)

---

## 🔄 Rollback Procedures

### If Migration Fails

```bash
# 1. Restore from backup
mysql -u root -p klinik_amikom_new < backup_YYYYMMDD_HHMMSS.sql

# 2. Investigate error
# Check MySQL error logs
# Verify foreign key dependencies
# Check for data conflicts
```

### If Laravel Migration Fails

```bash
# Rollback last batch
php artisan migrate:rollback

# Rollback specific migration
php artisan migrate:rollback --step=1

# Reset all migrations
php artisan migrate:reset
```

---

## 📊 Schema Comparison

### Before vs After

| Aspect | Before | After |
|--------|--------|-------|
| Total Tables | 11 | 13 (+2) |
| Laravel Compatible | ❌ No | ✅ Yes |
| Soft Deletes | 0 tables | 5 tables |
| Billing System | ❌ No | ✅ Yes |
| Scheduling System | ❌ No | ✅ Yes |
| Price Tracking | ❌ No | ✅ Yes |
| Data Integrity | ⚠️ Partial | ✅ Complete |

---

## 🎯 Next Steps

1. **Update Laravel Models**
   - Add `SoftDeletes` trait to models
   - Update `$fillable` arrays
   - Add relationships for new tables

2. **Update Controllers**
   - Handle new `email` field in registration
   - Update user profile logic
   - Implement billing functionality

3. **Create Seeders**
   - Seed `positions` table
   - Create test users with emails
   - Add sample doctor schedules

4. **Update Views**
   - Add email input to registration form
   - Display user name instead of username
   - Create billing interface
   - Create scheduling interface

5. **Testing**
   - Run all tests from checklist above
   - Test in staging environment
   - Get user acceptance before production deployment

---

## 📞 Support

If you encounter any issues during migration:

1. Check MySQL error logs
2. Verify Laravel version compatibility
3. Ensure all foreign key dependencies are satisfied
4. Review this documentation for breaking changes
5. Test in development environment first

---

**Document Version:** 1.0  
**Created:** 2026-02-02  
**Author:** Senior Laravel Developer
