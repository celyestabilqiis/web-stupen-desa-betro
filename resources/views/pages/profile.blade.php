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
    <div class="profile-section-heading village-officials-heading">
     <div><span class="profile-section-kicker">STRUKTUR PEMERINTAHAN</span><h2 id="daftar-perangkat-heading">Pemerintah Desa Betro</h2></div>
     <label class="profile-search"><span class="sr-only">Cari nama atau jabatan</span><span aria-hidden="true">⌕</span><input type="search" id="profileSearch" placeholder="Cari nama atau jabatan..." autocomplete="off"/><kbd>/</kbd></label>
    </div>
    <div class="village-officials-divider"></div>

    @if($villageHead)
     <section class="profile-leadership-section" aria-label="Kepala Desa">
      <article class="village-official-card village-official-leader" data-profile-card data-profile-name="{{ $villageHead->nama }}" data-profile-role="{{ $villageHead->jabatan }}">
       <div class="village-official-photo village-official-photo-leader">
        @if($villageHead->foto)<img src="{{ asset('storage/'.$villageHead->foto) }}" alt="Foto {{ $villageHead->nama }}" loading="lazy">@else<span class="village-official-placeholder" aria-hidden="true">♙</span>@endif
       </div>
       <div class="village-official-copy"><span class="profile-role-chip">KEPALA DESA</span><h3>{{ $villageHead->nama }}</h3><p>{{ $villageHead->jabatan }}</p>@if($villageHead->deskripsi)<div class="profile-person-summary">{{ $villageHead->deskripsi }}</div>@endif</div>
      </article>
     </section>
    @endif

    @if($otherOfficials->isNotEmpty())
     <div class="village-official-grid" aria-label="Perangkat desa lainnya">
      @foreach($otherOfficials as $official)
       <article class="village-official-card" data-profile-card data-profile-name="{{ $official->nama }}" data-profile-role="{{ $official->jabatan }}">
        <div class="village-official-photo">
         @if($official->foto)<img src="{{ asset('storage/'.$official->foto) }}" alt="Foto {{ $official->nama }}" loading="lazy">@else<span class="village-official-placeholder" aria-hidden="true">♙</span>@endif
        </div>
        <div class="village-official-copy"><h3>{{ $official->nama }}</h3><p>{{ $official->jabatan }}</p>@if($official->deskripsi)<div class="profile-person-summary">{{ $official->deskripsi }}</div>@endif</div>
       </article>
      @endforeach
     </div>
    @endif

    <div class="profile-no-results" id="profileNoResults" @if($villageHead || $otherOfficials->isNotEmpty()) hidden @endif><span aria-hidden="true">♙</span><h3>Data perangkat desa belum tersedia</h3><p>Informasi perangkat desa akan ditampilkan setelah dipublikasikan oleh admin.</p></div>
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
