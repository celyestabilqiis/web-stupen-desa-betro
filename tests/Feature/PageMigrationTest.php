<?php

namespace Tests\Feature;

use App\Models\Arsip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_migrated_pages_render_with_the_shared_layout(): void
    {
        $pages = [
            'pages.home' => 'Selamat Datang di Website Resmi',
            'pages.informasi' => 'Pusat Informasi',
            'pages.potensi' => 'Potensi Lokal',
            'pages.profile' => 'Profil Perangkat Desa',
            'pages.pengaduan' => 'Pengaduan Desa Betro',
        ];

        foreach ($pages as $route => $content) {
            $this->get(route($route))
                ->assertOk()
                ->assertSee($content)
                ->assertSee('site-header')
                ->assertSee('village-footer')
                ->assertSee(asset('assets/css/style.css'));
        }
    }

    public function test_navigation_uses_named_laravel_routes(): void
    {
        $this->get(route('pages.home'))
            ->assertOk()
            ->assertSee('href="'.route('pages.profile').'"', false)
            ->assertSee('href="'.route('pages.informasi').'"', false)
            ->assertDontSee('href="'.route('pages.home').'#layanan"', false)
            ->assertDontSee('Pemerintahan</a>')
            ->assertSee('href="'.route('pages.pengaduan').'"', false)
            ->assertDontSee('href="'.route('pages.login').'"', false)
            ->assertDontSee('Sign Up');
    }

    public function test_shared_footer_has_contact_links_map_and_existing_social_channels(): void
    {
        $this->get(route('pages.home'))
            ->assertOk()
            ->assertSee('PEMERINTAH DESA BETRO')
            ->assertSee('Hubungi Kami')
            ->assertSee('Telepon/WhatsApp')
            ->assertSee('Email resmi')
            ->assertSee('Belum tersedia')
            ->assertSee('href="'.route('pages.home').'"', false)
            ->assertSee('href="'.route('pages.profile').'"', false)
            ->assertSee('href="'.route('pages.potensi').'"', false)
            ->assertSee('href="'.route('pages.informasi').'"', false)
            ->assertSee('href="'.route('pages.arsip.index').'"', false)
            ->assertSee('aria-label="Buka lokasi Desa Betro di Google Maps"', false)
            ->assertSee('aria-label="Facebook"', false)
            ->assertSee('aria-label="Instagram"', false)
            ->assertSee('aria-label="YouTube"', false)
            ->assertSee('aria-label="WhatsApp"', false)
            ->assertSee('&copy; 2026 Desa Betro. All rights reserved.', false);
    }

    public function test_information_content_is_available_in_the_homepage_section(): void
    {
        $this->get(route('pages.home'))
            ->assertOk()
            ->assertSee('Informasi Desa')
            ->assertSee('Statistik Desa')
            ->assertSee('Arsip &amp; Dokumentasi Desa', false)
            ->assertDontSee('2.630')
            ->assertSee('—')
            ->assertSee(route('pages.informasi.statistik'))
            ->assertSee(route('pages.arsip.index'));
    }

    public function test_potensi_page_only_shows_umkm_and_business_permit_content(): void
    {
        $this->get(route('pages.potensi'))
            ->assertOk()
            ->assertSee('Jelajahi UMKM Desa Betro')
            ->assertSee('Izin Usaha')
            ->assertDontSee('Pusat Layanan &amp; Transparansi', false)
            ->assertDontSee('Pemerintahan Desa Betro')
            ->assertDontSee('Anggaran &amp; Realisasi Dana Desa', false)
            ->assertDontSee('Kesehatan &amp; Sosial', false)
            ->assertDontSee('id="publikasi-dokumen"', false);
    }

    public function test_navbar_has_informasi_dropdown_links(): void
    {
        $this->get(route('pages.home'))
            ->assertOk()
            ->assertSee('id="navDropdownInformasi"', false)
            ->assertSee(route('pages.informasi.statistik'))
            ->assertSee(route('pages.arsip.index'))
            ->assertSee('id="mobileDropdownBtn"', false)
            ->assertSee('id="mobileSubmenu"', false);
    }

    public function test_informasi_page_does_not_contain_the_three_separated_sections(): void
    {
        $this->get(route('pages.informasi'))
            ->assertOk()
            ->assertSee('Pusat Informasi')
            ->assertSee('Arsip &amp; Dokumentasi Desa Terbaru', false)
            ->assertDontSee('id="statistik-desa"', false)
            ->assertDontSee('id="publikasi-dokumen"', false)
            ->assertDontSee('id="dokumentasi-kegiatan"', false);
    }

    public function test_dedicated_informasi_subpages_render_correctly(): void
    {
        $this->get(route('pages.informasi.statistik'))
            ->assertOk()
            ->assertSee('Statistik Desa Betro')
            ->assertSee('Data statistik belum tersedia')
            ->assertSee('site-header');

        $this->get(route('pages.arsip.index'))
            ->assertOk()
            ->assertSee('Arsip')
            ->assertSee('site-header');
    }

    public function test_legacy_redirects_work(): void
    {
        $this->get('/layanan')->assertRedirect('/#informasi');
        $this->get('/pemerintahan')->assertRedirect('/potensi#izin-usaha');
        $this->get('/informasi/dokumen')->assertRedirect('/arsip-dokumentasi');
        $this->get('/informasi/kegiatan')->assertRedirect('/arsip-dokumentasi');
        $this->get('/publikasi-dokumen')->assertRedirect('/arsip-dokumentasi');
        $this->get('/dokumentasi-kegiatan')->assertRedirect('/arsip-dokumentasi');
    }

    public function test_admin_panel_button_visibility_in_navbar(): void
    {
        // 1. Pengunjung tamu tidak melihat tombol Admin Panel
        $this->get(route('pages.home'))
            ->assertOk()
            ->assertDontSee('Admin Panel')
            ->assertDontSee(route('admin.dashboard'));

        // 2. Admin yang login melihat tombol Admin Panel
        $admin = User::factory()->create();
        $this->actingAs($admin)
            ->get(route('pages.home'))
            ->assertOk()
            ->assertSee('Admin Panel')
            ->assertSee(route('admin.dashboard'));

        // 3. Setelah logout, tombol Admin Panel tidak muncul lagi
        $this->post(route('admin.logout'))
            ->assertRedirect(route('login'));

        $this->get(route('pages.home'))
            ->assertOk()
            ->assertDontSee('Admin Panel')
            ->assertDontSee(route('admin.dashboard'));
    }

    public function test_navbar_active_state_on_homepage(): void
    {
        $response = $this->get(route('pages.home'))->assertOk();

        // Beranda aktif
        $response->assertSee('nav-link-active', false);
        $response->assertSee('href="'.route('pages.home').'#beranda"', false);

        // Informasi tidak aktif
        $response->assertDontSee('class="nav-link-active transition inline-flex items-center gap-1.5" href="'.route('pages.informasi').'" id="navDropdownInformasi"', false);
    }

    public function test_navbar_active_state_on_arsip_pages(): void
    {
        $arsip = Arsip::factory()->terbit()->create([
            'judul' => 'Uji Aktivasi Menu Informasi',
        ]);

        // Daftar Arsip
        $responseList = $this->get(route('pages.arsip.index'))->assertOk();
        $responseList->assertSee('class="nav-link-active transition inline-flex items-center gap-1.5" href="'.route('pages.informasi').'" id="navDropdownInformasi"', false);
        $responseList->assertSee('href="'.route('pages.arsip.index').'" class="dropdown-item nav-link-active"', false);
        $responseList->assertDontSee('<a class="nav-link-active transition" aria-current="page" href="'.route('pages.home').'#beranda">', false);

        // Detail Arsip
        $responseDetail = $this->get(route('pages.arsip.show', $arsip->slug))->assertOk();
        $responseDetail->assertSee('class="nav-link-active transition inline-flex items-center gap-1.5" href="'.route('pages.informasi').'" id="navDropdownInformasi"', false);
        $responseDetail->assertSee('href="'.route('pages.arsip.index').'" class="dropdown-item nav-link-active"', false);
        $responseDetail->assertDontSee('<a class="nav-link-active transition" aria-current="page" href="'.route('pages.home').'#beranda">', false);
    }

    public function test_admin_sidebar_and_table_links_do_not_open_new_tab_for_articles(): void
    {
        $admin = User::factory()->create();
        $artikel = Arsip::factory()->terbit()->create(['tipe' => 'artikel']);
        $pdf = Arsip::factory()->terbit()->pdf()->create();

        // Sidebar link Lihat Website Publik tidak memiliki target="_blank"
        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertDontSee('href="'.route('pages.home').'" target="_blank"', false)
            ->assertSee('href="'.route('pages.home').'" class="flex items-center gap-3', false);

        // Tabel Arsip: artikel tidak membuka tab baru, PDF membuka tab baru
        $this->actingAs($admin)
            ->get(route('admin.arsip.index'))
            ->assertOk()
            ->assertSee('href="'.route('pages.arsip.show', $artikel->slug).'" class="p-1.5 text-gray-400', false)
            ->assertSee('href="'.route('pages.arsip.show', $pdf->slug).'" target="_blank" rel="noopener" class="p-1.5 text-gray-400', false);
    }

    public function test_navbar_on_pengaduan_page_has_dropdown_and_active_state(): void
    {
        $response = $this->get(route('pages.pengaduan'))->assertOk();

        // Menu Pengaduan bertanda aktif
        $response->assertSee('nav-link-active', false);
        $response->assertSee('href="'.route('pages.pengaduan').'"', false);

        // Markup dropdown Informasi beserta item Statistik Desa dan Arsip & Dokumentasi Desa tetap ada
        $response->assertSee('id="navDropdownInformasi"', false);
        $response->assertSee('href="'.route('pages.informasi.statistik').'"', false);
        $response->assertSee('Statistik Desa');
        $response->assertSee('href="'.route('pages.arsip.index').'"', false);
        $response->assertSee('Arsip &amp; Dokumentasi Desa', false);

        // Header dan footer bersama tampil pada halaman pengaduan
        $response->assertSee('site-header');
        $response->assertSee('village-footer');
    }
}
