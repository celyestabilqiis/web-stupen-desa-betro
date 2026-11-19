@extends('layouts.app')

@section('title', 'Dokumentasi Kegiatan Desa - Website Resmi Desa Betro')
@section('description', 'Dokumentasi foto, berita acara, dan galeri kegiatan kemasyarakatan serta program kerja Pemerintah Desa Betro.')
@section('page-key', 'informasi-kegiatan')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-12 site-main">
   <!-- Breadcrumb -->
   <nav aria-label="Breadcrumb" class="page-breadcrumb">
    <a href="{{ route('pages.home') }}">Beranda</a>
    <span>/</span>
    <a href="{{ route('pages.informasi') }}">Informasi</a>
    <span>/</span>
    <span aria-current="page">Dokumentasi Kegiatan</span>
   </nav>

   <!-- Hero Banner -->
   <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-brand-950 via-brand-900 to-brand-700 px-6 py-10 text-white sm:px-10 sm:py-14 shadow-xl">
    <div class="absolute -right-12 -top-16 h-64 w-64 rounded-full border border-white/10 pointer-events-none"></div>
    <div class="absolute -right-2 -top-6 h-44 w-44 rounded-full border border-white/10 pointer-events-none"></div>
    <div class="relative max-w-2xl">
     <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold tracking-wide text-white/90">
      <span class="h-2 w-2 rounded-full bg-amber-400"></span>
      GALERI &amp; DOKUMENTASI RESMI
     </span>
     <h1 class="mt-5 text-4xl font-extrabold leading-tight sm:text-5xl">Dokumentasi Kegiatan Desa</h1>
     <p class="mt-4 max-w-xl text-sm leading-relaxed text-white/80 sm:text-base">
      Arsip rekaman visual dan dokumentasi pelaksanaan program pembangunan, pembinaan warga, serta kegiatan kebersamaan di Desa Betro.
     </p>
     <div class="mt-7 flex flex-wrap items-center gap-3">
      <a class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-xs sm:text-sm font-bold text-brand-800 shadow-sm transition hover:bg-brand-50" href="#galeri-kegiatan">
       Lihat Seluruh Kegiatan &darr;
      </a>
      <a class="inline-flex items-center gap-2 rounded-full bg-brand-900/60 border border-white/20 px-5 py-2.5 text-xs sm:text-sm font-semibold text-white transition hover:bg-brand-800" href="{{ route('pages.home') }}#berita">
       Baca Berita Terkini 
      </a>
     </div>
    </div>
   </section>

   <!-- Grid Dokumentasi Kegiatan -->
   <section class="section-separator mt-10" id="galeri-kegiatan">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
     <div>
      <span class="text-xs font-bold uppercase tracking-[.18em] text-brand-700">ARSIP FOTO KEGIATAN</span>
      <h2 class="mt-1 text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">Dokumentasi Program &amp; Acara</h2>
      <p class="mt-2 text-sm text-gray-500 max-w-2xl">Dokumentasi kegiatan resmi bersama aparat desa, lembaga kemasyarakatan, dan seluruh warga Betro.</p>
     </div>
     <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1.5 rounded-full">
      8 Kegiatan Terdokumentasi
     </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
     <!-- Card 1: Musrenbang -->
     <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col group transition">
      <div class="relative h-48 overflow-hidden bg-gray-100">
       <img alt="Musrenbang Desa 2026" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="{{ asset('assets/images/info-musrenbang.jpg') }}"/>
       <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-brand-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
        PEMERINTAHAN
       </span>
      </div>
      <div class="p-4 flex flex-col flex-grow justify-between">
       <div>
        <span class="text-[10px] font-bold text-gray-400 mb-1.5 flex items-center gap-1">
         <svg class="w-3 h-3 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
         15 NOV 2026
        </span>
        <h3 class="font-bold text-sm text-gray-900 group-hover:text-brand-700 transition leading-snug line-clamp-2">
         Musrenbang Desa 2026
        </h3>
        <p class="text-xs text-gray-500 mt-2 line-clamp-2">
         Musyawarah perencanaan pembangunan desa untuk menyerap aspirasi dan usulan prioritas warga dari seluruh dusun.
        </p>
       </div>
       <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-brand-700 font-semibold">
        <span>Foto Dokumentasi</span>
        <span class="text-gray-400">Balai Desa</span>
       </div>
      </div>
     </div>

     <!-- Card 2: Pelatihan UMKM -->
     <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col group transition">
      <div class="relative h-48 overflow-hidden bg-gray-100">
       <img alt="Pelatihan UMKM Kuliner" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="{{ asset('assets/images/info-umkm.jpg') }}"/>
       <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-brand-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
        EKONOMI
       </span>
      </div>
      <div class="p-4 flex flex-col flex-grow justify-between">
       <div>
        <span class="text-[10px] font-bold text-gray-400 mb-1.5 flex items-center gap-1">
         <svg class="w-3 h-3 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
         22 NOV 2026
        </span>
        <h3 class="font-bold text-sm text-gray-900 group-hover:text-brand-700 transition leading-snug line-clamp-2">
         Pelatihan UMKM Kuliner
        </h3>
        <p class="text-xs text-gray-500 mt-2 line-clamp-2">
         Pelatihan peningkatan higienitas, perizinan P-IRT, dan inovasi kemasan bagi para pelaku usaha makanan ringan desa.
        </p>
       </div>
       <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-brand-700 font-semibold">
        <span>Foto Dokumentasi</span>
        <span class="text-gray-400">Aula Desa</span>
       </div>
      </div>
     </div>

     <!-- Card 3: Penyuluhan Kesehatan -->
     <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col group transition">
      <div class="relative h-48 overflow-hidden bg-gray-100">
       <img alt="Penyuluhan Kesehatan Lingkungan" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="{{ asset('assets/images/info-kesehatan.jpg') }}"/>
       <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-brand-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
        KESEHATAN
       </span>
      </div>
      <div class="p-4 flex flex-col flex-grow justify-between">
       <div>
        <span class="text-[10px] font-bold text-gray-400 mb-1.5 flex items-center gap-1">
         <svg class="w-3 h-3 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
         29 NOV 2026
        </span>
        <h3 class="font-bold text-sm text-gray-900 group-hover:text-brand-700 transition leading-snug line-clamp-2">
         Penyuluhan Kesehatan Lingkungan
        </h3>
        <p class="text-xs text-gray-500 mt-2 line-clamp-2">
         Pemeriksaan kesehatan gratis dan sosialisasi perilaku hidup bersih dan sehat bersama tenaga medis Puskesmas.
        </p>
       </div>
       <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-brand-700 font-semibold">
        <span>Foto Dokumentasi</span>
        <span class="text-gray-400">Posyandu Betro</span>
       </div>
      </div>
     </div>

     <!-- Card 4: Jalan Sehat -->
     <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col group transition">
      <div class="relative h-48 overflow-hidden bg-gray-100">
       <img alt="Jalan Sehat &amp; Senam Bersama" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="{{ asset('assets/images/info-senam.jpg') }}"/>
       <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-brand-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
        KEBUGARAN
       </span>
      </div>
      <div class="p-4 flex flex-col flex-grow justify-between">
       <div>
        <span class="text-[10px] font-bold text-gray-400 mb-1.5 flex items-center gap-1">
         <svg class="w-3 h-3 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
         06 DES 2026
        </span>
        <h3 class="font-bold text-sm text-gray-900 group-hover:text-brand-700 transition leading-snug line-clamp-2">
         Jalan Sehat &amp; Senam Bersama
        </h3>
        <p class="text-xs text-gray-500 mt-2 line-clamp-2">
         Kegiatan olahraga bersama seluruh lapisan warga untuk mempererat tali silaturahmi serta menjaga kebugaran jasmani.
        </p>
       </div>
       <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-brand-700 font-semibold">
        <span>Foto Dokumentasi</span>
        <span class="text-gray-400">Lapangan Desa</span>
       </div>
      </div>
     </div>

     <!-- Card 5: Jaga Lingkungan -->
     <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col group transition">
      <div class="relative h-48 overflow-hidden bg-gray-100">
       <img alt="Program Gotong Royong Jaga Lingkungan" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="{{ asset('assets/images/info-lingkungan.jpg') }}"/>
       <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-brand-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
        LINGKUNGAN
       </span>
      </div>
      <div class="p-4 flex flex-col flex-grow justify-between">
       <div>
        <span class="text-[10px] font-bold text-gray-400 mb-1.5 flex items-center gap-1">
         <svg class="w-3 h-3 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
         08 NOV 2026
        </span>
        <h3 class="font-bold text-sm text-gray-900 group-hover:text-brand-700 transition leading-snug line-clamp-2">
         Program Gotong Royong Lingkungan
        </h3>
        <p class="text-xs text-gray-500 mt-2 line-clamp-2">
         Kerja bakti pembersihan saluran irigasi pertanian dan penataan ruang hijau lingkungan bersama karang taruna.
        </p>
       </div>
       <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-brand-700 font-semibold">
        <span>Foto Dokumentasi</span>
        <span class="text-gray-400">Dusun Betro</span>
       </div>
      </div>
     </div>

     <!-- Card 6: Pelatihan Digital -->
     <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col group transition">
      <div class="relative h-48 overflow-hidden bg-gray-100">
       <img alt="Pelatihan Literasi Digital Warga" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="{{ asset('assets/images/info-digital.jpg') }}"/>
       <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-brand-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
        PEMBERDAYAAN
       </span>
      </div>
      <div class="p-4 flex flex-col flex-grow justify-between">
       <div>
        <span class="text-[10px] font-bold text-gray-400 mb-1.5 flex items-center gap-1">
         <svg class="w-3 h-3 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
         02 NOV 2026
        </span>
        <h3 class="font-bold text-sm text-gray-900 group-hover:text-brand-700 transition leading-snug line-clamp-2">
         Pelatihan Literasi Digital Warga
        </h3>
        <p class="text-xs text-gray-500 mt-2 line-clamp-2">
         Bimbingan teknis penggunaan aplikasi SAPAW dan internet aman bagi masyarakat serta pemuda desa.
        </p>
       </div>
       <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-brand-700 font-semibold">
        <span>Foto Dokumentasi</span>
        <span class="text-gray-400">Ruang Pertemuan</span>
       </div>
      </div>
     </div>

     <!-- Card 7: Pembangunan Jalan -->
     <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col group transition">
      <div class="relative h-48 overflow-hidden bg-gray-100">
       <img alt="Monitoring Perbaikan Jalan Dusun Sukses" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="{{ asset('assets/images/info-jalan.jpg') }}"/>
       <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-brand-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
        INFRASTRUKTUR
       </span>
      </div>
      <div class="p-4 flex flex-col flex-grow justify-between">
       <div>
        <span class="text-[10px] font-bold text-gray-400 mb-1.5 flex items-center gap-1">
         <svg class="w-3 h-3 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
         28 OKT 2026
        </span>
        <h3 class="font-bold text-sm text-gray-900 group-hover:text-brand-700 transition leading-snug line-clamp-2">
         Monitoring Perbaikan Jalan Dusun
        </h3>
        <p class="text-xs text-gray-500 mt-2 line-clamp-2">
         Pengecekan langsung hasil pengaspalan dan pelebaran akses jalan lingkungan yang didanai melalui APBDes Betro.
        </p>
       </div>
       <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-brand-700 font-semibold">
        <span>Foto Dokumentasi</span>
        <span class="text-gray-400">Dusun Sukses</span>
       </div>
      </div>
     </div>

     <!-- Card 8: Musyawarah Desa -->
     <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col group transition">
      <div class="relative h-48 overflow-hidden bg-gray-100">
       <img alt="Musyawarah Desa Penetapan Prioritas" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="{{ asset('assets/images/info-musyawarah.jpg') }}"/>
       <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-brand-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
        PEMERINTAHAN
       </span>
      </div>
      <div class="p-4 flex flex-col flex-grow justify-between">
       <div>
        <span class="text-[10px] font-bold text-gray-400 mb-1.5 flex items-center gap-1">
         <svg class="w-3 h-3 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
         20 OKT 2026
        </span>
        <h3 class="font-bold text-sm text-gray-900 group-hover:text-brand-700 transition leading-snug line-clamp-2">
         Musyawarah Desa Penetapan
        </h3>
        <p class="text-xs text-gray-500 mt-2 line-clamp-2">
         Forum musyawarah bersama warga dan lembaga desa untuk evaluasi pelaksanaan program tahun anggaran berjalan.
        </p>
       </div>
       <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-brand-700 font-semibold">
        <span>Foto Dokumentasi</span>
        <span class="text-gray-400">Balai Desa</span>
       </div>
      </div>
     </div>
    </div>
   </section>
</main>
@endsection
