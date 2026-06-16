@extends('layouts.admin')

@section('title', 'Daftar Pengajuan')
@section('page-title', 'Daftar Pengajuan')

@section('breadcrumb')
    <li class="breadcrumb-item active">Daftar Pengajuan</li>
@endsection

@section('content')

{{-- Filter & Search ─────────────────────────────── --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.applications.index') }}">
            <div class="row g-3 align-items-end">

                {{-- Search --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold small">
                        Cari Pengajuan
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input
                            type="text"
                            class="form-control"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Nama, NIK, atau No. Pengajuan..."
                        >
                    </div>
                </div>

                {{-- Filter Status --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">
                        Status
                    </label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        @foreach($statusList as $key => $status)
                            <option value="{{ $key }}"
                                {{ request('status') === $key ? 'selected' : '' }}>
                                {{ $status['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Jenis Surat --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">
                        Jenis Surat
                    </label>
                    <select class="form-select" name="letter_type_id">
                        <option value="">Semua Jenis</option>
                        @foreach($letterTypes as $type)
                            <option value="{{ $type->id }}"
                                {{ request('letter_type_id') == $type->id
                                    ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol --}}
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.applications.index') }}"
                           class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- Tabel Pengajuan ──────────────────────────────── --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>
            <i class="bi bi-file-earmark-text me-2"></i>
            Semua Pengajuan
        </span>
        <span class="badge bg-primary">
            {{ $applications->total() }} pengajuan
        </span>
    </div>
    <div class="card-body p-0">

        @if($applications->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox" style="font-size:2.5rem;"></i>
                <p class="mt-2 mb-0">Tidak ada pengajuan ditemukan.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Pengajuan</th>
                            <th>Nama Warga</th>
                            <th>NIK</th>
                            <th>Jenis Surat</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $app)
                        <tr>
                            <td>
                                <span class="fw-semibold text-primary small">
                                    {{ $app->application_number }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold small">
                                    {{ $app->user->name }}
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ $app->user->nik }}
                                </span>
                            </td>
                            <td>
                                <span class="small">
                                    {{ Str::limit($app->letterType->name, 30) }}
                                </span>
                            </td>
                            <td>
                                <span class="small text-muted">
                                    {{ $app->created_at->format('d/m/Y') }}<br>
                                    <span style="font-size:0.75rem;">
                                        {{ $app->created_at->format('H:i') }} WIB
                                    </span>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $app->status_color }}">
                                    {{ $app->status_label }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.applications.show',
                                           ['id' => $app->id]) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($applications->hasPages())
                <div class="d-flex justify-content-between align-items-center
                            px-3 py-3 border-top">
                    <div class="small text-muted">
                        Menampilkan {{ $applications->firstItem() }}–{{ $applications->lastItem() }}
                        dari {{ $applications->total() }} pengajuan
                    </div>
                    {{ $applications->links() }}
                </div>
            @endif
        @endif

    </div>
</div>

@endsection