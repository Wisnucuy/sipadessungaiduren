@extends('layouts.app')

@section('title', 'Beranda — Pelayanan Surat Desa Simpang Sungai Duren')

@section('styles')
<style>

    /* ── Navbar override ─────────────────────────── */
    .navbar { position: relative; z-index: 10; }

    /* ── Hero ───────────────────────────────────── */
    .hero-section {
        position: relative;
        min-height: 82vh;
        display: flex;
        align-items: center;
    }

    .hero-bg {
        position: absolute;
        inset: 0;
        background-image: url('{{ asset("images/kantor-desa.jpg") }}');
        background-size: cover;
        background-position: center center;
        z-index: 0;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            105deg,
            rgba(15,40,28,0.92) 0%,
            rgba(26,60,52,0.80) 45%,
            rgba(26,60,52,0.35) 100%
        );
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        width: 100%;
        padding: 80px 0 80px;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255,255,255,0.10);
        border: 1px solid rgba(255,255,255,0.22);
        color: #fff;
        padding: 0.4rem 1.1rem;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        margin-bottom: 1.75rem;
        backdrop-filter: blur(8px);
    }

    .hero-title {
        font-size: 3.4rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.12;
        margin-bottom: 1.25rem;
        text-shadow: 0 2px 16px rgba(0,0,0,0.35);
    }

    .hero-title span { color: #74c69d; }

    .hero-subtitle {
        color: rgba(255,255,255,0.78);
        font-size: 1.05rem;
        line-height: 1.8;
        margin-bottom: 2.5rem;
        max-width: 480px;
    }

    .btn-hero-primary {
        background: #40916c;
        border: none;
        color: #fff;
        padding: 0.8rem 2.2rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        box-shadow: 0 4px 20px rgba(64,145,108,0.45);
    }

    .btn-hero-primary:hover {
        background: #2d6a4f;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(64,145,108,0.5);
    }

    .btn-hero-outline {
        background: transparent;
        border: 2px solid rgba(255,255,255,0.55);
        color: #fff;
        padding: 0.8rem 2.2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .btn-hero-outline:hover {
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.9);
        color: #fff;
    }


    /* ── Stat Bar ────────────────────────────────── */
    .stat-bar {
        background: #fff;
        border-bottom: 1px solid #e8eaed;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 1.25rem 1.5rem;
    }

    .stat-item + .stat-item {
        border-left: 1px solid #e8eaed;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .stat-number {
        font-size: 1.7rem;
        font-weight: 800;
        line-height: 1;
        color: #1a3c34;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #888;
        margin-top: 3px;
    }

    /* ── Section title ───────────────────────────── */
    .sec-title {
        font-size: 1.85rem;
        font-weight: 800;
        color: #1a3c34;
        margin-bottom: 0.5rem;
    }

    .sec-sub {
        color: #6c757d;
        font-size: 0.95rem;
    }

    /* ── Feature Card ────────────────────────────── */
    .feat-card {
        background: #fff;
        border: 1px solid #e8eaed;
        border-radius: 16px;
        padding: 1.75rem 1.5rem;
        height: 100%;
        transition: all 0.25s;
        position: relative;
        overflow: hidden;
    }

    .feat-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg,#52b788,#2d6a4f);
        opacity: 0;
        transition: opacity 0.25s;
    }

    .feat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 36px rgba(0,0,0,0.09);
        border-color: #b7e4c7;
    }

    .feat-card:hover::after { opacity: 1; }

    .feat-icon {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 1.1rem;
    }

    .feat-title {
        font-weight: 700;
        color: #1a3c34;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .feat-desc {
        font-size: 0.855rem;
        color: #6c757d;
        line-height: 1.65;
        margin: 0;
    }

    /* ── Letter Card ─────────────────────────────── */
    .letter-card {
        background: #fff;
        border: 1px solid #e8eaed;
        border-radius: 12px;
        padding: 1rem 1.2rem;
        height: 100%;
        transition: all 0.2s;
    }

    .letter-card:hover {
        border-color: #74c69d;
        box-shadow: 0 4px 18px rgba(82,183,136,0.13);
    }

    .letter-num {
        width: 30px;
        height: 30px;
        background: #d8f3dc;
        color: #2d6a4f;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.78rem;
        flex-shrink: 0;
    }

    /* ── Step ────────────────────────────────────── */
    .step-circle {
        width: 68px;
        height: 68px;
        background: linear-gradient(135deg,#52b788,#1a3c34);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0 auto 1.1rem;
        box-shadow: 0 8px 24px rgba(82,183,136,0.35);
    }

    /* ── Info Card ───────────────────────────────── */
    .info-card {
        background: #fff;
        border: 1px solid #e8eaed;
        border-radius: 14px;
        padding: 1.5rem;
        text-align: center;
        height: 100%;
    }

    .info-card i {
        font-size: 1.75rem;
        margin-bottom: 0.75rem;
        display: block;
    }

    /* ── CTA ─────────────────────────────────────── */
    .cta-wrap {
        background: linear-gradient(135deg,#1a3c34 0%,#40916c 100%);
    }

</style>
@endsection

@section('content')

{{-- ══════════════════════════════════════
     HERO
══════════════════════════════════════ --}}
<div class="hero-section">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-xl-6">

                    <div class="hero-badge">
                        <i class="bi bi-patch-check-fill text-success"></i>
                        Layanan Resmi Desa Simpang Sungai Duren
                    </div>

                    <h1 class="hero-title">
                        Pelayanan Surat Desa<br>
                        <span>Online & Mudah</span>
                    </h1>

                    <p class="hero-subtitle">
                        Ajukan surat keterangan desa dari mana saja
                        tanpa perlu antri. Upload dokumen, pantau status,
                        dan terima notifikasi langsung ke WhatsApp Anda.
                    </p>

                    <div class="d-flex flex-wrap gap-3">
                        @auth('web')
                            <a href="{{ route('warga.dashboard') }}"
                               class="btn-hero-primary">
                                <i class="bi bi-speedometer2"></i>
                                Dashboard Saya
                            </a>
                            <a href="{{ route('warga.applications.create') }}"
                               class="btn-hero-outline">
                                <i class="bi bi-plus-circle"></i>
                                Ajukan Surat
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                               class="btn-hero-primary">
                                <i class="bi bi-person-plus"></i>
                                Daftar Sekarang
                            </a>
                            <a href="{{ route('login') }}"
                               class="btn-hero-outline">
                                <i class="bi bi-box-arrow-in-right"></i>
                                Sudah Punya Akun
                            </a>
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Scroll hint --}}
</div>

