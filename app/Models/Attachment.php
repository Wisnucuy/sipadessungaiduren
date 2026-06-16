<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments';

    protected $fillable = [
        'application_id',
        'document_type',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
    ];

    // =============================================
    // RELATIONSHIPS
    // =============================================

    /**
     * Dokumen ini milik satu pengajuan
     * Contoh: $attachment->application → data pengajuannya
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // =============================================
    // ACCESSOR / HELPER
    // =============================================

    /**
     * Label nama dokumen dalam Bahasa Indonesia
     * Contoh: $attachment->document_label → "Kartu Tanda Penduduk (KTP)"
     */
    public function getDocumentLabelAttribute(): string
    {
        $labels = [
            'ktp'                  => 'Kartu Tanda Penduduk (KTP)',
            'kk'                   => 'Kartu Keluarga (KK)',
            'surat_pengantar_rt'   => 'Surat Pengantar RT',
            'dokumen_pendukung'    => 'Dokumen Pendukung',
        ];

        return $labels[$this->document_type] ?? ucfirst($this->document_type);
    }

    /**
     * URL lengkap untuk mengakses file
     * Contoh: $attachment->file_url → "http://localhost/storage/attachments/..."
     */
    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Ukuran file dalam format yang mudah dibaca
     * Contoh: $attachment->file_size_formatted → "1.2 MB"
     */
    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' bytes';
    }

    /**
     * Cek apakah file berupa gambar (jpg, jpeg, png)
     */
    public function isImage(): bool
    {
        return in_array($this->mime_type, [
            'image/jpeg',
            'image/jpg',
            'image/png',
        ]);
    }

    /**
     * Cek apakah file berupa PDF
     */
    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }
}