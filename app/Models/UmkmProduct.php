<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UmkmProduct extends Model
{
    protected $fillable = ['nama_produk', 'deskripsi', 'harga', 'satuan', 'foto', 'tersedia'];

    protected function casts(): array
    {
        return ['tersedia' => 'boolean'];
    }

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }
}
