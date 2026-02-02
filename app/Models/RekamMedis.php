<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekamMedis extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rekam_medis'; // Fixed: was 'tabel_rekam_medis'

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_rekam_medis',
        'pasien_id',
        'dokter_id',
        'tanggal_periksa',
        'diagnosis',
        'catatan',
        'biaya_pemeriksaan',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_periksa' => 'date',
        'biaya_pemeriksaan' => 'decimal:2',
    ];

    /**
     * Get the pasien (patient) for this medical record.
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    /**
     * Get the dokter (doctor) for this medical record.
     */
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    /**
     * Alias for dokter relationship.
     */
    public function user()
    {
        return $this->dokter();
    }

    /**
     * Get the resep obat (medicine prescriptions) for this medical record.
     */
    public function resepObat()
    {
        return $this->hasMany(ResepObat::class, 'rekam_medis_id');
    }

    /**
     * Get the transaksi (transaction) for this medical record.
     */
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'rekam_medis_id');
    }
}
