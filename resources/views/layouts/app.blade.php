<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Website Resmi Desa Betro')</title>
    <meta name="description" content="@yield('description', 'Portal informasi, layanan, dan kegiatan Pemerintah Desa Betro.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/tailwind-config.js') }}"></script>
    @stack('head')
</head>
<body class="antialiased text-gray-800 bg-white selection:bg-brand-600 selection:text-white" data-page="@yield('page-key', 'home')">
<div class="gov-topbar">
   <div class="gov-topbar-inner">
    <span class="gov-topbar-label">
     <span class="gov-status-dot">
     </span>
     PORTAL DIGITAL DESA BETRO
    </span>
    <span class="gov-topbar-meta">
     Kecamatan Kemlagi &middot; Kabupaten Mojokerto &middot; Jawa Timur
    </span>
   </div>
  </div>
  <header class="sticky top-0 z-50 site-header" id="siteHeader">
   <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-20">
     <!-- KIRI: Logo Circle + Shield Icon + Title -->
     <a class="flex items-center gap-3.5 group" href="{{ route('pages.home') }}#beranda">
      <!-- Logo Desa dengan animasi putar elegan -->
      <div class="village-logo-frame" aria-label="Logo Desa Betro">
       <img alt="Logo Desa Betro" class="village-logo-image" src="{{ asset('assets/images/logo-betro.png') }}"/>
      </div>
      <div>
       <span class="block font-extrabold text-white text-lg sm:text-xl leading-tight tracking-tight">
        DESA BETRO
       </span>
       <span class="block text-xs font-medium text-white/70">
        Kecamatan Kemlagi &bull; Kabupaten Mojokerto
       </span>
      </div>
     </a>
     <!-- TENGAH: Menu Navigasi Horizontal Desktop -->
     @php
      $isHome = request()->routeIs('pages.home');
      $isProfile = request()->routeIs('pages.profile');
      $isPotensi = request()->routeIs('pages.potensi');
      $isWilayah = request()->routeIs('pages.wilayah') || request()->is('informasi/wilayah*');
      $isArsip = request()->routeIs('pages.arsip.*') || request()->is('arsip-dokumentasi*');
      $isInformasi = request()->routeIs('pages.informasi', 'pages.wilayah', 'pages.arsip.*') || request()->is('informasi*', 'arsip-dokumentasi*');
      $isPengaduan = request()->routeIs('pages.pengaduan');
     @endphp
     <nav class="hidden lg:flex items-center gap-7 text-sm font-semibold text-white/90" data-primary-nav="true">
      <a class="{{ $isHome ? 'nav-link-active' : 'hover:text-white' }} transition" @if($isHome) aria-current="page" @endif href="{{ route('pages.home') }}#beranda">
       Beranda
      </a>
      <a class="{{ $isProfile ? 'nav-link-active' : 'hover:text-white' }} transition" @if($isProfile) aria-current="page" @endif href="{{ route('pages.profile') }}">
       Profil Desa
      </a>
      <a class="{{ $isPotensi ? 'nav-link-active' : 'hover:text-white' }} transition" @if($isPotensi) aria-current="page" @endif href="{{ route('pages.potensi') }}">
       Potensi Desa
      </a>

      <!-- Menu Informasi dengan Dropdown Submenu -->
      <div class="relative group nav-dropdown py-2">
       <a class="{{ $isInformasi ? 'nav-link-active' : 'hover:text-white' }} transition inline-flex items-center gap-1.5" href="{{ route('pages.informasi') }}" id="navDropdownInformasi" aria-haspopup="true" aria-expanded="false" @if($isInformasi) aria-current="page" @endif>
        <span>Informasi</span>
        <svg class="w-3.5 h-3.5 text-white/60 group-hover:text-white group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
        </svg>
       </a>

       <!-- Dropdown Menu Desktop -->
       <div class="dropdown-menu absolute left-0 top-full pt-1.5 w-60 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto group-focus-within:opacity-100 group-focus-within:pointer-events-auto transition-all duration-150 ease-out transform group-hover:translate-y-0 -translate-y-1 z-50">
        <div class="bg-white rounded-lg shadow-md border border-gray-100 py-1.5 ring-1 ring-black/5">
         <a href="{{ route('pages.wilayah') }}" class="dropdown-item {{ $isWilayah ? 'nav-link-active' : '' }}" @if($isWilayah) aria-current="page" @endif>Informasi Wilayah</a>
         <a href="{{ route('pages.arsip.index') }}" class="dropdown-item {{ $isArsip ? 'nav-link-active' : '' }}" @if($isArsip) aria-current="page" @endif>Arsip &amp; Dokumentasi Desa</a>
        </div>
       </div>
      </div>

      <a class="{{ $isPengaduan ? 'nav-link-active' : 'hover:text-white' }} transition" @if($isPengaduan) aria-current="page" @endif href="{{ route('pages.pengaduan') }}">
       Pengaduan
      </a>

      @auth
       <a href="{{ route('admin.dashboard') }}" class="nav-admin-btn ml-1">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
        </svg>
        <span>Admin Panel</span>
       </a>
      @endauth
     </nav>
     <!-- Mobile Navigation Toggle -->
     <div class="lg:hidden flex items-center">
      <button aria-controls="mobileMenu" aria-expanded="false" aria-label="Buka menu navigasi" class="p-2 rounded-xl text-white/90 hover:text-white hover:bg-white/15 focus:outline-none" id="mobileMenuBtn">
       <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
        </path>
       </svg>
      </button>
     </div>
    </div>
   </div>
   <!-- Mobile Nav Drawer -->
   <div class="hidden lg:hidden border-t border-gray-100 bg-white px-4 pt-3 pb-6 space-y-2 shadow-lg" data-mobile-nav="true" id="mobileMenu">
    <a class="block px-3.5 py-2.5 rounded-xl {{ $isHome ? 'bg-brand-50 text-brand-700 font-bold nav-link-active' : 'text-gray-600 hover:bg-gray-50 font-medium' }}" @if($isHome) aria-current="page" @endif href="{{ route('pages.home') }}#beranda">
     Beranda
    </a>
    <a class="block px-3.5 py-2.5 rounded-xl {{ $isProfile ? 'bg-brand-50 text-brand-700 font-bold nav-link-active' : 'text-gray-600 hover:bg-gray-50 font-medium' }}" @if($isProfile) aria-current="page" @endif href="{{ route('pages.profile') }}">
     Profil Desa
    </a>
    <a class="block px-3.5 py-2.5 rounded-xl {{ $isPotensi ? 'bg-brand-50 text-brand-700 font-bold nav-link-active' : 'text-gray-600 hover:bg-gray-50 font-medium' }}" @if($isPotensi) aria-current="page" @endif href="{{ route('pages.potensi') }}">
     Potensi Desa
    </a>

    <!-- Menu Informasi Mobile dengan Toggle Submenu -->
    <div>
     <div class="flex items-center justify-between rounded-xl {{ $isInformasi ? 'bg-brand-50' : 'hover:bg-gray-50' }}">
      <a class="mobile-parent-link flex-grow px-3.5 py-2.5 {{ $isInformasi ? 'text-brand-700 font-bold nav-link-active' : 'text-gray-600 font-medium' }}" href="{{ route('pages.informasi') }}" @if($isInformasi) aria-current="page" @endif>
       Informasi
      </a>
      <button type="button" class="p-2.5 text-gray-500 hover:text-white focus:outline-none" id="mobileDropdownBtn" aria-expanded="{{ $isInformasi ? 'true' : 'false' }}" aria-label="Buka submenu Informasi">
       <svg class="w-4 h-4 transform transition-transform duration-200 {{ $isInformasi ? 'rotate-180' : '' }}" id="mobileDropdownIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
       </svg>
      </button>
     </div>
     <!-- Submenu List Mobile -->
     <div class="{{ $isInformasi ? '' : 'hidden' }} pl-3 pr-1 py-1.5 space-y-1 bg-brand-50/30 rounded-lg mt-1 border-l-2 border-brand-400" id="mobileSubmenu">
      <a class="block px-3.5 py-2 rounded-md text-sm {{ $isWilayah ? 'bg-white text-brand-700 font-bold nav-link-active shadow-2xs' : 'font-medium text-gray-700 hover:text-white hover:bg-white' }} transition" href="{{ route('pages.wilayah') }}" @if($isWilayah) aria-current="page" @endif>
       Informasi Wilayah
      </a>
      <a class="block px-3.5 py-2 rounded-md text-sm {{ $isArsip ? 'bg-white text-brand-700 font-bold nav-link-active shadow-2xs' : 'font-medium text-gray-700 hover:text-white hover:bg-white' }} transition" href="{{ route('pages.arsip.index') }}" @if($isArsip) aria-current="page" @endif>
       Arsip &amp; Dokumentasi Desa
      </a>
     </div>
    </div>

    <a class="block px-3.5 py-2.5 rounded-xl {{ $isPengaduan ? 'bg-brand-50 text-brand-700 font-bold nav-link-active' : 'text-gray-600 hover:bg-gray-50 font-medium' }}" @if($isPengaduan) aria-current="page" @endif href="{{ route('pages.pengaduan') }}">
     Pengaduan
    </a>

    @auth
     <div class="pt-3 mt-2 border-t border-gray-100">
      <a class="nav-admin-btn-mobile" href="{{ route('admin.dashboard') }}">
       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
       </svg>
       <span>Admin Panel</span>
      </a>
     </div>
    @endauth
   </div>
  </header>
    @yield('content')
