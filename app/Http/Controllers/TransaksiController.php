<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Mobil;
use App\Models\Akun;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    // Menampilkan daftar transaksi
    public function index()
    {
        $transaksi = Transaksi::with(['pelanggan', 'mobil', 'karyawan'])->get(); // Memuat pelanggan, mobil, dan karyawan terkait

        return view('transaksi.index', compact('transaksi'));
    }

    // Menampilkan form tambah transaksi
    public function create()
    {
        $pelanggan = Pelanggan::with('mobil')->get();
        $mobil = Mobil::all();
        $akun = Akun::all();
        $karyawan = Karyawan::all(); // Ambil data karyawan

        return view('transaksi.create', compact('pelanggan', 'mobil', 'akun', 'karyawan'));
    }

    // Menyimpan data transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'no_plat_mobil' => 'required|exists:mobil,no_plat_mobil',
            'tanggal_transaksi' => 'required|date',
            'metode_pembayaran' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'jumlah_mobil_dicuci' => 'required|integer|min:1',
            'jumlah_uang_dihasilkan' => 'required|numeric|min:0',
        ]);

        Transaksi::create([
            'id_pelanggan' => $request->id_pelanggan,
            'no_plat_mobil' => $request->no_plat_mobil,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_pembayaran' => $request->total_pembayaran,
            'status' => $request->status,
            'id_karyawan' => $request->id_karyawan,
            'id_akun' => Auth::user()->id_akun,
            'jumlah_mobil_dicuci' => $request->jumlah_mobil_dicuci,
            'jumlah_uang_dihasilkan' => $request->jumlah_uang_dihasilkan,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan.');
    }

    // Menampilkan form edit transaksi
    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id); // Pastikan data transaksi ada
        $pelanggan = Pelanggan::with('mobil')->get();
        $karyawan = Karyawan::all();

        return view('transaksi.edit', compact('transaksi', 'pelanggan', 'karyawan'));
    }

    // Memperbarui data transaksi
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id); // Pastikan data transaksi ada

        $request->validate([
            'no_plat_mobil' => 'required|exists:mobil,no_plat_mobil',
            'tanggal_transaksi' => 'required|date',
            'metode_pembayaran' => 'required|string|max:50',
            'total_pembayaran' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'jumlah_mobil_dicuci' => 'required|integer|min:1',
            'jumlah_uang_dihasilkan' => 'required|numeric|min:0',
        ]);

        $transaksi->update($request->all());

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    // Menghapus transaksi
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id); // Pastikan data transaksi ada
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
