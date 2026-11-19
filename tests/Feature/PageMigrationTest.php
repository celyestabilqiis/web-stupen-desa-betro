<?php

namespace Tests\Feature;

use Tests\TestCase;

class PageMigrationTest extends TestCase
{
    public function test_migrated_pages_render_with_the_shared_layout(): void
    {
        $pages = [
            'pages.home' => 'Selamat Datang di Website Resmi',
            'pages.informasi' => 'Pusat Informasi',
            'pages.potensi' => 'Potensi Lokal',
            'pages.profile' => 'Profil Perangkat Desa',
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

    public function test_information_content_is_available_in_the_homepage_section(): void
    {
        $this->get(route('pages.home'))
            ->assertOk()
            ->assertSee('Informasi Desa')
            ->assertSee('Statistik Desa')
            ->assertSee('Publikasi Dokumen')
            ->assertSee('Dokumentasi Kegiatan Desa')
            ->assertSee('2.630')
            ->assertSee('Ringkasan APBDes 2026')
            ->assertSee('Musrenbang Desa 2026')
            ->assertSee(route('pages.informasi.statistik'))
            ->assertSee(route('pages.informasi.dokumen'))
            ->assertSee(route('pages.informasi.kegiatan'));
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
            ->assertSee(route('pages.informasi.dokumen'))
            ->assertSee(route('pages.informasi.kegiatan'))
            ->assertSee('id="mobileDropdownBtn"', false)
            ->assertSee('id="mobileSubmenu"', false);
    }

    public function test_informasi_page_does_not_contain_the_three_separated_sections(): void
    {
        $this->get(route('pages.informasi'))
            ->assertOk()
            ->assertSee('Pusat Informasi')
            ->assertSee('Kabar &amp; Berita Terkini Desa Betro', false)
            ->assertDontSee('id="statistik-desa"', false)
            ->assertDontSee('id="publikasi-dokumen"', false)
            ->assertDontSee('id="dokumentasi-kegiatan"', false);
    }

    public function test_dedicated_informasi_subpages_render_correctly(): void
    {
        $this->get(route('pages.informasi.statistik'))
            ->assertOk()
            ->assertSee('Statistik Desa Betro')
            ->assertSee('2.630')
            ->assertSee('site-header');

        $this->get(route('pages.informasi.dokumen'))
            ->assertOk()
            ->assertSee('Publikasi Dokumen Resmi')
            ->assertSee('Ringkasan APBDes 2026')
            ->assertSee('site-header');

        $this->get(route('pages.informasi.kegiatan'))
            ->assertOk()
            ->assertSee('Dokumentasi Kegiatan Desa')
            ->assertSee('Musrenbang Desa 2026')
            ->assertSee('site-header');
    }

    public function test_removed_pages_redirect_to_their_new_locations(): void
    {
        $this->get('/layanan')->assertRedirect('/#informasi');
        $this->get('/pemerintahan')->assertRedirect('/potensi#izin-usaha');
    }
}
