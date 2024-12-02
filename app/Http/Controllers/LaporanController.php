<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi; // Model Transaksi
use Barryvdh\DomPDF\Facade\Pdf; // DomPDF facade

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman index laporan.
     */
    public function index()
    {
        $transaksi = Transaksi::with(['pelanggan', 'mobil', 'karyawan'])->get(); // Memuat pelanggan, mobil, dan karyawan terkait

        return view('laporan.index',  compact('transaksi'));
    }

    /**
     * Menampilkan halaman cetak laporan transaksi.
     */
    public function cetak($tanggal_awal, $tanggal_akhir)
    {
        $posts = Transaksi::with(['pelanggan', 'mobil.harga'])
            ->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])
            ->get();

        return view('laporan.cetak', compact('posts', 'tanggal_awal', 'tanggal_akhir'));
    }

    /**
     * Mengunduh laporan transaksi dalam format PDF.
     */
    public function download($tanggal_awal, $tanggal_akhir)
    {
        $posts = Transaksi::with(['pelanggan', 'mobil.harga'])
            ->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])
            ->get();

        $pdf = Pdf::loadView('laporan.download', compact('posts', 'tanggal_awal', 'tanggal_akhir'));

        return $pdf->download('laporan-transaksi.pdf');
        
    }
}
