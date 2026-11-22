<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama', 'telepon', 'jenis', 'pesan', 'foto', 'status'])]
class Pengaduan extends Model
{
    public const JENIS = ['Laporan Pengaduan / Aspirasi Warga', 'Pertanyaan Umum'];

    public const STATUSES = ['baru', 'diproses', 'selesai', 'ditolak'];

    protected function casts(): array
    {
        return ['foto' => 'array'];
    }

    public function catatan(): HasMany
    {
        return $this->hasMany(PengaduanCatatan::class)->latest();
    }

    public function riwayatStatus(): HasMany
    {
        return $this->hasMany(PengaduanRiwayatStatus::class)->latest();
    }
}
