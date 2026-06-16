@extends('layouts.admin')

@section('title', 'Edit Admin')
@section('page-title', 'Edit Akun Admin')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.settings.index') }}">Pengaturan</a>
    </li>
    <li class="breadcrumb-item active">Edit</li>
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

        {{-- Edit Data --}}
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-pencil me-2"></i>
                Edit Data Admin
            </div>
            <div class="card-body">
                <form
                    action="{{ route('admin.settings.update',
                             $admin->id) }}"
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
                            class="form-control"
                            name="name"
                            value="{{ old('name', $admin->name) }}"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input
                            type="email"
                            class="form-control"
                            name="email"
                            value="{{ old('email', $admin->email) }}"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Role <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" name="role">
                            <option value="admin"
                                {{ $admin->role === 'admin'
                                    ? 'selected' : '' }}>
                                Admin
                            </option>
                            <option value="operator"
                                {{ $admin->role === 'operator'
                                    ? 'selected' : '' }}>
                                Operator
                            </option>
                            <option value="superadmin"
                                {{ $admin->role === 'superadmin'
                                    ? 'selected' : '' }}>
                                Super Admin
                            </option>
                        </select>
                    </div>

                    <button type="submit"
                            class="btn btn-primary w-100">
                        <i class="bi bi-check-lg me-2"></i>
                        Simpan Perubahan
                    </button>

                </form>
            </div>
        </div>

        {{-- Ganti Password --}}
        <div class="card">
            <div class="card-header">
                <i class="bi bi-lock me-2"></i>Ganti Password
            </div>
            <div class="card-body">
                <form
                    action="{{ route('admin.settings.password',
                             $admin->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Password lama hanya jika edit diri sendiri --}}
                    @if($admin->id === $current->id)
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">
                                Password Saat Ini
                            </label>
                            <input
                                type="password"
                                class="form-control
                                    @error('current_password')
                                    is-invalid @enderror"
                                name="current_password"
                            >
                            @error('current_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">
                            Password Baru
                        </label>
                        <input
                            type="password"
                            class="form-control
                                @error('new_password') is-invalid @enderror"
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
                        <label class="form-label fw-semibold small">
                            Konfirmasi Password Baru
                        </label>
                        <input
                            type="password"
                            class="form-control"
                            name="new_password_confirmation"
                        >
                    </div>

                    <button type="submit"
                            class="btn btn-warning w-100">
                        <i class="bi bi-lock me-2"></i>
                        Ganti Password
                    </button>

                </form>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.settings.index') }}"
               class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

    </div>
</div>
@endsection