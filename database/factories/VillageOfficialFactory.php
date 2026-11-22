<?php

namespace Database\Factories;

use App\Models\VillageOfficial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VillageOfficial>
 */
class VillageOfficialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'jabatan' => fake()->jobTitle(),
            'deskripsi' => fake()->sentence(),
            'foto' => null,
            'is_kepala_desa' => false,
            'urutan' => fake()->numberBetween(1, 20),
            'status' => true,
        ];
    }
}
