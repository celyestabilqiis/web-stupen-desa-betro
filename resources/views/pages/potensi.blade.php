@extends('layouts.app')

@section('title', 'Potensi Desa Betro - Website Resmi Desa Betro')
@section('description', 'Jelajahi UMKM dan informasi izin usaha Desa Betro.')
@section('page-key', 'potensi')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-12 site-main">
   <nav aria-label="Breadcrumb" class="page-breadcrumb">
    <a href="{{ route('pages.home') }}">Beranda</a>
    <span>/</span>
    <span aria-current="page">Potensi Desa</span>
   </nav>

   <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-brand-950 via-brand-900 to-brand-700 px-6 py-10 text-white sm:px-10 sm:py-14">
    <div class="absolute -right-12 -top-16 h-64 w-64 rounded-full border border-white/10"></div>
    <div class="absolute -right-2 -top-6 h-44 w-44 rounded-full border border-white/10"></div>
    <div class="relative max-w-2xl">
     <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold tracking-wide text-white/90">
      <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
      POTENSI DESA BETRO
     </span>
     <h1 class="mt-5 text-4xl font-extrabold leading-tight sm:text-5xl">Potensi Lokal,<br/>Majukan Desa</h1>
     <p class="mt-4 max-w-xl text-sm leading-relaxed text-white/75 sm:text-base">Kenali produk dan usaha warga serta informasi Izin Usaha di Desa Betro.</p>
     <a class="mt-7 inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-bold text-brand-800 shadow-sm transition hover:bg-brand-50" href="#daftar-umkm">
      Jelajahi UMKM
      
     </a>
    </div>
   </section>

   <section class="section-separator" id="daftar-umkm">
    <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
     <div>
      <span class="text-xs font-bold uppercase tracking-[.18em] text-brand-700">Produk dan jasa warga</span>
      <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">Jelajahi UMKM Desa Betro</h2>
      <p class="mt-2 max-w-2xl text-sm leading-relaxed text-gray-500">Klik salah satu kartu untuk melihat deskripsi, foto, dan rating dari warga sekitar.</p>
     </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
     <button type="button" data-umkm-card data-title="Keripik Singkong Betro" data-category="Makanan ringan" data-image="https://images.unsplash.com/photo-1573080496219-bb080dd4f877?auto=format&amp;fit=crop&amp;w=1000&amp;q=85" data-description="Keripik singkong renyah yang dibuat dalam beberapa pilihan rasa. Cocok sebagai camilan keluarga maupun buah tangan dari Desa Betro." data-rating="4.8" data-reviews="32" class="group overflow-hidden rounded-2xl border border-gray-100 bg-white text-left shadow-sm transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-xl focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-200">
      <span class="relative block h-56 overflow-hidden bg-gray-100">
       <img alt="Keripik singkong sebagai contoh produk UMKM" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1573080496219-bb080dd4f877?auto=format&amp;fit=crop&amp;w=1000&amp;q=85" loading="lazy"/>
       <span class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1.5 text-xs font-bold text-brand-800">Makanan ringan</span>
       <span class="absolute bottom-4 right-4 inline-flex items-center gap-1 rounded-full bg-gray-950/75 px-3 py-1.5 text-xs font-bold text-white"><span class="text-amber-300">★</span> 4.8</span>
      </span>
      <span class="block p-5">
       <span class="block text-lg font-extrabold text-gray-900">Keripik Singkong Betro</span>
       <span class="mt-2 block text-sm leading-relaxed text-gray-500">Keripik renyah dengan pilihan rasa untuk camilan keluarga.</span>
       <span class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4 text-xs font-bold text-brand-700"><span>Lihat profil UMKM</span><span aria-hidden="true" class="transition group-hover:translate-x-1"></span></span>
      </span>
     </button>

     <button type="button" data-umkm-card data-title="Dapur Kue Betro" data-category="Kue rumahan" data-image="https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&amp;fit=crop&amp;w=1000&amp;q=85" data-description="Dapur rumahan yang menyediakan aneka kue untuk teman minum teh dan acara keluarga. Produk dibuat segar dengan pilihan yang dapat disesuaikan." data-rating="4.9" data-reviews="27" class="group overflow-hidden rounded-2xl border border-gray-100 bg-white text-left shadow-sm transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-xl focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-200">
      <span class="relative block h-56 overflow-hidden bg-gray-100">
       <img alt="Aneka kue sebagai contoh produk UMKM" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&amp;fit=crop&amp;w=1000&amp;q=85" loading="lazy"/>
       <span class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1.5 text-xs font-bold text-brand-800">Kue rumahan</span>
       <span class="absolute bottom-4 right-4 inline-flex items-center gap-1 rounded-full bg-gray-950/75 px-3 py-1.5 text-xs font-bold text-white"><span class="text-amber-300">★</span> 4.9</span>
      </span>
      <span class="block p-5">
       <span class="block text-lg font-extrabold text-gray-900">Dapur Kue Betro</span>
       <span class="mt-2 block text-sm leading-relaxed text-gray-500">Aneka kue rumahan yang dibuat segar untuk keluarga dan acara.</span>
       <span class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4 text-xs font-bold text-brand-700"><span>Lihat profil UMKM</span><span aria-hidden="true" class="transition group-hover:translate-x-1"></span></span>
      </span>
     </button>

     <button type="button" data-umkm-card data-title="Sambal &amp; Bumbu Dapur" data-category="Olahan pangan" data-image="https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&amp;fit=crop&amp;w=1000&amp;q=85" data-description="Aneka sambal dan bumbu siap pakai untuk membantu memasak hidangan rumahan. Dibuat dalam skala usaha warga dengan racikan bumbu pilihan." data-rating="4.7" data-reviews="19" class="group overflow-hidden rounded-2xl border border-gray-100 bg-white text-left shadow-sm transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-xl focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-200">
      <span class="relative block h-56 overflow-hidden bg-gray-100">
       <img alt="Olahan pangan sebagai contoh produk UMKM" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&amp;fit=crop&amp;w=1000&amp;q=85" loading="lazy"/>
       <span class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1.5 text-xs font-bold text-brand-800">Olahan pangan</span>
       <span class="absolute bottom-4 right-4 inline-flex items-center gap-1 rounded-full bg-gray-950/75 px-3 py-1.5 text-xs font-bold text-white"><span class="text-amber-300">★</span> 4.7</span>
      </span>
      <span class="block p-5">
       <span class="block text-lg font-extrabold text-gray-900">Sambal &amp; Bumbu Dapur</span>
       <span class="mt-2 block text-sm leading-relaxed text-gray-500">Sambal dan bumbu siap pakai untuk melengkapi masakan di rumah.</span>
       <span class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4 text-xs font-bold text-brand-700"><span>Lihat profil UMKM</span><span aria-hidden="true" class="transition group-hover:translate-x-1"></span></span>
      </span>
     </button>
    </div>
   </section>

   <dialog id="umkmDetailDialog" class="w-[min(92vw,720px)] max-w-none overflow-hidden rounded-3xl border-0 p-0 shadow-2xl backdrop:bg-gray-950/60" aria-labelledby="umkmDetailTitle">
    <div class="relative bg-white">
     <button type="button" data-close-umkm aria-label="Tutup detail UMKM" class="absolute right-4 top-4 z-10 grid h-10 w-10 place-items-center rounded-full bg-white/95 text-xl font-bold text-gray-700 shadow transition hover:bg-white">×</button>
     <img id="umkmDetailImage" class="h-56 w-full bg-gray-100 object-cover sm:h-72" src="" alt=""/>
     <div class="p-6 sm:p-8">
      <span id="umkmDetailCategory" class="inline-flex rounded-full bg-brand-50 px-3 py-1.5 text-xs font-bold text-brand-800"></span>
      <h2 id="umkmDetailTitle" class="mt-3 text-2xl font-extrabold text-gray-900 sm:text-3xl"></h2>
      <p id="umkmDetailDescription" class="mt-3 text-sm leading-relaxed text-gray-600"></p>
      <div class="mt-6 flex flex-wrap items-center gap-3 rounded-2xl bg-amber-50 p-4">
       <span aria-hidden="true" class="text-2xl tracking-wider text-amber-500">★★★★★</span>
       <span class="font-extrabold text-gray-900"><span id="umkmDetailRating"></span>/5</span>
       <span class="text-sm text-gray-600">dari <span id="umkmDetailReviews"></span> penilaian warga (contoh)</span>
      </div>
      <button type="button" data-close-umkm class="mt-6 rounded-full bg-brand-700 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-brand-800">Tutup detail</button>
     </div>
    </div>
   </dialog>
  </main>
@endsection

@section('after-content')

@endsection
