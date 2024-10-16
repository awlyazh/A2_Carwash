<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\DashboardController;

// Route resource untuk transaksi (CRUD Transaksi)
// Definisikan route untuk transaksi
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index'); // Menampilkan daftar transaksi
Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create'); // Menampilkan form tambah transaksi
Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store'); // Menyimpan transaksi
Route::get('/transaksi/{transaksi}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit'); // Menampilkan form edit transaksi
Route::put('/transaksi/{transaksi}', [TransaksiController::class, 'update'])->name('transaksi.update'); // Memperbarui transaksi
Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy'); // Menghapus transaksi


// Route resource untuk admin
Route::resource('admin', AdminController::class);

Route::resource('dashboard', DashboardController::class);

Route::get('/pelanggan', [PelangganController::class, 'index']);

Route::get('/pelanggan/create', [PelangganController::class, 'create']);


Route::post('/pelanggan/store', [PelangganController::class, 'store']);
