@extends('admin.layouts.app')
@section('title', $official ? 'Edit Perangkat Desa' : 'Tambah Perangkat Desa')
@section('page-title', $official ? 'Edit Perangkat Desa' : 'Tambah Perangkat Desa')
@section('page-desc', 'Kelola nama, jabatan, foto, urutan tampilan, dan status publikasi')
@section('content')

@php
    $anotherHeadExists = $existingHead && (! $official || $official->id !== $existingHead->id);
@endphp

<form method="POST" enctype="multipart/form-data" action="{{ $official ? route('admin.struktur-pemerintahan.update', $official) : route('admin.struktur-pemerintahan.store') }}" class="max-w-3xl space-y-6 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-7">
    @csrf
    @if($official)
        @method('PUT')
    @endif

    {{-- Alert jika ada error umum atau error Kepala Desa --}}
    @if($errors->has('is_kepala_desa') || $errors->has('jabatan'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-rose-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <p class="font-bold">Gagal Menyimpan Data</p>
                    <p class="mt-1 text-xs text-rose-700 leading-relaxed">
                        {{ $errors->first('is_kepala_desa') ?: $errors->first('jabatan') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Banner Informasi jika Kepala Desa sudah ada --}}
    @if($anotherHeadExists)
        <div class="rounded-xl border border-amber-200 bg-amber-50/80 p-4 text-sm text-amber-900">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div>
                    <p class="font-bold">Jabatan Kepala Desa sudah terisi</p>
                    <p class="mt-1 text-xs text-amber-800 leading-relaxed">
                        Saat ini jabatan Kepala Desa telah diisi oleh <strong>{{ $existingHead->nama }}</strong>. Dalam database hanya boleh terdapat <strong>1 data Kepala Desa</strong>.
                    </p>
                    <div class="mt-2.5">
                        <a href="{{ route('admin.struktur-pemerintahan.edit', $existingHead) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-700 bg-white border border-amber-300 px-3 py-1.5 rounded-lg shadow-2xs hover:bg-amber-100/60 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Data {{ $existingHead->nama }} (Kepala Desa)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="block text-sm font-semibold text-gray-700">
                Nama Lengkap <span class="text-rose-500">*</span>
            </label>
            <input name="nama" required maxlength="255" value="{{ old('nama', $official?->nama) }}" placeholder="Contoh: Budi Santoso, S.Sos." class="mt-1.5 w-full rounded-xl border border-gray-200 px-3.5 py-2.5 text-sm font-normal focus:border-brand-600 focus:ring-1 focus:ring-brand-600">
            @error('nama')
                <span class="mt-1 block text-xs text-rose-600 font-medium">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">
                Jabatan / Posisi <span class="text-rose-500">*</span>
            </label>
            <input name="jabatan" id="official-role" required maxlength="255" value="{{ old('jabatan', $official?->jabatan) }}" placeholder="Contoh: Sekretaris Desa" class="mt-1.5 w-full rounded-xl border border-gray-200 px-3.5 py-2.5 text-sm font-normal focus:border-brand-600 focus:ring-1 focus:ring-brand-600">
            <span id="role-warning" class="mt-1 hidden text-xs text-amber-700 font-medium"></span>
            @error('jabatan')
                <span class="mt-1 block text-xs text-rose-600 font-medium">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700">
            Deskripsi Singkat <span class="text-xs text-gray-400 font-normal">(opsional)</span>
        </label>
        <textarea name="deskripsi" rows="3" maxlength="3000" placeholder="Tuliskan keterangan tambahan bila ada..." class="mt-1.5 w-full rounded-xl border border-gray-200 px-3.5 py-2.5 text-sm font-normal focus:border-brand-600 focus:ring-1 focus:ring-brand-600">{{ old('deskripsi', $official?->deskripsi) }}</textarea>
        @error('deskripsi')
            <span class="mt-1 block text-xs text-rose-600 font-medium">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700">
            Foto Perangkat Desa
            <span class="block text-xs font-normal text-gray-500 mt-0.5">Format: JPG, JPEG, PNG, WebP (Rasio portrait, maksimal 5 MB)</span>
        </label>
        <input type="file" name="foto" id="official-photo" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full rounded-xl border border-gray-200 p-2 text-sm font-normal text-gray-600 file:mr-3 file:rounded-lg file:border-0 file:bg-gray-100 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-gray-700 hover:file:bg-gray-200">
        @error('foto')
            <span class="mt-1 block text-xs text-rose-600 font-medium">{{ $message }}</span>
        @enderror

        {{-- Preview Foto --}}
        <div class="mt-3 flex items-center gap-4">
            <div class="w-[100px] h-[125px] rounded-lg border border-gray-200 bg-gray-50 overflow-hidden flex items-center justify-center shadow-2xs shrink-0">
                <img id="official-photo-preview" src="{{ $official?->foto ? asset('storage/'.$official->foto) : '' }}" alt="Pratinjau foto" class="{{ $official?->foto ? '' : 'hidden' }} w-full h-full object-contain">
                <span id="official-photo-placeholder" class="{{ $official?->foto ? 'hidden' : '' }} text-4xl text-brand-700">♙</span>
            </div>
            <div class="text-xs text-gray-500">
                <p class="font-semibold text-gray-700">Pratinjau Foto</p>
                <p class="mt-0.5 text-gray-400">Foto akan ditampilkan dengan proporsi portrait tanpa terpotong (object-fit: contain).</p>
            </div>
        </div>
        @if($official?->foto)
            <label class="mt-3 inline-flex items-center gap-2 text-sm font-medium text-rose-700">
                <input type="checkbox" name="hapus_foto" id="remove-official-photo" value="1" @checked(old('hapus_foto')) class="rounded border-rose-300 text-rose-600 focus:ring-rose-500">
                Hapus foto saat disimpan
            </label>
        @endif
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="block text-sm font-semibold text-gray-700">
                Urutan Tampilan <span class="text-rose-500">*</span>
            </label>
            <input type="number" name="urutan" min="0" max="65535" required value="{{ old('urutan', $official?->urutan ?? 0) }}" class="mt-1.5 w-full rounded-xl border border-gray-200 px-3.5 py-2.5 text-sm font-normal focus:border-brand-600 focus:ring-1 focus:ring-brand-600">
            <span class="mt-1 block text-xs text-gray-400">Angka lebih kecil tampil lebih dulu (0, 1, 2, ...).</span>
            @error('urutan')
                <span class="mt-1 block text-xs text-rose-600 font-medium">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">
                Status Publikasi <span class="text-rose-500">*</span>
            </label>
            <select name="status" required class="mt-1.5 w-full rounded-xl border border-gray-200 px-3.5 py-2.5 text-sm font-normal focus:border-brand-600 focus:ring-1 focus:ring-brand-600">
                <option value="1" @selected((string) old('status', (int) ($official?->status ?? true)) === '1')>Aktif — tampil di halaman Profil</option>
                <option value="0" @selected((string) old('status', (int) ($official?->status ?? true)) === '0')>Nonaktif — hanya di Admin</option>
            </select>
            @error('status')
                <span class="mt-1 block text-xs text-rose-600 font-medium">{{ $message }}</span>
            @enderror
        </div>
    </div>

    {{-- Bagian Penanda Kepala Desa --}}
    @if($anotherHeadExists)
        <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-4 text-sm text-gray-500">
            <label class="flex items-start gap-3 cursor-not-allowed">
                <input type="checkbox" disabled class="mt-0.5 rounded border-gray-300 text-gray-400 cursor-not-allowed">
                <div>
                    <span class="font-semibold text-gray-600">Tetapkan sebagai Kepala Desa</span>
                    <span class="mt-1 block text-xs text-gray-400">Pilihan dinonaktifkan karena jabatan Kepala Desa saat ini sudah terisi oleh {{ $existingHead->nama }}.</span>
                </div>
            </label>
        </div>
    @else
        <label class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50/60 p-4 text-sm font-semibold text-amber-950 cursor-pointer hover:bg-amber-50 transition">
            <input type="hidden" name="is_kepala_desa" value="0">
            <input type="checkbox" name="is_kepala_desa" id="official-head" value="1" @checked((bool) old('is_kepala_desa', $official?->is_kepala_desa ?? false)) class="mt-0.5 rounded border-amber-300 text-brand-700 focus:ring-brand-500">
            <div>
                <span class="font-bold text-gray-900">Tetapkan sebagai Kepala Desa</span>
                <small class="mt-1 block font-normal text-xs text-amber-800">Menetapkan perangkat ini sebagai Kepala Desa yang ditampilkan di posisi khusus paling atas halaman Profil Desa.</small>
            </div>
        </label>
    @endif
    @error('is_kepala_desa')
        <span class="mt-1 block text-xs text-rose-600 font-medium">{{ $message }}</span>
    @enderror

    <div class="flex gap-3 pt-3 border-t border-gray-100">
        <button type="submit" class="rounded-xl bg-brand-700 px-6 py-2.5 text-sm font-bold text-white shadow-xs hover:bg-brand-800 transition">
            Simpan Perangkat Desa
        </button>
        <a href="{{ route('admin.struktur-pemerintahan.index') }}" class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-bold text-gray-600 hover:bg-gray-50 transition">
            Batal
        </a>
    </div>
</form>
@endsection

@push('scripts')
<script>
    const photoInput = document.getElementById('official-photo');
    const photoPreview = document.getElementById('official-photo-preview');
    const photoPlaceholder = document.getElementById('official-photo-placeholder');
    const removePhotoCheckbox = document.getElementById('remove-official-photo');
    const roleInput = document.getElementById('official-role');
    const headCheckbox = document.getElementById('official-head');
    const roleWarning = document.getElementById('role-warning');
    const anotherHeadExists = {{ $anotherHeadExists ? 'true' : 'false' }};

    if (photoInput) {
        photoInput.addEventListener('change', () => {
            const photo = photoInput.files[0];
            if (!photo) return;
            photoPreview.src = URL.createObjectURL(photo);
            photoPreview.classList.remove('hidden');
            photoPlaceholder.classList.add('hidden');
            if (removePhotoCheckbox) removePhotoCheckbox.checked = false;
        });
    }

    if (removePhotoCheckbox) {
        removePhotoCheckbox.addEventListener('change', () => {
            if (removePhotoCheckbox.checked && !photoInput.files.length) {
                photoPreview.classList.add('hidden');
                photoPlaceholder.classList.remove('hidden');
            } else if (!removePhotoCheckbox.checked && !photoInput.files.length) {
                photoPreview.classList.remove('hidden');
                photoPlaceholder.classList.add('hidden');
            }
        });
    }

    if (headCheckbox) {
        headCheckbox.addEventListener('change', (event) => {
            if (event.target.checked) {
                roleInput.value = 'Kepala Desa';
            }
        });
    }

    if (roleInput && anotherHeadExists) {
        roleInput.addEventListener('input', () => {
            if (roleInput.value.trim().toLowerCase() === 'kepala desa') {
                roleWarning.textContent = 'Peringatan: Jabatan Kepala Desa sudah terisi oleh data lain.';
                roleWarning.classList.remove('hidden');
            } else {
                roleWarning.classList.add('hidden');
            }
        });
    }
</script>
@endpush
