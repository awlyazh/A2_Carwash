<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;

class KaryawanController extends Controller
{
    // Menampilkan daftar karyawan
    public function index()
{
    $karyawan = Karyawan::all();
    return view('karyawan.index', compact('karyawan'));
}

    // Menampilkan form tambah karyawan
    public function create()
    {
        return view('karyawan.create');
    }

    // Menyimpan data karyawan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_karyawan' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15|regex:/^[0-9\s]+$/',
        ]);

        Karyawan::create([
            'nama_karyawan' => $request->nama_karyawan,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    // Menampilkan form edit karyawan
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id); // Pastikan karyawan ada
        return view('karyawan.edit', compact('karyawan'));
    }

    // Memperbarui data karyawan
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'nama_karyawan' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15|regex:/^[0-9\s]+$/',
        ]);

        $karyawan->update([
            'nama_karyawan' => $request->nama_karyawan,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    // Menghapus data karyawan
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
