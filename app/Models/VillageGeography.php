<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_informasi', 'nilai', 'satuan', 'deskripsi', 'gambar', 'urutan', 'status'])]
class VillageGeography extends Model
{
    protected function casts(): array
    {
        return ['urutan' => 'integer', 'status' => 'boolean'];
    }
}
