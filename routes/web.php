<?php

use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\ArsipAdminController;
use App\Http\Controllers\Admin\UmkmAdminController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UmkmController;
use App\Models\Arsip;
use App\Models\Umkm;
use Illuminate\Support\Facades\Route;

Route::get('/admin', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin', [AuthController::class, 'login'])->name('admin.authenticate');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalArsip = Arsip::count();
        $totalTerbit = Arsip::where('status', 'terbit')->count();
        $totalDraft = Arsip::where('status', 'draft')->count();
        $totalArsipDesa = Arsip::where('kategori', 'arsip_desa')->count();
        $totalDokumentasi = Arsip::where('kategori', 'dokumentasi_desa')->count();
        $arsipTerbaru = Arsip::with('penulis')->orderByDesc('created_at')->limit(5)->get();
        $umkmTerbaru = Umkm::withCount('products')->orderByDesc('created_at')->limit(3)->get();

        return view('admin.dashboard', compact(
            'totalArsip',
            'totalTerbit',
            'totalDraft',
            'totalArsipDesa',
            'totalDokumentasi',
            'arsipTerbaru',
            'umkmTerbaru'
        ));
    })->name('dashboard');

    Route::post('/arsip/upload-editor-image', [ArsipAdminController::class, 'uploadEditorImage'])->name('arsip.upload-image');
    Route::resource('arsip', ArsipAdminController::class)->except(['show']);
    Route::resource('umkm', UmkmAdminController::class)->except(['show']);

    Route::get('/accounts', [AdminAccountController::class, 'index'])->name('accounts.index');
    Route::get('/accounts/create', [AdminAccountController::class, 'create'])->name('accounts.create');
    Route::post('/accounts', [AdminAccountController::class, 'store'])->name('accounts.store');
    Route::get('/accounts/{user}/password', [AdminAccountController::class, 'editPassword'])->name('accounts.edit-password');
    Route::put('/accounts/{user}/password', [AdminAccountController::class, 'updatePassword'])->name('accounts.update-password');
    Route::delete('/accounts/{user}', [AdminAccountController::class, 'destroy'])->name('accounts.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Halaman Publik
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('pages.home');
    Route::get('/informasi', 'informasi')->name('pages.informasi');
    Route::get('/informasi/statistik', 'statistik')->name('pages.informasi.statistik');
    Route::get('/potensi', 'potensi')->name('pages.potensi');
    Route::get('/profile', 'profile')->name('pages.profile');
    Route::get('/pengaduan', 'pengaduan')->name('pages.pengaduan');
    Route::get('/login', 'login')->name('pages.login');
});

// Fitur Baru: Arsip & Dokumentasi Desa
Route::get('/arsip-dokumentasi', [ArsipController::class, 'index'])->name('pages.arsip.index');
Route::get('/arsip-dokumentasi/{slug}', [ArsipController::class, 'show'])->name('pages.arsip.show');
Route::get('/umkm/{slug}', [UmkmController::class, 'show'])->name('pages.umkm.show');

// Redirect 301 halaman lama ke /arsip-dokumentasi
Route::redirect('/informasi/dokumen', '/arsip-dokumentasi', 301);
Route::redirect('/informasi/kegiatan', '/arsip-dokumentasi', 301);
Route::redirect('/publikasi-dokumen', '/arsip-dokumentasi', 301);
Route::redirect('/dokumentasi-kegiatan', '/arsip-dokumentasi', 301);
Route::redirect('/statistik-desa', '/informasi/statistik', 301);
Route::redirect('/layanan', '/#informasi', 301);
Route::redirect('/pemerintahan', '/potensi#izin-usaha', 301);
