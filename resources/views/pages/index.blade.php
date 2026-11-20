@extends('layouts.app')

@section('title', 'Website Resmi Desa Betro - Kecamatan Kemlagi • Kabupaten Mojokerto')
@section('description', 'Portal informasi, layanan, dan kegiatan Pemerintah Desa Betro. Halaman home menggunakan konten contoh yang dapat disesuaikan.')
@section('page-key', 'home')

@section('content')
<main class="home-main">
   <section class="relative min-h-screen flex items-center overflow-hidden bg-gray-900" id="beranda">
    <!-- Landscape Background Image: Rice fields & mountain view -->
    <img alt="Persawahan Desa Betro" class="absolute inset-0 w-full h-full object-cover object-center" src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&amp;w=1920&amp;auto=format&amp;fit=crop"/>
    <!-- Smooth Gradient Overlay -->
    <div class="absolute inset-0 hero-overlay"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 sm:pt-36 lg:pt-40 pb-20 lg:pb-24 w-full z-10">
     <div class="max-w-2xl">
      <!-- Judul Utama -->
      <h1 class="home-hero-title text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-[1.15] tracking-tight mb-4">
       <span class="home-title-line home-title-line-main">Selamat Datang di Website Resmi</span>
       <span class="home-title-line home-title-line-accent">Desa Betro</span>
      </h1>
      <!-- Subtitle -->
      <p class="text-base sm:text-lg text-white/90 font-medium leading-relaxed mb-8 max-w-xl">
       Pusat informasi, pelayanan, dan keterbukaan Pemerintah Desa Betro untuk masyarakat.
      </p>
      <!-- Action CTA Buttons -->
      <div class="flex flex-wrap items-center gap-4">
       <a class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-bold text-sm shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 active:translate-y-0" href="{{ route('pages.informasi') }}">
        <svg class="w-4 h-4 text-brand-200" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
         <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
         </path>
         <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
         </path>
        </svg>
        <span>
         Jelajahi Desa
        </span>
       </a>
       <a class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-xl bg-white hover:bg-gray-50 text-gray-800 border border-gray-200 font-bold text-sm shadow-2xs hover:shadow transition transform hover:-translate-y-0.5" href="#informasi">
        <svg class="w-4 h-4 text-brand-700" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
         <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
         </path>
        </svg>
        <span>
         Layanan Desa
        </span>
       </a>
      </div>
     </div>
    </div>
   </section>
   <section aria-label="Ringkasan data desa" class="quick-stats">
    <div class="quick-stats-inner">
     <div class="quick-stat">
      <span class="quick-stat-icon">
       ⌂
      </span>
      <div>
       <strong>
        4.280
       </strong>
       <span>
        Perkiraan penduduk
       </span>
      </div>
     </div>
     <div class="quick-stat">
      <span class="quick-stat-icon">
       ▦
      </span>
      <div>
       <strong>
        1.245
       </strong>
       <span>
        Kepala keluarga
       </span>
      </div>
     </div>
     <div class="quick-stat">
      <span class="quick-stat-icon">
       ◎
      </span>
      <div>
       <strong>
        4
       </strong>
       <span>
        Dusun / wilayah
       </span>
      </div>
     </div>
    </div>
   </section>
   <section class="welcome-section" id="sambutan">
    <div class="welcome-inner">
     <div class="welcome-copy">
      <h2>
       Selamat datang di portal digital Desa Betro
      </h2>
      <p>
       Portal ini menjadi ruang informasi bersama untuk mengenal desa, mengikuti kegiatan, mengakses layanan, dan melihat informasi publik dengan lebih mudah. Kami terus berupaya menghadirkan pelayanan yang terbuka, ramah, dan dekat dengan kebutuhan warga.
      </p>
      <p class="welcome-greeting">
       Salam hangat, gotong royong, dan semangat membangun desa.
      </p>
      <div class="welcome-signature">
       <span class="welcome-avatar">
        AP
       </span>
       <div>
        <strong>
         Ahmad Pratama
        </strong>
        <span>
         Kepala Desa
        </span>
       </div>
      </div>
     </div>
     <div class="welcome-visual">
      <img alt="Hamparan persawahan sebagai ilustrasi suasana pedesaan" loading="lazy" src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&amp;w=1100&amp;auto=format&amp;fit=crop"/>
      
      </div>
     </div>
    </div>
   </section>
   <section class="py-16 lg:py-20 bg-white" id="informasi">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
     <!-- Section Header -->
     <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
      <div>
       <div class="accent-pill">
       </div>
       <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
        Informasi Desa
       </h2>
       <p class="text-sm sm:text-base text-gray-500 font-medium mt-1">
        Pusat data statistik wilayah, arsip dokumen publik, dan dokumentasi kegiatan Desa Betro.
       </p>
      </div>
      <a class="inline-flex items-center gap-1.5 text-sm font-bold text-brand-700 hover:text-brand-800 transition group self-start md:self-auto" href="{{ route('pages.informasi') }}">
       <span>
        Buka Halaman Informasi
       </span>
      
      </a>
     </div>

     <!-- Bagian Atas: Grid 2 Kolom (Statistik Desa & Publikasi Dokumen) -->
     <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
      <!-- KATEGORI A: STATISTIK DESA -->
      <div class="flex flex-col">
       <a class="information-section-heading group hover:border-brand-200 transition" href="{{ route('pages.informasi.statistik') }}">
        <span class="information-section-number">01</span>
        <div class="flex-grow">
         <span class="information-section-kicker">DATA DESA</span>
         <h3 class="group-hover:text-brand-700 transition">Statistik Desa</h3>
        </div>
        <span class="text-xs font-semibold text-brand-700 group-hover:translate-x-1 transition flex items-center gap-1">
         Lihat Detail <span aria-hidden="true"></span>
        </span>
       </a>

       <div class="grid grid-cols-2 gap-4 information-stat-grid flex-grow">
        <!-- Populasi -->
        <a class="card-hover bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between group transition" href="{{ route('pages.informasi.statistik') }}">
         <div class="flex items-center justify-between mb-2">
          <span class="text-xs font-medium text-gray-500">Populasi</span>
          <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center">
           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
            </path>
           </svg>
          </div>
         </div>
         <div>
          <p class="text-2xl font-extrabold text-gray-900 group-hover:text-brand-700 transition">2.630</p>
          <p class="text-[11px] text-gray-400 mt-0.5">Total Penduduk</p>
         </div>
        </a>

        <!-- Laki-laki -->
        <a class="card-hover bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between group transition" href="{{ route('pages.informasi.statistik') }}">
         <div class="flex items-center justify-between mb-2">
          <span class="text-xs font-medium text-gray-500">Laki-laki</span>
          <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
            <circle cx="12" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></circle>
            <path d="M5.5 21v-2a6.5 6.5 0 0 1 13 0v2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
           </svg>
          </div>
         </div>
         <div>
          <p class="text-2xl font-extrabold text-gray-900 group-hover:text-blue-700 transition">735</p>
          <p class="text-[11px] text-gray-400 mt-0.5">Jiwa Terdata</p>
         </div>
        </a>

        <!-- Perempuan -->
        <a class="card-hover bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between group transition" href="{{ route('pages.informasi.statistik') }}">
         <div class="flex items-center justify-between mb-2">
          <span class="text-xs font-medium text-gray-500">Perempuan</span>
          <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
            <circle cx="12" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></circle>
            <path d="M5.5 21v-2a6.5 6.5 0 0 1 13 0v2M9 16h6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
           </svg>
          </div>
         </div>
         <div>
          <p class="text-2xl font-extrabold text-gray-900 group-hover:text-rose-700 transition">775</p>
          <p class="text-[11px] text-gray-400 mt-0.5">Jiwa Terdata</p>
         </div>
        </a>

        <!-- Luas Wilayah -->
        <a class="card-hover bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between group transition" href="{{ route('pages.informasi.statistik') }}">
         <div class="flex items-center justify-between mb-2">
          <span class="text-xs font-medium text-gray-500">Luas Wilayah</span>
          <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
            <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
            </path>
           </svg>
          </div>
         </div>
         <div>
          <p class="text-2xl font-extrabold text-gray-900 group-hover:text-amber-700 transition">4.33 <span class="text-sm font-bold text-gray-500">km&sup2;</span></p>
          <p class="text-[11px] text-gray-400 mt-0.5">Wilayah Desa</p>
         </div>
        </a>
       </div>
      </div>

      <!-- KATEGORI B: PUBLIKASI DOKUMEN -->
      <div class="flex flex-col">
       <a class="information-section-heading group hover:border-brand-200 transition" href="{{ route('pages.informasi.dokumen') }}">
        <span class="information-section-number">02</span>
        <div class="flex-grow">
         <span class="information-section-kicker">ARSIP RESMI</span>
         <h3 class="group-hover:text-brand-700 transition">Publikasi Dokumen</h3>
        </div>
        <span class="text-xs font-semibold text-brand-700 group-hover:translate-x-1 transition flex items-center gap-1">
         Lihat Semua <span aria-hidden="true"></span>
        </span>
       </a>

       <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 information-document-grid flex-grow">
        <!-- Dokumen 1 -->
        <a class="card-hover bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between group transition" href="{{ route('pages.informasi.dokumen') }}">
         <div>
          <div class="flex items-center justify-between mb-2">
           <span class="block text-brand-700 text-xs font-bold">APBDES</span>
           <span class="text-gray-300 group-hover:text-brand-600 transition"></span>
          </div>
          <span class="font-bold text-gray-900 text-sm group-hover:text-brand-700 transition block">Ringkasan APBDes 2026</span>
         </div>
         <span class="text-[11px] text-gray-400 mt-3 flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
          Dokumen Keuangan Desa
         </span>
        </a>

        <!-- Dokumen 2 -->
        <a class="card-hover bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between group transition" href="{{ route('pages.informasi.dokumen') }}">
         <div>
          <div class="flex items-center justify-between mb-2">
           <span class="block text-brand-700 text-xs font-bold">PERANGKAT</span>
           <span class="text-gray-300 group-hover:text-brand-600 transition"></span>
          </div>
          <span class="font-bold text-gray-900 text-sm group-hover:text-brand-700 transition block">Profil Perangkat Desa</span>
         </div>
         <span class="text-[11px] text-gray-400 mt-3 flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
          Struktur Organisasi
         </span>
        </a>

        <!-- Dokumen 3 -->
        <a class="card-hover bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between group transition" href="{{ route('pages.informasi.dokumen') }}">
         <div>
          <div class="flex items-center justify-between mb-2">
           <span class="block text-brand-700 text-xs font-bold">DATA</span>
           <span class="text-gray-300 group-hover:text-brand-600 transition"></span>
          </div>
          <span class="font-bold text-gray-900 text-sm group-hover:text-brand-700 transition block">Data Penduduk</span>
         </div>
         <span class="text-[11px] text-gray-400 mt-3 flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
          Demografi &amp; Statistik
         </span>
        </a>

        <!-- Dokumen 4 -->
        <a class="card-hover bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between group transition" href="{{ route('pages.informasi.dokumen') }}">
         <div>
          <div class="flex items-center justify-between mb-2">
           <span class="block text-brand-700 text-xs font-bold">PANDUAN</span>
           <span class="text-gray-300 group-hover:text-brand-600 transition"></span>
          </div>
          <span class="font-bold text-gray-900 text-sm group-hover:text-brand-700 transition block">Panduan Layanan SAPAW</span>
         </div>
         <span class="text-[11px] text-gray-400 mt-3 flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
          Sistem Pelayanan Administrasi
         </span>
        </a>
       </div>
      </div>
     </div>

     <!-- Bagian Bawah: KATEGORI C (DOKUMENTASI KEGIATAN DESA) -->
     <div class="pt-6 border-t border-gray-100">
      <a class="information-section-heading information-agenda-heading group hover:border-brand-200 transition mb-6" href="{{ route('pages.informasi.kegiatan') }}">
       <span class="information-section-number">03</span>
       <div class="flex-grow">
        <span class="information-section-kicker">DOKUMENTASI DESA</span>
        <h3 class="group-hover:text-brand-700 transition">Dokumentasi Kegiatan Desa</h3>
       </div>
       <span class="text-xs font-semibold text-brand-700 group-hover:translate-x-1 transition flex items-center gap-1">
        Lihat Semua Dokumentasi <span aria-hidden="true"></span>
       </span>
      </a>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
       <!-- Card Kegiatan 1 -->
       <a class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-2xs flex flex-col group transition" href="{{ route('pages.informasi.kegiatan') }}">
        <div class="relative h-44 overflow-hidden bg-gray-100">
         <img alt="Musrenbang Desa 2026" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="{{ asset('assets/images/info-musrenbang.jpg') }}"/>
         <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-brand-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
          PEMERINTAHAN
         </span>
        </div>
        <div class="p-4 flex flex-col flex-grow justify-between">
         <div>
          <span class="text-[10px] font-bold text-gray-500 mb-1.5 flex items-center gap-1">
           <svg class="w-3 h-3 text-brand-600" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
           15 NOV 2026
          </span>
          <h4 class="font-bold text-sm text-gray-900 group-hover:text-brand-700 transition leading-snug line-clamp-2">
           Musrenbang Desa 2026
          </h4>
         </div>
         <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between text-xs text-brand-700 font-semibold">
          <span>Buka dokumentasi</span>
          <span class="group-hover:translate-x-1 transition"></span>
         </div>
        </div>
       </a>

       <!-- Card Kegiatan 2 -->
       <a class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-2xs flex flex-col group transition" href="{{ route('pages.informasi.kegiatan') }}">
        <div class="relative h-44 overflow-hidden bg-gray-100">
         <img alt="Pelatihan UMKM Kuliner" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="{{ asset('assets/images/info-umkm.jpg') }}"/>
         <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-brand-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
          EKONOMI
         </span>
        </div>
        <div class="p-4 flex flex-col flex-grow justify-between">
         <div>
          <span class="text-[10px] font-bold text-gray-500 mb-1.5 flex items-center gap-1">
           <svg class="w-3 h-3 text-brand-600" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
           22 NOV 2026
          </span>
          <h4 class="font-bold text-sm text-gray-900 group-hover:text-brand-700 transition leading-snug line-clamp-2">
           Pelatihan UMKM Kuliner
          </h4>
         </div>
         <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between text-xs text-brand-700 font-semibold">
          <span>Buka dokumentasi</span>
          <span class="group-hover:translate-x-1 transition"></span>
         </div>
        </div>
       </a>

       <!-- Card Kegiatan 3 -->
       <a class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-2xs flex flex-col group transition" href="{{ route('pages.informasi.kegiatan') }}">
        <div class="relative h-44 overflow-hidden bg-gray-100">
         <img alt="Penyuluhan Kesehatan Lingkungan" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="{{ asset('assets/images/info-kesehatan.jpg') }}"/>
         <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-brand-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
          KESEHATAN
         </span>
        </div>
        <div class="p-4 flex flex-col flex-grow justify-between">
         <div>
          <span class="text-[10px] font-bold text-gray-500 mb-1.5 flex items-center gap-1">
           <svg class="w-3 h-3 text-brand-600" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
           29 NOV 2026
          </span>
          <h4 class="font-bold text-sm text-gray-900 group-hover:text-brand-700 transition leading-snug line-clamp-2">
           Penyuluhan Kesehatan Lingkungan
          </h4>
         </div>
         <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between text-xs text-brand-700 font-semibold">
          <span>Buka dokumentasi</span>
          <span class="group-hover:translate-x-1 transition"></span>
         </div>
        </div>
       </a>

       <!-- Card Kegiatan 4 -->
       <a class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-2xs flex flex-col group transition" href="{{ route('pages.informasi.kegiatan') }}">
        <div class="relative h-44 overflow-hidden bg-gray-100">
         <img alt="Jalan Sehat &amp; Senam Bersama" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="{{ asset('assets/images/info-senam.jpg') }}"/>
         <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-brand-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
          KEBUGARAN
         </span>
        </div>
        <div class="p-4 flex flex-col flex-grow justify-between">
         <div>
          <span class="text-[10px] font-bold text-gray-500 mb-1.5 flex items-center gap-1">
           <svg class="w-3 h-3 text-brand-600" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
           06 DES 2026
          </span>
          <h4 class="font-bold text-sm text-gray-900 group-hover:text-brand-700 transition leading-snug line-clamp-2">
           Jalan Sehat &amp; Senam Bersama
          </h4>
         </div>
         <div class="mt-3 pt-3 border-t border-gray-50 flex items-center justify-between text-xs text-brand-700 font-semibold">
          <span>Buka dokumentasi</span>
          <span class="group-hover:translate-x-1 transition"></span>
         </div>
        </div>
       </a>
      </div>
     </div>
    </div>
   </section>
    </div>
   </section>
   <section class="py-16 lg:py-20 bg-gray-50/70 border-y border-gray-100" id="berita">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
     <!-- Section Header -->
     <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
      <div>
       <div class="accent-pill">
       </div>
       <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
        Berita &amp; Kegiatan Terkini
       </h2>
       <p class="text-sm sm:text-base text-gray-500 font-medium mt-1">
        Ikuti perkembangan terbaru kegiatan dan informasi penting di Desa Betro.
       </p>
      </div>
      <a class="inline-flex items-center gap-1.5 text-sm font-bold text-brand-700 hover:text-brand-800 transition group" data-detail-text="Menampilkan seluruh berita dan pengumuman resmi Desa Betro." data-detail-title="Arsip Berita" href="javascript:void(0)">
       <span>
        Lihat Semua
       </span>
      </a>
     </div>
     <!-- Grid 3 Kartu Berita -->
     <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Berita 1 -->
      <article aria-label="Kerja Bakti Bersama Warga, Wujud Kepedulian Lingkungan Desa Betro" class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-2xs flex flex-col group cursor-pointer" data-detail-text="Pemerintah Desa Betro bersama masyarakat melaksanakan kegiatan kerja bakti lingkungan secara gotong royong." data-detail-title="Kerja Bakti Bersama Warga" role="button" tabindex="0">
       <div class="relative h-48 overflow-hidden bg-gray-100">
        <img alt="Kerja Bakti Desa Betro" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="https://images.unsplash.com/photo-1593113598332-cd288d649433?q=80&amp;w=800&amp;auto=format&amp;fit=crop"/>
       </div>
       <div class="p-6 flex flex-col flex-grow justify-between">
        <div>
         <div class="flex items-center gap-3 mb-3">
          <span class="px-2.5 py-1 rounded-md bg-brand-700 text-white text-[11px] font-bold">
           Kegiatan Desa
          </span>
          <span class="text-xs text-gray-400 font-medium flex items-center gap-1">
           <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 7V3m8 3V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
            </path>
           </svg>
           12 September 2026
          </span>
         </div>
         <h3 class="text-base font-bold text-gray-900 mb-2 leading-snug group-hover:text-brand-700 transition">
          Kerja Bakti Bersama Warga, Wujud Kepedulian Lingkungan Desa Betro
         </h3>
         <p class="text-xs sm:text-sm text-gray-500 leading-relaxed mb-4 line-clamp-2">
          Pemerintah Desa Betro bersama masyarakat melaksanakan kegiatan kerja bakti lingkungan...
         </p>
        </div>
       </div>
      </article>
      <!-- Berita 2 -->
      <article aria-label="Pertanian Padi Jadi Potensi Unggulan Desa Betro" class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-2xs flex flex-col group cursor-pointer" data-detail-text="Sektor pertanian khususnya padi menjadi salah satu potensi utama yang terus dikembangkan di Desa Betro." data-detail-title="Pertanian Padi Potensi Unggulan" role="button" tabindex="0">
       <div class="relative h-48 overflow-hidden bg-gray-100">
        <img alt="Pertanian Padi Desa Betro" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="https://images.unsplash.com/photo-1530587191325-3db32d826c18?q=80&amp;w=800&amp;auto=format&amp;fit=crop"/>
       </div>
       <div class="p-6 flex flex-col flex-grow justify-between">
        <div>
         <div class="flex items-center gap-3 mb-3">
          <span class="px-2.5 py-1 rounded-md bg-brand-700 text-white text-[11px] font-bold">
           Potensi Desa
          </span>
          <span class="text-xs text-gray-400 font-medium flex items-center gap-1">
           <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 7V3m8 3V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
            </path>
           </svg>
           8 September 2026
          </span>
         </div>
         <h3 class="text-base font-bold text-gray-900 mb-2 leading-snug group-hover:text-brand-700 transition">
          Pertanian Padi Jadi Potensi Unggulan Desa Betro
         </h3>
         <p class="text-xs sm:text-sm text-gray-500 leading-relaxed mb-4 line-clamp-2">
          Sektor pertanian khususnya padi menjadi salah satu potensi utama yang terus dikembangkan...
         </p>
        </div>
       </div>
      </article>
      <!-- Berita 3 -->
      <article aria-label="Musyawarah Desa Bahas Rencana Pembangunan Tahun 2026" class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-2xs flex flex-col group cursor-pointer" data-detail-text="Pemerintah Desa Betro menggelar musyawarah desa untuk membahas rencana pembangunan tahun 2026." data-detail-title="Musyawarah Desa Pembangunan" role="button" tabindex="0">
       <div class="relative h-48 overflow-hidden bg-gray-100">
        <img alt="Musyawarah Desa Betro" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="https://images.unsplash.com/photo-1577495508048-b635879837f1?q=80&amp;w=800&amp;auto=format&amp;fit=crop"/>
       </div>
       <div class="p-6 flex flex-col flex-grow justify-between">
        <div>
         <div class="flex items-center gap-3 mb-3">
          <span class="px-2.5 py-1 rounded-md bg-brand-900 text-white text-[11px] font-bold">
           Pemerintahan
          </span>
          <span class="text-xs text-gray-400 font-medium flex items-center gap-1">
           <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 7V3m8 3V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
            </path>
           </svg>
           3 September 2026
          </span>
         </div>
         <h3 class="text-base font-bold text-gray-900 mb-2 leading-snug group-hover:text-brand-700 transition">
          Musyawarah Desa Bahas Rencana Pembangunan Tahun 2026
         </h3>
         <p class="text-xs sm:text-sm text-gray-500 leading-relaxed mb-4 line-clamp-2">
          Pemerintah Desa Betro menggelar musyawarah desa untuk membahas rencana pembangunan...
         </p>
        </div>
        </div>
       </div>
      </article>
     </div>
    </div>
   </section>

@endsection

@section('after-content')
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
