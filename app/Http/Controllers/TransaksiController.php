<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Mobil;
use App\Models\Akun;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    // Menampilkan daftar transaksi
    public function index()
    {
        $transaksi = Transaksi::with(['pelanggan', 'mobil'])->get(); // Memuat pelanggan dan mobil terkait

        return view('transaksi.index', compact('transaksi'));
    }


    // Menampilkan form tambah transaksi
    public function create()
    {
        // Mengambil data pelanggan beserta mobilnya
        $pelanggan = Pelanggan::with('mobil')->get();
        $mobil = Mobil::all();
        $akun = Akun::all();

        return view('transaksi.create', compact('pelanggan', 'mobil', 'akun'));
    }

    // Menyimpan data transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'tanggal_transaksi' => 'required|date',
            'metode_pembayaran' => 'required|string',
            'jenis_mobil' => 'required|string',
            'total_pembayaran' => 'required|numeric',
            'status' => 'required|string',
        ]);

        // Simpan data transaksi langsung menggunakan mass assignment
        Transaksi::create([
            'id_pelanggan' => $request->id_pelanggan,
            'no_plat_mobil' => $request->no_plat_mobil,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_pembayaran' => $request->total_pembayaran,
            'status' => $request->status,
            'id_akun' => Auth::user()->id_akun,
        ]);

        // Redirect ke halaman transaksi.index dengan pesan sukses
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan.');
    }
    public function edit($id)
    {
        // Ambil transaksi berdasarkan ID
        $transaksi = Transaksi::find($id);

        // Ambil pelanggan beserta mobil terkait, untuk mendapatkan jenis mobil
        $pelanggan = Pelanggan::with('mobil')->get();

        // Kirim data ke view
        return view('transaksi.edit', compact('transaksi', 'pelanggan'));
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
