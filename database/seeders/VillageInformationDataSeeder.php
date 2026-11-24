<?php

namespace Database\Seeders;

use App\Models\VillageGeography;
use App\Models\VillageProfile;
use Illuminate\Database\Seeder;

class VillageInformationDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bpsSource = 'BPS Kabupaten Mojokerto, Kecamatan Kemlagi Dalam Angka 2015, data 2014, Tabel 1.2 dan 3.1.6: https://web-api.bps.go.id/download.php?f=rsDL4%2FKjObzFxlzvdhwv3i9oYTQzejNHR2dKbGF1blhOdEtRaThWeXVzVDl2d2lEMXBpREh2N0NaU1VXZTc4ckNpNElTRjU5MFgrcmxhRXBTeUFhMWIrcm5wQzQ1TEFMMTJaZkV0cGU2NHJaQlFtK0orK0RqYmpYWXZZS2R5K3pKbnFYSFNtTGl3NVF3Mm5SamFrWXBrNHJING01Zk50ZExhWDlPVnVlS2dWRllxRGZESHNXNnVSQWJFU3BVVXo4RWpKNUpwVFJQbFlYMTZaL2NxVkNXaUtlRThqY2V1UlpRdGNvYXc9PQ%3D%3D';

        VillageProfile::query()->updateOrCreate(['id' => 1], [
            'nama_desa' => 'Betro', 'kecamatan' => 'Kemlagi', 'kabupaten' => 'Mojokerto',
            'provinsi' => 'Jawa Timur', 'kode_pos' => '61353', 'kode_wilayah' => '3516152002',
            'luas_wilayah' => 1.74, 'jumlah_dusun' => 2, 'jumlah_rw' => 4, 'jumlah_rt' => 16,
            'latitude' => null, 'longitude' => null, 'gambar' => null, 'tahun_data' => null,
            'deskripsi' => 'Luas wilayah dan jumlah dusun, RW, serta RT di atas adalah data historis BPS tahun 2014, bukan verifikasi kondisi terkini. Koordinat dan batas administratif belum diisi karena belum ditemukan data Desa Betro yang dapat diverifikasi.',
            'sumber_data' => $bpsSource.' Kode wilayah 3516152002: PMK 7/2026, https://jdih.kemenkeu.go.id/api/download/78d0134f-e7c2-4071-926e-9c48a0c05bfb/2026pmkeuangan007.pdf. Kode pos 61353 mengikuti data awal pengguna dan belum diverifikasi oleh sumber Pos Indonesia.',
        ]);

        $entries = [
            ['Ketinggian wilayah (data historis)', '33', 'meter di atas permukaan laut', 'Tinggi rata-rata tahun 2014, bukan pengukuran terbaru.', $bpsSource, 2014],
            ['Jumlah dusun (data historis)', '2', 'dusun', 'Nama dusun dan kondisi terkini perlu dikonfirmasi kepada Pemerintah Desa.', $bpsSource, 2014],
            ['Jumlah RW (data historis)', '4', 'RW', 'Jumlah administratif tahun 2014; perlu konfirmasi kondisi terkini.', $bpsSource, 2014],
            ['Jumlah RT (data historis)', '16', 'RT', 'Jumlah administratif tahun 2014; perlu konfirmasi kondisi terkini.', $bpsSource, 2014],
            ['Sekolah dasar (data historis)', '1', 'sekolah', 'BPS mencatat satu sekolah dasar di Betro pada tahun ajaran 2014/2015. Ini bukan jumlah fasilitas terkini.', $bpsSource.' Tabel 5.1.5, tahun ajaran 2014/2015.', 2015],
            ['Tempat ibadah (data historis)', '3 masjid; 12 langgar/mushola', null, 'Jumlah yang tercatat BPS untuk tahun 2014; perlu diperbarui oleh Pemerintah Desa.', $bpsSource.' Tabel 5.2.2 (2014).', 2014],
            ['Potensi pertanian padi semi-organik', 'Panen raya dilaporkan', null, 'Kecamatan Kemlagi memberitakan panen raya padi semi-organik di Desa Betro pada 9 Agustus 2024. Berita tidak menyebut luas lahan atau volume produksi.', 'Artikel resmi Kecamatan Kemlagi, 12 Agustus 2024: https://kemlagi.mojokertokab.go.id/detail-berita/panen-raya-padi-semi-organik-desa-betro-keckemlagi-dihadiri-bupati-mojokerto-drikfina-fahmawatimsi-1723440199. Foto kegiatan: https://mojokertokab.go.id/storage/tenantkemlagi/app/gambar/berita/panen-raya-padi-semi-organik-desa-betro-keckemlagi-dihadiri-bupati-mojokerto-drikfina-fahmawatimsi-20240812_122319.jpeg', 2024],
        ];

        foreach ($entries as $index => [$name, $value, $unit, $description, $source, $year]) {
            VillageGeography::query()->updateOrCreate(['nama_informasi' => $name], [
                'nilai' => $value, 'satuan' => $unit, 'deskripsi' => $description,
                'sumber_data' => $source, 'tahun_data' => $year, 'urutan' => $index + 1,
                'status' => true, 'gambar' => null,
            ]);
        }
    }
}
