<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.index');
    }

    public function informasi(): View
    {
        return view('pages.informasi');
    }

    public function statistik(): View
    {
        return view('pages.statistik');
    }

    public function dokumen(): View
    {
        return view('pages.dokumen');
    }

    public function kegiatan(): View
    {
        return view('pages.kegiatan');
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
