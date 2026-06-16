<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Memulai proses seeding database...');
        $this->command->newLine();

        // Urutan penting! Seeder yang saling bergantung harus urut
        $this->call([
            AdminUserSeeder::class,     // 1. Buat admin dulu
            VillageProfileSeeder::class, // 2. Profil desa
            LetterTypeSeeder::class,     // 3. Jenis surat
            UserSeeder::class,           // 4. Warga dummy
        ]);

        $this->command->newLine();
        $this->command->info('🎉 Semua data awal berhasil dibuat!');
        $this->command->newLine();
        $this->command->warn('⚠️  CATAT AKUN BERIKUT UNTUK LOGIN:');
        $this->command->newLine();
        $this->command->info('👨‍💼 ADMIN:');
        $this->command->line('   Email    : admin@desassd.id');
        $this->command->line('   Password : password123');
        $this->command->newLine();
        $this->command->info('👤 WARGA:');
        $this->command->line('   NIK      : 1504011234560001');
        $this->command->line('   Password : password123');
    }
}