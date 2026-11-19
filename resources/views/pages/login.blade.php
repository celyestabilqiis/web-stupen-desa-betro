<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Masuk atau Daftar - Portal Desa Betro</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet"/>
  <script src="{{ asset('assets/js/tailwind-config.js') }}"></script>
</head>
<body class="auth-page antialiased">
  <main class="auth-layout">
    <section class="auth-visual" aria-label="Portal Digital Desa Betro">
      <img src="{{ asset('assets/images/potensi-sawah.jpg') }}" alt="" class="auth-visual-image"/>
      <div class="auth-visual-overlay"></div>
      <span class="auth-orbit auth-orbit-one" aria-hidden="true"></span>
      <span class="auth-orbit auth-orbit-two" aria-hidden="true"></span>
      <a href="{{ route('pages.home') }}" class="auth-brand">
        <span class="auth-brand-mark"><img src="{{ asset('assets/images/logo-betro.png') }}" alt=""/></span>
        <span><strong>DESA BETRO</strong><small>Kecamatan Kemlagi · Kabupaten Mojokerto</small></span>
      </a>
      <div class="auth-visual-copy">
        <span class="auth-eyebrow"><i></i> PORTAL DIGITAL DESA</span>
        <h1>Lebih dekat,<br/><em>lebih mudah.</em></h1>
        <p>Akses layanan dan informasi Desa Betro dalam satu ruang yang nyaman, kapan saja Anda membutuhkannya.</p>
        <div class="auth-trust-note">
          <span class="auth-trust-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none"><path d="M12 3 19 6v5c0 4.5-2.9 8-7 10-4.1-2-7-5.5-7-10V6l7-3Z" stroke="currentColor" stroke-width="1.7"/><path d="m9 12 2 2 4-4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"/></svg>
          </span>
          <span><strong>Akses yang aman dan praktis</strong><small>Untuk warga Desa Betro</small></span>
        </div>
      </div>
      <p class="auth-copyright">© <span id="loginYear"></span> Pemerintah Desa Betro</p>
    </section>

    <section class="auth-content">
      <div class="auth-mobile-brand">
        <a href="{{ route('pages.home') }}" class="auth-brand auth-brand-mobile">
          <span class="auth-brand-mark"><img src="{{ asset('assets/images/logo-betro.png') }}" alt=""/></span>
          <span><strong>DESA BETRO</strong><small>Kecamatan Kemlagi</small></span>
        </a>
        <span class="auth-mobile-label">PORTAL WARGA</span>
      </div>
      <div class="auth-form-wrap">
        <a href="{{ route('pages.home') }}" class="auth-back-link">
          <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m15 18-6-6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          Kembali ke beranda
        </a>
        <div class="auth-card" id="authCard">
          <div class="auth-card-heading">
            <span class="auth-card-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none"><path d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM5 21a7 7 0 0 1 14 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
            </span>
            <span class="auth-kicker">SELAMAT DATANG</span>
            <h2 id="authTitle">Masuk ke akun Anda</h2>
            <p id="authSubtitle">Lanjutkan ke layanan digital Desa Betro.</p>
          </div>

          <div class="auth-mode-switch" role="group" aria-label="Pilih masuk atau daftar">
            <button type="button" class="auth-mode-button is-active" id="loginMode" aria-pressed="true">Masuk</button>
            <button type="button" class="auth-mode-button" id="registerMode" aria-pressed="false">Buat akun</button>
          </div>

          <form class="auth-form" id="loginForm">
            <div class="auth-field">
              <label for="email">Email atau username</label>
              <div class="auth-input-wrap">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3.5" y="5" width="17" height="14" rx="3" stroke="currentColor" stroke-width="1.6"/><path d="m5 7 7 5 7-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <input id="email" name="email" type="text" autocomplete="username" required placeholder="nama@email.com"/>
              </div>
            </div>
            <div class="auth-field">
              <div class="auth-label-row"><label for="password">Kata sandi</label><a href="#bantuan" id="forgotPassword">Lupa kata sandi?</a></div>
              <div class="auth-input-wrap">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="4" y="10" width="16" height="11" rx="2.5" stroke="currentColor" stroke-width="1.6"/><path d="M8 10V7a4 4 0 1 1 8 0v3m-4 4v3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                <input id="password" name="password" type="password" autocomplete="current-password" required minlength="6" placeholder="Masukkan kata sandi"/>
                <button type="button" class="auth-password-toggle" data-password-toggle="password" aria-label="Tampilkan kata sandi">
                  <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M2.5 12s3.2-6 9.5-6 9.5 6 9.5 6-3.2 6-9.5 6-9.5-6-9.5-6Z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="2.7" stroke="currentColor" stroke-width="1.6"/></svg>
                </button>
              </div>
            </div>
            <label class="auth-remember"><input type="checkbox" name="remember"/> <span>Ingat saya di perangkat ini</span></label>
            <button type="submit" class="auth-submit"><span>Masuk</span></button>
            <p class="auth-message" id="loginMessage" role="status" aria-live="polite" hidden></p>
          </form>

          <form class="auth-form" id="registerForm" hidden>
            <div class="auth-field">
              <label for="registerName">Nama lengkap</label>
              <div class="auth-input-wrap">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="8" r="3.5" stroke="currentColor" stroke-width="1.6"/><path d="M4.5 20a7.5 7.5 0 0 1 15 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                <input id="registerName" name="name" type="text" autocomplete="name" required placeholder="Nama sesuai identitas"/>
              </div>
            </div>
            <div class="auth-field">
              <label for="registerEmail">Email</label>
              <div class="auth-input-wrap">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3.5" y="5" width="17" height="14" rx="3" stroke="currentColor" stroke-width="1.6"/><path d="m5 7 7 5 7-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <input id="registerEmail" name="email" type="email" autocomplete="email" required placeholder="nama@email.com"/>
              </div>
            </div>
            <div class="auth-field">
              <label for="registerPassword">Buat kata sandi</label>
              <div class="auth-input-wrap">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="4" y="10" width="16" height="11" rx="2.5" stroke="currentColor" stroke-width="1.6"/><path d="M8 10V7a4 4 0 1 1 8 0v3m-4 4v3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                <input id="registerPassword" name="password" type="password" autocomplete="new-password" required minlength="6" placeholder="Minimal 6 karakter"/>
                <button type="button" class="auth-password-toggle" data-password-toggle="registerPassword" aria-label="Tampilkan kata sandi">
                  <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M2.5 12s3.2-6 9.5-6 9.5 6 9.5 6-3.2 6-9.5 6-9.5-6-9.5-6Z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="2.7" stroke="currentColor" stroke-width="1.6"/></svg>
                </button>
              </div>
            </div>
            <button type="submit" class="auth-submit"><span>Daftar sekarang</span></button>
            <p class="auth-message" id="registerMessage" role="status" aria-live="polite" hidden></p>
          </form>

          <div class="auth-card-foot"><span class="auth-foot-dot"></span> Layanan resmi Pemerintah Desa Betro</div>
        </div>
        <p class="auth-bottom-note">Dengan melanjutkan, Anda mengakses portal layanan resmi Desa Betro.</p>
      </div>
    </section>
  </main>
  <script>
    const loginYear = document.getElementById('loginYear');
    loginYear.textContent = new Date().getFullYear();

    const authCard = document.getElementById('authCard');
    const loginMode = document.getElementById('loginMode');
    const registerMode = document.getElementById('registerMode');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const authTitle = document.getElementById('authTitle');
    const authSubtitle = document.getElementById('authSubtitle');

    function setAuthMode(mode) {
      const registering = mode === 'register';
      loginForm.hidden = registering;
      registerForm.hidden = !registering;
      loginMode.classList.toggle('is-active', !registering);
      registerMode.classList.toggle('is-active', registering);
      loginMode.setAttribute('aria-pressed', String(!registering));
      registerMode.setAttribute('aria-pressed', String(registering));
      authTitle.textContent = registering ? 'Buat akun warga' : 'Masuk ke akun Anda';
      authSubtitle.textContent = registering ? 'Daftar untuk menikmati layanan digital Desa Betro.' : 'Lanjutkan ke layanan digital Desa Betro.';
      document.title = registering ? 'Daftar - Portal Desa Betro' : 'Masuk - Portal Desa Betro';
      authCard.classList.remove('auth-card-enter');
      requestAnimationFrame(() => {
        authCard.classList.add('auth-card-enter');
      });
    }

    loginMode.addEventListener('click', () => setAuthMode('login'));
    registerMode.addEventListener('click', () => setAuthMode('register'));

    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
      button.addEventListener('click', () => {
        const input = document.getElementById(button.dataset.passwordToggle);
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        button.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
      });
    });

    document.getElementById('registerForm').addEventListener('submit', (event) => {
      event.preventDefault();
      const message = document.getElementById('registerMessage');
      message.textContent = 'Pendaftaran demo berhasil disubmit. Formulir ini belum terhubung ke sistem akun.';
      message.hidden = false;
    });

    document.getElementById('loginForm').addEventListener('submit', (event) => {
      event.preventDefault();
      const message = document.getElementById('loginMessage');
      message.textContent = 'Form login demo berhasil disubmit. Belum terhubung ke sistem autentikasi.';
      message.hidden = false;
    });

    document.getElementById('forgotPassword').addEventListener('click', (event) => {
      event.preventDefault();
      const message = document.getElementById('loginMessage');
      message.textContent = 'Fitur pemulihan kata sandi belum tersedia. Silakan hubungi Pemerintah Desa Betro.';
      message.hidden = false;
    });

    if (window.location.hash === '#daftar') setAuthMode('register');
  </script>
</body>
</html>
