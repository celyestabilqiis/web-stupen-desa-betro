@extends('layouts.app')

@section('title', $arsip->judul . ' - Desa Betro')
@section('description', $arsip->ringkasan ?: \Illuminate\Support\Str::limit(strip_tags($arsip->isi), 160))

@push('head')
    <meta property="og:title" content="{{ $arsip->judul }} - Desa Betro">
    <meta property="og:description" content="{{ $arsip->ringkasan ?: \Illuminate\Support\Str::limit(strip_tags($arsip->isi), 160) }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ route('pages.arsip.show', $arsip->slug) }}">
    @if ($arsip->gambar_sampul)
        <meta property="og:image" content="{{ asset('storage/' . $arsip->gambar_sampul) }}">
    @endif
@endpush

@section('page-key', 'arsip-detail')

@section('content')
<main class="min-h-screen bg-gray-50/80 py-10 md:py-14">
    <div class="max-w-[1180px] mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Kolom Kiri: Kartu Artikel Utama (75% / 9 kolom di desktop) -->
            <article class="lg:col-span-8 bg-white rounded-2xl p-6 sm:p-8 md:p-10 border border-gray-100 shadow-xs">
                <!-- 1. Breadcrumb Kecil -->
                <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-gray-500 mb-6 font-medium">
                    <a href="{{ route('pages.home') }}" class="hover:text-brand-700 transition flex items-center gap-1" title="Beranda">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Beranda</span>
                    </a>
                    <span class="text-gray-300">/</span>
                    <a href="{{ route('pages.arsip.index') }}" class="hover:text-brand-700 transition">
                        Arsip &amp; Dokumentasi Desa
                    </a>
                    <span class="text-gray-300">/</span>
                    <span class="text-brand-700 font-bold truncate max-w-[200px] sm:max-w-xs">{{ $arsip->labelKategori() }}</span>
                </nav>

                <!-- 2. Judul Artikel Besar & Tebal -->
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight mb-4">
                    {{ $arsip->judul }}
                </h1>

                <!-- 3. Baris Info Kecil Abu-abu -->
                <div class="flex flex-wrap items-center justify-between gap-3 text-xs text-gray-500 pb-6 border-b border-gray-100 mb-6 font-medium">
                    <!-- Kiri: Tanggal & Penulis -->
                    <div class="flex flex-wrap items-center gap-4">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $arsip->tanggal ? $arsip->tanggal->translatedFormat('d F Y') : '-' }}</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Ditulis oleh <strong class="text-gray-700 font-semibold">{{ $arsip->penulis->name ?? 'Administrator' }}</strong></span>
                        </span>
                    </div>

                    <!-- Kanan: Dilihat N kali -->
                    <div class="flex items-center gap-1.5 ml-auto sm:ml-0 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span>Dilihat {{ $arsip->jumlah_dilihat }} kali</span>
                    </div>
                </div>

                <!-- 4. Gambar Sampul Selebar Kartu (16:9) -->
                @if ($arsip->gambar_sampul)
                    <div class="w-full aspect-video rounded-2xl overflow-hidden bg-gray-100 mb-8 shadow-xs">
                        <img src="{{ asset('storage/' . $arsip->gambar_sampul) }}" alt="{{ $arsip->judul }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <!-- 5 & 6. Isi Artikel HTML dari Editor dengan Tipografi Rapi -->
                <div class="tiptap-content text-gray-800 leading-relaxed text-base">
                    {!! $arsip->isi !!}
                </div>

                <!-- Footer Artikel: Bagikan -->
                <div class="mt-12 pt-6 border-t border-gray-100 flex items-center justify-between">
                    <a href="{{ route('pages.arsip.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand-700 hover:text-brand-900 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Kembali ke Daftar Arsip</span>
                    </a>
                </div>
            </article>

            <!-- Kolom Kanan: Sidebar Arsip Terbaru (25% / 4 kolom di desktop) -->
            <aside class="lg:col-span-4 bg-white rounded-2xl p-6 border border-gray-100 shadow-xs space-y-6 sticky top-24">
                <div class="border-b border-gray-100 pb-3">
                    <h3 class="text-base font-bold text-gray-900 tracking-tight flex items-center gap-2">
                        <span class="w-2 h-4 bg-brand-700 rounded-full inline-block"></span>
                        <span>Arsip Terbaru</span>
                    </h3>
                </div>

                <div class="space-y-4">
                    @forelse ($arsipTerbaru as $terbaru)
                        @php
                            $isPdfTerbaru = $terbaru->tipe === 'pdf';
                            $terbaruUrl = $isPdfTerbaru && $terbaru->file_pdf 
                                ? asset('storage/' . $terbaru->file_pdf) 
                                : route('pages.arsip.show', $terbaru->slug);
                        @endphp
                        <a href="{{ $terbaruUrl }}" @if($isPdfTerbaru) target="_blank" rel="noopener noreferrer" @endif class="flex items-start gap-3 group transition">
                            <!-- Thumbnail Persegi 50x50 px -->
                            <div class="w-[50px] h-[50px] rounded-xl overflow-hidden bg-gray-100 flex-shrink-0 border border-gray-100">
                                @if ($terbaru->gambar_sampul)
                                    <img src="{{ asset('storage/' . $terbaru->gambar_sampul) }}" alt="{{ $terbaru->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @elseif ($isPdfTerbaru)
                                    <div class="w-full h-full flex items-center justify-center bg-rose-50 text-rose-600 font-extrabold text-[10px]">
                                        PDF
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Info Judul, Tanggal, Dilihat -->
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs font-bold text-gray-900 group-hover:text-brand-700 transition leading-snug line-clamp-2 mb-1">
                                    {{ $terbaru->judul }}
                                </h4>
                                <div class="flex items-center gap-2 text-[10px] text-gray-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ $terbaru->tanggal ? $terbaru->tanggal->translatedFormat('d M Y') : '-' }}</span>
                                    </span>
                                    <span>&bull;</span>
                                    <span>{{ $terbaru->jumlah_dilihat }}x dilihat</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-xs text-gray-400 py-3 text-center">Belum ada arsip lainnya.</p>
                    @endforelse
                </div>
            </aside>
        </div>
    </div>
</main>
@endsection
