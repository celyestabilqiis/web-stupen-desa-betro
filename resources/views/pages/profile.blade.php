@extends('layouts.app')

@section('title', 'Profil Perangkat Desa Betro - Portal Digital Desa Betro')
@section('description', 'Profil perangkat Desa Betro, struktur organisasi, jabatan, dan tugas contoh. Seluruh nama adalah data dummy yang perlu disesuaikan.')
@section('page-key', 'profile')

@php
    /**
     * PENGATURAN GAMBAR HERO PROFIL DESA:
     * Untuk mengganti gambar/foto di samping judul "Kenali Perangkat Desa Betro":
     * 1. Cukup ganti file di: public/images/profil-hero.jpg (atau public/assets/images/profil-hero.jpg)
     * 2. Atau ubah path file di bawah ini ke file gambar lain (format: JPG, PNG, WebP, SVG)
     */
    $profileHeroImage = file_exists(public_path('images/profil-hero.jpg')) 
        ? asset('images/profil-hero.jpg') 
        : (file_exists(public_path('assets/images/profil-hero.jpg')) 
            ? asset('assets/images/profil-hero.jpg') 
            : asset('assets/images/profil-hero.svg'));
@endphp

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-12 site-main profile-page">
   <nav aria-label="Breadcrumb" class="page-breadcrumb">
    <a href="{{ route('pages.home') }}">Beranda</a><span>/</span><span aria-current="page">Profil Perangkat Desa</span>
   </nav>

   <section class="profile-hero">
    <div class="profile-hero-copy">
     <span class="profile-eyebrow"><span></span> PROFIL DESA BETRO</span>
     <h1>Kenali <em>Perangkat Desa</em> Betro</h1>
     <p>Kenali jajaran pemerintah desa yang membantu menjalankan administrasi, pelayanan publik, pembangunan, dan pemberdayaan masyarakat.</p>
     <div class="profile-hero-actions">
      <a class="profile-button-primary" href="#daftar-perangkat">Lihat Profil Perangkat </a>
      <a class="profile-button-secondary" href="{{ route('pages.potensi') }}">Jelajahi Potensi Desa </a>
     </div>
    </div>
    
    <div class="profile-hero-visual" aria-label="Foto Pemerintah Desa Betro">
     <!-- Gambar Hero Profil Desa -->
     <div class="profile-hero-image-box">
      <img src="{{ $profileHeroImage }}"
          alt="Pemerintah Desa Betro"
          class="profile-hero-image"
          loading="eager" />
     </div>
    </div>
   </section>

   <section class="profile-leadership-section" aria-labelledby="kepala-desa-heading">
    <div class="profile-section-heading">
     <div><span class="profile-section-kicker">PIMPINAN DESA</span><h2 id="kepala-desa-heading">Kepala Desa</h2></div>
    </div>
    <article class="profile-leader-card" data-profile-card data-profile-name="Ahmad Firmansyah" data-profile-role="Kepala Desa">
     <div class="profile-leader-art"><span class="profile-dummy-label">DATA DUMMY</span><div class="profile-avatar profile-avatar-large">AF</div><span class="profile-leader-seal" aria-hidden="true">✦</span></div>
     <div class="profile-leader-content"><span class="profile-role-chip">KEPALA DESA</span><h3>Ahmad Firmansyah</h3><p class="profile-leader-subtitle">Kepala Desa Betro <span>•</span> Periode contoh 2025–2031</p><p class="profile-person-summary">Bertanggung jawab atas penyelenggaraan pemerintahan desa, pembinaan kemasyarakatan, pembangunan, serta koordinasi pelayanan bagi warga.</p><div class="profile-leader-tags"><span>Koordinasi pemerintahan</span><span>Pembangunan desa</span><span>Pelayanan warga</span></div><button class="profile-detail-button" type="button" data-detail-title="Tugas Kepala Desa" data-detail-text="Contoh tugas: menyelenggarakan pemerintahan desa, menetapkan kebijakan bersama BPD sesuai ketentuan, mengoordinasikan pembangunan, serta membina kehidupan masyarakat. Ganti nama dan rincian ini dengan informasi resmi Desa Betro.">Tugas &amp; Fungsi </button></div>
    </article>
   </section>

   <section class="profile-directory-section" id="daftar-perangkat" aria-labelledby="daftar-perangkat-heading">
    <div class="profile-section-heading profile-directory-heading">
     <div><span class="profile-section-kicker">STRUKTUR ORGANISASI</span><h2 id="daftar-perangkat-heading">Perangkat Desa Lainnya</h2><p class="profile-heading-caption">Lihat nama, jabatan, dan ringkasan tanggung jawab masing-masing perangkat.</p></div>
     <label class="profile-search"><span class="sr-only">Cari nama atau jabatan</span><span aria-hidden="true">⌕</span><input type="search" id="profileSearch" placeholder="Cari nama atau jabatan..." autocomplete="off"/><kbd>/</kbd></label>
    </div>

    <div class="profile-group" data-profile-group>
     <div class="profile-group-heading"><span class="profile-group-number">01</span><div><h3>Sekretariat Desa</h3><p>Mengoordinasikan administrasi dan membantu kepala desa menjalankan pemerintahan.</p></div></div>
     <div class="profile-card-grid">
      <article class="profile-card" data-profile-card data-profile-name="Siti Rahmawati" data-profile-role="Sekretaris Desa">
       <div class="profile-card-art art-rose"><span class="profile-dummy-label">DUMMY</span><div class="profile-avatar">SR</div><span class="profile-card-ornament"></span></div>
       <div class="profile-card-content"><span class="profile-role-chip">SEKRETARIAT</span><h4>Siti Rahmawati</h4><p class="profile-card-role">Sekretaris Desa</p><p class="profile-person-summary">Mengelola koordinasi administrasi, tata naskah, arsip, dan dukungan kerja antarperangkat desa.</p><button class="profile-detail-button" type="button" data-detail-title="Tugas Sekretaris Desa" data-detail-text="Contoh tugas: membantu kepala desa dalam administrasi pemerintahan, koordinasi perangkat, pengelolaan surat dan arsip, serta penyusunan laporan. Sesuaikan dengan struktur resmi desa.">Tugas &amp; Fungsi </button></div>
      </article>
     </div>
    </div>

    <div class="profile-group" data-profile-group>
     <div class="profile-group-heading"><span class="profile-group-number">02</span><div><h3>Kepala Seksi (Kasi)</h3><p>Menjalankan urusan teknis pemerintahan, kesejahteraan, dan pelayanan.</p></div></div>
     <div class="profile-card-grid">
      <article class="profile-card" data-profile-card data-profile-name="Dimas Prasetyo" data-profile-role="Kasi Pemerintahan">
       <div class="profile-card-art art-red"><span class="profile-dummy-label">DUMMY</span><div class="profile-avatar">DP</div><span class="profile-card-ornament"></span></div>
       <div class="profile-card-content"><span class="profile-role-chip">KEPALA SEKSI</span><h4>Dimas Prasetyo</h4><p class="profile-card-role">Kasi Pemerintahan</p><p class="profile-person-summary">Membantu administrasi pemerintahan, data wilayah, ketertiban, dan pembinaan lembaga kemasyarakatan.</p><button class="profile-detail-button" type="button" data-detail-title="Tugas Kasi Pemerintahan" data-detail-text="Contoh tugas: membantu pelaksanaan administrasi pemerintahan, pengelolaan data kependudukan dan wilayah, serta pembinaan ketenteraman. Detail jabatan dapat berbeda mengikuti peraturan dan struktur desa.">Tugas &amp; Fungsi </button></div>
      </article>
      <article class="profile-card" data-profile-card data-profile-name="Nur Aisyah" data-profile-role="Kasi Kesejahteraan">
       <div class="profile-card-art art-peach"><span class="profile-dummy-label">DUMMY</span><div class="profile-avatar">NA</div><span class="profile-card-ornament"></span></div>
       <div class="profile-card-content"><span class="profile-role-chip">KEPALA SEKSI</span><h4>Nur Aisyah</h4><p class="profile-card-role">Kasi Kesejahteraan</p><p class="profile-person-summary">Mendukung program sosial, pemberdayaan warga, kegiatan kemasyarakatan, serta pembangunan kesejahteraan.</p><button class="profile-detail-button" type="button" data-detail-title="Tugas Kasi Kesejahteraan" data-detail-text="Contoh tugas: menyiapkan dan melaksanakan kegiatan pembangunan serta pemberdayaan masyarakat, sosial, pendidikan, kesehatan, dan kesejahteraan sesuai program desa.">Tugas &amp; Fungsi </button></div>
      </article>
      <article class="profile-card" data-profile-card data-profile-name="Eko Saputra" data-profile-role="Kasi Pelayanan">
       <div class="profile-card-art art-plum"><span class="profile-dummy-label">DUMMY</span><div class="profile-avatar">ES</div><span class="profile-card-ornament"></span></div>
       <div class="profile-card-content"><span class="profile-role-chip">KEPALA SEKSI</span><h4>Eko Saputra</h4><p class="profile-card-role">Kasi Pelayanan</p><p class="profile-person-summary">Mendukung pelayanan administrasi warga, fasilitasi kebutuhan masyarakat, dan peningkatan kualitas layanan.</p><button class="profile-detail-button" type="button" data-detail-title="Tugas Kasi Pelayanan" data-detail-text="Contoh tugas: membantu pelaksanaan pelayanan kepada masyarakat, fasilitasi administrasi publik, dan kegiatan peningkatan mutu layanan desa.">Tugas &amp; Fungsi </button></div>
      </article>
     </div>
    </div>

    <div class="profile-group" data-profile-group>
     <div class="profile-group-heading"><span class="profile-group-number">03</span><div><h3>Kepala Urusan (Kaur)</h3><p>Mendukung pengelolaan keuangan, tata usaha, umum, dan perencanaan desa.</p></div></div>
     <div class="profile-card-grid">
      <article class="profile-card" data-profile-card data-profile-name="Rina Kurniasih" data-profile-role="Kaur Keuangan">
       <div class="profile-card-art art-gold"><span class="profile-dummy-label">DUMMY</span><div class="profile-avatar">RK</div><span class="profile-card-ornament"></span></div>
       <div class="profile-card-content"><span class="profile-role-chip">KEPALA URUSAN</span><h4>Rina Kurniasih</h4><p class="profile-card-role">Kaur Keuangan</p><p class="profile-person-summary">Membantu penatausahaan keuangan desa, pencatatan transaksi, dan penyusunan laporan sesuai ketentuan.</p><button class="profile-detail-button" type="button" data-detail-title="Tugas Kaur Keuangan" data-detail-text="Contoh tugas: membantu pengelolaan administrasi keuangan, penatausahaan penerimaan dan pengeluaran, serta penyusunan laporan keuangan desa sesuai peraturan.">Tugas &amp; Fungsi </button></div>
      </article>
      <article class="profile-card" data-profile-card data-profile-name="Fajar Hidayat" data-profile-role="Kaur Tata Usaha dan Umum">
       <div class="profile-card-art art-rose"><span class="profile-dummy-label">DUMMY</span><div class="profile-avatar">FH</div><span class="profile-card-ornament"></span></div>
       <div class="profile-card-content"><span class="profile-role-chip">KEPALA URUSAN</span><h4>Fajar Hidayat</h4><p class="profile-card-role">Kaur Tata Usaha dan Umum</p><p class="profile-person-summary">Membantu administrasi perkantoran, surat-menyurat, arsip, inventaris, dan kebutuhan umum kantor desa.</p><button class="profile-detail-button" type="button" data-detail-title="Tugas Kaur Tata Usaha dan Umum" data-detail-text="Contoh tugas: menjalankan tata usaha, administrasi surat-menyurat, pengarsipan, inventaris aset, dan urusan umum kantor desa.">Tugas &amp; Fungsi </button></div>
      </article>
      <article class="profile-card" data-profile-card data-profile-name="Lestari Wulandari" data-profile-role="Kaur Perencanaan">
       <div class="profile-card-art art-red"><span class="profile-dummy-label">DUMMY</span><div class="profile-avatar">LW</div><span class="profile-card-ornament"></span></div>
       <div class="profile-card-content"><span class="profile-role-chip">KEPALA URUSAN</span><h4>Lestari Wulandari</h4><p class="profile-card-role">Kaur Perencanaan</p><p class="profile-person-summary">Mendukung penyusunan rencana kerja, pengumpulan data program, dan pemantauan kegiatan pembangunan.</p><button class="profile-detail-button" type="button" data-detail-title="Tugas Kaur Perencanaan" data-detail-text="Contoh tugas: membantu koordinasi perencanaan pembangunan, penyusunan dokumen perencanaan, pengumpulan data, dan evaluasi pelaksanaan program desa.">Tugas &amp; Fungsi </button></div>
      </article>
     </div>
    </div>

    <div class="profile-group" data-profile-group>
     <div class="profile-group-heading"><span class="profile-group-number">04</span><div><h3>Kepala Dusun</h3><p>Membantu penyelenggaraan pemerintahan dan pelayanan pada wilayah dusun.</p></div></div>
     <div class="profile-card-grid">
      <article class="profile-card" data-profile-card data-profile-name="Arif Setiawan" data-profile-role="Kepala Dusun I">
       <div class="profile-card-art art-plum"><span class="profile-dummy-label">DUMMY</span><div class="profile-avatar">AS</div><span class="profile-card-ornament"></span></div>
       <div class="profile-card-content"><span class="profile-role-chip">KEPALA DUSUN</span><h4>Arif Setiawan</h4><p class="profile-card-role">Kepala Dusun I</p><p class="profile-person-summary">Menjadi penghubung pemerintah desa dengan warga dan membantu koordinasi kegiatan tingkat dusun.</p><button class="profile-detail-button" type="button" data-detail-title="Tugas Kepala Dusun I" data-detail-text="Contoh tugas: membantu pelaksanaan pemerintahan, pembangunan, pembinaan masyarakat, serta penyampaian kebutuhan warga di wilayah dusun. Nama dusun dan nomenklatur wilayah perlu disesuaikan.">Tugas &amp; Fungsi </button></div>
      </article>
      <article class="profile-card" data-profile-card data-profile-name="Budi Santoso" data-profile-role="Kepala Dusun II">
       <div class="profile-card-art art-peach"><span class="profile-dummy-label">DUMMY</span><div class="profile-avatar">BS</div><span class="profile-card-ornament"></span></div>
       <div class="profile-card-content"><span class="profile-role-chip">KEPALA DUSUN</span><h4>Budi Santoso</h4><p class="profile-card-role">Kepala Dusun II</p><p class="profile-person-summary">Membantu penyaluran informasi, pendataan warga, dan pelaksanaan kegiatan lingkungan.</p><button class="profile-detail-button" type="button" data-detail-title="Tugas Kepala Dusun II" data-detail-text="Contoh tugas: membantu pelayanan warga, pendataan wilayah, koordinasi kegiatan sosial, dan penyampaian aspirasi masyarakat. Nama dusun dan detail jabatan masih dummy.">Tugas &amp; Fungsi </button></div>
      </article>
      <article class="profile-card" data-profile-card data-profile-name="Wahyu Nugroho" data-profile-role="Kepala Dusun III">
       <div class="profile-card-art art-gold"><span class="profile-dummy-label">DUMMY</span><div class="profile-avatar">WN</div><span class="profile-card-ornament"></span></div>
       <div class="profile-card-content"><span class="profile-role-chip">KEPALA DUSUN</span><h4>Wahyu Nugroho</h4><p class="profile-card-role">Kepala Dusun III</p><p class="profile-person-summary">Mendampingi kebutuhan lingkungan warga dan berkoordinasi terkait kegiatan desa di wilayah dusun.</p><button class="profile-detail-button" type="button" data-detail-title="Tugas Kepala Dusun III" data-detail-text="Contoh tugas: mengoordinasikan kegiatan pemerintahan dan kemasyarakatan pada wilayah dusun, serta membantu menyampaikan kebutuhan dan aspirasi warga. Nama dusun dan detail jabatan masih dummy.">Tugas &amp; Fungsi </button></div>
      </article>
     </div>
    </div>
    <div class="profile-no-results" id="profileNoResults" hidden><span aria-hidden="true">⌕</span><h3>Profil tidak ditemukan</h3><p>Coba gunakan nama atau jabatan yang berbeda.</p></div>
   </section>

   <section class="profile-contact-cta">
    <div><span class="profile-section-kicker">POTENSI DESA</span><h2>Mencari informasi UMKM atau izin usaha?</h2><p>Kunjungi halaman Potensi Desa untuk mengenal UMKM lokal dan melihat informasi izin usaha.</p></div>
    <div class="profile-cta-actions"><a class="profile-button-light" href="{{ route('pages.potensi') }}">Potensi Desa </a><a class="profile-button-outline" href="{{ route('pages.home') }}#informasi">Lihat Layanan </a></div>
   </section>
  </main>
