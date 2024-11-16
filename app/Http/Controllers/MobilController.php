<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;
use App\Models\MasterNamaMobils;

class MobilController extends Controller
{
    public function create()
{
    $masterNamaMobils = MasterNamaMobils::all(); 
    return view('mobil.create', compact('masterNamaMobils'));
    
    return view('pelanggan.create', compact('mobil'));
}

    public function store(Request $request)
{
    $request->validate([
        'nama_mobil' => 'required|string|max:255',
        'jenis_mobil' => 'required|string|max:255',
        'no_plat_mobil' => 'nullable|string|unique:mobils,no_plat_mobil',
    ]);

    Mobil::create([
        'nama_mobil' => $request->nama_mobil,
        'jenis_mobil' => $request->jenis_mobil,
        'no_plat_mobil' => $request->no_plat_mobil,
    ]);

    return response()->json(['success' => 'Mobil berhasil ditambahkan']);
}

}
