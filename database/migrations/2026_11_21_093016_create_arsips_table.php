<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsips', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->enum('kategori', ['arsip_desa', 'dokumentasi_desa'])->index();
            $table->enum('tipe', ['artikel', 'pdf']);
            $table->string('ringkasan', 300)->nullable();
            $table->longText('isi')->nullable();
            $table->string('gambar_sampul')->nullable();
            $table->string('file_pdf')->nullable();
            $table->enum('status', ['draft', 'terbit'])->default('draft')->index();
            $table->date('tanggal')->index();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('jumlah_dilihat')->default(0);
            $table->timestamps();

            $table->index(['status', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsips');
    }
};
