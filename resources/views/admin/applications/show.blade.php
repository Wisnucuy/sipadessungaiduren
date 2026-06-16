@extends('layouts.admin')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail Pengajuan')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.applications.index') }}">Daftar Pengajuan</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $application->application_number }}
    </li>
@endsection

@section('content')

<div class="row g-4">

    {{-- ══ KOLOM KIRI ══════════════════════════════ --}}
    <div class="col-lg-8">

        {{-- Info Warga ──────────────────────────── --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <i class="bi bi-person me-2"></i>Data Pemohon
                </span>
                <span class="badge bg-{{ $application->status_color }} fs-6">
                    {{ $application->status_label }}
                </span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small text-muted fw-semibold">
                            NAMA LENGKAP
                        </label>
                        <p class="mb-0 fw-semibold">
                            {{ $application->user->name }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted fw-semibold">NIK</label>
                        <p class="mb-0 fw-semibold">
                            {{ $application->user->nik }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted fw-semibold">
                            NO. HP / WHATSAPP
                        </label>
                        <p class="mb-0">
                            {{ $application->user->phone ?? '-' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted fw-semibold">EMAIL</label>
                        <p class="mb-0">
                            {{ $application->user->email ?? '-' }}
                        </p>
                    </div>
                    <div class="col-12">
                        <label class="form-label small text-muted fw-semibold">ALAMAT</label>
                        <p class="mb-0">{{ $application->user->address }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Info Pengajuan ───────────────────────── --}}
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-file-earmark-text me-2"></i>Detail Pengajuan
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small text-muted fw-semibold">
                            NO. PENGAJUAN
                        </label>
                        <p class="mb-0 fw-bold text-primary">
                            {{ $application->application_number }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted fw-semibold">
                            JENIS SURAT
                        </label>
                        <p class="mb-0 fw-semibold">
                            {{ $application->letterType->name }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted fw-semibold">
                            TANGGAL PENGAJUAN
                        </label>
                        <p class="mb-0">
                            {{ $application->created_at->format('d F Y, H:i') }} WIB
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted fw-semibold">
                            ESTIMASI PROSES
                        </label>
                        <p class="mb-0">
                            {{ $application->letterType->processing_time }}
                        </p>
                    </div>
                    <div class="col-12">
                        <label class="form-label small text-muted fw-semibold">
                            KEPERLUAN SURAT
                        </label>
                        <div class="p-3 bg-light rounded">
                            {{ $application->purpose }}
                        </div>
                    </div>

                    {{-- Catatan admin jika ada --}}
                    @if($application->notes)
                        <div class="col-12">
                            <label class="form-label small text-muted fw-semibold">
                                CATATAN ADMIN
                            </label>
                            <div class="p-3 bg-warning bg-opacity-10
                                        border border-warning rounded">
                                {{ $application->notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Dokumen Lampiran ─────────────────────── --}}
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-paperclip me-2"></i>
                Dokumen yang Diupload
                <span class="badge bg-secondary ms-2">
                    {{ $application->attachments->count() }} file
                </span>
            </div>
            <div class="card-body">
                @if($application->attachments->isEmpty())
                    <p class="text-muted small mb-0">Tidak ada dokumen.</p>
                @else
                    <div class="row g-3">
                        @foreach($application->attachments as $attachment)
                            <div class="col-md-6">
                                <div class="border rounded p-3">
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="bi {{ $attachment->isPdf()
                                            ? 'bi-file-earmark-pdf text-danger'
                                            : 'bi-file-image text-primary' }}
                                            fs-3"></i>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="fw-semibold small">
                                                {{ $attachment->document_label }}
                                            </div>
                                            <div class="text-muted"
                                                 style="font-size:0.75rem;">
                                                {{ Str::limit($attachment->file_name, 25) }}
                                            </div>
                                            <div class="text-muted"
                                                 style="font-size:0.75rem;">
                                                {{ $attachment->file_size_formatted }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ $attachment->file_url }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-primary w-100">
                                            <i class="bi bi-eye me-1"></i>
                                            Lihat Dokumen
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- ══ KOLOM KANAN ═════════════════════════════ --}}
    <div class="col-lg-4">

    <div class="card-body">

    {{-- ── Tombol Generate PDF ─────────────── --}}
        @if(in_array($application->status, ['approved', 'completed']))
            <a href="{{ route('admin.applications.pdf',
                    ['id' => $application->id]) }}"
            target="_blank"
            class="btn btn-danger w-100 mb-3">
                <i class="bi bi-file-earmark-pdf me-2"></i>
                Generate & Cetak PDF
            </a>
            <hr>
        @endif

        {{-- Aksi Admin ──────────────────────────── --}}
        

    {{-- ... sisa tombol aksi ... --}}
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-gear me-2"></i>Aksi Admin
            </div>
            <div class="card-body">

                {{-- PENDING → VERIFYING --}}
                @if($application->status === 'pending')
                    <form action="{{ route('admin.applications.verify',
                                   ['id' => $application->id]) }}"
                          method="POST" class="mb-2">
                        @csrf
                        <button type="submit"
                                class="btn btn-info w-100 text-white"
                                onclick="return confirm('Mulai verifikasi pengajuan ini?')">
                            <i class="bi bi-search me-2"></i>
                            Mulai Verifikasi
                        </button>
                    </form>
                @endif

                {{-- VERIFYING → APPROVED --}}
                @if($application->status === 'verifying')
                    <form action="{{ route('admin.applications.approve',
                                   ['id' => $application->id]) }}"
                          method="POST" class="mb-2">
                        @csrf
                        <div class="mb-2">
                            <textarea
                                class="form-control form-control-sm"
                                name="notes"
                                rows="2"
                                placeholder="Catatan persetujuan (opsional)...">
                            </textarea>
                        </div>
                        <button type="submit"
                                class="btn btn-primary w-100"
                                onclick="return confirm('Setujui pengajuan ini?')">
                            <i class="bi bi-check-circle me-2"></i>
                            Setujui Pengajuan
                        </button>
                    </form>
                @endif

                {{-- APPROVED → COMPLETED --}}
                @if($application->status === 'approved')
                    <form action="{{ route('admin.applications.complete',
                                   ['id' => $application->id]) }}"
                          method="POST" class="mb-2">
                        @csrf
                        <button type="submit"
                                class="btn btn-success w-100"
                                onclick="return confirm('Tandai pengajuan ini selesai?')">
                            <i class="bi bi-check-all me-2"></i>
                            Tandai Selesai
                        </button>
                    </form>
                @endif

                {{-- REJECT (Pending atau Verifying) --}}
                @if(in_array($application->status, ['pending', 'verifying']))
                    <hr>
                    <form action="{{ route('admin.applications.reject',
                                   ['id' => $application->id]) }}"
                          method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label small fw-semibold text-danger">
                                Catatan Penolakan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea
                                class="form-control form-control-sm
                                       @error('notes') is-invalid @enderror"
                                name="notes"
                                rows="3"
                                placeholder="Jelaskan alasan penolakan secara detail..."
                                required
                            ></textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit"
                                class="btn btn-danger w-100"
                                onclick="return confirm('Tolak pengajuan ini?')">
                            <i class="bi bi-x-circle me-2"></i>
                            Tolak Pengajuan
                        </button>
                    </form>
                @endif

                {{-- Status Completed --}}
                @if($application->status === 'completed')
                    <div class="text-center py-3">
                        <i class="bi bi-check-circle-fill text-success"
                           style="font-size:2.5rem;"></i>
                        <p class="mt-2 mb-0 fw-semibold text-success">
                            Pengajuan Selesai
                        </p>
                        <p class="small text-muted">
                            Selesai pada:
                            {{ $application->completed_at?->format('d/m/Y H:i') }}
                        </p>
                    </div>
                @endif

                {{-- Status Rejected --}}
                @if($application->status === 'rejected')
                    <div class="text-center py-3">
                        <i class="bi bi-x-circle-fill text-danger"
                           style="font-size:2.5rem;"></i>
                        <p class="mt-2 mb-0 fw-semibold text-danger">
                            Pengajuan Ditolak
                        </p>
                        <p class="small text-muted">
                            Menunggu warga memperbaiki dokumen.
                        </p>
                    </div>
                @endif

            </div>
        </div>

        {{-- Notifikasi WhatsApp ──────────────────── --}}
        @if($application->user->phone &&
            in_array($application->status,
                ['approved','rejected','completed']))
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-whatsapp text-success me-2"></i>
                    Kirim Notifikasi WhatsApp
                </div>
                <div class="card-body">
                    @php
                        $phone   = preg_replace('/^0/', '62',
                                      $application->user->phone);
                        $name    = $application->user->name;
                        $surat   = $application->letterType->name;
                        $notes   = $application->notes ?? '';

                        $messages = [
                            'approved'  => urlencode(
                                "Halo {$name}, pengajuan {$surat} Anda telah *disetujui* "
                                ."dan sedang diproses oleh pihak Desa Simpang Sungai Duren."
                            ),
                            'rejected'  => urlencode(
                                "Halo {$name}, pengajuan {$surat} Anda *ditolak* "
                                ."karena: {$notes}. "
                                ."Silakan perbaiki data atau dokumen melalui sistem."
                            ),
                            'completed' => urlencode(
                                "Halo {$name}, surat {$surat} Anda telah *selesai diproses*. "
                                ."Silakan mengambil surat di kantor desa."
                            ),
                        ];

                        $message = $messages[$application->status] ?? '';
                    @endphp

                    @if($message)
                        <p class="small text-muted mb-3">
                            Klik tombol di bawah untuk mengirim
                            notifikasi via WhatsApp ke warga.
                        </p>
                        <a href="https://wa.me/{{ $phone }}?text={{ $message }}"
                           target="_blank"
                           class="btn btn-success w-100">
                            <i class="bi bi-whatsapp me-2"></i>
                            Kirim WhatsApp ke Warga
                        </a>
                        <div class="mt-2 small text-muted">
                            No. HP: {{ $application->user->phone }}
                        </div>
                    @endif

                </div>
            </div>
        @endif

        {{-- Timeline Status ─────────────────────── --}}
        <div class="card">
            <div class="card-header">
                <i class="bi bi-clock-history me-2"></i>Riwayat Status
            </div>
            <div class="card-body">
                @forelse($application->statusHistories as $history)
                    <div class="d-flex gap-3
                                {{ !$loop->last ? 'mb-3' : '' }}">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle
                                        bg-{{ $history->new_status_color }}
                                        d-flex align-items-center
                                        justify-content-center"
                                 style="width:28px;height:28px;min-width:28px;">
                                <i class="bi bi-check text-white"
                                   style="font-size:0.7rem;"></i>
                            </div>
                            @if(!$loop->last)
                                <div style="width:2px;flex:1;
                                            background:#e0e0e0;
                                            min-height:20px;
                                            margin:3px 0;">
                                </div>
                            @endif
                        </div>
                        <div class="pb-1">
                            <div class="fw-semibold small">
                                {{ $history->new_status_label }}
                            </div>
                            @if($history->notes)
                                <div class="text-muted small">
                                    {{ $history->notes }}
                                </div>
                            @endif
                            <div class="text-muted"
                                 style="font-size:0.72rem;">
                                {{ $history->created_at->format('d/m/Y H:i') }}
                                · {{ $history->changed_by }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small text-center mb-0">
                        Belum ada riwayat.
                    </p>
                @endforelse
            </div>
        </div>

    </div>

</div>

@endsection