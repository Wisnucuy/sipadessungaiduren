@extends('layouts.app')

@section('title', 'Perbaiki Pengajuan')
@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('warga.dashboard') }}">Dashboard</a>
    </div>
    <div class="breadcrumb-item">
        <a href="{{ route('warga.applications.index') }}">Riwayat</a>
    </div>
    <div class="breadcrumb-item active">Perbaiki Pengajuan</div>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="mb-4">
                <h4 class="fw-bold mb-1">Perbaiki Pengajuan</h4>
                <p class="text-muted mb-0">
                    No: <strong>{{ $application->application_number }}</strong>
                </p>
            </div>

            {{-- Catatan Penolakan --}}
            @if($application->notes)
                <div class="alert alert-danger mb-4">
                    <p class="fw-semibold mb-1">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Alasan Penolakan dari Admin:
                    </p>
                    <p class="mb-0">{{ $application->notes }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('warga.applications.update', $application->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Jenis Surat (readonly) --}}
                <div class="card mb-4">
                    <div class="card-header">Jenis Surat</div>
                    <div class="card-body">
                        <input type="text"
                               class="form-control"
                               value="{{ $application->letterType->name }}"
                               readonly>
                    </div>
                </div>

                {{-- Data Identitas Tambahan --}}
                <div class="card mb-4">
                    <div class="card-header">Data Pemohon</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $application->applicant_data['tempat_lahir'] ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $application->applicant_data['tanggal_lahir'] ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki" {{ (old('jenis_kelamin', $application->applicant_data['jenis_kelamin'] ?? '') == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ (old('jenis_kelamin', $application->applicant_data['jenis_kelamin'] ?? '') == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Agama</label>
                                <input type="text" name="agama" class="form-control" value="{{ old('agama', $application->applicant_data['agama'] ?? '') }}" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $application->applicant_data['pekerjaan'] ?? '') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Keperluan --}}
                <div class="card mb-4">
                    <div class="card-header">Keperluan Surat</div>
                    <div class="card-body">
                        <textarea
                            class="form-control @error('purpose') is-invalid @enderror"
                            name="purpose"
                            rows="4"
                            required
                        >{{ old('purpose', $application->purpose) }}</textarea>
                        @error('purpose')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Upload Ulang Dokumen --}}
                <div class="card mb-4">
                    <div class="card-header">
                        Upload Ulang Dokumen
                        <span class="text-muted small fw-normal ms-2">
                            (kosongkan jika tidak ingin mengganti)
                        </span>
                    </div>
                    <div class="card-body">

                        @php
                            $docTypes = [
                                'ktp'                => 'KTP',
                                'kk'                 => 'KK',
                                'surat_pengantar_rt' => 'Surat Pengantar RT',
                                'dokumen_pendukung'  => 'Dokumen Pendukung',
                            ];
                        @endphp

                        @foreach($docTypes as $key => $label)
                            @php
                                $existing = $application->attachments
                                    ->firstWhere('document_type', $key);
                            @endphp
                            <div class="mb-4">
                                <label class="form-label fw-semibold">{{ $label }}</label>

                                {{-- File lama --}}
                                @if($existing)
                                    <div class="d-flex align-items-center gap-2
                                                p-2 bg-light rounded mb-2 small">
                                        <i class="bi bi-file-earmark-check text-success"></i>
                                        <span>{{ $existing->file_name }}</span>
                                        <span class="text-muted">
                                            ({{ $existing->file_size_formatted }})
                                        </span>
                                        <a href="{{ $existing->file_url }}"
                                           target="_blank"
                                           class="ms-auto btn btn-xs btn-outline-primary btn-sm">
                                            Lihat
                                        </a>
                                    </div>
                                @endif

                                <input
                                    type="file"
                                    class="form-control"
                                    name="{{ $key }}"
                                    accept=".jpg,.jpeg,.png,.pdf"
                                >
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class="bi bi-send me-2"></i>Kirim Ulang Pengajuan
                    </button>
                    <a href="{{ route('warga.applications.show', $application->id) }}"
                       class="btn btn-outline-secondary btn-lg">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection