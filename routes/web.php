<?php

use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// BEGIN Guest Handler
Route::prefix('/')->group(function () {
    Route::get('/', function () {
        $guestLand = \App\Models\GuestLand::get();
        return view('welcome')->with(compact('guestLand'));
    })->name('welcome');
    //BEGIN GuestLand Controller
    Route::controller(\App\Http\Controllers\Guest\SearchController::class)->prefix('search/')->name('Search')->group(function () {
        // Route::get('/', 'index'); //Index Default Layout
        Route::post('/store', 'store')->name('Store'); //Get Layout Create
        Route::get('{token}/token/{id}/show', 'show')->name('Show'); //Get Layout Create
    });
    //END GuestLand Controller
    Route::get('/download/{nib}', [\App\Http\Controllers\Admin\DownloadController::class, 'download'])->name('userDownload');
});
// END Guest Handler

Route::prefix('admin/')->middleware('auth', 'admin')->name('admin')->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');

    //BEGIN GuestLand Controller
    Route::controller(\App\Http\Controllers\Admin\UserController::class)->prefix('user/')->name('User')->group(function () {
        Route::get('/{select}/select', 'index'); //Index Default Layout
        Route::get('/create', 'create')->name('Create'); //Get Layout Create
        Route::post('/store', 'store')->name('Store'); //Get Layout Create
        Route::get('{id}/show', 'show')->name('Show'); //Get Layout Create
        Route::get('{id}/edit', 'edit')->name('Edit'); //Get Layout Create
        Route::post('{id}/update', 'update')->name('Update'); //Get Layout Create
        Route::get('{id}/destroy/{type}/type', 'destroy')->name('Destroy'); //Get Layout Create
    });
    //END GuestLand Controller

    //BEGIN GuestLand Controller
    Route::controller(\App\Http\Controllers\Admin\GuestLandController::class)->prefix('guest-land/')->name('GuestLand')->group(function () {
        Route::get('/', 'index'); //Index Default Layout
        Route::get('/create', 'create')->name('Create'); //Get Layout Create
        Route::post('/store', 'store')->name('Store'); //Get Layout Create
        Route::get('{id}/show', 'show')->name('Show'); //Get Layout Create
        Route::get('{id}/edit', 'edit')->name('Edit'); //Get Layout Create
        Route::post('{id}/update', 'update')->name('Update'); //Get Layout Create
        Route::get('{id}/destroy', 'destroy')->name('Destroy'); //Get Layout Create
    });
    //END GuestLand Controller

    //BEGIN GuestLand Controller
    Route::controller(\App\Http\Controllers\Admin\PetugasController::class)->prefix('petugas/')->name('Petugas')->group(function () {
        Route::get('/', 'index'); //Index Default Layout
        // Route::get('/create', 'create')->name('Create'); //Get Layout Create
        // Route::post('/store', 'store')->name('Store'); //Get Layout Create
        Route::get('{id}/show', 'show')->name('Show'); //Get Layout Create
        Route::get('{id}/edit', 'edit')->name('Edit'); //Get Layout Create
        Route::post('{id}/update', 'update')->name('Update'); //Get Layout Create
        // Route::get('{id}/destroy', 'destroy')->name('Destroy'); //Get Layout Create
    });
    //END GuestLand Controller

    // BEGIN Proses Hanlder
    // BEGIN Admin Pemilihan Petugas Controller
    Route::controller(\App\Http\Controllers\Admin\PemilihanPetugasController::class)->prefix('pemilihan-petugas/')->name('PemilihanPetugas')->group(function () {
        Route::get('/', 'index'); //Index Default Layout
        Route::get('/create', 'create')->name('Create'); //Get Layout Create
        Route::post('/store', 'store')->name('Store'); //Get Layout Create
        Route::get('{id}/show', 'show')->name('Show'); //Get Layout Create
        Route::get('{id}/edit', 'edit')->name('Edit'); //Get Layout Create
        Route::post('{id}/update', 'update')->name('Update'); //Get Layout Create
        Route::get('{id}/destroy', 'destroy')->name('Destroy'); //Get Layout Create
    });
    // END Admin Pemilihan Petugas Controller

    // BEGIN Admin Pengukuran Wilayah Bidang Controller
    Route::controller(\App\Http\Controllers\Admin\PengukuranBidangController::class)->prefix('pengukuran-bidang-tanah/')->name('PengukuranBidang')->group(function () {
        Route::get('/', 'index'); //Index Default Layout
        Route::get('/create', 'create')->name('Create'); //Get Layout Create
        Route::post('/store', 'store')->name('Store'); //Get Layout Create
        Route::get('{id}/show', 'show')->name('Show'); //Get Layout Create
        Route::get('{id}/edit', 'edit')->name('Edit'); //Get Layout Create
        Route::post('{id}/update', 'update')->name('Update'); //Get Layout Create
        Route::get('{id}/destroy/', 'destroy')->name('Destroy'); //Get Layout Create
    });
    // END Admin Pengukuran Wilayah Bidang Controller

    // BEGIN Admin Pengukuran Wilayah Bidang Controller
    Route::controller(\App\Http\Controllers\Admin\PembuatanPetaController::class)->prefix('pembuatan-peta/')->name('PembuatanPeta')->group(function () {
        Route::get('/', 'index'); //Index Default Layout
        Route::get('/create', 'create')->name('Create'); //Get Layout Create
        Route::post('/store', 'store')->name('Store'); //Get Layout Create
        Route::get('{id}/show', 'show')->name('Show'); //Get Layout Create
        Route::get('{id}/edit', 'edit')->name('Edit'); //Get Layout Create
        Route::post('{id}/update', 'update')->name('Update'); //Get Layout Create
        Route::get('{id}/destroy', 'destroy')->name('Destroy'); //Get Layout Create
    });
    // END Admin Pengukuran Wilayah Bidang Controller
    // BEGIN Admin Pengukuran Wilayah Bidang Controller
    Route::controller(\App\Http\Controllers\Admin\ValidasiPekerjaanController::class)->prefix('validasi-pekerjaan/')->name('ValidasiPekerjaan')->group(function () {
        Route::get('/', 'index'); //Index Default Layout
        Route::get('/create', 'create')->name('Create'); //Get Layout Create
        Route::post('/store', 'store')->name('Store'); //Get Layout Create
        Route::get('{id}/show', 'show')->name('Show'); //Get Layout Create
        Route::get('{id}/edit', 'edit')->name('Edit'); //Get Layout Create
        Route::post('{id}/update', 'update')->name('Update'); //Get Layout Create
        Route::get('{id}/destroy', 'destroy')->name('Destroy'); //Get Layout Create
    });
    // END Admin Pengukuran Wilayah Bidang Controller
    //END Proses Handler

    //BEGIN Pengukuran Bidang Controller
    Route::controller(\App\Http\Controllers\Admin\KecamatanController::class)->prefix('kecamatan')->name('Kecamatan')->group(function () {
        Route::get('/', 'index'); //Index Default Layout
        Route::get('/create', 'create')->name('Create'); //Get Layout Create
        Route::post('/store', 'store')->name('Store'); //Get Layout Create
        Route::get('{id}/show', 'show')->name('Show'); //Get Layout Create
        Route::get('{id}/edit', 'edit')->name('Edit'); //Get Layout Create
        Route::post('{id}/update', 'update')->name('Update'); //Get Layout Create
        Route::get('{id}/destroy', 'destroy')->name('Destroy'); //Get Layout Create
    });
    //END Pengukuran Bidang Controller

    //BEGIN Pengukuran Bidang Controller
    Route::controller(\App\Http\Controllers\Admin\DesaController::class)->prefix('desa')->name('Desa')->group(function () {
        Route::get('/', 'index'); //Index Default Layout
        Route::get('/create', 'create')->name('Create'); //Get Layout Create
        Route::post('/store', 'store')->name('Store'); //Get Layout Create
        Route::get('{id}/show', 'show')->name('Show'); //Get Layout Create
        Route::get('{id}/edit', 'edit')->name('Edit'); //Get Layout Create
        Route::post('{id}/update', 'update')->name('Update'); //Get Layout Create
        Route::get('{id}/destroy', 'destroy')->name('Destroy'); //Get Layout Create
    });
    //END Pengukuran Bidang Controller

    Route::get('/download/{nib}', [\App\Http\Controllers\Admin\DownloadController::class, 'download'])->name('Download');
});

