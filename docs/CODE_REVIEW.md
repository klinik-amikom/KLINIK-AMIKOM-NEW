# Code Review: Business Logic, Clean Code & Security

## 📊 Database Schema Review

### ✅ **SUDAH SESUAI Business Logic Klinik**

#### 1. **User Management** ✅
```sql
users (id, position_id, identity_id, email, password)
positions (id, position, code) -- ADM, DOK, APT
master_identity (id, identity_number, name, gender, address)
```
**Alasan Bagus:**
- ✅ Normalisasi data (identity terpisah dari users)
- ✅ Role-based access menggunakan relasi (bukan string)
- ✅ Mendukung Laravel 11 authentication
- ✅ Soft deletes untuk audit trail

#### 2. **Patient Management** ✅
```sql
pasien (id, identity_id, kode_pasien, status)
```
**Alasan Bagus:**
- ✅ Pasien linked ke master_identity (reusable data)
- ✅ `kode_pasien` untuk public exposure (bukan raw ID)
- ✅ Status workflow (menunggu → diperiksa → diobati → selesai)

#### 3. **Medical Records** ✅
```sql
rekam_medis (id, kode_rekam_medis, pasien_id, dokter_id, diagnosis, catatan, status)
resep_obat (id, rekam_medis_id, obat_id, jumlah, dosis, catatan)
```
**Alasan Bagus:**
- ✅ Rekam medis terpisah dari resep (many-to-many)
- ✅ Satu rekam medis bisa punya banyak obat
- ✅ Audit trail lengkap (timestamps, soft deletes)

#### 4. **Pharmacy Management** ✅
```sql
obat (id, nama_obat, kategori, stok, harga, satuan)
transaksi (id, rekam_medis_id, total_biaya, status_pembayaran)
```
**Alasan Bagus:**
- ✅ Obat punya harga & stok
- ✅ Transaksi terpisah untuk billing
- ✅ Status pembayaran (lunas/belum)

---

### ⚠️ **YANG MASIH KURANG (Business Logic)**

#### 1. **Appointment/Jadwal** ⚠️
```sql
-- MISSING: Sistem antrian/appointment
jadwal_dokter (id, dokter_id, hari, jam_mulai, jam_selesai)
antrian_pasien (id, pasien_id, tanggal, nomor_antrian, status)
```
**Rekomendasi:** Tambahkan jika klinik butuh sistem antrian

#### 2. **Inventory Management** ⚠️
```sql
-- MISSING: History stok obat
stok_history (id, obat_id, jenis, jumlah, keterangan, created_at)
```
**Rekomendasi:** Untuk tracking obat masuk/keluar

#### 3. **Payment Details** ⚠️
```sql
-- MISSING: Detail pembayaran
detail_transaksi (id, transaksi_id, item, harga, qty, subtotal)
```
**Rekomendasi:** Untuk invoice yang detail

#### 4. **Audit Log** ⚠️
```sql
-- MISSING: Activity log
activity_logs (id, user_id, action, model, model_id, changes, created_at)
```
**Rekomendasi:** Untuk compliance & security audit

---

## 🧹 Clean Code Review

### ✅ **SUDAH CLEAN CODE**

#### 1. **Models** ✅
```php
// GOOD: Proper relationships
public function position()
{
    return $this->belongsTo(Position::class);
}

// GOOD: Helper methods
public function isAdmin(): bool
{
    return $this->position && $this->position->code === 'ADM';
}

// GOOD: Attribute accessors
public function getRoleAttribute(): string
{
    return $this->position ? strtolower($this->position->position) : 'guest';
}
```

#### 2. **Controllers** ✅
```php
// GOOD: Transaction wrapping
DB::beginTransaction();
try {
    User::create([...]);
    DB::commit();
} catch (Exception $e) {
    DB::rollBack();
    return redirect()->back()->with('error', $e->getMessage());
}
```

