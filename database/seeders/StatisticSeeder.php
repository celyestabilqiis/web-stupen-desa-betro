<?php

namespace Database\Seeders;

use App\Models\Statistic;
use App\Models\StatisticCategory;
use App\Models\StatisticPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StatisticSeeder extends Seeder
{
    public function run(): void
    {
        $pageSlugs = [
            'statistik-kependudukan' => ['Jenis Kelamin', 'Kelompok Umur', 'Dusun', 'Status Perkawinan', 'Agama', 'Wajib Pilih'],
            'statistik-pendidikan' => ['Tingkat Pendidikan'],
            'statistik-pekerjaan' => ['Mata Pencaharian'],
            'statistik-wilayah' => ['Jumlah Dusun', 'Jumlah RW', 'Jumlah RT', 'Luas Wilayah', 'Jumlah Rumah Tangga'],
            'statistik-fasilitas-umum' => ['Pendidikan', 'Kesehatan', 'Tempat Ibadah', 'Olahraga', 'Fasilitas Umum Lainnya'],
            'statistik-ekonomi-dan-umkm' => ['Jumlah UMKM', 'Usaha Kuliner', 'Usaha Perdagangan', 'Usaha Kerajinan', 'Usaha Jasa', 'Kelompok Usaha Masyarakat'],
        ];

        foreach ($pageSlugs as $pageSlug => $categoryNames) {
            $page = StatisticPage::query()->where('slug', $pageSlug)->firstOrFail();
            foreach ($categoryNames as $index => $name) {
                StatisticCategory::query()->firstOrCreate(
                    ['slug' => Str::slug($name)],
                    ['page_id' => $page->id, 'nama_kategori' => $name, 'deskripsi' => null, 'ikon' => null, 'visualization_type' => 'bar', 'urutan' => $index + 1, 'status' => true],
                );
            }
        }

        $populationCategory = StatisticCategory::query()->where('slug', 'kependudukan')->firstOrFail();
        $genderCategory = StatisticCategory::query()->where('slug', 'jenis-kelamin')->firstOrFail();
        $regionCategory = StatisticCategory::query()->where('slug', 'wilayah')->firstOrFail();
        $records = [
            [$populationCategory, 'Total Penduduk', 'Total Penduduk', 3985, 'Jiwa', 1, true],
            [$genderCategory, 'Penduduk Laki-laki', 'Laki-laki', 1964, 'Jiwa', 1, true],
            [$genderCategory, 'Penduduk Perempuan', 'Perempuan', 2021, 'Jiwa', 2, true],
            [$populationCategory, 'Jumlah Rumah Tangga', 'Rumah Tangga', 1226, 'Rumah Tangga', 2, true],
            [$regionCategory, 'Luas Wilayah', 'Luas Wilayah', 1.74, 'km²', 1, true],
            [$regionCategory, 'Kepadatan Penduduk', 'Kepadatan Penduduk', 2290, 'Jiwa/km²', 2, false],
        ];

        foreach ($records as [$category, $name, $label, $value, $unit, $sort, $summary]) {
            Statistic::query()->firstOrCreate(
                ['category_id' => $category->id, 'slug' => Str::slug($name), 'tahun' => 2014],
                ['nama_statistik' => $name, 'label' => $label, 'nilai' => $value, 'satuan' => $unit, 'deskripsi' => null, 'sumber_data' => 'Kecamatan Kemlagi Dalam Angka 2015; sumber tabel: Kantor Kecamatan Kemlagi.', 'urutan' => $sort, 'tampil_di_ringkasan' => $summary, 'status' => 'aktif'],
            );
        }
    }
}
