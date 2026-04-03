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
        'email',
        'birth_date',
        'gender',
        'no_telp',
        'address',
    ];

    public function pasien()
    {
        return $this->hasMany(Pasien::class, 'identity_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'identity_id');
    }
}
