<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_kategori', 'luas', 'satuan', 'deskripsi', 'gambar', 'urutan', 'status'])]
class VillageLandUse extends Model
{
    protected function casts(): array
    {
        return ['luas' => 'decimal:4', 'urutan' => 'integer', 'status' => 'boolean'];
    }
}
