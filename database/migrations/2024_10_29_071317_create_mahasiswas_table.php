<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) { 
            $table->id();  // ID primary key otomatis 
            $table->string('nama');  // Kolom nama mahasiswa 
            $table->string('nim')->unique();  // Kolom NIM unik 
            $table->string('jurusan');  // Kolom jurusan 
            $table->timestamps();  // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