{{-- ══════════════════════════════════════
     STAT BAR
══════════════════════════════════════ --}}
@php
    $totalSurat   = \App\Models\Application::count();
    $totalSelesai = \App\Models\Application::where('status','completed')->count();
    $totalJenis   = \App\Models\LetterType::where('is_active',true)->count();
    $totalWarga   = \App\Models\User::count();
@endphp

<div class="stat-bar">
    <div class="container">
        <div class="row g-0">

            <div class="col-md-3">
                <div class="stat-item">
                    <div class="stat-icon" style="background:#d8f3dc;">
                        <i class="bi bi-file-earmark-text text-success"></i>
                    </div>
                    <div>
                        <div class="stat-number">{{ $totalSurat }}</div>
                        <div class="stat-label">Total Pengajuan</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-item">
                    <div class="stat-icon" style="background:#cfe2ff;">
                        <i class="bi bi-check-circle-fill text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-number">{{ $totalSelesai }}</div>
                        <div class="stat-label">Surat Selesai</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-item">
                    <div class="stat-icon" style="background:#fff3cd;">
                        <i class="bi bi-journals text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-number">{{ $totalJenis }}</div>
                        <div class="stat-label">Jenis Layanan</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-item">
                    <div class="stat-icon" style="background:#f8d7da;">
                        <i class="bi bi-people-fill text-danger"></i>
                    </div>
                    <div>
                        <div class="stat-number">{{ $totalWarga }}</div>
                        <div class="stat-label">Warga Terdaftar</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     FITUR LAYANAN
