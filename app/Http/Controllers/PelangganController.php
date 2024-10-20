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
        return view('pelanggan.create',);
    }

    public function store(Request $request)
    {
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
    // Memperbarui data transaksi yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'no_plat_mobil' => 'required|max:50',
            'nama_mobil' => 'required',
            'jenis_mobil' => 'required',
        ]);

        $tablePelanggan = [
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ];

        $tableMobil = [
            'no_plat_mobil' => $request->no_plat_mobil,
            'nama_mobil' => $request->nama_mobil,
            'jenis_mobil' => $request->jenis_mobil,
        ];

        $pelanggan = Pelanggan::where('pelanggan.id_pelanggan', '=', $id);
        $pelanggan->update($tablePelanggan);

        $mobil = mobil::where('mobil.id_pelanggan', '=', $id);
        $mobil->update($tableMobil);

        return redirect()->to('pelanggan')->with('success', 'Transaksi berhasil diperbarui.');
    }

    // Menghapus transaksi
    public function destroy($id)
    {
        $pelanggan = Pelanggan::where('pelanggan.id_pelanggan', '=', $id);
        $pelanggan->delete();

        return redirect()->to('pelanggan')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
