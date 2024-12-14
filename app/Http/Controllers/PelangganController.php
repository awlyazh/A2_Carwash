<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Mobil;
use App\Models\Harga;

class PelangganController extends Controller
{
    // Menampilkan daftar pelanggan
    public function index()
    {
        $pelanggan = Pelanggan::join('mobil', 'pelanggan.id_pelanggan', '=', 'mobil.id_pelanggan')
            ->leftJoin('harga', 'mobil.id_harga', '=', 'harga.id_harga')
            ->select(
                'pelanggan.id_pelanggan',
                'pelanggan.nama',
                'pelanggan.no_hp',
                'mobil.no_plat_mobil',
                'mobil.nama_mobil',
                'harga.jenis_mobil',
                'harga.harga'
            )
            ->get();

        return view('pelanggan.index', compact('pelanggan'));
    }

    // Menampilkan form tambah pelanggan
    public function create()
    {
        $harga = Harga::all(); // Ambil semua data harga
        $mobil = Mobil::select('nama_mobil')->distinct()->get(); // Ambil nama mobil yang unik

        return view('pelanggan.create', compact('harga', 'mobil'));
    }

    // Menyimpan data pelanggan baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|digits_between:10,15|numeric',
            'no_plat_mobil' => 'required|string|max:50|unique:mobil,no_plat_mobil',
            'jenis_mobil' => 'required|exists:harga,jenis_mobil',
        ]);

        // Menentukan nama mobil
        if ($request->input('nama_mobil') === 'add_new') {
            $request->validate([
                'nama_mobil_manual' => 'required|string|max:100|unique:mobil,nama_mobil',
            ]);
            $namaMobil = $request->input('nama_mobil_manual');
        } else {
            $request->validate([
                'nama_mobil' => 'required|string',
            ]);
            $namaMobil = $request->input('nama_mobil');
        }

        // Simpan data pelanggan
        $pelanggan = Pelanggan::create([
            'nama' => $request->input('nama'),
            'no_hp' => $request->input('no_hp'),
        ]);

        // Simpan data mobil
        Mobil::create([
            'no_plat_mobil' => $request->input('no_plat_mobil'),
            'nama_mobil' => $namaMobil,
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'id_harga' => Harga::where('jenis_mobil', $request->input('jenis_mobil'))->value('id_harga'),
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan dan mobil berhasil ditambahkan.');
    }

    // Menampilkan form edit pelanggan
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $mobil = Mobil::where('id_pelanggan', $id)->first();
        $harga = Harga::all();

        return view('pelanggan.edit', compact('pelanggan', 'mobil', 'harga'));
    }

    // Menyimpan perubahan data pelanggan
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|digits_between:10,15|numeric',
            'no_plat_mobil' => 'required|string|max:50',
            'nama_mobil' => 'required|string|max:100',
            'jenis_mobil' => 'required|exists:harga,jenis_mobil',
        ]);

        // Update data pelanggan
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update([
            'nama' => $request->input('nama'),
            'no_hp' => $request->input('no_hp'),
        ]);

        // Update data mobil terkait
        $mobil = Mobil::where('id_pelanggan', $pelanggan->id_pelanggan)->first();
        if ($mobil) {
            $mobil->update([
                'no_plat_mobil' => $request->input('no_plat_mobil'),
                'nama_mobil' => $request->input('nama_mobil'),
                'id_harga' => Harga::where('jenis_mobil', $request->input('jenis_mobil'))->value('id_harga'),
            ]);
        }

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan dan mobil berhasil diperbarui.');
    }

    // Menghapus data pelanggan dan mobil terkait
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        Mobil::where('id_pelanggan', $pelanggan->id_pelanggan)->delete(); // Hapus mobil terkait
        $pelanggan->delete(); // Hapus pelanggan

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan dan mobil berhasil dihapus.');
    }
}
