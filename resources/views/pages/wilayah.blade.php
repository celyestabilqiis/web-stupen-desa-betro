@extends('layouts.app')

@section('title', 'Informasi Wilayah Desa Betro')
@section('description', 'Informasi geografis dan administratif Desa Betro.')
@section('page-key', 'informasi-wilayah')

@section('content')
<main class="bg-gray-50">
    <section class="bg-[#801b2a] text-white">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
            <p class="text-xs font-bold uppercase tracking-[.2em] text-[#e6c77d]">Desa Betro · Informasi Wilayah</p>
            <h1 class="mt-3 text-3xl font-extrabold sm:text-5xl">Informasi Wilayah Desa Betro</h1>
            <p class="mt-4 max-w-3xl text-sm leading-7 text-white/80 sm:text-base">Kenali identitas, pembagian administratif, kondisi geografis, dan penggunaan lahan Desa Betro.</p>
        </div>
    </section>
    <div class="mx-auto max-w-7xl space-y-14 px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <section id="gambaran-umum">
            <div class="mb-6"><p class="text-xs font-bold uppercase tracking-widest text-brand-700">01 · Profil</p><h2 class="mt-1 text-2xl font-extrabold text-gray-900">Gambaran Umum Desa</h2></div>
            <div class="grid gap-6 rounded-3xl border border-gray-100 bg-white p-5 shadow-sm sm:p-8 lg:grid-cols-[1.2fr_.8fr]">
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900">{{ $profile?->nama_desa ?: 'Desa Betro' }}</h3>
                    <p class="mt-2 text-gray-600">{{ collect([$profile?->kecamatan, $profile?->kabupaten, $profile?->provinsi])->filter()->implode(', ') ?: 'Informasi wilayah administratif belum dilengkapi.' }}</p>
                    <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3">
                        @foreach([['Kode Pos', $profile?->kode_pos], ['Kode Wilayah', $profile?->kode_wilayah], ['Luas Wilayah', $profile?->luas_wilayah ? number_format((float) $profile->luas_wilayah, 2, ',', '.').' km²' : null], ['Latitude', $profile?->latitude], ['Longitude', $profile?->longitude]] as [$label, $value])
                            <div class="rounded-xl bg-gray-50 p-3"><p class="text-xs text-gray-500">{{ $label }}</p><p class="mt-1 break-all text-sm font-bold text-gray-900">{{ $value ?: 'Belum tersedia' }}</p></div>
                        @endforeach
                    </div>
                    @if($profile?->deskripsi)<p class="mt-6 whitespace-pre-line leading-7 text-gray-700">{{ $profile->deskripsi }}</p>@endif
                </div>
                @if($profile?->gambar)<img class="h-64 w-full rounded-2xl object-contain bg-gray-50" src="{{ asset('storage/'.$profile->gambar) }}" alt="Gambaran Desa Betro" loading="lazy">@else<div class="flex min-h-56 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-50 to-amber-50 text-6xl" aria-hidden="true">⌖</div>@endif
            </div>
        </section>
        <section id="batas-wilayah">
            <div class="mb-6"><p class="text-xs font-bold uppercase tracking-widest text-brand-700">02 · Administrasi</p><h2 class="mt-1 text-2xl font-extrabold text-gray-900">Batas Wilayah</h2></div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($boundaries as $boundary)<article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm"><span class="text-xs font-bold uppercase tracking-wider text-brand-700">{{ $boundary->arah }}</span><h3 class="mt-2 text-lg font-bold text-gray-900">{{ $boundary->wilayah_berbatasan }}</h3>@if($boundary->deskripsi)<p class="mt-2 text-sm leading-6 text-gray-600">{{ $boundary->deskripsi }}</p>@endif</article>@empty<div class="rounded-2xl border border-dashed border-gray-300 bg-white p-6 text-sm text-gray-500 sm:col-span-2 lg:col-span-4">Informasi batas wilayah belum tersedia.</div>@endforelse
            </div>
        </section>
        <section id="dusun">
            <div class="mb-6"><p class="text-xs font-bold uppercase tracking-widest text-brand-700">03 · Pembagian Administratif</p><h2 class="mt-1 text-2xl font-extrabold text-gray-900">Pembagian Wilayah Administratif</h2></div>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($dusuns as $dusun)<article class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">@if($dusun->foto)<img src="{{ asset('storage/'.$dusun->foto) }}" alt="Dusun {{ $dusun->nama_dusun }}" class="h-48 w-full object-contain bg-gray-50" loading="lazy">@else<div class="flex h-36 items-center justify-center bg-brand-50 text-4xl" aria-hidden="true">⌂</div>@endif<div class="p-5"><h3 class="text-lg font-bold text-gray-900">{{ $dusun->nama_dusun }}</h3><div class="mt-3 flex gap-4 text-sm text-gray-600"><span>RW: {{ $dusun->jumlah_rw ?? '—' }}</span><span>RT: {{ $dusun->jumlah_rt ?? '—' }}</span></div>@if($dusun->luas_wilayah)<p class="mt-1 text-sm text-gray-600">Luas: {{ number_format((float) $dusun->luas_wilayah, 2, ',', '.') }}</p>@endif @if($dusun->deskripsi)<p class="mt-3 text-sm leading-6 text-gray-600">{{ $dusun->deskripsi }}</p>@endif</div></article>@empty<div class="rounded-2xl border border-dashed border-gray-300 bg-white p-6 text-sm text-gray-500 sm:col-span-2 lg:col-span-3">Informasi dusun belum tersedia.</div>@endforelse
            </div>
        </section>
        <section id="geografi">
            <div class="mb-6"><p class="text-xs font-bold uppercase tracking-widest text-brand-700">04 · Lingkungan</p><h2 class="mt-1 text-2xl font-extrabold text-gray-900">Kondisi Geografis</h2></div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($geographies as $entry)<article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">@if($entry->gambar)<img src="{{ asset('storage/'.$entry->gambar) }}" alt="{{ $entry->nama_informasi }}" class="mb-4 h-40 w-full rounded-xl object-contain bg-gray-50" loading="lazy">@endif<h3 class="font-bold text-gray-900">{{ $entry->nama_informasi }}</h3>@if($entry->nilai)<p class="mt-2 text-lg font-extrabold text-brand-800">{{ $entry->nilai }} <span class="text-sm font-medium text-gray-500">{{ $entry->satuan }}</span></p>@endif @if($entry->deskripsi)<p class="mt-2 text-sm leading-6 text-gray-600">{{ $entry->deskripsi }}</p>@endif</article>@empty<div class="rounded-2xl border border-dashed border-gray-300 bg-white p-6 text-sm text-gray-500 sm:col-span-2 lg:col-span-3">Informasi kondisi geografis belum tersedia.</div>@endforelse
            </div>
        </section>
        <section id="penggunaan-lahan">
            <div class="mb-6"><p class="text-xs font-bold uppercase tracking-widest text-brand-700">05 · Tata Guna</p><h2 class="mt-1 text-2xl font-extrabold text-gray-900">Penggunaan Lahan</h2></div>
            <div class="grid gap-5 lg:grid-cols-[1fr_auto]">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">@forelse($landUses as $landUse)<article class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">@if($landUse->gambar)<img src="{{ asset('storage/'.$landUse->gambar) }}" alt="{{ $landUse->nama_kategori }}" class="h-40 w-full object-contain bg-gray-50" loading="lazy">@endif<div class="p-5"><h3 class="font-bold text-gray-900">{{ $landUse->nama_kategori }}</h3>@if($landUse->luas !== null)<p class="mt-2 text-2xl font-extrabold text-brand-800">{{ number_format((float) $landUse->luas, 2, ',', '.') }} <span class="text-sm font-semibold">{{ $landUse->satuan }}</span></p>@endif @if($landUse->deskripsi)<p class="mt-2 text-sm leading-6 text-gray-600">{{ $landUse->deskripsi }}</p>@endif</div></article>@empty<div class="rounded-2xl border border-dashed border-gray-300 bg-white p-6 text-sm text-gray-500 sm:col-span-2 lg:col-span-3">Informasi penggunaan lahan belum tersedia.</div>@endforelse</div>
                @if($chartReady)
                    @php($totalLand = $landUses->sum(fn ($landUse) => (float) $landUse->luas))
                    @php($colors = ['#801b2a', '#d7ad53', '#466c55', '#4984a6', '#bf7652', '#8061a7'])
                    @php($stops = [])
                    @php($cursor = 0)
                    @foreach($landUses as $index => $landUse)@php($next = $cursor + ((float) $landUse->luas / $totalLand * 100))@php($stops[] = $colors[$index % count($colors)].' '.$cursor.'% '.$next.'%')@php($cursor = $next)@endforeach
                    <aside class="h-fit rounded-2xl border border-gray-100 bg-white p-5 shadow-sm"><h3 class="font-bold text-gray-900">Komposisi Lahan</h3><div class="mx-auto mt-5 h-44 w-44 rounded-full" role="img" aria-label="Diagram komposisi penggunaan lahan" style="background: conic-gradient({{ implode(', ', $stops) }})"></div><ul class="mt-5 grid gap-2">@foreach($landUses as $index => $landUse)<li class="flex items-center gap-2 text-xs text-gray-700"><span class="h-2.5 w-2.5 rounded-full" style="background: {{ $colors[$index % count($colors)] }}"></span><span>{{ $landUse->nama_kategori }} · {{ number_format((float) $landUse->luas, 2, ',', '.') }} {{ $landUse->satuan }}</span></li>@endforeach</ul></aside>
                @endif
            </div>
        </section>
        <section id="peta-wilayah">
            <div class="mb-6"><p class="text-xs font-bold uppercase tracking-widest text-brand-700">06 · Peta</p><h2 class="mt-1 text-2xl font-extrabold text-gray-900">Peta Wilayah Desa</h2></div>
            @if($map)
                @if($map->gambar)<img src="{{ asset('storage/'.$map->gambar) }}" alt="{{ $map->nama_peta ?: 'Peta Wilayah Desa Betro' }}" class="max-h-[620px] w-full rounded-3xl border border-gray-100 bg-white object-contain p-3 shadow-sm" loading="lazy">@endif
                @if(($map->latitude ?? $profile?->latitude) !== null && ($map->longitude ?? $profile?->longitude) !== null)
                    <div class="mt-4 overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm"><div id="village-map" class="h-[420px] w-full" role="application" aria-label="Peta interaktif Desa Betro"></div><div class="p-3 text-xs text-gray-500">Peta © <a class="text-brand-700 underline" href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a>. Penanda dan batas mengikuti data yang dimasukkan admin.</div></div>
                @elseif($map->map_url)
                    <a class="mt-4 inline-flex rounded-xl bg-white px-5 py-3 font-bold text-brand-700 shadow-sm" href="{{ $map->map_url }}" target="_blank" rel="noopener">{{ $map->nama_peta ?: 'Buka peta wilayah' }} ↗</a>
                @elseif(! $map->gambar)
                    <div class="rounded-3xl border border-dashed border-gray-300 bg-white p-8 text-center"><p class="text-4xl" aria-hidden="true">🗺️</p><h3 class="mt-3 font-bold text-gray-900">Peta belum tersedia</h3><p class="mt-1 text-sm text-gray-500">Admin dapat mengunggah gambar peta atau mengisi koordinat dan tautan peta.</p></div>
                @endif
                @if($map->map_url && ($map->gambar || $map->latitude !== null))<a class="mt-4 inline-flex rounded-xl bg-white px-5 py-3 font-bold text-brand-700 shadow-sm" href="{{ $map->map_url }}" target="_blank" rel="noopener">Buka tautan peta ↗</a>@endif
                @if($map->deskripsi)<p class="mt-4 text-sm leading-6 text-gray-600">{{ $map->deskripsi }}</p>@endif
            @else
                <div class="rounded-3xl border border-dashed border-gray-300 bg-white p-8 text-center"><p class="text-4xl" aria-hidden="true">🗺️</p><h3 class="mt-3 font-bold text-gray-900">Peta belum tersedia</h3><p class="mt-1 text-sm text-gray-500">Admin dapat mengunggah gambar peta atau mengisi koordinat dan tautan peta.</p></div>
            @endif
        </section>
    </div>