<footer class="village-footer text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-9 border-b border-brand-900/60 pb-9 sm:grid-cols-2 lg:grid-cols-5 lg:gap-8">
            <section aria-labelledby="footer-identity-title">
                <div class="mb-4 flex items-center gap-3">
                    <img src="{{ asset('assets/images/logo-betro.png') }}" alt="Lambang Desa Betro" class="h-12 w-12 rounded-full border border-brand-400/50 bg-white object-contain p-1">
                    <div><h2 id="footer-identity-title" class="text-sm font-extrabold tracking-wide text-white">PEMERINTAH DESA BETRO</h2><p class="mt-1 text-xs text-brand-100/75">Portal resmi desa</p></div>
                </div>
                <p class="text-sm leading-relaxed text-brand-100/80">Kecamatan Kemlagi<br>Kabupaten Mojokerto<br>Provinsi Jawa Timur</p>
                <p class="mt-3 text-sm leading-relaxed text-brand-100/70">Informasi desa, layanan, dan potensi lokal Desa Betro.</p>
            </section>

            <section aria-labelledby="footer-contact-title">
                <h2 id="footer-contact-title" class="mb-4 text-xs font-extrabold uppercase tracking-[.14em] text-[#e5c36f]">Hubungi Kami</h2>
                <ul class="space-y-3 text-sm text-brand-100/80">
                    <li class="flex items-start gap-3"><svg class="mt-0.5 h-4 w-4 flex-none text-[#e5c36f]" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M3 5a2 2 0 012-2h3l2 5-2 1a14 14 0 007 7l1-2 5 2v3a2 2 0 01-2 2C10 21 3 14 3 5z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Telepon/WhatsApp<br><span class="text-xs text-brand-100/60">Belum tersedia</span></span></li>
                    <li class="flex items-start gap-3"><svg class="mt-0.5 h-4 w-4 flex-none text-[#e5c36f]" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2" stroke-width="1.8"/><path d="m4 7 8 6 8-6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Email resmi<br><span class="text-xs text-brand-100/60">Belum tersedia</span></span></li>
                    <li class="flex items-start gap-3"><svg class="mt-0.5 h-4 w-4 flex-none text-[#e5c36f]" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1116 0z" stroke-width="1.8"/><circle cx="12" cy="10" r="2.5" stroke-width="1.8"/></svg><span>Alamat wilayah<br><span class="text-xs text-brand-100/60">Desa Betro, Kecamatan Kemlagi, Kabupaten Mojokerto, Jawa Timur</span></span></li>
                </ul>
            </section>

            <nav aria-labelledby="footer-quick-links-title">
                <h2 id="footer-quick-links-title" class="mb-4 text-xs font-extrabold uppercase tracking-[.14em] text-[#e5c36f]">Tautan Cepat</h2>
                <ul class="space-y-3 text-sm font-medium text-brand-100/80">
                    <li><a class="transition hover:text-white" href="{{ route('pages.home') }}">Beranda</a></li>
                    <li><a class="transition hover:text-white" href="{{ route('pages.profile') }}">Profil Desa</a></li>
                    <li><a class="transition hover:text-white" href="{{ route('pages.potensi') }}">Potensi Desa</a></li>
                </ul>
            </nav>

            <nav aria-labelledby="footer-information-title">
                <h2 id="footer-information-title" class="mb-4 text-xs font-extrabold uppercase tracking-[.14em] text-[#e5c36f]">Informasi</h2>
                <ul class="space-y-3 text-sm font-medium text-brand-100/80">
                    <li><a class="transition hover:text-white" href="{{ route('pages.informasi') }}">Informasi Desa</a></li>
                    <li><a class="transition hover:text-white" href="{{ route('pages.arsip.index') }}">Arsip &amp; Dokumentasi Desa</a></li>
                </ul>
            </nav>

            <section aria-labelledby="footer-map-title">
                <h2 id="footer-map-title" class="mb-4 text-xs font-extrabold uppercase tracking-[.14em] text-[#e5c36f]">Peta Wilayah</h2>
                <a class="footer-map" href="https://www.google.com/maps/search/?api=1&amp;query=Desa+Betro%2C+Kemlagi%2C+Mojokerto" target="_blank" rel="noopener" aria-label="Buka lokasi Desa Betro di Google Maps">
                    <div class="footer-map-visual" aria-hidden="true"><svg viewBox="0 0 320 180" preserveAspectRatio="xMidYMid meet" role="img"><rect width="320" height="180" fill="#e8eee5"/><path d="M0 38L320 62M0 112L320 95M75 0L54 180M192 0L210 180" stroke="#b9cab2" stroke-width="18" opacity=".95" fill="none"/><path d="M0 132C55 118 78 139 122 120C169 100 178 116 220 92C248 76 290 82 320 58" stroke="#fff" stroke-width="6" fill="none"/><path d="M48 154L70 124L102 118L120 86L154 72L178 42L218 35L238 66L218 96L186 112L164 148Z" stroke="#e94145" stroke-width="3" fill="#a8bba0" fill-opacity=".42"/><circle cx="158" cy="91" r="7" fill="#2f73b6" stroke="#fff" stroke-width="3"/><circle cx="158" cy="91" r="14" fill="#2f73b6" fill-opacity=".18"/></svg></div>
                    <span>Kecamatan Kemlagi</span>
                </a>
                <h3 class="mb-3 mt-5 text-xs font-extrabold uppercase tracking-[.14em] text-[#e5c36f]">Ikuti Kami</h3>
                <div class="flex items-center gap-2.5">
                    <a class="footer-social-link" href="javascript:void(0)" title="Facebook" aria-label="Facebook"><svg class="h-4 w-4 fill-current" viewBox="0 0 24 24" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                    <a class="footer-social-link" href="javascript:void(0)" title="Instagram" aria-label="Instagram"><svg class="h-4 w-4 fill-current" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    <a class="footer-social-link" href="javascript:void(0)" title="YouTube" aria-label="YouTube"><svg class="h-4 w-4 fill-current" viewBox="0 0 24 24" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                    <a class="footer-social-link" href="javascript:void(0)" title="WhatsApp" aria-label="WhatsApp"><svg class="h-4 w-4 fill-current" viewBox="0 0 24 24" aria-hidden="true"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg></a>
                </div>
            </section>
        </div>

        <div class="flex flex-col items-center justify-between gap-3 pt-5 text-center text-xs text-brand-100/60 sm:flex-row sm:text-left">
            <p>&copy; 2026 Desa Betro. All rights reserved.</p>
            <p class="font-medium">Desa Betro, Kabupaten Mojokerto</p>
        </div>
    </div>
</footer>
    @yield('after-content')
    <script defer src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
