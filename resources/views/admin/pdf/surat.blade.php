<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $application->letterType->name }}</title>
    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            margin: 15mm 30mm 15mm 30mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            color: #000;
            background: #fff;
            line-height: 1.45;
            margin: 0;
        }

        .page {
            width: 100%;
            padding: 0;
        }

        /* ── KOP SURAT ───────────────────────────── */
        .kop-surat {
            width: 100%;
            margin-bottom: 10px;
        }

        .kop-table {
            width: 100%;
        }

        .kop-table td {
            vertical-align: middle;
            padding: 0;
        }

        .kop-logo-cell {
            width: 75px;
            text-align: center;
        }

        .kop-logo-cell img {
            width: 62px;
            height: 62px;
            object-fit: contain;
        }

        .kop-logo-placeholder {
            width: 65px;
            height: 65px;
            border: 2px solid #000;
            border-radius: 50%;
            text-align: center;
            line-height: 65px;
            font-size: 9pt;
            font-weight: bold;
            display: inline-block;
        }

        .kop-tengah {
            text-align: center;
            padding: 0 8px;
        }

        .kop-tengah .prov {
            font-size: 10pt;
            line-height: 1.4;
        }

        .kop-tengah .desa {
            font-size: 20pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.2;
        }

        .kop-tengah .alamat {
            font-size: 8.5pt;
            line-height: 1.5;
            margin-top: 2px;
        }

        .kop-garis {
            border: none;
            border-top: 4px double #000;
            margin: 8px 0 14px 0;
        }

        /* ── JUDUL SURAT ─────────────────────────── */
        .judul-box {
            text-align: center;
            margin: 14px 0 4px 0;
        }

        .judul-box h2 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            letter-spacing: 0.5px;
        }

        .nomor-box {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 18px;
        }

        /* ── ISI SURAT ───────────────────────────── */
        .paragraf {
            text-align: justify;
            margin-bottom: 8px;
            font-size: 11.5pt;
            line-height: 1.45;
            width: 100%;
        }

        /* ── Tabel Data Warga ────────────────────── */
        .tabel-data {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin: 10px auto 14px auto;
        }

        .tabel-data tr td {
            font-size: 11.5pt;
            padding: 1px 0;
            vertical-align: top;
            line-height: 1.45;
            word-wrap: break-word;
            overflow-wrap: anywhere;
        }

        .tabel-data tr td:nth-child(1) {
            width: 145px;
            padding-left: 12px;
        }

        /* Kolom titik dua */
        .tabel-data tr td:nth-child(2) {
            width: 15px;
            text-align: center;
        }

        /* Kolom nilai */
        .tabel-data tr td:nth-child(3) {
            font-weight: bold;
        }

        /* ── Kotak Keperluan ─────────────────────── */
        .kotak-keperluan {
            border: 1px solid #333;
            padding: 7px 10px;
            margin: 8px auto 12px auto;
            background: #fafafa;
            width: 100%;
        }

        .kotak-keperluan .label {
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 4px;
        }

        .kotak-keperluan .isi {
            font-size: 11.5pt;
            line-height: 1.45;
            word-wrap: break-word;
            overflow-wrap: anywhere;
        }

        /* ── TANDA TANGAN ────────────────────────── */
        .ttd-area {
            margin-top: 28px;
            width: 100%;
        }

        .ttd-table {
            width: 100%;
            margin: 0 auto;
        }

        .ttd-table td {
            vertical-align: top;
            padding: 0;
        }

        .ttd-kiri {
            width: 50%;
        }

        .ttd-kanan {
            width: 50%;
            text-align: center;
        }

        .ttd-kanan .kota-tanggal {
            font-size: 11pt;
            margin-bottom: 3px;
        }

        .ttd-kanan .jabatan {
            font-size: 12pt;
            font-weight: bold;
        }

        .ttd-kanan .ruang {
            height: 65px;
        }

        .ttd-kanan .nama {
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
        }

        .ttd-kanan .nip {
            font-size: 10pt;
            margin-top: 2px;
        }

        /* ── FOOTER ──────────────────────────────── */
        .footer-doc {
            margin-top: 30px;
            padding-top: 6px;
            border-top: 1px dashed #aaa;
            font-size: 8pt;
            color: #666;
            text-align: center;
            line-height: 1.5;
        }

    </style>
