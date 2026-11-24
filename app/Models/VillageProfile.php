<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_desa', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'kode_wilayah', 'luas_wilayah', 'latitude', 'longitude', 'deskripsi', 'gambar'])]
class VillageProfile extends Model
{
    protected function casts(): array
    {
        return ['luas_wilayah' => 'decimal:4', 'latitude' => 'decimal:7', 'longitude' => 'decimal:7'];
    }
}
