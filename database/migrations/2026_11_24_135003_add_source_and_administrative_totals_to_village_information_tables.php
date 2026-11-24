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
        Schema::table('village_profiles', function (Blueprint $table): void {
            $table->unsignedInteger('jumlah_dusun')->nullable();
            $table->unsignedInteger('jumlah_rw')->nullable();
            $table->unsignedInteger('jumlah_rt')->nullable();
            $table->text('sumber_data')->nullable();
            $table->unsignedSmallInteger('tahun_data')->nullable();
        });

        foreach (['village_boundaries', 'village_dusuns', 'village_geographies', 'village_land_uses'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table): void {
                $table->text('sumber_data')->nullable();
                $table->unsignedSmallInteger('tahun_data')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (['village_land_uses', 'village_geographies', 'village_dusuns', 'village_boundaries'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table): void {
                $table->dropColumn(['sumber_data', 'tahun_data']);
            });
        }

        Schema::table('village_profiles', function (Blueprint $table): void {
            $table->dropColumn(['jumlah_dusun', 'jumlah_rw', 'jumlah_rt', 'sumber_data', 'tahun_data']);
        });
    }
};
