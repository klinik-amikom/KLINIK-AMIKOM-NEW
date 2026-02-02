# Database Seeders - Klinik AMIKOM

## 📦 Seeders yang Tersedia

### 1. PositionSeeder
Membuat 3 role/posisi di sistem klinik:

| Position | Code | Deskripsi |
|----------|------|-----------|
| Admin | ADM | Mengelola sistem, user management, laporan |
| Dokter | DOK | Melakukan pemeriksaan, menulis resep |
| Apoteker | APT | Mengelola obat, memberikan obat sesuai resep |

**File:** [PositionSeeder.php](file:///e:/penting/aca/KA%20NGULANG/database/seeders/PositionSeeder.php)

---

### 2. MasterIdentitySeeder
Membuat 4 identitas staff klinik:

| Nama | NIP/NID | Tipe | Gender |
|------|---------|------|--------|
| Ahmad Fauzi | 198501012010 | Karyawan | L |
| Dr. Siti Nurhaliza | 198203151998 | Dosen | P |
| drg. Budi Santoso | 198707202005 | Dosen | L |
| Apt. Dewi Lestari | 199001052015 | Karyawan | P |

**File:** [MasterIdentitySeeder.php](file:///e:/penting/aca/KA%20NGULANG/database/seeders/MasterIdentitySeeder.php)

---

### 3. UserSeeder
Membuat 4 user dengan akses login:

**File:** [UserSeeder.php](file:///e:/penting/aca/KA%20NGULANG/database/seeders/UserSeeder.php)

---

## 🔑 Login Credentials

> [!IMPORTANT]
> **Default password untuk semua user: `password`**

### 👨‍💼 Admin
```
Username: admin
Email: admin@klinik.amikom.ac.id
Password: password
Role: Admin (ADM)
```

**Akses:**
- ✅ User management
- ✅ Laporan & statistik
- ✅ Konfigurasi sistem
- ✅ Full access

---

### 👨‍⚕️ Dokter Umum
```
Username: dr.siti
Email: siti.nurhaliza@amikom.ac.id
Password: password
Role: Dokter (DOK)
Spesialisasi: Poli Umum
```

**Akses:**
- ✅ Melihat daftar pasien
- ✅ Melakukan pemeriksaan
- ✅ Menulis diagnosis
- ✅ Menulis resep obat

---

### 🦷 Dokter Gigi
```
Username: drg.budi
Email: budi.santoso@amikom.ac.id
Password: password
Role: Dokter (DOK)
Spesialisasi: Poli Gigi
```

**Akses:**
- ✅ Melihat daftar pasien
- ✅ Melakukan pemeriksaan
- ✅ Menulis diagnosis
- ✅ Menulis resep obat

---

### 💊 Apoteker
```
Username: apt.dewi
Email: dewi.lestari@klinik.amikom.ac.id
Password: password
Role: Apoteker (APT)
```

**Akses:**
- ✅ Melihat resep obat
- ✅ Mengelola stok obat
- ✅ Memberikan obat ke pasien
- ✅ Update status resep

---

## 🚀 Cara Menjalankan Seeders

### Fresh Seed (Hapus data lama)
```bash
php artisan migrate:fresh --seed
```

### Seed Saja (Tanpa migrate)
```bash
php artisan db:seed
```

### Seed Specific Seeder
```bash
# Hanya positions
php artisan db:seed --class=PositionSeeder

# Hanya master identity
php artisan db:seed --class=MasterIdentitySeeder

# Hanya users
php artisan db:seed --class=UserSeeder
```

---

## 📝 Urutan Dependency

> [!WARNING]
> **Seeders harus dijalankan dengan urutan yang benar!**

```
1. PositionSeeder      (tidak ada dependency)
   ↓
2. MasterIdentitySeeder (tidak ada dependency)
   ↓
3. UserSeeder          (depends on: positions, master_identity)
```

**DatabaseSeeder** sudah mengatur urutan ini secara otomatis.

---

## 🔧 Customization

### Menambah User Baru

Edit `UserSeeder.php`:

```php
[
    'identity_id' => 5, // Buat dulu di master_identity
    'name' => 'Nama Lengkap',
    'username' => 'username',
    'email' => 'email@amikom.ac.id',
    'email_verified_at' => now(),
    'password' => Hash::make('password'),
    'position_id' => 2, // 1=Admin, 2=Dokter, 3=Apoteker
    'created_at' => now(),
    'updated_at' => now(),
]
```

### Menambah Role Baru

Edit `PositionSeeder.php`:

```php
[
    'position' => 'Perawat',
    'code' => 'PWT',
    'created_at' => now(),
    'updated_at' => now(),
]
```

---

## 🧪 Testing Login

### Via Tinker
```bash
php artisan tinker

# Test login
$user = \App\Models\User::where('username', 'admin')->first();
\Illuminate\Support\Facades\Hash::check('password', $user->password);
// Output: true

# Lihat semua users
\App\Models\User::with('position', 'identity')->get();
```

### Via Browser
```
1. Akses: http://localhost:8000/login
2. Input username: admin
3. Input password: password
4. Login ✅
```

---

## 📊 Data yang Di-seed

### Positions Table
```
id | position  | code
1  | Admin     | ADM
2  | Dokter    | DOK
3  | Apoteker  | APT
```

### Master Identity Table
```
id | identity_number | identity_type | name
1  | 198501012010    | karyawan      | Ahmad Fauzi
2  | 198203151998    | dosen         | Dr. Siti Nurhaliza
3  | 198707202005    | dosen         | drg. Budi Santoso
4  | 199001052015    | karyawan      | Apt. Dewi Lestari
```

### Users Table
```
id | username  | email                              | position_id
1  | admin     | admin@klinik.amikom.ac.id          | 1 (Admin)
2  | dr.siti   | siti.nurhaliza@amikom.ac.id        | 2 (Dokter)
3  | drg.budi  | budi.santoso@amikom.ac.id          | 2 (Dokter)
4  | apt.dewi  | dewi.lestari@klinik.amikom.ac.id   | 3 (Apoteker)
```

---

## 🔐 Security Notes

> [!CAUTION]
> **Production Deployment:**

1. **Ganti semua password default!**
   ```bash
   # Jangan gunakan password "password" di production
   ```

2. **Hapus atau disable seeder di production**
   ```php
   // DatabaseSeeder.php
   public function run(): void
   {
       if (app()->environment('local')) {
           $this->call([...]);
       }
   }
   ```

3. **Gunakan password yang kuat**
   - Minimal 12 karakter
   - Kombinasi huruf besar, kecil, angka, simbol
   - Tidak mudah ditebak

---

**Status:** ✅ **Seeders Ready to Use!**  
**Total Users:** 4 (1 Admin, 2 Dokter, 1 Apoteker)
