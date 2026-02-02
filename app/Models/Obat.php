<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obat extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'obat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'stok' => 'integer',
        'harga' => 'decimal:2',
        'tanggal_kadaluarsa' => 'date',
    ];

    /**
     * Get the resep obat records for this medicine.
     */
    public function resepObat()
    {
        return $this->hasMany(ResepObat::class, 'obat_id');
    }
}

