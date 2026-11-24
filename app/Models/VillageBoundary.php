<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['arah', 'wilayah_berbatasan', 'deskripsi', 'sumber_data', 'tahun_data'])]
class VillageBoundary extends Model
{
    public const DIRECTIONS = ['Utara', 'Selatan', 'Timur', 'Barat'];
}
