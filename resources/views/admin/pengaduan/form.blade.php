@extends('admin.layouts.app')

@section('title', $pengaduan ? 'Edit Pengaduan' : 'Tambah Pengaduan')
@section('page-title', $pengaduan ? 'Edit Pengaduan' : 'Tambah Pengaduan')
@section('page-desc', 'Lengkapi identitas pelapor dan informasi laporan')

@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ $pengaduan ? route('admin.pengaduan.update', $pengaduan) : route('admin.pengaduan.store') }}" class="max-w-3xl space-y-5 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-7">
    @csrf @if($pengaduan) @method('PUT') @endif
    <div class="grid gap-4 sm:grid-cols-2"><label class="text-sm font-semibold">Nama lengkap<input name="nama" required maxlength="255" value="{{ old('nama', $pengaduan?->nama) }}" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label><label class="text-sm font-semibold">Nomor WhatsApp / HP<input name="telepon" required value="{{ old('telepon', $pengaduan?->telepon) }}" class="mt-2 w-full rounded-xl border-gray-200 text-sm"></label></div>
    <label class="block text-sm font-semibold">Jenis layanan / pengaduan<select name="jenis" required class="mt-2 w-full rounded-xl border-gray-200 text-sm">@unless($pengaduan)<option value="" disabled selected>Pilih Jenis Layanan / Pengaduan</option>@endunless @foreach($jenisPilihan as $jenis)<option value="{{ $jenis }}" @selected(old('jenis', $pengaduan?->jenis) === $jenis)>{{ $jenis }}</option>@endforeach</select></label>
    <label class="block text-sm font-semibold">Pesan / detail pengaduan<textarea name="pesan" required rows="6" class="mt-2 w-full rounded-xl border-gray-200 text-sm">{{ old('pesan', $pengaduan?->pesan) }}</textarea></label>
    <label class="block text-sm font-semibold">Status<select name="status" @required($pengaduan) class="mt-2 w-full rounded-xl border-gray-200 text-sm">@foreach(\App\Models\Pengaduan::STATUSES as $status)<option value="{{ $status }}" @selected(old('status', $pengaduan?->status ?? 'baru') === $status)>{{ ucfirst($status) }}</option>@endforeach</select></label>
    @if($pengaduan && count($pengaduan->foto ?? []))<div><p class="text-sm font-semibold">Bukti tersimpan</p><div class="mt-2 grid grid-cols-3 gap-3">@foreach($pengaduan->foto as $index => $foto)<label class="text-xs"><img src="{{ route('admin.pengaduan.photo', [$pengaduan, $index]) }}" class="aspect-square w-full rounded-xl object-cover"><span class="mt-1 block"><input type="checkbox" name="hapus_foto[]" value="{{ $foto }}"> Hapus foto</span></label>@endforeach</div></div>@endif
    <label class="block text-sm font-semibold">{{ $pengaduan ? 'Tambah foto bukti' : 'Foto bukti (opsional)' }}<input type="file" name="bukti[]" accept="image/jpeg,image/png,image/webp" multiple class="mt-2 block w-full text-sm"><span class="mt-1 block text-xs font-normal text-gray-500">JPG, PNG, WebP; maksimal 5 MB per foto, total maksimal 3 foto.</span></label>
    <div class="flex gap-3"><button class="rounded-xl bg-brand-700 px-5 py-3 text-sm font-bold text-white">Simpan</button><a href="{{ route('admin.pengaduan.index') }}" class="rounded-xl border border-gray-200 px-5 py-3 text-sm font-bold text-gray-600">Batal</a></div>
</form>
@endsection
