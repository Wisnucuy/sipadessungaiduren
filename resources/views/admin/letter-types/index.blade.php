@extends('layouts.admin')

@section('title', 'Kelola Jenis Surat')
@section('page-title', 'Kelola Jenis Surat')

@section('breadcrumb')
    <li class="breadcrumb-item active">Jenis Surat</li>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0">
            Kelola jenis surat yang tersedia untuk warga
        </p>
    </div>
    <a href="{{ route('admin.letter-types.create') }}"
       class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Jenis Surat
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($letterTypes->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-journals" style="font-size:2.5rem;"></i>
                <p class="mt-2">Belum ada jenis surat.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Jenis Surat</th>
                            <th>Estimasi Proses</th>
                            <th>Persyaratan</th>
                            <th>Total Pengajuan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($letterTypes as $type)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $type->name }}</div>
                                @if($type->description)
                                    <div class="text-muted small">
                                        {{ Str::limit($type->description, 60) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="small">
                                    {{ $type->processing_time }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $reqs = is_array($type->requirements)
                                        ? $type->requirements
                                        : (json_decode($type->requirements, true) ?? []);
                                @endphp
                                <span class="badge bg-secondary">
                                    {{ count($reqs) }} dokumen
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $type->applications()->count() }} pengajuan
                                </span>
                            </td>
                            <td>
                                @if($type->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.letter-types.edit',
                                               $type->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    {{-- Toggle Aktif --}}
                                    <form action="{{ route('admin.letter-types.toggle',
                                                   $type->id) }}"
                                          method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm
                                                {{ $type->is_active
                                                    ? 'btn-outline-warning'
                                                    : 'btn-outline-success' }}"
                                                title="{{ $type->is_active
                                                    ? 'Nonaktifkan'
                                                    : 'Aktifkan' }}">
                                            <i class="bi bi-{{ $type->is_active
                                                ? 'toggle-on'
                                                : 'toggle-off' }}"></i>
                                        </button>
                                    </form>

                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.letter-types.destroy',
                                                   $type->id) }}"
                                          method="POST"
                                          onsubmit="return confirm(
                                              'Hapus jenis surat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($letterTypes->hasPages())
                <div class="px-3 py-3 border-top">
                    {{ $letterTypes->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

@endsection