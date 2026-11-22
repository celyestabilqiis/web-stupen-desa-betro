@extends('admin.layouts.app')
@section('title', $statistic ? 'Edit Data Statistik' : 'Tambah Data Statistik')
@section('page-title', $statistic ? 'Edit Data Statistik' : 'Tambah Data Statistik')
@section('page-desc', 'Setiap kombinasi kategori, indikator, dan tahun disimpan sebagai rekam terpisah')
@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ $statistic ? route('admin.statistik.update', $statistic) : route('admin.statistik.store') }}" class="max-w-3xl space-y-5 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-7">
    @csrf @if($statistic) @method('PUT') @endif
    <div class="grid gap-4 sm:grid-cols-2"><label class="block text-sm font-semibold">Halaman statistik<select name="page_id" id="statistic-page" required class="mt-2 w-full rounded-xl border-gray-200 text-sm"><option value="">Pilih halaman</option>@foreach($pages as $page)<option value="{{ $page->id }}" @selected((string) old('page_id', $statistic?->category?->page_id) === (string) $page->id)>{{ $page->title }}</option>@endforeach</select></label><label class="block text-sm font-semibold">Kategori statistik<select name="category_id" id="statistic-category" required class="mt-2 w-full rounded-xl border-gray-200 text-sm"><option value="">Pilih kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}" data-page="{{ $category->page_id }}" @selected((string) old('category_id', $statistic?->category_id) === (string) $category->id)>{{ $category->nama_kategori }}{{ $category->status ? '' : ' (Nonaktif)' }}</option>@endforeach</select></label></div>
    <div class="grid gap-4 sm:grid-cols-2"><label class="block text-sm font-semibold">Nama statistik<input name="nama_statistik" required maxlength="255" value="{{ old('nama_statistik', $statistic?->nama_statistik) }}" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label><label class="block text-sm font-semibold">Label data<input name="label" maxlength="255" value="{{ old('label', $statistic?->label) }}" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label></div>
    <div class="grid gap-4 sm:grid-cols-2"><label class="block text-sm font-semibold">Nilai statistik<input type="number" name="nilai" required min="0" max="99999999999999.9999" step="0.0001" value="{{ old('nilai', $statistic?->nilai) }}" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label><label class="block text-sm font-semibold">Ikon statistik (opsional)<input name="ikon" maxlength="50" value="{{ old('ikon', $statistic?->ikon) }}" placeholder="Contoh: 👥" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label></div>
    <div class="grid gap-4 sm:grid-cols-3"><label class="block text-sm font-semibold">Satuan<input name="satuan" maxlength="50" value="{{ old('satuan', $statistic?->satuan) }}" placeholder="Jiwa, unit, km²" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label><label class="block text-sm font-semibold">Tahun data<input type="number" name="tahun" min="1900" max="2200" required value="{{ old('tahun', $statistic?->tahun ?? date('Y')) }}" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label><label class="block text-sm font-semibold">Urutan tampilan<input type="number" name="urutan" min="0" max="65535" required value="{{ old('urutan', $statistic?->urutan ?? 0) }}" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label></div>
    <label class="block text-sm font-semibold">Deskripsi / keterangan<textarea name="deskripsi" rows="3" class="mt-2 w-full rounded-xl border-gray-200 text-sm">{{ old('deskripsi', $statistic?->deskripsi) }}</textarea></label>
    <div class="grid gap-4 sm:grid-cols-2"><label class="block text-sm font-semibold">Sumber data (opsional)<input name="sumber_data" maxlength="255" value="{{ old('sumber_data', $statistic?->sumber_data) }}" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label><label class="block text-sm font-semibold">Gambar pendukung (maks. 5 MB)<input type="file" name="gambar" id="statistic-image" accept="image/jpeg,image/png,image/webp" class="mt-2 w-full rounded-xl border border-gray-200 p-2 text-sm">@if($statistic?->gambar)<img src="{{ asset('storage/'.$statistic->gambar) }}" alt="Gambar statistik" class="mt-3 h-24 rounded-lg object-cover">@endif</label></div>
    <div class="grid gap-4 sm:grid-cols-2"><label class="block text-sm font-semibold">Status publikasi<select name="status" required class="mt-2 w-full rounded-xl border-gray-200 text-sm"><option value="aktif" @selected(old('status', $statistic?->status ?? 'aktif') === 'aktif')>Aktif — tampil pada publik</option><option value="nonaktif" @selected(old('status', $statistic?->status) === 'nonaktif')>Nonaktif — hanya admin</option></select></label><div class="flex items-end"><input type="hidden" name="tampil_di_ringkasan" value="0"><label class="flex items-center gap-2 pb-3 text-sm font-semibold"><input type="checkbox" name="tampil_di_ringkasan" value="1" @checked((bool) old('tampil_di_ringkasan', $statistic?->tampil_di_ringkasan ?? false)) class="rounded border-gray-300 text-brand-700 focus:ring-brand-500"> Tampilkan di ringkasan publik</label></div></div>
    <div class="rounded-xl bg-amber-50 p-4 text-xs leading-relaxed text-amber-900">Gunakan data agregat. Jangan menyimpan NIK, nomor KK, nama warga, atau informasi pribadi lainnya.</div>
    <div class="flex gap-3"><button class="rounded-xl bg-brand-700 px-5 py-3 text-sm font-bold text-white">Simpan Statistik</button><a href="{{ route('admin.statistik.index') }}" class="rounded-xl border border-gray-200 px-5 py-3 text-sm font-bold text-gray-600">Batal</a></div>
</form>
@endsection

@push('scripts')
<script>
    const pageSelect = document.getElementById('statistic-page');
    const categorySelect = document.getElementById('statistic-category');
    const categoryOptions = [...categorySelect.options].slice(1);
    const selectedCategory = categorySelect.value;
    const updateStatisticCategories = () => {
        const pageId = pageSelect.value;
        categoryOptions.forEach((option) => {
            option.hidden = option.dataset.page !== pageId;
            option.disabled = option.hidden;
        });
        if (categorySelect.selectedOptions[0]?.disabled) categorySelect.value = '';
        if (!categorySelect.value && categoryOptions.some((option) => option.value === selectedCategory && !option.disabled)) categorySelect.value = selectedCategory;
    };
    pageSelect.addEventListener('change', updateStatisticCategories);
    updateStatisticCategories();
    document.getElementById('statistic-image').addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) return;
        const preview = document.createElement('img');
        preview.src = URL.createObjectURL(file);
        preview.alt = 'Preview gambar statistik';
        preview.className = 'mt-3 h-24 rounded-lg object-cover';
        event.target.parentElement.querySelectorAll('[data-image-preview]').forEach((image) => image.remove());
        preview.dataset.imagePreview = 'true';
        event.target.after(preview);
    });
</script>
@endpush
