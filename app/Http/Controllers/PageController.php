<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Contracts\View\View;

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

    public function statistik(): View
    {
        return view('pages.statistik');
    }

    public function potensi(): View
    {
        return view('pages.potensi');
    }

    public function profile(): View
    {
        return view('pages.profile');
    }

    public function pengaduan(): View
    {
        return view('pages.pengaduan');
    }

    public function login(): View
    {
        return view('pages.login');
    }
}
