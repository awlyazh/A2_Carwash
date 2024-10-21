<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Mobil;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::join('mobil', 'pelanggan.id_pelanggan', '=', 'mobil.id_pelanggan')->get();

        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|digits_between:10,15|numeric',
            'no_plat_mobil' => 'required|string|max:50',
            'nama_mobil' => 'required|string|max:100',
            'jenis_mobil' => 'required|string|max:100',
        ]);

        // Simpan data ke database
        $pelanggan = new Pelanggan();
        $pelanggan->nama = $request->input('nama');
        $pelanggan->no_hp = $request->input('no_hp');
        $pelanggan->save();

        $idPelanggan = $pelanggan->id_pelanggan;

        $mobil = new Mobil();
        $mobil->no_plat_mobil = $request->input('no_plat_mobil');
        $mobil->nama_mobil = $request->input('nama_mobil');
        $mobil->jenis_mobil = $request->input('jenis_mobil');
        $mobil->id_pelanggan = $idPelanggan;
        $mobil->save();

        return redirect()->to('pelanggan');
    }

    // Menampilkan form edit pelanggan
    public function edit($id)
    {
        $pelanggan = Pelanggan::join('mobil', 'pelanggan.id_pelanggan', '=', 'mobil.id_pelanggan')
            ->select('pelanggan.*', 'mobil.no_plat_mobil', 'mobil.nama_mobil', 'mobil.jenis_mobil')
            ->where('pelanggan.id_pelanggan', '=', $id)
            ->firstOrFail();

        return view('pelanggan.edit', compact('pelanggan'));
    }

    // Memperbarui data pelanggan dan mobil yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|digits_between:10,15|numeric',
            'no_plat_mobil' => 'required|string|max:50',
            'nama_mobil' => 'required|string|max:100',
            'jenis_mobil' => 'required|string|max:100',
        ]);

        // Update data pelanggan
        $pelanggan = Pelanggan::where('id_pelanggan', '=', $id)->first();
        $pelanggan->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        // Update data mobil
        $mobil = Mobil::where('id_pelanggan', '=', $id)->first();
        $mobil->update([
            'no_plat_mobil' => $request->no_plat_mobil,
            'nama_mobil' => $request->nama_mobil,
            'jenis_mobil' => $request->jenis_mobil,
        ]);

        return redirect()->to('pelanggan')->with('success', 'Data pelanggan dan mobil berhasil diperbarui.');
    }

    // Menghapus pelanggan dan mobil
    public function destroy($id)
    {
        // Hapus pelanggan
        $pelanggan = Pelanggan::where('id_pelanggan', '=', $id)->first();
        $pelanggan->delete();

        // Hapus mobil terkait
        $mobil = Mobil::where('id_pelanggan', '=', $id)->first();
        $mobil->delete();

        return redirect()->to('pelanggan')->with('success', 'Pelanggan dan mobil berhasil dihapus.');
    }
}
