@extends('admin.layouts.app')

@section('title', 'Kelola Arsip & Dokumentasi')
@section('page-title', 'Arsip & Dokumentasi Desa')
@section('page-desc', 'Kelola seluruh dokumen publik dan arsip kegiatan Desa Betro')

@section('page-actions')
    <a href="{{ route('admin.arsip.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs shadow-sm transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Tambah Arsip</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
        <form method="GET" action="{{ route('admin.arsip.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Cari Judul -->
            <div>
                <label for="cari" class="block text-xs font-bold text-gray-700 mb-1.5">Cari Judul</label>
                <input type="text" name="cari" id="cari" value="{{ request('cari') }}" placeholder="Ketik kata kunci judul..." class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">
            </div>

            <!-- Filter Kategori -->
            <div>
                <label for="kategori" class="block text-xs font-bold text-gray-700 mb-1.5">Kategori</label>
                <select name="kategori" id="kategori" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    <option value="">Semua Kategori</option>
                    <option value="arsip_desa" {{ request('kategori') === 'arsip_desa' ? 'selected' : '' }}>Arsip Desa</option>
                    <option value="dokumentasi_desa" {{ request('kategori') === 'dokumentasi_desa' ? 'selected' : '' }}>Dokumentasi Desa</option>
                </select>
            </div>

            <!-- Filter Status -->
            <div>
                <label for="status" class="block text-xs font-bold text-gray-700 mb-1.5">Status</label>
                <select name="status" id="status" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="terbit" {{ request('status') === 'terbit' ? 'selected' : '' }}>Terbit</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <!-- Tombol Filter -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs rounded-xl transition">
                    Saring Data
                </button>
                @if (request()->hasAny(['cari', 'kategori', 'status']))
                    <a href="{{ route('admin.arsip.index') }}" class="px-3.5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition" title="Reset filter">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Judul</th>
                        <th class="px-6 py-3.5">Kategori</th>
                        <th class="px-6 py-3.5">Tipe</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5">Tanggal</th>
                        <th class="px-6 py-3.5 text-center">Dilihat</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($arsipList as $item)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($item->gambar_sampul)
                                        <img src="{{ asset('storage/' . $item->gambar_sampul) }}" alt="Sampul" class="w-12 h-10 object-cover rounded-lg flex-shrink-0 bg-gray-100">
                                    @elseif ($item->tipe === 'pdf')
                                        <div class="w-12 h-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0 font-extrabold text-[10px]">
                                            PDF
                                        </div>
                                    @else
                                        <div class="w-12 h-10 rounded-lg bg-gray-100 text-gray-400 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <span class="font-bold text-gray-900 block max-w-sm sm:max-w-md truncate">{{ $item->judul }}</span>
                                        <span class="text-xs text-gray-400">Penulis: {{ $item->penulis->name ?? 'Admin' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->kategori === 'arsip_desa')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700">Arsip Desa</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-50 text-purple-700">Dokumentasi Desa</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->tipe === 'pdf')
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-md">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        PDF
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded-md">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                        Artikel
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->status === 'terbit')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700">Terbit</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600 whitespace-nowrap">
                                {{ $item->tanggal ? $item->tanggal->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-center text-xs font-bold text-gray-600 whitespace-nowrap">
                                {{ $item->jumlah_dilihat }}x
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    @if ($item->status === 'terbit')
                                        <a href="{{ route('pages.arsip.show', $item->slug) }}"{!! $item->tipe === 'pdf' ? ' target="_blank" rel="noopener"' : '' !!} class="p-1.5 text-gray-400 hover:text-gray-700 rounded-lg transition" title="Lihat publik">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.arsip.edit', $item) }}" class="p-1.5 text-brand-700 hover:text-brand-900 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.arsip.destroy', $item) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip ini? Tindakan ini tidak dapat dibatalkan.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400 text-sm">
                                Tidak ada data arsip yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($arsipList->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $arsipList->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
