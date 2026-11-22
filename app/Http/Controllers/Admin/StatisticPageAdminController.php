<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatisticPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StatisticPageAdminController extends Controller
{
    public function index(): View
    {
        $pages = StatisticPage::query()->withCount('categories')->orderBy('sort_order')->paginate(10);

        return view('admin.statistik.halaman.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.statistik.halaman.form', ['page' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        StatisticPage::create($data);

        return redirect()->route('admin.statistik.halaman.index')->with('success', 'Halaman statistik berhasil ditambahkan.');
    }

    public function edit(StatisticPage $halaman): View
    {
        return view('admin.statistik.halaman.form', ['page' => $halaman]);
    }

    public function update(Request $request, StatisticPage $halaman): RedirectResponse
    {
        $data = $this->validated($request, $halaman);
        $data['slug'] = $this->uniqueSlug($data['title'], $halaman->id);
        $halaman->update($data);

        return redirect()->route('admin.statistik.halaman.index')->with('success', 'Halaman statistik berhasil diperbarui.');
    }

    public function destroy(StatisticPage $halaman): RedirectResponse
    {
        if ($halaman->categories()->exists()) {
            return back()->with('error', 'Halaman tidak dapat dihapus selama masih memiliki kategori.');
        }

        $halaman->delete();

        return redirect()->route('admin.statistik.halaman.index')->with('success', 'Halaman statistik berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, ?StatisticPage $page = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('statistic_pages', 'title')->ignore($page)],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
            'status' => ['required', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'statistik';
        $slug = $base;
        $suffix = 2;
        while (StatisticPage::query()->where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
