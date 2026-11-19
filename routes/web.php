<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/admin', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin', [AuthController::class, 'login'])->name('admin.authenticate');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('pages.home');
    Route::get('/informasi', 'informasi')->name('pages.informasi');
    Route::get('/informasi/statistik', 'statistik')->name('pages.informasi.statistik');
    Route::get('/informasi/dokumen', 'dokumen')->name('pages.informasi.dokumen');
    Route::get('/informasi/kegiatan', 'kegiatan')->name('pages.informasi.kegiatan');
    Route::get('/potensi', 'potensi')->name('pages.potensi');
    Route::get('/profile', 'profile')->name('pages.profile');
    Route::get('/pengaduan', 'pengaduan')->name('pages.pengaduan');
    Route::get('/login', 'login')->name('pages.login');
});

Route::redirect('/statistik-desa', '/informasi/statistik', 301);
Route::redirect('/publikasi-dokumen', '/informasi/dokumen', 301);
Route::redirect('/dokumentasi-kegiatan', '/informasi/kegiatan', 301);
Route::redirect('/layanan', '/#informasi', 301);
Route::redirect('/pemerintahan', '/potensi#izin-usaha', 301);
