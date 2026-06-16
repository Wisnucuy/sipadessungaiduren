@extends('layouts.app')

@section('title', 'Ajukan Surat')
@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('warga.dashboard') }}">Dashboard</a>
    </div>
    <div class="breadcrumb-item active">Ajukan Surat</div>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Header --}}
<div class="d-flex align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Ajukan Surat Baru</h4>
        <p class="text-muted mb-0 small">
            Isi formulir di bawah ini dengan lengkap dan benar
        </p>
    </div>
</div>

            {{-- Error validasi (hanya tampil jika form disubmit) --}}
            @if($errors->any() && old('_submitted'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Terdapat kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ════════════════════════════════════
                 LANGKAH 1: Pilih Jenis Surat
                 (Form GET terpisah, tidak submit data)
            ════════════════════════════════════ --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-1-circle-fill text-success me-2"></i>
                    Pilih Jenis Surat
                </div>
                <div class="card-body">

                    {{-- Form GET untuk pilih jenis surat --}}
                    <form method="GET" action="{{ route('warga.applications.create') }}"
                          id="formPilihSurat">
                        <div class="mb-3">
                            <label for="letter_type_id" class="form-label fw-semibold">
                                Jenis Surat <span class="text-danger">*</span>
                            </label>
                            <select
                                class="form-select"
                                id="letter_type_id"
                                name="letter_type_id"
                                onchange="document.getElementById('formPilihSurat').submit()"
                            >
                                <option value="">-- Pilih Jenis Surat --</option>
                                @foreach($letterTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ request('letter_type_id') == $type->id
                                            ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    {{-- Info jenis surat yang dipilih --}}
                    @if($selectedLetterType)
                        <div class="alert alert-info mb-0">
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <p class="mb-1 fw-semibold">
                                        {{ $selectedLetterType->name }}
                                    </p>
                                    <p class="mb-2 small">
                                        {{ $selectedLetterType->description }}
                                    </p>
                                    <p class="mb-0 small">
                                        <i class="bi bi-clock me-1"></i>
                                        Estimasi waktu proses:
                                        <strong>
                                            {{ $selectedLetterType->processing_time }}
                                        </strong>
                                    </p>
                                </div>
                                <div class="col-md-5">
                                    <p class="mb-1 fw-semibold small">
                                        Persyaratan Dokumen:
                                    </p>
                                    <ul class="mb-0 small ps-3">
    @php
        $requirements = is_array($selectedLetterType->requirements)
            ? $selectedLetterType->requirements
            : (json_decode($selectedLetterType->requirements, true) ?? []);
    @endphp
    @foreach($requirements as $req)
        <li>{{ $req }}</li>
    @endforeach
</ul>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            {{-- ════════════════════════════════════
                 FORM UTAMA: Isi & Upload
                 (Hanya muncul jika jenis surat dipilih)
            ════════════════════════════════════ --}}
            @if($selectedLetterType)

            <form action="{{ route('warga.applications.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="formPengajuan">
                @csrf

                {{-- Field tersembunyi: tandai bahwa ini submit utama --}}
                <input type="hidden" name="_submitted" value="1">

                {{-- Field tersembunyi: kirim letter_type_id yang sudah dipilih --}}
                <input type="hidden"
                       name="letter_type_id"
                       value="{{ $selectedLetterType->id }}">

                {{-- LANGKAH 2: Isi Keperluan ──────────────────── --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-2-circle-fill text-success me-2"></i>
                        Isi Keperluan Surat
                    </div>
                    <div class="card-body">

                        {{-- Data warga (readonly) --}}
                        <div class="alert alert-light border mb-4">
                            <p class="fw-semibold mb-2 small text-muted text-uppercase">
                                Data Pemohon (dari akun Anda)
                            </p>
                            <div class="row g-2 small">
                                <div class="col-md-6">
                                    <span class="text-muted">Nama:</span>
                                    <span class="fw-semibold ms-1">
                                        {{ Auth::guard('web')->user()->name }}
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span class="text-muted">NIK:</span>
                                    <span class="fw-semibold ms-1">
                                        {{ Auth::guard('web')->user()->nik }}
                                    </span>
                                </div>
                                <div class="col-12">
                                    <span class="text-muted">Alamat:</span>
                                    <span class="fw-semibold ms-1">
                                        {{ Auth::guard('web')->user()->address }}
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span class="text-muted">No. HP:</span>
                                    <span class="fw-semibold ms-1">
                                        {{ Auth::guard('web')->user()->phone ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Data Identitas Tambahan --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Contoh: Jambi" required>
                                @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="agama" class="form-label fw-semibold">Agama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama" value="{{ old('agama') }}" placeholder="Contoh: Islam" required>
                                @error('agama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-12">
                                <label for="pekerjaan" class="form-label fw-semibold">Pekerjaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Contoh: Petani" required>
                                @error('pekerjaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Keperluan Surat --}}
                        <div>
                            <label for="purpose" class="form-label fw-semibold">
                                Keperluan Surat
                                <span class="text-danger">*</span>
                            </label>
                            <textarea
                                class="form-control @error('purpose') is-invalid @enderror"
                                id="purpose"
                                name="purpose"
                                rows="4"
                                placeholder="Jelaskan keperluan Anda secara detail..."
                                required
                            >{{ old('purpose') }}</textarea>
                            <div class="form-text">
                                Minimal 10 karakter. Contoh:
                                "Untuk keperluan pendaftaran beasiswa di Universitas Jambi."
                            </div>
                            @error('purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- LANGKAH 3: Upload Dokumen ─────────────────── --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-3-circle-fill text-success me-2"></i>
                        Upload Dokumen Persyaratan
                    </div>
                    <div class="card-body">

                        <div class="alert alert-warning small mb-4">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Format: <strong>JPG, JPEG, PNG, PDF</strong> —
                            Maksimal <strong>5 MB</strong> per file.
                        </div>

                        {{-- KTP --}}
                        <div class="mb-4 p-3 border rounded">
                            <label for="ktp" class="form-label fw-semibold">
                                <i class="bi bi-person-vcard me-1 text-success"></i>
                                KTP (Kartu Tanda Penduduk)
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                type="file"
                                class="form-control @error('ktp') is-invalid @enderror"
                                id="ktp"
                                name="ktp"
                                accept=".jpg,.jpeg,.png,.pdf"
                                onchange="previewFile(this, 'preview_ktp')"
                                required
                            >
                            <div id="preview_ktp" class="mt-2"></div>
                            @error('ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- KK --}}
                        <div class="mb-4 p-3 border rounded">
                            <label for="kk" class="form-label fw-semibold">
                                <i class="bi bi-people me-1 text-success"></i>
                                KK (Kartu Keluarga)
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                type="file"
                                class="form-control @error('kk') is-invalid @enderror"
                                id="kk"
                                name="kk"
                                accept=".jpg,.jpeg,.png,.pdf"
                                onchange="previewFile(this, 'preview_kk')"
                                required
                            >
                            <div id="preview_kk" class="mt-2"></div>
                            @error('kk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Surat Pengantar RT --}}
                        <div class="mb-4 p-3 border rounded">
                            <label for="surat_pengantar_rt" class="form-label fw-semibold">
                                <i class="bi bi-file-earmark-text me-1 text-success"></i>
                                Surat Pengantar RT
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                type="file"
                                class="form-control @error('surat_pengantar_rt') is-invalid @enderror"
                                id="surat_pengantar_rt"
                                name="surat_pengantar_rt"
                                accept=".jpg,.jpeg,.png,.pdf"
                                onchange="previewFile(this, 'preview_rt')"
                                required
                            >
                            <div id="preview_rt" class="mt-2"></div>
                            @error('surat_pengantar_rt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dokumen Pendukung --}}
                        <div class="p-3 border rounded border-dashed">
                            <label for="dokumen_pendukung" class="form-label fw-semibold">
                                <i class="bi bi-paperclip me-1 text-secondary"></i>
                                Dokumen Pendukung
                                <span class="badge bg-secondary ms-1"
                                      style="font-size:0.7rem;">
                                    Opsional
                                </span>
                            </label>
                            <input
                                type="file"
                                class="form-control @error('dokumen_pendukung') is-invalid @enderror"
                                id="dokumen_pendukung"
                                name="dokumen_pendukung"
                                accept=".jpg,.jpeg,.png,.pdf"
                                onchange="previewFile(this, 'preview_pendukung')"
                            >
                            <div id="preview_pendukung" class="mt-2"></div>
                            <div class="form-text">
                                Upload jika ada dokumen tambahan yang diperlukan.
                            </div>
                            @error('dokumen_pendukung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- LANGKAH 4: Konfirmasi & Submit ──────────────── --}}
                <div class="card mb-4">
                    <div class="card-body">

                        {{-- Error validasi di sini --}}
                        @if($errors->any())
                            <div class="alert alert-danger mb-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Terdapat kesalahan, periksa kembali:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-check mb-3">
                            <input type="checkbox"
                                   class="form-check-input"
                                   id="confirm"
                                   required>
                            <label class="form-check-label" for="confirm">
                                Saya menyatakan bahwa data dan dokumen yang saya upload
                                adalah <strong>benar dan valid</strong>.
                            </label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit"
                                    class="btn btn-success btn-lg px-5">
                                <i class="bi bi-send me-2"></i>Kirim Pengajuan
                            </button>
                            <a href="{{ route('warga.dashboard') }}"
                               class="btn btn-outline-secondary btn-lg">
                                Batal
                            </a>
                        </div>

                    </div>
                </div>

            </form>

            @else
                {{-- Instruksi jika belum pilih jenis surat --}}
                <div class="card">
                    <div class="card-body text-center py-5 text-muted">
                        <i class="bi bi-arrow-up-circle"
                           style="font-size:3rem;"></i>
                        <p class="mt-3 mb-0 fw-semibold">
                            Pilih jenis surat terlebih dahulu
                        </p>
                        <p class="small">
                            Formulir pengajuan akan muncul setelah
                            Anda memilih jenis surat di atas.
                        </p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function previewFile(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';

    if (!input.files || !input.files[0]) return;

    const file   = input.files[0];
    const sizeMB = (file.size / 1048576).toFixed(2);

    // Validasi ukuran
    if (file.size > 5 * 1024 * 1024) {
        preview.innerHTML = `
            <div class="alert alert-danger py-2 small mt-1">
                <i class="bi bi-x-circle me-1"></i>
                File terlalu besar (${sizeMB} MB). Maksimal 5 MB.
            </div>`;
        input.value = '';
        return;
    }

    const ext  = file.name.split('.').pop().toLowerCase();
    let icon   = 'bi-file-earmark';
    if (['jpg','jpeg','png'].includes(ext)) icon = 'bi-file-image text-primary';
    if (ext === 'pdf') icon = 'bi-file-earmark-pdf text-danger';

    preview.innerHTML = `
        <div class="d-flex align-items-center gap-2 p-2 bg-light rounded small mt-1">
            <i class="bi ${icon} fs-5"></i>
            <div>
                <div class="fw-semibold">${file.name}</div>
                <div class="text-muted">${sizeMB} MB</div>
            </div>
            <i class="bi bi-check-circle-fill text-success ms-auto"></i>
        </div>`;

    // Preview gambar
    if (['jpg','jpeg','png'].includes(ext)) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.innerHTML += `
                <img src="${e.target.result}"
                     class="img-thumbnail mt-2"
                     style="max-height:150px;max-width:250px;">`;
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection