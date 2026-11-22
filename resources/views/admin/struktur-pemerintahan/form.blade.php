@extends('admin.layouts.app')
@section('title', $official ? 'Edit Perangkat Desa' : 'Tambah Perangkat Desa')
@section('page-title', $official ? 'Edit Perangkat Desa' : 'Tambah Perangkat Desa')
@section('page-desc', 'Kelola nama, jabatan, foto, dan status publikasi')
@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ $official ? route('admin.struktur-pemerintahan.update', $official) : route('admin.struktur-pemerintahan.store') }}" class="max-w-3xl space-y-5 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-7">
    @csrf @if($official) @method('PUT') @endif
    <div class="grid gap-4 sm:grid-cols-2"><label class="block text-sm font-semibold text-gray-700">Nama lengkap<input name="nama" required maxlength="255" value="{{ old('nama', $official?->nama) }}" class="mt-2 w-full rounded-xl border-gray-200 text-sm font-normal"></label><label class="block text-sm font-semibold text-gray-700">Jabatan / posisi<input name="jabatan" id="official-role" required maxlength="255" value="{{ old('jabatan', $official?->jabatan) }}" placeholder="Contoh: Sekretaris Desa" class="mt-2 w-full rounded-xl border-gray-200 text-sm font-normal"></label></div>
    <label class="block text-sm font-semibold text-gray-700">Deskripsi singkat (opsional)<textarea name="deskripsi" rows="3" maxlength="3000" class="mt-2 w-full rounded-xl border-gray-200 text-sm font-normal">{{ old('deskripsi', $official?->deskripsi) }}</textarea></label>
    <label class="block text-sm font-semibold text-gray-700">Foto perangkat desa (JPG, JPEG, PNG, WebP; maks. 5 MB)<input type="file" name="foto" id="official-photo" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full rounded-xl border border-gray-200 p-2 text-sm font-normal">@error('foto')<span class="mt-1 block text-xs text-rose-700">{{ $message }}</span>@enderror<img id="official-photo-preview" src="{{ $official?->foto ? asset('storage/'.$official->foto) : '' }}" alt="Pratinjau foto perangkat desa" class="{{ $official?->foto ? '' : 'hidden' }} mt-3 h-36 w-32 rounded-xl bg-gray-50 object-contain"><span id="official-photo-placeholder" class="{{ $official?->foto ? 'hidden' : '' }} mt-3 grid h-36 w-32 place-items-center rounded-xl bg-brand-50 text-4xl text-brand-700">♙</span></label>
    <div class="grid gap-4 sm:grid-cols-2"><label class="block text-sm font-semibold text-gray-700">Urutan tampilan<input type="number" name="urutan" min="0" max="65535" required value="{{ old('urutan', $official?->urutan ?? 0) }}" class="mt-2 w-full rounded-xl border-gray-200 text-sm font-normal"></label><label class="block text-sm font-semibold text-gray-700">Status publikasi<select name="status" required class="mt-2 w-full rounded-xl border-gray-200 text-sm font-normal"><option value="1" @selected((string) old('status', (int) ($official?->status ?? true)) === '1')>Aktif — tampil di halaman Profil</option><option value="0" @selected((string) old('status', (int) ($official?->status ?? true)) === '0')>Nonaktif — hanya tampil di Admin</option></select></label></div>
    <label class="flex items-start gap-3 rounded-xl bg-amber-50 p-4 text-sm font-semibold text-amber-950"><input type="hidden" name="is_kepala_desa" value="0"><input type="checkbox" name="is_kepala_desa" id="official-head" value="1" @checked((bool) old('is_kepala_desa', $official?->is_kepala_desa ?? false)) class="mt-0.5 rounded border-amber-300 text-brand-700"><span>Tetapkan sebagai Kepala Desa <small class="mt-1 block font-normal">Jika diaktifkan, sistem mengganti Kepala Desa aktif sebelumnya dan menempatkan kartu ini di atas.</small></span></label>
    <div class="flex gap-3"><button class="rounded-xl bg-brand-700 px-5 py-3 text-sm font-bold text-white">Simpan Perangkat Desa</button><a href="{{ route('admin.struktur-pemerintahan.index') }}" class="rounded-xl border border-gray-200 px-5 py-3 text-sm font-bold text-gray-600">Batal</a></div>
</form>
@endsection
@push('scripts')
<script>
    const photoInput = document.getElementById('official-photo');
    const photoPreview = document.getElementById('official-photo-preview');
    const photoPlaceholder = document.getElementById('official-photo-placeholder');
    photoInput.addEventListener('change', () => {
        const photo = photoInput.files[0];
        if (!photo) return;
        photoPreview.src = URL.createObjectURL(photo);
        photoPreview.classList.remove('hidden');
        photoPlaceholder.classList.add('hidden');
    });
    document.getElementById('official-head').addEventListener('change', (event) => {
        if (event.target.checked) document.getElementById('official-role').value = 'Kepala Desa';
    });
</script>
@endpush
