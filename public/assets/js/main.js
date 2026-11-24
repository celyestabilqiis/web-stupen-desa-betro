/* Interaksi bersama untuk semua halaman Portal Desa Betro. */
(() => {
  'use strict';

  const $ = (selector, scope = document) => scope.querySelector(selector);
  const $$ = (selector, scope = document) => [...scope.querySelectorAll(selector)];

  // Navigasi mobile yang bisa dipakai lewat klik, keyboard, dan screen reader.
  const siteHeader = $('#siteHeader');
  const mobileMenuBtn = $('#mobileMenuBtn');
  const mobileMenu = $('#mobileMenu');
  if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.addEventListener('click', () => {
      const isOpen = !mobileMenu.classList.contains('hidden');
      mobileMenu.classList.toggle('hidden');
      mobileMenuBtn.setAttribute('aria-expanded', String(!isOpen));
      mobileMenuBtn.setAttribute('aria-label', isOpen ? 'Buka menu navigasi' : 'Tutup menu navigasi');
      if (siteHeader) {
        if (!isOpen) {
          siteHeader.classList.add('nav-menu-open');
        } else if (window.scrollY <= 50) {
          siteHeader.classList.remove('nav-menu-open');
        }
      }
    });

    $$('a', mobileMenu).forEach((link) => {
      link.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
        mobileMenuBtn.setAttribute('aria-label', 'Buka menu navigasi');
        if (siteHeader && window.scrollY <= 50) {
          siteHeader.classList.remove('nav-menu-open');
        }
      });
    });
  }

  // Toggle submenu Informasi pada drawer mobile
  const mobileDropdownBtn = $('#mobileDropdownBtn');
  const mobileSubmenu = $('#mobileSubmenu');
  const mobileDropdownIcon = $('#mobileDropdownIcon');

  if (mobileDropdownBtn && mobileSubmenu) {
    mobileDropdownBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      const isExpanded = mobileDropdownBtn.getAttribute('aria-expanded') === 'true';
      mobileDropdownBtn.setAttribute('aria-expanded', !isExpanded);
      mobileSubmenu.classList.toggle('hidden');
      if (mobileDropdownIcon) {
        mobileDropdownIcon.classList.toggle('rotate-180');
      }
    });
  }

  // Tandai halaman yang sedang dibuka pada navigasi desktop dan mobile.
  const page = document.body.dataset.page || 'home';
  const hrefMap = {
    home: '/',
    potensi: '/potensi',
    informasi: '/informasi',
    'informasi-wilayah': '/informasi/wilayah',
    'informasi-dokumen': '/arsip-dokumentasi',
    'informasi-kegiatan': '/arsip-dokumentasi',
    'arsip-dokumentasi': '/arsip-dokumentasi',
    'arsip-detail': '/arsip-dokumentasi',
    profile: '/profile',
    pengaduan: '/pengaduan',
    login: '/login'
  };
  const isInformasiPage = page.startsWith('informasi') || page.startsWith('arsip');
  const activePath = hrefMap[page] || null;

  if (activePath) {
    $$('header nav a, [data-mobile-nav] a').forEach((link) => {
      // Abaikan tombol Admin Panel
      if (link.getAttribute('href')?.includes('/admin')) return;

      const href = link.getAttribute('href') || '';
      const linkUrl = new URL(href, window.location.href);
      const isParentInformasi = isInformasiPage && linkUrl.pathname === '/informasi' && !link.closest('.dropdown-menu') && !link.closest('#mobileSubmenu');
      const isSubmenuItem = (page === 'informasi-wilayah' && linkUrl.pathname === '/informasi/wilayah') ||
                            ((page === 'arsip-dokumentasi' || page === 'arsip-detail') && linkUrl.pathname === '/arsip-dokumentasi');

      const isCurrent = (linkUrl.pathname === activePath || isParentInformasi || isSubmenuItem) && (page !== 'home' || linkUrl.hash === '#beranda');
      if (isCurrent) {
        link.classList.add('nav-link-active');
        link.setAttribute('aria-current', 'page');
      } else {
        link.classList.remove('nav-link-active');
        link.removeAttribute('aria-current');
      }
    });
  }

  const umkmDialog = $('#umkmDetailDialog');
  if (umkmDialog) {
    document.addEventListener('click', (event) => {
      const closeButton = event.target.closest('[data-close-umkm]');
      if (closeButton) {
        umkmDialog.close();
        return;
      }

      const card = event.target.closest('[data-umkm-card]');
      if (card) {
        $('#umkmDetailImage', umkmDialog).src = card.dataset.image || '';
        $('#umkmDetailImage', umkmDialog).alt = card.dataset.title || 'Foto UMKM';
        $('#umkmDetailCategory', umkmDialog).textContent = card.dataset.category || '';
        $('#umkmDetailTitle', umkmDialog).textContent = card.dataset.title || 'Profil UMKM';
        $('#umkmDetailDescription', umkmDialog).textContent = card.dataset.description || '';
        $('#umkmDetailRating', umkmDialog).textContent = card.dataset.rating || '0';
        $('#umkmDetailReviews', umkmDialog).textContent = card.dataset.reviews || '0';
        document.body.classList.add('modal-open');
        umkmDialog.showModal();
        return;
      }
    });

    umkmDialog.addEventListener('click', (event) => {
      if (event.target === umkmDialog) umkmDialog.close();
    });
    umkmDialog.addEventListener('close', () => {
      document.body.classList.remove('modal-open');
    });
  }

  // Pencarian daftar perangkat pada halaman Profil Desa.
  const profileSearch = $('#profileSearch');
  if (profileSearch) {
    const profileCards = $$('[data-profile-card]');
    const profileGroups = $$('[data-profile-group]');
    const emptyState = $('#profileNoResults');
    const normalise = (value) => (value || '').toLocaleLowerCase('id-ID').normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    const filterProfiles = () => {
      const query = normalise(profileSearch.value.trim());
      let visibleCount = 0;
      profileCards.forEach((card) => {
        const haystack = normalise(`${card.dataset.profileName || ''} ${card.dataset.profileRole || ''} ${card.textContent}`);
        const visible = haystack.includes(query);
        card.hidden = !visible;
        if (visible) visibleCount += 1;
      });
      profileGroups.forEach((group) => {
        group.hidden = !group.querySelector('[data-profile-card]:not([hidden])');
      });
      const leadershipSection = $('.profile-leadership-section');
      if (leadershipSection) leadershipSection.hidden = !leadershipSection.querySelector('[data-profile-card]:not([hidden])');
      if (emptyState) {
        emptyState.hidden = visibleCount > 0;
        const heading = emptyState.querySelector('h3');
        const description = emptyState.querySelector('p');
        if (query) {
          if (heading) heading.textContent = 'Profil tidak ditemukan';
          if (description) description.textContent = 'Coba gunakan nama atau jabatan yang berbeda.';
        } else {
          if (heading) heading.textContent = 'Data perangkat desa belum tersedia';
          if (description) description.textContent = 'Informasi perangkat desa akan ditampilkan setelah dipublikasikan oleh admin.';
        }
      }
    };
    profileSearch.addEventListener('input', filterProfiles);
    document.addEventListener('keydown', (event) => {
      if (event.key === '/' && !['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement?.tagName) && !event.ctrlKey && !event.metaKey && !event.altKey) {
        event.preventDefault();
        profileSearch.focus();
      }
      if (event.key === 'Escape' && document.activeElement === profileSearch) {
        profileSearch.value = '';
        filterProfiles();
        profileSearch.blur();
      }
    });
  }

  // Modal sederhana. Pengaduan sekarang menggunakan halaman terpisah.
  window.openModal = function openModal(id) {
    let modal = document.getElementById(id);
    if (!modal && id === 'pengaduanModal') {
      window.location.href = '/pengaduan';
      return;
    }
    if (!modal) return;
    modal.classList.remove('hidden');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('modal-open');
    const focusable = $('input, textarea, select, button, a[href]', modal);
    if (focusable) window.setTimeout(() => focusable.focus(), 40);
  };

  window.closeModal = function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('hidden');
    modal.setAttribute('aria-hidden', 'true');
    if (!$('[id$="Modal"]:not(.hidden)')) document.body.classList.remove('modal-open');
  };

  // Detail modal yang juga berjalan pada halaman selain beranda.
  function ensureDetailModal() {
    let modal = $('#detailModal');
    if (modal) return modal;
    modal = document.createElement('div');
    modal.id = 'detailModal';
    modal.className = 'custom-modal hidden';
    modal.setAttribute('role', 'dialog');
    modal.setAttribute('aria-modal', 'true');
    modal.setAttribute('aria-labelledby', 'modalTitle');
    modal.innerHTML = `
      <div class="custom-modal-panel">
        <button type="button" class="custom-modal-close" data-close-detail aria-label="Tutup dialog">×</button>
        <span class="eyebrow">INFORMASI DESA</span>
        <h3 id="modalTitle">Informasi</h3>
        <p id="modalBody"></p>
        <button type="button" class="button-primary" data-close-detail>Tutup</button>
      </div>`;
    document.body.appendChild(modal);
    $$('[data-close-detail]', modal).forEach((button) => button.addEventListener('click', () => window.closeModal('detailModal')));
    return modal;
  }

  window.openDetailModal = function openDetailModal(title, text) {
    const modal = ensureDetailModal();
    const titleEl = $('#modalTitle', modal);
    const bodyEl = $('#modalBody', modal);
    if (titleEl) titleEl.textContent = title || 'Informasi';
    if (bodyEl) bodyEl.textContent = text || 'Informasi lebih lanjut akan ditampilkan di sini.';
    window.openModal('detailModal');
  };

  // Pratinjau bukti foto pada formulir pengaduan.
  const buktiInput = $('#pengaduanBukti');
  const buktiPreview = $('#pengaduanPreview');
  const buktiError = $('#pengaduanBuktiError');
  let selectedBukti = [];

  function syncBuktiInput() {
    if (!buktiInput) return;
    const transfer = new DataTransfer();
    selectedBukti.forEach((file) => transfer.items.add(file));
    buktiInput.files = transfer.files;
  }

  function clearBuktiError() {
    if (!buktiError) return;
    buktiError.classList.add('hidden');
    buktiError.textContent = '';
  }

  function renderBuktiPreview() {
    if (!buktiPreview) return;
    buktiPreview.replaceChildren();
    selectedBukti.forEach((file, index) => {
      const item = document.createElement('div');
      item.className = 'relative aspect-square overflow-hidden rounded-lg border border-gray-200 bg-gray-50';
      const image = document.createElement('img');
      image.className = 'h-full w-full object-cover';
      image.alt = `Bukti pengaduan ${index + 1}: ${file.name}`;
      image.src = URL.createObjectURL(file);
      image.addEventListener('load', () => URL.revokeObjectURL(image.src), { once: true });

      const remove = document.createElement('button');
      remove.type = 'button';
      remove.className = 'absolute right-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-black/70 text-sm font-bold text-white shadow';
      remove.setAttribute('aria-label', `Hapus ${file.name}`);
      remove.textContent = '×';
      remove.addEventListener('click', () => {
        selectedBukti.splice(index, 1);
        syncBuktiInput();
        renderBuktiPreview();
      });

      item.append(image, remove);
      buktiPreview.appendChild(item);
    });
  }

  if (buktiInput) {
    buktiInput.addEventListener('change', () => {
      clearBuktiError();
      const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
      const incomingFiles = [...buktiInput.files];
      const validFiles = incomingFiles.filter((file) => allowedTypes.includes(file.type) && file.size <= 5 * 1024 * 1024);

      if (validFiles.length !== incomingFiles.length) {
        buktiError.textContent = 'Gunakan foto JPG, PNG, atau WebP dengan ukuran maksimal 5 MB.';
        buktiError.classList.remove('hidden');
      } else if (selectedBukti.length + validFiles.length > 3) {
        buktiError.textContent = 'Bukti maksimal 3 foto.';
        buktiError.classList.remove('hidden');
      } else {
        selectedBukti.push(...validFiles);
        syncBuktiInput();
        renderBuktiPreview();
        return;
      }

      syncBuktiInput();
    });
  }

  // Formulir sengaja bersifat simulasi sampai dihubungkan ke backend/API.
  window.handlePengaduanSubmit = function handlePengaduanSubmit(event) {
    if (event) event.preventDefault();
    window.closeModal('pengaduanModal');
    const standaloneSuccess = $('#pengaduanSuccess');
    if (standaloneSuccess) {
      standaloneSuccess.classList.remove('hidden');
      standaloneSuccess.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
      window.openDetailModal(
        'Simulasi pengaduan berhasil',
        selectedBukti.length
          ? `Pengaduan beserta ${selectedBukti.length} foto bukti diterima dalam simulasi. Data dan gambar belum disimpan atau dikirim ke server.`
          : 'Ini masih versi demo. Data formulir belum disimpan atau dikirim ke server. Hubungkan formulir ke backend sebelum website digunakan secara resmi.'
      );
    }
    const form = $('#pengaduanModal form') || $('[data-demo-submit]');
    if (form) form.reset();
    selectedBukti = [];
    syncBuktiInput();
    clearBuktiError();
    renderBuktiPreview();
  };

  window.scrollToSection = function scrollToSection(id) {
    const target = document.getElementById(id);
    if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
  };

  // Event diikat dari satu berkas JS (tanpa onclick/onsubmit di HTML).
  document.addEventListener('click', (event) => {
    const actionEl = event.target.closest('[data-action], [data-detail-title], [data-go], [data-scroll-to], [data-close-modal]');
    if (!actionEl) return;

    if (actionEl.dataset.action === 'open-pengaduan' || actionEl.dataset.action === 'go-pengaduan') {
      event.preventDefault();
      window.location.href = '/pengaduan';
      return;
    }

    if (actionEl.dataset.action === 'open-modal') {
      event.preventDefault();
      window.openModal(actionEl.dataset.modalId);
      return;
    }
    if (actionEl.dataset.closeModal) {
      event.preventDefault();
      window.closeModal(actionEl.dataset.closeModal);
      return;
    }
    if (actionEl.dataset.go) {
      event.preventDefault();
      window.location.href = actionEl.dataset.go;
      return;
    }
    if (actionEl.dataset.scrollTo) {
      event.preventDefault();
      window.scrollToSection(actionEl.dataset.scrollTo);
      return;
    }
    if (actionEl.hasAttribute('data-detail-title')) {
      if (actionEl.tagName === 'A') event.preventDefault();
      window.openDetailModal(actionEl.dataset.detailTitle, actionEl.dataset.detailText);
    }
  });

  document.addEventListener('keydown', (event) => {
    const target = event.target.closest('[role="button"][data-detail-title], [role="button"][data-go]');
    if (!target || (event.key !== 'Enter' && event.key !== ' ')) return;
    event.preventDefault();
    target.click();
  });

  document.addEventListener('submit', (event) => {
    if (event.target.matches('[data-demo-submit]')) window.handlePengaduanSubmit(event);
  });

  // Klik di luar dialog atau tombol Escape menutup modal.
  document.addEventListener('click', (event) => {
    const modal = event.target.closest('.custom-modal, #pengaduanModal, #detailModal');
    if (modal && event.target === modal) window.closeModal(modal.id);
  });
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      $$('.custom-modal, #pengaduanModal, #detailModal').forEach((modal) => {
        if (!modal.classList.contains('hidden')) window.closeModal(modal.id);
      });
    }
  });

  // Jika pengunjung datang dari tombol pengaduan di halaman lain.
  if (window.location.hash === '#pengaduan' && $('#pengaduanModal')) {
    window.setTimeout(() => window.openModal('pengaduanModal'), 80);
  }

  // Tahun footer selalu mengikuti tahun berjalan.
  $$('footer').forEach((footer) => {
    $$('p', footer).forEach((paragraph) => {
      if (/©\s*20\d{2}/.test(paragraph.textContent)) {
        paragraph.textContent = paragraph.textContent.replace(/©\s*20\d{2}/, `© ${new Date().getFullYear()}`);
      }
    });
  });

  // ─── Navbar dinamis: transparan di hero, solid saat di-scroll ───────────────
  if (siteHeader) {
    const isHome = document.body.getAttribute('data-page') === 'home' || !!document.querySelector('#beranda');
    const NAV_THRESHOLD = 50;

    if (!isHome) {
      siteHeader.classList.add('nav-no-hero');
    } else {
      let ticking = false;
      const updateNavbar = () => {
        if (window.scrollY > NAV_THRESHOLD) {
          siteHeader.classList.add('nav-scrolled');
        } else {
          siteHeader.classList.remove('nav-scrolled');
          if (mobileMenu && mobileMenu.classList.contains('hidden')) {
            siteHeader.classList.remove('nav-menu-open');
          }
        }
        ticking = false;
      };

      window.addEventListener('scroll', () => {
        if (!ticking) {
          window.requestAnimationFrame(updateNavbar);
          ticking = true;
        }
      }, { passive: true });
      updateNavbar(); // jalankan saat halaman pertama dimuat
    }
  }
})();
