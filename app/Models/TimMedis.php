<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimMedis extends Model
{
    protected $fillable = [
        'name',
        'deskripsi',
        'gambar'
    ];

    public $timestamps = false;
}