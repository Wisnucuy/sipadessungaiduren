<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Nama admin
            $table->string('email')->unique();         // Email untuk login
            $table->string('password');                // Password terenkripsi
            $table->enum('role', ['superadmin', 'admin', 'operator'])
                  ->default('admin');                  // Role admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_users');
    }
};