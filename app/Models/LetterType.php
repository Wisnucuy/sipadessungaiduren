<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    use HasFactory;

    protected $table = 'letter_types';

    protected $fillable = [
        'name',
        'description',
        'requirements',
        'processing_time',
        'template_content',
        'is_active',
    ];

    /**
     * Casting tipe data
     * requirements → otomatis diubah dari JSON string ke array PHP
     */
    protected $casts = [
        'requirements' => 'array',
        'is_active'    => 'boolean',
    ];

    // =============================================
    // RELATIONSHIPS
    // =============================================

    /**
     * Satu jenis surat bisa dipakai di banyak pengajuan
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    // =============================================
    // SCOPE (Filter Query)
    // =============================================

    /**
     * Scope untuk mengambil hanya jenis surat yang aktif
     * Penggunaan: LetterType::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}