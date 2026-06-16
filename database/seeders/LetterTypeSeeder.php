<?php

namespace Database\Seeders;

use App\Models\LetterType;
use Illuminate\Database\Seeder;

class LetterTypeSeeder extends Seeder
{
    public function run(): void
    {
        // LetterType::truncate();

        $letterTypes = [

            // 1. Surat Keterangan Tidak Mampu
            [
                'name'             => 'Surat Keterangan Tidak Mampu',
                'description'      => 'Surat keterangan yang menyatakan bahwa pemohon termasuk dalam kategori masyarakat kurang mampu secara ekonomi. Digunakan untuk keperluan beasiswa, keringanan biaya pengobatan, dan bantuan sosial lainnya.',
                'requirements'     => json_encode([
                    'KTP pemohon',
                    'Kartu Keluarga (KK)',
                    'Surat Pengantar RT/RW',
                    'Surat Keterangan Penghasilan dari RT',
                ]),
                'processing_time'  => '1-2 hari kerja',
                'template_content' => 'Yang bertanda tangan di bawah ini, Kepala Desa Simpang Sungai Duren, Kecamatan Jambi Luar Kota, Kabupaten Muaro Jambi, dengan ini menerangkan bahwa: Nama [NAMA_WARGA], NIK [NIK], yang beralamat di [ALAMAT], adalah benar merupakan warga Desa Simpang Sungai Duren yang tergolong dalam keluarga tidak mampu. Surat keterangan ini dibuat untuk keperluan [KEPERLUAN] dan berlaku selama diperlukan.',
                'is_active'        => true,
            ],

            // 2. Surat Keterangan Domisili
            [
                'name'             => 'Surat Keterangan Domisili',
                'description'      => 'Surat keterangan yang menyatakan bahwa pemohon benar-benar bertempat tinggal di wilayah Desa Simpang Sungai Duren. Digunakan untuk keperluan pembuatan rekening bank, pendaftaran sekolah, dan keperluan administrasi lainnya.',
                'requirements'     => json_encode([
                    'KTP pemohon',
                    'Kartu Keluarga (KK)',
                    'Surat Pengantar RT/RW',
                ]),
                'processing_time'  => '1-2 hari kerja',
                'template_content' => 'Yang bertanda tangan di bawah ini, Kepala Desa Simpang Sungai Duren, Kecamatan Jambi Luar Kota, Kabupaten Muaro Jambi, dengan ini menerangkan bahwa: Nama [NAMA_WARGA], NIK [NIK], adalah benar merupakan warga yang berdomisili di [ALAMAT], Desa Simpang Sungai Duren. Surat keterangan domisili ini dibuat untuk keperluan [KEPERLUAN] dan berlaku selama diperlukan.',
                'is_active'        => true,
            ],

            // 3. Surat Keterangan Usaha
            [
                'name'             => 'Surat Keterangan Usaha',
                'description'      => 'Surat keterangan yang menyatakan bahwa pemohon menjalankan usaha di wilayah Desa Simpang Sungai Duren. Digunakan untuk keperluan permohonan kredit usaha, perizinan, dan keperluan bisnis lainnya.',
                'requirements'     => json_encode([
                    'KTP pemohon',
                    'Kartu Keluarga (KK)',
                    'Surat Pengantar RT/RW',
                    'Foto lokasi usaha',
                    'Dokumen pendukung usaha (jika ada)',
                ]),
                'processing_time'  => '2-3 hari kerja',
                'template_content' => 'Yang bertanda tangan di bawah ini, Kepala Desa Simpang Sungai Duren, Kecamatan Jambi Luar Kota, Kabupaten Muaro Jambi, dengan ini menerangkan bahwa: Nama [NAMA_WARGA], NIK [NIK], yang beralamat di [ALAMAT], adalah benar menjalankan usaha di wilayah Desa Simpang Sungai Duren. Surat keterangan usaha ini dibuat untuk keperluan [KEPERLUAN].',
                'is_active'        => true,
            ],

            // 4. Surat Keterangan Kelahiran
            [
                'name'             => 'Surat Keterangan Kelahiran',
                'description'      => 'Surat keterangan yang menyatakan kelahiran seorang bayi di wilayah Desa Simpang Sungai Duren. Digunakan sebagai syarat pembuatan akta kelahiran di Dinas Kependudukan dan Catatan Sipil.',
                'requirements'     => json_encode([
                    'KTP ayah dan ibu',
                    'Kartu Keluarga (KK)',
                    'Surat Pengantar RT/RW',
                    'Surat keterangan lahir dari bidan/dokter/rumah sakit',
                    'Buku nikah orang tua',
                ]),
                'processing_time'  => '1-2 hari kerja',
                'template_content' => 'Yang bertanda tangan di bawah ini, Kepala Desa Simpang Sungai Duren, Kecamatan Jambi Luar Kota, Kabupaten Muaro Jambi, dengan ini menerangkan bahwa telah lahir seorang bayi dengan nama [NAMA_BAYI], jenis kelamin [JENIS_KELAMIN], lahir pada tanggal [TANGGAL_LAHIR], anak dari [NAMA_AYAH] dan [NAMA_IBU], yang beralamat di [ALAMAT].',
                'is_active'        => true,
            ],

            // 5. Surat Keterangan Kematian
            [
                'name'             => 'Surat Keterangan Kematian',
                'description'      => 'Surat keterangan yang menyatakan bahwa seseorang telah meninggal dunia di wilayah Desa Simpang Sungai Duren. Digunakan untuk pengurusan akta kematian dan keperluan administrasi terkait.',
                'requirements'     => json_encode([
                    'KTP almarhum/almarhumah',
                    'Kartu Keluarga (KK)',
                    'Surat Pengantar RT/RW',
                    'Surat keterangan kematian dari dokter/rumah sakit (jika ada)',
                    'KTP pelapor',
                ]),
                'processing_time'  => '1 hari kerja',
                'template_content' => 'Yang bertanda tangan di bawah ini, Kepala Desa Simpang Sungai Duren, Kecamatan Jambi Luar Kota, Kabupaten Muaro Jambi, dengan ini menerangkan bahwa benar telah meninggal dunia: Nama [NAMA_ALMARHUM], NIK [NIK], yang beralamat di [ALAMAT], pada hari [HARI], tanggal [TANGGAL_MENINGGAL].',
                'is_active'        => true,
            ],

            // 6. Surat Pengantar SKCK
            [
                'name'             => 'Surat Pengantar SKCK',
                'description'      => 'Surat pengantar dari desa untuk pembuatan Surat Keterangan Catatan Kepolisian (SKCK) di Kepolisian. Digunakan untuk keperluan melamar pekerjaan, pendaftaran sekolah kedinasan, dan keperluan lainnya.',
                'requirements'     => json_encode([
                    'KTP pemohon',
                    'Kartu Keluarga (KK)',
                    'Surat Pengantar RT/RW',
                    'Pas foto terbaru 4x6 (2 lembar)',
                    'Fotokopi ijazah terakhir',
                ]),
                'processing_time'  => '1-2 hari kerja',
                'template_content' => 'Yang bertanda tangan di bawah ini, Kepala Desa Simpang Sungai Duren, Kecamatan Jambi Luar Kota, Kabupaten Muaro Jambi, dengan ini menerangkan bahwa: Nama [NAMA_WARGA], NIK [NIK], yang beralamat di [ALAMAT], adalah benar merupakan warga Desa Simpang Sungai Duren yang berkelakuan baik dan tidak pernah terlibat tindak kriminal selama berdomisili di desa ini. Surat pengantar ini dibuat untuk keperluan pembuatan SKCK.',
                'is_active'        => true,
            ],

        ];

        foreach ($letterTypes as $type) {
            LetterType::create($type);
        }

        $this->command->info('✅ ' . count($letterTypes) . ' jenis surat berhasil dibuat.');
    }
}