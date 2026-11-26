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
        Schema::dropIfExists('village_maps');
        Schema::dropIfExists('village_land_uses');
        Schema::dropIfExists('village_geographies');
        Schema::dropIfExists('village_dusuns');
        Schema::dropIfExists('village_boundaries');
        Schema::dropIfExists('village_profiles');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('village_profiles', function (Blueprint $table): void {
            $table->id();
            $table->string('nama_desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('kode_wilayah', 32)->nullable();
            $table->decimal('luas_wilayah', 14, 4)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->unsignedInteger('jumlah_dusun')->nullable();
            $table->unsignedInteger('jumlah_rw')->nullable();
            $table->unsignedInteger('jumlah_rt')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->text('sumber_data')->nullable();
            $table->unsignedSmallInteger('tahun_data')->nullable();
            $table->timestamps();
        });

        Schema::create('village_boundaries', function (Blueprint $table): void {
            $table->id();
            $table->string('arah', 16)->unique();
            $table->string('wilayah_berbatasan');
            $table->text('deskripsi')->nullable();
            $table->text('sumber_data')->nullable();
            $table->unsignedSmallInteger('tahun_data')->nullable();
            $table->timestamps();
        });

        Schema::create('village_dusuns', function (Blueprint $table): void {
            $table->id();
            $table->string('nama_dusun')->unique();
            $table->unsignedInteger('jumlah_rw')->nullable();
            $table->unsignedInteger('jumlah_rt')->nullable();
            $table->decimal('luas_wilayah', 14, 4)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('status')->default(false)->index();
            $table->text('sumber_data')->nullable();
            $table->unsignedSmallInteger('tahun_data')->nullable();
            $table->timestamps();
        });

        Schema::create('village_geographies', function (Blueprint $table): void {
            $table->id();
            $table->string('nama_informasi')->unique();
            $table->string('nilai')->nullable();
            $table->string('satuan', 80)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('status')->default(false)->index();
            $table->text('sumber_data')->nullable();
            $table->unsignedSmallInteger('tahun_data')->nullable();
            $table->timestamps();
        });

        Schema::create('village_land_uses', function (Blueprint $table): void {
            $table->id();
            $table->string('nama_kategori')->unique();
            $table->decimal('luas', 14, 4)->nullable();
            $table->string('satuan', 80)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('status')->default(false)->index();
            $table->text('sumber_data')->nullable();
            $table->unsignedSmallInteger('tahun_data')->nullable();
            $table->timestamps();
        });

        Schema::create('village_maps', function (Blueprint $table): void {
            $table->id();
            $table->string('nama_peta')->nullable();
            $table->string('gambar')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('map_url', 2048)->nullable();
            $table->longText('boundary_geojson')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('status')->default(false)->index();
            $table->timestamps();
        });
    }
};
