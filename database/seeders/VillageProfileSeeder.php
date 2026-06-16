<?php

namespace Database\Seeders;

use App\Models\VillageProfile;
use Illuminate\Database\Seeder;

class VillageProfileSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama
        VillageProfile::truncate();

        VillageProfile::create([
            'village_name' => 'Desa Simpang Sungai Duren',
            'address'      => 'Jl. Simpang Sungai Duren No. 1, Kecamatan Jambi Luar Kota, Kabupaten Muaro Jambi, Provinsi Jambi',
            'phone'        => '(0741) 123456',
            'email'        => 'desasimpangsungaiduren@gmail.com',
            'headman_name' => 'H. Ahmad Fauzi, S.Sos',
            'logo'         => null,
            'description'  => 'Desa Simpang Sungai Duren adalah sebuah desa yang terletak di Kecamatan Jambi Luar Kota, Kabupaten Muaro Jambi, Provinsi Jambi. Desa ini berkomitmen untuk memberikan pelayanan administrasi terbaik kepada seluruh warganya melalui sistem digital yang modern dan mudah diakses.',
        ]);

        $this->command->info('✅ Profil desa berhasil dibuat.');
    }
}