Route::prefix('petugas/')->middleware('auth', 'petugas')->name('petugas')->group(function () {

    // Route::get('/dashboard', function () {
    //     return view('pages.petugas.dashboard');
    //     // })->middleware(['auth'])->name('dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [\App\Http\Controllers\Petugas\PetugasController::class, 'index'])->name('dashboard');

    //BEGIN Daftar Tugas Controller
    Route::controller(\App\Http\Controllers\Petugas\DaftarTugasController::class)->prefix('daftar-pekerjaan')->name('DaftarTugas')->group(function () {
        Route::get('/', 'index'); //Index Default Layout
        Route::get('/create', 'create')->name('Create'); //Get Layout Create
        Route::get('{id}/show', 'show')->name('Show'); //Get Layout Create
        Route::post('{id}/update', 'update')->name('Update'); //Get Layout Create
        Route::get('{id}/destroy', 'destroy')->name('Destroy'); //Get Layout Create
    });
    //END Daftar Tugas Controller

    //BEGIN Daftar Tugas Controller
    Route::controller(\App\Http\Controllers\Petugas\ValidasiPekerjaanController::class)->prefix('validasi-pekerjaan')->name('ValidasiPekerjaan')->group(function () {
        Route::get('/', 'index'); //Index Default Layout
        Route::get('/create', 'create')->name('Create'); //Get Layout Create
        Route::get('{id}/show', 'show')->name('Show'); //Get Layout Create
        Route::post('{id}/update', 'update')->name('Update'); //Get Layout Create
        Route::get('{id}/destroy', 'destroy')->name('Destroy'); //Get Layout Create
    });
    //END Daftar Tugas Controller

    //BEGIN Daftar Tugas Controller
    Route::controller(\App\Http\Controllers\Petugas\PengukuranBidangController::class)->prefix('pengukuran-bidang')->name('PengukuranBidang')->group(function () {
        Route::get('/', 'index'); //Index Default Layout
        Route::get('/create', 'create')->name('Create'); //Get Layout Create
        Route::get('{id}/show', 'show')->name('Show'); //Get Layout Create
        Route::get('{id}/edit', 'edit')->name('Edit'); //Get Layout Create
        Route::post('{id}/update', 'update')->name('Update'); //Get Layout Create
        Route::get('{id}/destroy', 'destroy')->name('Destroy'); //Get Layout Create
    });
    //END Daftar Tugas Controller

    //BEGIN Pembuatan Peta Bidang Controller
    Route::controller(\App\Http\Controllers\Petugas\PembuatanPetaController::class)->prefix('pembuatan-peta')->name('PembuatanPeta')->group(function () {
        Route::get('/', 'index'); //Index Default Layout
        Route::get('/create', 'create')->name('Create'); //Get Layout Create
        Route::get('{id}/show', 'show')->name('Show'); //Get Layout Create
        Route::get('{id}/edit', 'edit')->name('Edit'); //Get Layout Create
        Route::post('{id}/update', 'update')->name('Update'); //Get Layout Create
        Route::get('{id}/destroy', 'destroy')->name('Destroy'); //Get Layout Create
    });
    //END Pembuatan Peta Bidang Controller

});




require __DIR__ . '/auth.php';
