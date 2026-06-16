<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi massal (mass assignment)
     */
    protected $fillable = [
        'nik',
        'name',
        'email',
        'phone',
        'address',
        'password',
    ];

    /**
     * Kolom yang disembunyikan saat data diubah ke JSON/array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data kolom
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // =============================================
    // RELATIONSHIPS
    // =============================================

    /**
     * Satu warga bisa punya banyak pengajuan surat
     * Contoh: $user->applications → mengambil semua pengajuan warga ini
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}