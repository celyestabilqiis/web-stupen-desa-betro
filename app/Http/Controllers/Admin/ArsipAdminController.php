<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Arsip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ArsipAdminController extends Controller
{
    public function index(Request $request): View
    {
        $query = Arsip::query()->with('penulis')->orderByDesc('tanggal');

        if ($request->filled('cari')) {
            $query->where('judul', 'like', '%'.$request->input('cari').'%');
        }
        if ($request->filled('kategori') && in_array($request->input('kategori'), ['arsip_desa', 'dokumentasi_desa'])) {
            $query->where('kategori', $request->input('kategori'));
        }
        if ($request->filled('status') && in_array($request->input('status'), ['draft', 'terbit'])) {
            $query->where('status', $request->input('status'));
        }

        $arsipList = $query->paginate(10)->withQueryString();

        return view('admin.arsip.index', compact('arsipList'));
    }

    public function create(): View
    {
        return view('admin.arsip.form', ['arsip' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateArsip($request);

        if (! empty($validated['isi'])) {
            $validated['isi'] = clean($validated['isi']);
        }

        $arsip = new Arsip;
        $arsip->fill($validated);
        $arsip->user_id = $request->user()->id;
        $arsip->slug = Arsip::generateUniqueSlug($validated['judul']);

        $this->handleFiles($request, $arsip);
        $this->autoRingkasan($arsip);

        $arsip->save();

        return redirect()->route('admin.arsip.index')
            ->with('success', 'Arsip berhasil ditambahkan.');
    }

    public function edit(Arsip $arsip): View
    {
        return view('admin.arsip.form', compact('arsip'));
    }

    public function update(Request $request, Arsip $arsip): RedirectResponse
    {
        $validated = $this->validateArsip($request, $arsip);

        if (! empty($validated['isi'])) {
            $validated['isi'] = clean($validated['isi']);
        }

        $arsip->fill($validated);

        // Update slug jika judul berubah
        if ($arsip->isDirty('judul')) {
            $arsip->slug = Arsip::generateUniqueSlug($validated['judul'], $arsip->id);
        }

        $this->handleFiles($request, $arsip);
        $this->autoRingkasan($arsip);

        $arsip->save();

        return redirect()->route('admin.arsip.index')
            ->with('success', 'Arsip berhasil diperbarui.');
    }

    public function destroy(Arsip $arsip): RedirectResponse
    {
        // Hapus file terkait
        if ($arsip->gambar_sampul) {
            Storage::disk('public')->delete($arsip->gambar_sampul);
        }
        if ($arsip->file_pdf) {
            Storage::disk('public')->delete($arsip->file_pdf);
        }

        $arsip->delete();

        return redirect()->route('admin.arsip.index')
            ->with('success', 'Arsip berhasil dihapus.');
    }

    public function uploadEditorImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'image.max' => 'Ukuran gambar terlalu besar. Maksimal 5 MB.',
            'image.mimes' => 'Format gambar tidak didukung. Gunakan JPG, PNG, atau WebP.',
        ]);

        $path = $request->file('image')->store('arsip/editor', 'public');

        return response()->json([
            'url' => Storage::disk('public')->url($path),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validateArsip(Request $request, ?Arsip $arsip = null): array
    {
        $isUpdate = $arsip !== null;
        $isPdf = $request->input('tipe') === 'pdf';

        $rules = [
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', Rule::in(['arsip_desa', 'dokumentasi_desa'])],
            'tipe' => ['required', Rule::in(['artikel', 'pdf'])],
            'tanggal' => ['required', 'date'],
            'status' => ['required', Rule::in(['draft', 'terbit'])],
            'ringkasan' => ['nullable', 'string', 'max:300'],
            'isi' => [$isPdf ? 'nullable' : 'required', 'string'],
            'gambar_sampul' => [
                $isUpdate ? 'nullable' : ($isPdf ? 'nullable' : 'required'),
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'file_pdf' => [
                $isUpdate ? 'nullable' : ($isPdf ? 'required' : 'nullable'),
                'file',
                'mimes:pdf',
                'max:10240',
            ],
        ];

        $messages = [
            'judul.required' => 'Judul wajib diisi.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'tipe.required' => 'Tipe isi wajib dipilih.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'isi.required' => 'Isi artikel wajib diisi.',
            'gambar_sampul.required' => 'Gambar sampul wajib diunggah untuk tipe Artikel.',
            'gambar_sampul.max' => 'Ukuran gambar sampul terlalu besar. Maksimal 5 MB.',
            'gambar_sampul.mimes' => 'Format gambar tidak didukung. Gunakan JPG, PNG, atau WebP.',
            'file_pdf.required' => 'File PDF wajib diunggah.',
            'file_pdf.max' => 'Ukuran file PDF terlalu besar. Maksimal 10 MB.',
            'file_pdf.mimes' => 'File harus berformat PDF.',
        ];

        return $request->validate($rules, $messages);
    }

    private function handleFiles(Request $request, Arsip $arsip): void
    {
        if ($request->hasFile('gambar_sampul')) {
            // Hapus file lama
            if ($arsip->exists && $arsip->getOriginal('gambar_sampul')) {
                Storage::disk('public')->delete($arsip->getOriginal('gambar_sampul'));
            }
            $arsip->gambar_sampul = $request->file('gambar_sampul')->store('arsip/sampul', 'public');
        }

        if ($request->hasFile('file_pdf')) {
            // Hapus file lama
            if ($arsip->exists && $arsip->getOriginal('file_pdf')) {
                Storage::disk('public')->delete($arsip->getOriginal('file_pdf'));
            }
            $arsip->file_pdf = $request->file('file_pdf')->store('arsip/pdf', 'public');
        }
    }

    private function autoRingkasan(Arsip $arsip): void
    {
        if (empty($arsip->ringkasan) && ! empty($arsip->isi)) {
            $arsip->ringkasan = Str::limit(strip_tags($arsip->isi), 160);
        }
    }
}
