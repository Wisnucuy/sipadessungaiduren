<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama agar tidak duplikat saat seeder dijalankan ulang
        // AdminUser::truncate();

        $admins = [
            [
                'name'     => 'Super Admin',
                'email'    => 'superadmin@desassd.id',
                'password' => Hash::make('password123'),
                'role'     => 'superadmin',
            ],
            [
                'name'     => 'Budi Santoso',
                'email'    => 'admin@desassd.id',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
            ],
            [
                'name'     => 'Siti Aminah',
                'email'    => 'operator@desassd.id',
                'password' => Hash::make('password123'),
                'role'     => 'operator',
            ],
        ];

        foreach ($admins as $admin) {
            AdminUser::create($admin);
        }

        $this->command->info('✅ Admin users berhasil dibuat.');
        $this->command->table(
            ['Nama', 'Email', 'Password', 'Role'],
            [
                ['Super Admin', 'superadmin@desassd.id', 'password123', 'superadmin'],
                ['Budi Santoso', 'admin@desassd.id',     'password123', 'admin'],
                ['Siti Aminah', 'operator@desassd.id',   'password123', 'operator'],
            ]
        );
    }
}