</head>
<body>
<div class="page">

    {{-- ══════════════════════════════
         KOP SURAT
    ══════════════════════════════ --}}
    <div class="kop-surat">
        <table class="kop-table">
            <tr>
                {{-- Logo --}}
                <td class="kop-logo-cell">
                    @if($village->logo && file_exists(storage_path('app/public/' . $village->logo)))
                        <img src="{{ storage_path('app/public/' . $village->logo) }}"
                             alt="Logo Desa {{ $village->village_name }}">
                    @else
                        <div class="kop-logo-placeholder">LOGO</div>
                    @endif
                </td>

                {{-- Teks Kop --}}
                <td class="kop-tengah">
                    <div class="prov">PEMERINTAH KABUPATEN MUARO JAMBI</div>
                    <div class="prov">KECAMATAN JAMBI LUAR KOTA</div>
                    <div class="desa">{{ strtoupper($village->village_name) }}</div>
                    <div class="alamat">
                        {{ $village->address }}
                        @if($village->phone)
                            &nbsp;|&nbsp; Telp: {{ $village->phone }}
                        @endif
                        @if($village->email)
                            &nbsp;|&nbsp; Email: {{ $village->email }}
                        @endif
                    </div>
                </td>

                {{-- Sisi kanan kosong (keseimbangan) --}}
                <td style="width:75px;"></td>
            </tr>
        </table>
    </div>

    {{-- Garis kop --}}
    <hr class="kop-garis">

    {{-- ══════════════════════════════
         JUDUL SURAT
    ══════════════════════════════ --}}
    <div class="judul-box">
        <h2>{{ strtoupper($application->letterType->name) }}</h2>
    </div>
    <div class="nomor-box">
        Nomor&nbsp;:&nbsp;{{ $nomorSurat }}
    </div>

    {{-- ══════════════════════════════
         ISI SURAT
    ══════════════════════════════ --}}

    {{-- Paragraf pembuka --}}
    <div class="paragraf">
        Yang bertanda tangan di bawah ini, Kepala {{ $village->village_name }},
        Kecamatan Jambi Luar Kota, Kabupaten Muaro Jambi, Provinsi Jambi,
        dengan ini <strong>menerangkan</strong> bahwa:
    </div>

    {{-- Tabel data warga --}}
    <table class="tabel-data">
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{ $application->user->name }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $application->user->nik }}</td>
        </tr>
        <tr>
            <td>Tempat / Tgl Lahir</td>
            <td>:</td>
            <td>
                @if(!empty($application->applicant_data['tempat_lahir']))
                    {{ $application->applicant_data['tempat_lahir'] }},
                    {{ $application->applicant_data['tanggal_lahir'] ?? '-' }}
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>
                {{ $application->applicant_data['jenis_kelamin'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $application->applicant_data['agama'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $application->applicant_data['pekerjaan'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $application->user->address }}</td>
        </tr>
    </table>

    {{-- Paragraf isi --}}
    <div class="paragraf">
        Adalah benar merupakan warga {{ $village->village_name }} yang mengajukan
        <strong>{{ $application->letterType->name }}</strong> untuk keperluan:
    </div>

    {{-- Kotak keperluan --}}
    <div class="kotak-keperluan">
        <div class="label">Keperluan:</div>
        <div class="isi">{{ $application->purpose }}</div>
    </div>

    {{-- Paragraf penutup --}}
    <div class="paragraf">
        Demikian surat keterangan ini dibuat dengan sebenarnya untuk
        dapat dipergunakan sebagaimana mestinya.
    </div>

    {{-- ══════════════════════════════
         TANDA TANGAN
    ══════════════════════════════ --}}
    <div class="ttd-area">
        <table class="ttd-table">
            <tr>
                <td class="ttd-kiri"></td>
                <td class="ttd-kanan">
                    <div class="kota-tanggal">
                        {{ $village->village_name }}, {{ $tanggal }}
                    </div>
                    <div class="jabatan">Kepala Desa</div>
                    <div class="ruang"></div>
                    <div class="nama">{{ $village->headman_name ?? 'Kepala Desa' }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ══════════════════════════════
         FOOTER
    ══════════════════════════════ --}}
    <div class="footer-doc">
        Dokumen ini digenerate secara otomatis oleh Sistem Pelayanan Administrasi Surat
        {{ $village->village_name }} pada {{ now()->format('d/m/Y H:i') }} WIB.
        &nbsp;|&nbsp; No. Pengajuan: {{ $application->application_number }}
    </div>

</div>
</body>
</html>