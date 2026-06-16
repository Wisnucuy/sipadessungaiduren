@extends('layouts.admin')

@section('title', 'Tambah Admin')
@section('page-title', 'Tambah Admin Baru')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.settings.index') }}">Pengaturan</a>
    </li>
    <li class="breadcrumb-item active">Tambah Admin</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-plus me-2"></i>
                Tambah Akun Admin Baru
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.store') }}"
                      method="POST">
                    @csrf

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
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input
                            type="email"
                            class="form-control
                                @error('email') is-invalid @enderror"
                            name="email"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Role <span class="text-danger">*</span>
                        </label>
                        <select
                            class="form-select
                                @error('role') is-invalid @enderror"
                            name="role"
                            required
                        >
                            <option value="">-- Pilih Role --</option>
                            <option value="admin"
                                {{ old('role') === 'admin'
                                    ? 'selected' : '' }}>
                                Admin
                            </option>
                            <option value="operator"
                                {{ old('role') === 'operator'
                                    ? 'selected' : '' }}>
                                Operator
                            </option>
                            <option value="superadmin"
                                {{ old('role') === 'superadmin'
                                    ? 'selected' : '' }}>
                                Super Admin
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Password <span class="text-danger">*</span>
                        </label>
                        <input
                            type="password"
                            class="form-control
                                @error('password') is-invalid @enderror"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
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

                    <div class="d-flex gap-2">
                        <button type="submit"
                                class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-2"></i>Simpan
                        </button>
                        <a href="{{ route('admin.settings.index') }}"
                           class="btn btn-outline-secondary px-4">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection