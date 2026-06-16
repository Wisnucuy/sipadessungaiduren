@extends('layouts.app')

@section('title', 'Masuk - Surat Desa')

@section('styles')
<style>
    body { background-color: #f6fdf9; }

    .login-wrap {
        min-height: calc(100vh - 64px);
        display: flex;
        align-items: center;
        padding: 24px 0;
    }

    .login-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .login-sidebar {
        background: linear-gradient(160deg, #1a3c34 0%, #40916c 100%);
        padding: 2.5rem 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: #fff;
        min-height: 100%;
    }

    .login-sidebar .brand-icon {
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

    .login-sidebar h4 {
        font-weight: 800;
        font-size: 1.35rem;
        margin-bottom: 0.5rem;
    }

    .login-sidebar p {
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

    .login-body {
        padding: 2.5rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .login-body h5 {
        font-weight: 700;
        color: #1a3c34;
        margin-bottom: 0.25rem;
        font-size: 1.3rem;
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
        padding: 0.65rem 0.875rem;
        font-size: 0.9rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus {
        border-color: #40916c;
        box-shadow: 0 0 0 3px rgba(64,145,108,0.12);
    }

    .btn-login {
        background: linear-gradient(135deg, #40916c, #1a3c34);
        border: none;
        color: #fff;
        border-radius: 9px;
        padding: 0.75rem 1rem;
        font-weight: 700;
        font-size: 1rem;
        width: 100%;
        transition: opacity 0.2s, transform 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-login:hover {
        opacity: 0.92;
        color: #fff;
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')
<div class="login-wrap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">

                <div class="login-card">
                    <div class="row g-0">

                        {{-- Sidebar Kiri ──────────────── --}}
                        <div class="col-lg-5 d-none d-lg-block">
                            <div class="login-sidebar">

                                <div class="brand-icon">
                                    <i class="bi bi-building"></i>
                                </div>

                                <h4>Selamat Datang</h4>
                                <p>
                                    Desa Simpang Sungai Duren.<br>
                                    Masuk untuk mengakses layanan
                                    administrasi surat desa secara online.
                                </p>

                                <div class="sidebar-feature">
                                    <i class="bi bi-file-earmark-text"></i>
                                    Ajukan surat keterangan
                                </div>
                                <div class="sidebar-feature">
                                    <i class="bi bi-search"></i>
                                    Pantau status pengajuan
                                </div>
                                <div class="sidebar-feature">
                                    <i class="bi bi-whatsapp"></i>
                                    Notifikasi WhatsApp
                                </div>
                                <div class="sidebar-feature">
                                    <i class="bi bi-shield-check"></i>
                                    Data aman & terpercaya
                                </div>

                            </div>
                        </div>

                        {{-- Form Kanan ────────────────── --}}
                        <div class="col-lg-7">
                            <div class="login-body">

                                <h5>Masuk ke Sistem</h5>
                                <p class="text-muted mb-4"
                                   style="font-size:0.82rem;">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}"
                                       class="text-success fw-semibold
                                              text-decoration-none">
                                        Daftar di sini
                                    </a>
                                </p>

                                {{-- Error --}}
                                @if($errors->any())
                                    <div class="alert alert-danger
                                                py-2 mb-3"
                                         style="font-size:0.82rem;
                                                border-radius:8px;">
                                        <i class="bi bi-exclamation-triangle
                                                   me-1"></i>
                                        {{ $errors->first() }}
                                    </div>
                                @endif

                                @if(session('success'))
                                    <div class="alert alert-success
                                                py-2 mb-3"
                                         style="font-size:0.82rem;
                                                border-radius:8px;">
                                        <i class="bi bi-check-circle
                                                   me-1"></i>
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form action="{{ route('login.post') }}"
                                      method="POST">
                                    @csrf

                                    {{-- NIK --}}
                                    <div class="mb-3">
                                        <label class="form-label">
                                            NIK
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control form-control-lg
                                                @error('nik') is-invalid @enderror"
                                            name="nik"
                                            value="{{ old('nik') }}"
                                            placeholder="Masukkan 16 digit NIK Anda"
                                            maxlength="16"
                                            autofocus
                                            required
                                        >
                                        @error('nik')
                                            <div class="invalid-feedback"
                                                 style="font-size:0.78rem;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Password --}}
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Password
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input
                                                type="password"
                                                class="form-control form-control-lg"
                                                id="password"
                                                name="password"
                                                placeholder="Masukkan password"
                                                required
                                            >
                                            <button
                                                class="btn btn-outline-secondary"
                                                type="button"
                                                onclick="togglePass()">
                                                <i class="bi bi-eye"
                                                   id="eyeIcon"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Remember --}}
                                    <div class="mb-4 form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            id="remember"
                                            name="remember"
                                        >
                                        <label class="form-check-label"
                                               for="remember"
                                               style="font-size:0.85rem;">
                                            Ingat saya
                                        </label>
                                    </div>

                                    {{-- Tombol Masuk --}}
                                    <button type="submit"
                                            class="btn-login mb-3">
                                        <i class="bi bi-box-arrow-in-right"></i>
                                        Masuk
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

@section('scripts')
<script>
function togglePass() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eyeIcon');
    const show  = input.type === 'password';
    input.type     = show ? 'text' : 'password';
    icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
}
</script>
@endsection