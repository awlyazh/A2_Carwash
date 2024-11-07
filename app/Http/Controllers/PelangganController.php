<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Mobil;

class PelangganController extends Controller
{
    public function index()
    {
        // Mengambil data pelanggan dan mobil terkait
        $pelanggan = Pelanggan::join('mobil', 'pelanggan.id_pelanggan', '=', 'mobil.id_pelanggan')
            ->select('pelanggan.*', 'mobil.no_plat_mobil', 'mobil.nama_mobil', 'mobil.jenis_mobil')
            ->get();

        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        // Menampilkan halaman untuk membuat pelanggan baru
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
            'new_car_name' => 'nullable|string|max:100', // Tambahkan validasi untuk nama mobil baru
        ]);

        // Cek apakah pengguna memilih "Tambah Mobil Baru"
        $namaMobil = $request->input('nama_mobil') === "Tambah Mobil Baru" ? $request->input('new_car_name') : $request->input('nama_mobil');

        if ($request->input('nama_mobil') === "Tambah Mobil Baru" && empty($request->input('new_car_name'))) {
            return redirect()->back()->withErrors(['new_car_name' => 'Nama mobil baru harus diisi jika memilih "Tambah Mobil Baru".']);
        }

        // Simpan data pelanggan
        $pelanggan = new Pelanggan();
        $pelanggan->nama = $request->input('nama');
        $pelanggan->no_hp = $request->input('no_hp');
        $pelanggan->save();

        // Simpan data mobil
        $mobil = new Mobil();
        $mobil->no_plat_mobil = $request->input('no_plat_mobil');
        $mobil->nama_mobil = $namaMobil; // Menggunakan nama mobil yang benar
        $mobil->jenis_mobil = $request->input('jenis_mobil');
        $mobil->id_pelanggan = $pelanggan->id_pelanggan; // Menggunakan id pelanggan yang baru disimpan
        $mobil->save();

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan dan mobil berhasil disimpan');
    }

    public function edit($id)
    {
        // Ambil data pelanggan beserta mobil terkait berdasarkan ID
        $pelanggan = Pelanggan::join('mobil', 'pelanggan.id_pelanggan', '=', 'mobil.id_pelanggan')
            ->select('pelanggan.*', 'mobil.no_plat_mobil', 'mobil.nama_mobil', 'mobil.jenis_mobil')
            ->where('pelanggan.id_pelanggan', '=', $id)
            ->firstOrFail();

        // Menampilkan halaman edit
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|numeric',
            'no_plat_mobil' => 'required|string|max:50',
            'nama_mobil' => 'required|string',
            'jenis_mobil' => 'required|string',
        ]);

        // Ambil data pelanggan berdasarkan ID
        $pelanggan = Pelanggan::findOrFail($id);

        // Update data pelanggan
        $pelanggan->update([
            'nama' => $validatedData['nama'],
            'no_hp' => $validatedData['no_hp'],
        ]);

        // Temukan data mobil yang terkait dengan pelanggan
        $mobil = Mobil::where('id_pelanggan', $id)->first();

        if ($mobil) {
            // Perbarui data mobil
            $mobil->update([
                'no_plat_mobil' => $validatedData['no_plat_mobil'],
                'nama_mobil' => $validatedData['nama_mobil'],
                'jenis_mobil' => $validatedData['jenis_mobil'],
            ]);
        } else {
            return redirect()->back()->withErrors('Mobil terkait tidak ditemukan.');
        }

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan dan mobil berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Hapus pelanggan dan mobil terkait
        $pelanggan = Pelanggan::find($id);
        if ($pelanggan) {
            $pelanggan->delete();

            // Hapus mobil terkait
            $mobil = Mobil::where('id_pelanggan', $id)->first();
            if ($mobil) {
                $mobil->delete();
            } else {
                return redirect()->back()->withErrors('Mobil tidak ditemukan untuk pelanggan ini.');
            }

            return redirect()->route('pelanggan.index')->with('success', 'Pelanggan dan mobil berhasil dihapus.');
        }

        return redirect()->back()->withErrors('Pelanggan tidak ditemukan.');
    }
}
