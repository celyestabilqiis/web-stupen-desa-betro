<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UmkmAdminController extends Controller
{
    public function index(Request $request): View
    {
        $query = Umkm::query()->withCount('products')->orderByDesc('created_at');

        if ($request->filled('cari')) {
            $query->where('nama_usaha', 'like', '%'.$request->string('cari').'%');
        }
        if ($request->filled('status') && in_array($request->input('status'), ['draft', 'terbit'], true)) {
            $query->where('status', $request->input('status'));
        }

        /** @var LengthAwarePaginator<int, Umkm> $umkmList */
        $umkmList = $query->paginate(10)->withQueryString();

        return view('admin.umkm.index', compact('umkmList'));
    }

    public function create(): View
    {
        return view('admin.umkm.form', ['umkm' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $products = $data['products'] ?? [];
        unset($data['products']);
        $data['slug'] = Umkm::makeSlug($data['nama_usaha']);
        $data['is_demo'] = $request->boolean('is_demo');
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('umkm', 'public');
        }
        DB::transaction(function () use (&$umkm, $data, $products): void {
            $umkm = Umkm::create($data);
            $this->syncProducts($umkm, $products);
        });

        return redirect()->route('admin.umkm.index')->with('success', 'Data UMKM berhasil ditambahkan.');
    }

    public function edit(Umkm $umkm): View
    {
        $umkm->load('products');

        return view('admin.umkm.form', compact('umkm'));
    }

    public function update(Request $request, Umkm $umkm): RedirectResponse
    {
        $data = $this->validated($request);
        $products = $data['products'] ?? [];
        unset($data['products']);
        $data['is_demo'] = $request->boolean('is_demo');
        $oldMainPhoto = $umkm->foto;
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('umkm', 'public');
        }
        $data['slug'] = Umkm::makeSlug($data['nama_usaha'], $umkm->id);
        $productPhotosToDelete = DB::transaction(function () use ($umkm, $data, $products): array {
            $umkm->update($data);

            return $this->syncProducts($umkm, $products);
        });
        Storage::disk('public')->delete($productPhotosToDelete);
        if ($request->hasFile('foto') && $oldMainPhoto && ! str_starts_with($oldMainPhoto, 'http')) {
            Storage::disk('public')->delete($oldMainPhoto);
        }

        return redirect()->route('admin.umkm.index')->with('success', 'Data UMKM berhasil diperbarui.');
    }

    public function destroy(Umkm $umkm): RedirectResponse
    {
        $photoPaths = $umkm->products()->whereNotNull('foto')->pluck('foto')->push($umkm->foto)->filter(fn (?string $path): bool => filled($path) && ! str_starts_with($path, 'http'));
        $umkm->delete();
        Storage::disk('public')->delete($photoPaths->all());

        return redirect()->route('admin.umkm.index')->with('success', 'Data UMKM berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        $request->merge([
            'products' => collect($request->input('products', []))
                ->filter(fn ($product): bool => is_array($product) && filled($product['nama_produk'] ?? null))
                ->values()
                ->all(),
        ]);

        return $request->validate([
            'nama_usaha' => ['required', 'string', 'max:255'], 'kategori' => ['required', 'string', 'max:120'],
            'nama_pemilik' => ['nullable', 'string', 'max:255'], 'alamat' => ['nullable', 'string'],
            'deskripsi_singkat' => ['nullable', 'string', 'max:500'], 'deskripsi_lengkap' => ['nullable', 'string'],
            'tahun_berdiri' => ['nullable', 'string', 'max:100'], 'jam_operasional' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'status' => ['required', 'in:draft,terbit'], 'is_demo' => ['nullable', 'boolean'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'products' => ['nullable', 'array'], 'products.*.id' => ['nullable', 'integer'], 'products.*.nama_produk' => ['required', 'string', 'max:255'],
            'products.*.deskripsi' => ['nullable', 'string'], 'products.*.harga' => ['nullable', 'integer', 'min:0'],
            'products.*.satuan' => ['nullable', 'string', 'max:100'], 'products.*.foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'products.*.tersedia' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * @param  array<int|string, array<string, mixed>>  $products
     */
    private function syncProducts(Umkm $umkm, array $products): array
    {
        $retainedIds = [];
        $photosToDelete = [];
        foreach ($products as $productData) {
            if (! empty($productData['id'])) {
                $retainedIds[] = (int) $productData['id'];
            }
        }

        $removedProductsQuery = $umkm->products();
        if ($retainedIds !== []) {
            $removedProductsQuery->whereNotIn('id', $retainedIds);
        }
        foreach ($removedProductsQuery->get() as $removedProduct) {
            if ($removedProduct->foto && ! str_starts_with($removedProduct->foto, 'http')) {
                $photosToDelete[] = $removedProduct->foto;
            }
            $removedProduct->delete();
        }

        foreach ($products as $productData) {
            $product = null;
            if (! empty($productData['id'])) {
                $product = $umkm->products()->find($productData['id']);
                if (! $product) {
                    throw ValidationException::withMessages(['products' => 'Produk tidak ditemukan pada UMKM ini.']);
                }
            }

            $photo = $productData['foto'] ?? null;
            unset($productData['id'], $productData['foto']);
            $productData['tersedia'] = (bool) ($productData['tersedia'] ?? false);
            if ($photo) {
                $newPhoto = $photo->store('umkm/produk', 'public');
                if ($product?->foto && ! str_starts_with($product->foto, 'http')) {
                    $photosToDelete[] = $product->foto;
                }
                $productData['foto'] = $newPhoto;
            } elseif ($product) {
                $productData['foto'] = $product->foto;
            }

            if ($product) {
                $product->update($productData);
            } else {
                $umkm->products()->create($productData);
            }
        }

        return $photosToDelete;
    }
}
