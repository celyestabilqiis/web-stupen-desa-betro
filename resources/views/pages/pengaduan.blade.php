@extends('layouts.app')

@section('title', 'Pengaduan Warga - Website Resmi Desa Betro')
@section('description', 'Sampaikan laporan, keluhan, saran, atau permintaan layanan kepada Pemerintah Desa Betro dengan mudah dan tertib.')
@section('page-key', 'pengaduan')

@section('content')
<main class="bg-[#f7faf7] min-h-[calc(100vh-180px)]">
  <section class="relative min-h-[340px] overflow-hidden bg-brand-950 text-white sm:min-h-[360px]">
    <img src="{{ asset('assets/images/potensi-sawah.jpg') }}" alt="Pemandangan perdesaan Desa Betro yang asri" class="absolute inset-0 h-full w-full object-cover object-center"/>
    <div class="absolute inset-0 bg-gradient-to-r from-brand-950/95 via-brand-900/80 to-brand-900/20"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-brand-950/45 via-transparent to-black/10"></div>
    <div class="absolute -right-16 -top-20 h-72 w-72 rounded-full border border-white/20"></div>
    <div class="absolute -right-4 -top-8 h-48 w-48 rounded-full border border-brand-200/25"></div>
    <div class="relative mx-auto flex min-h-[340px] max-w-7xl items-center px-4 py-12 sm:min-h-[360px] sm:px-6 lg:px-8">
     <div class="max-w-2xl">
      <div class="mb-5 flex items-center gap-3 text-xs font-extrabold uppercase tracking-[0.22em] text-brand-100"><span class="h-px w-9 bg-brand-200"></span>Layanan Aspirasi Warga</div>
      <h1 class="text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">Pengaduan Desa Betro</h1>
      <p class="mt-5 max-w-xl text-sm leading-7 text-white/85 sm:text-base">Sampaikan laporan, keluhan, saran, atau permintaan layanan kepada Pemerintah Desa Betro dengan mudah dan tertib.</p>
     </div>
    </div>
  </section>
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14"><div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm p-5 sm:p-8">
      <div class="flex items-center gap-3 mb-6"><div class="w-11 h-11 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div><div><h2 class="text-xl font-extrabold text-gray-900">Form Pengaduan Warga</h2><p class="text-xs text-gray-500 mt-1">Kolom bertanda wajib harus diisi</p></div></div>
      @if (session('success'))<div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-800" role="status">{{ session('success') }}</div>@endif
      @if ($errors->any())<div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800" role="alert"><ul class="list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
      <form class="space-y-5" action="{{ route('pages.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5"><div><label class="block text-sm font-bold text-gray-700 mb-2" for="nama">Nama Lengkap *</label><input name="nama" value="{{ old('nama') }}" id="nama" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-100" placeholder="Nama lengkap Anda" required/></div><div><label class="block text-sm font-bold text-gray-700 mb-2" for="telepon">Nomor WhatsApp / HP *</label><input name="telepon" value="{{ old('telepon') }}" id="telepon" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-100" placeholder="08xxxxxxxxxx" required type="tel"/></div></div>
        <div><label class="block text-sm font-bold text-gray-700 mb-2" for="jenis">Jenis Layanan / Pengaduan *</label><select name="jenis" id="jenis" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-100"><option value="" disabled selected>Pilih Jenis Layanan / Pengaduan</option><option value="Laporan Pengaduan / Aspirasi Warga" @selected(old('jenis') === 'Laporan Pengaduan / Aspirasi Warga')>Laporan Pengaduan / Aspirasi Warga</option><option value="Pertanyaan Umum" @selected(old('jenis') === 'Pertanyaan Umum')>Pertanyaan Umum</option></select></div>
        <div><label class="block text-sm font-bold text-gray-700 mb-2" for="pesan">Pesan / Detail Pengaduan *</label><textarea name="pesan" id="pesan" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-100" placeholder="Tuliskan detail laporan, lokasi kejadian, atau permohonan Anda..." required rows="5">{{ old('pesan') }}</textarea></div>
        <div><label class="block text-sm font-bold text-gray-700 mb-2" for="pengaduanBukti">Foto Bukti <span class="font-normal text-gray-400">(opsional)</span></label><label class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border-2 border-dashed border-gray-200 px-4 py-5 text-sm font-semibold text-gray-600 hover:border-brand-400 hover:bg-brand-50/40" for="pengaduanBukti"><svg class="h-5 w-5 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Pilih atau unggah foto</label><input accept="image/jpeg,image/png,image/webp" class="hidden" id="pengaduanBukti" multiple name="bukti[]" type="file"/><p class="mt-2 text-xs text-gray-400">Maksimal 3 foto, JPG/PNG/WebP, ukuran masing-masing 5 MB.</p><p class="mt-1 hidden text-xs font-semibold text-red-600" id="pengaduanBuktiError" role="alert"></p><div class="mt-2 grid grid-cols-3 gap-2" id="pengaduanPreview" aria-live="polite"></div></div>
        <button class="w-full py-3.5 bg-brand-700 hover:bg-brand-800 text-white font-bold rounded-xl transition shadow-sm" type="submit">Kirim Pengaduan</button>
      </form>
    </div>
    <aside class="space-y-5"><div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6"><h3 class="font-extrabold text-gray-900">Informasi Pengaduan</h3><div class="mt-5 space-y-5"><div class="flex gap-3"><div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-700 flex-none flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div><div><p class="text-sm font-bold">Jam Layanan</p><p class="text-xs text-gray-500 mt-1">Senin–Sabtu, 08.00–15.00 WIB</p></div></div><div class="flex gap-3"><div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-700 flex-none flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div><div><p class="text-sm font-bold">Data Dijaga Kerahasiaannya</p><p class="text-xs text-gray-500 mt-1">Identitas dan bukti digunakan untuk proses tindak lanjut.</p></div></div></div></div><div class="rounded-2xl bg-brand-800 text-white p-6"><p class="text-xs font-bold uppercase tracking-wider text-brand-200">Butuh Bantuan?</p><h3 class="mt-2 font-extrabold">Hubungi Kantor Desa Betro</h3><p class="mt-3 text-sm text-brand-100 leading-relaxed">Datang langsung ke kantor desa pada jam kerja untuk mendapat bantuan lebih lanjut.</p></div></aside>
  </div></section>
</main>
@endsection
