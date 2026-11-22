<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->updateOrCreate(
            ['email' => 'admin@desabetro.id'],
            [
                'name' => 'Admin Desa Betro',
                'password' => 'admin123',
            ],
        );

        $this->call(ArsipSeeder::class);
        $this->call(UmkmSeeder::class);
        $this->call(StatisticSeeder::class);
    }
}
