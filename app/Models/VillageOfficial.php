<?php

namespace App\Models;

use Database\Factories\VillageOfficialFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'jabatan', 'deskripsi', 'foto', 'is_kepala_desa', 'kepala_desa_slot', 'urutan', 'status'])]
class VillageOfficial extends Model
{
    /** @use HasFactory<VillageOfficialFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_kepala_desa' => 'boolean',
            'urutan' => 'integer',
            'status' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (VillageOfficial $official): void {
            $official->kepala_desa_slot = $official->is_kepala_desa ? 'kepala_desa' : null;
        });
    }
}
