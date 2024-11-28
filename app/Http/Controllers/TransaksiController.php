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

        // Debug data sebelum mengirim ke view
        // dd(compact('pelanggan', 'mobil', 'akun', 'karyawan'));

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
        ]);

        // Ambil data mobil untuk mendapatkan harga berdasarkan plat nomor
        $mobil = Mobil::where('no_plat_mobil', $request->no_plat_mobil)->first();
        $hargaMobil = $mobil->harga->harga; // Ambil harga mobil sesuai dengan relasi harga

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'id_pelanggan' => $request->id_pelanggan,
            'no_plat_mobil' => $request->no_plat_mobil,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => $request->status,
            'id_karyawan' => $request->id_karyawan,
            'id_akun' => Auth::user()->id_akun,
        ]);

        // Perbarui data jumlah mobil dicuci dan jumlah uang dihasilkan di tabel Karyawan
        $karyawan = Karyawan::findOrFail($request->id_karyawan);

        $karyawan->jumlah_mobil_dicuci = ($karyawan->jumlah_mobil_dicuci ?? 0) + 1; // Tambah 1 mobil
        $karyawan->jumlah_uang_dihasilkan = ($karyawan->jumlah_uang_dihasilkan ?? 0) + $hargaMobil; // Tambah harga mobil

        $karyawan->save(); // Simpan perubahan ke database

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
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
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'no_plat_mobil' => 'required|exists:mobil,no_plat_mobil',
            'tanggal_transaksi' => 'required|date',
            'metode_pembayaran' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
        ]);

        // Ambil data mobil untuk mendapatkan harga
        $mobil = Mobil::where('no_plat_mobil', $request->no_plat_mobil)->first();
        $hargaMobil = $mobil->harga->harga; // Ambil harga mobil sesuai dengan relasi harga

        // Jika karyawan tidak berubah
        if ($transaksi->id_karyawan == $request->id_karyawan) {
            $transaksi->update([
                'id_pelanggan' => $request->id_pelanggan,
                'no_plat_mobil' => $request->no_plat_mobil,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => $request->status,
                'id_karyawan' => $request->id_karyawan,
            ]);
        } else {
            // Jika karyawan berubah
            $karyawanLama = Karyawan::findOrFail($transaksi->id_karyawan);
            $karyawanBaru = Karyawan::findOrFail($request->id_karyawan);

            // Kurangi data pada karyawan lama
            $karyawanLama->jumlah_mobil_dicuci = max(($karyawanLama->jumlah_mobil_dicuci ?? 0) - 1, 0);
            $karyawanLama->jumlah_uang_dihasilkan = max(($karyawanLama->jumlah_uang_dihasilkan ?? 0) - $hargaMobil, 0);
            $karyawanLama->save();

            // Tambahkan data pada karyawan baru
            $karyawanBaru->jumlah_mobil_dicuci = ($karyawanBaru->jumlah_mobil_dicuci ?? 0) + 1;
            $karyawanBaru->jumlah_uang_dihasilkan = ($karyawanBaru->jumlah_uang_dihasilkan ?? 0) + $hargaMobil;
            $karyawanBaru->save();

            // Update data transaksi
            $transaksi->update([
                'id_pelanggan' => $request->id_pelanggan,
                'no_plat_mobil' => $request->no_plat_mobil,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => $request->status,
                'id_karyawan' => $request->id_karyawan,
            ]);
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    // Menghapus transaksi
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id); // Pastikan data transaksi ada

        // Ambil data karyawan terkait
        $karyawan = Karyawan::findOrFail($transaksi->id_karyawan);

        // Ambil data mobil untuk mengurangi jumlah uang dihasilkan sesuai harga mobil
        $mobil = Mobil::where('no_plat_mobil', $transaksi->no_plat_mobil)->first();
        $hargaMobil = $mobil->harga->harga ?? 0;

        // Kurangi jumlah mobil dicuci dan jumlah uang dihasilkan
        $karyawan->jumlah_mobil_dicuci = max(($karyawan->jumlah_mobil_dicuci ?? 0) - 1, 0);
        $karyawan->jumlah_uang_dihasilkan = max(($karyawan->jumlah_uang_dihasilkan ?? 0) - $hargaMobil, 0);

        $karyawan->save(); // Simpan perubahan pada tabel karyawan

        $transaksi->delete(); // Hapus data transaksi

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
