<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VillageBoundary;
use App\Models\VillageDusun;
use App\Models\VillageGeography;
use App\Models\VillageLandUse;
use App\Models\VillageMap;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VillageInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_statistic_tables_are_removed_and_admin_pages_require_authentication(): void
    {
        $this->assertFalse(Schema::hasTable('statistics'));
        $this->assertFalse(Schema::hasTable('statistic_categories'));
        $this->assertFalse(Schema::hasTable('statistic_pages'));
        $this->assertTrue(Schema::hasTable('users'));
        $this->assertTrue(Schema::hasTable('umkms'));
        $this->assertTrue(Schema::hasTable('pengaduans'));

        $this->get(route('admin.wilayah.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.wilayah.profile'))->assertRedirect(route('login'));
        $this->get(route('admin.wilayah.items.index', 'dusun'))->assertRedirect(route('login'));
        $this->get('/informasi/statistik')->assertRedirect('/informasi/wilayah');

        $this->actingAs(User::factory()->create());
        $this->get(route('admin.wilayah.dashboard'))->assertOk();
        $this->get(route('admin.wilayah.profile'))->assertOk();
        $this->get(route('admin.wilayah.boundaries'))->assertOk();
        $this->get(route('admin.wilayah.map'))->assertOk();
        $this->get(route('admin.wilayah.items.index', 'dusun'))->assertOk();
        $this->get(route('admin.wilayah.items.create', 'geografi'))->assertOk();
    }

    public function test_admin_can_manage_profile_boundaries_and_dusun_records(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->put(route('admin.wilayah.profile.update'), [
            'nama_desa' => 'Desa Betro', 'kecamatan' => 'Kemlagi', 'kabupaten' => 'Mojokerto',
            'provinsi' => 'Jawa Timur', 'kode_pos' => '61353', 'luas_wilayah' => 12.5,
            'latitude' => -7.2, 'longitude' => 112.4, 'deskripsi' => 'Deskripsi wilayah.',
            'jumlah_dusun' => 2, 'jumlah_rw' => 4, 'jumlah_rt' => 16,
            'sumber_data' => 'Dokumen uji', 'tahun_data' => 2020,
        ])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('village_profiles', ['nama_desa' => 'Desa Betro', 'luas_wilayah' => 12.5, 'jumlah_dusun' => 2, 'jumlah_rw' => 4, 'jumlah_rt' => 16, 'tahun_data' => 2020]);
        $this->actingAs($admin)->get(route('admin.wilayah.dashboard'))->assertOk()->assertSee('Jumlah Dusun')->assertSee('16');

        $boundaryData = [];
        foreach (VillageBoundary::DIRECTIONS as $direction) {
            $boundaryData[] = ['arah' => $direction, 'wilayah_berbatasan' => $direction === 'Utara' ? 'Wilayah Utara' : '', 'deskripsi' => ''];
        }
        $this->put(route('admin.wilayah.boundaries.update'), ['boundaries' => $boundaryData])->assertSessionHasNoErrors();
        $this->assertDatabaseCount('village_boundaries', 1);
        $this->assertDatabaseHas('village_boundaries', ['arah' => 'Utara', 'wilayah_berbatasan' => 'Wilayah Utara']);

        $this->post(route('admin.wilayah.items.store', 'dusun'), [
            'nama_dusun' => 'Dusun Contoh', 'jumlah_rw' => 2, 'jumlah_rt' => 5, 'luas_wilayah' => 1.2,
            'deskripsi' => 'Keterangan dusun.', 'urutan' => 1, 'status' => 1,
        ])->assertRedirect(route('admin.wilayah.items.index', 'dusun'));
        $dusun = VillageDusun::query()->firstOrFail();
        $this->get(route('admin.wilayah.items.show', ['dusun', $dusun->id]))->assertOk()->assertSee('Dusun Contoh');
        $this->assertSame(2, $dusun->jumlah_rw);
        $this->put(route('admin.wilayah.items.update', ['dusun', $dusun->id]), [
            'nama_dusun' => 'Dusun Diperbarui', 'jumlah_rw' => 3, 'jumlah_rt' => 7,
            'urutan' => 2, 'status' => 1,
        ])->assertRedirect(route('admin.wilayah.items.index', 'dusun'));
        $this->assertDatabaseHas('village_dusuns', ['id' => $dusun->id, 'nama_dusun' => 'Dusun Diperbarui', 'jumlah_rw' => 3]);
        $this->delete(route('admin.wilayah.items.destroy', ['dusun', $dusun->id]))->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('village_dusuns', ['id' => $dusun->id]);
    }

    public function test_admin_can_manage_geography_land_use_and_images_and_public_page_updates(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/pXcAAAAASUVORK5CYII=');
        $image = UploadedFile::fake()->createWithContent('wilayah.png', $png);
        $sourceUrl = 'https://example.com/'.str_repeat('very-long-source-segment', 12);
        $photoUrl = 'https://example.com/panen.jpeg';

        $this->actingAs($admin)->post(route('admin.wilayah.items.store', 'geografi'), [
            'nama_informasi' => 'Topografi', 'nilai' => 'Dataran rendah', 'deskripsi' => 'Kondisi umum.',
            'urutan' => 1, 'status' => 1, 'gambar' => $image, 'sumber_data' => 'Sumber uji: '.$sourceUrl.' Foto kegiatan: '.$photoUrl, 'tahun_data' => 2024,
        ])->assertRedirect(route('admin.wilayah.items.index', 'geografi'));
        $geography = VillageGeography::query()->firstOrFail();
        Storage::disk('public')->assertExists($geography->gambar);

        $this->post(route('admin.wilayah.items.store', 'lahan'), [
            'nama_kategori' => 'Lahan Uji', 'luas' => 2.5, 'satuan' => 'ha',
            'deskripsi' => 'Area permukiman.', 'urutan' => 1, 'status' => 1,
        ])->assertRedirect(route('admin.wilayah.items.index', 'lahan'));
        $land = VillageLandUse::query()->where('nama_kategori', 'Lahan Uji')->firstOrFail();
        $this->put(route('admin.wilayah.items.update', ['lahan', $land->id]), [
            'nama_kategori' => 'Lahan Uji', 'luas' => 3.5, 'satuan' => 'ha',
            'urutan' => 1, 'status' => 1,
        ])->assertRedirect(route('admin.wilayah.items.index', 'lahan'));

        $this->get(route('pages.wilayah'))->assertOk()->assertSee('Topografi')->assertSee('Sumber uji')->assertSee('Foto kegiatan:')->assertSee('Buka sumber ↗')->assertSee('Lihat foto kegiatan ↗')->assertSee('Data 2024')->assertSee('href="'.$sourceUrl.'" target="_blank" rel="noopener noreferrer"', false)->assertSee('href="'.$photoUrl.'" target="_blank" rel="noopener noreferrer"', false)->assertSee('overflow-wrap:anywhere', false)->assertSee('text-blue-700 underline', false)->assertSee('Lahan Uji')->assertSee('conic-gradient');
        $this->assertDatabaseHas('village_land_uses', ['id' => $land->id, 'luas' => 3.5]);
    }

    public function test_admin_can_update_map_and_public_page_only_shows_published_content(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/pXcAAAAASUVORK5CYII=');
        $this->actingAs($admin)->put(route('admin.wilayah.map.update'), [
            'nama_peta' => 'Peta Desa', 'latitude' => -7.25, 'longitude' => 112.45,
            'boundary_geojson' => '{"type":"Polygon","coordinates":[]}', 'status' => 1,
            'gambar' => UploadedFile::fake()->createWithContent('map.png', $png),
        ])->assertSessionHasNoErrors();
        $map = VillageMap::query()->firstOrFail();
        Storage::disk('public')->assertExists($map->gambar);
        $this->assertDatabaseHas('village_maps', ['id' => $map->id, 'nama_peta' => 'Peta Desa', 'status' => 1]);

        VillageGeography::query()->create(['nama_informasi' => 'Informasi Draft', 'status' => false]);
        $this->get(route('pages.wilayah'))->assertOk()->assertSee('Peta Desa')->assertDontSee('Informasi Draft');
        $this->get('/informasi/statistik/statistik-kependudukan')->assertRedirect('/informasi/wilayah');
    }
}
