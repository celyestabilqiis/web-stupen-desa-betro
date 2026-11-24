@extends('admin.layouts.app')
@section('title', 'Dashboard Wilayah')
@section('page-title', 'Dashboard Informasi Wilayah')
@section('page-desc', 'Ringkasan kelengkapan informasi geografis dan administratif Desa Betro')
@section('content')
<div class="space-y-6">
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach([['Luas Wilayah', $profile?->luas_wilayah ? number_format((float) $profile->luas_wilayah, 2, ',', '.').' km²' : 'Belum diisi'], ['Jumlah Dusun', $jumlahDusun], ['Jumlah RW', $jumlahRw], ['Jumlah RT', $jumlahRt], ['Kategori Penggunaan Lahan', $jumlahLahan], ['Kelengkapan Informasi', $missing->isEmpty() ? 'Lengkap' : $missing->count().' hal perlu dilengkapi']] as [$label, $value])
            <article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm"><p class="text-sm font-medium text-gray-500">{{ $label }}</p><p class="mt-2 text-2xl font-extrabold text-gray-900">{{ $value }}</p></article>
        @endforeach
    </div>
    <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm"><h2 class="font-bold text-gray-900">Informasi yang perlu dilengkapi</h2>@if($missing->isEmpty())<p class="mt-3 text-sm text-green-700">Seluruh bagian utama sudah terisi.</p>@else<ul class="mt-3 grid gap-2 sm:grid-cols-2">@foreach($missing as $entry)<li class="rounded-xl bg-amber-50 px-4 py-3 text-sm text-amber-900">{{ $entry }}</li>@endforeach</ul>@endif</section>
    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">@foreach([['Gambaran Umum Desa', 'admin.wilayah.profile'], ['Batas Wilayah', 'admin.wilayah.boundaries'], ['Pembagian Dusun', 'admin.wilayah.items.index', 'dusun'], ['Kondisi Geografis', 'admin.wilayah.items.index', 'geografi'], ['Penggunaan Lahan', 'admin.wilayah.items.index', 'lahan'], ['Peta Wilayah', 'admin.wilayah.map']] as $link)<a class="rounded-xl border border-gray-100 bg-white p-4 font-semibold text-brand-800 shadow-sm hover:border-brand-200" href="{{ isset($link[2]) ? route($link[1], $link[2]) : route($link[1]) }}">{{ $link[0] }} →</a>@endforeach</div>
</div>
@endsection
