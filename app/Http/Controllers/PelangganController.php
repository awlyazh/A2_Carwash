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
        // Ambil data harga dan mobil yang sudah ada
        $harga = Harga::all();
        $mobil = Mobil::all();

        return view('pelanggan.create', compact('harga', 'mobil'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|digits_between:10,15|numeric',
            'no_plat_mobil' => 'required|string|max:50|unique:mobil,no_plat_mobil',
            'nama_mobil' => 'nullable|string|max:100',
            'jenis_mobil' => 'required|exists:harga,jenis_mobil',
        ]);

        // Buat data pelanggan baru
        $pelanggan = Pelanggan::create([
            'nama' => $request->input('nama'),
            'no_hp' => $request->input('no_hp'),
        ]);

        // Cek apakah user memilih input manual untuk nama mobil
        if ($request->input('nama_mobil') == 'manual') {
            // Validasi nama mobil manual
            $request->validate([
                'manual_nama_mobil' => 'required|string|max:100|unique:mobil,nama_mobil',
            ]);

            // Simpan nama mobil manual ke tabel mobil
            $mobil = Mobil::create([
                'no_plat_mobil' => $request->input('no_plat_mobil'),
                'nama_mobil' => $request->input('manual_nama_mobil'),
                'jenis_mobil' => $request->input('jenis_mobil'),
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'id_harga' => Harga::where('jenis_mobil', $request->input('jenis_mobil'))->value('id_harga'),
            ]);
        } else {
            // Gunakan nama mobil yang dipilih dari dropdown
            $mobil = Mobil::create([
                'no_plat_mobil' => $request->input('no_plat_mobil'),
                'nama_mobil' => $request->input('nama_mobil'),
                'jenis_mobil' => $request->input('jenis_mobil'),
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'id_harga' => Harga::where('jenis_mobil', $request->input('jenis_mobil'))->value('id_harga'),
            ]);
        }

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan dan mobil berhasil ditambahkan.');
    }

    public function edit($id)
{
    $pelanggan = Pelanggan::with('mobil')->findOrFail($id); // Ambil data pelanggan beserta mobil terkait
    $harga = Harga::all(); // Ambil data harga
    $jenis_mobil = ['kecil' => 'Mobil Kecil', 'besar' => 'Mobil Besar']; // Pilihan jenis mobil
    $mobil = Mobil::all(); // Ambil semua data mobil untuk dropdown

    return view('pelanggan.edit', compact('pelanggan', 'harga', 'jenis_mobil', 'mobil'));
}

        

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:100',
        'no_hp' => 'required|digits_between:10,15|numeric',
        'no_plat_mobil' => 'required|string|max:50',
        'nama_mobil' => 'required|string|max:100',
        'jenis_mobil' => 'required|in:kecil,besar',
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
