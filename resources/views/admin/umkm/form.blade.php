@extends('admin.layouts.app')

@section('title', $umkm ? 'Edit UMKM' : 'Tambah UMKM')
@section('page-title', $umkm ? 'Edit UMKM' : 'Tambah UMKM')
@section('page-desc', 'Kelola profil usaha, publikasi, dan produk')

@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ $umkm ? route('admin.umkm.update', $umkm) : route('admin.umkm.store') }}" class="max-w-5xl space-y-6" id="umkmForm">
    @csrf
    @if ($umkm)
        @method('PUT')
    @endif

    <section class="grid gap-5 rounded-2xl border border-gray-100 bg-white p-6 md:grid-cols-2">
        @foreach (['nama_usaha' => 'Nama usaha', 'kategori' => 'Kategori', 'nama_pemilik' => 'Nama pemilik', 'tahun_berdiri' => 'Tahun berdiri (beri penanda jika data contoh)', 'jam_operasional' => 'Jam operasional', 'whatsapp' => 'Nomor WhatsApp (kosongkan jika belum tersedia)'] as $field => $label)
            <label class="block text-sm font-bold text-gray-700">{{ $label }}
                <input name="{{ $field }}" value="{{ old($field, $umkm->$field ?? '') }}" @required(in_array($field, ['nama_usaha', 'kategori'], true)) class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 font-normal">
                @error($field)<span class="text-xs text-rose-600">{{ $message }}</span>@enderror
            </label>
        @endforeach
        <label class="block text-sm font-bold text-gray-700 md:col-span-2">Alamat lengkap
            <textarea name="alamat" rows="2" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 font-normal">{{ old('alamat', $umkm->alamat ?? '') }}</textarea>
            @error('alamat')<span class="text-xs text-rose-600">{{ $message }}</span>@enderror
        </label>
        <label class="block text-sm font-bold text-gray-700 md:col-span-2">Deskripsi singkat
            <textarea name="deskripsi_singkat" rows="2" maxlength="500" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 font-normal">{{ old('deskripsi_singkat', $umkm->deskripsi_singkat ?? '') }}</textarea>
        </label>
        <label class="block text-sm font-bold text-gray-700 md:col-span-2">Deskripsi lengkap
            <textarea name="deskripsi_lengkap" rows="5" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 font-normal">{{ old('deskripsi_lengkap', $umkm->deskripsi_lengkap ?? '') }}</textarea>
        </label>
        <label class="block text-sm font-bold text-gray-700">Foto utama (JPG, PNG, WebP; maks. 5 MB)
            <input type="file" name="foto" accept="image/jpeg,image/png,image/webp" data-image-preview="main-photo-preview" class="mt-2 block w-full text-sm font-normal">
            <img id="main-photo-preview" class="{{ $umkm?->foto ? '' : 'hidden' }} mt-3 h-28 rounded-lg object-cover" src="{{ $umkm?->foto ? (str_starts_with($umkm->foto, 'http') ? $umkm->foto : asset('storage/'.$umkm->foto)) : '' }}" alt="Pratinjau foto utama">
            @error('foto')<span class="text-xs text-rose-600">{{ $message }}</span>@enderror
        </label>
        <label class="block text-sm font-bold text-gray-700">Status publikasi
            <select name="status" required class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 font-normal"><option value="draft" @selected(old('status', $umkm->status ?? 'draft') === 'draft')>Draft</option><option value="terbit" @selected(old('status', $umkm->status ?? 'draft') === 'terbit')>Terbit</option></select>
        </label>
        <label class="flex items-center gap-2 text-sm font-bold text-gray-700"><input type="checkbox" name="is_demo" value="1" @checked(old('is_demo', $umkm->is_demo ?? false))> Tandai sebagai data demonstrasi</label>
    </section>

    <section class="space-y-4 rounded-2xl border border-gray-100 bg-white p-6">
        <div class="flex flex-wrap items-center justify-between gap-3"><div><h2 class="text-lg font-extrabold">Produk/Menu</h2><p class="text-xs text-gray-500">Tambahkan produk sesuai kebutuhan. Produk yang dihapus di sini akan dihapus dari katalog.</p></div><button type="button" id="add-product" class="rounded-xl bg-brand-700 px-4 py-2.5 text-xs font-bold text-white hover:bg-brand-800">+ Tambah Produk/Menu</button></div>
        @php($products = old('products', $umkm?->products?->toArray() ?? []))
        <div id="product-list" class="space-y-4">
            @foreach ($products as $index => $product)
                @include('admin.umkm.partials.product-fields', ['index' => $index, 'product' => $product])
            @endforeach
        </div>
        <template id="product-template">
            @include('admin.umkm.partials.product-fields', ['index' => '__INDEX__', 'product' => []])
        </template>
    </section>

    <div class="flex gap-3"><button class="rounded-xl bg-brand-700 px-5 py-3 text-sm font-bold text-white">Simpan UMKM</button><a href="{{ route('admin.umkm.index') }}" class="rounded-xl bg-gray-100 px-5 py-3 text-sm font-bold">Batal</a></div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const productList = document.getElementById('product-list');
    const productTemplate = document.getElementById('product-template');
    let productIndex = {{ count($products) }};

    document.getElementById('add-product').addEventListener('click', () => {
        const html = productTemplate.innerHTML.replaceAll('__INDEX__', String(productIndex++));
        productList.insertAdjacentHTML('beforeend', html);
    });

    document.getElementById('umkmForm').addEventListener('click', (event) => {
        if (event.target.closest('[data-remove-product]')) {
            event.target.closest('[data-product-row]').remove();
        }
    });

    document.getElementById('umkmForm').addEventListener('change', (event) => {
        const input = event.target.closest('[data-image-preview]');
        if (!input || !input.files?.[0]) return;
        const preview = document.getElementById(input.dataset.imagePreview);
        preview.src = URL.createObjectURL(input.files[0]);
        preview.classList.remove('hidden');
    });
});
</script>
@endpush
