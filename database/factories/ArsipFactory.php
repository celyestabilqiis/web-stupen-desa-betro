<?php

namespace Database\Factories;

use App\Models\Arsip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Arsip>
 */
class ArsipFactory extends Factory
{
    protected $model = Arsip::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(6),
            'kategori' => fake()->randomElement(['arsip_desa', 'dokumentasi_desa']),
            'tipe' => 'artikel',
            'ringkasan' => fake()->paragraph(1),
            'isi' => '<p>'.fake()->paragraphs(3, true).'</p>',
            'gambar_sampul' => null,
            'file_pdf' => null,
            'status' => 'draft',
            'tanggal' => fake()->dateTimeBetween('-6 months', 'now'),
            'user_id' => User::factory(),
        ];
    }

    /** State: arsip berstatus terbit. */
    public function terbit(): static
    {
        return $this->state(fn (): array => ['status' => 'terbit']);
    }

    /** State: arsip bertipe PDF. */
    public function pdf(): static
    {
        return $this->state(fn (): array => [
            'tipe' => 'pdf',
            'file_pdf' => 'arsip/pdf/sample.pdf',
            'isi' => null,
        ]);
    }

    /** State: kategori arsip_desa. */
    public function arsipDesa(): static
    {
        return $this->state(fn (): array => ['kategori' => 'arsip_desa']);
    }

    /** State: kategori dokumentasi_desa. */
    public function dokumentasiDesa(): static
    {
        return $this->state(fn (): array => ['kategori' => 'dokumentasi_desa']);
    }
}
