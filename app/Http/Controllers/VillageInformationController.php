<?php

namespace App\Http\Controllers;

use App\Models\VillageBoundary;
use App\Models\VillageDusun;
use App\Models\VillageGeography;
use App\Models\VillageLandUse;
use App\Models\VillageMap;
use App\Models\VillageProfile;
use Illuminate\Contracts\View\View;

class VillageInformationController extends Controller
{
    public function index(): View
    {
        $profile = VillageProfile::query()->first();
        $boundaries = VillageBoundary::query()->orderByRaw("CASE arah WHEN 'Utara' THEN 1 WHEN 'Timur' THEN 2 WHEN 'Selatan' THEN 3 WHEN 'Barat' THEN 4 ELSE 5 END")->get();
        $dusuns = VillageDusun::query()->where('status', true)->orderBy('urutan')->orderBy('nama_dusun')->get();
        $geographies = VillageGeography::query()->where('status', true)->orderBy('urutan')->orderBy('nama_informasi')->get();
        $landUses = VillageLandUse::query()->where('status', true)->orderBy('urutan')->orderBy('nama_kategori')->get();
        $map = VillageMap::query()->where('status', true)->first();
        $chartReady = $landUses->isNotEmpty()
            && $landUses->every(fn (VillageLandUse $landUse): bool => $landUse->luas !== null && (float) $landUse->luas > 0 && filled($landUse->satuan))
            && $landUses->pluck('satuan')->map(fn (?string $unit): string => mb_strtolower((string) $unit))->unique()->count() === 1;

        return view('pages.wilayah', compact('profile', 'boundaries', 'dusuns', 'geographies', 'landUses', 'map', 'chartReady'));
    }
}
