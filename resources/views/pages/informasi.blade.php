@extends('layouts.app')

@section('title', 'Informasi Desa Betro')
@section('description', 'Arsip dan dokumentasi Desa Betro.')
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
            <p>Arsip dan dokumentasi Pemerintah Desa Betro.</p>
        </div>
    </section>

    <section class="information-latest section-separator mt-10" aria-labelledby="latest-archives-title">
        <div class="mb-7 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <span class="information-section-kicker">Publikasi terbaru</span>
                <h2 id="latest-archives-title" class="mt-2 text-2xl font-extrabold">Arsip &amp; Dokumentasi Terbaru</h2>
                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-gray-600">Temukan informasi, dokumen, dan dokumentasi terbaru mengenai kegiatan Pemerintah Desa Betro.</p>
            </div>
            <a href="{{ route('pages.arsip.index') }}" class="inline-flex shrink-0 items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-bold text-white transition hover:bg-brand-800">Lihat Semua Arsip &amp; Dokumentasi</a>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
            @forelse($arsipTerbaru as $arsip)
                <article class="information-archive-card group flex min-w-0 flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                    <a href="{{ route('pages.arsip.show', $arsip->slug) }}" class="block h-48 overflow-hidden bg-rose-50" aria-label="Lihat {{ $arsip->judul }}">
                        @if($arsip->gambar_sampul)
                            <img src="{{ asset('storage/'.$arsip->gambar_sampul) }}" alt="{{ $arsip->judul }}" loading="lazy" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="flex h-full w-full flex-col items-center justify-center gap-2 text-brand-700" aria-label="Dokumen tanpa gambar">
                                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 1.414 0l5 5A2 2 0 0 1 19 9v10a2 2 0 0 1-2 2Z"/></svg>
                                <span class="text-xs font-semibold">Dokumen Desa</span>
                            </div>
                        @endif
                    </a>
                    <div class="flex flex-1 flex-col p-5">
                        <div class="mb-3 flex items-center justify-between gap-3">
                            <span class="rounded-full bg-rose-50 px-3 py-1 text-[11px] font-bold text-brand-800">{{ $arsip->labelKategori() }}</span>
                            <time class="shrink-0 text-xs text-gray-500" datetime="{{ $arsip->tanggal->toDateString() }}">{{ $arsip->tanggal->translatedFormat('d F Y') }}</time>
                        </div>
                        <h3 class="text-lg font-bold leading-snug text-gray-900">{{ $arsip->judul }}</h3>
                        <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-gray-600">{{ $arsip->ringkasan }}</p>
                        <a href="{{ route('pages.arsip.show', $arsip->slug) }}" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-brand-700 hover:text-brand-900">Baca Selengkapnya</a>
                    </div>
                </article>
            @empty
                <p class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-white p-8 text-center text-sm text-gray-500">Belum ada arsip atau dokumentasi yang dipublikasikan.</p>
            @endforelse
        </div>
    </section>
</main>
@endsection
