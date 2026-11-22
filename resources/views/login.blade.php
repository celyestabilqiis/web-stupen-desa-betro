<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Admin - Portal Desa Betro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet"/>
</head>
<body class="auth-page antialiased">
    <main class="auth-layout">
        <section class="auth-visual" aria-label="Portal Digital Desa Betro">
            <img src="{{ asset('assets/images/potensi-sawah.jpg') }}" alt="" class="auth-visual-image"/>
            <div class="auth-visual-overlay"></div>
            <span class="auth-orbit auth-orbit-one" aria-hidden="true"></span>
            <span class="auth-orbit auth-orbit-two" aria-hidden="true"></span>

            <a href="{{ route('pages.home') }}" class="auth-brand">
                <span class="auth-brand-mark">
                    <img src="{{ asset('assets/images/logo-betro.png') }}" alt=""/>
                </span>
                <span>
                    <strong>DESA BETRO</strong>
                    <small>Kecamatan Kemlagi - Kabupaten Mojokerto</small>
                </span>
            </a>

            <div class="auth-visual-copy">
                <span class="auth-eyebrow"><i></i> RUANG ADMINISTRATOR</span>
                <h1>Melayani desa,<br/><em>dengan sepenuh hati.</em></h1>
                <p>Kelola informasi dan layanan Desa Betro melalui portal administrasi resmi yang aman dan mudah digunakan.</p>
                <div class="auth-trust-note">
                    <span class="auth-trust-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 3 19 6v5c0 4.5-2.9 8-7 10-4.1-2-7-5.5-7-10V6l7-3Z" stroke="currentColor" stroke-width="1.7"/>
                            <path d="m9 12 2 2 4-4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"/>
                        </svg>
                    </span>
                    <span>
                        <strong>Akses khusus administrator</strong>
                        <small>Portal resmi Pemerintah Desa Betro</small>
                    </span>
                </div>
            </div>

            <p class="auth-copyright">© {{ date('Y') }} Pemerintah Desa Betro</p>
        </section>

        <section class="auth-content">
            <div class="auth-mobile-brand">
                <a href="{{ route('pages.home') }}" class="auth-brand auth-brand-mobile">
                    <span class="auth-brand-mark">
                        <img src="{{ asset('assets/images/logo-betro.png') }}" alt=""/>
                    </span>
                    <span>
                        <strong>DESA BETRO</strong>
                        <small>Kecamatan Kemlagi</small>
                    </span>
                </a>
                <span class="auth-mobile-label">ADMIN</span>
            </div>

            <div class="auth-form-wrap">
                <a href="{{ route('pages.home') }}" class="auth-back-link">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="m15 18-6-6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Kembali ke beranda
                </a>

                <div class="auth-card">
                    <div class="auth-card-heading">
                        <span class="auth-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <rect x="4" y="10" width="16" height="11" rx="2.5" stroke="currentColor" stroke-width="1.7"/>
                                <path d="M8 10V7a4 4 0 1 1 8 0v3m-4 4v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span class="auth-kicker">SELAMAT DATANG KEMBALI</span>
                        <h2>Login Admin</h2>
                        <p>Masuk untuk melanjutkan ke dashboard Desa Betro.</p>
                    </div>

                    <form class="auth-form" method="POST" action="{{ route('admin.authenticate') }}">
                        @csrf

                        <div class="auth-field">
                            <label for="email">Email administrator</label>
                            <div class="auth-input-wrap">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <rect x="3.5" y="5" width="17" height="14" rx="3" stroke="currentColor" stroke-width="1.6"/>
                                    <path d="m5 7 7 5 7-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    autocomplete="username"
                                    placeholder="nama@email.com"
                                    required
                                    autofocus
                                />
                            </div>
                            @error('email')
                                <p class="auth-field-error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="auth-field">
                            <label for="password">Kata sandi</label>
                            <div class="auth-input-wrap">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <rect x="4" y="10" width="16" height="11" rx="2.5" stroke="currentColor" stroke-width="1.6"/>
                                    <path d="M8 10V7a4 4 0 1 1 8 0v3m-4 4v3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                </svg>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="current-password"
                                    placeholder="Masukkan kata sandi"
                                    required
                                />
                            </div>
                            @error('password')
                                <p class="auth-field-error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <label class="auth-remember">
                            <input type="checkbox" name="remember"/>
                            <span>Ingat saya di perangkat ini</span>
                        </label>

                        <button type="submit" class="auth-submit">
                            <span>Masuk ke dashboard</span>
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </form>

                    <div class="auth-card-foot">
                        <span class="auth-foot-dot"></span>
                        Layanan resmi Pemerintah Desa Betro
                    </div>
                </div>

                <p class="auth-bottom-note">Halaman ini hanya untuk administrator yang berwenang.</p>
            </div>
        </section>
    </main>
</body>
</html>
