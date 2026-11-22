<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use App\Models\StatisticCategory;
use App\Models\StatisticPage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StatisticAdminController extends Controller
{
    public function years(): View
    {
        $years = Statistic::query()->selectRaw('tahun, COUNT(*) as statistics_count')
            ->groupBy('tahun')->orderByDesc('tahun')->get();

        return view('admin.statistik.tahun', compact('years'));
    }

    public function index(Request $request): View
    {
        $request->validate([
            'cari' => ['nullable', 'string', 'max:255'],
            'kategori' => ['nullable', 'integer', Rule::exists('statistic_categories', 'id')],
            'halaman' => ['nullable', 'integer', Rule::exists('statistic_pages', 'id')],
            'tahun' => ['nullable', 'integer', 'min:1900', 'max:2200'],
            'status' => ['nullable', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $statistics = $this->filteredQuery($request)->orderByDesc('tahun')->orderBy('urutan')->orderBy('nama_statistik')->paginate(10)->withQueryString();
        $categories = StatisticCategory::query()->orderBy('urutan')->orderBy('nama_kategori')->get();
        $pages = StatisticPage::query()->orderBy('sort_order')->get();
        $years = Statistic::query()->select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');
        $categoryBreakdown = StatisticCategory::query()
            ->whereHas('statistics', fn (Builder $query) => $query->where('status', 'aktif'))
            ->withCount(['statistics as statistics_count' => fn (Builder $query) => $query->where('status', 'aktif')])
            ->orderBy('urutan')
            ->get();
        $summary = [
            'total' => Statistic::count(),
            'categories' => StatisticCategory::count(),
            'pages' => StatisticPage::count(),
            'active' => Statistic::where('status', 'aktif')->count(),
            'inactive' => Statistic::where('status', 'nonaktif')->count(),
            'latestYear' => Statistic::max('tahun'),
        ];

        return view('admin.statistik.index', compact('statistics', 'categories', 'years', 'categoryBreakdown', 'summary', 'pages'));
    }

    public function create(): View
    {
        $categories = StatisticCategory::query()->with('page')->orderBy('urutan')->orderBy('nama_kategori')->get();
        $pages = StatisticPage::query()->orderBy('sort_order')->get();

        return view('admin.statistik.form', ['statistic' => null, 'categories' => $categories, 'pages' => $pages]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateStatistic($request);
        $validated['slug'] = Str::slug($validated['nama_statistik']) ?: 'statistik';
        unset($validated['page_id']);
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('statistik', 'public');
        }

        Statistic::create($validated);

        return redirect()->route('admin.statistik.index')->with('success', 'Data statistik berhasil ditambahkan.');
    }

    public function show(Statistic $statistik): View
    {
        $statistik->load('category');

        return view('admin.statistik.show', ['statistic' => $statistik]);
    }

    public function edit(Statistic $statistik): View
    {
        $categories = StatisticCategory::query()->with('page')->orderBy('urutan')->orderBy('nama_kategori')->get();
        $pages = StatisticPage::query()->orderBy('sort_order')->get();

        return view('admin.statistik.form', ['statistic' => $statistik, 'categories' => $categories, 'pages' => $pages]);
    }

    public function update(Request $request, Statistic $statistik): RedirectResponse
    {
        $validated = $this->validateStatistic($request, $statistik);
        $validated['slug'] = Str::slug($validated['nama_statistik']) ?: 'statistik';
        unset($validated['page_id']);
        if ($request->hasFile('gambar')) {
            if ($statistik->gambar) {
                Storage::disk('public')->delete($statistik->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('statistik', 'public');
        }

        $statistik->update($validated);

        return redirect()->route('admin.statistik.show', $statistik)->with('success', 'Data statistik berhasil diperbarui.');
    }

    public function destroy(Statistic $statistik): RedirectResponse
    {
        if ($statistik->gambar) {
            Storage::disk('public')->delete($statistik->gambar);
        }
        $statistik->delete();

        return redirect()->route('admin.statistik.index')->with('success', 'Data statistik berhasil dihapus.');
    }

    /** @return Builder<Statistic> */
    private function filteredQuery(Request $request): Builder
    {
        return Statistic::query()->with('category.page')
            ->when($request->filled('cari'), fn (Builder $query) => $query->where('nama_statistik', 'like', '%'.$request->input('cari').'%'))
            ->when($request->filled('kategori'), fn (Builder $query) => $query->where('category_id', $request->input('kategori')))
            ->when($request->filled('halaman'), fn (Builder $query) => $query->whereHas('category', fn (Builder $categoryQuery) => $categoryQuery->where('page_id', $request->input('halaman'))))
            ->when($request->filled('tahun'), fn (Builder $query) => $query->where('tahun', $request->input('tahun')))
            ->when($request->filled('status'), fn (Builder $query) => $query->where('status', $request->input('status')));
    }

    /** @return array<string, mixed> */
    private function validateStatistic(Request $request, ?Statistic $statistic = null): array
    {
        $slug = Str::slug((string) $request->input('nama_statistik')) ?: 'statistik';

        $validated = $request->validate([
            'page_id' => ['required', 'integer', Rule::exists('statistic_pages', 'id')],
            'nama_statistik' => ['required', 'string', 'max:255'],
            'label' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'integer', Rule::exists('statistic_categories', 'id')->where('page_id', $request->input('page_id'))],
            'nilai' => ['required', 'numeric', 'min:0', 'max:99999999999999.9999'],
            'satuan' => ['nullable', 'string', 'max:50'],
            'tahun' => ['required', 'integer', 'min:1900', 'max:2200'],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'sumber_data' => ['nullable', 'string', 'max:255'],
            'ikon' => ['nullable', 'string', 'max:50'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'urutan' => ['required', 'integer', 'min:0', 'max:65535'],
            'tampil_di_ringkasan' => ['required', 'boolean'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        Validator::make(
            ['nama_statistik' => $slug],
            ['nama_statistik' => [Rule::unique('statistics', 'slug')->where('category_id', $request->input('category_id'))->where('tahun', $request->input('tahun'))->ignore($statistic)]],
            [],
            ['nama_statistik' => 'nama statistik']
        )->validate();

        return $validated;
    }
}