#### 3. **Validation** ✅
```php
// GOOD: Custom validation messages
$rules = [
    'email' => 'required|email|unique:users,email',
    'password' => 'required|string|min:8|confirmed',
];
$request->validate($rules, $this->customMessages());
```

---

### ⚠️ **YANG PERLU DIPERBAIKI (Clean Code)**

#### 1. **Magic Numbers** ⚠️
```php
// BAD: Hard-coded position codes
$users = User::whereHas('position', function($q) {
    $q->where('code', 'DOK'); // Magic string
})->get();

// BETTER: Use constants
class Position {
    const ADMIN = 'ADM';
    const DOKTER = 'DOK';
    const APOTEKER = 'APT';
}

$users = User::whereHas('position', function($q) {
    $q->where('code', Position::DOKTER);
})->get();
```

#### 2. **Duplicate Code** ⚠️
```php
// BAD: Repeated query pattern
User::whereHas('position', function($q) {
    $q->where('code', 'DOK');
})->count();

// BETTER: Scope in User model
class User extends Model {
    public function scopeByPosition($query, $code) {
        return $query->whereHas('position', fn($q) => $q->where('code', $code));
    }
}

// Usage:
User::byPosition('DOK')->count();
```

#### 3. **Fat Controllers** ⚠️
```php
// BAD: Business logic in controller
public function store(Request $request) {
    // 50 lines of validation, creation, email sending, etc.
}

// BETTER: Use Service classes
class UserService {
    public function createUser(array $data): User {
        // Business logic here
    }
}

public function store(Request $request, UserService $service) {
    $user = $service->createUser($request->validated());
    return redirect()->back()->with('success', 'User created!');
}
```

#### 4. **Missing Type Hints** ⚠️
```php
// BAD: No type hints
public function update($request, $id) {
    // ...
}

// GOOD: Proper type hints
public function update(Request $request, int $id): RedirectResponse {
    // ...
}
```

---

## 🔒 Security Review

### ✅ **SUDAH AMAN**

#### 1. **Authentication** ✅
```php
// GOOD: Password hashing
'password' => Hash::make($request->password)

// GOOD: Auth middleware
Route::middleware(['auth', 'role:admin'])->group(function() {
    // Protected routes
});
```

#### 2. **Authorization** ✅
```php
// GOOD: Role-based middleware
public function handle(Request $request, Closure $next, string $role) {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    $userRole = strtolower($user->position->position);
    if ($userRole === $role) {
        return $next($request);
    }
    
    Auth::logout();
    return redirect()->route('login')->with('error', 'Unauthorized');
}
```

#### 3. **CSRF Protection** ✅
```blade
<!-- GOOD: CSRF token in forms -->
<form method="POST">
    @csrf
    @method('PUT')
</form>
```

#### 4. **SQL Injection Prevention** ✅
```php
// GOOD: Using Eloquent (parameterized queries)
User::where('email', $request->email)->first();

// GOOD: Using query builder with bindings
DB::table('users')->where('email', '=', $email)->get();
```

#### 5. **Mass Assignment Protection** ✅
```php
// GOOD: Fillable whitelist
protected $fillable = [
    'name', 'email', 'password', 'position_id', 'identity_id'
];
```

---

### ⚠️ **SECURITY ISSUES (Harus Diperbaiki!)**

#### 1. **No Rate Limiting** ❌
```php
// MISSING: Login throttling
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1'); // Max 5 attempts per minute
```

#### 2. **Weak Password Policy** ❌
```php
// CURRENT: Only min 8 chars
'password' => 'required|string|min:8|confirmed'

// BETTER: Strong password rules
'password' => [
    'required',
    'string',
    'min:8',
    'confirmed',
    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
]
```

#### 3. **No Email Verification** ⚠️
```php
// CURRENT: Auto-verified
'email_verified_at' => now()

// BETTER: Send verification email
Mail::to($user->email)->send(new VerifyEmail($user));
```

