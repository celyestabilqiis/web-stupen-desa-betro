<?php

namespace App\Models;

use Database\Factories\ArsipFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable([
    'judul', 'slug', 'kategori', 'tipe', 'ringkasan', 'isi',
    'gambar_sampul', 'file_pdf', 'status', 'tanggal', 'user_id',
])]
class Arsip extends Model
{
    /** @use HasFactory<ArsipFactory> */
    use HasFactory;

    /** @var array<string, string> */
    protected $casts = [
        'tanggal' => 'date',
        'jumlah_dilihat' => 'integer',
    ];

    /**
     * Boot: auto-generate unique slug from judul.
     */
    protected static function booted(): void
    {
        static::creating(function (Arsip $arsip): void {
            if (empty($arsip->slug)) {
                $arsip->slug = static::generateUniqueSlug($arsip->judul);
            }
        });
    }

    /**
     * Generate a unique slug, appending -2, -3, etc. if duplicates exist.
     */
    public static function generateUniqueSlug(string $judul, ?int $excludeId = null): string
    {
        $slug = Str::slug($judul);
        $original = $slug;
        $counter = 2;

        while (static::query()
            ->where('slug', $slug)
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->exists()
        ) {
            $slug = $original.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Label kategori yang ramah tampilan.
     */
    public function labelKategori(): string
    {
        return match ($this->kategori) {
            'arsip_desa' => 'Arsip Desa',
            'dokumentasi_desa' => 'Dokumentasi Desa',
            default => $this->kategori,
        };
    }

    /**
     * Label tipe yang ramah tampilan.
     */
    public function labelTipe(): string
    {
        return match ($this->tipe) {
            'artikel' => 'Artikel',
            'pdf' => 'PDF',
            default => $this->tipe,
        };
    }

    /**
     * Scope: hanya arsip berstatus terbit.
     *
     * @param  Builder<Arsip>  $query
     * @return Builder<Arsip>
     */
    public function scopeTerbit($query)
    {
        return $query->where('status', 'terbit');
    }
}
