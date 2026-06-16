<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'application_status_histories';

    protected $fillable = [
        'application_id',
        'old_status',
        'new_status',
        'changed_by',
        'changed_by_type',
        'notes',
    ];

    // =============================================
    // RELATIONSHIPS
    // =============================================

    /**
     * Riwayat ini milik satu pengajuan
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // =============================================
    // ACCESSOR / HELPER
    // =============================================

    /**
     * Label status baru dalam Bahasa Indonesia
     */
    public function getNewStatusLabelAttribute(): string
    {
        $labels = Application::statusList();
        return $labels[$this->new_status]['label'] ?? $this->new_status;
    }

    /**
     * Warna badge untuk status baru
     */
    public function getNewStatusColorAttribute(): string
    {
        $list = Application::statusList();
        return $list[$this->new_status]['color'] ?? 'secondary';
    }

    /**
     * Deskripsi perubahan status
     * Contoh: "Pengajuan diubah dari Menunggu ke Diverifikasi oleh Admin"
     */
    public function getChangeDescriptionAttribute(): string
    {
        $oldLabel = $this->old_status
            ? (Application::statusList()[$this->old_status]['label'] ?? $this->old_status)
            : 'Awal';

        $newLabel = Application::statusList()[$this->new_status]['label']
            ?? $this->new_status;

        $by = $this->changed_by ?? 'Sistem';

        return "Status diubah dari {$oldLabel} ke {$newLabel} oleh {$by}";
    }
}