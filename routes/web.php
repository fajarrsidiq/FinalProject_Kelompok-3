<?php

use App\Http\Controllers\CabangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotificationController; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('cabang', CabangController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('barang', BarangController::class); 
    Route::resource('pegawai', PegawaiController::class);
    Route::get('pegawai/{pegawai}/toggle-status', [PegawaiController::class, 'toggleStatus'])->name('pegawai.toggle-status');
});

// Routes notifikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
});

Route::middleware(['auth', 'role:kasir,supervisor,manager,owner'])->prefix('transaksi')->name('transaksi.')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('index');
    Route::get('/kasir', [TransaksiController::class, 'kasir'])->name('kasir');
    Route::post('/kasir/add-to-cart', [TransaksiController::class, 'addToCart'])->name('cart.add');
    Route::get('/kasir/remove-from-cart/{id}', [TransaksiController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/kasir/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
    Route::get('/invoice/{id}', [TransaksiController::class, 'invoice'])->name('invoice');
});

Route::middleware(['auth', 'role:gudang,manager,owner'])->prefix('stok')->name('stok.')->group(function () {
    Route::get('/', [StokController::class, 'index'])->name('index');
    Route::get('/mutasi', [StokController::class, 'mutasi'])->name('mutasi');
    Route::post('/mutasi/store', [StokController::class, 'storeMutasi'])->name('mutasi.store');
});

Route::middleware(['auth', 'role:owner,manager'])->prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/transaksi', [LaporanController::class, 'transaksi'])->name('transaksi');
    Route::post('/transaksi/cetak', [LaporanController::class, 'cetakTransaksi'])->name('transaksi.cetak');
    Route::get('/stok', [LaporanController::class, 'stok'])->name('stok');
    Route::post('/stok/cetak', [LaporanController::class, 'cetakStok'])->name('stok.cetak');
});

require __DIR__.'/auth.php';