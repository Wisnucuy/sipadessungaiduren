@extends('layouts.app')

@section('title', 'Profil Saya')
@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('warga.dashboard') }}">Dashboard</a>
    </div>
    <div class="breadcrumb-item active">Profil Saya</div>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="mb-4">
                <h4 class="fw-bold mb-1">Profil Saya</h4>
                <p class="text-muted mb-0">
                    Kelola data diri dan keamanan akun Anda
                </p>
            </div>

            {{-- Edit Data Diri ──────────────────── --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-person me-2"></i>Data Diri
                </div>
                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- NIK readonly --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">NIK</label>
                        <input
                            type="text"
                            class="form-control bg-light"
                            value="{{ $user->nik }}"
                            readonly
                        >
                        <div class="form-text">
                            NIK tidak dapat diubah.
                        </div>
                    </div>

                    <form
                        action="{{ route('warga.profile.update') }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nama Lengkap
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                class="form-control
                                    @error('name') is-invalid @enderror"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Email
                                </label>
                                <input
                                    type="email"
                                    class="form-control
                                        @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    placeholder="email@contoh.com"
                                >
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Nomor HP / WhatsApp
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    placeholder="08xxxxxxxxxx"
                                >
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Alamat Lengkap
                                <span class="text-danger">*</span>
                            </label>
                            <textarea
                                class="form-control
                                    @error('address') is-invalid @enderror"
                                name="address"
                                rows="3"
                                required
                            >{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit"
                                class="btn btn-success px-4">
                            <i class="bi bi-check-lg me-2"></i>
                            Simpan Perubahan
                        </button>

                    </form>
                </div>
            </div>

            {{-- Ganti Password ──────────────────── --}}
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-lock me-2"></i>Ganti Password
                </div>
                <div class="card-body">
                    <form
                        action="{{ route('warga.profile.password') }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Password Saat Ini
                            </label>
                            <input
                                type="password"
                                class="form-control
                                    @error('current_password')
                                    is-invalid @enderror"
                                name="current_password"
                                placeholder="Masukkan password saat ini"
                            >
                            @error('current_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Password Baru
                            </label>
                            <input
                                type="password"
                                class="form-control
                                    @error('new_password')
                                    is-invalid @enderror"
                                name="new_password"
                                placeholder="Minimal 8 karakter"
                            >
                            @error('new_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Konfirmasi Password Baru
                            </label>
                            <input
                                type="password"
                                class="form-control"
                                name="new_password_confirmation"
                                placeholder="Ulangi password baru"
                            >
                        </div>

                        <button type="submit"
                                class="btn btn-warning px-4">
                            <i class="bi bi-lock me-2"></i>
                            Ganti Password
                        </button>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection