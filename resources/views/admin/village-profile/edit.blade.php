@extends('layouts.admin')

@section('title', 'Profil Desa')
@section('page-title', 'Profil Desa')

@section('breadcrumb')
    <li class="breadcrumb-item active">Profil Desa</li>
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

        <form action="{{ route('admin.village-profile.update') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Logo Desa --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-image me-2"></i>Logo Desa
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-4">

                        {{-- Preview logo --}}
                        <div>
                            @if($village->logo)
                                <img src="{{ asset('storage/' . $village->logo) }}"
                                     alt="Logo Desa"
                                     class="rounded border"
                                     style="width:100px;height:100px;
                                            object-fit:contain;">
                            @else
                                <div class="rounded border d-flex align-items-center
                                            justify-content-center bg-light"
                                     style="width:100px;height:100px;">
                                    <i class="bi bi-building text-muted"
                                       style="font-size:2rem;"></i>
                                </div>
                            @endif
                        </div>

                        {{-- Input logo --}}
                        <div class="flex-grow-1">
                            <label class="form-label fw-semibold">
                                Upload Logo Baru
                            </label>
                            <input
                                type="file"
                                class="form-control @error('logo') is-invalid @enderror"
                                name="logo"
                                accept=".jpg,.jpeg,.png"
                                onchange="previewLogo(this)"
                            >
                            <div class="form-text">
                                Format: JPG, JPEG, PNG. Maksimal 2 MB.
                                Biarkan kosong jika tidak ingin mengganti logo.
                            </div>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Info Desa --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-house me-2"></i>Informasi Desa
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Desa <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('village_name') is-invalid @enderror"
                            name="village_name"
                            value="{{ old('village_name', $village->village_name) }}"
                            required
                        >
                        @error('village_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Alamat Kantor Desa <span class="text-danger">*</span>
                        </label>
                        <textarea
                            class="form-control @error('address') is-invalid @enderror"
                            name="address"
                            rows="3"
                            required
                        >{{ old('address', $village->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Nomor Telepon
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                name="phone"
                                value="{{ old('phone', $village->phone) }}"
                                placeholder="(0741) 123456"
                            >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Email Desa
                            </label>
                            <input
                                type="email"
                                class="form-control"
                                name="email"
                                value="{{ old('email', $village->email) }}"
                                placeholder="desa@email.com"
                            >
                        </div>
                    </div>

                </div>
            </div>

            {{-- Kepala Desa --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-person-badge me-2"></i>
                    Data Kepala Desa
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Kepala Desa <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('headman_name') is-invalid @enderror"
                            name="headman_name"
                            value="{{ old('headman_name', $village->headman_name) }}"
                            placeholder="Nama lengkap beserta gelar"
                            required
                        >
                        <div class="form-text">
                            Nama ini akan muncul di PDF surat sebagai
                            penanda tangan.
                        </div>
                        @error('headman_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-text-paragraph me-2"></i>
                    Deskripsi Desa
                </div>
                <div class="card-body">
                    <textarea
                        class="form-control"
                        name="description"
                        rows="5"
                        placeholder="Deskripsi singkat tentang desa..."
                    >{{ old('description', $village->description) }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('admin.dashboard') }}"
                   class="btn btn-outline-secondary px-4">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function previewLogo(input) {
    if (!input.files || !input.files[0]) return;

    const file   = input.files[0];
    const sizeMB = (file.size / 1048576).toFixed(2);

    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran logo terlalu besar (' + sizeMB + ' MB). Maksimal 2 MB.');
        input.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = e => {
        const imgs = document.querySelectorAll('img[alt="Logo Desa"]');
        imgs.forEach(img => {
            img.src = e.target.result;
        });
    };
    reader.readAsDataURL(file);
}
</script>
@endsection