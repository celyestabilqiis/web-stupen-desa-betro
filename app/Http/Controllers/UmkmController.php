<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\View\View;

class UmkmController extends Controller
{
    public function show(string $slug): View
    {
        $umkm = Umkm::published()->with('products')->where('slug', $slug)->firstOrFail();

        return view('pages.umkm.show', compact('umkm'));
    }
}