══════════════════════════════════════ --}}
<div class="container py-5">

    <div class="text-center mb-5">
        <h2 class="sec-title">Kenapa Menggunakan Sistem Ini?</h2>
        <p class="sec-sub">
            Dirancang khusus untuk kemudahan warga Desa Simpang Sungai Duren
        </p>
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="feat-card">
                <div class="feat-icon" style="background:#d8f3dc;">
                    <i class="bi bi-laptop text-success"></i>
                </div>
                <div class="feat-title">Ajukan Online</div>
                <p class="feat-desc">
                    Tidak perlu antri di kantor desa. Ajukan surat
                    keterangan langsung dari komputer Anda kapan saja.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feat-card">
                <div class="feat-icon" style="background:#cfe2ff;">
                    <i class="bi bi-search text-primary"></i>
                </div>
                <div class="feat-title">Pantau Status Real-time</div>
                <p class="feat-desc">
                    Lacak status pengajuan dari Menunggu hingga
                    Selesai dengan timeline yang lengkap dan jelas.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feat-card">
                <div class="feat-icon" style="background:#d1f7e8;">
                    <i class="bi bi-whatsapp" style="color:#25d366;"></i>
                </div>
                <div class="feat-title">Notifikasi WhatsApp</div>
                <p class="feat-desc">
                    Terima pemberitahuan status pengajuan langsung
                    ke WhatsApp Anda dari perangkat desa.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feat-card">
                <div class="feat-icon" style="background:#f8d7da;">
                    <i class="bi bi-file-earmark-pdf text-danger"></i>
                </div>
                <div class="feat-title">Surat PDF Resmi</div>
                <p class="feat-desc">
                    Surat digenerate dalam format PDF resmi siap
                    cetak dan ditandatangani kepala desa.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feat-card">
                <div class="feat-icon" style="background:#fff3cd;">
                    <i class="bi bi-upload text-warning"></i>
                </div>
                <div class="feat-title">Upload Dokumen Mudah</div>
                <p class="feat-desc">
                    Upload KTP, KK, Surat Pengantar RT, dan
                    dokumen pendukung dalam format JPG atau PDF.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feat-card">
                <div class="feat-icon" style="background:#d8f3dc;">
                    <i class="bi bi-shield-check text-success"></i>
                </div>
                <div class="feat-title">Aman & Terpercaya</div>
                <p class="feat-desc">
                    Data dan dokumen Anda tersimpan aman. Hanya
                    Anda dan perangkat desa yang bisa mengakses.
                </p>
            </div>
        </div>

    </div>

</div>

{{-- ══════════════════════════════════════
     JENIS SURAT
══════════════════════════════════════ --}}
<div style="background:#f6fdf9;" class="py-5">
    <div class="container">

        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <h2 class="sec-title mb-1">Jenis Surat yang Tersedia</h2>
                <p class="sec-sub mb-0">
                    Pilih layanan surat yang Anda butuhkan
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                @auth('web')
                    <a href="{{ route('warga.applications.create') }}"
                       class="btn btn-success px-4">
                        <i class="bi bi-plus-circle me-2"></i>
                        Ajukan Sekarang
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="btn btn-success px-4">
                        <i class="bi bi-person-plus me-2"></i>
                        Daftar & Ajukan
                    </a>
                @endauth
            </div>
        </div>

        <div class="row g-3">
            @foreach(\App\Models\LetterType::active()
                ->orderBy('name')->get() as $i => $type)
                <div class="col-md-4">
                    <div class="letter-card">
                        <div class="d-flex align-items-start gap-3">
                            <div class="letter-num">{{ $i + 1 }}</div>
                            <div>
                                <div class="fw-bold small mb-1"
                                     style="color:#1a3c34;">
                                    {{ $type->name }}
                                </div>
                                <p class="text-muted mb-2"
                                   style="font-size:0.78rem;line-height:1.5;">
                                    {{ Str::limit($type->description, 72) }}
                                </p>
                                <span class="badge bg-light text-dark border"
                                      style="font-size:0.68rem;">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $type->processing_time }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════
     CARA MENGAJUKAN
