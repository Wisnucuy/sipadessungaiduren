@extends('layouts.admin')

@section('title', 'Edit Jenis Surat')
@section('page-title', 'Edit Jenis Surat')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.letter-types.index') }}">Jenis Surat</a>
    </li>
    <li class="breadcrumb-item active">Edit</li>
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

        <form action="{{ route('admin.letter-types.update', $letterType->id) }}"
              method="POST">
            @csrf
            @method('PUT')

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
                            value="{{ old('name', $letterType->name) }}"
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
                        >{{ old('description', $letterType->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Estimasi Waktu Proses
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            name="processing_time"
                            value="{{ old('processing_time',
                                $letterType->processing_time) }}"
                            required
                        >
                    </div>

                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="is_active"
                            id="is_active"
                            {{ old('is_active', $letterType->is_active)
                                ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="is_active">
                            Aktifkan jenis surat ini
                        </label>
                    </div>

                </div>
            </div>

            {{-- Persyaratan --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-list-check me-2"></i>
                    Persyaratan Dokumen
                </div>
                <div class="card-body">
                    @php
                        $reqs = is_array($letterType->requirements)
                            ? $letterType->requirements
                            : (json_decode($letterType->requirements, true) ?? []);
                        $reqsText = implode("\n", $reqs);
                    @endphp
                    <textarea
                        class="form-control"
                        name="requirements"
                        rows="6"
                        placeholder="Satu persyaratan per baris..."
                    >{{ old('requirements', $reqsText) }}</textarea>
                    <div class="form-text">
                        Tulis satu persyaratan per baris.
                    </div>
                </div>
            </div>

            {{-- Template --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-file-text me-2"></i>
                    Template Isi Surat
                </div>
                <div class="card-body">
                    <textarea
                        class="form-control"
                        name="template_content"
                        rows="6"
                    >{{ old('template_content', $letterType->template_content) }}</textarea>
                    <div class="form-text">
                        Placeholder:
                        <code>[NAMA_WARGA]</code>,
                        <code>[NIK]</code>,
                        <code>[ALAMAT]</code>,
                        <code>[KEPERLUAN]</code>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
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