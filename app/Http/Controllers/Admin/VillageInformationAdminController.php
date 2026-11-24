<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageBoundary;
use App\Models\VillageDusun;
use App\Models\VillageGeography;
use App\Models\VillageLandUse;
use App\Models\VillageMap;
use App\Models\VillageProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class VillageInformationAdminController extends Controller
{
    private const SECTIONS = [
        'dusun' => ['title' => 'Pembagian Dusun', 'model' => VillageDusun::class, 'name' => 'nama_dusun', 'image' => 'foto', 'fields' => ['nama_dusun', 'jumlah_rw', 'jumlah_rt', 'luas_wilayah', 'deskripsi', 'foto', 'latitude', 'longitude', 'urutan', 'status']],
        'geografi' => ['title' => 'Kondisi Geografis', 'model' => VillageGeography::class, 'name' => 'nama_informasi', 'image' => 'gambar', 'fields' => ['nama_informasi', 'nilai', 'satuan', 'deskripsi', 'gambar', 'urutan', 'status']],
        'lahan' => ['title' => 'Penggunaan Lahan', 'model' => VillageLandUse::class, 'name' => 'nama_kategori', 'image' => 'gambar', 'fields' => ['nama_kategori', 'luas', 'satuan', 'deskripsi', 'gambar', 'urutan', 'status']],
    ];

    public function dashboard(): View
    {
        $profile = VillageProfile::query()->first();
        $jumlahDusun = VillageDusun::query()->count();
        $jumlahRw = VillageDusun::query()->sum('jumlah_rw');
        $jumlahRt = VillageDusun::query()->sum('jumlah_rt');
        $jumlahLahan = VillageLandUse::query()->count();
        $missing = collect([
            'Identitas desa' => ! $profile || blank($profile->nama_desa) || blank($profile->kecamatan) || blank($profile->kabupaten),
            'Batas wilayah' => VillageBoundary::query()->count() < 4,
            'Koordinat desa' => ! $profile || $profile->latitude === null || $profile->longitude === null,
            'Dusun' => $jumlahDusun === 0,
            'Kondisi geografis' => VillageGeography::query()->where('status', true)->count() === 0,
            'Penggunaan lahan' => $jumlahLahan === 0,
            'Peta wilayah' => VillageMap::query()->where('status', true)->count() === 0,
        ])->filter()->keys();

        return view('admin.wilayah.dashboard', compact('profile', 'jumlahDusun', 'jumlahRw', 'jumlahRt', 'jumlahLahan', 'missing'));
    }

    public function profile(): View
    {
        return view('admin.wilayah.profile', ['profile' => VillageProfile::query()->first()]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_desa' => ['nullable', 'string', 'max:255'], 'kecamatan' => ['nullable', 'string', 'max:255'],
            'kabupaten' => ['nullable', 'string', 'max:255'], 'provinsi' => ['nullable', 'string', 'max:255'],
            'kode_pos' => ['nullable', 'string', 'max:10'], 'kode_wilayah' => ['nullable', 'string', 'max:32'],
            'luas_wilayah' => ['nullable', 'numeric', 'min:0'], 'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'], 'deskripsi' => ['nullable', 'string', 'max:10000'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
        $profile = VillageProfile::query()->firstOrNew();
        $this->replaceImage($request, $profile, 'gambar', 'informasi-wilayah/profil');
        $profile->fill(collect($validated)->except('gambar')->all())->save();

        return back()->with('success', 'Gambaran umum desa berhasil diperbarui.');
    }

    public function boundaries(): View
    {
        $boundaries = VillageBoundary::query()->get()->keyBy('arah');

        return view('admin.wilayah.boundaries', compact('boundaries'));
    }

    public function updateBoundaries(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'boundaries' => ['required', 'array', 'size:4'],
            'boundaries.*.arah' => ['required', Rule::in(VillageBoundary::DIRECTIONS), 'distinct'],
            'boundaries.*.wilayah_berbatasan' => ['nullable', 'string', 'max:255'],
            'boundaries.*.deskripsi' => ['nullable', 'string', 'max:2000'],
        ]);
        foreach ($validated['boundaries'] as $boundary) {
            if (blank($boundary['wilayah_berbatasan'] ?? null)) {
                VillageBoundary::query()->where('arah', $boundary['arah'])->delete();
            } else {
                VillageBoundary::query()->updateOrCreate(['arah' => $boundary['arah']], $boundary);
            }
        }

        return back()->with('success', 'Batas wilayah berhasil diperbarui.');
    }

    public function map(): View
    {
        return view('admin.wilayah.map', ['map' => VillageMap::query()->first()]);
    }

    public function updateMap(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_peta' => ['nullable', 'string', 'max:255'], 'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'], 'map_url' => ['nullable', 'url', 'starts_with:https://', 'max:2048'],
            'boundary_geojson' => ['nullable', 'json', 'max:20000'],
            'deskripsi' => ['nullable', 'string', 'max:5000'], 'status' => ['nullable', 'boolean'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
        $map = VillageMap::query()->firstOrNew();
        $this->replaceImage($request, $map, 'gambar', 'informasi-wilayah/peta');
        $map->fill(collect($validated)->except('gambar')->all());
        $map->status = $request->boolean('status');
        $map->save();

        return back()->with('success', 'Pengaturan peta berhasil diperbarui.');
    }

    public function index(Request $request, string $section): View
    {
        $config = $this->section($section);
        $items = $config['model']::query()->when($request->filled('cari'), fn ($query) => $query->where($config['name'], 'like', '%'.trim((string) $request->input('cari')).'%'))->orderBy('urutan')->orderBy($config['name'])->paginate(15)->withQueryString();

        return view('admin.wilayah.index', compact('section', 'config', 'items'));
    }

    public function create(string $section): View
    {
        $config = $this->section($section);

        return view('admin.wilayah.form', ['section' => $section, 'config' => $config, 'item' => null]);
    }

    public function show(string $section, int $item): View
    {
        $config = $this->section($section);
        $record = $config['model']::query()->findOrFail($item);

        return view('admin.wilayah.show', ['section' => $section, 'config' => $config, 'item' => $record]);
    }

    public function store(Request $request, string $section): RedirectResponse
    {
        $config = $this->section($section);
        $validated = $this->validateItem($request, $config);
        $item = new $config['model'];
        $this->replaceImage($request, $item, $config['image'], 'informasi-wilayah/'.$section);
        $item->fill(collect($validated)->except($config['image'])->all());
        $item->status = $request->boolean('status');
        $item->save();

        return redirect()->route('admin.wilayah.items.index', $section)->with('success', $config['title'].' berhasil ditambahkan.');
    }

    public function edit(string $section, int $item): View
    {
        $config = $this->section($section);
        $record = $config['model']::query()->findOrFail($item);

        return view('admin.wilayah.form', ['section' => $section, 'config' => $config, 'item' => $record]);
    }

    public function update(Request $request, string $section, int $item): RedirectResponse
    {
        $config = $this->section($section);
        $record = $config['model']::query()->findOrFail($item);
        $validated = $this->validateItem($request, $config, $record);
        $this->replaceImage($request, $record, $config['image'], 'informasi-wilayah/'.$section);
        $record->fill(collect($validated)->except($config['image'])->all());
        $record->status = $request->boolean('status');
        $record->save();

        return redirect()->route('admin.wilayah.items.index', $section)->with('success', $config['title'].' berhasil diperbarui.');
    }

    public function destroy(string $section, int $item): RedirectResponse
    {
        $config = $this->section($section);
        $record = $config['model']::query()->findOrFail($item);
        if ($record->{$config['image']}) {
            Storage::disk('public')->delete($record->{$config['image']});
        }
        $record->delete();

        return back()->with('success', $config['title'].' berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function section(string $section): array
    {
        abort_unless(isset(self::SECTIONS[$section]), 404);

        return self::SECTIONS[$section];
    }

    /** @param array<string, mixed> $config
     * @return array<string, mixed>
     */
    private function validateItem(Request $request, array $config, ?Model $item = null): array
    {
        $nameField = $config['name'];
        $table = $item?->getTable() ?? (new $config['model'])->getTable();
        $rules = [
            $nameField => ['required', 'string', 'max:255', Rule::unique($table, $nameField)->ignore($item?->getKey())],
            'deskripsi' => ['nullable', 'string', 'max:5000'], 'urutan' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'], 'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'nilai' => ['nullable', 'string', 'max:255'], 'satuan' => ['nullable', 'string', 'max:80'],
            'luas' => ['nullable', 'numeric', 'min:0'], 'luas_wilayah' => ['nullable', 'numeric', 'min:0'],
            'jumlah_rw' => ['nullable', 'integer', 'min:0'], 'jumlah_rt' => ['nullable', 'integer', 'min:0'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'], 'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ];

        return $request->validate(collect($rules)->only($config['fields'])->all());
    }

    private function replaceImage(Request $request, Model $model, string $field, string $directory): void
    {
        if ($request->hasFile($field)) {
            if ($model->exists && $model->getOriginal($field)) {
                Storage::disk('public')->delete($model->getOriginal($field));
            }
            $model->{$field} = $request->file($field)->store($directory, 'public');
        } elseif ($request->boolean('hapus_gambar') && $model->exists && $model->getOriginal($field)) {
            Storage::disk('public')->delete($model->getOriginal($field));
            $model->{$field} = null;
        }
    }
}
