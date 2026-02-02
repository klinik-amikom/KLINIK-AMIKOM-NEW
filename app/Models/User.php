<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identity_id',
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'position_id',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the position/role of the user.
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get the master identity of the user.
     */
    public function identity()
    {
        return $this->belongsTo(MasterIdentity::class, 'identity_id');
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->position && $this->position->code === 'ADM';
    }

    /**
     * Check if user is dokter.
     */
    public function isDokter(): bool
    {
        return $this->position && $this->position->code === 'DOK';
    }

    /**
     * Check if user is apoteker.
     */
    public function isApoteker(): bool
    {
        return $this->position && $this->position->code === 'APT';
    }

    /**
     * Get role name for backward compatibility.
     */
    public function getRoleAttribute(): string
    {
        return $this->position ? strtolower($this->position->position) : 'unknown';
    }
}

