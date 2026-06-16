@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
    body { background: #f0f4f8; }

    .dash-header {
        background: linear-gradient(135deg, #0f2419 0%, #1a3c34 100%);
        padding: 2rem 0 3.5rem;
        color: #fff;
    }

    .dash-header h4 {
        font-weight: 800;
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }

    .dash-header p {
        color: rgba(255,255,255,0.65);
        font-size: 0.875rem;
        margin: 0;
    }

    .btn-ajukan {
        background: rgba(255,255,255,0.12);
        border: 1.5px solid rgba(255,255,255,0.35);
        color: #fff;
        padding: 0.6rem 1.4rem;
        border-radius: 9px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .btn-ajukan:hover {
        background: rgba(255,255,255,0.22);
        color: #fff;
        border-color: rgba(255,255,255,0.6);
    }

    /* ── Stat Cards ──────────────────────────── */
.stats-row {
    margin-top: -2rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    border-radius: 14px;
    padding: 1.25rem 1.1rem;
    color: white;
    position: relative;
    overflow: hidden;
    height: 100%;
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.18);
}

.stat-card .stat-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 3rem;
    opacity: 0.18;
}

.stat-card .num {
    font-size: 2rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 0.35rem;
    position: relative;
    z-index: 1;
}

.stat-card .lbl {
    font-size: 0.75rem;
    font-weight: 500;
    opacity: 0.88;
    position: relative;
    z-index: 1;
}

    /* ── Shortcut ────────────────────────────── */
    .shortcut-card {
        background: #fff;
        border: 1px solid #e8eaed;
        border-radius: 12px;
        padding: 1.1rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.875rem;
        transition: all 0.2s;
        height: 100%;
    }

    .shortcut-card:hover {
        border-color: #1a3c34;
        box-shadow: 0 4px 16px rgba(26,60,52,0.1);
        transform: translateY(-2px);
    }

    .shortcut-icon {
        width: 44px;
        height: 44px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }

    .shortcut-card .sc-title {
        font-weight: 700;
        font-size: 0.875rem;
        color: #1a3c34;
        margin-bottom: 0.1rem;
    }

    .shortcut-card .sc-desc {
        font-size: 0.75rem;
        color: #999;
        margin: 0;
    }

    /* ── Dash Card ───────────────────────────── */
    .dash-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e8eaed;
        box-shadow: 0 1px 8px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .dash-card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fafafa;
    }

    .dash-card-header .title {
        font-weight: 700;
        font-size: 0.9rem;
        color: #1a3c34;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* ── Table ───────────────────────────────── */
    .table th {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #888;
        border-bottom: 1px solid #e8eaed;
        padding: 0.75rem 1rem;
        background: #fafafa;
    }

    .table td {
        font-size: 0.855rem;
        vertical-align: middle;
        padding: 0.75rem 1rem;
        border-color: #f0f0f0;
    }

    .badge {
        font-size: 0.72rem;
        padding: 0.35em 0.75em;
        border-radius: 6px;
        font-weight: 600;
    }

    /* ── Empty State ─────────────────────────── */
    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 2.75rem;
        color: #ddd;
        margin-bottom: 0.75rem;
        display: block;
    }

    .empty-state p {
        font-size: 0.875rem;
        color: #aaa;
        margin: 0;
        line-height: 1.7;
    }
</style>
@endsection

@section('content')

@php $user = Auth::guard('web')->user(); @endphp

{{-- Header ──────────────────────────────── --}}
<div class="dash-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4>Selamat datang, {{ $user->name }}! 👋</h4>
                <p>
                    <i class="bi bi-card-text me-1"></i>
                    NIK: {{ $user->nik }}
                    &nbsp;·&nbsp;
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </p>
            </div>
            <a href="{{ route('warga.applications.create') }}"
               class="btn-ajukan d-none d-md-inline-flex">
                <i class="bi bi-plus-circle"></i>
                Ajukan Surat Baru
            </a>
        </div>
    </div>
</div>

<div class="container pb-5">

    {{-- Stat Cards ───────────────────────────── --}}
