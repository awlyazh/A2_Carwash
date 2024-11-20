<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;

class MobilController extends Controller
{
    public function create()
{
    return view('mobil.create', compact('Mobil'));
}

    public function store(Request $request)
{
    $request->validate([
        'nama_mobil' => 'required|string|max:255',
        'jenis_mobil' => 'required|string|max:255',
        'no_plat_mobil' => 'nullable|string|unique:mobils,no_plat_mobil',
        'id_harga' => 'required|exists:harga,id_harga',
    ]);

    Mobil::create([
        'nama_mobil' => $request->nama_mobil,
        'jenis_mobil' => $request->jenis_mobil,
        'no_plat_mobil' => $request->no_plat_mobil,
        'id_harga' => $request->id_harga,
    ]);

    return response()->json(['success' => 'Mobil berhasil ditambahkan']);
}
    public function mobil()
    {
        return $this->hasMany(Mobil::class, 'id_pelanggan');
    }

}