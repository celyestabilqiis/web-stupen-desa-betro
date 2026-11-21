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
        Schema::create('umkm_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained()->cascadeOnDelete();
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('harga')->nullable();
            $table->string('satuan')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('tersedia')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_products');
    }
};
