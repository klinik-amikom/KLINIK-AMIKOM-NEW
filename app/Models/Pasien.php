<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pasien';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identity_id',
        'kode_pasien',
        'poli',
        'queue_number',
        'estimasi_jam',
        'visit_date',
        'status',
        'tensi',
        'berat_badan',
        'tinggi_badan',
        'keluhan',
    ];

    /**
     * Get the master identity for this patient.
     */
    public function identity()
    {
        return $this->belongsTo(MasterIdentity::class, 'identity_id');
    }

    /**
     * Get the rekam medis records for this patient.
     */
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'pasien_id');
    }
}
