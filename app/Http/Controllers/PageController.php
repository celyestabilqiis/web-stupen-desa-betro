<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Pengaduan;
use App\Models\PengaduanRiwayatStatus;
use App\Models\Statistic;
use App\Models\StatisticCategory;
use App\Models\StatisticPage;
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

        return view('pages.index', compact('arsipTerbaru'));
    }

    public function informasi(): View
    {
        $arsipTerbaru = Arsip::query()
            ->terbit()
            ->with('penulis')
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('pages.informasi', compact('arsipTerbaru'));
    }

    public function statistik(Request $request): View
    {
        return $this->renderStatistik($request);
    }

    public function statistikPage(Request $request, string $slug): View
    {
        $page = StatisticPage::query()->where('slug', $slug)->where('status', true)->firstOrFail();

        return $this->renderStatistik($request, $page);
    }

    private function renderStatistik(Request $request, ?StatisticPage $page = null): View
    {
        $years = Statistic::query()
            ->where('status', 'aktif')
            ->whereHas('category', fn ($query) => $query->where('status', true)->where(fn ($pageQuery) => $pageQuery->whereNull('page_id')->orWhereHas('page', fn ($statisticPageQuery) => $statisticPageQuery->where('status', true))))
            ->when($page, fn ($query) => $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('page_id', $page->id)))
            ->select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');
        $request->validate([
            'tahun' => ['nullable', Rule::in(['semua', ...$years->map(fn ($year): string => (string) $year)->all()])],
            'banding_id' => ['nullable', 'integer'],
            'tahun_mulai' => ['nullable', 'integer', 'min:1900', 'max:2200'],
            'tahun_selesai' => ['nullable', 'integer', 'min:1900', 'max:2200'],
        ]);

        $latestYear = $years->first();
        $selectedYear = $request->filled('tahun') ? (string) $request->input('tahun') : (string) ($latestYear ?? 'semua');
        $statisticsQuery = Statistic::query()
            ->with('category')
            ->where('status', 'aktif')
            ->whereHas('category', fn ($query) => $query->where('status', true)->where(fn ($pageQuery) => $pageQuery->whereNull('page_id')->orWhereHas('page', fn ($statisticPageQuery) => $statisticPageQuery->where('status', true)))->when($page, fn ($categoryQuery) => $categoryQuery->where('page_id', $page->id)));
        if ($selectedYear !== 'semua') {
            $statisticsQuery->where('tahun', (int) $selectedYear);
        }
        $statistics = $statisticsQuery->orderBy('urutan')->orderBy('nama_statistik')->get();
        $yearGroups = $statistics->groupBy('tahun')->sortKeysDesc();
        $categories = StatisticCategory::query()->with('page')->where('status', true)->where(fn ($pageQuery) => $pageQuery->whereNull('page_id')->orWhereHas('page', fn ($statisticPageQuery) => $statisticPageQuery->where('status', true)))->when($page, fn ($query) => $query->where('page_id', $page->id))->orderBy('urutan')->orderBy('nama_kategori')->get();
        $summaryGroups = $yearGroups->map(fn ($yearStatistics) => $yearStatistics->where('tampil_di_ringkasan', true)->sortBy('urutan')->values());

        $comparisonIndicators = Statistic::query()
            ->with('category')
            ->where('status', 'aktif')
            ->whereHas('category', fn ($query) => $query->where('status', true)->where(fn ($pageQuery) => $pageQuery->whereNull('page_id')->orWhereHas('page', fn ($statisticPageQuery) => $statisticPageQuery->where('status', true)))->when($page, fn ($categoryQuery) => $categoryQuery->where('page_id', $page->id)))
            ->orderBy('category_id')
            ->orderBy('nama_statistik')
            ->orderBy('tahun')
            ->get()
            ->unique(fn (Statistic $statistic): string => $statistic->category_id.'-'.$statistic->slug)
            ->values();
        $comparisonIndicator = $request->filled('banding_id')
            ? $comparisonIndicators->firstWhere('id', (int) $request->input('banding_id'))
            : null;
        $comparisonRows = collect();
        $changePercent = null;
        $changeValue = null;
        $comparisonStart = null;
        $comparisonEnd = null;
        if ($comparisonIndicator) {
            $comparisonStart = (int) ($request->input('tahun_mulai') ?: $years->min());
            $comparisonEnd = (int) ($request->input('tahun_selesai') ?: $years->max());
            if ($comparisonStart > 0 && $comparisonEnd > 0) {
                $comparisonRows = Statistic::query()
                    ->where('category_id', $comparisonIndicator->category_id)
                    ->where('slug', $comparisonIndicator->slug)
                    ->where('status', 'aktif')
                    ->whereBetween('tahun', [$comparisonStart, $comparisonEnd])
                    ->orderBy('tahun')
                    ->get();
                $first = $comparisonRows->first();
                $last = $comparisonRows->last();
                $hasRangeEndpoints = $first && $last && (int) $first->tahun === $comparisonStart && (int) $last->tahun === $comparisonEnd;
                if ($comparisonRows->count() >= 2 && $hasRangeEndpoints) {
                    $changeValue = (float) $last->nilai - (float) $first->nilai;
                    if ((float) $first->nilai !== 0.0) {
                        $changePercent = ($changeValue / (float) $first->nilai) * 100;
                    }
                }
            }
        }

        $publishedPages = StatisticPage::query()->where('status', true)->whereHas('categories', fn ($query) => $query->where('status', true)->whereHas('statistics', fn ($statisticsQuery) => $statisticsQuery->where('status', 'aktif')))->orderBy('sort_order')->get();

        return view('pages.statistik', compact('years', 'latestYear', 'selectedYear', 'yearGroups', 'categories', 'summaryGroups', 'comparisonIndicators', 'comparisonIndicator', 'comparisonRows', 'changeValue', 'changePercent', 'comparisonStart', 'comparisonEnd', 'page', 'publishedPages'));
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
