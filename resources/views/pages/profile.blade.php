@extends('layouts.app')

@section('title', 'Profil Perangkat Desa Betro - Portal Digital Desa Betro')
@section('description', 'Profil pimpinan dan perangkat Pemerintah Desa Betro yang telah dipublikasikan.')
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

   <section class="village-officials-section" id="daftar-perangkat" aria-labelledby="daftar-perangkat-heading">
    <!-- Container Utama -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6 sm:p-8 md:p-10 shadow-xs max-w-6xl mx-auto">
     <!-- Judul Bagian -->
     <div class="text-center pb-5 border-b border-gray-200 mb-8 sm:mb-10">
      <h2 id="daftar-perangkat-heading" class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 uppercase">
       PEMERINTAH DESA BETRO
      </h2>
     </div>

     <!-- Kartu Kepala Desa (Posisi Khusus: Paling Atas dan Tepat di Tengah Horizontal) -->
     @if($villageHead)
      <div class="flex justify-center mb-8 sm:mb-10">
       <article class="bg-white border border-gray-200 rounded-xl p-5 sm:p-6 flex flex-col items-center text-center shadow-xs hover:shadow-md hover:border-gray-300 transition-all duration-200 w-full max-w-[280px] sm:max-w-[300px]" data-profile-card data-profile-name="{{ $villageHead->nama }}" data-profile-role="{{ $villageHead->jabatan }}">
        <!-- Foto Kepala Desa: Sedikit lebih menonjol dibandingkan foto perangkat lainnya -->
        <div class="w-[120px] h-[150px] sm:w-[130px] sm:h-[162px] rounded-lg overflow-hidden bg-gray-50 border border-gray-100 flex items-center justify-center shrink-0 mb-4 shadow-2xs">
         @if($villageHead->foto)
          <img src="{{ asset('storage/'.$villageHead->foto) }}" alt="Foto {{ $villageHead->nama }}" class="w-full h-full object-contain" loading="lazy">
         @else
          <span class="grid h-full w-full place-items-center bg-brand-50 text-4xl text-brand-700" aria-hidden="true">♙</span>
         @endif
        </div>
        <!-- Nama: Huruf tebal, HURUF KAPITAL, rata tengah -->
        <h3 class="font-bold text-gray-900 uppercase text-base sm:text-lg leading-snug break-words max-w-full text-center">
         {{ mb_strtoupper($villageHead->nama) }}
        </h3>
        <!-- Jabatan: Tepat di bawah nama, font lebih kecil, warna lembut, rata tengah -->
        <p class="text-xs sm:text-sm text-gray-500 font-medium text-center mt-1.5">
         Kepala Desa
        </p>
       </article>
      </div>
     @endif

     <!-- Grid Kartu Perangkat Desa Lainnya: 4 Kolom Desktop, 2 Tablet, 1-2 Smartphone -->
     @if($otherOfficials->isNotEmpty())
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6" aria-label="Perangkat desa lainnya">
       @foreach($otherOfficials as $official)
        <article class="bg-white border border-gray-200 rounded-xl p-4 sm:p-5 flex flex-col items-center text-center h-full hover:shadow-md hover:border-gray-300 transition-all duration-200" data-profile-card data-profile-name="{{ $official->nama }}" data-profile-role="{{ $official->jabatan }}">
         <!-- Foto Perangkat Desa: Ukuran seragam portrait 100x125 px, object-fit contain -->
         <div class="w-[100px] h-[125px] rounded-lg overflow-hidden bg-gray-50 border border-gray-100 flex items-center justify-center shrink-0 mb-3 shadow-2xs">
          @if($official->foto)
           <img src="{{ asset('storage/'.$official->foto) }}" alt="Foto {{ $official->nama }}" class="w-full h-full object-contain" loading="lazy">
          @else
           <span class="grid h-full w-full place-items-center bg-brand-50 text-3xl text-brand-700" aria-hidden="true">♙</span>
          @endif
         </div>
         <!-- Nama: Huruf tebal, HURUF KAPITAL, rata tengah -->
         <h3 class="font-bold text-gray-900 uppercase text-sm sm:text-base leading-snug break-words max-w-full text-center">
          {{ mb_strtoupper($official->nama) }}
         </h3>
         <!-- Jabatan: Tepat di bawah nama, ukuran lebih kecil, warna lebih lembut, rata tengah -->
         <p class="text-xs text-gray-500 font-medium text-center mt-1">
          {{ $official->jabatan }}
         </p>
        </article>
       @endforeach
      </div>
     @endif

     <!-- Tampilan kosong jika belum ada data -->
     <div class="profile-no-results text-center py-12 text-gray-500" id="profileNoResults" @if($villageHead || $otherOfficials->isNotEmpty()) hidden @endif>
      <span class="text-4xl block mb-2" aria-hidden="true">♙</span>
      <h3 class="text-base font-bold text-gray-700">Data perangkat desa belum tersedia</h3>
      <p class="text-xs sm:text-sm text-gray-500 mt-1">Informasi perangkat desa akan ditampilkan setelah dipublikasikan oleh admin.</p>
     </div>
    </div>
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
      <select required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-600 focus:ring-1 focus:ring-brand-600 text-gray-700">
       <option value="" disabled selected>
        Pilih Jenis Layanan / Pengaduan
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
