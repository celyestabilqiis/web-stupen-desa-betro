<?php

use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\ArsipAdminController;
use App\Http\Controllers\Admin\PengaduanAdminController;
use App\Http\Controllers\Admin\UmkmAdminController;
use App\Http\Controllers\Admin\VillageInformationAdminController;
use App\Http\Controllers\Admin\VillageOfficialAdminController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\VillageInformationController;
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
    Route::get('/pengaduan/export/excel', [PengaduanAdminController::class, 'exportExcel'])->name('pengaduan.export.excel');
    Route::get('/pengaduan/export/pdf', [PengaduanAdminController::class, 'exportPdf'])->name('pengaduan.export.pdf');
    Route::get('/pengaduan/{pengaduan}/foto/{photo}', [PengaduanAdminController::class, 'photo'])->whereNumber('photo')->name('pengaduan.photo');
    Route::post('/pengaduan/{pengaduan}/catatan', [PengaduanAdminController::class, 'addNote'])->name('pengaduan.notes.store');
    Route::resource('pengaduan', PengaduanAdminController::class);
    Route::prefix('informasi-wilayah')->name('wilayah.')->controller(VillageInformationAdminController::class)->group(function (): void {
        Route::get('/', 'dashboard')->name('dashboard');
        Route::get('/gambaran-umum', 'profile')->name('profile');
        Route::put('/gambaran-umum', 'updateProfile')->name('profile.update');
        Route::get('/batas-wilayah', 'boundaries')->name('boundaries');
        Route::put('/batas-wilayah', 'updateBoundaries')->name('boundaries.update');
        Route::get('/peta', 'map')->name('map');
        Route::put('/peta', 'updateMap')->name('map.update');
        Route::get('/{section}', 'index')->whereIn('section', ['dusun', 'geografi', 'lahan'])->name('items.index');
        Route::get('/{section}/create', 'create')->whereIn('section', ['dusun', 'geografi', 'lahan'])->name('items.create');
        Route::post('/{section}', 'store')->whereIn('section', ['dusun', 'geografi', 'lahan'])->name('items.store');
        Route::get('/{section}/{item}', 'show')->whereIn('section', ['dusun', 'geografi', 'lahan'])->whereNumber('item')->name('items.show');
        Route::get('/{section}/{item}/edit', 'edit')->whereIn('section', ['dusun', 'geografi', 'lahan'])->whereNumber('item')->name('items.edit');
        Route::put('/{section}/{item}', 'update')->whereIn('section', ['dusun', 'geografi', 'lahan'])->whereNumber('item')->name('items.update');
        Route::delete('/{section}/{item}', 'destroy')->whereIn('section', ['dusun', 'geografi', 'lahan'])->whereNumber('item')->name('items.destroy');
    });
    Route::resource('arsip', ArsipAdminController::class)->except(['show']);
    Route::resource('umkm', UmkmAdminController::class)->except(['show']);
    Route::resource('struktur-pemerintahan', VillageOfficialAdminController::class)
        ->parameters(['struktur-pemerintahan' => 'villageOfficial']);

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
    Route::get('/informasi/wilayah', [VillageInformationController::class, 'index'])->name('pages.wilayah');
    Route::get('/potensi', 'potensi')->name('pages.potensi');
    Route::get('/profile', 'profile')->name('pages.profile');
    Route::get('/pengaduan', 'pengaduan')->name('pages.pengaduan');
    Route::get('/login', 'login')->name('pages.login');
});

Route::post('/pengaduan', [PageController::class, 'storePengaduan'])->middleware('throttle:pengaduan')->name('pages.pengaduan.store');

// Fitur Baru: Arsip & Dokumentasi Desa
Route::get('/arsip-dokumentasi', [ArsipController::class, 'index'])->name('pages.arsip.index');
Route::get('/arsip-dokumentasi/{slug}', [ArsipController::class, 'show'])->name('pages.arsip.show');
Route::get('/umkm/{slug}', [UmkmController::class, 'show'])->name('pages.umkm.show');

// Redirect 301 halaman lama ke /arsip-dokumentasi
Route::redirect('/informasi/dokumen', '/arsip-dokumentasi', 301);
Route::redirect('/informasi/kegiatan', '/arsip-dokumentasi', 301);
Route::redirect('/publikasi-dokumen', '/arsip-dokumentasi', 301);
Route::redirect('/dokumentasi-kegiatan', '/arsip-dokumentasi', 301);
Route::redirect('/informasi/statistik/{legacy?}', '/informasi/wilayah', 301)->where('legacy', '.*');
Route::redirect('/statistik-desa', '/informasi/wilayah', 301);
Route::redirect('/layanan', '/#informasi', 301);
Route::redirect('/pemerintahan', '/potensi#izin-usaha', 301);
