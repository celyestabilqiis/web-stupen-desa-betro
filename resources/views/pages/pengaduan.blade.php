<!DOCTYPE html>
<html class="scroll-smooth" lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pengaduan Warga - Website Resmi Desa Betro</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet"/>
  <script src="{{ asset('assets/js/tailwind-config.js') }}"></script>
</head>
<body class="antialiased text-gray-800 bg-white" data-page="pengaduan">
  <div class="gov-topbar"><div class="gov-topbar-inner"><span class="gov-topbar-label"><span class="gov-status-dot"></span>PORTAL DIGITAL DESA BETRO</span><span class="gov-topbar-meta">Kecamatan Kemlagi &middot; Kabupaten Mojokerto &middot; Jawa Timur</span></div></div>
  <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-2xs site-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"><div class="flex items-center justify-between h-20">
      <a class="flex items-center gap-3.5 group" href="{{ route('pages.home') }}"><div class="village-logo-frame" aria-label="Logo Desa Betro"><img alt="Logo Desa Betro" class="village-logo-image" src="{{ asset('assets/images/logo-betro.png') }}"/></div><div><span class="block font-extrabold text-brand-700 text-lg sm:text-xl leading-tight">DESA BETRO</span><span class="block text-xs font-medium text-gray-500">Kecamatan Kemlagi &bull; Kabupaten Mojokerto</span></div></a>
      <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold text-gray-600" data-primary-nav="true"><a class="hover:text-brand-700 transition" href="{{ route('pages.home') }}">Beranda</a><a class="hover:text-brand-700 transition" href="{{ route('pages.profile') }}">Profil Desa</a><a class="hover:text-brand-700 transition" href="{{ route('pages.potensi') }}">Potensi Desa</a><a class="hover:text-brand-700 transition" href="{{ route('pages.informasi') }}">Informasi</a><a class="nav-link-active transition" aria-current="page" href="{{ route('pages.pengaduan') }}">Pengaduan</a></nav>
      <button class="lg:hidden p-2 rounded-xl text-gray-600" id="mobileMenuBtn" aria-controls="mobileMenu" aria-expanded="false" aria-label="Buka menu navigasi"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round"/></svg></button>
    </div></div>
    <div class="hidden lg:hidden border-t border-gray-100 bg-white px-4 pt-3 pb-6 space-y-2 shadow-lg" data-mobile-nav="true" id="mobileMenu"><a class="block px-3.5 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 font-medium" href="{{ route('pages.home') }}">Beranda</a><a class="block px-3.5 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 font-medium" href="{{ route('pages.profile') }}">Profil Desa</a><a class="block px-3.5 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 font-medium" href="{{ route('pages.potensi') }}">Potensi Desa</a><a class="block px-3.5 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 font-medium" href="{{ route('pages.informasi') }}">Informasi</a><a class="block px-3.5 py-2.5 rounded-xl bg-brand-50 text-brand-700 font-bold" aria-current="page" href="{{ route('pages.pengaduan') }}">Pengaduan</a></div>
  </header>

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
        <div class="hidden mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-800" id="pengaduanSuccess" role="status"><strong>Pengaduan berhasil dikirim.</strong><br/>Terima kasih, laporan Anda telah diterima untuk proses simulasi.</div>
        <form class="space-y-5" data-demo-submit="true">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5"><div><label class="block text-sm font-bold text-gray-700 mb-2" for="nama">Nama Lengkap *</label><input id="nama" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-100" placeholder="Nama lengkap Anda" required/></div><div><label class="block text-sm font-bold text-gray-700 mb-2" for="telepon">Nomor WhatsApp / HP *</label><input id="telepon" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-100" placeholder="08xxxxxxxxxx" required type="tel"/></div></div>
          <div><label class="block text-sm font-bold text-gray-700 mb-2" for="jenis">Jenis Layanan / Pengaduan *</label><select id="jenis" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-100"><option>Pengajuan Surat Keterangan</option><option>Laporan Pengaduan / Aspirasi Warga</option><option>Pertanyaan Umum</option></select></div>
          <div><label class="block text-sm font-bold text-gray-700 mb-2" for="pesan">Pesan / Detail Pengaduan *</label><textarea id="pesan" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brand-600 focus:ring-2 focus:ring-brand-100" placeholder="Tuliskan detail laporan, lokasi kejadian, atau permohonan Anda..." required rows="5"></textarea></div>
          <div><label class="block text-sm font-bold text-gray-700 mb-2" for="pengaduanBukti">Foto Bukti <span class="font-normal text-gray-400">(opsional)</span></label><label class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border-2 border-dashed border-gray-200 px-4 py-5 text-sm font-semibold text-gray-600 hover:border-brand-400 hover:bg-brand-50/40" for="pengaduanBukti"><svg class="h-5 w-5 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Pilih atau unggah foto</label><input accept="image/jpeg,image/png,image/webp" class="hidden" id="pengaduanBukti" multiple name="bukti" type="file"/><p class="mt-2 text-xs text-gray-400">Maksimal 3 foto, JPG/PNG/WebP, ukuran masing-masing 5 MB.</p><p class="mt-1 hidden text-xs font-semibold text-red-600" id="pengaduanBuktiError" role="alert"></p><div class="mt-2 grid grid-cols-3 gap-2" id="pengaduanPreview" aria-live="polite"></div></div>
          <button class="w-full py-3.5 bg-brand-700 hover:bg-brand-800 text-white font-bold rounded-xl transition shadow-sm" type="submit">Kirim Pengaduan</button>
        </form>
      </div>
      <aside class="space-y-5"><div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6"><h3 class="font-extrabold text-gray-900">Informasi Pengaduan</h3><div class="mt-5 space-y-5"><div class="flex gap-3"><div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-700 flex-none flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div><div><p class="text-sm font-bold">Jam Layanan</p><p class="text-xs text-gray-500 mt-1">Senin–Sabtu, 08.00–15.00 WIB</p></div></div><div class="flex gap-3"><div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-700 flex-none flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div><div><p class="text-sm font-bold">Data Dijaga Kerahasiaannya</p><p class="text-xs text-gray-500 mt-1">Identitas dan bukti digunakan untuk proses tindak lanjut.</p></div></div></div></div><div class="rounded-2xl bg-brand-800 text-white p-6"><p class="text-xs font-bold uppercase tracking-wider text-brand-200">Butuh Bantuan?</p><h3 class="mt-2 font-extrabold">Hubungi Kantor Desa Betro</h3><p class="mt-3 text-sm text-brand-100 leading-relaxed">Datang langsung ke kantor desa pada jam kerja untuk mendapat bantuan lebih lanjut.</p></div></aside>
    </div></section>
  </main>
  <footer class="bg-[#032015] text-white py-6"><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between gap-2 text-xs text-brand-100/80"><p>&copy; <span data-current-year></span> Pemerintah Desa Betro</p><p>Kecamatan Kemlagi, Kabupaten Mojokerto</p></div></footer>
  <script defer src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
