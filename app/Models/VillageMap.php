<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_peta', 'gambar', 'latitude', 'longitude', 'map_url', 'boundary_geojson', 'deskripsi', 'status'])]
class VillageMap extends Model
{
    protected function casts(): array
    {
        return ['latitude' => 'decimal:7', 'longitude' => 'decimal:7', 'status' => 'boolean'];
    }
}
