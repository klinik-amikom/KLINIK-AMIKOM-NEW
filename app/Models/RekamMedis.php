<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekamMedis extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rekam_medis';

    protected $fillable = [
        'kode_rekam_medis',
        'pasien_id',
        'dokter_id',
        'tanggal_periksa',
        'diagnosis',
        'catatan',
        'status'
    ];

    protected $casts = [
        'tanggal_periksa' => 'date',
        'obat' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke tabel pasien
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    /**
     * Relasi ke tabel users sebagai dokter
     */
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function resepObat()
    {
        return $this->hasMany(ResepObat::class, 'rekam_medis_id');
    }

}