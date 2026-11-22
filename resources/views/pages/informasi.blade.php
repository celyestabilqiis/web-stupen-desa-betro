@extends('layouts.app')

@section('title', 'Informasi Publik - Website Resmi Desa Betro')
@section('description', 'Portal informasi, layanan, dan kegiatan Pemerintah Desa Betro. Halaman informasi menggunakan konten contoh yang dapat disesuaikan.')
@section('page-key', 'informasi')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-12 site-main information-page">
   <!-- Hero Informasi -->
   <nav aria-label="Breadcrumb" class="page-breadcrumb">
    <a href="{{ route('pages.home') }}">
     Beranda
    </a>
    <span>
     /
    </span>
    <span aria-current="page">
     Informasi Publik
    </span>
   </nav>
   <section class="information-hero">
    <span class="information-hero-ornament ornament-left" aria-hidden="true"></span>
    <span class="information-hero-ornament ornament-right" aria-hidden="true"></span>
    <img alt="Pemandangan pedesaan asri Desa Betro" src="{{ asset('assets/images/informasi-desa.jpg') }}"/>
    <div class="information-hero-overlay"></div>
    <div class="information-hero-content">
     <span class="information-hero-kicker"><span></span> Informasi Desa Betro</span>
     <h1>Pusat Informasi<br/>Desa Betro</h1>
     <p>Temukan berita, pengumuman, layanan, dan dokumen resmi desa dalam satu portal informasi yang transparan dan mudah diakses.</p>
     
    </div>
   </section>
   <section class="information-stats" aria-label="Ringkasan Desa">
    <div class="information-stat"><div class="information-stat-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div><div><strong>{{ $publicStatistics->get('total-penduduk')?->nilai_format ?? '—' }}</strong><span>Total Penduduk</span></div></div>
    <div class="information-stat"><div class="information-stat-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="7" r="4"/><path d="M5.5 21v-2a6.5 6.5 0 0 1 13 0v2"/></svg></div><div><strong>{{ $publicStatistics->get('penduduk-laki-laki')?->nilai_format ?? '—' }}</strong><span>Laki-laki</span></div></div>
    <div class="information-stat"><div class="information-stat-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="7" r="4"/><path d="M5.5 21v-2a6.5 6.5 0 0 1 13 0v2M9 16h6"/></svg></div><div><strong>{{ $publicStatistics->get('penduduk-perempuan')?->nilai_format ?? '—' }}</strong><span>Perempuan</span></div></div>
    <a class="information-stat information-stat-link" href="{{ route('pages.informasi.statistik') }}"><div class="information-stat-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3v18h18M7 16l4-4 3 3 5-7"/></svg></div><div><strong class="information-stat-small">Statistik Desa</strong><span>Lihat data lengkap </span></div></a>
   </section>
   <!-- Arsip & Dokumentasi Desa Terbaru -->
   <section class="section-separator">
    <div class="flex items-center justify-between mb-6">
     <div>
      <div class="accent-pill">
      </div>
      <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
       Arsip &amp; Dokumentasi Desa Terbaru
      </h2>
     </div>
     <a class="text-xs text-brand-700 hover:text-brand-900 font-semibold flex items-center gap-1" href="{{ route('pages.arsip.index') }}">
      Lihat Semua
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
       <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
      </svg>
     </a>
    </div>
    @if($arsipTerbaru->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ min($arsipTerbaru->count(), 5) }} gap-4">
     @foreach($arsipTerbaru as $arsip)
     <a href="{{ route('pages.arsip.show', $arsip->slug) }}" class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
      <div>
       @if($arsip->gambar_sampul)
       <img alt="{{ $arsip->judul }}" class="w-full h-28 object-cover" src="{{ asset('storage/' . $arsip->gambar_sampul) }}"/>
       @else
       <div class="w-full h-28 bg-gray-100 flex items-center justify-center">
        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
       </div>
       @endif
       <div class="p-3">
        <h4 class="font-bold text-xs text-gray-900 mb-1 leading-tight group-hover:text-brand-700 transition line-clamp-2">
         {{ $arsip->judul }}
        </h4>
        <p class="text-[10px] text-gray-500 line-clamp-2">
         {{ $arsip->ringkasan }}
        </p>
       </div>
      </div>
      <div class="px-3 pb-3 flex items-center justify-between">
       <span class="text-[10px] text-brand-700 font-semibold">{{ $arsip->labelKategori() }}</span>
       <span class="text-gray-400 text-[10px]">{{ $arsip->tanggal->translatedFormat('d M Y') }}</span>
      </div>
     </a>
     @endforeach
    </div>
    @else
    <p class="text-sm text-gray-500 text-center py-8">Belum ada arsip atau dokumentasi yang dipublikasikan.</p>
    @endif
   </section>

   <!-- Kategori Informasi Desa -->
   <section class="section-separator mt-10 pt-10 border-t border-gray-100">
    <div class="mb-6">
     <div class="accent-pill"></div>
     <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
      Kategori Informasi Desa Lainnya
     </h2>
     <p class="text-sm text-gray-500 font-medium mt-1">
      Jelajahi data statistik kependudukan dan arsip dokumentasi kegiatan Desa Betro.
     </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
     <!-- Card 1: Statistik Desa -->
     <a href="{{ route('pages.informasi.statistik') }}" class="card-hover bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between group transition">
      <div>
       <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center mb-4 group-hover:bg-brand-700 group-hover:text-white transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
       </div>
       <span class="text-[10px] font-bold text-brand-700 uppercase tracking-widest block mb-1">01 &bull; KEPENDUDUKAN</span>
       <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-700 transition mb-2">Statistik Desa</h3>
       <p class="text-xs text-gray-500 leading-relaxed">
        Data populasi penduduk, rasio gender, sebaran wilayah, dan statistik demografi Desa Betro secara transparan.
       </p>
      </div>
      <div class="mt-5 pt-4 border-t border-gray-50 flex items-center justify-between text-xs font-bold text-brand-700">
       <span>Buka Statistik</span>
       <span class="group-hover:translate-x-1 transition"></span>
      </div>
     </a>

     <!-- Card 2: Arsip & Dokumentasi Desa -->
     <a href="{{ route('pages.arsip.index') }}" class="card-hover bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between group transition">
      <div>
       <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
       </div>
       <span class="text-[10px] font-bold text-blue-700 uppercase tracking-widest block mb-1">02 &bull; ARSIP &amp; DOKUMENTASI</span>
       <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-700 transition mb-2">Arsip &amp; Dokumentasi Desa</h3>
       <p class="text-xs text-gray-500 leading-relaxed">
        Arsip dokumen resmi, laporan APBDes, dokumentasi kegiatan, dan galeri foto desa dalam satu halaman.
       </p>
      </div>
      <div class="mt-5 pt-4 border-t border-gray-50 flex items-center justify-between text-xs font-bold text-blue-700">
       <span>Buka Arsip</span>
       <span class="group-hover:translate-x-1 transition"></span>
      </div>
     </a>
    </div>
   </section>
  </main>
@endsection

@section('after-content')

@endsection
