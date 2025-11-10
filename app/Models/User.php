<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean'
    ];

    // Roles
    const ROLE_ADMIN = 'admin';
    const ROLE_DOKTER = 'dokter';
    const ROLE_PERAWAT = 'perawat';
    const ROLE_REGISTRASI = 'registrasi';

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isDokter()
    {
        return $this->role === self::ROLE_DOKTER;
    }

    public function isPerawat()
    {
        return $this->role === self::ROLE_PERAWAT;
    }

    public function isRegistrasi()
    {
        return $this->role === self::ROLE_REGISTRASI;
    }

    public function isActive()
    {
        return $this->is_active;
    }

    // Relasi dengan visits jika diperlukan
    public function visits()
    {
        return $this->hasMany(Visits::class);
    }
}