<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['page_id', 'nama_kategori', 'slug', 'deskripsi', 'ikon', 'visualization_type', 'gambar', 'urutan', 'status'])]
class StatisticCategory extends Model
{
    protected function casts(): array
    {
        return ['status' => 'boolean', 'urutan' => 'integer'];
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(Statistic::class, 'category_id');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(StatisticPage::class, 'page_id');
    }
}
