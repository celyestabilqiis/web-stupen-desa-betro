@extends('admin.layouts.app')
@section('title', 'Detail Perangkat Desa')
@section('page-title', 'Detail Perangkat Desa')
@section('page-desc', 'Rincian data perangkat Pemerintah Desa Betro')
@section('page-actions')
    <a href="{{ route('admin.struktur-pemerintahan.edit', $official) }}" class="inline-flex items-center gap-1.5 rounded-xl bg-brand-700 px-4 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-brand-800 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        Edit Data
    </a>
@endsection

@section('content')
<article class="max-w-3xl overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
    <div class="grid sm:grid-cols-[220px_1fr]">
        <div class="grid min-h-64 place-items-center bg-gray-50 p-4 border-b sm:border-b-0 sm:border-r border-gray-100">
            @if($official->foto)
                <img src="{{ asset('storage/'.$official->foto) }}" alt="Foto {{ $official->nama }}" class="max-h-72 w-full object-contain rounded-lg">
            @else
                <span class="text-6xl text-brand-700">♙</span>
            @endif
        </div>
        <div class="p-6 sm:p-8">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-brand-700">{{ $official->jabatan }}</p>
                    <h2 class="mt-1.5 text-2xl font-extrabold text-gray-900">{{ $official->nama }}</h2>
                </div>
                <span class="rounded-full px-3 py-1 text-xs font-bold border {{ $official->status ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-gray-100 text-gray-600 border-gray-200' }}">
                    {{ $official->status ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>

            <dl class="mt-6 grid gap-4 border-t border-gray-100 pt-5 sm:grid-cols-2">
                <div>
                    <dt class="text-xs text-gray-500 font-medium">Status Kepala Desa</dt>
                    <dd class="mt-1 font-bold text-gray-900">
                        @if($official->is_kepala_desa)
                            <span class="inline-flex items-center gap-1 text-amber-700">
                                <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Ya, Kepala Desa
                            </span>
                        @else
                            Bukan Kepala Desa
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 font-medium">Urutan Tampilan</dt>
                    <dd class="mt-1 font-bold text-gray-900">{{ $official->urutan }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-xs text-gray-500 font-medium">Deskripsi</dt>
                    <dd class="mt-1 whitespace-pre-line text-sm text-gray-700 leading-relaxed">{{ $official->deskripsi ?: '—' }}</dd>
                </div>
            </dl>

            <div class="mt-6 flex gap-3 border-t border-gray-100 pt-5">
                <a href="{{ route('admin.struktur-pemerintahan.index') }}" class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-50 transition">
                    Kembali
                </a>
                <form method="POST" action="{{ route('admin.struktur-pemerintahan.destroy', $official) }}" onsubmit="return confirm('Hapus perangkat desa ini? Foto yang tidak digunakan akan dihapus.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-xs font-bold text-rose-700 hover:bg-rose-100 transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</article>
@endsection
