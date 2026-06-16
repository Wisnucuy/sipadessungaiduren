<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminUser extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nama tabel yang digunakan model ini
     * Perlu ditulis karena nama tabel tidak mengikuti konvensi Laravel
     */
    protected $table = 'admin_users';

    /**
     * Kolom yang boleh diisi massal
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Kolom yang disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // =============================================
    // RELATIONSHIPS
    // =============================================

    /**
     * Satu admin bisa mereview banyak pengajuan
     * Contoh: $admin->reviewedApplications → semua pengajuan yang direview admin ini
     */
    public function reviewedApplications()
    {
        return $this->hasMany(Application::class, 'reviewed_by');
    }
}