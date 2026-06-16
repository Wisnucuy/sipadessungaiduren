<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')
                  ->constrained('applications')
                  ->onDelete('cascade');                 // Relasi ke pengajuan
            $table->string('old_status')->nullable();    // Status sebelumnya
            $table->string('new_status');                // Status baru
            $table->string('changed_by')->nullable();    // Nama yang mengubah
            $table->string('changed_by_type')
                  ->default('system');                   // 'warga', 'admin', 'system'
            $table->text('notes')->nullable();           // Catatan perubahan status
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_status_histories');
    }
};