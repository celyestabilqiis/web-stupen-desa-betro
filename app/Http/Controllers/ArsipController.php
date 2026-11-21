<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class ArsipController extends Controller
{
    public function index(Request $request): View
    {
        $query = Arsip::query()
            ->terbit()
            ->with('penulis')
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at');

        if ($request->filled('kategori') && in_array($request->input('kategori'), ['arsip_desa', 'dokumentasi_desa'])) {
            $query->where('kategori', $request->input('kategori'));
        }

        $arsipList = $query->paginate(6)->withQueryString();

        return view('pages.arsip-dokumentasi.index', compact('arsipList'));
    }

    public function show(Request $request, string $slug): View|BinaryFileResponse|Response
    {
        $arsip = Arsip::query()
            ->terbit()
            ->where('slug', $slug)
            ->with('penulis')
            ->firstOrFail();

        // Tambah jumlah_dilihat (1x per sesi per arsip)
        $sessionKey = 'arsip_viewed_'.$arsip->id;
        if (! $request->session()->has($sessionKey)) {
            $arsip->increment('jumlah_dilihat');
            $request->session()->put($sessionKey, true);
        }

        // PDF: tampilkan inline
        if ($arsip->tipe === 'pdf' && $arsip->file_pdf) {
            $filePath = storage_path('app/public/'.$arsip->file_pdf);
            if (file_exists($filePath)) {
                return response()->file($filePath, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.basename($arsip->file_pdf).'"',
                ]);
            }
            abort(404);
        }

        // Sidebar: arsip terbaru
        $arsipTerbaru = Arsip::query()
            ->terbit()
            ->where('id', '!=', $arsip->id)
            ->with('penulis')
            ->orderByDesc('tanggal')
            ->limit(7)
            ->get();

        return view('pages.arsip-dokumentasi.show', compact('arsip', 'arsipTerbaru'));
    }
}
