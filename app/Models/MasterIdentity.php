<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterIdentity extends Model
{
    use SoftDeletes;

    protected $table = 'master_identity';

    protected $fillable = [
        'identity_number',
        'identity_type',
        'name',
        'birth_date',
        'no_telp',
        'gender',
        'address',
    ];

    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'identity_id');
    }

}