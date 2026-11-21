@extends('admin.layouts.app')

@section('title', 'Kelola UMKM')
@section('page-title', 'Katalog UMKM')
@section('page-desc', 'Kelola data usaha dan produk yang ditampilkan di halaman publik')

@section('page-actions')
    <a href="{{ route('admin.umkm.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-700 px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-brand-800">Tambah UMKM</a>
@endsection

@section('content')
<div class="space-y-6">
    <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-xs">
        <form method="GET" action="{{ route('admin.umkm.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <label for="cari" class="block text-xs font-bold text-gray-700">Cari Nama Usaha<input type="search" name="cari" id="cari" value="{{ request('cari') }}" placeholder="Ketik nama usaha..." class="mt-1.5 w-full rounded-xl border border-gray-200 px-3.5 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-brand-700"></label>
            <label for="status" class="block text-xs font-bold text-gray-700">Status Publikasi<select name="status" id="status" class="mt-1.5 w-full rounded-xl border border-gray-200 px-3.5 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-brand-700"><option value="">Semua Status</option><option value="terbit" @selected(request('status') === 'terbit')>Terbit</option><option value="draft" @selected(request('status') === 'draft')>Draft</option></select></label>
            <div class="flex items-end gap-2"><button type="submit" class="flex-1 rounded-xl bg-brand-700 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-brand-800">Saring Data</button>@if(request()->hasAny(['cari', 'status']))<a href="{{ route('admin.umkm.index') }}" class="rounded-xl bg-gray-100 px-3.5 py-2.5 text-xs font-bold text-gray-700">Reset</a>@endif</div>
        </form>
    </div>
    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-xs">
        <div class="overflow-x-auto"><table class="w-full text-left text-sm"><thead class="border-b border-gray-100 bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500"><tr><th class="px-6 py-3.5">Nama usaha</th><th class="px-6 py-3.5">Kategori</th><th class="px-6 py-3.5">Jumlah produk</th><th class="px-6 py-3.5">Status</th><th class="px-6 py-3.5 text-right">Aksi</th></tr></thead>
            <tbody class="divide-y divide-gray-100">@forelse ($umkmList as $umkm)<tr class="hover:bg-gray-50/50"><td class="px-6 py-4 font-bold text-gray-900">{{ $umkm->nama_usaha }} @if($umkm->is_demo)<span class="ml-1 text-xs font-medium text-amber-700">(Demo)</span>@endif</td><td class="px-6 py-4">{{ $umkm->kategori }}</td><td class="px-6 py-4">{{ $umkm->products_count }}</td><td class="px-6 py-4">@if($umkm->status === 'terbit')<span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700">Terbit</span>@else<span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700">Draft</span>@endif</td><td class="px-6 py-4 text-right"><div class="inline-flex items-center gap-3"><a class="text-xs font-bold text-brand-700" href="{{ route('admin.umkm.edit', $umkm) }}">Edit</a><form method="POST" action="{{ route('admin.umkm.destroy', $umkm) }}" onsubmit="return confirm('Hapus data UMKM ini beserta produk dan fotonya?')">@csrf @method('DELETE')<button class="text-xs font-bold text-rose-600">Hapus</button></form></div></td></tr>@empty<tr><td colspan="5" class="px-6 py-12 text-center text-sm text-gray-400">Tidak ada data UMKM yang sesuai dengan filter.</td></tr>@endforelse</tbody>
        </table></div>
        @if ($umkmList->hasPages())<div class="border-t border-gray-100 p-4">{{ $umkmList->links() }}</div>@endif
    </div>
</div>
@endsection
