<?php

namespace Database\Seeders;

use App\Models\Arsip;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ArsipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@desabetro.id'],
            [
                'name' => 'Admin Desa Betro',
                'password' => 'admin123',
            ]
        );

        // Pastikan direktori storage ada
        $sampulDir = storage_path('app/public/arsip/sampul');
        if (! File::isDirectory($sampulDir)) {
            File::makeDirectory($sampulDir, 0755, true);
        }

        // Salin gambar contoh jika ada di assets
        $sampul1 = 'arsip/sampul/apbdes-sampul.jpg';
        $source1 = public_path('assets/images/info-musrenbang.jpg');
        if (File::exists($source1)) {
            File::copy($source1, storage_path('app/public/'.$sampul1));
        }

        $sampul2 = 'arsip/sampul/gotong-royong-sampul.jpg';
        $source2 = public_path('assets/images/info-lingkungan.jpg');
        if (File::exists($source2)) {
            File::copy($source2, storage_path('app/public/'.$sampul2));
        }

        // 1. Data Contoh Arsip Desa: Ringkasan Laporan Realisasi APBDes Desa Betro
        Arsip::updateOrCreate(
            ['slug' => 'ringkasan-laporan-realisasi-apbdes-desa-betro'],
            [
                'judul' => 'Ringkasan Laporan Realisasi APBDes Desa Betro',
                'kategori' => 'arsip_desa',
                'tipe' => 'artikel',
                'ringkasan' => 'Ringkasan laporan pertanggungjawaban realisasi Anggaran Pendapatan dan Belanja Desa (APBDes) Betro tahun berjalan demi keterbukaan publik.',
                'isi' => '<h2>Transparansi Pengelolaan Anggaran Desa</h2>
<p>Pemerintah Desa Betro berkomitmen untuk terus menjunjung tinggi asas keterbukaan dan akuntabilitas dalam pengelolaan Anggaran Pendapatan dan Belanja Desa (APBDes). Laporan realisasi ini disajikan agar seluruh elemen masyarakat dapat memantau jalannya program pembangunan dan pemberdayaan masyarakat secara langsung.</p>

<h2>Fokus Utama Alokasi Dana</h2>
<p>Alokasi anggaran pada periode berjalan diarahkan pada beberapa bidang prioritas berikut:</p>
<ul>
    <li>Peningkatan infrastruktur jalan lingkungan dan saluran drainase pemukiman warga.</li>
    <li>Penguatan ketahanan pangan dan dukungan sarana produksi bagi kelompok tani.</li>
    <li>Pelayanan kesehatan masyarakat, termasuk penanganan stunting dan posyandu balita serta lansia.</li>
    <li>Pemberdayaan ekonomi melalui pengembangan unit usaha BUMDes Betro.</li>
</ul>

<h2>Rincian Realisasi Pendapatan &amp; Belanja Desa</h2>
<p>Berikut adalah ikhtisar realisasi pendapatan dan belanja desa yang telah diverifikasi oleh Badan Permusyawaratan Desa (BPD):</p>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f3f4f6;">
            <th style="border: 1px solid #d1d5db; padding: 10px; text-align: left;">Uraian Pos Anggaran</th>
            <th style="border: 1px solid #d1d5db; padding: 10px; text-align: right;">Target Anggaran (Rp)</th>
            <th style="border: 1px solid #d1d5db; padding: 10px; text-align: right;">Realisasi (Rp)</th>
            <th style="border: 1px solid #d1d5db; padding: 10px; text-align: center;">Persentase</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid #d1d5db; padding: 10px;">Pendapatan Asli Desa (PADes)</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: right;">85.000.000</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: right;">82.500.000</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: center;">97,06%</td>
        </tr>
        <tr style="background-color: #fafafa;">
            <td style="border: 1px solid #d1d5db; padding: 10px;">Dana Desa (APBN)</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: right;">820.000.000</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: right;">820.000.000</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: center;">100%</td>
        </tr>
        <tr>
            <td style="border: 1px solid #d1d5db; padding: 10px;">Alokasi Dana Desa (ADD)</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: right;">450.000.000</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: right;">445.000.000</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: center;">98,89%</td>
        </tr>
        <tr style="background-color: #fafafa;">
            <td style="border: 1px solid #d1d5db; padding: 10px;">Belanja Bidang Pembangunan</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: right;">680.000.000</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: right;">672.300.000</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: center;">98,87%</td>
        </tr>
        <tr>
            <td style="border: 1px solid #d1d5db; padding: 10px;">Belanja Pemberdayaan Warga</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: right;">210.000.000</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: right;">205.100.000</td>
            <td style="border: 1px solid #d1d5db; padding: 10px; text-align: center;">97,67%</td>
        </tr>
    </tbody>
</table>

<p>Masyarakat dapat memperoleh salinan fisik dokumen resmi ini melalui kantor sekretariat Pemerintah Desa Betro pada jam kerja pelayanan.</p>',
                'gambar_sampul' => $sampul1,
                'file_pdf' => null,
                'status' => 'terbit',
                'tanggal' => now()->subDays(5)->toDateString(),
                'user_id' => $admin->id,
                'jumlah_dilihat' => 24,
            ]
        );

        // 2. Data Contoh Dokumentasi Desa: Gotong Royong Warga Desa Betro
        Arsip::updateOrCreate(
            ['slug' => 'gotong-royong-warga-desa-betro'],
            [
                'judul' => 'Gotong Royong Warga Desa Betro',
                'kategori' => 'dokumentasi_desa',
                'tipe' => 'artikel',
                'ringkasan' => 'Dokumentasi kebersamaan dan kerja bakti serentak warga Desa Betro membersihkan fasilitas umum dan lingkungan desa.',
                'isi' => '<h2>Aksi Nyata Kebersamaan Warga</h2>
<p>Semangat kekeluargaan dan gotong royong senantiasa hidup di tengah masyarakat Desa Betro. Pada hari Minggu pagi yang cerah, puluhan warga dari berbagai dusun berkumpul bersama perangkat desa untuk melaksanakan kerja bakti serentak.</p>

<p>Kegiatan ini difokuskan pada pembersihan saluran air utama menjelang musim penghujan, perapian bahu jalan poros desa, serta pembersihan area balai pertemuan dan sarana olahraga umum.</p>

<h2>Fokus Utama Kegiatan Pemeliharaan</h2>
<p>Adapun titik-titik lokasi yang menjadi sasaran kerja bakti kali ini meliputi:</p>
<ul>
    <li>Normalisasi selokan di Dusun I dan Dusun II guna mengantisipasi genangan air.</li>
    <li>Pembersihan semak belukar di sepanjang jalan penghubung antar dusun.</li>
    <li>Pengecatan ulang pagar fasilitas pos kamling dan taman bacaan desa.</li>
</ul>

<blockquote>"Gotong royong bukan sekadar membersihkan lingkungan, melainkan merawat tali persaudaraan dan rasa memiliki terhadap desa kita tercinta." - Kepala Desa Betro</blockquote>

<p>Pemerintah Desa Betro menyampaikan apresiasi setinggi-tingginya kepada seluruh warga, pemuda karang taruna, dan tokoh masyarakat yang telah meluangkan waktu serta tenaga demi kemajuan dan keasrian desa kita bersama.</p>',
                'gambar_sampul' => $sampul2,
                'file_pdf' => null,
                'status' => 'terbit',
                'tanggal' => now()->subDays(2)->toDateString(),
                'user_id' => $admin->id,
                'jumlah_dilihat' => 18,
            ]
        );
    }
}