@endsection

@section('after-content')
<!-- MODAL 1: FORM PENGADUAN -->
  <div class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-xs flex items-center justify-center p-4" id="pengaduanModal">
   <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 shadow-2xl relative">
    <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition" data-close-modal="pengaduanModal">
     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
      </path>
     </svg>
    </button>
    <div class="flex items-center gap-3 mb-5">
     <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
       <path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
       </path>
      </svg>
     </div>
     <div>
      <h3 class="text-lg font-bold text-gray-900">
       Form Pengaduan &amp; Layanan Warga
      </h3>
      <p class="text-xs text-gray-500">
       Pemerintah Desa Betro, Kec. Kemlagi
      </p>
     </div>
    </div>
    <form class="space-y-4" data-demo-submit="true">
     <div>
      <label class="block text-xs font-bold text-gray-700 mb-1">
       Nama Lengkap
      </label>
      <input class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600" placeholder="Nama lengkap Anda" required="" type="text"/>
     </div>
     <div>
      <label class="block text-xs font-bold text-gray-700 mb-1">
       Nomor WhatsApp / HP
      </label>
      <input class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600" placeholder="08xxxxxxxxxx" required="" type="tel"/>
     </div>
     <div>
      <label class="block text-xs font-bold text-gray-700 mb-1">
       Jenis Layanan / Pengaduan
      </label>
      <select class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600 text-gray-700">
       <option>
        Pengajuan Surat Keterangan
       </option>
       <option>
        Laporan Pengaduan / Aspirasi Warga
       </option>
       <option>
        Pertanyaan Umum
       </option>
      </select>
     </div>
     <div>
      <label class="block text-xs font-bold text-gray-700 mb-1">
       Pesan / Detail
      </label>
      <textarea class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600" placeholder="Tuliskan detail permohonan atau pengaduan Anda..." required="" rows="3"></textarea>
     </div>
     <div class="pt-2">
      <button class="w-full py-3 bg-brand-700 hover:bg-brand-800 text-white font-bold rounded-xl text-sm transition shadow-sm" type="submit">
       Kirim Pengaduan
      </button>
     </div>
    </form>
   </div>
  </div>
  <!-- MODAL 2: GENERAL DETAIL MODAL -->
  <div class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-xs flex items-center justify-center p-4" id="detailModal">
   <div class="bg-white rounded-2xl max-w-md w-full p-6 text-center shadow-2xl relative">
    <div class="w-12 h-12 rounded-full bg-brand-50 text-brand-700 flex items-center justify-center mx-auto mb-4">
     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
      </path>
     </svg>
    </div>
    <h3 class="text-lg font-bold text-gray-900 mb-2" id="modalTitle">
     Informasi
    </h3>
    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-6" id="modalBody">
    </p>
    <button class="px-6 py-2.5 bg-brand-700 text-white font-bold text-xs rounded-xl hover:bg-brand-800 transition" data-close-modal="detailModal">
     Tutup
    </button>
   </div>
  </div>
  <!-- JavaScript Helpers -->
@endsection
