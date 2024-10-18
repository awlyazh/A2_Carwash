<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\AkunController;


// Route untuk halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Route resource untuk transaksi (CRUD Transaksi)
// Ini sudah mencakup semua metode yang diperlukan, termasuk edit, update, dan destroy
Route::get('/transaksi', [TransaksiController::class, 'index']);
Route::get('/transaksi/create', [TransaksiController::class, 'create']);
Route::post('/transaksi/store', [TransaksiController::class, 'store']);
Route::get('/transaksi/{transaksi}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');


// Route resource untuk admin
Route::resource('admin', AdminController::class);

Route::resource('dashboard', DashboardController::class);
// Route untuk pelanggan
Route::get('/pelanggan', [PelangganController::class, 'index']);
Route::get('/pelanggan/create', [PelangganController::class, 'create']);
Route::post('/pelanggan/store', [PelangganController::class, 'store']);
// Rute untuk menampilkan form edit pelanggan berdasarkan nomor plat mobil
Route::get('/pelanggan/edit/{id}', [PelangganController::class, 'edit'])->name('pelanggan.edit');
// Rute untuk memperbarui data pelanggan berdasarkan nomor plat mobil
Route::put('/pelanggan/update/{no_plat}', [PelangganController::class, 'update'])->name('pelanggan.update');

// Rute untuk menghapus pelanggan berdasarkan nomor plat mobil
Route::delete('/pelanggan/destroy/{no_plat}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
// Route untuk halaman login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Route untuk proses login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Rute utama untuk halaman daftar akun
Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');

// Rute untuk menampilkan form tambah akun
Route::get('/akun/create', [AkunController::class, 'create'])->name('akun.create');

// Rute untuk menyimpan akun baru
Route::post('/akun', [AkunController::class, 'store'])->name('akun.store');

// Rute untuk menampilkan form edit akun
Route::get('/akun/{id}/edit', [AkunController::class, 'edit'])->name('akun.edit');

// Rute untuk memperbarui akun
Route::put('/akun/{id}', [AkunController::class, 'update'])->name('akun.update');

// Rute untuk menghapus akun
Route::delete('/akun/{id}', [AkunController::class, 'destroy'])->name('akun.destroy');


