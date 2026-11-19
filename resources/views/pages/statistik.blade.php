@extends('layouts.app')

@section('title', 'Statistik Desa Betro - Website Resmi Desa Betro')
@section('description', 'Data statistik kependudukan, demografi wilayah, dan profil wilayah Desa Betro secara terbuka dan akurat.')
@section('page-key', 'informasi-statistik')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-12 site-main">
   <!-- Breadcrumb -->
   <nav aria-label="Breadcrumb" class="page-breadcrumb">
    <a href="{{ route('pages.home') }}">Beranda</a>
    <span>/</span>
    <a href="{{ route('pages.informasi') }}">Informasi</a>
    <span>/</span>
    <span aria-current="page">Statistik Desa</span>
   </nav>

   <!-- Hero Banner -->
   <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-brand-950 via-brand-900 to-brand-700 px-6 py-10 text-white sm:px-10 sm:py-14 shadow-xl">
    <div class="absolute -right-12 -top-16 h-64 w-64 rounded-full border border-white/10 pointer-events-none"></div>
    <div class="absolute -right-2 -top-6 h-44 w-44 rounded-full border border-white/10 pointer-events-none"></div>
    <div class="relative max-w-2xl">
     <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold tracking-wide text-white/90">
      <span class="h-2 w-2 rounded-full bg-amber-400"></span>
      DATA &amp; DEMOGRAFI DESA
     </span>
     <h1 class="mt-5 text-4xl font-extrabold leading-tight sm:text-5xl">Statistik Desa Betro</h1>
     <p class="mt-4 max-w-xl text-sm leading-relaxed text-white/80 sm:text-base">
      Transparansi data kependudukan, demografi jenis kelamin, sebaran wilayah, dan profil pembangunan Pemerintah Desa Betro.
     </p>
     <div class="mt-7 flex flex-wrap items-center gap-3">
      <a class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-xs sm:text-sm font-bold text-brand-800 shadow-sm transition hover:bg-brand-50" href="#ringkasan-statistik">
       Lihat Data Lengkap &darr;
      </a>
      <a class="inline-flex items-center gap-2 rounded-full bg-brand-900/60 border border-white/20 px-5 py-2.5 text-xs sm:text-sm font-semibold text-white transition hover:bg-brand-800" href="{{ route('pages.informasi.dokumen') }}">
       Unduh Buku Profil Desa 
      </a>
     </div>
    </div>
   </section>

   <!-- 4 Kartu Statistik Utama -->
   <section class="section-separator mt-10" id="ringkasan-statistik">
    <div class="mb-8">
     <span class="text-xs font-bold uppercase tracking-[.18em] text-brand-700">RINGKASAN POPULASI</span>
     <h2 class="mt-1 text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">Data Agregat Kependudukan</h2>
     <p class="mt-2 text-sm text-gray-500 max-w-2xl">Rekapitulasi data kependudukan resmi berdasarkan pendataan semester berjalan.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
     <!-- Populasi -->
     <div class="card-hover bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between border-l-4 !border-l-brand-700">
      <div class="flex items-center justify-between mb-4">
       <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Penduduk</span>
       <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
       </div>
      </div>
      <div>
       <span class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight">2.630</span>
       <p class="text-xs text-gray-500 mt-1">Jiwa terdaftar dalam KK</p>
      </div>
     </div>

     <!-- Laki-laki -->
     <div class="card-hover bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between border-l-4 !border-l-blue-600">
      <div class="flex items-center justify-between mb-4">
       <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Laki-Laki</span>
       <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/><path d="M5.5 21v-2a6.5 6.5 0 0113 0v2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
       </div>
      </div>
      <div>
       <span class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight">735</span>
       <p class="text-xs text-blue-600 font-semibold mt-1">48.7% dari total penduduk</p>
      </div>
     </div>

     <!-- Perempuan -->
     <div class="card-hover bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between border-l-4 !border-l-rose-500">
      <div class="flex items-center justify-between mb-4">
       <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Perempuan</span>
       <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/><path d="M5.5 21v-2a6.5 6.5 0 0113 0v2M9 16h6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
       </div>
      </div>
      <div>
       <span class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight">775</span>
       <p class="text-xs text-rose-600 font-semibold mt-1">51.3% dari total penduduk</p>
      </div>
     </div>

     <!-- Luas Wilayah -->
     <div class="card-hover bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between border-l-4 !border-l-amber-500">
      <div class="flex items-center justify-between mb-4">
       <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Luas Wilayah</span>
       <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
       </div>
      </div>
      <div>
       <span class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight">4.33 <span class="text-lg font-bold text-gray-500">km&sup2;</span></span>
       <p class="text-xs text-gray-500 mt-1">Kecamatan Kemlagi, Mojokerto</p>
      </div>
     </div>
    </div>
   </section>

   <!-- Rincian Distribusi Wilayah & Mata Pencaharian -->
   <section class="section-separator grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Distribusi Kewilayahan -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 shadow-sm">
     <div class="flex items-center gap-3 mb-6">
      <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center font-bold">
       01
      </div>
      <div>
       <h3 class="text-lg font-extrabold text-gray-900">Sebaran Kewilayahan Dusun</h3>
       <p class="text-xs text-gray-500">Pembagian wilayah administratif Desa Betro</p>
      </div>
     </div>

     <div class="space-y-4">
      <div>
       <div class="flex justify-between text-xs font-bold text-gray-700 mb-1">
        <span>Dusun Betro (Pusat Pemerintahan)</span>
        <span>1.120 Jiwa (42.5%)</span>
       </div>
       <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
        <div class="h-full bg-brand-700 rounded-full" style="width: 42.5%"></div>
       </div>
      </div>

      <div>
       <div class="flex justify-between text-xs font-bold text-gray-700 mb-1">
        <span>Dusun Sukses Barat</span>
        <span>820 Jiwa (31.2%)</span>
       </div>
       <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
        <div class="h-full bg-blue-600 rounded-full" style="width: 31.2%"></div>
       </div>
      </div>

      <div>
       <div class="flex justify-between text-xs font-bold text-gray-700 mb-1">
        <span>Dusun Sukses Timur</span>
        <span>690 Jiwa (26.3%)</span>
       </div>
       <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
        <div class="h-full bg-amber-500 rounded-full" style="width: 26.3%"></div>
       </div>
      </div>
     </div>

     <div class="mt-6 pt-5 border-t border-gray-100 grid grid-cols-2 gap-4 text-center">
      <div class="bg-gray-50/80 p-3 rounded-xl">
       <span class="block text-xl font-bold text-gray-900">6</span>
       <span class="text-[11px] text-gray-500">Rukun Warga (RW)</span>
      </div>
      <div class="bg-gray-50/80 p-3 rounded-xl">
       <span class="block text-xl font-bold text-gray-900">22</span>
       <span class="text-[11px] text-gray-500">Rukun Tetangga (RT)</span>
      </div>
     </div>
    </div>

    <!-- Mata Pencaharian Penduduk -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 shadow-sm">
     <div class="flex items-center gap-3 mb-6">
      <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold">
       02
      </div>
      <div>
       <h3 class="text-lg font-extrabold text-gray-900">Mata Pencaharian Utama</h3>
       <p class="text-xs text-gray-500">Komposisi sektor profesi masyarakat desa</p>
      </div>
     </div>

     <div class="space-y-4">
      <div>
       <div class="flex justify-between text-xs font-bold text-gray-700 mb-1">
        <span>Pertanian &amp; Perkebunan</span>
        <span>48%</span>
       </div>
       <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
        <div class="h-full bg-emerald-600 rounded-full" style="width: 48%"></div>
       </div>
      </div>

      <div>
       <div class="flex justify-between text-xs font-bold text-gray-700 mb-1">
        <span>Wiraswasta &amp; Pelaku UMKM</span>
        <span>26%</span>
       </div>
       <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
        <div class="h-full bg-brand-700 rounded-full" style="width: 26%"></div>
       </div>
      </div>

      <div>
       <div class="flex justify-between text-xs font-bold text-gray-700 mb-1">
        <span>Karyawan Swasta &amp; Jasa</span>
        <span>18%</span>
       </div>
       <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
        <div class="h-full bg-blue-600 rounded-full" style="width: 18%"></div>
       </div>
      </div>

      <div>
       <div class="flex justify-between text-xs font-bold text-gray-700 mb-1">
        <span>PNS / TNI / Polri</span>
        <span>8%</span>
       </div>
       <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
        <div class="h-full bg-purple-600 rounded-full" style="width: 8%"></div>
       </div>
      </div>
     </div>

     <div class="mt-6 pt-5 border-t border-gray-100 flex items-center justify-between">
      <span class="text-xs text-gray-500">Sumber data: Laporan Tahunan Desa Betro</span>
      <a href="{{ route('pages.potensi') }}" class="text-xs font-bold text-brand-700 hover:underline">
       Lihat Sektor UMKM 
      </a>
     </div>
    </div>
   </section>
</main>
@endsection
