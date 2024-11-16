<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Mobil;
use App\Models\MasterNamaMobils;
use App\Models\Harga;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::join('mobil', 'pelanggan.id_pelanggan', '=', 'mobil.id_pelanggan')
            ->leftJoin('harga', 'mobil.id_harga', '=', 'harga.id_harga')
            ->select('pelanggan.*', 'mobil.no_plat_mobil', 'mobil.nama_mobil', 'mobil.jenis_mobil', 'harga.harga')
            ->get();

        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        $masterNamaMobils = MasterNamaMobils::all();
        $harga = Harga::all(); 

        return view('pelanggan.create', compact('masterNamaMobils', 'harga'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|digits_between:10,15|numeric',
            'no_plat_mobil' => 'required|string|max:50|unique:mobil,no_plat_mobil',
            'nama_mobil' => 'required|string|max:100',
            'jenis_mobil' => 'required|string|max:100',
            'new_car_name' => 'nullable|string|max:100',
        ]);
    
        $namaMobil = $request->input('nama_mobil') === "Tambah Mobil Baru" 
            ? $request->input('new_car_name') 
            : $request->input('nama_mobil');
    
        if ($request->input('nama_mobil') === "Tambah Mobil Baru" && empty($request->input('new_car_name'))) {
            return redirect()->back()->withErrors(['new_car_name' => 'Nama mobil baru harus diisi jika memilih "Tambah Mobil Baru".']);
        }
    
        $jenisMobil = $request->input('jenis_mobil');
        $hargaData = Harga::where('jenis_mobil', $jenisMobil)->first(); 
    
        if (!$hargaData) {
            return redirect()->back()->withErrors(['jenis_mobil' => 'Jenis mobil tidak ditemukan dalam daftar harga.']);
        }
    
        $idHarga = $hargaData->id_harga; 
    
        $existingMobil = Mobil::where('no_plat_mobil', $request->input('no_plat_mobil'))
            ->where('id_harga', $idHarga)
            ->first();
    
        if ($existingMobil) {
            return redirect()->back()->withErrors(['no_plat_mobil' => 'Mobil dengan plat nomor ini dan harga yang sama sudah terdaftar.']);
        }
    
        $pelanggan = Pelanggan::create([
            'nama' => $request->input('nama'),
            'no_hp' => $request->input('no_hp'),
        ]);
    
        Mobil::create([
            'no_plat_mobil' => $request->input('no_plat_mobil'),
            'nama_mobil' => $namaMobil,
            'jenis_mobil' => $jenisMobil,
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'id_harga' => $idHarga,
        ]);
    
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan dan mobil berhasil ditambahkan.');
    }    

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $mobil = Mobil::where('id_pelanggan', $id)->first();
        $harga = Harga::all();
        $masterNamaMobils = MasterNamaMobils::all();

        return view('pelanggan.edit', compact('pelanggan', 'mobil', 'harga', 'masterNamaMobils'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|digits_between:10,15|numeric',
            'no_plat_mobil' => 'required|string|max:50',
            'nama_mobil' => 'required|string|max:100',
            'jenis_mobil' => 'required|string|max:100',
            'id_harga' => 'required|exists:harga,id_harga',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update([
            'nama' => $request->input('nama'),
            'no_hp' => $request->input('no_hp'),
        ]);

        $mobil = Mobil::where('id_pelanggan', $id)->first();
        $mobil->update([
            'no_plat_mobil' => $request->input('no_plat_mobil'),
            'nama_mobil' => $request->input('nama_mobil'),
            'jenis_mobil' => $request->input('jenis_mobil'),
            'id_harga' => $request->input('id_harga'),
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan dan mobil berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        Mobil::where('id_pelanggan', $id)->delete();
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }
}
