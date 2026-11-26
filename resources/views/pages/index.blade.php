@extends('layouts.app')

@section('title', 'Website Resmi Desa Betro - Kecamatan Kemlagi - Kabupaten Mojokerto')
@section('description', 'Portal informasi, layanan, dan kegiatan Pemerintah Desa Betro. Halaman home menggunakan konten contoh yang dapat disesuaikan.')
@section('page-key', 'home')

@section('content')
<main class="home-main">
   <section class="relative min-h-screen flex items-center overflow-hidden bg-gray-900" id="beranda">
    <img alt="Persawahan Desa Betro" class="absolute inset-0 w-full h-full object-cover object-center" src="{{ asset('assets/images/potensi-sawah.jpg') }}"/>
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
       Pusat informasi, dan Dokumentasi Pemerintah Desa Betro untuk masyarakat.
      </p>
      
     </div>
    </div>
   </section>
   <section class="welcome-section" id="sambutan">
    <div class="welcome-inner">
     <div class="welcome-copy">
      <span class="information-section-kicker">SAMBUTAN KEPALA DESA</span>
      <h2>
       Selamat datang di portal digital Desa Betro
      </h2>
      <p>
       {{ $villageHead?->deskripsi ?: 'Portal ini menjadi ruang informasi bersama untuk mengenal desa, mengikuti kegiatan, mengakses layanan, dan melihat informasi publik dengan lebih mudah. Kami terus berupaya menghadirkan pelayanan yang terbuka, ramah, dan dekat dengan kebutuhan warga.' }}
      </p>
      <p class="welcome-greeting">
       Salam hangat, gotong royong, dan semangat membangun desa.
      </p>
      <div class="welcome-signature">
       @if($villageHead?->foto)
        <img class="welcome-avatar welcome-head-photo" src="{{ asset('storage/'.$villageHead->foto) }}" alt="Foto {{ $villageHead->nama }}" loading="lazy">
       @else
        @php($headInitials = $villageHead ? collect(preg_split('/\s+/', trim($villageHead->nama)))->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('') : null)
        <span class="welcome-avatar" aria-label="Inisial Kepala Desa">{{ $headInitials ?: '♙' }}</span>
       @endif
       <div>
        <strong>{{ $villageHead?->nama ?: 'Kepala Desa belum tersedia' }}</strong>
        <span>{{ $villageHead?->jabatan ?: 'Pemerintah Desa Betro' }}</span>
       </div>
      </div>
     </div>
     <div class="welcome-visual">
      <img alt="Hamparan persawahan sebagai ilustrasi suasana pedesaan" loading="lazy" src="{{ asset('assets/images/potensi-sawah.jpg') }}"/>
     </div>
    </div>
   </section>
   <section class="py-16 lg:py-20 bg-gray-50/70 border-y border-gray-100" id="arsip-dokumentasi">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
     <!-- Section Header -->
     <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
      <div>
       <div class="accent-pill">
       </div>
       <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
        Arsip &amp; Dokumentasi Desa
       </h2>
       <p class="text-sm sm:text-base text-gray-500 font-medium mt-1">
        Arsip dokumen dan dokumentasi kegiatan terbaru Desa Betro.
       </p>
      </div>
      <a class="inline-flex items-center gap-1.5 text-sm font-bold text-brand-700 hover:text-brand-800 transition group" href="{{ route('pages.arsip.index') }}">
       <span>
        Lihat Semua
       </span>
      </a>
     </div>
     <!-- Grid Kartu Arsip -->
     <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      @forelse($arsipTerbaru as $arsip)
      <a href="{{ route('pages.arsip.show', $arsip->slug) }}" class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-2xs flex flex-col group transition">
       <div class="relative h-48 overflow-hidden bg-gray-100">
        @if($arsip->gambar_sampul)
        <img alt="{{ $arsip->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" src="{{ asset('storage/' . $arsip->gambar_sampul) }}"/>
        @else
        <div class="w-full h-full flex items-center justify-center">
         <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        @endif
        <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-brand-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
         {{ strtoupper($arsip->labelKategori()) }}
        </span>
       </div>
       <div class="p-6 flex flex-col flex-grow justify-between">
        <div>
         <div class="flex items-center gap-3 mb-3">
          <span class="text-xs text-gray-400 font-medium flex items-center gap-1">
           <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
           {{ $arsip->tanggal->translatedFormat('d F Y') }}
          </span>
         </div>
         <h3 class="text-base font-bold text-gray-900 mb-2 leading-snug group-hover:text-brand-700 transition line-clamp-2">
          {{ $arsip->judul }}
         </h3>
         <p class="text-xs sm:text-sm text-gray-500 leading-relaxed mb-4 line-clamp-2">
          {{ $arsip->ringkasan }}
         </p>
        </div>
       </div>
      </a>
      @empty
      <div class="col-span-3 text-center py-12">
       <p class="text-sm text-gray-500">Belum ada arsip atau dokumentasi yang dipublikasikan.</p>
      </div>
      @endforelse
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
