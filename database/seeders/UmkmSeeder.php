<?php

namespace Database\Seeders;

use App\Models\Umkm;
use Illuminate\Database\Seeder;

class UmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Umkm::query()->where('is_demo', true)->delete();

        $umkm = Umkm::create([
            'nama_usaha' => 'Dapur Kue Betro',
            'slug' => Umkm::makeSlug('Dapur Kue Betro'),
            'kategori' => 'Kuliner dan Makanan',
            'nama_pemilik' => 'Contoh Pemilik UMKM',
            'alamat' => 'Desa Betro, Kecamatan Kemlagi, Kabupaten Mojokerto, Jawa Timur.',
            'deskripsi_singkat' => 'UMKM yang bergerak di bidang produksi aneka kue rumahan dengan berbagai pilihan produk untuk kebutuhan sehari-hari maupun acara khusus.',
            'deskripsi_lengkap' => 'Dapur Kue Betro merupakan contoh usaha kuliner lokal yang menyediakan berbagai jenis kue rumahan dengan cita rasa khas. Usaha ini menjadi salah satu contoh potensi ekonomi masyarakat Desa Betro yang dapat dikembangkan melalui pemanfaatan teknologi digital sebagai media promosi dan pemasaran produk.',
            'tahun_berdiri' => 'Data contoh (dummy)',
            'jam_operasional' => 'Belum ditentukan',
            'whatsapp' => null,
            'foto' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=1200&q=85',
            'is_demo' => true,
            'status' => 'terbit',
        ]);

        foreach ([
            ['Brownies Cokelat', 'Brownies cokelat sebagai produk demonstrasi.', 35000, 'per kotak', 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=800&q=85'],
            ['Bolu Pisang', 'Bolu pisang sebagai produk demonstrasi.', 25000, 'per loyang', 'https://images.unsplash.com/photo-1606101273945-e9eba910dd7b?auto=format&fit=crop&w=800&q=85'],
            ['Kue Nastar', 'Kue nastar sebagai produk demonstrasi.', 45000, 'per toples', 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&w=800&q=85'],
        ] as [$nama, $deskripsi, $harga, $satuan, $foto]) {
            $umkm->products()->create(['nama_produk' => $nama, 'deskripsi' => $deskripsi, 'harga' => $harga, 'satuan' => $satuan, 'foto' => $foto, 'tersedia' => true]);
        }
    }
}
