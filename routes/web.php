<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController; // Perbarui namespace untuk LoginController
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;
use App\Http\Controllers\Admin\PelangganController as AdminPelangganController;
use App\Http\Controllers\Admin\MobilController as AdminMobilController;
use App\Http\Controllers\Admin\DashboardController; // Perbarui namespace untuk DashboardController
use App\Http\Controllers\Admin\AkunController; // Perbarui namespace untuk AkunController
// use App\Http\Controllers\Karyawan\TransaksiController as KaryawanTransaksiController;
// use App\Http\Controllers\Karyawan\PelangganController as KaryawanPelangganController;
// use App\Http\Controllers\Karyawan\MobilController as KaryawanMobilController;

// Route untuk halaman utama
Route::get('/', function () {
    return view('auth.login');
})->name('home');

// Route untuk halaman login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Route untuk proses login
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

// Route untuk logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route untuk dashboard (akses admin dan karyawan)
Route::middleware(['auth', 'role:admin,karyawan'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    // Rute lainnya...
});

// Route untuk transaksi (akses hanya admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/transaksi', [AdminTransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [AdminTransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [AdminTransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi}/edit', [AdminTransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{transaksi}', [AdminTransaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/{transaksi}', [AdminTransaksiController::class, 'destroy'])->name('transaksi.destroy');
});

// Route untuk pelanggan (akses admin dan karyawan)
Route::middleware(['auth', 'role:admin,karyawan'])->group(function () {
    Route::get('/pelanggan', [AdminPelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/create', [AdminPelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('/pelanggan/store', [AdminPelangganController::class, 'store'])->name('pelanggan.store');
    Route::get('/pelanggan/edit/{id}', [AdminPelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::put('/pelanggan/update/{no_plat}', [AdminPelangganController::class, 'update'])->name('pelanggan.update');
    Route::delete('/pelanggan/destroy/{no_plat}', [AdminPelangganController::class, 'destroy'])->name('pelanggan.destroy');
});

// Route untuk akun (akses hanya admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::get('/akun/create', [AkunController::class, 'create'])->name('akun.create');
    Route::post('/akun', [AkunController::class, 'store'])->name('akun.store');
    Route::get('/akun/{id}/edit', [AkunController::class, 'edit'])->name('akun.edit');
    Route::put('/akun/{id}', [AkunController::class, 'update'])->name('akun.update');
    Route::delete('/akun/{id}', [AkunController::class, 'destroy'])->name('akun.destroy');
});
