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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('statistic_categories')->restrictOnDelete();
            $table->string('nama_statistik');
            $table->string('slug');
            $table->decimal('nilai', 18, 4);
            $table->string('satuan', 50)->nullable();
            $table->unsignedSmallInteger('tahun');
            $table->text('deskripsi')->nullable();
            $table->string('sumber_data')->nullable();
            $table->string('ikon', 50)->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('tampil_di_ringkasan')->default(false);
            $table->string('status', 20)->default('aktif')->index();
            $table->timestamps();
            $table->unique(['category_id', 'slug', 'tahun']);
            $table->index(['tahun', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