#### 4. **Exposed Sensitive Data** ⚠️
```php
// BAD: Returning all user data
return User::all(); // Includes password hash!

// GOOD: Hide sensitive fields
protected $hidden = ['password', 'remember_token'];

// BETTER: Use API Resources
class UserResource extends JsonResource {
    public function toArray($request) {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }
}
```

#### 5. **No Input Sanitization** ⚠️
```php
// BAD: Direct output
{{ $user->name }} // XSS vulnerable if name contains <script>

// GOOD: Blade auto-escapes
{{ $user->name }} // Safe in Blade

// BETTER: Sanitize on input
'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/'
```

#### 6. **Missing HTTPS Enforcement** ❌
```php
// MISSING in .env
APP_URL=https://klinik.amikom.ac.id
FORCE_HTTPS=true

// MISSING in AppServiceProvider
if (config('app.force_https')) {
    URL::forceScheme('https');
}
```

#### 7. **No API Token/Session Security** ⚠️
```php
// MISSING: Secure session config
// config/session.php
'secure' => env('SESSION_SECURE_COOKIE', true), // HTTPS only
'http_only' => true, // No JavaScript access
'same_site' => 'strict', // CSRF protection
```

#### 8. **Predictable IDs** ⚠️
```php
// CURRENT: Auto-increment IDs exposed in URLs
/admin/users/1
/admin/users/2

// BETTER: Use UUID or kode
/admin/users/ADM0001
/admin/pasien/P0123

// ALREADY IMPLEMENTED for pasien (kode_pasien) ✅
```

#### 9. **No Backup Strategy** ❌
```bash
# MISSING: Automated database backup
# Should have cron job:
0 2 * * * cd /path/to/app && php artisan backup:run
```

#### 10. **Debug Mode in Production** ❌
```env
# DANGEROUS if true in production!
APP_DEBUG=false  # Must be false in production
APP_ENV=production
```

---

## 📋 Security Checklist

### Critical (Must Fix Before Production)
- [ ] Enable rate limiting on login
- [ ] Enforce HTTPS
- [ ] Set `APP_DEBUG=false` in production
- [ ] Implement strong password policy
- [ ] Add email verification
- [ ] Configure secure session cookies
- [ ] Setup automated backups
- [ ] Add activity logging

### Important (Should Fix Soon)
- [ ] Implement API resources for data exposure
- [ ] Add input sanitization rules
- [ ] Use UUID for sensitive resources
- [ ] Add 2FA for admin accounts
- [ ] Implement password reset flow
- [ ] Add CORS configuration
- [ ] Setup monitoring & alerts

### Nice to Have
- [ ] Add API rate limiting
- [ ] Implement IP whitelisting for admin
- [ ] Add file upload validation
- [ ] Setup intrusion detection
- [ ] Add database encryption

---

## 🎯 Overall Assessment

### Business Logic: **8/10** ✅
- Schema sudah bagus untuk klinik dasar
- Perlu tambahan: antrian, inventory history, audit log

### Clean Code: **7/10** ⚠️
- Structure bagus, tapi ada duplicate code
- Perlu: Service classes, Scopes, Constants
- Type hints masih kurang konsisten

### Security: **6/10** ⚠️
- Basic security sudah ada (auth, CSRF, SQL injection)
- **CRITICAL MISSING:** Rate limiting, HTTPS, strong password
- Perlu: Email verification, activity log, backup

---

## 🚀 Rekomendasi Prioritas

### **Priority 1 (Before Production)**
1. Set `APP_DEBUG=false`
2. Enable HTTPS & force scheme
3. Add rate limiting on login
4. Strong password validation
5. Secure session configuration

### **Priority 2 (Next Sprint)**
1. Email verification
2. Activity logging
3. Automated backups
4. Service layer refactoring
5. Add constants for magic strings

### **Priority 3 (Future Enhancement)**
1. Appointment system
2. Inventory tracking
3. Detailed billing
4. 2FA for admin
5. API resources

---

**Kesimpulan:** Sistem sudah **cukup baik** untuk development/testing, tapi **BELUM SIAP PRODUCTION** tanpa perbaikan security critical! 🔒
