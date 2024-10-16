<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Mobil;
use App\Models\Akun;

class TransaksiController extends Controller
{
    // Menampilkan daftar transaksi
    public function index()
    {
        $transaksi = Transaksi::all();
        return view('transaksi.index', compact('transaksi'));
    }

    // Menampilkan form tambah transaksi
    public function create()
    {
        $pelanggan = Pelanggan::all();
        $mobil = Mobil::all();
        $akun = Akun::all();
        return view('transaksi.create', compact('pelanggan', 'mobil', 'akun'));
    }

    // Menyimpan data transaksi baru
    public function store(Request $request)
    {

        Transaksi::create($request->all());
        return redirect()->to('transaksi')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    // Menampilkan form edit transaksi
    public function edit(Transaksi $transaksi)
    {
        // Ambil semua mobil, pelanggan, dan akun untuk mengisi dropdown pada form
        $mobil = Mobil::all();
        $pelanggan = Pelanggan::all();
        $akun = Akun::all();

        // Tampilkan view edit dengan data transaksi, mobil, pelanggan, dan akun
        return view('transaksi.edit', compact('transaksi', 'mobil', 'pelanggan', 'akun'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        // Validasi input
        $request->validate([
            'no_plat_mobil' => 'required|string|regex:/^[A-Z0-9\s]+$/',
            'tanggal_transaksi' => 'required|date',
            'metode_pembayaran' => 'required|string|max:50',
            'total_pembayaran' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);

        // Update transaksi dengan data yang diinputkan
        $transaksi->update($request->all());

        // Redirect ke halaman transaksi.index
        return redirect()->to('transaksi')->with('success', 'Transaksi berhasil diperbarui.');
    }


    // Menghapus transaksi
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
