<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = [
        'application_number',
        'user_id',
        'letter_type_id',
        'status',
        'purpose',
        'applicant_data',
        'notes',
        'reviewed_by',
        'reviewed_at',
        'completed_at',
    ];

    protected $casts = [
        'applicant_data' => 'array',
        'reviewed_at'    => 'datetime',
        'completed_at'   => 'datetime',
    ];

    // =============================================
    // KONSTANTA STATUS
    // =============================================

    const STATUS_PENDING    = 'pending';
    const STATUS_VERIFYING  = 'verifying';
    const STATUS_APPROVED   = 'approved';
    const STATUS_REJECTED   = 'rejected';
    const STATUS_COMPLETED  = 'completed';

    /**
     * Daftar semua status beserta label dan warna badge Bootstrap
     * Dipakai untuk menampilkan badge status di tampilan
     */
    public static function statusList(): array
    {
        return [
            self::STATUS_PENDING   => [
                'label' => 'Menunggu',
                'color' => 'warning',
                'icon'  => 'clock',
            ],
            self::STATUS_VERIFYING => [
                'label' => 'Diverifikasi',
                'color' => 'info',
                'icon'  => 'search',
            ],
            self::STATUS_APPROVED  => [
                'label' => 'Disetujui',
                'color' => 'primary',
                'icon'  => 'check-circle',
            ],
            self::STATUS_REJECTED  => [
                'label' => 'Ditolak',
                'color' => 'danger',
                'icon'  => 'x-circle',
            ],
            self::STATUS_COMPLETED => [
                'label' => 'Selesai',
                'color' => 'success',
                'icon'  => 'check-all',
            ],
        ];
    }

    /**
     * Mengambil label status dalam Bahasa Indonesia
     * Contoh: $application->status_label → "Menunggu"
     */
    public function getStatusLabelAttribute(): string
    {
        return self::statusList()[$this->status]['label'] ?? $this->status;
    }

    /**
     * Mengambil warna badge Bootstrap untuk status
     * Contoh: $application->status_color → "warning"
     */
    public function getStatusColorAttribute(): string
    {
        return self::statusList()[$this->status]['color'] ?? 'secondary';
    }

    // =============================================
    // RELATIONSHIPS
    // =============================================

    /**
     * Pengajuan ini milik satu warga
     * Contoh: $application->user → data warga yang mengajukan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Pengajuan ini untuk satu jenis surat
     * Contoh: $application->letterType → data jenis surat
     */
    public function letterType()
    {
        return $this->belongsTo(LetterType::class);
    }

    /**
     * Pengajuan ini direview oleh satu admin
     * Contoh: $application->reviewer → data admin yang mereview
     */
    public function reviewer()
    {
        return $this->belongsTo(AdminUser::class, 'reviewed_by');
    }

    /**
     * Satu pengajuan bisa punya banyak dokumen lampiran
     * Contoh: $application->attachments → semua dokumen yang diupload
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * Satu pengajuan punya banyak riwayat perubahan status
     * Contoh: $application->statusHistories → timeline status pengajuan
     */
    public function statusHistories()
    {
        return $this->hasMany(ApplicationStatusHistory::class)
                    ->orderBy('created_at', 'asc'); // Urut dari yang paling lama
    }

    // =============================================
    // SCOPE (Filter Query)
    // =============================================

    /**
     * Filter pengajuan berdasarkan status
     * Contoh: Application::byStatus('pending')->get()
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Filter pengajuan berdasarkan jenis surat
     */
    public function scopeByLetterType($query, int $letterTypeId)
    {
        return $query->where('letter_type_id', $letterTypeId);
    }

    /**
     * Pencarian berdasarkan nama warga, NIK, atau nomor pengajuan
     */
    public function scopeSearch($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('application_number', 'like', "%{$keyword}%")
              ->orWhereHas('user', function ($q2) use ($keyword) {
                  $q2->where('name', 'like', "%{$keyword}%")
                     ->orWhere('nik', 'like', "%{$keyword}%");
              });
        });
    }

    // =============================================
    // HELPER METHOD
    // =============================================

    /**
     * Generate nomor pengajuan otomatis
     * Format: SRT-2025-0001
     */
    public static function generateApplicationNumber(): string
    {
        $year  = date('Y');
        $prefix = "SRT-{$year}-";

        // Cari nomor urut terakhir di tahun ini
        $last = self::where('application_number', 'like', $prefix . '%')
                    ->orderBy('application_number', 'desc')
                    ->first();

        if ($last) {
            // Ambil nomor urut dari belakang dan tambah 1
            $lastNumber = (int) substr($last->application_number, -4);
            $newNumber  = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // Format jadi 4 digit: 0001, 0002, dst
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Cek apakah pengajuan bisa diedit oleh warga
     * Hanya bisa diedit jika status Rejected
     */
    public function isEditable(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Cek apakah pengajuan bisa dihapus oleh warga.
     * Hanya pengajuan yang masih berstatus Menunggu yang boleh dihapus.
     */
    public function isDeletable(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }
}