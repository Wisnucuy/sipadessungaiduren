<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\VillageProfile;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    /**
     * Generate dan tampilkan PDF surat
     */
    public function generate($id)
    {
        // Ambil data pengajuan lengkap
        $application = Application::with([
            'user',
            'letterType',
            'reviewer',
        ])->findOrFail($id);

        // Hanya bisa generate PDF jika status Approved atau Completed
        if (!in_array($application->status, [
            Application::STATUS_APPROVED,
            Application::STATUS_COMPLETED,
        ])) {
            return back()->with('error',
                'PDF hanya bisa digenerate untuk pengajuan yang sudah Disetujui atau Selesai.');
        }

        // Ambil profil desa
        $village = VillageProfile::first();

        if (!$village) {
            return back()->with('error',
                'Profil desa belum diatur. Silakan isi profil desa terlebih dahulu.');
        }

        // Buat nomor surat otomatis
        $nomorSurat = $this->generateNomorSurat($application);

        // Siapkan data untuk template PDF
        $data = [
            'application' => $application,
            'village'     => $village,
            'nomorSurat'  => $nomorSurat,
            'tanggal'     => now()->locale('id')->isoFormat('D MMMM Y'),
            'bulan'       => now()->locale('id')->isoFormat('MMMM'),
            'tahun'       => now()->format('Y'),
        ];

        // Generate PDF dari template Blade
        $pdf = Pdf::loadView('admin.pdf.surat', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont'          => 'serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => false,
                'dpi'                  => 110,
                'enable_css_float'     => true,
                'isJavascriptEnabled'  => false,
                'debugPng'             => false,
                'debugKeepTemp'        => false,
                'debugCss'             => false,
                'logOutputFile'        => null,
            ]);

        // Nama file PDF
        $fileName = 'surat-' . $application->application_number . '.pdf';

        // Stream = tampilkan di browser
        // download = langsung unduh
        return $pdf->stream($fileName);
    }

    /**
     * Generate nomor surat resmi desa
     * Format: 400/DS-SSD/[bulan-romawi]/[tahun]
     */
    private function generateNomorSurat(Application $application): string
    {
        $romanMonths = [
            1  => 'I',    2  => 'II',   3  => 'III',
            4  => 'IV',   5  => 'V',    6  => 'VI',
            7  => 'VII',  8  => 'VIII', 9  => 'IX',
            10 => 'X',    11 => 'XI',   12 => 'XII',
        ];

        $bulan = $romanMonths[now()->month];
        $tahun = now()->year;
        $urut  = str_pad($application->id, 3, '0', STR_PAD_LEFT);

        return "{$urut}/DS-SSD/{$bulan}/{$tahun}";
    }
}