<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
//

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('barang', BarangController::class);
    Route::resource('pegawai', PegawaiController::class);
});

Route::middleware(['auth', 'role:gudang,manager,owner'])->prefix('stok')->name('stok.')->group(function () {
    Route::get('/', [StokController::class, 'index'])->name('index');
    Route::get('/mutasi', [StokController::class, 'mutasi'])->name('mutasi');
    Route::post('/mutasi/store', [StokController::class, 'storeMutasi'])->name('mutasi.store');
});



require __DIR__.'/auth.php';