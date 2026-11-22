<?php

namespace Tests\Feature;

use App\Models\Statistic;
use App\Models\StatisticCategory;
use App\Models\StatisticPage;
use App\Models\User;
use Database\Seeders\StatisticSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StatisticManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_statistic_management(): void
    {
        $this->get(route('admin.statistik.index'))->assertRedirect(route('login'));
        $this->get(route('admin.statistik.kategori.index'))->assertRedirect(route('login'));
        $this->get(route('admin.statistik.halaman.index'))->assertRedirect(route('login'));
        $this->get(route('admin.statistik.tahun'))->assertRedirect(route('login'));
    }

    public function test_admin_can_manage_categories_and_categories_with_data_cannot_be_deleted(): void
    {
        $admin = User::factory()->create();
        $this->assertDatabaseCount('statistic_categories', 6);

        $this->actingAs($admin)->post(route('admin.statistik.kategori.store'), [
            'page_id' => StatisticCategory::where('slug', 'kependudukan')->value('page_id'),
            'nama_kategori' => 'Lingkungan',
            'deskripsi' => 'Data lingkungan desa.',
            'ikon' => '🌱',
            'visualization_type' => 'bar',
            'urutan' => 7,
            'status' => 1,
        ])->assertRedirect(route('admin.statistik.kategori.index'));

        $category = StatisticCategory::where('nama_kategori', 'Lingkungan')->firstOrFail();
        $this->get(route('admin.statistik.create'))->assertOk()->assertSee('Lingkungan');
        $this->put(route('admin.statistik.kategori.update', $category), [
            'page_id' => $category->page_id,
            'nama_kategori' => 'Lingkungan Hidup',
            'deskripsi' => 'Deskripsi baru.',
            'ikon' => '🍃',
            'visualization_type' => 'pie',
            'urutan' => 8,
            'status' => 1,
        ])->assertRedirect(route('admin.statistik.kategori.index'));
        $this->assertDatabaseHas('statistic_categories', ['id' => $category->id, 'nama_kategori' => 'Lingkungan Hidup', 'slug' => 'lingkungan-hidup']);

        $statistic = Statistic::create($this->statisticData($category->id, 'Tutupan Pohon', 2026, 75));
        $this->delete(route('admin.statistik.kategori.destroy', $category))
            ->assertRedirect()
            ->assertSessionHas('error');
        $this->assertModelExists($category);

        $this->delete(route('admin.statistik.destroy', $statistic))->assertRedirect(route('admin.statistik.index'));
        $this->delete(route('admin.statistik.kategori.destroy', $category))->assertRedirect(route('admin.statistik.kategori.index'));
        $this->assertDatabaseMissing('statistic_categories', ['id' => $category->id]);
    }

    public function test_statistics_keep_yearly_history_and_prevent_duplicate_indicators_per_year(): void
    {
        $admin = User::factory()->create();
        $category = StatisticCategory::where('slug', 'kependudukan')->firstOrFail();

        $this->actingAs($admin)->post(route('admin.statistik.store'), $this->statisticData($category->id, 'Jumlah Penduduk', 2025, 3250))
            ->assertRedirect(route('admin.statistik.index'));
        $firstYear = Statistic::where('tahun', 2025)->firstOrFail();

        $this->post(route('admin.statistik.store'), $this->statisticData($category->id, 'Jumlah Penduduk', 2026, 3300))
            ->assertRedirect(route('admin.statistik.index'));
        $this->assertDatabaseCount('statistics', 2);
        $this->assertDatabaseHas('statistics', ['slug' => 'jumlah-penduduk', 'tahun' => 2025, 'nilai' => 3250]);
        $this->assertDatabaseHas('statistics', ['slug' => 'jumlah-penduduk', 'tahun' => 2026, 'nilai' => 3300]);

        $this->from(route('admin.statistik.create'))->post(route('admin.statistik.store'), $this->statisticData($category->id, 'Jumlah Penduduk', 2026, 3350))
            ->assertSessionHasErrors('nama_statistik');
        $this->assertDatabaseCount('statistics', 2);

        $this->put(route('admin.statistik.update', $firstYear), $this->statisticData($category->id, 'Jumlah Penduduk', 2025, 3260))
            ->assertRedirect(route('admin.statistik.show', $firstYear));
        $this->assertDatabaseHas('statistics', ['id' => $firstYear->id, 'tahun' => 2025, 'nilai' => 3260]);
        $this->assertDatabaseHas('statistics', ['tahun' => 2026, 'nilai' => 3300]);
    }

    public function test_admin_statistics_dashboard_search_filters_detail_and_pagination_work(): void
    {
        $admin = User::factory()->create();
        $category = StatisticCategory::where('slug', 'fasilitas-umum')->firstOrFail();
        foreach (range(1, 11) as $number) {
            Statistic::create($this->statisticData($category->id, 'Fasilitas '.$number, 2020 + $number, $number));
        }

        $this->actingAs($admin)->get(route('admin.statistik.index', ['cari' => 'Fasilitas', 'kategori' => $category->id, 'status' => 'aktif']))
            ->assertOk()
            ->assertSee('Total Data Statistik')
            ->assertSee('Fasilitas 11')
            ->assertDontSee('>Fasilitas 1</a>', false)
            ->assertSee('page=2', false);
        $statistic = Statistic::where('nama_statistik', 'Fasilitas 1')->firstOrFail();
        $this->get(route('admin.statistik.index', ['cari' => 'Fasilitas', 'kategori' => $category->id, 'status' => 'aktif', 'page' => 2]))
            ->assertOk()->assertSee('Fasilitas 1');
        $this->get(route('admin.statistik.show', $statistic))->assertOk()->assertSee('Fasilitas 1');
        $this->get(route('admin.statistik.edit', $statistic))->assertOk()->assertSee('name="tahun"', false);
    }

    public function test_public_statistics_filter_years_show_only_published_data_and_compare_years(): void
    {
        $population = StatisticCategory::where('slug', 'kependudukan')->firstOrFail();
        $customCategory = StatisticCategory::create([
            'nama_kategori' => 'Lingkungan',
            'slug' => 'lingkungan',
            'deskripsi' => 'Data lingkungan.',
            'ikon' => '🌱',
            'urutan' => 7,
            'status' => true,
        ]);
        $first = Statistic::create($this->statisticData($population->id, 'Jumlah Penduduk', 2025, 1000, true));
        Statistic::create($this->statisticData($population->id, 'Jumlah Penduduk', 2026, 1100, true));
        $internalData = $this->statisticData($population->id, 'Data Internal', 2026, 50);
        $internalData['status'] = 'nonaktif';
        Statistic::create($internalData);
        Statistic::create($this->statisticData($customCategory->id, 'Pohon Tertanam', 2026, 25));

        $this->get(route('pages.informasi.statistik'))
            ->assertOk()
            ->assertSee('1.100')
            ->assertSee('Pohon Tertanam')
            ->assertDontSee('Data Internal');
        $this->get(route('pages.informasi.statistik', ['tahun' => 2025]))
            ->assertOk()
            ->assertSee('1.000')
            ->assertDontSee('1.100')
            ->assertDontSee('25 <span class="text-sm font-semibold text-gray-500">jiwa</span>', false);
        $this->get(route('pages.informasi.statistik', ['tahun' => 'semua']))
            ->assertOk()
            ->assertSee('Ringkasan Statistik 2025')
            ->assertSee('Ringkasan Statistik 2026');
        $this->get(route('pages.informasi.statistik', ['banding_id' => $first->id]))
            ->assertOk()
            ->assertSee('Perubahan: 100')
            ->assertSee('+10,00%');

        $customCategory->update(['status' => false]);
        $this->get(route('pages.informasi.statistik', ['tahun' => 2026]))
            ->assertOk()
            ->assertDontSee('Pohon Tertanam</p>', false);
    }

    public function test_statistics_reject_invalid_values_years_and_unknown_categories(): void
    {
        $admin = User::factory()->create();
        $category = StatisticCategory::where('slug', 'wilayah')->firstOrFail();
        $payload = $this->statisticData($category->id, 'Luas Wilayah', 2026, -2);

        $this->actingAs($admin)->from(route('admin.statistik.create'))->post(route('admin.statistik.store'), $payload)
            ->assertSessionHasErrors('nilai');
        $payload = $this->statisticData(99999, 'Luas Wilayah', 2026, 4.25);
        $this->from(route('admin.statistik.create'))->post(route('admin.statistik.store'), $payload)
            ->assertSessionHasErrors('category_id');
        $payload = $this->statisticData($category->id, 'Luas Wilayah', 1800, 4.25);
        $this->from(route('admin.statistik.create'))->post(route('admin.statistik.store'), $payload)
            ->assertSessionHasErrors('tahun');
        $this->post(route('admin.statistik.store'), $this->statisticData($category->id, 'Luas Wilayah', 2026, 4.25))
            ->assertRedirect(route('admin.statistik.index'));
        $this->assertDatabaseHas('statistics', ['nama_statistik' => 'Luas Wilayah', 'nilai' => 4.25]);
        $this->assertDatabaseCount('statistics', 1);
    }

    public function test_statistics_pages_can_be_managed_and_seed_data_is_idempotent(): void
    {
        $admin = User::factory()->create();
        $this->actingAs($admin)->post(route('admin.statistik.halaman.store'), [
            'title' => 'Statistik Lingkungan',
            'description' => 'Kondisi lingkungan desa.',
            'sort_order' => 7,
            'status' => 1,
        ])->assertRedirect(route('admin.statistik.halaman.index'));
        $page = StatisticPage::query()->where('slug', 'statistik-lingkungan')->firstOrFail();
        $this->get(route('admin.statistik.halaman.index'))->assertOk()->assertSee('Statistik Lingkungan');

        $this->seed(StatisticSeeder::class);
        $seededCount = Statistic::count();
        $this->seed(StatisticSeeder::class);
        $this->assertSame($seededCount, Statistic::count());
        $this->assertDatabaseHas('statistics', ['slug' => 'total-penduduk', 'tahun' => 2014, 'nilai' => '3985.0000']);

        $totalPopulation = Statistic::query()->where('slug', 'total-penduduk')->firstOrFail();
        $this->get(route('pages.informasi.statistik.page', ['slug' => 'statistik-kependudukan']))
            ->assertOk()->assertSee('3.985')->assertSee('tahun 2014');
        $totalPopulation->update(['nilai' => 4200]);
        $this->get(route('pages.home'))->assertOk()->assertSee('4.200');
        $this->get(route('pages.informasi'))->assertOk()->assertSee('4.200');
        $this->assertDatabaseHas('statistic_pages', ['id' => $page->id, 'slug' => 'statistik-lingkungan']);
    }

    public function test_statistic_images_are_validated_and_stored_for_public_use(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $category = StatisticCategory::query()->where('slug', 'wilayah')->firstOrFail();
        $payload = $this->statisticData($category->id, 'Gambar Uji', 2026, 1);
        $pixelPng = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/pXcAAAAASUVORK5CYII=');
        $payload['gambar'] = UploadedFile::fake()->createWithContent('illustration.png', $pixelPng);

        $this->actingAs($admin)->post(route('admin.statistik.store'), $payload)->assertRedirect(route('admin.statistik.index'));
        $statistic = Statistic::query()->where('slug', 'gambar-uji')->firstOrFail();
        $this->assertNotNull($statistic->gambar);
        Storage::disk('public')->assertExists($statistic->gambar);
    }

    /** @return array<string, mixed> */
    private function statisticData(int $categoryId, string $name, int $year, int|float $value, bool $summary = false): array
    {
        return [
            'nama_statistik' => $name,
            'page_id' => StatisticCategory::query()->whereKey($categoryId)->value('page_id') ?? 1,
            'category_id' => $categoryId,
            'nilai' => $value,
            'satuan' => 'jiwa',
            'tahun' => $year,
            'deskripsi' => 'Data agregat untuk pengujian.',
            'sumber_data' => 'Administrasi desa',
            'ikon' => '📊',
            'urutan' => 1,
            'tampil_di_ringkasan' => $summary ? 1 : 0,
            'status' => 'aktif',
        ];
    }
}
