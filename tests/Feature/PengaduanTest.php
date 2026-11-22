<?php

namespace Tests\Feature;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PengaduanTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_form_requires_one_of_two_current_categories(): void
    {
        $this->get(route('pages.pengaduan'))
            ->assertOk()
            ->assertSee('name="jenis" id="jenis" required', false)
            ->assertSee('<option value="" disabled selected>Pilih Jenis Layanan / Pengaduan</option>', false)
            ->assertSee('Laporan Pengaduan / Aspirasi Warga')
            ->assertSee('Pertanyaan Umum')
            ->assertDontSee('Pengajuan Surat Keterangan');

        foreach (['Laporan Pengaduan / Aspirasi Warga', 'Pertanyaan Umum'] as $jenis) {
            $this->post(route('pages.pengaduan.store'), [
                'nama' => 'Warga '.$jenis,
                'telepon' => '081234567890',
                'jenis' => $jenis,
                'pesan' => 'Laporan uji.',
            ])->assertRedirect(route('pages.pengaduan'));
        }

        $this->assertDatabaseCount('pengaduans', 2);
        $this->assertDatabaseHas('pengaduans', ['jenis' => 'Laporan Pengaduan / Aspirasi Warga']);
        $this->assertDatabaseHas('pengaduans', ['jenis' => 'Pertanyaan Umum']);

        $this->from(route('pages.pengaduan'))->post(route('pages.pengaduan.store'), [
            'nama' => 'Warga Lama',
            'telepon' => '081234567890',
            'jenis' => 'Pengajuan Surat Keterangan',
            'pesan' => 'Kategori lama tidak berlaku untuk pengiriman baru.',
        ])->assertSessionHasErrors('jenis');
    }

    public function test_public_form_saves_complaint_and_private_evidence(): void
    {
        Storage::fake('local');
        $photo = UploadedFile::fake()->create('bukti.jpg', 100, 'image/jpeg');

        $this->post(route('pages.pengaduan.store'), [
            'nama' => 'Warga Betro',
            'telepon' => '081234567890',
            'jenis' => 'Laporan Pengaduan / Aspirasi Warga',
            'pesan' => 'Lampu jalan padam di RT 02.',
            'bukti' => [$photo],
        ])->assertRedirect(route('pages.pengaduan'));

        $pengaduan = Pengaduan::firstOrFail();
        $this->assertSame('baru', $pengaduan->status);
        $this->assertCount(1, $pengaduan->foto);
        Storage::disk('local')->assertExists($pengaduan->foto[0]);
    }

    public function test_guest_cannot_access_complaint_management_or_private_photos(): void
    {
        $pengaduan = Pengaduan::create(['nama' => 'Warga', 'telepon' => '081234567890', 'jenis' => 'Pertanyaan Umum', 'pesan' => 'Isi', 'status' => 'baru']);

        $this->get(route('admin.pengaduan.index'))->assertRedirect(route('login'));
        $this->get(route('admin.pengaduan.show', $pengaduan))->assertRedirect(route('login'));
    }

    public function test_admin_can_create_complaint_manually_and_filter_the_dashboard(): void
    {
        $admin = User::factory()->create();
        $completed = Pengaduan::create(['nama' => 'Warga Selesai', 'telepon' => '081234567890', 'jenis' => 'Pertanyaan Umum', 'pesan' => 'Sudah selesai', 'status' => 'selesai']);
        Pengaduan::create(['nama' => 'Warga Baru', 'telepon' => '081234567891', 'jenis' => 'Pengajuan Surat Keterangan', 'pesan' => 'Menunggu', 'status' => 'baru']);

        $this->actingAs($admin)->get(route('admin.pengaduan.index', ['status' => 'selesai']))
            ->assertOk()
            ->assertSee('Total Pengaduan')
            ->assertSee('Warga Selesai')
            ->assertSee('Pengajuan Surat Keterangan')
            ->assertDontSee('Warga Baru');
        $this->get(route('admin.pengaduan.create'))->assertOk()->assertSee('Tambah Pengaduan');

        $this->post(route('admin.pengaduan.store'), [
            'nama' => 'Input Manual',
            'telepon' => '081234567891',
            'jenis' => 'Pertanyaan Umum',
            'pesan' => 'Dicatat oleh admin.',
            'status' => 'baru',
        ])->assertRedirect();

        $this->assertDatabaseHas('pengaduans', ['nama' => 'Input Manual', 'status' => 'baru']);
        $this->assertModelExists($completed);
    }

    public function test_admin_can_change_status_add_internal_note_and_delete_complaint_photos(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create();
        $photo = UploadedFile::fake()->create('bukti.png', 100, 'image/png');
        $path = $photo->store('pengaduan', 'local');
        $pengaduan = Pengaduan::create(['nama' => 'Warga', 'telepon' => '081234567890', 'jenis' => 'Pertanyaan Umum', 'pesan' => 'Isi', 'foto' => [$path], 'status' => 'baru']);

        $this->actingAs($admin)->put(route('admin.pengaduan.update', $pengaduan), [
            'nama' => 'Warga', 'telepon' => '081234567890', 'jenis' => 'Pertanyaan Umum', 'pesan' => 'Isi diperiksa', 'status' => 'diproses',
        ])->assertRedirect(route('admin.pengaduan.show', $pengaduan));
        $this->assertSame('diproses', $pengaduan->fresh()->status);
        $this->assertDatabaseHas('pengaduan_riwayat_statuses', ['pengaduan_id' => $pengaduan->id, 'status_lama' => 'baru', 'status_baru' => 'diproses']);

        $this->post(route('admin.pengaduan.notes.store', $pengaduan), ['catatan' => 'Sudah dilakukan pengecekan lokasi.'])
            ->assertRedirect();
        $this->assertDatabaseHas('pengaduan_catatans', ['pengaduan_id' => $pengaduan->id, 'catatan' => 'Sudah dilakukan pengecekan lokasi.']);

        $this->delete(route('admin.pengaduan.destroy', $pengaduan))->assertRedirect(route('admin.pengaduan.index'));
        $this->assertDatabaseMissing('pengaduans', ['id' => $pengaduan->id]);
        Storage::disk('local')->assertMissing($path);
    }

    public function test_admin_can_view_detail_and_filtered_exports(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create();
        $photo = UploadedFile::fake()->create('bukti.jpg', 100, 'image/jpeg');
        $path = $photo->store('pengaduan', 'local');
        $pengaduan = Pengaduan::create(['nama' => 'Warga Filter', 'telepon' => '081234567890', 'jenis' => 'Pertanyaan Umum', 'pesan' => 'Isi rinci', 'foto' => [$path], 'status' => 'selesai']);

        $this->actingAs($admin)->get(route('admin.pengaduan.show', $pengaduan))
            ->assertOk()
            ->assertSee('Warga Filter')
            ->assertSee('Isi rinci')
            ->assertSee('https://wa.me/6281234567890');
        $this->get(route('admin.pengaduan.photo', [$pengaduan, 0]))->assertOk();
        $this->get(route('admin.pengaduan.export.excel', ['status' => 'selesai']))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->assertSee('Warga Filter');
        $this->get(route('admin.pengaduan.export.pdf', ['jenis' => 'Pertanyaan Umum']))
            ->assertOk()
            ->assertSee('Warga Filter');
    }

    public function test_public_form_rejects_more_than_three_photos(): void
    {
        $photos = [UploadedFile::fake()->create('1.jpg', 100, 'image/jpeg'), UploadedFile::fake()->create('2.jpg', 100, 'image/jpeg'), UploadedFile::fake()->create('3.jpg', 100, 'image/jpeg'), UploadedFile::fake()->create('4.jpg', 100, 'image/jpeg')];

        $this->from(route('pages.pengaduan'))->post(route('pages.pengaduan.store'), [
            'nama' => 'Warga', 'telepon' => '081234567890', 'jenis' => 'Pertanyaan Umum', 'pesan' => 'Isi', 'bukti' => $photos,
        ])->assertSessionHasErrors('bukti');

        $this->assertDatabaseCount('pengaduans', 0);
    }
}
