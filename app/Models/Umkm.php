<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Umkm extends Model
{
    protected $fillable = ['nama_usaha', 'slug', 'kategori', 'nama_pemilik', 'alamat', 'deskripsi_singkat', 'deskripsi_lengkap', 'tahun_berdiri', 'jam_operasional', 'whatsapp', 'foto', 'latitude', 'longitude', 'is_demo', 'status'];

    protected function casts(): array
    {
        return ['is_demo' => 'boolean'];
    }

    public function products(): HasMany
    {
        return $this->hasMany(UmkmProduct::class);
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('status', 'terbit');
    }

    public static function makeSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $suffix = 2;
        while (static::query()->where('slug', $slug)->when($ignoreId, fn (Builder $query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
