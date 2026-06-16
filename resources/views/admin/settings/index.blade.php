@extends('layouts.admin')

@section('title', 'Pengaturan Admin')
@section('page-title', 'Pengaturan Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active">Pengaturan</li>
@endsection

@section('content')

<div class="row g-4">

    {{-- Daftar Akun Admin ───────────────────────── --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between
                        align-items-center">
                <span>
                    <i class="bi bi-people me-2"></i>
                    Daftar Akun Admin
                </span>
                <a href="{{ route('admin.settings.create') }}"
                   class="btn btn-sm btn-primary">
                    <i class="bi bi-plus me-1"></i>Tambah Admin
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary
                                                d-flex align-items-center
                                                justify-content-center
                                                text-white fw-bold"
                                         style="width:34px;height:34px;
                                                font-size:0.8rem;">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">
                                            {{ $admin->name }}
                                        </div>
                                        @if($admin->id === $current->id)
                                            <span class="badge bg-success"
                                                  style="font-size:0.65rem;">
                                                Anda
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="small">{{ $admin->email }}</span>
                            </td>
                            <td>
                                <span class="badge
                                    {{ $admin->role === 'superadmin'
                                        ? 'bg-danger'
                                        : ($admin->role === 'admin'
                                            ? 'bg-primary'
                                            : 'bg-secondary') }}">
                                    {{ ucfirst($admin->role) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1
                                            justify-content-center">
                                    <a href="{{ route('admin.settings.edit',
                                               $admin->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    @if($admin->id !== $current->id)
                                        <form
                                            action="{{ route('admin.settings.destroy',
                                                     $admin->id) }}"
                                            method="POST"
                                            onsubmit="return confirm(
                                                'Hapus akun {{ $admin->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm
                                                           btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Ganti Password Sendiri ──────────────────── --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-lock me-2"></i>Ganti Password Saya
            </div>
            <div class="card-body">
                <form
                    action="{{ route('admin.settings.password',
                             $current->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">
                            Password Saat Ini
                        </label>
                        <input
                            type="password"
                            class="form-control
                                @error('current_password') is-invalid @enderror"
                            name="current_password"
                            placeholder="Password saat ini"
                        >
                        @error('current_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

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
                            placeholder="Ulangi password baru"
                        >
                    </div>

                    <button type="submit"
                            class="btn btn-primary w-100">
                        <i class="bi bi-lock me-2"></i>
                        Ganti Password
                    </button>

                </form>
            </div>
        </div>
    </div>

</div>

@endsection