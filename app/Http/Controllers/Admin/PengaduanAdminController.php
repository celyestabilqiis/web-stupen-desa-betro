<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\PengaduanRiwayatStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PengaduanAdminController extends Controller
{
    public function index(Request $request): View
    {
        $pengaduans = $this->filteredQuery($request)->orderByDesc('created_at')->paginate(10)->withQueryString();
        $jenisPengaduan = Pengaduan::query()->select('jenis')->distinct()->orderBy('jenis')->pluck('jenis');
        $stats = [
            'total' => Pengaduan::count(),
            'baru' => Pengaduan::where('status', 'baru')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'ditolak' => Pengaduan::where('status', 'ditolak')->count(),
        ];
        $monthly = collect(range(11, 0))->map(function (int $offset): array {
            $date = now()->startOfMonth()->subMonths($offset);

            return ['label' => $date->translatedFormat('M Y'), 'count' => Pengaduan::whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->count()];
        });

        return view('admin.pengaduan.index', compact('pengaduans', 'jenisPengaduan', 'stats', 'monthly'));
    }

    public function create(): View
    {
        return view('admin.pengaduan.form', ['pengaduan' => null, 'jenisPilihan' => Pengaduan::JENIS]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);
        $validated['foto'] = $this->storePhotos($request);
        $validated['status'] = $validated['status'] ?? 'baru';
        $pengaduan = Pengaduan::create($validated);
        PengaduanRiwayatStatus::create(['pengaduan_id' => $pengaduan->id, 'user_id' => $request->user()->id, 'status_baru' => $pengaduan->status]);

        return redirect()->route('admin.pengaduan.show', $pengaduan)->with('success', 'Pengaduan berhasil ditambahkan.');
    }

    public function show(Pengaduan $pengaduan): View
    {
        $pengaduan->load(['catatan.admin', 'riwayatStatus.admin']);
        $waNumber = preg_replace('/\D+/', '', $pengaduan->telepon) ?? '';
        if (str_starts_with($waNumber, '00')) {
            $waNumber = substr($waNumber, 2);
        } elseif (str_starts_with($waNumber, '0')) {
            $waNumber = '62'.substr($waNumber, 1);
        } elseif (str_starts_with($waNumber, '8')) {
            $waNumber = '62'.$waNumber;
        }

        return view('admin.pengaduan.show', compact('pengaduan', 'waNumber'));
    }

    public function edit(Pengaduan $pengaduan): View
    {
        return view('admin.pengaduan.form', ['pengaduan' => $pengaduan, 'jenisPilihan' => array_values(array_unique([...Pengaduan::JENIS, $pengaduan->jenis]))]);
    }

    public function update(Request $request, Pengaduan $pengaduan): RedirectResponse
    {
        $validated = $this->validateData($request, true, $pengaduan->jenis);
        $existing = $pengaduan->foto ?? [];
        $removed = array_intersect($request->input('hapus_foto', []), $existing);
        $newPhotos = $request->file('bukti', []);
        if (count($existing) - count($removed) + count($newPhotos) > 3) {
            throw ValidationException::withMessages(['bukti' => 'Maksimal 3 foto bukti untuk setiap pengaduan.']);
        }
        foreach ($removed as $path) {
            Storage::disk('local')->delete($path);
        }
        $validated['foto'] = array_values([...array_diff($existing, $removed), ...$this->storePhotos($request)]);

        DB::transaction(function () use ($request, $pengaduan, $validated): void {
            $oldStatus = $pengaduan->status;
            $pengaduan->update($validated);
            if ($oldStatus !== $pengaduan->status) {
                PengaduanRiwayatStatus::create(['pengaduan_id' => $pengaduan->id, 'user_id' => $request->user()->id, 'status_lama' => $oldStatus, 'status_baru' => $pengaduan->status]);
            }
        });

        return redirect()->route('admin.pengaduan.show', $pengaduan)->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function destroy(Pengaduan $pengaduan): RedirectResponse
    {
        foreach ($pengaduan->foto ?? [] as $path) {
            Storage::disk('local')->delete($path);
        }
        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan dan foto bukti berhasil dihapus.');
    }

    public function addNote(Request $request, Pengaduan $pengaduan): RedirectResponse
    {
        $validated = $request->validate(['catatan' => ['required', 'string', 'max:5000']]);
        $pengaduan->catatan()->create(['user_id' => $request->user()->id, 'catatan' => $validated['catatan']]);

        return back()->with('success', 'Catatan tindak lanjut berhasil disimpan.');
    }

    public function photo(Pengaduan $pengaduan, int $photo): Response
    {
        $path = ($pengaduan->foto ?? [])[$photo] ?? abort(404);
        abort_unless(Storage::disk('local')->exists($path), 404);

        return response(Storage::disk('local')->get($path), 200, ['Content-Type' => Storage::disk('local')->mimeType($path) ?? 'application/octet-stream', 'Cache-Control' => 'private, no-store']);
    }

    public function exportExcel(Request $request): Response
    {
        $rows = $this->filteredQuery($request)->orderByDesc('created_at')->get();
        $html = view('admin.pengaduan.export-excel', compact('rows'))->render();

        return response($html, 200, ['Content-Type' => 'application/vnd.ms-excel; charset=UTF-8', 'Content-Disposition' => 'attachment; filename="data-pengaduan.xls"']);
    }

    public function exportPdf(Request $request): View
    {
        $rows = $this->filteredQuery($request)->orderByDesc('created_at')->get();

        return view('admin.pengaduan.export-pdf', compact('rows'));
    }

    /** @return Builder<Pengaduan> */
    private function filteredQuery(Request $request): Builder
    {
        $request->validate([
            'cari' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(Pengaduan::STATUSES)],
            'jenis' => ['nullable', 'string', 'max:255'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ]);

        return Pengaduan::query()
            ->when($request->filled('cari'), fn (Builder $query) => $query->where(fn (Builder $query) => $query->where('nama', 'like', '%'.$request->string('cari').'%')->orWhere('jenis', 'like', '%'.$request->string('cari').'%')))
            ->when($request->filled('status'), fn (Builder $query) => $query->where('status', $request->input('status')))
            ->when($request->filled('jenis'), fn (Builder $query) => $query->where('jenis', $request->input('jenis')))
            ->when($request->filled('tanggal_mulai'), fn (Builder $query) => $query->whereDate('created_at', '>=', $request->input('tanggal_mulai')))
            ->when($request->filled('tanggal_selesai'), fn (Builder $query) => $query->whereDate('created_at', '<=', $request->input('tanggal_selesai')));
    }

    /** @return array<string, mixed> */
    private function validateData(Request $request, bool $updating = false, ?string $legacyJenis = null): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'string', 'max:32', 'regex:/^[0-9+(). -]{8,32}$/'],
            'jenis' => ['required', Rule::in($legacyJenis ? [...Pengaduan::JENIS, $legacyJenis] : Pengaduan::JENIS)],
            'pesan' => ['required', 'string', 'max:10000'],
            'status' => [$updating ? 'required' : 'nullable', Rule::in(Pengaduan::STATUSES)],
            'bukti' => ['nullable', 'array', 'max:3'],
            'bukti.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'hapus_foto' => ['nullable', 'array'],
            'hapus_foto.*' => ['string'],
        ]);
    }

    /** @return array<int, string> */
    private function storePhotos(Request $request): array
    {
        return collect($request->file('bukti', []))->map(fn ($photo) => $photo->store('pengaduan', 'local'))->all();
    }
}
