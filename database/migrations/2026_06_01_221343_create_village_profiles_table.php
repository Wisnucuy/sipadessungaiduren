<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('village_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('village_name');             // Nama desa
            $table->text('address');                    // Alamat kantor desa
            $table->string('phone')->nullable();        // Nomor telepon desa
            $table->string('email')->nullable();        // Email desa
            $table->string('headman_name');             // Nama kepala desa
            $table->string('logo')->nullable();         // Path logo desa
            $table->text('description')->nullable();    // Deskripsi desa
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('village_profiles');
    }
};