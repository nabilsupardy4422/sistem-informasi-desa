<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| PUBLIC CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\BeritaController as PublicBeritaController;
use App\Http\Controllers\Public\LayananController as PublicLayananController;
use App\Http\Controllers\Public\PengaduanController as PublicPengaduanController;
use App\Http\Controllers\Public\TrackingController as PublicTrackingController;
use App\Http\Controllers\Public\ApbdesController as PublicApbdesController;
use App\Http\Controllers\Public\PublicController;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\AdminLayananController;
use App\Http\Controllers\Admin\AdminPermohonanController;
use App\Http\Controllers\Admin\AdminPengaduanController;
use App\Http\Controllers\Admin\AdminTrackingController;
use App\Http\Controllers\Admin\ApbdesController as AdminApbdesController;
use App\Http\Controllers\Admin\PendudukController;
use App\Http\Controllers\Admin\UmkmController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | BERITA
    |--------------------------------------------------------------------------
    */

    Route::resource('berita', AdminBeritaController::class)
        ->names('berita');

    Route::get('/berita-data', [AdminBeritaController::class, 'getData'])
        ->name('berita.data');

    /*
    |--------------------------------------------------------------------------
    | LAYANAN MASTER
    |--------------------------------------------------------------------------
    */

    Route::prefix('layanan')->name('layanan.')->group(function () {
        Route::get('/', [AdminLayananController::class, 'index'])->name('index');
        Route::post('/', [AdminLayananController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminLayananController::class, 'show'])->name('show');
        Route::put('/{id}', [AdminLayananController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminLayananController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-status', [AdminLayananController::class, 'toggleStatus'])->name('toggle-status');
    });

    /*
    |--------------------------------------------------------------------------
    | PERMOHONAN
    |--------------------------------------------------------------------------
    */

    Route::prefix('permohonan')->name('permohonan.')->group(function () {
        Route::get('/', [AdminPermohonanController::class, 'index'])->name('index');

        Route::get('/{id}', [AdminPermohonanController::class, 'show'])->name('show');

        Route::put('/{id}', [AdminPermohonanController::class, 'update'])->name('update');

        Route::delete('/{id}', [AdminPermohonanController::class, 'destroy'])->name('destroy');

        Route::get('/{id}/download/{type}', [AdminPermohonanController::class, 'downloadDocument'])
            ->name('download');
    });

    /*
    |--------------------------------------------------------------------------
    | PENGADUAN
    |--------------------------------------------------------------------------
    */

    Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
        Route::get('/', [AdminPengaduanController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminPengaduanController::class, 'show'])->name('show');
        Route::put('/{id}', [AdminPengaduanController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminPengaduanController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | TRACKING
    |--------------------------------------------------------------------------
    */

    Route::prefix('tracking')->name('tracking.')->group(function () {
        Route::get('/', [AdminTrackingController::class, 'index'])->name('index');
        Route::get('/data', [AdminTrackingController::class, 'data'])->name('data');
        Route::get('/show/{trackingCode}', [AdminTrackingController::class, 'show'])->name('show');
        Route::delete('/{id}', [AdminTrackingController::class, 'destroy'])->name('destroy');
        Route::delete('/code/{trackingCode}', [AdminTrackingController::class, 'destroyByCode'])->name('destroy-code');
    });

    /*
    |--------------------------------------------------------------------------
    | APBDES
    |--------------------------------------------------------------------------
    */

    Route::resource('apbdes', AdminApbdesController::class)
        ->names('apbdes');

    Route::post('/apbdes-detail', [AdminApbdesController::class, 'storeDetail'])
        ->name('apbdes.detail.store');

    Route::get('/apbdes-detail/{id}', [AdminApbdesController::class, 'showDetail'])
        ->name('apbdes.detail.show');

    Route::post('/apbdes-detail/{id}', [AdminApbdesController::class, 'updateDetail'])
        ->name('apbdes.detail.update');

    Route::delete('/apbdes-detail/{id}', [AdminApbdesController::class, 'destroyDetail'])
        ->name('apbdes.detail.destroy');

    Route::get('/apbdes/{id}/detail', [AdminApbdesController::class, 'detail'])
        ->name('apbdes.detail');

    /*
    |--------------------------------------------------------------------------
    | PENDUDUK
    |--------------------------------------------------------------------------
    */

    Route::resource('penduduk', PendudukController::class)
        ->names('penduduk');

    Route::get('/penduduk-data', [PendudukController::class, 'getData'])
        ->name('penduduk.data');

    /*
    |--------------------------------------------------------------------------
    | UMKM
    |--------------------------------------------------------------------------
    */

    Route::prefix('umkm')->name('umkm.')->group(function () {
        Route::get('/', [UmkmController::class, 'index'])->name('index');
        Route::post('/', [UmkmController::class, 'store'])->name('store');
        Route::get('/data', [UmkmController::class, 'data'])->name('data');
        Route::get('/{id}', [UmkmController::class, 'show'])->name('show');
        Route::post('/{id}', [UmkmController::class, 'update'])->name('update');
        Route::delete('/{id}', [UmkmController::class, 'destroy'])->name('destroy');
    });
});


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('berita')->name('public.berita.')->group(function () {
    Route::get('/', [PublicBeritaController::class, 'index'])->name('index');
    Route::get('/{id}', [PublicBeritaController::class, 'show'])->name('show');
});

Route::prefix('layanan')->name('public.layanan.')->group(function () {
    Route::get('/', [PublicLayananController::class, 'index'])->name('index');
    Route::get('/{id}', [PublicLayananController::class, 'show'])->name('show');
    Route::post('/ajukan', [PublicLayananController::class, 'ajukan'])->name('ajukan');
});

Route::prefix('pengaduan')->name('public.pengaduan.')->group(function () {
    Route::get('/', [PublicPengaduanController::class, 'index'])->name('index');
    Route::post('/', [PublicPengaduanController::class, 'store'])->name('store');
});

Route::prefix('tracking')->name('public.tracking.')->group(function () {
    Route::get('/', [PublicTrackingController::class, 'index'])->name('index');
    Route::post('/', [PublicTrackingController::class, 'cari'])->name('cari');
});

Route::prefix('apbdes')->name('public.apbdes.')->group(function () {
    Route::get('/', [PublicApbdesController::class, 'index'])->name('index');
    Route::get('/data', [PublicApbdesController::class, 'data'])->name('data');
    Route::get('/{id}', [PublicApbdesController::class, 'detail'])->name('detail');
});

Route::get('/penduduk', [PublicController::class, 'penduduk'])
    ->name('public.penduduk');

    Route::get('/umkm', [PublicController::class, 'umkm'])
    ->name('public.umkm.index');

Route::get('/umkm/{id}', [PublicController::class, 'umkmShow'])
    ->name('public.umkm.show');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';