<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')
                  ->constrained('applications')
                  ->onDelete('cascade');                 // Relasi ke pengajuan
            $table->string('document_type');             // Jenis dokumen (KTP, KK, dll)
            $table->string('file_path');                 // Path file di storage
            $table->string('file_name');                 // Nama file asli
            $table->integer('file_size');                // Ukuran file (bytes)
            $table->string('mime_type');                 // Tipe file (image/jpeg, dll)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};