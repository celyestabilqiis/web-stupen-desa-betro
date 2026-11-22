@extends('admin.layouts.app')
@section('title', $page ? 'Edit Halaman Statistik' : 'Tambah Halaman Statistik')
@section('page-title', $page ? 'Edit Halaman Statistik' : 'Tambah Halaman Statistik')
@section('page-desc', 'Kelompokkan kategori dan data statistik ke dalam halaman publik')
@section('content')
<form method="POST" action="{{ $page ? route('admin.statistik.halaman.update', $page) : route('admin.statistik.halaman.store') }}" class="max-w-2xl space-y-5 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-7">@csrf @if($page) @method('PUT') @endif
<label class="block text-sm font-semibold">Judul halaman<input name="title" required maxlength="255" value="{{ old('title', $page?->title) }}" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label>
<label class="block text-sm font-semibold">Deskripsi<textarea name="description" rows="3" class="mt-2 w-full rounded-xl border-gray-200 text-sm">{{ old('description', $page?->description) }}</textarea></label>
<div class="grid gap-4 sm:grid-cols-2"><label class="block text-sm font-semibold">Urutan<input type="number" name="sort_order" required min="0" value="{{ old('sort_order', $page?->sort_order ?? 0) }}" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label><label class="flex items-center gap-2 pt-7 text-sm font-semibold"><input type="hidden" name="status" value="0"><input type="checkbox" name="status" value="1" @checked((bool) old('status', $page?->status ?? true)) class="rounded border-gray-300 text-brand-700"> Halaman aktif</label></div>
<div class="flex gap-3"><button class="rounded-xl bg-brand-700 px-5 py-3 text-sm font-bold text-white">Simpan Halaman</button><a href="{{ route('admin.statistik.halaman.index') }}" class="rounded-xl border border-gray-200 px-5 py-3 text-sm font-bold text-gray-600">Batal</a></div></form>
@endsection
