<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Mobil;
use App\Models\Harga;

class PelangganController extends Controller
{
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
            'mobil.jenis_mobil',
            'harga.harga'
        )
        ->get();

    return view('pelanggan.index', compact('pelanggan'));
}

public function create()
{
    $harga = Harga::all(); // Ambil semua harga
    $mobil = Mobil::select('nama_mobil')->distinct()->get(); // Ambil nama mobil yang ada

    return view('pelanggan.create', compact('harga', 'mobil'));
}
   

public function store(Request $request)
{
    // Validasi input umum
    $request->validate([
        'nama' => 'required|string|max:100',
        'no_hp' => 'required|digits_between:10,15|numeric',
        'no_plat_mobil' => 'required|string|max:50|unique:mobil,no_plat_mobil',
        'jenis_mobil' => 'required|exists:harga,jenis_mobil',
    ]);

    // Validasi khusus untuk nama mobil
    if ($request->input('nama_mobil') === 'add_new') {
        $request->validate([
            'nama_mobil_manual' => 'required|string|max:100|unique:mobil,nama_mobil',
        ]);
        $namaMobil = $request->input('nama_mobil_manual');
    } else {
        $request->validate([
            'nama_mobil' => 'required|string|exists:mobil,nama_mobil',
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
        'jenis_mobil' => $request->input('jenis_mobil'),
        'id_pelanggan' => $pelanggan->id_pelanggan,
        'id_harga' => Harga::where('jenis_mobil', $request->input('jenis_mobil'))->value('id_harga'),
    ]);

    return redirect()->route('pelanggan.index')->with('success', 'Pelanggan dan mobil berhasil ditambahkan.');
}


public function edit($id)
{
    $pelanggan = Pelanggan::findOrFail($id);
    $mobil = Mobil::all()->unique('nama_mobil'); // Menghapus duplikasi nama mobil
    $harga = Harga::all();

    return view('pelanggan.edit', compact('pelanggan', 'mobil', 'harga'));
}


public function update(Request $request, $id)
{
    // Validasi input
    $validated = $request->validate([
        'nama' => 'required|string|max:100',
        'no_hp' => 'required|digits_between:10,15|numeric',
        'no_plat_mobil' => 'required|string|max:50',
        'nama_mobil' => 'required|string|max:100',
        'jenis_mobil' => 'required|exists:harga,jenis_mobil',
    ]);

    // Update data pelanggan
    $pelanggan = Pelanggan::findOrFail($id);
    $pelanggan->update([
        'nama' => $validated['nama'],
        'no_hp' => $validated['no_hp'],
    ]);

    // Update data mobil terkait
    $mobil = Mobil::where('id_pelanggan', $pelanggan->id_pelanggan)->first();
    if ($mobil) {
        $mobil->update([
            'no_plat_mobil' => $validated['no_plat_mobil'],
            'nama_mobil' => $validated['nama_mobil'],
            'jenis_mobil' => $validated['jenis_mobil'],
            'id_harga' => Harga::where('jenis_mobil', $validated['jenis_mobil'])->value('id_harga'),
        ]);
    }

    return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
}




    public function destroy($id)
    {
        // Hapus data mobil dan pelanggan terkait
        $pelanggan = Pelanggan::findOrFail($id);
        $mobil = Mobil::where('id_pelanggan', $pelanggan->id_pelanggan)->first();

        // Hapus mobil terlebih dahulu
        $mobil->delete();
        // Hapus pelanggan
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan dan mobil berhasil dihapus.');
    }
}
