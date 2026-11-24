<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_desa', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'kode_wilayah', 'luas_wilayah', 'latitude', 'longitude', 'jumlah_dusun', 'jumlah_rw', 'jumlah_rt', 'deskripsi', 'gambar', 'sumber_data', 'tahun_data'])]
class VillageProfile extends Model
{
    protected function casts(): array
    {
        return ['luas_wilayah' => 'decimal:4', 'latitude' => 'decimal:7', 'longitude' => 'decimal:7', 'jumlah_dusun' => 'integer', 'jumlah_rw' => 'integer', 'jumlah_rt' => 'integer', 'tahun_data' => 'integer'];
    }
}