</main>
@endsection
@if($map && $map->status && ($map->latitude ?? $profile?->latitude) !== null && ($map->longitude ?? $profile?->longitude) !== null)
    @push('styles')<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">@endpush
    @push('scripts')
        @php($mapLatitude = $map->latitude ?? $profile->latitude)@php($mapLongitude = $map->longitude ?? $profile->longitude)
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            const villageMap = L.map('village-map').setView([{{ $mapLatitude }}, {{ $mapLongitude }}], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(villageMap);
            L.marker([{{ $mapLatitude }}, {{ $mapLongitude }}]).addTo(villageMap).bindPopup(@js($profile?->nama_desa ?: 'Desa Betro'));
            @foreach($dusuns->filter(fn ($dusun) => $dusun->latitude !== null && $dusun->longitude !== null) as $dusun)
                L.marker([{{ $dusun->latitude }}, {{ $dusun->longitude }}]).addTo(villageMap).bindPopup(@js($dusun->nama_dusun));
            @endforeach
            @if($map->boundary_geojson)
                const villageBoundary = L.geoJSON(@json(json_decode($map->boundary_geojson, true)), { style: { color: '#801b2a', weight: 3, fillOpacity: 0.12 } }).addTo(villageMap);
                villageMap.fitBounds(villageBoundary.getBounds());
            @endif
        </script>
    @endpush
@endif
