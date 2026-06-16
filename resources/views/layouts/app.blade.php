<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Pelayanan Surat Desa')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ── Base ────────────────────────────── */
        html, body {
            height: 100%;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        main {
            flex: 1;
        }

        /* ── Navbar ──────────────────────────── */
        .main-navbar {
            background: #1a3c34;
            padding: 0;
            min-height: 57px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .navbar-brand-text {
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .navbar-brand-text:hover { color: #d8f3dc; }

        .navbar-brand-text .brand-icon {
            width: 30px;
            height: 30px;
            background: rgba(255,255,255,0.15);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-menu a {
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 500;
            padding: 0.4rem 0.75rem;
            border-radius: 7px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .nav-menu a:hover {
            color: #fff;
            background: rgba(255,255,255,0.1);
        }

        .nav-divider {
            width: 1px;
            height: 20px;
            background: rgba(255,255,255,0.15);
            margin: 0 0.5rem;
        }

        /* ── Dropdown ────────────────────────── */
        .nav-dropdown {
            position: relative;
        }

        .nav-dropdown-toggle {
            color: rgba(255,255,255,0.85);
            font-size: 0.82rem;
            font-weight: 500;
            padding: 0.32rem 0.65rem;
            border-radius: 7px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            user-select: none;
        }

        .nav-dropdown-toggle:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }

        .nav-dropdown-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.14);
            min-width: 210px;
            padding: 0.5rem;
            display: none;
            border: 1px solid #e8eaed;
            z-index: 1050;
        }

        .nav-dropdown-menu.show {
            display: block;
        }

        .nav-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.55rem 0.75rem;
            color: #333;
            font-size: 0.855rem;
            font-weight: 500;
            border-radius: 7px;
            text-decoration: none;
            transition: background 0.15s;
        }

        .nav-dropdown-menu a:hover {
            background: #f6fdf9;
            color: #1a3c34;
        }

        .nav-dropdown-menu a i {
            color: #40916c;
            font-size: 0.9rem;
        }

        .nav-dropdown-divider {
            height: 1px;
            background: #f0f0f0;
            margin: 0.35rem 0;
        }

        .nav-dropdown-menu .logout-btn {
            color: #dc3545;
            width: 100%;
            background: none;
            border: none;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.55rem 0.75rem;
            font-size: 0.855rem;
            font-weight: 500;
            border-radius: 7px;
            cursor: pointer;
            transition: background 0.15s;
        }

        .nav-dropdown-menu .logout-btn:hover {
            background: #fff5f5;
        }

        .nav-dropdown-menu .logout-btn i {
            color: #dc3545;
        }

        /* ── Avatar ──────────────────────────── */
        .user-avatar {
            width: 28px;
            height: 28px;
            background: #52b788;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        /* ── Breadcrumb ──────────────────────── */
        .breadcrumb-bar {
            background: #fff;
            border-bottom: 1px solid #e8eaed;
            padding: 0.55rem 0;
        }

        .breadcrumb {
            margin: 0;
            padding: 0;
            background: none;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.1rem;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
            color: #888;
        }

        .breadcrumb-item a {
            color: #40916c;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            transition: color 0.2s;
        }

        .breadcrumb-item a:hover { color: #1a3c34; }

        .breadcrumb-item.active {
            color: #333;
            font-weight: 600;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 4px;
            background: #ccc;
            border-radius: 50%;
            margin: 0 0.5rem;
            flex-shrink: 0;
        }

        /* ── Alert ───────────────────────────── */
        .alert {
            border-radius: 10px;
            border: none;
            font-size: 0.875rem;
        }

        /* ── Card ────────────────────────────── */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.25rem;
            font-weight: 600;
        }

        .btn { border-radius: 8px; font-weight: 500; }

        /* ── Footer ──────────────────────────── */
        footer {
            background: #1a3c34;
            color: rgba(255,255,255,0.6);
            padding: 1.25rem 0;
            font-size: 0.8rem;
            margin-top: 0;
            flex-shrink: 0;
        }

        footer a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
        }

        footer a:hover { color: #fff; }
    </style>

    @yield('styles')
</head>
<body>
@php($village = \App\Models\VillageProfile::first())

{{-- ════════════════════════════════════
     NAVBAR
════════════════════════════════════ --}}
<nav class="main-navbar">
    <div class="container-fluid px-4 d-flex align-items-center
                justify-content-between">

        {{-- Brand --}}
        <a href="{{ route('home') }}" class="navbar-brand-text">
            <div class="brand-icon" style="overflow:hidden; padding:0;">
                @if($village && $village->logo)
                    <img src="{{ $village->logo_url }}"
                         alt="Logo Desa"
                         style="width:100%;height:100%;object-fit:contain;">
                @else
                    <i class="bi bi-building"></i>
                @endif
            </div>
            {{ $village->village_name ?? 'Desa Simpang Sungai Duren' }}
        </a>

        {{-- Menu --}}
        <div class="d-flex align-items-center gap-2">

            @auth('web')

                {{-- Menu Warga --}}
                <ul class="nav-menu d-none d-md-flex">
                    <li>
                        <a href="{{ route('warga.dashboard') }}">
                            <i class="bi bi-speedometer2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('warga.applications.create') }}">
                            <i class="bi bi-plus-circle"></i>
                            Ajukan Surat
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('warga.applications.index') }}">
                            <i class="bi bi-clock-history"></i>
                            Riwayat
                        </a>
                    </li>
                </ul>

                <div class="nav-divider d-none d-md-block"></div>

                {{-- Dropdown Profil --}}
                <div class="nav-dropdown">
                    <div class="nav-dropdown-toggle"
                         onclick="toggleDropdown(event)">
                        <div class="user-avatar">
                            {{ strtoupper(substr(
                                Auth::guard('web')->user()->name, 0, 1)) }}
                        </div>
                        <span class="d-none d-md-inline">
                            {{ Str::limit(
                                Auth::guard('web')->user()->name, 14) }}
                        </span>
                        <i class="bi bi-chevron-down"
                           style="font-size:0.7rem;
                                  color:rgba(255,255,255,0.6);"></i>
                    </div>
                    <div class="nav-dropdown-menu">
                        {{-- Info User --}}
                        <div style="padding:0.5rem 0.75rem 0.4rem;">
                            <div style="font-weight:700;
                                        font-size:0.875rem;
                                        color:#1a3c34;">
                                {{ Auth::guard('web')->user()->name }}
                            </div>
                            <div style="font-size:0.75rem;color:#888;">
                                NIK: {{ Auth::guard('web')->user()->nik }}
                            </div>
                        </div>
                        <div class="nav-dropdown-divider"></div>
                        <a href="{{ route('warga.dashboard') }}">
                            <i class="bi bi-speedometer2"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('warga.applications.index') }}">
                            <i class="bi bi-clock-history"></i>
                            Riwayat Pengajuan
                        </a>
                        <a href="{{ route('warga.profile.edit') }}">
                            <i class="bi bi-person"></i>
                            Profil Saya
                        </a>
                        <div class="nav-dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="bi bi-box-arrow-right"></i>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>

            @else

                {{-- Tamu --}}
                <ul class="nav-menu">
                    <li>
                        <a href="{{ route('home') }}">
                            <i class="bi bi-house"></i>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Masuk
                        </a>
                    </li>
                </ul>
                <a href="{{ route('register') }}"
                   style="background:#52b788;color:#fff;
                          padding:0.4rem 1rem;border-radius:8px;
                          font-size:0.855rem;font-weight:600;
                          text-decoration:none;
                          transition:background 0.2s;"
                   onmouseover="this.style.background='#40916c'"
                   onmouseout="this.style.background='#52b788'">
                    Daftar
                </a>

            @endauth

        </div>
    </div>
