@php
    $productId = $product['id'] ?? null;
    $productPhoto = $product['foto'] ?? null;
    $previewId = 'product-photo-preview-'.$index;
@endphp
<div data-product-row class="grid gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 md:grid-cols-2">
    @if ($productId)<input type="hidden" name="products[{{ $index }}][id]" value="{{ $productId }}">@endif
    <label class="text-xs font-bold text-gray-700">Nama produk/menu <input required name="products[{{ $index }}][nama_produk]" value="{{ $product['nama_produk'] ?? '' }}" class="mt-1 w-full rounded-lg border border-gray-200 bg-white p-2.5"></label>
    <label class="text-xs font-bold text-gray-700">Harga <input type="number" min="0" step="1" name="products[{{ $index }}][harga]" value="{{ $product['harga'] ?? '' }}" class="mt-1 w-full rounded-lg border border-gray-200 bg-white p-2.5"></label>
    <label class="text-xs font-bold text-gray-700">Satuan <input name="products[{{ $index }}][satuan]" value="{{ $product['satuan'] ?? '' }}" placeholder="per kotak" class="mt-1 w-full rounded-lg border border-gray-200 bg-white p-2.5"></label>
    <label class="text-xs font-bold text-gray-700">Deskripsi produk <input name="products[{{ $index }}][deskripsi]" value="{{ $product['deskripsi'] ?? '' }}" class="mt-1 w-full rounded-lg border border-gray-200 bg-white p-2.5"></label>
    <label class="text-xs font-bold text-gray-700">Foto produk (JPG, PNG, WebP; maks. 5 MB)
        <input type="file" accept="image/jpeg,image/png,image/webp" name="products[{{ $index }}][foto]" data-image-preview="{{ $previewId }}" class="mt-1 block w-full text-xs font-normal">
        <img id="{{ $previewId }}" class="{{ $productPhoto ? '' : 'hidden' }} mt-2 h-24 rounded-lg object-cover" src="{{ $productPhoto ? (str_starts_with($productPhoto, 'http') ? $productPhoto : asset('storage/'.$productPhoto)) : '' }}" alt="Pratinjau foto produk">
        @error('products.'.$index.'.foto')<span class="text-xs text-rose-600">{{ $message }}</span>@enderror
    </label>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <label class="flex items-center gap-2 text-xs font-bold text-gray-700"><input type="hidden" name="products[{{ $index }}][tersedia]" value="0"><input type="checkbox" name="products[{{ $index }}][tersedia]" value="1" @checked($product['tersedia'] ?? true)> Tersedia</label>
        <button type="button" data-remove-product class="rounded-lg px-3 py-2 text-xs font-bold text-rose-700 hover:bg-rose-50">Hapus produk</button>
    </div>
</div>
