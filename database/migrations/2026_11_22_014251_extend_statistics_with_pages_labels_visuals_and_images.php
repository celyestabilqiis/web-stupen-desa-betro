<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistic_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true)->index();
            $table->timestamps();
        });

        Schema::table('statistic_categories', function (Blueprint $table) {
            $table->foreignId('page_id')->nullable()->after('id')->constrained('statistic_pages')->restrictOnDelete();
            $table->string('visualization_type', 20)->default('bar')->after('ikon');
            $table->string('gambar')->nullable()->after('visualization_type');
        });

        Schema::table('statistics', function (Blueprint $table) {
            $table->string('label')->nullable()->after('nama_statistik');
            $table->string('gambar')->nullable()->after('ikon');
        });

        $now = now();
        $pages = [
            ['Statistik Kependudukan', 'statistik-kependudukan', 'Informasi agregat kependudukan Desa Betro.', 1],
            ['Statistik Pendidikan', 'statistik-pendidikan', 'Data tingkat pendidikan masyarakat.', 2],
            ['Statistik Pekerjaan', 'statistik-pekerjaan', 'Data mata pencaharian masyarakat.', 3],
            ['Statistik Wilayah', 'statistik-wilayah', 'Data wilayah dan administrasi Desa Betro.', 4],
            ['Statistik Fasilitas Umum', 'statistik-fasilitas-umum', 'Data fasilitas umum Desa Betro.', 5],
            ['Statistik Ekonomi dan UMKM', 'statistik-ekonomi-dan-umkm', 'Data ekonomi dan UMKM Desa Betro.', 6],
        ];
        foreach ($pages as [$title, $slug, $description, $sort]) {
            DB::table('statistic_pages')->insert(['title' => $title, 'slug' => $slug, 'description' => $description, 'sort_order' => $sort, 'status' => true, 'created_at' => $now, 'updated_at' => $now]);
        }

        foreach (['kependudukan' => 1, 'pendidikan' => 2, 'pekerjaan' => 3, 'wilayah' => 4, 'fasilitas-umum' => 5, 'ekonomi-dan-umkm' => 6] as $slug => $pageId) {
            DB::table('statistic_categories')->where('slug', $slug)->update(['page_id' => $pageId]);
        }
    }

    public function down(): void
    {
        Schema::table('statistics', function (Blueprint $table) {
            $table->dropColumn(['label', 'gambar']);
        });
        Schema::table('statistic_categories', function (Blueprint $table) {
            $table->dropConstrainedForeignId('page_id');
            $table->dropColumn(['visualization_type', 'gambar']);
        });
        Schema::dropIfExists('statistic_pages');
    }
};
