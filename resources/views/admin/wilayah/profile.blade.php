@extends('admin.layouts.app')
@section('title', 'Gambaran Umum Desa')
@section('page-title', 'Gambaran Umum Desa')
@section('page-desc', 'Kelola identitas dan deskripsi Desa Betro')
@section('content')
<form method="POST" action="{{ route('admin.wilayah.profile.update') }}" enctype="multipart/form-data" class="max-w-4xl space-y-5 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
    @csrf @method('PUT')
    <div class="grid gap-4 sm:grid-cols-2">@foreach([['nama_desa','Nama Desa'],['kecamatan','Kecamatan'],['kabupaten','Kabupaten'],['provinsi','Provinsi'],['kode_pos','Kode Pos'],['kode_wilayah','Kode Wilayah'],['luas_wilayah','Luas Wilayah (km²)'],['latitude','Latitude'],['longitude','Longitude']] as [$name,$label])<label class="block text-sm font-semibold text-gray-700">{{ $label }}<input name="{{ $name }}" value="{{ old($name, $profile?->$name) }}" @if(in_array($name,['luas_wilayah','latitude','longitude'])) type="number" step="any" @else type="text" @endif class="mt-1 w-full rounded-xl border-gray-300" @if($name==='latitude') min="-90" max="90" @elseif($name==='longitude') min="-180" max="180" @endif></label>@endforeach</div>
    <label class="block text-sm font-semibold text-gray-700">Deskripsi Umum<textarea name="deskripsi" rows="5" class="mt-1 w-full rounded-xl border-gray-300">{{ old('deskripsi', $profile?->deskripsi) }}</textarea></label>
    <label class="block text-sm font-semibold text-gray-700">Gambar pendukung (JPG, PNG, WebP · maks. 5 MB)<input type="file" name="gambar" accept="image/jpeg,image/png,image/webp" class="mt-1 block w-full text-sm" data-image-preview></label>
    <div class="flex flex-wrap gap-3">@if($profile?->gambar)<div><img src="{{ asset('storage/'.$profile->gambar) }}" alt="Gambar Desa" class="h-40 w-56 rounded-xl bg-gray-50 object-contain"><label class="mt-2 flex items-center gap-2 text-xs text-red-700"><input type="checkbox" name="hapus_gambar" value="1">Hapus gambar saat ini</label></div>@endif<img data-preview-output alt="Pratinjau gambar baru" class="hidden h-40 w-56 rounded-xl bg-gray-50 object-contain"></div>
    <button class="rounded-xl bg-brand-700 px-5 py-3 font-bold text-white">Simpan Perubahan</button>
</form>
@endsection
@push('scripts')<script>document.querySelector('[data-image-preview]')?.addEventListener('change', event => { const output = document.querySelector('[data-preview-output]'); const file = event.target.files?.[0]; if (file) { output.src = URL.createObjectURL(file); output.classList.remove('hidden'); } });</script>@endpush
