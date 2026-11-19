@extends('layouts.app')

@section('title', 'Publikasi Dokumen Resmi - Website Resmi Desa Betro')
@section('description', 'Arsip publikasi dokumen resmi, laporan APBDes, dan panduan regulasi Desa Betro secara terbuka dan transparan.')
@section('page-key', 'informasi-dokumen')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-12 site-main">
   <!-- Breadcrumb -->
   <nav aria-label="Breadcrumb" class="page-breadcrumb">
    <a href="{{ route('pages.home') }}">Beranda</a>
    <span>/</span>
    <a href="{{ route('pages.informasi') }}">Informasi</a>
    <span>/</span>
    <span aria-current="page">Publikasi Dokumen</span>
   </nav>

   <!-- Hero Banner -->
   <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-brand-950 via-brand-900 to-brand-700 px-6 py-10 text-white sm:px-10 sm:py-14 shadow-xl">
    <div class="absolute -right-12 -top-16 h-64 w-64 rounded-full border border-white/10 pointer-events-none"></div>
    <div class="absolute -right-2 -top-6 h-44 w-44 rounded-full border border-white/10 pointer-events-none"></div>
    <div class="relative max-w-2xl">
     <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold tracking-wide text-white/90">
      <span class="h-2 w-2 rounded-full bg-amber-400"></span>
      ARSIP &amp; PUBLIKASI RESMI
     </span>
     <h1 class="mt-5 text-4xl font-extrabold leading-tight sm:text-5xl">Publikasi Dokumen Desa</h1>
     <p class="mt-4 max-w-xl text-sm leading-relaxed text-white/80 sm:text-base">
      Unduh dan akses laporan APBDes, profil aparatur pemerintahan, data kependudukan, dan panduan administrasi warga Desa Betro secara terbuka.
     </p>
     <div class="mt-7 flex flex-wrap items-center gap-3">
      <a class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-xs sm:text-sm font-bold text-brand-800 shadow-sm transition hover:bg-brand-50" href="#daftar-dokumen">
       Jelajahi Arsip &darr;
      </a>
      <a class="inline-flex items-center gap-2 rounded-full bg-brand-900/60 border border-white/20 px-5 py-2.5 text-xs sm:text-sm font-semibold text-white transition hover:bg-brand-800" href="{{ route('pages.informasi.statistik') }}">
       Lihat Data Statistik 
      </a>
     </div>
    </div>
   </section>

   <!-- Daftar Dokumen Resmi -->
   <section class="section-separator mt-10" id="daftar-dokumen">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
     <div>
      <span class="text-xs font-bold uppercase tracking-[.18em] text-brand-700">ARSIP PUBLIK</span>
      <h2 class="mt-1 text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">Daftar Dokumen Resmi Desa</h2>
      <p class="mt-2 text-sm text-gray-500 max-w-2xl">Dokumen dapat diunduh atau dipelajari oleh seluruh warga masyarakat untuk keterbukaan informasi publik.</p>
     </div>
     <div class="flex items-center gap-2 text-xs font-semibold text-gray-500">
      <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
      Format PDF Resmi
     </div>
    </div>

    <!-- Grid Dokumen -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
     <!-- Dokumen 1: APBDES -->
     <div class="card-hover bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between border-l-4 !border-l-brand-700">
      <div>
       <div class="flex items-center justify-between mb-3">
        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold bg-brand-50 text-brand-700 border border-brand-100">
         APBDES
        </span>
        <span class="text-xs text-gray-400 font-medium">Tahun 2026</span>
       </div>
       <h3 class="text-lg font-bold text-gray-900 mb-2">Ringkasan APBDes 2026</h3>
       <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
        Laporan transparansi pendapatan, belanja, dan pembiayaan Anggaran Pendapatan dan Belanja Desa Betro tahun anggaran 2026.
       </p>
      </div>
      <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
       <span class="text-xs text-gray-400 flex items-center gap-1.5">
        <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
        PDF &bull; 1.8 MB
       </span>
       <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-700 hover:text-brand-900 transition">
        <span>Unduh Dokumen</span>
        <span aria-hidden="true"></span>
       </a>
      </div>
     </div>

     <!-- Dokumen 2: Profil Perangkat -->
     <div class="card-hover bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between border-l-4 !border-l-brand-700">
      <div>
       <div class="flex items-center justify-between mb-3">
        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
         PERANGKAT
        </span>
        <span class="text-xs text-gray-400 font-medium">Struktur 2025–2031</span>
       </div>
       <h3 class="text-lg font-bold text-gray-900 mb-2">Profil Perangkat Desa</h3>
       <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
        Buku susunan organisasi, rincian tugas pokok, dan fungsi masing-masing kepala seksi, kepala urusan, dan kepala dusun.
       </p>
      </div>
      <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
       <span class="text-xs text-gray-400 flex items-center gap-1.5">
        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
        PDF &bull; 2.4 MB
       </span>
       <a href="{{ route('pages.profile') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-700 hover:text-brand-900 transition">
        <span>Buka Halaman Profil</span>
        <span aria-hidden="true"></span>
       </a>
      </div>
     </div>

     <!-- Dokumen 3: Data Penduduk -->
     <div class="card-hover bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between border-l-4 !border-l-brand-700">
      <div>
       <div class="flex items-center justify-between mb-3">
        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
         DATA &amp; STATISTIK
        </span>
        <span class="text-xs text-gray-400 font-medium">Semester I</span>
       </div>
       <h3 class="text-lg font-bold text-gray-900 mb-2">Data Penduduk &amp; Demografi</h3>
       <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
        Buku data rekapitulasi jumlah penduduk, sebaran usia, tingkat pendidikan, dan mata pencaharian warga Desa Betro.
       </p>
      </div>
      <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
       <span class="text-xs text-gray-400 flex items-center gap-1.5">
        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
        PDF &bull; 1.2 MB
       </span>
       <a href="{{ route('pages.informasi.statistik') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-700 hover:text-brand-900 transition">
        <span>Lihat Statistik Lengkap</span>
        <span aria-hidden="true"></span>
       </a>
      </div>
     </div>

     <!-- Dokumen 4: Panduan Layanan SAPAW -->
     <div class="card-hover bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between border-l-4 !border-l-brand-700">
      <div>
       <div class="flex items-center justify-between mb-3">
        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-100">
         PANDUAN LAYANAN
        </span>
        <span class="text-xs text-gray-400 font-medium">Versi Terbaru</span>
       </div>
       <h3 class="text-lg font-bold text-gray-900 mb-2">Panduan Layanan SAPAW</h3>
       <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
        Petunjuk teknis pengurusan surat pengantar, administrasi kependudukan, izin usaha, dan pengaduan digital warga.
       </p>
      </div>
      <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
       <span class="text-xs text-gray-400 flex items-center gap-1.5">
        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
        PDF &bull; 3.1 MB
       </span>
       <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-700 hover:text-brand-900 transition">
        <span>Unduh Panduan</span>
        <span aria-hidden="true"></span>
       </a>
      </div>
     </div>

     <!-- Dokumen 5: Rencana Kerja Pemerintah Desa -->
     <div class="card-hover bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between border-l-4 !border-l-purple-600">
      <div>
       <div class="flex items-center justify-between mb-3">
        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold bg-purple-50 text-purple-700 border border-purple-100">
         PEMBANGUNAN
        </span>
        <span class="text-xs text-gray-400 font-medium">RKPDes</span>
       </div>
       <h3 class="text-lg font-bold text-gray-900 mb-2">Rencana Kerja Pemerintah Desa (RKPDes)</h3>
       <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
        Dokumen perencanaan tahunan desa yang memuat prioritas program pembangunan sarana fisik dan pemberdayaan masyarakat.
       </p>
      </div>
      <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
       <span class="text-xs text-gray-400 flex items-center gap-1.5">
        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
        PDF &bull; 4.2 MB
       </span>
       <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-700 hover:text-brand-900 transition">
        <span>Unduh Dokumen</span>
        <span aria-hidden="true"></span>
       </a>
      </div>
     </div>

     <!-- Dokumen 6: Regulasi & Perdes -->
     <div class="card-hover bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between border-l-4 !border-l-indigo-600">
      <div>
       <div class="flex items-center justify-between mb-3">
        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
         REGULASI
        </span>
        <span class="text-xs text-gray-400 font-medium">Hukum &amp; Tata Tertib</span>
       </div>
       <h3 class="text-lg font-bold text-gray-900 mb-2">Peraturan Desa (Perdes) Betro</h3>
       <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
        Kumpulan regulasi, keputusan kepala desa, dan kesepakatan bersama Badan Permusyawaratan Desa (BPD).
       </p>
      </div>
      <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
       <span class="text-xs text-gray-400 flex items-center gap-1.5">
        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
        PDF &bull; 2.1 MB
       </span>
       <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-700 hover:text-brand-900 transition">
        <span>Unduh Dokumen</span>
        <span aria-hidden="true"></span>
       </a>
      </div>
     </div>
    </div>
   </section>
</main>
@endsection