══════════════════════════════════════ --}}
<div class="container py-5">

    <div class="text-center mb-5">
        <h2 class="sec-title">Cara Mengajukan Surat</h2>
        <p class="sec-sub">Hanya 4 langkah mudah</p>
    </div>

    <div class="row g-4">
        @php
            $steps = [
                ['icon'=>'person-plus-fill','title'=>'Daftar Akun',
                 'desc'=>'Buat akun menggunakan NIK dan data diri Anda sebagai warga desa.'],
                ['icon'=>'journals','title'=>'Pilih Jenis Surat',
                 'desc'=>'Pilih jenis surat yang Anda butuhkan dari daftar layanan tersedia.'],
                ['icon'=>'upload','title'=>'Upload Dokumen',
                 'desc'=>'Upload KTP, KK, Surat Pengantar RT, dan dokumen pendukung.'],
                ['icon'=>'building-fill','title'=>'Ambil Surat',
                 'desc'=>'Setelah disetujui, surat siap diambil di kantor desa.'],
            ];
        @endphp

        @foreach($steps as $i => $step)
            <div class="col-md-3 text-center">
                <div class="step-circle">{{ $i + 1 }}</div>
                <h6 class="fw-bold mb-2" style="color:#1a3c34;">
                    {{ $step['title'] }}
                </h6>
                <p class="text-muted small mb-0"
                   style="line-height:1.65;">
                    {{ $step['desc'] }}
                </p>
            </div>
        @endforeach
    </div>

</div>

{{-- ══════════════════════════════════════
     INFO DESA
══════════════════════════════════════ --}}
@php $village = \App\Models\VillageProfile::first(); @endphp
@if($village)
<div style="background:#f6fdf9;" class="py-5">
    <div class="container">

        <div class="text-center mb-4">
            <h2 class="sec-title">{{ $village->village_name }}</h2>
            <p class="sec-sub">
                {{ $village->description
                    ? Str::limit($village->description, 120)
                    : 'Berkomitmen memberikan pelayanan administrasi terbaik kepada seluruh warga.' }}
            </p>
        </div>

        <div class="row g-3 justify-content-center">

            <div class="col-md-3">
                <div class="info-card">
                    <i class="bi bi-geo-alt-fill text-success"></i>
                    <div class="fw-semibold small text-muted mb-1">
                        Alamat
                    </div>
                    <div class="small" style="line-height:1.6;">
                        {{ $village->address }}
                    </div>
                </div>
            </div>

            @if($village->phone)
            <div class="col-md-3">
                <div class="info-card">
                    <i class="bi bi-telephone-fill text-success"></i>
                    <div class="fw-semibold small text-muted mb-1">
                        Telepon
                    </div>
                    <div class="small">{{ $village->phone }}</div>
                </div>
            </div>
            @endif

            @if($village->email)
            <div class="col-md-3">
                <div class="info-card">
                    <i class="bi bi-envelope-fill text-success"></i>
                    <div class="fw-semibold small text-muted mb-1">
                        Email
                    </div>
                    <div class="small">{{ $village->email }}</div>
                </div>
            </div>
            @endif

            <div class="col-md-3">
                <div class="info-card">
                    <i class="bi bi-person-badge-fill text-success"></i>
                    <div class="fw-semibold small text-muted mb-1">
                        Kepala Desa
                    </div>
                    <div class="small fw-bold" style="color:#1a3c34;">
                        {{ $village->headman_name }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endif

{{-- ══════════════════════════════════════
     CTA (hanya tamu)
══════════════════════════════════════ --}}
@guest('web')
<div class="cta-wrap py-5">
    <div class="container text-center py-3">
        <h3 class="fw-bold text-white mb-3">
            Siap Mengajukan Surat Keterangan?
        </h3>
        <p class="mb-4"
           style="color:rgba(255,255,255,0.72);
                  max-width:460px;margin:0 auto 1.75rem;">
            Daftarkan diri Anda dan nikmati kemudahan layanan
            administrasi surat desa secara online, gratis.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('register') }}"
               class="btn-hero-primary">
                <i class="bi bi-person-plus"></i>
                Daftar Gratis
            </a>
            <a href="{{ route('login') }}"
               class="btn-hero-outline">
                <i class="bi bi-box-arrow-in-right"></i>
                Sudah Punya Akun
            </a>
        </div>
    </div>
</div>
@endguest

@endsection