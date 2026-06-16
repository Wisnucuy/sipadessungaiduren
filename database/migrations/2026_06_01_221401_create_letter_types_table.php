<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letter_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');                     // Nama jenis surat
            $table->text('description')->nullable();    // Deskripsi surat
            $table->text('requirements')->nullable();   // Persyaratan dokumen (JSON)
            $table->string('processing_time')
                  ->default('3-5 hari kerja');          // Estimasi waktu proses
            $table->longText('template_content')
                  ->nullable();                         // Template isi surat
            $table->boolean('is_active')->default(true); // Aktif/nonaktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letter_types');
    }
};