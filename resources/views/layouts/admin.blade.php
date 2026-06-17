<!DOCTYPE html>
<html lang="id">
<head>

<script>
(function (m, a, z, e) {
  var s, t, u, v;
  try {
    t = m.sessionStorage.getItem('maze-us');
  } catch (err) {}

  if (!t) {
    t = new Date().getTime();
    try {
      m.sessionStorage.setItem('maze-us', t);
    } catch (err) {}
  }

  u = document.currentScript || (function () {
    var w = document.getElementsByTagName('script');
    return w[w.length - 1];
  })();
  v = u && u.nonce;

  s = a.createElement('script');
  s.src = z + '?apiKey=' + e;
  s.async = true;
  if (v) s.setAttribute('nonce', v);
  a.getElementsByTagName('head')[0].appendChild(s);
  m.mazeUniversalSnippetApiKey = e;
})(window, document, 'https://snippet.maze.co/maze-universal-loader.js', '261ff951-2586-41d6-b312-d053e23738d3');
</script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Surat Desa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ── Reset & Base ─────────────────────────── */
        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            min-height: 100vh;
        }

        /* ── Sidebar ──────────────────────────────── */
        #sidebar {
            width: 280px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1a3c34 0%, #0f2419 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: width 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand h6 {
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
            margin: 0;
            line-height: 1.3;
        }

        .sidebar-brand small {
            color: rgba(255,255,255,0.5);
            font-size: 0.75rem;
        }

        .sidebar-nav {
            padding: 1rem 0;
            flex: 1;
            overflow-y: auto;
        }

        .nav-section-title {
            color: rgba(255,255,255,0.35);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0.75rem 1.25rem 0.25rem;
            margin-top: 0.5rem;
        }

        .sidebar-nav .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 0.6rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-radius: 0;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .sidebar-nav .nav-link i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-nav .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-left-color: rgba(255,255,255,0.3);
        }

        .sidebar-nav .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.12);
            border-left-color: #52b788;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* ── Topbar ───────────────────────────────── */
        #topbar {
            margin-left: 280px;
            height: 70px;
            background: #fff;
            border-bottom: 1px solid #e8eaed;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 99;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }

        /* ── Main Content ─────────────────────────── */
        #main-content {
            margin-left: 280px;
            padding: 1.5rem;
            min-height: calc(100vh - 64px);
        }

        /* ── Card ─────────────────────────────────── */
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
            font-size: 0.9rem;
        }

        /* ── Stat Card ────────────────────────────── */
        .stat-card {
            border-radius: 12px;
            padding: 1.25rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stat-card .stat-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3.5rem;
            opacity: 0.15;
        }

        .stat-card .stat-number {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-card .stat-label {
            font-size: 0.8rem;
            opacity: 0.85;
            margin-top: 0.25rem;
        }

        /* ── Badge ────────────────────────────────── */
        .badge { font-size: 0.75rem; padding: 0.4em 0.7em; border-radius: 6px; }

        /* ── Table ────────────────────────────────── */
        .table th {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom: 1px solid #e8eaed;
        }

        .table td { vertical-align: middle; font-size: 0.875rem; }

        /* ── Button ───────────────────────────────── */
        .btn { border-radius: 8px; font-weight: 500; font-size: 0.875rem; }

        /* ── Alert ────────────────────────────────── */
        .alert { border-radius: 10px; border: none; }

        /* ── Page Header ──────────────────────────── */
        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h4 {
            font-weight: 800;
            font-size: 1.15rem;
            margin-bottom: 0.25rem;
        }

        .page-header p {
            color: #6c757d;
            margin-bottom: 0;
            font-size: 0.875rem;
        }
    </style>

    @yield('styles')
</head>
<body>
@php($village = \App\Models\VillageProfile::first())

<!-- ═══════════════════════════════════════
     SIDEBAR
═══════════════════════════════════════ -->
<div id="sidebar">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2">
            <div style="width:36px;height:36px;background:rgba(255,255,255,0.15);
                        border-radius:8px;display:flex;align-items:center;
                        justify-content:center;overflow:hidden;">
                @if($village && $village->logo)
                    <img src="{{ $village->logo_url }}"
                         alt="Logo Desa"
                         style="width:100%;height:100%;object-fit:contain;">
                @else
                    <i class="bi bi-building text-white"></i>
                @endif
            </div>
            <div>
                <h6>Panel Admin</h6>
                <small>{{ $village->village_name ?? 'Desa Simpang Sungai Duren' }}</small>
            </div>
        </div>
    </div>

    {{-- Navigasi --}}
    <nav class="sidebar-nav">

        <div class="nav-section-title">Utama</div>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section-title">Pengajuan</div>

        <a href="{{ route('admin.applications.index') }}"
           class="nav-link {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Daftar Pengajuan
        </a>

        <div class="nav-section-title">Pengaturan</div>

        <a href="{{ route('admin.letter-types.index') }}"
           class="nav-link {{ request()->routeIs('admin.letter-types.*') ? 'active' : '' }}">
            <i class="bi bi-journals"></i> Jenis Surat
        </a>

        <a href="{{ route('admin.village-profile.edit') }}"
           class="nav-link {{ request()->routeIs('admin.village-profile.*') ? 'active' : '' }}">
            <i class="bi bi-house-gear"></i> Profil Desa
        </a>

        <a href="{{ route('admin.settings.index') }}"
           class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Pengaturan
        </a>

    </nav>

    {{-- Sidebar Footer --}}
    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div style="width:32px;height:32px;background:rgba(255,255,255,0.15);
                        border-radius:50%;display:flex;align-items:center;
                        justify-content:center;">
                <i class="bi bi-person-fill text-white small"></i>
            </div>
            <div>
                <div class="text-white small fw-semibold">
                    {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
                </div>
                <div style="color:rgba(255,255,255,0.45);font-size:0.7rem;">
                    {{ ucfirst(Auth::guard('admin')->user()->role ?? '') }}
                </div>
            </div>
        </div>

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="btn btn-sm w-100 text-white"
                    style="background:rgba(255,255,255,0.1);border:1px solid
                           rgba(255,255,255,0.15);font-size:0.8rem;">
                <i class="bi bi-box-arrow-right me-1"></i>Keluar
            </button>
        </form>
    </div>

</div>

<!-- ═══════════════════════════════════════
     TOPBAR
═══════════════════════════════════════ -->
<div id="topbar">
    <div>
        <h6 class="mb-0" style="font-weight:800; font-size:0.98rem; color:#1f2937;">@yield('page-title', 'Dashboard')</h6>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size:0.75rem;">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                        Beranda
                    </a>
                </li>
                @yield('breadcrumb')
            </ol>
        </nav>
    </div>

    <div class="d-flex align-items-center gap-3">
        {{-- Tanggal hari ini --}}
        <span class="text-muted small">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </span>

        {{-- Dropdown profil admin --}}
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                    data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-1"></i>
                {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                        <i class="bi bi-gear me-2"></i>Pengaturan
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════ -->
<div id="main-content">

    {{-- Alert global --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>