<div class="row g-3 stats-row">

    <div class="col-6 col-md-2">
        <div class="stat-card"
             style="background:linear-gradient(135deg,#6366f1,#4f46e5);">
            <i class="bi bi-file-earmark-text stat-icon"></i>
            <div class="num">{{ $stats['total'] }}</div>
            <div class="lbl">Total Pengajuan</div>
        </div>
    </div>

    <div class="col-6 col-md-2">
        <div class="stat-card"
             style="background:linear-gradient(135deg,#f59e0b,#d97706);">
            <i class="bi bi-clock stat-icon"></i>
            <div class="num">{{ $stats['pending'] }}</div>
            <div class="lbl">Menunggu</div>
        </div>
    </div>

    <div class="col-6 col-md-2">
        <div class="stat-card"
             style="background:linear-gradient(135deg,#06b6d4,#0891b2);">
            <i class="bi bi-search stat-icon"></i>
            <div class="num">{{ $stats['verifying'] }}</div>
            <div class="lbl">Diverifikasi</div>
        </div>
    </div>

    <div class="col-6 col-md-2">
        <div class="stat-card"
             style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
            <i class="bi bi-check-circle stat-icon"></i>
            <div class="num">{{ $stats['approved'] }}</div>
            <div class="lbl">Disetujui</div>
        </div>
    </div>

    <div class="col-6 col-md-2">
        <div class="stat-card"
             style="background:linear-gradient(135deg,#ef4444,#dc2626);">
            <i class="bi bi-x-circle stat-icon"></i>
            <div class="num">{{ $stats['rejected'] }}</div>
            <div class="lbl">Ditolak</div>
        </div>
    </div>

    <div class="col-6 col-md-2">
        <div class="stat-card"
             style="background:linear-gradient(135deg,#22c55e,#16a34a);">
            <i class="bi bi-check-all stat-icon"></i>
            <div class="num">{{ $stats['completed'] }}</div>
            <div class="lbl">Selesai</div>
        </div>
    </div>

</div>

    {{-- Shortcut Menu ────────────────────────── --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <a href="{{ route('warga.applications.create') }}"
               class="shortcut-card">
                <div class="shortcut-icon" style="background:#e8f5e9;">
                    <i class="bi bi-plus-circle-fill text-success"></i>
                </div>
                <div>
                    <div class="sc-title">Ajukan Surat</div>
                    <p class="sc-desc">Buat pengajuan baru</p>
                </div>
                <i class="bi bi-chevron-right text-muted ms-auto small"></i>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('warga.applications.index') }}"
               class="shortcut-card">
                <div class="shortcut-icon" style="background:#e8f0fe;">
                    <i class="bi bi-clock-history text-primary"></i>
                </div>
                <div>
                    <div class="sc-title">Riwayat</div>
                    <p class="sc-desc">Semua pengajuan saya</p>
                </div>
                <i class="bi bi-chevron-right text-muted ms-auto small"></i>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('warga.profile.edit') }}"
               class="shortcut-card">
                <div class="shortcut-icon" style="background:#fff8e1;">
                    <i class="bi bi-person-circle text-warning"></i>
                </div>
                <div>
                    <div class="sc-title">Profil Saya</div>
                    <p class="sc-desc">Edit data & password</p>
                </div>
                <i class="bi bi-chevron-right text-muted ms-auto small"></i>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('home') }}" class="shortcut-card">
                <div class="shortcut-icon" style="background:#f3e5f5;">
                    <i class="bi bi-house-fill"
                       style="color:#7b1fa2;"></i>
                </div>
                <div>
                    <div class="sc-title">Beranda</div>
                    <p class="sc-desc">Kembali ke halaman utama</p>
                </div>
                <i class="bi bi-chevron-right text-muted ms-auto small"></i>
            </a>
        </div>

    </div>

    {{-- Pengajuan Terbaru ─────────────────────── --}}
    <div class="dash-card">

        <div class="dash-card-header">
            <div class="title">
                <i class="bi bi-clock-history text-success"></i>
                Pengajuan Terbaru
            </div>
            <a href="{{ route('warga.applications.index') }}"
               class="btn btn-sm btn-outline-success"
               style="font-size:0.78rem;border-radius:7px;">
                Lihat Semua
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        @if($recentApplications->isEmpty())

            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <p>
                    Belum ada pengajuan surat.<br>
                    <span style="font-size:0.8rem;">
                        Klik <strong>Ajukan Surat Baru</strong>
                        di pojok kanan atas untuk memulai.
                    </span>
                </p>
            </div>

        @else

            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No. Pengajuan</th>
                            <th>Jenis Surat</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentApplications as $app)
                        <tr>
                            <td>
                                <span class="fw-semibold"
                                      style="color:#1a3c34;">
                                    {{ $app->application_number }}
                                </span>
                            </td>
                            <td>{{ $app->letterType->name }}</td>
                            <td class="text-muted">
                                {{ $app->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                <span class="badge
                                    bg-{{ $app->status_color }}">
                                    {{ $app->status_label }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route(
                                    'warga.applications.show',
                                    ['id' => $app->id]) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   style="border-radius:7px;
                                          font-size:0.78rem;">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                                @if($app->isEditable())
                                    <a href="{{ route(
                                        'warga.applications.edit',
                                        ['id' => $app->id]) }}"
                                       class="btn btn-sm
                                              btn-outline-warning ms-1"
                                       style="border-radius:7px;
                                              font-size:0.78rem;">
                                        <i class="bi bi-pencil me-1"></i>
                                        Perbaiki
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

    </div>

</div>

@endsection