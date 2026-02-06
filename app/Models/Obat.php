<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obat extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel yang dikaitkan dengan model.
     * * @var string
     */
    protected $table = 'obat';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Pastikan 'deskripsi' masuk di sini agar bisa disimpan via Controller.
     * * @var array<int, string>
     */
    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'stok',
        'harga',
        'tanggal_kadaluarsa',
        'deskripsi',
    ];

    /**
     * Casting atribut ke tipe data tertentu.
     * Menambahkan 'tanggal_kadaluarsa' agar otomatis menjadi objek Carbon.
     * * @var array<string, string>
     */
    protected $casts = [
        'stok' => 'integer',
        'harga' => 'decimal:2',
        'tanggal_kadaluarsa' => 'date:Y-m-d',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Tabel ResepObat.
     */
    public function resepObat()
    {
        return $this->hasMany(ResepObat::class, 'obat_id');
    }

    /**
     * Aksesor opsional: Mengecek apakah obat sudah kadaluarsa.
     * Bisa digunakan di View seperti: $obat->is_expired
     */
    public function getIsExpiredAttribute()
    {
        if (!$this->tanggal_kadaluarsa) return false;
        return $this->tanggal_kadaluarsa->isPast();
    }
}