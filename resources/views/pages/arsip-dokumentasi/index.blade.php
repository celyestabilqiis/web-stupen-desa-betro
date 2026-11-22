@extends('layouts.app')

@section('title', 'Arsip & Dokumentasi Desa - Website Resmi Desa Betro')
@section('description', 'Menyajikan arsip dokumen resmi dan galeri dokumentasi kegiatan Pemerintah Desa Betro secara terbuka dan akuntabel.')
@section('page-key', 'arsip-dokumentasi')

@section('content')
<main class="min-h-screen bg-gray-50/60 py-10 md:py-14">
    <div class="max-w-[1000px] mx-auto px-4 sm:px-6">
        <!-- Header Judul & Deskripsi -->
        <div class="text-center mb-8">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-brand-700 tracking-tight">
                Arsip &amp; Dokumentasi Desa
            </h1>
            <p class="text-sm sm:text-base text-gray-700 font-medium mt-2 max-w-2xl mx-auto">
                Menyajikan arsip dan dokumentasi resmi kegiatan Desa Betro secara terbuka dan transparan.
            </p>
        </div>

        <!-- Tombol Saring Berbentuk Pil (Pills) -->
        <div class="flex items-center justify-center gap-2.5 mb-10 flex-wrap">
            <a href="{{ route('pages.arsip.index', array_filter(['cari' => request('cari')], fn ($value) => $value !== null)) }}"
               class="px-5 py-2 rounded-full text-xs sm:text-sm font-bold transition shadow-xs {{ !request('kategori') ? 'bg-brand-700 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                Semua
            </a>
            <a href="{{ route('pages.arsip.index', array_filter(['kategori' => 'arsip_desa', 'cari' => request('cari')], fn ($value) => $value !== null)) }}"
               class="px-5 py-2 rounded-full text-xs sm:text-sm font-bold transition shadow-xs {{ request('kategori') === 'arsip_desa' ? 'bg-brand-700 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                Arsip Desa
            </a>
            <a href="{{ route('pages.arsip.index', array_filter(['kategori' => 'dokumentasi_desa', 'cari' => request('cari')], fn ($value) => $value !== null)) }}"
               class="px-5 py-2 rounded-full text-xs sm:text-sm font-bold transition shadow-xs {{ request('kategori') === 'dokumentasi_desa' ? 'bg-brand-700 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                Dokumentasi Desa
            </a>
        </div>

        <form method="GET" action="{{ route('pages.arsip.index') }}" class="mb-8">
            @if (request('kategori'))<input type="hidden" name="kategori" value="{{ request('kategori') }}">@endif
            <label for="arsip-search" class="sr-only">Cari arsip atau dokumentasi desa</label>
            <div class="mx-auto flex max-w-2xl items-center gap-2 rounded-2xl border border-gray-200 bg-white px-4 py-2 shadow-xs focus-within:border-brand-400 focus-within:ring-2 focus-within:ring-brand-100">
                <svg class="h-5 w-5 shrink-0 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke-width="2"/><path d="m20 20-4-4" stroke-width="2" stroke-linecap="round"/></svg>
                <input id="arsip-search" name="cari" value="{{ request('cari') }}" placeholder="Cari arsip atau dokumentasi desa..." class="min-w-0 flex-1 border-0 text-sm outline-none focus:ring-0">
                @if (request()->filled('cari'))<a href="{{ route('pages.arsip.index', request('kategori') ? ['kategori' => request('kategori')] : []) }}" class="shrink-0 text-xs font-bold text-brand-700 hover:text-brand-900">Hapus</a>@endif
                <button type="submit" class="shrink-0 rounded-xl bg-brand-700 px-4 py-2 text-xs font-bold text-white transition hover:bg-brand-800">Cari</button>
            </div>
        </form>

        <!-- Grid Kartu Arsip (3 kolom desktop, 2 tablet, 1 mobile, gap 24px) -->
        @if ($arsipList->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($arsipList as $item)
                    @php
                        $isPdf = $item->tipe === 'pdf';
                        $targetUrl = $isPdf && $item->file_pdf 
                            ? asset('storage/' . $item->file_pdf) 
                            : route('pages.arsip.show', $item->slug);
                        $tanggalBadge = $item->tanggal ? $item->tanggal->translatedFormat('d M') : date('d M');
                        $tahunBadge = $item->tanggal ? $item->tanggal->format('Y') : date('Y');
                    @endphp

                    <div class="bg-white rounded-2xl shadow-xs hover:shadow-md border border-gray-100 overflow-hidden flex flex-col justify-between group transition duration-300">
                        <div>
                            <!-- 1. Gambar Sampul Rasio 16:9 (h-40 ~ 160-165px) -->
                            <div class="relative w-full h-[165px] bg-gray-100 overflow-hidden">
                                @if ($item->gambar_sampul)
                                    <img src="{{ asset('storage/' . $item->gambar_sampul) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @elseif ($isPdf)
                                    <!-- Placeholder PDF yang Rapi -->
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-rose-50 to-brand-50 text-brand-700">
                                        <svg class="w-12 h-12 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-xs font-extrabold uppercase mt-1 tracking-wider">Dokumen PDF</span>
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Label Kategori Pojok Kiri Atas -->
                                <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-brand-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
                                    {{ $item->labelKategori() }}
                                </span>
                            </div>

                            <!-- Konten Kartu -->
                            <div class="p-4 sm:p-5">
                                <!-- 2. Judul Tebal Maksimal 2 Baris -->
                                <h2 class="font-bold text-base text-gray-900 group-hover:text-brand-700 transition leading-snug line-clamp-2 mb-2">
                                    <a href="{{ $targetUrl }}" @if($isPdf) target="_blank" rel="noopener noreferrer" @endif>
                                        {{ $item->judul }}
                                    </a>
                                </h2>

                                <!-- 3. Ringkasan Teks Maksimal 3 Baris -->
                                <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                                    {{ $item->ringkasan ?: \Illuminate\Support\Str::limit(strip_tags($item->isi), 120) }}
                                </p>
                            </div>
                        </div>

                        <!-- 4. Baris Bawah Kartu dengan Badge Tanggal di Pojok Kanan Bawah -->
                        <div class="relative flex items-center justify-between pl-4 sm:pl-5 pr-0 py-3 border-t border-gray-50 bg-white">
                            <!-- Kiri: Penulis & Dilihat -->
                            <div class="text-[11px] text-gray-400 space-y-0.5 leading-tight py-1">
                                <div class="flex items-center gap-1.5 font-medium text-gray-600">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>{{ $item->penulis->name ?? 'Administrator' }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span>Dilihat {{ $item->jumlah_dilihat }} kali</span>
                                </div>
                            </div>

                            <!-- Kanan Bawah: Badge Tanggal Berlatar Warna Utama Menempel di Sudut -->
                            <div class="bg-brand-700 text-white px-3.5 py-2 text-center rounded-tl-xl shadow-xs self-end">
                                <div class="text-xs font-bold leading-none">{{ $tanggalBadge }}</div>
                                <div class="text-[10px] font-semibold text-white/80 leading-none mt-1">{{ $tahunBadge }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination di Tengah Bawah Grid -->
            @include('components.public-pagination', ['paginator' => $arsipList])
        @else
            <!-- Keadaan Kosong (Empty State) -->
            <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center max-w-md mx-auto shadow-xs my-8">
                <div class="w-16 h-16 rounded-full bg-brand-50 text-brand-700 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">{{ request()->filled('cari') ? 'Arsip atau dokumentasi tidak ditemukan' : 'Belum Ada Arsip' }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed mb-6">
                    @if (request()->filled('cari'))
                        Coba kata kunci lain atau hapus pencarian untuk melihat data lainnya.
                    @elseif (request('kategori'))
                        Belum ada dokumen atau arsip untuk kategori ini.
                    @else
                        Arsip dan dokumentasi desa belum diterbitkan. Silakan periksa kembali nanti.
                    @endif
                </p>
                @if (request('kategori'))
                    <a href="{{ route('pages.arsip.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-brand-700 text-white text-xs font-bold hover:bg-brand-800 transition">
                        Tampilkan Semua Kategori
                    </a>
                @endif
            </div>
        @endif
    </div>
</main>
@endsection
