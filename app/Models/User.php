<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nim',
        'angkatan',
        'prodi',
        'email',
        'password',
        'coins',
        'role',
        'is_suspended',
        'suspend_reason', // Tambahkan ini
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_suspended' => 'boolean',
        ];
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public static function getProdiList()
    {
        return [
            '1' => 'Teknik Mesin Industri',
            '2' => 'Teknik Mekatronika',
            '3' => 'Teknik Perancangan Mekanik dan Mesin',
            '4' => 'Rekayasa Teknologi Manufaktur',
            '5' => 'Perancangan Manufaktur',
            '6' => 'Teknologi Rekayasa Mekatronika',
            '7' => 'Teknologi Rekayasa Informatika Industri',
        ];
    }
}