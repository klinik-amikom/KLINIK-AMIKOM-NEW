<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKlinik extends Model
{
    protected $table = 'jadwal_klinik';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'hari',
        'jam_buka'  // sebelumnya jam_praktik
    ];
}