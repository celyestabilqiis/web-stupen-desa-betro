@extends('layouts.app')
@section('title', $umkm->nama_usaha.' - Katalog UMKM Desa Betro')
@section('page-key', 'potensi')
@section('content')
<main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 site-main">
    <nav aria-label="Breadcrumb" class="page-breadcrumb"><a href="{{ route('pages.home') }}">Beranda</a><span>/</span><a href="{{ route('pages.potensi') }}">Potensi Desa</a><span>/</span><span aria-current="page">{{ $umkm->nama_usaha }}</span></nav>
    <article class="mt-6 overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
        <img class="h-64 w-full bg-gray-100 object-cover sm:h-96" src="{{ $umkm->foto ? (str_starts_with($umkm->foto, 'http') ? $umkm->foto : asset('storage/'.$umkm->foto)) : asset('assets/images/logo-betro.png') }}" alt="Foto {{ $umkm->nama_usaha }}"/>
        <div class="p-6 sm:p-10">@if ($umkm->is_demo)<p class="mb-4 inline-flex rounded-full bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-800">DATA DEMONSTRASI — BUKAN INFORMASI RESMI UMKM DESA BETRO</p>@endif
            <span class="inline-flex rounded-full bg-brand-50 px-3 py-1.5 text-xs font-bold text-brand-800">{{ $umkm->kategori }}</span><h1 class="mt-3 text-3xl font-extrabold text-gray-900">{{ $umkm->nama_usaha }}</h1>
            @if ($umkm->deskripsi_singkat)<p class="mt-4 text-gray-600">{{ $umkm->deskripsi_singkat }}</p>@endif
            <dl class="mt-8 grid gap-5 sm:grid-cols-2">@foreach (['Nama pemilik' => $umkm->nama_pemilik, 'Alamat' => $umkm->alamat, 'Tahun berdiri' => $umkm->tahun_berdiri, 'Jam operasional' => $umkm->jam_operasional] as $label => $value)@if ($value)<div><dt class="text-xs font-bold uppercase tracking-wide text-gray-400">{{ $label }}</dt><dd class="mt-1 text-sm text-gray-700">{{ $value }}</dd></div>@endif @endforeach</dl>
            @if ($umkm->deskripsi_lengkap)<section class="mt-8"><h2 class="text-xl font-bold text-gray-900">Deskripsi dan Sejarah Usaha</h2><p class="mt-3 whitespace-pre-line leading-relaxed text-gray-600">{{ $umkm->deskripsi_lengkap }}</p></section>@endif
            @if ($umkm->products->isNotEmpty())<section class="mt-10"><h2 class="text-xl font-bold text-gray-900">Produk</h2><div class="mt-4 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">@foreach ($umkm->products as $product)<div class="overflow-hidden rounded-2xl border border-gray-100"><img class="h-40 w-full bg-gray-100 object-cover" src="{{ $product->foto ? (str_starts_with($product->foto, 'http') ? $product->foto : asset('storage/'.$product->foto)) : asset('assets/images/logo-betro.png') }}" alt="{{ $product->nama_produk }}"/><div class="p-4">@if ($umkm->is_demo)<span class="text-[10px] font-bold text-amber-700">CONTOH PRODUK</span>@endif<h3 class="mt-1 font-bold text-gray-900">{{ $product->nama_produk }}</h3>@if ($product->deskripsi)<p class="mt-1 text-sm text-gray-500">{{ $product->deskripsi }}</p>@endif<p class="mt-3 font-extrabold text-brand-800">{{ $product->harga !== null ? 'Rp'.number_format($product->harga, 0, ',', '.') : 'Harga belum tersedia' }} {{ $product->satuan }}</p><p class="mt-1 text-xs {{ $product->tersedia ? 'text-emerald-700' : 'text-gray-500' }}">{{ $product->tersedia ? 'Tersedia' : 'Tidak tersedia' }}</p></div></div>@endforeach</div></section>@endif
            @if ($umkm->whatsapp)<section class="mt-8"><h2 class="text-xl font-bold text-gray-900">Informasi Kontak</h2><p class="mt-2 text-gray-600">WhatsApp: {{ $umkm->whatsapp }}</p></section>@endif
            @if ($umkm->latitude && $umkm->longitude)<section class="mt-8"><h2 class="text-xl font-bold text-gray-900">Lokasi Usaha</h2><a class="mt-2 inline-block text-brand-700 underline" href="https://maps.google.com/?q={{ $umkm->latitude }},{{ $umkm->longitude }}" target="_blank" rel="noopener">Lihat lokasi di peta</a></section>@endif
        </div>
    </article>
</main>
@endsection
