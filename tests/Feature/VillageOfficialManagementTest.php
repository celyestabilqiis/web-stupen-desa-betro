<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VillageOfficial;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VillageOfficialManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_official_management(): void
    {
        $this->get(route('admin.struktur-pemerintahan.index'))->assertRedirect(route('login'));
        $this->get(route('admin.struktur-pemerintahan.create'))->assertRedirect(route('login'));
    }

    public function test_admin_can_create_edit_search_and_delete_officials(): void
    {
        $admin = User::factory()->create();
        $this->actingAs($admin)->post(route('admin.struktur-pemerintahan.store'), $this->officialData([
            'nama' => 'Nadia Putri',
            'jabatan' => 'Sekretaris Desa',
        ]))->assertRedirect(route('admin.struktur-pemerintahan.index'));

        $official = VillageOfficial::query()->firstOrFail();
        $this->assertDatabaseHas('village_officials', ['nama' => 'Nadia Putri', 'jabatan' => 'Sekretaris Desa']);
        $this->get(route('admin.struktur-pemerintahan.index', ['cari' => 'Nadia', 'jabatan' => 'Sekretaris Desa']))
            ->assertOk()->assertSee('Nadia Putri')->assertSee('Sekretaris Desa');

        $this->put(route('admin.struktur-pemerintahan.update', $official), $this->officialData([
            'nama' => 'Nadia Putri Utami',
            'jabatan' => 'Kepala Seksi Pelayanan',
            'urutan' => 3,
        ]))->assertRedirect(route('admin.struktur-pemerintahan.show', $official));
        $this->assertDatabaseHas('village_officials', ['id' => $official->id, 'nama' => 'Nadia Putri Utami', 'jabatan' => 'Kepala Seksi Pelayanan']);

        $this->delete(route('admin.struktur-pemerintahan.destroy', $official))->assertRedirect(route('admin.struktur-pemerintahan.index'));
        $this->assertDatabaseMissing('village_officials', ['id' => $official->id]);
    }

    public function test_public_profile_page_displays_redesigned_government_structure(): void
    {
        VillageOfficial::create([
            'nama' => 'Budi Santoso',
            'jabatan' => 'Kepala Desa',
            'is_kepala_desa' => true,
            'urutan' => 1,
            'status' => true,
        ]);

        VillageOfficial::create([
            'nama' => 'Siti Aminah',
            'jabatan' => 'Sekretaris Desa',
            'is_kepala_desa' => false,
            'urutan' => 2,
            'status' => true,
        ]);

        VillageOfficial::create([
            'nama' => 'Ahmad Fauzi',
            'jabatan' => 'Kasi Pemerintahan',
            'is_kepala_desa' => false,
            'urutan' => 3,
            'status' => true,
        ]);

        $response = $this->get(route('pages.profile'))->assertOk();

        // 1. Judul Bagian: PEMERINTAH DESA BETRO
        $response->assertSee('PEMERINTAH DESA BETRO');

        // 2. Kepala Desa tampil di kartu utama terpisah
        $response->assertSee('BUDI SANTOSO');
        $response->assertSee('Kepala Desa');

        // 3. Perangkat Desa lainnya tersusun dalam grid
        $response->assertSee('SITI AMINAH');
        $response->assertSee('Sekretaris Desa');
        $response->assertSee('AHMAD FAUZI');
        $response->assertSee('Kasi Pemerintahan');
    }

    public function test_admin_can_add_kepala_desa_when_none_exists(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post(route('admin.struktur-pemerintahan.store'), $this->officialData([
            'nama' => 'Budi Santoso',
            'jabatan' => 'Kepala Desa',
            'is_kepala_desa' => 1,
            'status' => 1,
        ]))->assertRedirect(route('admin.struktur-pemerintahan.index'));

        $this->assertDatabaseHas('village_officials', [
            'nama' => 'Budi Santoso',
            'jabatan' => 'Kepala Desa',
            'is_kepala_desa' => true,
            'status' => true,
        ]);
    }

    public function test_admin_cannot_add_second_kepala_desa_when_one_exists(): void
    {
        $admin = User::factory()->create();

        // Kepala Desa pertama
        VillageOfficial::create([
            'nama' => 'Budi Santoso',
            'jabatan' => 'Kepala Desa',
            'is_kepala_desa' => true,
            'urutan' => 1,
            'status' => true,
        ]);

        // Coba menambahkan Kepala Desa kedua melalui checkbox is_kepala_desa
        $response = $this->actingAs($admin)
            ->from(route('admin.struktur-pemerintahan.create'))
            ->post(route('admin.struktur-pemerintahan.store'), $this->officialData([
                'nama' => 'Joko Widodo',
                'jabatan' => 'Kepala Desa Baru',
                'is_kepala_desa' => 1,
            ]));

        $response->assertSessionHasErrors([
            'is_kepala_desa' => 'Jabatan Kepala Desa sudah terisi. Silakan edit data Kepala Desa yang sudah ada atau hapus data sebelumnya sebelum menambahkan Kepala Desa yang baru.',
        ]);

        $this->assertSame(1, VillageOfficial::query()->where('is_kepala_desa', true)->count());
        $this->assertDatabaseMissing('village_officials', ['nama' => 'Joko Widodo']);
    }

    public function test_admin_cannot_add_official_with_kepala_desa_role_when_one_exists(): void
    {
        $admin = User::factory()->create();

        // Kepala Desa pertama
        VillageOfficial::create([
            'nama' => 'Budi Santoso',
            'jabatan' => 'Kepala Desa',
            'is_kepala_desa' => true,
            'urutan' => 1,
            'status' => true,
        ]);

        // Coba menambahkan perangkat lain dengan input jabatan 'Kepala Desa'
        $response = $this->actingAs($admin)
            ->from(route('admin.struktur-pemerintahan.create'))
            ->post(route('admin.struktur-pemerintahan.store'), $this->officialData([
                'nama' => 'Agus Salim',
                'jabatan' => 'Kepala Desa',
                'is_kepala_desa' => 0,
            ]));

        $response->assertSessionHasErrors([
            'jabatan' => 'Jabatan Kepala Desa sudah terisi. Silakan edit data Kepala Desa yang sudah ada atau hapus data sebelumnya sebelum menambahkan Kepala Desa yang baru.',
        ]);

        $this->assertSame(1, VillageOfficial::query()->where('is_kepala_desa', true)->count());
        $this->assertDatabaseMissing('village_officials', ['nama' => 'Agus Salim']);
    }

    public function test_admin_can_edit_existing_kepala_desa_record(): void
    {
        $admin = User::factory()->create();

        $head = VillageOfficial::create([
            'nama' => 'Budi Santoso',
            'jabatan' => 'Kepala Desa',
            'is_kepala_desa' => true,
            'urutan' => 1,
            'status' => true,
        ]);

        $response = $this->actingAs($admin)
            ->put(route('admin.struktur-pemerintahan.update', $head), $this->officialData([
                'nama' => 'Budi Santoso, S.Sos.',
                'jabatan' => 'Kepala Desa',
                'is_kepala_desa' => 1,
                'urutan' => 1,
                'status' => 1,
            ]));

        $response->assertRedirect(route('admin.struktur-pemerintahan.show', $head));
        $head->refresh();
        $this->assertSame('Budi Santoso, S.Sos.', $head->nama);
        $this->assertTrue($head->is_kepala_desa);
    }

    public function test_admin_cannot_update_another_official_to_become_kepala_desa_while_one_exists(): void
    {
        $admin = User::factory()->create();

        VillageOfficial::create([
            'nama' => 'Budi Santoso',
            'jabatan' => 'Kepala Desa',
            'is_kepala_desa' => true,
            'urutan' => 1,
            'status' => true,
        ]);

        $other = VillageOfficial::create([
            'nama' => 'Siti Aminah',
            'jabatan' => 'Sekretaris Desa',
            'is_kepala_desa' => false,
            'urutan' => 2,
            'status' => true,
        ]);

        $response = $this->actingAs($admin)
            ->from(route('admin.struktur-pemerintahan.edit', $other))
            ->put(route('admin.struktur-pemerintahan.update', $other), $this->officialData([
                'nama' => 'Siti Aminah',
                'jabatan' => 'Kepala Desa',
                'is_kepala_desa' => 1,
            ]));

        $response->assertSessionHasErrors([
            'is_kepala_desa' => 'Jabatan Kepala Desa sudah terisi. Silakan edit data Kepala Desa yang sudah ada atau hapus data sebelumnya sebelum menambahkan Kepala Desa yang baru.',
        ]);

        $other->refresh();
        $this->assertFalse($other->is_kepala_desa);
        $this->assertSame('Sekretaris Desa', $other->jabatan);
    }

    public function test_deleting_kepala_desa_vacates_position_allowing_new_head_to_be_added(): void
    {
        $admin = User::factory()->create();

        $head = VillageOfficial::create([
            'nama' => 'Kepala Lama',
            'jabatan' => 'Kepala Desa',
            'is_kepala_desa' => true,
            'urutan' => 1,
            'status' => true,
        ]);

        // Hapus Kepala Desa lama
        $this->actingAs($admin)
            ->delete(route('admin.struktur-pemerintahan.destroy', $head))
            ->assertRedirect(route('admin.struktur-pemerintahan.index'));

        $this->assertDatabaseMissing('village_officials', ['id' => $head->id]);
        $this->assertSame(0, VillageOfficial::query()->where('is_kepala_desa', true)->count());

        // Tambah Kepala Desa baru
        $this->post(route('admin.struktur-pemerintahan.store'), $this->officialData([
            'nama' => 'Kepala Baru',
            'jabatan' => 'Kepala Desa',
            'is_kepala_desa' => 1,
        ]))->assertRedirect(route('admin.struktur-pemerintahan.index'));

        $this->assertDatabaseHas('village_officials', [
            'nama' => 'Kepala Baru',
            'is_kepala_desa' => true,
        ]);
    }

    public function test_database_level_unique_constraint_prevents_duplicate_kepala_desa(): void
    {
        VillageOfficial::create([
            'nama' => 'Kepala Satu',
            'jabatan' => 'Kepala Desa',
            'is_kepala_desa' => true,
            'urutan' => 1,
            'status' => true,
        ]);

        $this->expectException(QueryException::class);

        // Bypass controller dan coba insert langsung via Eloquent
        VillageOfficial::create([
            'nama' => 'Kepala Dua',
            'jabatan' => 'Kepala Desa',
            'is_kepala_desa' => true,
            'urutan' => 2,
            'status' => true,
        ]);
    }

    public function test_official_photos_are_previewable_uploadable_replaceable_and_removed_when_unused(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $firstPhoto = UploadedFile::fake()->createWithContent('official.png', $this->pixelPng());
        $this->actingAs($admin)->post(route('admin.struktur-pemerintahan.store'), $this->officialData([
            'foto' => $firstPhoto,
        ]))->assertRedirect(route('admin.struktur-pemerintahan.index'));
        $official = VillageOfficial::query()->firstOrFail();
        Storage::disk('public')->assertExists($official->foto);
        $this->get(route('admin.struktur-pemerintahan.edit', $official))->assertOk()->assertSee('official-photo-preview');

        $oldPhotoPath = $official->foto;
        $replacementPhoto = UploadedFile::fake()->createWithContent('official-new.png', $this->pixelPng());
        $this->put(route('admin.struktur-pemerintahan.update', $official), $this->officialData([
            'nama' => $official->nama,
            'jabatan' => $official->jabatan,
            'foto' => $replacementPhoto,
        ]))->assertRedirect(route('admin.struktur-pemerintahan.show', $official));
        $official->refresh();
        Storage::disk('public')->assertMissing($oldPhotoPath);
        Storage::disk('public')->assertExists($official->foto);

        $this->delete(route('admin.struktur-pemerintahan.destroy', $official))->assertRedirect(route('admin.struktur-pemerintahan.index'));
        Storage::disk('public')->assertMissing($official->foto);
    }

    public function test_unsupported_photo_files_are_rejected(): void
    {
        $admin = User::factory()->create();
        $payload = $this->officialData(['foto' => UploadedFile::fake()->create('payload.txt', 5, 'text/plain')]);

        $this->actingAs($admin)->from(route('admin.struktur-pemerintahan.create'))
            ->post(route('admin.struktur-pemerintahan.store'), $payload)
            ->assertSessionHasErrors('foto');
        $this->assertDatabaseCount('village_officials', 0);
    }

    /** @return array<string, mixed> */
    private function officialData(array $overrides = []): array
    {
        return array_merge([
            'nama' => 'Perangkat Desa',
            'jabatan' => 'Staf Teknis',
            'deskripsi' => 'Informasi perangkat desa.',
            'urutan' => 1,
            'status' => 1,
            'is_kepala_desa' => 0,
        ], $overrides);
    }

    private function pixelPng(): string
    {
        return base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/pXcAAAAASUVORK5CYII=');
    }
}
