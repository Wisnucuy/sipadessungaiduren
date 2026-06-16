@extends('layouts.app')

@section('title', 'Detail Pengajuan')
@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('warga.dashboard') }}">Dashboard</a>
    </div>
    <div class="breadcrumb-item">
        <a href="{{ route('warga.applications.index') }}">Riwayat</a>
    </div>
    <div class="breadcrumb-item active">
        {{ $application->application_number }}
    </div>
@endsection

@section('content')
<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-lg-9">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Detail Pengajuan</h4>
                    <p class="text-muted mb-0">
                        No. Pengajuan:
                        <strong class="text-primary">
                            {{ $application->application_number }}
                        </strong>
                    </p>
                </div>
                <div class="d-flex gap-2">
                    @if($application->isEditable())
                        <a href="{{ route('warga.applications.edit', $application->id) }}"
                           class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i>Perbaiki
                        </a>
                    @endif
                    <a href="{{ route('warga.applications.index') }}"
                       class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            {{-- Status Banner --}}
            <div class="alert alert-{{ $application->status_color }} mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div style="font-size:2.5rem;">
                        @switch($application->status)
                            @case('pending')   🕐 @break
                            @case('verifying') 🔍 @break
                            @case('approved')  ✅ @break
                            @case('rejected')  ❌ @break
                            @case('completed') 🎉 @break
                        @endswitch
                    </div>
                    <div>
                        <div class="fw-bold fs-5">{{ $application->status_label }}</div>
                        <div class="small">
                            @switch($application->status)
                                @case('pending')
                                    Pengajuan Anda sedang menunggu untuk diverifikasi oleh perangkat desa.
                                    @break
                                @case('verifying')
                                    Pengajuan Anda sedang diperiksa oleh perangkat desa.
                                    @break
                                @case('approved')
                                    Pengajuan Anda telah disetujui dan surat sedang disiapkan.
                                    @break
                                @case('rejected')
                                    Pengajuan Anda ditolak. Silakan perbaiki data atau dokumen.
                                    @break
                                @case('completed')
                                    Surat Anda telah selesai. Silakan ambil di kantor desa.
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>

                {{-- Catatan penolakan --}}
                @if($application->status === 'rejected' && $application->notes)
                    <hr>
                    <div class="fw-semibold small">
                        <i class="bi bi-chat-left-text me-1"></i>
                        Catatan dari Admin:
                    </div>
                    <div class="small mt-1">{{ $application->notes }}</div>
                @endif
            </div>

            <div class="row g-4">

                {{-- Kolom kiri: Info Pengajuan + Dokumen --}}
                <div class="col-md-7">

                    {{-- Info Pengajuan --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            Informasi Pengajuan
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0 small">
                                <tr>
                                    <td class="text-muted fw-semibold" width="40%">
                                        No. Pengajuan
                                    </td>
                                    <td>{{ $application->application_number }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Jenis Surat</td>
                                    <td>{{ $application->letterType->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Keperluan</td>
                                    <td>{{ $application->purpose }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Tanggal Pengajuan</td>
                                    <td>
                                        {{ $application->created_at->format('d F Y, H:i') }} WIB
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Status</td>
                                    <td>
                                        <span class="badge bg-{{ $application->status_color }}">
                                            {{ $application->status_label }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Dokumen yang Diupload --}}
                    <div class="card">
                        <div class="card-header">
                            <i class="bi bi-paperclip me-2"></i>
                            Dokumen yang Diupload
                        </div>
                        <div class="card-body p-0">
                            @foreach($application->attachments as $attachment)
                                <div class="d-flex align-items-center justify-content-between
                                            px-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi {{ $attachment->isPdf()
                                            ? 'bi-file-earmark-pdf text-danger'
                                            : 'bi-file-image text-primary' }} fs-5"></i>
                                        <div>
                                            <div class="small fw-semibold">
                                                {{ $attachment->document_label }}
                                            </div>
                                            <div class="text-muted" style="font-size:0.75rem;">
                                                {{ $attachment->file_name }}
                                                · {{ $attachment->file_size_formatted }}
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ $attachment->file_url }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>Lihat
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- Kolom kanan: Timeline Status --}}
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <i class="bi bi-clock-history me-2"></i>
                            Riwayat Status
                        </div>
                        <div class="card-body">
                            @forelse($application->statusHistories as $history)
                                <div class="d-flex gap-3 {{ !$loop->last ? 'mb-3' : '' }}">
                                    {{-- Garis timeline --}}
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="rounded-circle bg-{{ $history->new_status_color }}
                                                    d-flex align-items-center justify-content-center"
                                             style="width:32px;height:32px;min-width:32px;">
                                            <i class="bi bi-check text-white small"></i>
                                        </div>
                                        @if(!$loop->last)
                                            <div style="width:2px;flex:1;
                                                        background:#e0e0e0;
                                                        min-height:24px;
                                                        margin:4px 0;">
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Konten --}}
                                    <div class="pb-2">
                                        <div class="fw-semibold small">
                                            {{ $history->new_status_label }}
                                        </div>
                                        @if($history->notes)
                                            <div class="text-muted small">
                                                {{ $history->notes }}
                                            </div>
                                        @endif
                                        <div class="text-muted" style="font-size:0.75rem;">
                                            {{ $history->created_at->format('d/m/Y H:i') }}
                                            · {{ $history->changed_by }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted small text-center mb-0">
                                    Belum ada riwayat status.
                                </p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection