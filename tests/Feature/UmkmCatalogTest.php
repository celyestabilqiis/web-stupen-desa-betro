<?php

namespace Tests\Feature;

use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UmkmCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_catalog_shows_only_published_database_records(): void
    {
        $published = Umkm::create(['nama_usaha' => 'Dapur Kue Betro', 'slug' => 'dapur-kue-betro', 'kategori' => 'Kuliner dan Makanan', 'deskripsi_singkat' => 'Kue rumahan', 'status' => 'terbit', 'is_demo' => true]);
        $published->products()->create(['nama_produk' => 'Brownies Cokelat', 'harga' => 35000, 'satuan' => 'per kotak', 'tersedia' => true]);
        Umkm::create(['nama_usaha' => 'Usaha Draft', 'slug' => 'usaha-draft', 'kategori' => 'Kuliner', 'status' => 'draft']);

        $this->get(route('pages.potensi'))
            ->assertOk()
            ->assertSee('Dapur Kue Betro')
            ->assertSee('Kuliner dan Makanan')
            ->assertSee('DATA DEMONSTRASI')
            ->assertDontSee('Usaha Draft')
            ->assertDontSee('Keripik Singkong Betro')
            ->assertDontSee('Sambal &amp; Bumbu Dapur');

        $this->get(route('pages.umkm.show', $published->slug))
            ->assertOk()
            ->assertSee('Brownies Cokelat')
            ->assertSee('Rp35.000')
            ->assertSee('per kotak');

        $this->get(route('pages.umkm.show', 'usaha-draft'))->assertNotFound();
    }

    public function test_public_catalog_searches_business_and_product_fields_without_duplicates(): void
    {
        $umkm = Umkm::create([
            'nama_usaha' => 'Warung Pojok Betro',
            'slug' => 'warung-pojok-betro',
            'kategori' => 'Kuliner',
            'deskripsi_singkat' => 'Menyediakan hidangan rumahan',
            'deskripsi_lengkap' => 'Usaha kuliner dengan layanan pesan antar.',
            'status' => 'terbit',
        ]);
        $umkm->products()->create(['nama_produk' => 'Sambal Nanas', 'deskripsi' => 'Sambal buah segar khas desa']);
        $umkm->products()->create(['nama_produk' => 'Sambal Mangga', 'deskripsi' => 'Sambal segar lainnya']);

        $this->get(route('pages.potensi', ['cari' => 'Warung Pojok']))
            ->assertOk()
            ->assertSee('Warung Pojok Betro');
        $productSearch = $this->get(route('pages.potensi', ['cari' => 'Sambal']))
            ->assertOk()
            ->assertSee('Warung Pojok Betro')
            ->assertDontSee('Data UMKM tidak ditemukan');
        $this->assertSame(1, substr_count($productSearch->getContent(), 'href="'.route('pages.umkm.show', $umkm->slug).'"'));
        $this->get(route('pages.potensi', ['cari' => 'pesan antar']))
            ->assertOk()
            ->assertSee('Warung Pojok Betro');
        $this->get(route('pages.potensi', ['cari' => 'buah segar']))
            ->assertOk()
            ->assertSee('Warung Pojok Betro');
        $this->get(route('pages.potensi', ['cari' => 'tidak-ada-hasil']))
            ->assertOk()
            ->assertSee('Data UMKM tidak ditemukan');
    }

    public function test_public_catalog_paginates_six_results_and_preserves_search(): void
    {
        foreach (range(1, 7) as $number) {
            Umkm::create([
                'nama_usaha' => 'Usaha Pencarian '.$number,
                'slug' => 'usaha-pencarian-'.$number,
                'kategori' => 'Kuliner',
                'deskripsi_singkat' => 'Hasil khusus paginasi',
                'status' => 'terbit',
            ]);
        }

        $this->get(route('pages.potensi', ['cari' => 'khusus paginasi']))
            ->assertOk()
            ->assertSee('Usaha Pencarian 1')
            ->assertDontSee('Usaha Pencarian 7')
            ->assertSee('cari=khusus%20paginasi', false)
            ->assertSee('page=2', false);
        $this->get(route('pages.potensi', ['cari' => 'khusus paginasi', 'page' => 2]))
            ->assertOk()
            ->assertSee('Usaha Pencarian 7')
            ->assertSee('Sebelumnya')
            ->assertSee('Berikutnya');
    }

    public function test_administrator_can_create_and_edit_umkm_and_products(): void
    {
        $admin = User::factory()->create();
        $this->actingAs($admin)->post(route('admin.umkm.store'), [
            'nama_usaha' => 'Dapur Contoh', 'kategori' => 'Kuliner dan Makanan', 'status' => 'draft',
            'products' => [
                ['nama_produk' => 'Bolu Pisang', 'harga' => 25000, 'satuan' => 'per loyang', 'tersedia' => 1],
                ['nama_produk' => 'Brownies', 'harga' => 35000, 'satuan' => 'per kotak', 'tersedia' => 1],
            ],
        ])->assertRedirect(route('admin.umkm.index'));

        $umkm = Umkm::with('products')->firstOrFail();
        $this->assertSame('Bolu Pisang', $umkm->products->first()->nama_produk);
        $this->get(route('pages.potensi'))->assertDontSee('Dapur Contoh');

        $productId = $umkm->products->first()->id;
        $this->put(route('admin.umkm.update', $umkm), [
            'nama_usaha' => 'Dapur Contoh Baru', 'kategori' => 'Kuliner', 'status' => 'terbit',
            'products' => [['id' => $productId, 'nama_produk' => 'Bolu Pisang', 'harga' => 27000, 'satuan' => 'per loyang', 'tersedia' => 0]],
        ])->assertRedirect(route('admin.umkm.index'));

        $umkm->refresh()->load('products');
        $this->assertSame('Dapur Contoh Baru', $umkm->nama_usaha);
        $this->assertSame($productId, $umkm->products->first()->id);
        $this->assertSame(27000, $umkm->products->first()->harga);
        $this->assertFalse($umkm->products->first()->tersedia);
        $this->assertCount(1, $umkm->products);
        $this->get(route('pages.potensi'))->assertSee('Dapur Contoh Baru');
    }

    public function test_admin_can_search_and_filter_umkm_records(): void
    {
        $admin = User::factory()->create();
        Umkm::create(['nama_usaha' => 'Dapur Terbit', 'slug' => 'dapur-terbit', 'kategori' => 'Kuliner', 'status' => 'terbit']);
        Umkm::create(['nama_usaha' => 'Kebun Draft', 'slug' => 'kebun-draft', 'kategori' => 'Pertanian', 'status' => 'draft']);

        $this->actingAs($admin)->get(route('admin.umkm.index', ['cari' => 'Dapur', 'status' => 'terbit']))
            ->assertOk()
            ->assertSee('Dapur Terbit')
            ->assertDontSee('Kebun Draft');
    }

    public function test_umkm_and_product_photos_are_uploaded_and_kept_after_edit(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $tinyPng = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+aS6kAAAAASUVORK5CYII=');
        $this->actingAs($admin)->post(route('admin.umkm.store'), [
            'nama_usaha' => 'Dapur Foto', 'kategori' => 'Kuliner', 'status' => 'terbit',
            'foto' => UploadedFile::fake()->createWithContent('usaha.png', $tinyPng),
            'products' => [['nama_produk' => 'Kue Foto', 'harga' => 10000, 'foto' => UploadedFile::fake()->createWithContent('produk.png', $tinyPng)]],
        ])->assertRedirect(route('admin.umkm.index'));

        $umkm = Umkm::with('products')->firstOrFail();
        Storage::disk('public')->assertExists($umkm->foto);
        Storage::disk('public')->assertExists($umkm->products->first()->foto);
        $mainPhoto = $umkm->foto;
        $productPhoto = $umkm->products->first()->foto;

        $this->put(route('admin.umkm.update', $umkm), [
            'nama_usaha' => 'Dapur Foto', 'kategori' => 'Kuliner', 'status' => 'terbit',
            'products' => [['id' => $umkm->products->first()->id, 'nama_produk' => 'Kue Foto Revisi', 'harga' => 11000]],
        ])->assertRedirect(route('admin.umkm.index'));

        $umkm->refresh()->load('products');
        $this->assertSame($mainPhoto, $umkm->foto);
        $this->assertSame($productPhoto, $umkm->products->first()->foto);
        Storage::disk('public')->assertExists($productPhoto);
    }

    public function test_dashboard_displays_only_the_three_most_recent_umkm(): void
    {
        $admin = User::factory()->create();
        foreach (range(1, 4) as $number) {
            $umkm = Umkm::create(['nama_usaha' => 'Usaha '.$number, 'slug' => 'usaha-'.$number, 'kategori' => 'Kuliner', 'status' => 'draft']);
            $umkm->forceFill(['created_at' => now()->addSeconds($number)])->saveQuietly();
        }

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('UMKM Terbaru')
            ->assertSee('Kelola Semua UMKM')
            ->assertSee('Usaha 4')
            ->assertDontSee('Usaha 1');
    }
}
