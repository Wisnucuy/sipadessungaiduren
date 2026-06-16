<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageProfile extends Model
{
    use HasFactory;

    protected $table = 'village_profiles';

    protected $fillable = [
        'village_name',
        'address',
        'phone',
        'email',
        'headman_name',
        'logo',
        'description',
    ];

    // =============================================
    // ACCESSOR / HELPER
    // =============================================

    /**
     * Mengambil URL logo desa
     * Jika logo ada → tampilkan dari storage
     * Jika tidak ada → tampilkan gambar default
     */
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }

        return asset('images/default-logo.png');
    }
}