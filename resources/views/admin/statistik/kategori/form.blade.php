@extends('admin.layouts.app')
@section('title', $category ? 'Edit Kategori Statistik' : 'Tambah Kategori Statistik')
@section('page-title', $category ? 'Edit Kategori Statistik' : 'Tambah Kategori Statistik')
@section('page-desc', 'Kategori yang aktif dan berisi data publik akan tampil di halaman statistik')
@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ $category ? route('admin.statistik.kategori.update', $category) : route('admin.statistik.kategori.store') }}" class="max-w-2xl space-y-5 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-7">
    @csrf @if($category) @method('PUT') @endif
    <label class="block text-sm font-semibold">Nama kategori<input name="nama_kategori" required maxlength="255" value="{{ old('nama_kategori', $category?->nama_kategori) }}" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label>
    <label class="block text-sm font-semibold">Halaman statistik<select name="page_id" required class="mt-2 w-full rounded-xl border-gray-200 text-sm"><option value="">Pilih halaman</option>@foreach($pages as $page)<option value="{{ $page->id }}" @selected((string) old('page_id', $category?->page_id) === (string) $page->id)>{{ $page->title }}</option>@endforeach</select></label>
    <label class="block text-sm font-semibold">Deskripsi<textarea name="deskripsi" rows="3" class="mt-2 w-full rounded-xl border-gray-200 text-sm">{{ old('deskripsi', $category?->deskripsi) }}</textarea></label>
    <div class="grid gap-4 sm:grid-cols-2"><label class="block text-sm font-semibold">Ikon / emoji<input name="ikon" maxlength="50" value="{{ old('ikon', $category?->ikon) }}" placeholder="Contoh: 👥" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label><label class="block text-sm font-semibold">Urutan tampilan<input type="number" name="urutan" min="0" max="65535" required value="{{ old('urutan', $category?->urutan ?? 0) }}" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label></div>
    <div class="grid gap-4 sm:grid-cols-2"><label class="block text-sm font-semibold">Jenis visualisasi<select name="visualization_type" required class="mt-2 w-full rounded-xl border-gray-200 text-sm"><option value="bar" @selected(old('visualization_type', $category?->visualization_type ?? 'bar') === 'bar')>Diagram batang</option><option value="pie" @selected(old('visualization_type', $category?->visualization_type) === 'pie')>Diagram lingkaran</option><option value="doughnut" @selected(old('visualization_type', $category?->visualization_type) === 'doughnut')>Doughnut</option><option value="table" @selected(old('visualization_type', $category?->visualization_type) === 'table')>Tabel</option></select></label><label class="block text-sm font-semibold">Gambar kategori (maks. 5 MB)<input type="file" id="category-image" name="gambar" accept="image/jpeg,image/png,image/webp" class="mt-2 w-full rounded-xl border border-gray-200 p-2 text-sm">@if($category?->gambar)<img src="{{ asset('storage/'.$category->gambar) }}" alt="Gambar kategori" class="mt-3 h-24 rounded-lg object-cover">@endif</label></div>
    <input type="hidden" name="status" value="0"><label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="status" value="1" @checked((bool) old('status', $category?->status ?? true)) class="rounded border-gray-300 text-brand-700 focus:ring-brand-500"> Kategori aktif</label>
    <div class="flex gap-3"><button class="rounded-xl bg-brand-700 px-5 py-3 text-sm font-bold text-white">Simpan</button><a href="{{ route('admin.statistik.kategori.index') }}" class="rounded-xl border border-gray-200 px-5 py-3 text-sm font-bold text-gray-600">Batal</a></div>
</form>
@endsection
@push('scripts')
<script>
    document.getElementById('category-image').addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) return;
        const preview = document.createElement('img');
        preview.src = URL.createObjectURL(file);
        preview.alt = 'Preview gambar kategori';
        preview.className = 'mt-3 h-24 rounded-lg object-cover';
        preview.dataset.imagePreview = 'true';
        event.target.parentElement.querySelectorAll('[data-image-preview]').forEach((image) => image.remove());
        event.target.after(preview);
    });
</script>
@endpush
