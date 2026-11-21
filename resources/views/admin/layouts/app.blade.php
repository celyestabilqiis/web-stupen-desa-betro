<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') - Desa Betro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fbf6f6',
                            100: '#f7eded',
                            200: '#eddcdc',
                            300: '#dfc1c1',
                            400: '#cb9b9b',
                            500: '#b46b6b',
                            600: '#9e4646',
                            700: '#801b2a',
                            800: '#6d1523',
                            900: '#57121d',
                            950: '#380710',
                        },
                        gold: '#d7ad53',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">
    <div class="min-h-screen md:flex">
        <!-- Sidebar Desktop -->
        <aside class="w-full bg-[#801b2a] text-white flex flex-col justify-between md:fixed md:inset-y-0 md:left-0 md:z-40 md:h-screen md:w-64">
            <div>
                <!-- Brand Header -->
                <div class="p-6 border-b border-brand-800/80 flex items-center gap-3">
                    <img src="{{ asset('assets/images/logo-betro.png') }}" alt="Logo Desa Betro" class="w-10 h-10 object-contain rounded-full bg-white/10 p-1">
                    <div>
                        <span class="block font-extrabold text-white text-base tracking-tight leading-none">DESA BETRO</span>
                        <span class="block text-[11px] text-white/70 mt-1 font-medium">Panel Administrasi</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="p-4 space-y-1.5">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-white shadow-xs' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.arsip.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.arsip.*') ? 'bg-white/15 text-white shadow-xs' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>Arsip &amp; Dokumentasi</span>
                    </a>

                    <a href="{{ route('admin.umkm.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.umkm.*') ? 'bg-white/15 text-white shadow-xs' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <span class="text-gold">◆</span><span>Katalog UMKM</span>
                    </a>

                    <a href="{{ route('admin.accounts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.accounts.*') ? 'bg-white/15 text-white shadow-xs' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Kelola Akun Admin</span>
                    </a>

                    <div class="pt-4 mt-4 border-t border-brand-800/80">
                        <a href="{{ route('pages.home') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-white/70 hover:bg-white/10 hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            <span>Lihat Website Publik</span>
                        </a>
                    </div>
                </nav>
            </div>

            <!-- User Info & Logout -->
            <div class="p-4 border-t border-brand-800/80 bg-brand-900/40">
                <div class="flex items-center justify-between mb-3 px-2">
                    <div class="overflow-hidden">
                        <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-white/60 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-red-700 text-white text-xs font-bold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex min-h-screen flex-1 flex-col md:ml-64 md:h-screen md:overflow-y-auto">
            <!-- Topbar Mobile & Breadcrumb -->
            <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-gray-500 mt-0.5">@yield('page-desc', 'Sistem Manajemen Informasi Desa Betro')</p>
                </div>
                <div class="flex items-center gap-3">
                    @yield('page-actions')
                </div>
            </header>

            <!-- Flash Messages -->
            <main class="flex-1 p-6 md:p-8">
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-sm font-medium">{{ session('success') }}</div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start gap-3">
                        <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-sm font-medium">{{ session('error') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800">
                        <div class="text-sm font-bold mb-1">Terdapat kesalahan pengisian formulir:</div>
                        <ul class="list-disc list-inside text-xs space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
