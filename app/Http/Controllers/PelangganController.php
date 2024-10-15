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
}
