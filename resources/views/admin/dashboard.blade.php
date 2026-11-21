@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-desc', 'Ringkasan statistik data dan arsip Desa Betro')

@section('page-actions')
    <a href="{{ route('admin.arsip.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs shadow-sm transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Tambah Arsip Baru</span>
    </a>
@endsection

@section('content')
<div class="space-y-8">
    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
        <!-- Total Arsip -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500">Total Arsip</p>
                <p class="text-2xl font-extrabold text-gray-900 mt-0.5">{{ $totalArsip }}</p>
            </div>
        </div>

        <!-- Terbit -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500">Status Terbit</p>
                <p class="text-2xl font-extrabold text-emerald-600 mt-0.5">{{ $totalTerbit }}</p>
            </div>
        </div>

        <!-- Draft -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500">Status Draft</p>
                <p class="text-2xl font-extrabold text-amber-600 mt-0.5">{{ $totalDraft }}</p>
            </div>
        </div>

        <!-- Kategori Arsip Desa -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500">Arsip Desa</p>
                <p class="text-2xl font-extrabold text-blue-600 mt-0.5">{{ $totalArsipDesa }}</p>
            </div>
        </div>

        <!-- Kategori Dokumentasi Desa -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500">Dokumentasi Desa</p>
                <p class="text-2xl font-extrabold text-purple-600 mt-0.5">{{ $totalDokumentasi }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Arsip Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-gray-900">Arsip Terbaru</h2>
                <p class="text-xs text-gray-500 mt-0.5">Daftar arsip dan dokumentasi yang baru saja ditambahkan</p>
            </div>
            <a href="{{ route('admin.arsip.index') }}" class="text-xs font-bold text-brand-700 hover:text-brand-900 transition flex items-center gap-1">
                <span>Kelola Semua Arsip</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Judul</th>
                        <th class="px-6 py-3.5">Kategori</th>
                        <th class="px-6 py-3.5">Tipe</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5">Tanggal</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($arsipTerbaru as $item)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-900 block max-w-md truncate">{{ $item->judul }}</span>
                                <span class="text-xs text-gray-400">Oleh: {{ $item->penulis->name ?? 'Admin' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->kategori === 'arsip_desa')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700">Arsip Desa</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-50 text-purple-700">Dokumentasi Desa</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold uppercase text-gray-600">{{ $item->labelTipe() }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->status === 'terbit')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700">Terbit</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600 whitespace-nowrap">
                                {{ $item->tanggal ? $item->tanggal->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('admin.arsip.edit', $item) }}" class="text-xs font-bold text-brand-700 hover:text-brand-900 transition mr-3">Edit</a>
                                @if ($item->status === 'terbit')
                                    <a href="{{ route('pages.arsip.show', $item->slug) }}"{!! $item->tipe === 'pdf' ? ' target="_blank" rel="noopener"' : '' !!} class="text-xs font-bold text-gray-600 hover:text-gray-900 transition">Lihat</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada data arsip.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-xs">
        <div class="flex items-center justify-between border-b border-gray-100 p-5">
            <div><h2 class="text-base font-bold text-gray-900">UMKM Terbaru</h2><p class="mt-0.5 text-xs text-gray-500">Maksimal tiga usaha yang terakhir ditambahkan</p></div>
            <a href="{{ route('admin.umkm.index') }}" class="flex items-center gap-1 text-xs font-bold text-brand-700 transition hover:text-brand-900"><span>Kelola Semua UMKM</span><svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
        </div>
        <div class="overflow-x-auto"><table class="w-full text-left text-sm"><thead class="border-b border-gray-100 bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500"><tr><th class="px-6 py-3.5">Nama usaha</th><th class="px-6 py-3.5">Kategori</th><th class="px-6 py-3.5">Produk</th><th class="px-6 py-3.5">Status</th><th class="px-6 py-3.5 text-right">Aksi</th></tr></thead><tbody class="divide-y divide-gray-100">@forelse ($umkmTerbaru as $umkm)<tr class="hover:bg-gray-50/50"><td class="px-6 py-4 font-bold text-gray-900">{{ $umkm->nama_usaha }}</td><td class="px-6 py-4">{{ $umkm->kategori }}</td><td class="px-6 py-4">{{ $umkm->products_count }}</td><td class="px-6 py-4">{{ $umkm->status === 'terbit' ? 'Terbit' : 'Draft' }}</td><td class="px-6 py-4 text-right"><a href="{{ route('admin.umkm.edit', $umkm) }}" class="text-xs font-bold text-brand-700">Edit</a></td></tr>@empty<tr><td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">Belum ada data UMKM.</td></tr>@endforelse</tbody></table></div>
    </div>
</div>
@endsection
