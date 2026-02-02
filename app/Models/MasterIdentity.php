<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterIdentity extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_identity';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identity_number',
        'identity_type',
        'name',
        'gender',
        'address',
    ];

    /**
     * Get the users with this identity.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'identity_id');
    }

    /**
     * Get the pasien records with this identity.
     */
    public function pasien()
    {
        return $this->hasMany(Pasien::class, 'identity_id');
    }
}
