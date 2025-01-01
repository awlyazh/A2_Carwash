<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\SPKController;

Route::get('/transaksi/sendWhatsApp/{id}', [TransaksiController::class, 'sendWhatsApp'])->name('transaksi.sendWhatsApp');
Route::post('mobil/store', [MobilController::class, 'store'])->name('mobil.store');

// Route untuk halaman utama
Route::get('/', function () {
    return view('auth.login');
})->name('home');

// Route untuk halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Route untuk proses login
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Route untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk dashboard (akses admin dan karyawan)
Route::middleware(['auth', 'role:admin,karyawan'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    // Rute lainnya...
});

Route::resource('harga', HargaController::class);

// Route untuk transaksi (akses admin dan karyawan)
Route::middleware(['auth', 'role:admin,karyawan'])->group(function () {
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi:id_transaksi}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{transaksi}', [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
});

// Route untuk pelanggan (akses admin dan karyawan)
Route::middleware(['auth', 'role:admin,karyawan'])->group(function () {
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('/pelanggan/store', [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::get('/pelanggan/edit/{id}', [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::put('/pelanggan/update/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::delete('/pelanggan/destroy/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
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

// Route untuk laporan (akses hanya admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak/{tanggal_awal}/{tanggal_akhir}', [LaporanController::class, 'cetak'])->name('laporan.cetak');
    Route::get('/laporan/download/{tanggal_awal}/{tanggal_akhir}', [LaporanController::class, 'download'])->name('laporan.download');
});

// Route untuk karyawan (akses admin saja)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
    Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::get('/karyawan/{id_karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::put('/karyawan/{id_karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::delete('/karyawan/{id_karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
});

Route::post('/transaksi/{id}/kirimWhatsapp', [TransaksiController::class, 'kirimWhatsapp'])->name('transaksi.kirimWhatsapp');

// Route Hitung SPK
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/spk', [SPKController::class, 'index'])->name('spk.index');
    Route::post('/spk/hitungAHP', [SPKController::class, 'hitungAHP'])->name('spk.hitungAHP');
    Route::post('/spk/hitungSAW', [SPKController::class, 'hitungSAW'])->name('spk.hitungSAW');
    Route::get('/spk/cetak', [SPKController::class, 'cetakSPK'])->name('spk.cetak');
    Route::post('/spk/simpan', [SPKController::class, 'simpanHasil'])->name('spk.simpan');
    Route::get('/spk/lihat', [SPKController::class, 'lihatPDF'])->name('spk.lihat');
    Route::delete('/spk/hapus', [SPKController::class, 'hapusSPK'])->name('spk.hapus');
    Route::get('/laporan-spk', [SPKController::class, 'laporanSPK'])->name('spk.laporan');
});
