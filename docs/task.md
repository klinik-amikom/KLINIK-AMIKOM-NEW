# Task: Perbaikan Database Schema Klinik AMIKOM

## Checklist Perbaikan

### [x] Analisis & Dokumentasi
- [x] Analisis struktur database existing
- [x] Identifikasi masalah kritis
- [x] Buat dokumentasi lengkap perubahan

### [x] SQL Script Perbaikan
- [x] Fix tabel `users` untuk kompatibilitas Laravel 11
- [x] Tambahkan timestamps ke `resep_obat` dan `positions`
- [x] Tambahkan soft deletes ke tabel-tabel penting
- [x] Fix foreign key constraints
- [x] Tambahkan constraint UNSIGNED untuk stok
- [x] Tambahkan tabel `transaksi` untuk billing
- [x] Tambahkan tabel `jadwal_dokter` untuk scheduling
- [x] Tambahkan kolom `harga` di tabel `obat`

### [x] Migration Files Laravel
- [x] Buat migration untuk fix tabel `users`
- [x] Buat migration untuk timestamps
- [x] Buat migration untuk soft deletes
- [x] Buat migration untuk tabel baru
- [x] Buat migration untuk constraint fixes

### [x] Dokumentasi
- [x] Buat dokumentasi perubahan lengkap
- [x] Buat panduan migrasi data
- [x] Buat catatan breaking changes

### [x] Models & Controllers Migration
- [x] Update semua models ke schema baru
- [x] Fix AuthController & RoleMiddleware
- [x] Fix DashboardController & ApotekerController
- [x] Refactor UserController
- [x] Fix RekamMedisController
- [x] Verify no more `where('level')` queries

### [x] Seeders
- [x] Create PositionSeeder
- [x] Create MasterIdentitySeeder
- [x] Create UserSeeder
- [x] Test login dengan seeded users

