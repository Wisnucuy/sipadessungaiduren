@extends('layouts.app')

@section('title', 'Daftar Akun - Surat Desa')

@section('styles')
<style>
    body { background-color: #f6fdf9; }

    .register-wrap {
        min-height: calc(100vh - 64px);
        display: flex;
        align-items: center;
        padding: 24px 0;
    }

    .register-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .register-sidebar {
        background: linear-gradient(160deg, #1a3c34 0%, #40916c 100%);
        padding: 2.5rem 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: #fff;
        min-height: 100%;
    }

    .register-sidebar .brand-icon {
        width: 56px;
        height: 56px;
        background: rgba(255,255,255,0.15);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .register-sidebar h4 {
        font-weight: 800;
        font-size: 1.35rem;
        margin-bottom: 0.5rem;
    }

    .register-sidebar p {
        color: rgba(255,255,255,0.7);
        font-size: 0.875rem;
        line-height: 1.65;
        margin-bottom: 2rem;
    }

    .sidebar-feature {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.875rem;
        font-size: 0.85rem;
        color: rgba(255,255,255,0.85);
    }

    .sidebar-feature i {
        width: 28px;
        height: 28px;
        background: rgba(255,255,255,0.15);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 0.85rem;
    }

    .register-body {
        padding: 2rem 2.25rem;
    }

    .register-body h5 {
        font-weight: 700;
        color: #1a3c34;
        margin-bottom: 0.25rem;
    }

    .form-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: #444;
        margin-bottom: 0.3rem;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #dde2e8;
        padding: 0.55rem 0.875rem;
        font-size: 0.875rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus {
        border-color: #40916c;
        box-shadow: 0 0 0 3px rgba(64,145,108,0.12);
    }

    .btn-register {
        background: linear-gradient(135deg, #40916c, #1a3c34);
        border: none;
        color: #fff;
        border-radius: 9px;
        padding: 0.65rem 1rem;
        font-weight: 700;
        font-size: 0.95rem;
        width: 100%;
        transition: opacity 0.2s, transform 0.2s;
    }

    .btn-register:hover {
        opacity: 0.92;
        color: #fff;
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')
<div class="register-wrap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">

                <div class="register-card">
                    <div class="row g-0">

                        {{-- Sidebar Kiri ──────────────── --}}
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="register-sidebar">

                                <div class="brand-icon">
                                    <i class="bi bi-building"></i>
                                </div>

                                <h4>Daftar Akun Warga</h4>
                                <p>
                                    Desa Simpang Sungai Duren.<br>
                                    Layanan surat online cepat
                                    dan mudah.
                                </p>

                                <div class="sidebar-feature">
                                    <i class="bi bi-check-lg"></i>
                                    Ajukan surat dari rumah
                                </div>
                                <div class="sidebar-feature">
                                    <i class="bi bi-check-lg"></i>
                                    Pantau status real-time
                                </div>
                                <div class="sidebar-feature">
                                    <i class="bi bi-check-lg"></i>
                                    Notifikasi WhatsApp
                                </div>
                                <div class="sidebar-feature">
                                    <i class="bi bi-check-lg"></i>
                                    Dokumen aman tersimpan
                                </div>

                            </div>
                        </div>

                        {{-- Form Kanan ────────────────── --}}
                        <div class="col-lg-8">
                            <div class="register-body">

                                <h5>Buat Akun Baru</h5>
                                <p class="text-muted mb-3"
                                   style="font-size:0.82rem;">
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}"
                                       class="text-success fw-semibold
                                              text-decoration-none">
                                        Masuk di sini
                                    </a>
                                </p>

                                {{-- Error --}}
                                @if($errors->any())
                                    <div class="alert alert-danger
                                                py-2 mb-3"
                                         style="font-size:0.82rem;
                                                border-radius:8px;">
                                        <ul class="mb-0 ps-3">
                                            @foreach($errors->all() as $e)
                                                <li>{{ $e }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('register.post') }}"
                                      method="POST">
                                    @csrf

                                    {{-- Baris 1: NIK --}}
                                    <div class="mb-2">
                                        <label class="form-label">
                                            NIK
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control
                                                @error('nik') is-invalid @enderror"
                                            name="nik"
                                            value="{{ old('nik') }}"
                                            placeholder="16 digit NIK sesuai KTP"
                                            maxlength="16"
                                            required
                                        >
                                        @error('nik')
                                            <div class="invalid-feedback"
                                                 style="font-size:0.78rem;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Baris 2: Nama --}}
                                    <div class="mb-2">
                                        <label class="form-label">
                                            Nama Lengkap
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control
                                                @error('name') is-invalid @enderror"
                                            name="name"
                                            value="{{ old('name') }}"
                                            placeholder="Sesuai KTP"
                                            required
                                        >
                                        @error('name')
                                            <div class="invalid-feedback"
                                                 style="font-size:0.78rem;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Baris 3: Email + HP --}}
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <label class="form-label">
                                                Email
                                            </label>
                                            <input
                                                type="email"
                                                class="form-control
                                                    @error('email') is-invalid @enderror"
                                                name="email"
                                                value="{{ old('email') }}"
                                                placeholder="contoh@email.com"
                                            >
                                            @error('email')
                                                <div class="invalid-feedback"
                                                     style="font-size:0.78rem;">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">
                                                No. HP / WhatsApp
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="phone"
                                                value="{{ old('phone') }}"
                                                placeholder="08xxxxxxxxxx"
                                            >
                                        </div>
                                    </div>

                                    {{-- Baris 4: Alamat --}}
                                    <div class="mb-2">
                                        <label class="form-label">
                                            Alamat Lengkap
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea
                                            class="form-control
                                                @error('address') is-invalid @enderror"
                                            name="address"
                                            rows="2"
                                            placeholder="RT, RW, Dusun, Desa"
                                            required
                                        >{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback"
                                                 style="font-size:0.78rem;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Baris 5: Password --}}
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label class="form-label">
                                                Password
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input
                                                type="password"
                                                class="form-control
                                                    @error('password') is-invalid @enderror"
                                                name="password"
                                                placeholder="Min. 8 karakter"
                                                required
                                            >
                                            @error('password')
                                                <div class="invalid-feedback"
                                                     style="font-size:0.78rem;">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">
                                                Konfirmasi Password
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input
                                                type="password"
                                                class="form-control"
                                                name="password_confirmation"
                                                placeholder="Ulangi password"
                                                required
                                            >
                                        </div>
                                    </div>

                                    {{-- Submit --}}
                                    <button type="submit"
                                            class="btn-register">
                                        <i class="bi bi-person-check
                                                   me-2"></i>
                                        Daftar Sekarang
                                    </button>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection