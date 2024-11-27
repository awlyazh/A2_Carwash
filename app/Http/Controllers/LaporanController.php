<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function cetak($tanggal_awal, $tanggal_akhir)
    {
        // Ambil data transaksi dengan mobil dan harga terkait
        $cetak = Transaksi::with(['pelanggan', 'mobil.harga'])
            ->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])
            ->get();

        dd($cetak);

        // Kirim data ke view
        return view('laporan.cetak', compact('cetak'));
    }
}
