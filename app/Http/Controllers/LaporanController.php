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
        $cetak = Transaksi::all()->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir]);
        return view('laporan.cetak', compact('cetak'));
    }
}
