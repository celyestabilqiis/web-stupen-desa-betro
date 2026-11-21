@extends('layouts.app')

@section('title', 'Potensi Desa Betro - Website Resmi Desa Betro')
@section('description', 'Jelajahi UMKM dan informasi izin usaha Desa Betro.')
@section('page-key', 'potensi')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-12 site-main">
    <nav aria-label="Breadcrumb" class="page-breadcrumb"><a href="{{ route('pages.home') }}">Beranda</a><span>/</span><span aria-current="page">Potensi Desa</span></nav>
    <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-brand-950 via-brand-900 to-brand-700 px-6 py-10 text-white sm:px-10 sm:py-14">
        <div class="absolute -right-12 -top-16 h-64 w-64 rounded-full border border-white/10"></div><div class="absolute -right-2 -top-6 h-44 w-44 rounded-full border border-white/10"></div>
        <div class="relative max-w-2xl"><span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold tracking-wide text-white/90"><span class="h-2 w-2 rounded-full bg-emerald-300"></span>POTENSI DESA BETRO</span><h1 class="mt-5 text-4xl font-extrabold leading-tight sm:text-5xl">Potensi Lokal,<br/>Majukan Desa</h1><p class="mt-4 max-w-xl text-sm leading-relaxed text-white/75 sm:text-base">Kenali produk dan usaha warga serta informasi Izin Usaha di Desa Betro.</p><a class="mt-7 inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-bold text-brand-800 shadow-sm transition hover:bg-brand-50" href="#daftar-umkm">Jelajahi UMKM</a></div>
    </section>
    <section class="section-separator" id="daftar-umkm">
        <div class="mb-8"><span class="text-xs font-bold uppercase tracking-[.18em] text-brand-700">Produk dan jasa warga</span><h2 class="mt-2 text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">Jelajahi UMKM Desa Betro</h2><p class="mt-2 max-w-2xl text-sm leading-relaxed text-gray-500">Pilih usaha untuk melihat informasi dan produk yang tersedia.</p></div>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($umkmList as $umkm)
                <a href="{{ route('pages.umkm.show', $umkm->slug) }}" class="group overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-xl">
                    <span class="relative block h-56 overflow-hidden bg-gray-100"><img alt="Foto {{ $umkm->nama_usaha }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" src="{{ $umkm->foto ? (str_starts_with($umkm->foto, 'http') ? $umkm->foto : asset('storage/'.$umkm->foto)) : asset('assets/images/logo-betro.png') }}" loading="lazy"/><span class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1.5 text-xs font-bold text-brand-800">{{ $umkm->kategori }}</span></span>
                    <span class="block p-5">@if ($umkm->is_demo)<span class="mb-2 inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-bold text-amber-800">DATA DEMONSTRASI · BUKAN INFORMASI RESMI</span>@endif<span class="block text-lg font-extrabold text-gray-900">{{ $umkm->nama_usaha }}</span><span class="mt-2 block text-sm leading-relaxed text-gray-500">{{ $umkm->deskripsi_singkat }}</span><span class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4 text-xs font-bold text-brand-700"><span>Lihat Profil UMKM</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @endforeach
        </div>
    </section>
</main>
@endsection
