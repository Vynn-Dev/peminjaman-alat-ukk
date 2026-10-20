<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\alatController;
use App\Http\Controllers\peminjamanController;
use App\Http\Controllers\pengembalianController;

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

Route::get('/dashboard', function () {

    if (auth()->user()->role == 'admin') {
        return view('dashboard.admin');
    }

    if (auth()->user()->role == 'petugas') {
        return view('dashboard.petugas');
    }

    if (auth()->user()->role == 'peminjam') {
        return view('dashboard.peminjam');
    }

})->middleware(['auth'])->name('dashboard');

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

Route::middleware(['auth', 'role:petugas'])->group(function () {

    Route::get(
        '/peminjaman/{id}/approve',
        [PeminjamanController::class, 'approve']
    )->name('peminjaman.approve');

});

/*
|--------------------------------------------------------------------------
| PENGEMBALIAN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::post(
        '/pengembalian/{id}',
        [PengembalianController::class, 'store']
    )->name('pengembalian.store');

});

require __DIR__.'/auth.php';