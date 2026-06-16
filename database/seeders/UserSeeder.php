<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User::truncate();

        $users = [
            [
                'nik'     => '1504011234560001',
                'name'    => 'Ahmad Rizki',
                'email'   => 'ahmad.rizki@gmail.com',
                'phone'   => '081234567890',
                'address' => 'Jl. Melati No. 5 RT 001 RW 002, Desa Simpang Sungai Duren',
                'password' => Hash::make('password123'),
            ],
            [
                'nik'     => '1504011234560002',
                'name'    => 'Siti Rahayu',
                'email'   => 'siti.rahayu@gmail.com',
                'phone'   => '082345678901',
                'address' => 'Jl. Mawar No. 12 RT 003 RW 001, Desa Simpang Sungai Duren',
                'password' => Hash::make('password123'),
            ],
            [
                'nik'     => '1504011234560003',
                'name'    => 'Budi Prasetyo',
                'email'   => 'budi.prasetyo@gmail.com',
                'phone'   => '083456789012',
                'address' => 'Jl. Kenanga No. 8 RT 002 RW 003, Desa Simpang Sungai Duren',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('✅ Warga dummy berhasil dibuat.');
        $this->command->table(
            ['NIK', 'Nama', 'Password'],
            [
                ['1504011234560001', 'Ahmad Rizki',   'password123'],
                ['1504011234560002', 'Siti Rahayu',   'password123'],
                ['1504011234560003', 'Budi Prasetyo', 'password123'],
            ]
        );
    }
}