</nav>

{{-- ════════════════════════════════════
     BREADCRUMB
════════════════════════════════════ --}}
@hasSection('breadcrumb')
<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('home') }}">
                    <i class="bi bi-house-fill"></i>
                    Beranda
                </a>
            </div>
            @yield('breadcrumb')
        </nav>
    </div>
</div>
@endif

{{-- ════════════════════════════════════
     FLASH MESSAGE
════════════════════════════════════ --}}
@if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

{{-- ════════════════════════════════════
     KONTEN UTAMA
════════════════════════════════════ --}}
<main>
    @yield('content')
</main>

{{-- ════════════════════════════════════
     FOOTER
════════════════════════════════════ --}}
<footer>
    <div class="container text-center">
        <p class="mb-0">
            &copy; {{ date('Y') }} Desa Simpang Sungai Duren
            &nbsp;·&nbsp;
            Sistem Pelayanan Administrasi Surat Desa
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle dropdown saat diklik
    function toggleDropdown(e) {
        e.stopPropagation();
        const menu = e.currentTarget
            .closest('.nav-dropdown')
            .querySelector('.nav-dropdown-menu');
        menu.classList.toggle('show');
    }

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function () {
        document.querySelectorAll('.nav-dropdown-menu.show')
            .forEach(m => m.classList.remove('show'));
    });
</script>

@yield('scripts')
</body>
</html>