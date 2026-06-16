@extends('layouts.app')

@section('title', 'Riwayat Pengajuan')
@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('warga.dashboard') }}">Dashboard</a>
    </div>
    <div class="breadcrumb-item active">Riwayat Pengajuan</div>
@endsection

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Riwayat Pengajuan Surat</h4>
            <p class="text-muted mb-0">Semua pengajuan surat yang pernah Anda buat</p>
        </div>
        <a href="{{ route('warga.applications.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>Ajukan Surat Baru
        </a>
    </div>

    {{-- Tabel --}}
    <div class="card">
        <div class="card-body p-0">
            @if($applications->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox" style="font-size:3rem;"></i>
                    <p class="mt-3 mb-1 fw-semibold">Belum Ada Pengajuan</p>
                    <p class="small">Anda belum pernah mengajukan surat apapun.</p>
                    <a href="{{ route('warga.applications.create') }}"
                       class="btn btn-success btn-sm mt-1">
                        Ajukan Sekarang
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No. Pengajuan</th>
                                <th>Jenis Surat</th>
                                <th>Keperluan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applications as $app)
                            <tr>
                                <td>
                                    <span class="fw-semibold text-primary">
                                        {{ $app->application_number }}
                                    </span>
                                </td>
                                <td>{{ $app->letterType->name }}</td>
                                <td>
                                    <span class="text-muted small">
                                        {{ Str::limit($app->purpose, 50) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="small">
                                        {{ $app->created_at->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $app->status_color }}">
                                        {{ $app->status_label }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('warga.applications.show', $app->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>Detail
                                    </a>
                                    @if($app->isEditable())
                                        <a href="{{ route('warga.applications.edit', $app->id) }}"
                                           class="btn btn-sm btn-outline-warning ms-1">
                                            <i class="bi bi-pencil me-1"></i>Perbaiki
                                        </a>
                                    @endif
                                    @if($app->isDeletable())
                                        <form action="{{ route('warga.applications.destroy', $app->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger ms-1">
                                                <i class="bi bi-trash me-1"></i>Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($applications->hasPages())
                    <div class="d-flex justify-content-center py-3">
                        {{ $applications->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

</div>
@endsection