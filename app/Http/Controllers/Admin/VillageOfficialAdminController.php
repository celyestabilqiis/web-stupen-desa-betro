<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageOfficial;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VillageOfficialAdminController extends Controller
{
    public function index(Request $request): View
    {
        $request->validate([
            'cari' => ['nullable', 'string', 'max:255'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'in:aktif,nonaktif'],
        ]);

        $officials = VillageOfficial::query()
            ->when($request->filled('cari'), fn (Builder $query) => $query->where('nama', 'like', '%'.$request->input('cari').'%'))
            ->when($request->filled('jabatan'), fn (Builder $query) => $query->where('jabatan', $request->input('jabatan')))
            ->when($request->filled('status'), fn (Builder $query) => $query->where('status', $request->input('status') === 'aktif'))
            ->orderByDesc('is_kepala_desa')->orderBy('urutan')->orderBy('nama')->paginate(10)->withQueryString();
        $jabatanList = VillageOfficial::query()->select('jabatan')->distinct()->orderBy('jabatan')->pluck('jabatan');

        return view('admin.struktur-pemerintahan.index', compact('officials', 'jabatanList'));
    }

    public function create(): View
    {
        return view('admin.struktur-pemerintahan.form', ['official' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['status'] = $request->boolean('status');
        $data['is_kepala_desa'] = $request->boolean('is_kepala_desa');
        if ($data['is_kepala_desa']) {
            $data['jabatan'] = 'Kepala Desa';
        }
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('perangkat-desa', 'public');
        }

        DB::transaction(function () use ($data): void {
            if ($data['is_kepala_desa'] && $data['status']) {
                $this->releaseCurrentHead();
            }
            VillageOfficial::create($data);
        });

        return redirect()->route('admin.struktur-pemerintahan.index')->with('success', 'Data perangkat desa berhasil ditambahkan.');
    }

    public function show(VillageOfficial $villageOfficial): View
    {
        return view('admin.struktur-pemerintahan.show', ['official' => $villageOfficial]);
    }

    public function edit(VillageOfficial $villageOfficial): View
    {
        return view('admin.struktur-pemerintahan.form', ['official' => $villageOfficial]);
    }

    public function update(Request $request, VillageOfficial $villageOfficial): RedirectResponse
    {
        $data = $this->validated($request);
        $data['status'] = $request->boolean('status');
        $data['is_kepala_desa'] = $request->boolean('is_kepala_desa');
        if ($villageOfficial->is_kepala_desa && ! $data['is_kepala_desa'] && mb_strtolower($data['jabatan']) === 'kepala desa') {
            $data['jabatan'] = 'Perangkat Desa';
        }
        if ($data['is_kepala_desa']) {
            $data['jabatan'] = 'Kepala Desa';
        }
        $oldPhoto = $villageOfficial->foto;
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('perangkat-desa', 'public');
        }

        DB::transaction(function () use ($data, $villageOfficial): void {
            if ($data['is_kepala_desa'] && $data['status']) {
                $this->releaseCurrentHead($villageOfficial->id);
            }
            $villageOfficial->update($data);
        });
        $this->deleteUnusedPhoto($request->hasFile('foto') ? $oldPhoto : null);

        return redirect()->route('admin.struktur-pemerintahan.show', $villageOfficial)->with('success', 'Data perangkat desa berhasil diperbarui.');
    }

    public function destroy(VillageOfficial $villageOfficial): RedirectResponse
    {
        $photo = $villageOfficial->foto;
        $villageOfficial->delete();
        $this->deleteUnusedPhoto($photo);

        return redirect()->route('admin.struktur-pemerintahan.index')->with('success', 'Data perangkat desa berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        if (! $request->boolean('status')) {
            if ($request->boolean('is_kepala_desa') && mb_strtolower((string) $request->input('jabatan')) === 'kepala desa') {
                $request->merge(['jabatan' => 'Perangkat Desa']);
            }
            $request->merge(['is_kepala_desa' => false]);
        }
        if ($request->boolean('is_kepala_desa')) {
            $request->merge(['jabatan' => 'Kepala Desa']);
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:3000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'urutan' => ['required', 'integer', 'min:0', 'max:65535'],
            'status' => ['required', 'boolean'],
            'is_kepala_desa' => ['required', 'boolean'],
        ]);

        return $data;
    }

    private function releaseCurrentHead(?int $exceptId = null): void
    {
        $currentHeads = VillageOfficial::query()->where('is_kepala_desa', true)->where('status', true)
            ->when($exceptId, fn (Builder $query) => $query->whereKeyNot($exceptId))->lockForUpdate()->get();
        foreach ($currentHeads as $currentHead) {
            $currentHead->is_kepala_desa = false;
            $currentHead->kepala_desa_slot = null;
            if (mb_strtolower($currentHead->jabatan) === 'kepala desa') {
                $currentHead->jabatan = 'Perangkat Desa';
            }
            $currentHead->save();
        }
    }

    private function deleteUnusedPhoto(?string $photo): void
    {
        if ($photo && ! VillageOfficial::query()->where('foto', $photo)->exists()) {
            Storage::disk('public')->delete($photo);
        }
    }
}
