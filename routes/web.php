<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KatalogController;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD MULTI ROLE
|--------------------------------------------------------------------------
*/

Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)->middleware(['auth'])
 ->name('dashboard');

/*
|--------------------------------------------------------------------------
| KATALOG ALAT (SEMUA ROLE)
|--------------------------------------------------------------------------
*/

Route::get(
    '/katalog',
    [KatalogController::class, 'index']
)->middleware(['auth'])
 ->name('katalog.index');

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    /*
    |----------------------------------------
    | CRUD KATEGORI
    |----------------------------------------
    */

    Route::resource('kategori', KategoriController::class);

    /*
    |----------------------------------------
    | CRUD ALAT MUSIK
    |----------------------------------------
    */

    Route::resource('alat', AlatController::class);

});

/*
|--------------------------------------------------------------------------
| PEMINJAMAN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::resource('peminjaman', PeminjamanController::class);

});

/*
|--------------------------------------------------------------------------
| PETUGAS APPROVAL
|--------------------------------------------------------------------------
*/

Route::post(
    '/peminjaman/{id}/approve',
    [PeminjamanController::class, 'approve']
)->middleware(['auth', 'role:petugas'])
 ->name('peminjaman.approve');

Route::post(
    '/peminjaman/{id}/tolak',
    [PeminjamanController::class, 'tolak']
)->middleware(['auth', 'role:petugas'])
 ->name('peminjaman.tolak');

/*
|--------------------------------------------------------------------------
| PENGEMBALIAN
|--------------------------------------------------------------------------
*/

Route::post(
    '/pengembalian/{id}',
    [PengembalianController::class, 'store']
)->middleware(['auth'])
 ->name('pengembalian.store');

/*
|--------------------------------------------------------------------------
| LOG AKTIVITAS (ADMIN)
|--------------------------------------------------------------------------
*/

Route::get(
    '/log-aktivitas',
    [LogAktivitasController::class, 'index']
)->middleware(['auth', 'role:admin'])
 ->name('logaktivitas.index');

require __DIR__.'/auth.php';