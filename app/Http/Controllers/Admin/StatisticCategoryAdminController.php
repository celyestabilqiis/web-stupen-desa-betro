<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatisticCategory;
use App\Models\StatisticPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StatisticCategoryAdminController extends Controller
{
    public function index(): View
    {
        $categories = StatisticCategory::query()
            ->with('page')
            ->withCount('statistics')
            ->orderBy('urutan')
            ->orderBy('nama_kategori')
            ->paginate(10);

        return view('admin.statistik.kategori.index', compact('categories'));
    }

    public function create(): View
    {
        $pages = StatisticPage::query()->orderBy('sort_order')->get();

        return view('admin.statistik.kategori.form', ['category' => null, 'pages' => $pages]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateCategory($request);
        $validated['slug'] = $this->uniqueSlug($validated['nama_kategori']);
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('statistik/kategori', 'public');
        }

        StatisticCategory::create($validated);

        return redirect()->route('admin.statistik.kategori.index')->with('success', 'Kategori statistik berhasil ditambahkan.');
    }

    public function edit(StatisticCategory $category): View
    {
        $pages = StatisticPage::query()->orderBy('sort_order')->get();

        return view('admin.statistik.kategori.form', compact('category', 'pages'));
    }

    public function update(Request $request, StatisticCategory $category): RedirectResponse
    {
        $validated = $this->validateCategory($request, $category);
        $validated['slug'] = $this->uniqueSlug($validated['nama_kategori'], $category->id);
        if ($request->hasFile('gambar')) {
            if ($category->gambar) {
                Storage::disk('public')->delete($category->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('statistik/kategori', 'public');
        }
        $category->update($validated);

        return redirect()->route('admin.statistik.kategori.index')->with('success', 'Kategori statistik berhasil diperbarui.');
    }

    public function destroy(StatisticCategory $category): RedirectResponse
    {
        if ($category->statistics()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh data statistik.');
        }

        if ($category->gambar) {
            Storage::disk('public')->delete($category->gambar);
        }

        $category->delete();

        return redirect()->route('admin.statistik.kategori.index')->with('success', 'Kategori statistik berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function validateCategory(Request $request, ?StatisticCategory $category = null): array
    {
        return $request->validate([
            'page_id' => ['required', 'integer', Rule::exists('statistic_pages', 'id')],
            'nama_kategori' => ['required', 'string', 'max:255', Rule::unique('statistic_categories', 'nama_kategori')->ignore($category)],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'ikon' => ['nullable', 'string', 'max:50'],
            'visualization_type' => ['required', Rule::in(['bar', 'pie', 'doughnut', 'table'])],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'urutan' => ['required', 'integer', 'min:0', 'max:65535'],
            'status' => ['required', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'kategori';
        $slug = $base;
        $suffix = 2;

        while (StatisticCategory::query()->where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
