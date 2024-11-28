<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harga;

class HargaController extends Controller
{
    // Menampilkan daftar harga
    public function index()
    {
        $harga = Harga::all(); // Mengambil semua data
        return view('harga.index', compact('harga'));
    }

    // Menampilkan form tambah harga
    public function create()
    {
        return view('harga.create');
    }

    // Menyimpan data harga baru
    public function store(Request $request)
    {
        $request->validate([
            'jenis_mobil' => 'required|unique:harga|max:50',
            'harga' => 'required|numeric|min:0',
        ]);

        Harga::create($request->all());
        return redirect()->route('harga.index')->with('success', 'Harga berhasil ditambahkan.');
    }

    // Menampilkan form edit harga
    public function edit($id)
    {
        $harga = Harga::findOrFail($id);
        return view('harga.edit', compact('harga'));
    }

    // Mengupdate data harga
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_mobil' => 'required|max:50|unique:harga,jenis_mobil,' . $id . ',id_harga',
            'harga' => 'required|numeric|min:0',
        ]);

        $harga = Harga::findOrFail($id);
        $harga->update($request->all());
        return redirect()->route('harga.index')->with('success', 'Harga berhasil diperbarui.');
    }

    // Menghapus data harga
    public function destroy($id)
    {
        $harga = Harga::findOrFail($id);
        $harga->delete();
        return redirect()->route('harga.index')->with('success', 'Harga berhasil dihapus.');
    }
}
