<?php

namespace Tests\Feature;

use App\Models\Arsip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArsipTest extends TestCase
{
    use RefreshDatabase;

    // ─── PUBLIC ────────────────────────────────────────

    public function test_arsip_list_page_loads_and_shows_only_published_items(): void
    {
        Arsip::factory()->terbit()->create(['judul' => 'Arsip Publik Terbit']);
        Arsip::factory()->create(['judul' => 'Arsip Draft Rahasia', 'status' => 'draft']);

        $this->get(route('pages.arsip.index'))
            ->assertOk()
            ->assertSee('Arsip Publik Terbit')
            ->assertDontSee('Arsip Draft Rahasia');
    }

    public function test_arsip_list_filters_by_kategori(): void
    {
        Arsip::factory()->terbit()->arsipDesa()->create(['judul' => 'Laporan APBDes Terbaru']);
        Arsip::factory()->terbit()->dokumentasiDesa()->create(['judul' => 'Gotong Royong Warga']);

        $response = $this->get(route('pages.arsip.index', ['kategori' => 'arsip_desa']));
        $response->assertOk()
            ->assertSee('Laporan APBDes Terbaru')
            ->assertDontSee('Gotong Royong Warga');

        $response = $this->get(route('pages.arsip.index', ['kategori' => 'dokumentasi_desa']));
        $response->assertOk()
            ->assertSee('Gotong Royong Warga')
            ->assertDontSee('Laporan APBDes Terbaru');
    }

    public function test_arsip_list_has_pagination(): void
    {
        Arsip::factory()->terbit()->count(10)->create();

        $this->get(route('pages.arsip.index'))
            ->assertOk()
            ->assertSee('Berikutnya');
    }

    public function test_arsip_detail_page_shows_article(): void
    {
        $arsip = Arsip::factory()->terbit()->create([
            'judul' => 'Detail Artikel Uji',
            'isi' => '<p>Isi artikel lengkap untuk pengujian.</p>',
        ]);

        $this->get(route('pages.arsip.show', $arsip->slug))
            ->assertOk()
            ->assertSee('Detail Artikel Uji')
            ->assertSee('Isi artikel lengkap untuk pengujian.');
    }

    public function test_draft_arsip_returns_404(): void
    {
        $arsip = Arsip::factory()->create(['status' => 'draft']);

        $this->get(route('pages.arsip.show', $arsip->slug))
            ->assertNotFound();
    }

    public function test_view_count_increments_once_per_session(): void
    {
        $arsip = Arsip::factory()->terbit()->create(['jumlah_dilihat' => 0]);

        // Kunjungan pertama: jumlah naik
        $this->get(route('pages.arsip.show', $arsip->slug))->assertOk();
        $this->assertSame(1, $arsip->fresh()->jumlah_dilihat);

        // Kunjungan kedua di sesi sama: jumlah tetap
        $this->get(route('pages.arsip.show', $arsip->slug))->assertOk();
        $this->assertSame(1, $arsip->fresh()->jumlah_dilihat);
    }

    // ─── ADMIN CRUD ────────────────────────────────────

    public function test_guest_cannot_access_admin_routes(): void
    {
        $this->get(route('admin.arsip.index'))->assertRedirect(route('login'));
        $this->get(route('admin.arsip.create'))->assertRedirect(route('login'));
        $this->get(route('admin.accounts.index'))->assertRedirect(route('login'));
    }

    public function test_admin_can_create_arsip(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.arsip.store'), [
            'judul' => 'Arsip Baru dari Test',
            'kategori' => 'arsip_desa',
            'tipe' => 'artikel',
            'tanggal' => '2026-11-20',
            'status' => 'terbit',
            'isi' => '<p>Isi dari arsip baru.</p>',
            'gambar_sampul' => UploadedFile::fake()->create('sampul.jpg', 2048, 'image/jpeg'),
        ]);

        $response->assertRedirect(route('admin.arsip.index'));
        $this->assertDatabaseHas('arsips', ['judul' => 'Arsip Baru dari Test']);
    }

    public function test_admin_can_update_arsip(): void
    {
        $user = User::factory()->create();
        $arsip = Arsip::factory()->terbit()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('admin.arsip.update', $arsip), [
            'judul' => 'Judul Diperbarui',
            'kategori' => 'dokumentasi_desa',
            'tipe' => 'artikel',
            'tanggal' => '2026-11-21',
            'status' => 'terbit',
            'isi' => '<p>Isi yang diperbarui.</p>',
        ]);

        $response->assertRedirect(route('admin.arsip.index'));
        $this->assertDatabaseHas('arsips', ['judul' => 'Judul Diperbarui']);
    }

    public function test_admin_can_delete_arsip(): void
    {
        $user = User::factory()->create();
        $arsip = Arsip::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('admin.arsip.destroy', $arsip));

        $response->assertRedirect(route('admin.arsip.index'));
        $this->assertDatabaseMissing('arsips', ['id' => $arsip->id]);
    }

    public function test_image_upload_rejects_file_over_5mb(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.arsip.store'), [
            'judul' => 'Arsip Gambar Besar',
            'kategori' => 'arsip_desa',
            'tipe' => 'artikel',
            'tanggal' => '2026-11-20',
            'status' => 'draft',
            'isi' => '<p>Konten.</p>',
            'gambar_sampul' => UploadedFile::fake()->create('besar.jpg', 6000, 'image/jpeg'),
        ]);

        $response->assertSessionHasErrors('gambar_sampul');
    }

    public function test_pdf_upload_rejects_file_over_10mb(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.arsip.store'), [
            'judul' => 'Arsip PDF Besar',
            'kategori' => 'arsip_desa',
            'tipe' => 'pdf',
            'tanggal' => '2026-11-20',
            'status' => 'draft',
            'file_pdf' => UploadedFile::fake()->create('besar.pdf', 11000, 'application/pdf'),
        ]);

        $response->assertSessionHasErrors('file_pdf');
    }

    public function test_html_is_sanitized(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.arsip.store'), [
            'judul' => 'Arsip XSS',
            'kategori' => 'arsip_desa',
            'tipe' => 'artikel',
            'tanggal' => '2026-11-20',
            'status' => 'draft',
            'isi' => '<p>Aman</p><script>alert("xss")</script>',
            'gambar_sampul' => UploadedFile::fake()->create('sampul.jpg', 1024, 'image/jpeg'),
        ]);

        $arsip = Arsip::where('judul', 'Arsip XSS')->first();
        $this->assertNotNull($arsip);
        $this->assertStringNotContainsString('<script>', $arsip->isi);
        $this->assertStringContainsString('Aman', $arsip->isi);
    }
}
