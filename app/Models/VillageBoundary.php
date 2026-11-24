<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['arah', 'wilayah_berbatasan', 'deskripsi'])]
class VillageBoundary extends Model
{
    public const DIRECTIONS = ['Utara', 'Selatan', 'Timur', 'Barat'];
}
