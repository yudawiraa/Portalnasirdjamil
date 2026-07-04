<?php

use App\Http\Controllers\Admin\AspirasiAdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\TrackingAspirasiController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');

Route::middleware('private.site')->group(function (): void {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');
    Route::get('/profil', [PageController::class, 'profil'])->name('profil');
    Route::get('/kegiatan', [PageController::class, 'kegiatan'])->name('kegiatan');
    Route::get('/kegiatan/{slug}', [PageController::class, 'kegiatanDetail'])->name('kegiatan.show');
    Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri');
    Route::get('/galeri/{slug}', [PageController::class, 'galeriDetail'])->name('galeri.show');
    Route::redirect('/komisi-iii', '/#komisi-iii')->name('komisi-iii');
    Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');

    Route::get('/aspirasi', [AspirasiController::class, 'create'])->name('aspirasi.create');
    Route::post('/aspirasi', [AspirasiController::class, 'store'])->middleware('throttle:10,1')->name('aspirasi.store');
    Route::get('/aspirasi/sukses/{code}', [AspirasiController::class, 'success'])->name('aspirasi.success');

    Route::get('/cek-aspirasi', [TrackingAspirasiController::class, 'form'])->name('aspirasi.track.form');
    Route::post('/cek-aspirasi', [TrackingAspirasiController::class, 'lookup'])->middleware('throttle:20,1')->name('aspirasi.track.lookup');
});

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.submit');

    Route::middleware(['auth', 'admin'])->group(function (): void {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/aspirasi', [AspirasiAdminController::class, 'index'])->name('aspirasi.index');
        Route::get('/aspirasi/export/{format}', [AspirasiAdminController::class, 'export'])->whereIn('format', ['csv', 'xls'])->name('aspirasi.export');
        Route::get('/aspirasi/{aspirasi}', [AspirasiAdminController::class, 'show'])->name('aspirasi.show');
        Route::patch('/aspirasi/{aspirasi}', [AspirasiAdminController::class, 'update'])->name('aspirasi.update');
        Route::get('/aspirasi/{aspirasi}/attachments/{attachment}', [AspirasiAdminController::class, 'download'])->name('aspirasi.attachments.download');
    });
});
