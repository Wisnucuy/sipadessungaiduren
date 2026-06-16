@extends('layouts.admin')

@section('title', 'Tambah Jenis Surat')
@section('page-title', 'Tambah Jenis Surat')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.letter-types.index') }}">Jenis Surat</a>
    </li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.letter-types.store') }}"
              method="POST">
            @csrf

            {{-- Info Dasar --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>
                    Informasi Dasar
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Jenis Surat <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Surat Keterangan Tidak Mampu"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea
                            class="form-control"
                            name="description"
                            rows="3"
                            placeholder="Penjelasan singkat tentang jenis surat ini..."
                        >{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Estimasi Waktu Proses
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('processing_time') is-invalid @enderror"
                            name="processing_time"
                            value="{{ old('processing_time', '1-2 hari kerja') }}"
                            placeholder="Contoh: 1-2 hari kerja"
                            required
                        >
                        @error('processing_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="is_active"
                            id="is_active"
                            {{ old('is_active', true) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="is_active">
                            Aktifkan jenis surat ini
                        </label>
                    </div>

                </div>
            </div>

            {{-- Persyaratan Dokumen --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-list-check me-2"></i>
                    Persyaratan Dokumen
                </div>
                <div class="card-body">
                    <div class="mb-0">
                        <label class="form-label fw-semibold">
                            Daftar Persyaratan
                        </label>
                        <textarea
                            class="form-control"
                            name="requirements"
                            rows="6"
                            placeholder="Tulis satu persyaratan per baris, contoh:&#10;KTP pemohon&#10;Kartu Keluarga (KK)&#10;Surat Pengantar RT/RW"
                        >{{ old('requirements') }}</textarea>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Tulis satu persyaratan per baris.
                            Setiap baris akan menjadi satu item persyaratan.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Template Surat --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-file-text me-2"></i>
                    Template Isi Surat
                    <span class="text-muted small fw-normal ms-2">(Opsional)</span>
                </div>
                <div class="card-body">
                    <textarea
                        class="form-control"
                        name="template_content"
                        rows="6"
                        placeholder="Tulis template isi surat. Gunakan [NAMA_WARGA], [NIK], [ALAMAT], [KEPERLUAN] sebagai placeholder..."
                    >{{ old('template_content') }}</textarea>
                    <div class="form-text">
                        Placeholder yang tersedia:
                        <code>[NAMA_WARGA]</code>,
                        <code>[NIK]</code>,
                        <code>[ALAMAT]</code>,
                        <code>[KEPERLUAN]</code>,
                        <code>[TANGGAL]</code>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-2"></i>Simpan
                </button>
                <a href="{{ route('admin.letter-types.index') }}"
                   class="btn btn-outline-secondary px-4">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection