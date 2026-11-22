<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VillageOfficial;
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

    public function test_admin_can_create_edit_search_and_delete_officials_and_public_page_uses_database(): void
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
        $this->get(route('pages.profile'))->assertOk()->assertSee('Pemerintah Desa Betro')->assertSee('Nadia Putri');

        $this->put(route('admin.struktur-pemerintahan.update', $official), $this->officialData([
            'nama' => 'Nadia Putri Utami',
            'jabatan' => 'Kepala Seksi Pelayanan',
            'urutan' => 3,
        ]))->assertRedirect(route('admin.struktur-pemerintahan.show', $official));
        $this->get(route('pages.profile'))->assertOk()->assertSee('Nadia Putri Utami')->assertSee('Kepala Seksi Pelayanan');

        $this->delete(route('admin.struktur-pemerintahan.destroy', $official))->assertRedirect(route('admin.struktur-pemerintahan.index'));
        $this->assertDatabaseMissing('village_officials', ['id' => $official->id]);
        $this->get(route('pages.profile'))->assertOk()->assertDontSee('Nadia Putri Utami');
    }

    public function test_only_one_active_head_can_be_selected_and_inactive_records_are_hidden(): void
    {
        $admin = User::factory()->create();
        $this->actingAs($admin)->post(route('admin.struktur-pemerintahan.store'), $this->officialData([
            'nama' => 'Kepala Lama',
            'is_kepala_desa' => 1,
        ]))->assertRedirect(route('admin.struktur-pemerintahan.index'));
        $firstHead = VillageOfficial::query()->firstOrFail();

        $this->post(route('admin.struktur-pemerintahan.store'), $this->officialData([
            'nama' => 'Kepala Baru',
            'jabatan' => 'Kepala Desa',
            'is_kepala_desa' => 1,
            'urutan' => 1,
        ]))->assertRedirect(route('admin.struktur-pemerintahan.index'));

        $firstHead->refresh();
        $secondHead = VillageOfficial::query()->where('nama', 'Kepala Baru')->firstOrFail();
        $this->assertFalse($firstHead->is_kepala_desa);
        $this->assertSame('Perangkat Desa', $firstHead->jabatan);
        $this->assertTrue($secondHead->is_kepala_desa);
        $this->assertSame(1, VillageOfficial::query()->where('is_kepala_desa', true)->where('status', true)->count());
        $this->get(route('pages.profile'))->assertOk()->assertSee('Kepala Baru')->assertSee('Kepala Lama')->assertSee('Perangkat Desa');

        $this->put(route('admin.struktur-pemerintahan.update', $secondHead), $this->officialData([
            'nama' => 'Kepala Baru',
            'jabatan' => 'Kepala Desa',
            'status' => 0,
            'is_kepala_desa' => 1,
        ]))->assertRedirect(route('admin.struktur-pemerintahan.show', $secondHead));
        $secondHead->refresh();
        $this->assertFalse($secondHead->is_kepala_desa);
        $this->get(route('pages.profile'))->assertOk()->assertDontSee('Kepala Baru');
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
