@extends('layouts.app')

@section('title', 'Informasi Desa Betro')
@section('description', 'Informasi wilayah, arsip, dan dokumentasi Desa Betro.')
@section('page-key', 'informasi')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-12 site-main information-page">
    <nav aria-label="Breadcrumb" class="page-breadcrumb"><a href="{{ route('pages.home') }}">Beranda</a><span>/</span><span aria-current="page">Informasi Desa</span></nav>
    <section class="information-hero">
        <span class="information-hero-ornament ornament-left" aria-hidden="true"></span>
        <span class="information-hero-ornament ornament-right" aria-hidden="true"></span>
        <img alt="Ilustrasi wilayah Desa Betro" src="{{ asset('assets/images/informasi-desa.jpg') }}">
        <div class="information-hero-overlay"></div>
        <div class="information-hero-content">
            <span class="information-hero-kicker"><span></span> Informasi Desa Betro</span>
            <h1>Kenali Desa Betro</h1>
            <p>Informasi wilayah, arsip, dan dokumentasi Pemerintah Desa Betro.</p>
        </div>
    </section>

    <section class="section-separator mt-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('pages.wilayah') }}" class="card-hover rounded-2xl border border-gray-100 bg-white p-6 shadow-sm group">
                <span class="text-3xl" aria-hidden="true">⌖</span>
                <h2 class="mt-3 text-xl font-extrabold text-gray-900 group-hover:text-brand-700">Informasi Wilayah Desa Betro</h2>
                <p class="mt-2 text-sm leading-relaxed text-gray-600">Gambaran umum, batas wilayah, dusun, kondisi geografis, penggunaan lahan, dan peta.</p>
                <span class="mt-5 inline-block text-sm font-bold text-brand-700">Buka Informasi Wilayah →</span>
            </a>
            <a href="{{ route('pages.arsip.index') }}" class="card-hover rounded-2xl border border-gray-100 bg-white p-6 shadow-sm group">
                <span class="text-3xl" aria-hidden="true">▤</span>
                <h2 class="mt-3 text-xl font-extrabold text-gray-900 group-hover:text-brand-700">Arsip &amp; Dokumentasi Desa</h2>
                <p class="mt-2 text-sm leading-relaxed text-gray-600">Telusuri dokumen publik dan dokumentasi kegiatan Desa Betro.</p>
                <span class="mt-5 inline-block text-sm font-bold text-brand-700">Buka Arsip →</span>
            </a>
        </div>
    </section>
</main>
@endsection
