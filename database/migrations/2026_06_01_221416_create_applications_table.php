<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_number')->unique(); // Nomor pengajuan unik
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');                 // Relasi ke tabel users
            $table->foreignId('letter_type_id')
                  ->constrained('letter_types')
                  ->onDelete('cascade');                 // Relasi ke jenis surat
            $table->enum('status', [
                'pending',
                'verifying',
                'approved',
                'rejected',
                'completed'
            ])->default('pending');                      // Status pengajuan
            $table->text('purpose');                     // Keperluan surat
            $table->json('applicant_data')->nullable();  // Data tambahan pemohon
            $table->text('notes')->nullable();           // Catatan admin
            $table->foreignId('reviewed_by')
                  ->nullable()
                  ->constrained('admin_users')
                  ->onDelete('set null');                // Admin yang review
            $table->timestamp('reviewed_at')->nullable(); // Waktu direview
            $table->timestamp('completed_at')->nullable(); // Waktu selesai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};