<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_dusun', 'jumlah_rw', 'jumlah_rt', 'luas_wilayah', 'deskripsi', 'foto', 'latitude', 'longitude', 'urutan', 'status'])]
class VillageDusun extends Model
{
    protected function casts(): array
    {
        return ['jumlah_rw' => 'integer', 'jumlah_rt' => 'integer', 'luas_wilayah' => 'decimal:4', 'latitude' => 'decimal:7', 'longitude' => 'decimal:7', 'urutan' => 'integer', 'status' => 'boolean'];
    }
}
