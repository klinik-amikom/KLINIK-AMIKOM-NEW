<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    protected $table = 'jadwal_dokter';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'nama_dokter',
        'poli',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];
}
