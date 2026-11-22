<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statistic_categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori')->unique();
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('ikon', 50)->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('status')->default(true)->index();
            $table->timestamps();
        });

        $now = now();
        DB::table('statistic_categories')->insert([
            ['nama_kategori' => 'Kependudukan', 'slug' => 'kependudukan', 'deskripsi' => 'Data agregat penduduk Desa Betro.', 'ikon' => '👥', 'urutan' => 1, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Pendidikan', 'slug' => 'pendidikan', 'deskripsi' => 'Data pendidikan masyarakat.', 'ikon' => '📚', 'urutan' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Pekerjaan', 'slug' => 'pekerjaan', 'deskripsi' => 'Data pekerjaan dan mata pencaharian masyarakat.', 'ikon' => '🧰', 'urutan' => 3, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Wilayah', 'slug' => 'wilayah', 'deskripsi' => 'Data wilayah administratif Desa Betro.', 'ikon' => '🗺️', 'urutan' => 4, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Fasilitas Umum', 'slug' => 'fasilitas-umum', 'deskripsi' => 'Data fasilitas umum di Desa Betro.', 'ikon' => '🏫', 'urutan' => 5, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Ekonomi dan UMKM', 'slug' => 'ekonomi-dan-umkm', 'deskripsi' => 'Data kegiatan ekonomi dan UMKM.', 'ikon' => '💼', 'urutan' => 6, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistic_categories');
    }
};
