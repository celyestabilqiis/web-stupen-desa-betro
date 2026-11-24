@extends('admin.layouts.app')
@section('title', 'Struktur Pemerintahan')
@section('page-title', 'Struktur Pemerintahan')
@section('page-desc', 'Kelola profil perangkat Desa Betro yang ditampilkan pada halaman Profil Desa')
@section('page-actions')
    <a href="{{ route('admin.struktur-pemerintahan.create') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-brand-700 px-4 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-brand-800 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Perangkat Desa
    </a>
@endsection

@section('content')
<div class="space-y-5">
    <form method="GET" action="{{ route('admin.struktur-pemerintahan.index') }}" class="grid gap-3 rounded-2xl border border-gray-100 bg-white p-4 sm:grid-cols-2 lg:grid-cols-4 shadow-2xs">
        <label class="text-xs font-bold text-gray-700">
            Cari nama
            <input type="search" name="cari" value="{{ request('cari') }}" placeholder="Ketik nama perangkat..." class="mt-1.5 w-full rounded-xl border border-gray-200 px-3 py-2 text-sm font-normal focus:border-brand-600 focus:ring-1 focus:ring-brand-600">
        </label>
        <label class="text-xs font-bold text-gray-700">
            Jabatan
            <select name="jabatan" class="mt-1.5 w-full rounded-xl border border-gray-200 px-3 py-2 text-sm font-normal focus:border-brand-600 focus:ring-1 focus:ring-brand-600">
                <option value="">Semua jabatan</option>
                @foreach($jabatanList as $jabatan)
                    <option value="{{ $jabatan }}" @selected(request('jabatan') === $jabatan)>{{ $jabatan }}</option>
                @endforeach
            </select>
        </label>
        <label class="text-xs font-bold text-gray-700">
            Status
            <select name="status" class="mt-1.5 w-full rounded-xl border border-gray-200 px-3 py-2 text-sm font-normal focus:border-brand-600 focus:ring-1 focus:ring-brand-600">
                <option value="">Semua status</option>
                <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
            </select>
        </label>
        <div class="flex items-end gap-2">
            <button class="flex-1 rounded-xl bg-brand-700 px-4 py-2.5 text-xs font-bold text-white hover:bg-brand-800 transition">Terapkan</button>
            <a href="{{ route('admin.struktur-pemerintahan.index') }}" class="rounded-xl bg-gray-100 px-4 py-2.5 text-xs font-bold text-gray-700 hover:bg-gray-200 transition">Reset</a>
        </div>
    </form>

    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-4">No.</th>
                        <th class="px-5 py-4">Foto</th>
                        <th class="px-5 py-4">Nama Lengkap</th>
                        <th class="px-5 py-4">Jabatan</th>
                        <th class="px-5 py-4">Status Kepala Desa</th>
                        <th class="px-5 py-4">Urutan</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($officials as $official)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-5 py-3 text-gray-500">{{ $officials->firstItem() + $loop->index }}</td>
                            <td class="px-5 py-3">
                                <div class="w-12 h-14 rounded-lg bg-gray-50 border border-gray-100 overflow-hidden flex items-center justify-center">
                                    @if($official->foto)
                                        <img src="{{ asset('storage/'.$official->foto) }}" alt="Foto {{ $official->nama }}" class="w-full h-full object-contain">
                                    @else
                                        <span class="text-xl text-brand-700">♙</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-3 font-bold text-gray-900">
                                {{ $official->nama }}
                            </td>
                            <td class="px-5 py-3 text-gray-700">
                                {{ $official->jabatan }}
                            </td>
                            <td class="px-5 py-3">
                                @if($official->is_kepala_desa)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-800 border border-amber-200">
                                        <svg class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        Kepala Desa
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 font-medium">Bukan</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-gray-700 font-medium">
                                {{ $official->urutan }}
                            </td>
                            <td class="px-5 py-3">
                                @if($official->status)
                                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">Aktif</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-600 border border-gray-200">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="inline-flex items-center gap-3">
                                    <a href="{{ route('admin.struktur-pemerintahan.show', $official) }}" class="font-bold text-brand-700 hover:text-brand-900 transition">Detail</a>
                                    <a href="{{ route('admin.struktur-pemerintahan.edit', $official) }}" class="font-bold text-gray-600 hover:text-gray-900 transition">Edit</a>
                                    <form method="POST" action="{{ route('admin.struktur-pemerintahan.destroy', $official) }}" onsubmit="return confirm('Hapus data {{ addslashes($official->nama) }}? Foto yang tidak digunakan akan dihapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-bold text-rose-700 hover:text-rose-900 transition">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-gray-500">
                                Belum ada data perangkat desa. Tambahkan data melalui tombol “Tambah Perangkat Desa”.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($officials->hasPages())
            <div class="border-t border-gray-100 p-4">
                {{ $officials->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
