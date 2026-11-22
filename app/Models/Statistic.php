<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable(['category_id', 'nama_statistik', 'label', 'slug', 'nilai', 'satuan', 'tahun', 'deskripsi', 'sumber_data', 'ikon', 'gambar', 'urutan', 'tampil_di_ringkasan', 'status'])]
class Statistic extends Model
{
    protected static function booted(): void
    {
        static::creating(function (Statistic $statistic): void {
            if (blank($statistic->slug)) {
                $statistic->slug = Str::slug($statistic->nama_statistik) ?: 'statistik';
            }
        });
    }

    protected function casts(): array
    {
        return [
            'nilai' => 'decimal:4',
            'tahun' => 'integer',
            'urutan' => 'integer',
            'tampil_di_ringkasan' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(StatisticCategory::class, 'category_id');
    }

    public function getNilaiFormatAttribute(): string
    {
        $formatted = number_format((float) $this->nilai, 4, ',', '.');

        return rtrim(rtrim($formatted, '0'), ',');
    }
}
