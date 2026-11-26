<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Pengaduan;
use App\Models\PengaduanRiwayatStatus;
use App\Models\Umkm;
use App\Models\VillageOfficial;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function home(): View
    {
        $arsipTerbaru = Arsip::query()
            ->terbit()
            ->with('penulis')
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();

        $villageHead = VillageOfficial::query()
            ->where('status', true)
            ->where('is_kepala_desa', true)
            ->first();

        return view('pages.index', compact('arsipTerbaru', 'villageHead'));
    }

    public function informasi(): View
    {
        $arsipTerbaru = Arsip::query()
            ->terbit()
            ->with('penulis')
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('pages.informasi', compact('arsipTerbaru'));
    }

    public function potensi(Request $request): View
    {
        $request->validate(['cari' => ['nullable', 'string', 'max:255']]);

        $query = Umkm::published()->latest();

        if ($request->filled('cari')) {
            $search = trim((string) $request->input('cari'));
            $query->where(function ($query) use ($search): void {
                $query->where('nama_usaha', 'like', '%'.$search.'%')
                    ->orWhere('deskripsi_singkat', 'like', '%'.$search.'%')
                    ->orWhere('deskripsi_lengkap', 'like', '%'.$search.'%')
                    ->orWhereHas('products', function ($productQuery) use ($search): void {
                        $productQuery->where('nama_produk', 'like', '%'.$search.'%')
                            ->orWhere('deskripsi', 'like', '%'.$search.'%');
                    });
            });
        }

        $umkmList = $query->paginate(6)->withQueryString();

        return view('pages.potensi', compact('umkmList'));
    }

    public function profile(): View
    {
        $villageOfficials = VillageOfficial::query()->where('status', true)
            ->orderByDesc('is_kepala_desa')->orderBy('urutan')->orderBy('nama')->get();
        $villageHead = $villageOfficials->first(fn (VillageOfficial $official): bool => $official->is_kepala_desa);
        $otherOfficials = $villageOfficials->reject(fn (VillageOfficial $official): bool => $official->is_kepala_desa)->values();

        return view('pages.profile', compact('villageHead', 'otherOfficials'));
    }

    public function pengaduan(): View
    {
        return view('pages.pengaduan');
    }

    public function storePengaduan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'string', 'max:32', 'regex:/^[0-9+(). -]{8,32}$/'],
            'jenis' => ['required', Rule::in(Pengaduan::JENIS)],
            'pesan' => ['required', 'string', 'max:10000'],
            'bukti' => ['nullable', 'array', 'max:3'],
            'bukti.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'bukti.max' => 'Maksimal 3 foto bukti.',
            'bukti.*.max' => 'Ukuran setiap foto maksimal 5 MB.',
            'bukti.*.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WebP.',
            'bukti.*.image' => 'File bukti harus berupa gambar.',
        ]);

        $validated['foto'] = collect($request->file('bukti', []))->map(fn ($photo) => $photo->store('pengaduan', 'local'))->all();
        unset($validated['bukti']);
        $validated['status'] = 'baru';
        $pengaduan = Pengaduan::create($validated);
        PengaduanRiwayatStatus::create(['pengaduan_id' => $pengaduan->id, 'status_baru' => 'baru']);

        return redirect()->route('pages.pengaduan')->with('success', 'Pengaduan berhasil dikirim. Terima kasih, laporan Anda telah diterima.');
    }

    public function login(): View
    {
        return view('pages.login');
    }
}
