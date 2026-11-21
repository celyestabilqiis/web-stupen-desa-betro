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
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_usaha');
            $table->string('slug')->unique();
            $table->string('kategori');
            $table->string('nama_pemilik')->nullable();
            $table->text('alamat')->nullable();
            $table->text('deskripsi_singkat')->nullable();
            $table->longText('deskripsi_lengkap')->nullable();
            $table->string('tahun_berdiri')->nullable();
            $table->string('jam_operasional')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('foto')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->boolean('is_demo')->default(false);
            $table->enum('status', ['draft', 'terbit'])->default('draft')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
