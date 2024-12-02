<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // DomPDF facade

class SPKController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $karyawan = Karyawan::all();

        foreach ($karyawan as $k) {
            $transaksiKaryawan = Transaksi::where('id_karyawan', $k->id_karyawan)
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    return $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
                })
                ->get();

            $k->jumlah_mobil_dicuci = $transaksiKaryawan->count();
            $k->jumlah_uang_dihasilkan = $transaksiKaryawan->sum(function ($transaksi) {
                return $transaksi->mobil->harga->harga ?? 0;
            });
        }

        // Ambil bobot AHP dari session jika ada
        $hasilAHP = session('bobot_kriteria') ?? null;

        return view('spk.index', compact('karyawan', 'startDate', 'endDate', 'hasilAHP'));
    }

    public function hitungAHP(Request $request)
    {
        // Matriks perbandingan kriteria
        $matriksPerbandingan = [
            [1, 2],
            [0.5, 1],
        ];

        $jumlahKolom = array_map(fn($col) => array_sum(array_column($matriksPerbandingan, $col)), array_keys($matriksPerbandingan[0]));
        $matriksNormalisasi = array_map(
            fn($row) => array_map(fn($value, $colIndex) => $value / $jumlahKolom[$colIndex], $row, array_keys($row)),
            $matriksPerbandingan
        );
        $bobotPrioritas = array_map(fn($row) => array_sum($row) / count($row), $matriksNormalisasi);

        // Simpan bobot kriteria di session
        session(['bobot_kriteria' => $bobotPrioritas]);

        // Respons JSON untuk AJAX
        return response()->json([
            'status' => 'success',
            'bobot' => $bobotPrioritas,
        ]);
    }

    public function hitungSAW(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $bobotKriteria = session('bobot_kriteria');

        if (!$bobotKriteria) {
            return redirect()->route('spk.index', compact('startDate', 'endDate'))->with('error', 'Silakan lakukan perhitungan AHP terlebih dahulu.');
        }

        $karyawan = Karyawan::all();
        $hasil = [];

        $maxMobilDicuci = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->groupBy('id_karyawan')
            ->selectRaw('COUNT(id_transaksi) as total_mobil_dicuci')
            ->pluck('total_mobil_dicuci')
            ->max();

        $maxUangDihasilkan = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->get()
            ->sum(fn($transaksi) => $transaksi->mobil->harga->harga ?? 0);

        foreach ($karyawan as $k) {
            $transaksiKaryawan = Transaksi::where('id_karyawan', $k->id_karyawan)
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->get();

            $totalMobilDicuci = $transaksiKaryawan->count();
            $totalUangDihasilkan = $transaksiKaryawan->sum(function ($transaksi) {
                return $transaksi->mobil->harga->harga ?? 0;
            });

            $normalisasiMobilDicuci = $maxMobilDicuci ? $totalMobilDicuci / $maxMobilDicuci : 0;
            $normalisasiUangDihasilkan = $maxUangDihasilkan ? $totalUangDihasilkan / $maxUangDihasilkan : 0;

            $skor = ($normalisasiMobilDicuci * $bobotKriteria[0]) + ($normalisasiUangDihasilkan * $bobotKriteria[1]);

            // dd(compact('normalisasiMobilDicuci', 'normalisasiUangDihasilkan', 'skor'));

            $hasil[] = [
                'karyawan' => $k,
                'total_mobil_dicuci' => $totalMobilDicuci,
                'total_uang_dihasilkan' => $totalUangDihasilkan,
                'skor' => $skor,
            ];
        }

        usort($hasil, fn($a, $b) => $b['skor'] <=> $a['skor']);

        return view('spk.hasil', compact('hasil', 'startDate', 'endDate'));
    }

    public function cetakSPK(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $bobotKriteria = session('bobot_kriteria');
    
        $karyawan = Karyawan::all();
        $hasil = [];
    
        $maxMobilDicuci = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->groupBy('id_karyawan')
            ->selectRaw('COUNT(id_transaksi) as total_mobil_dicuci')
            ->pluck('total_mobil_dicuci')
            ->max();
    
        $maxUangDihasilkan = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->get()
            ->sum(fn($transaksi) => $transaksi->mobil->harga->harga ?? 0);
    
        foreach ($karyawan as $k) {
            $transaksiKaryawan = Transaksi::where('id_karyawan', $k->id_karyawan)
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->get();
    
            $totalMobilDicuci = $transaksiKaryawan->count();
            $totalUangDihasilkan = $transaksiKaryawan->sum(function ($transaksi) {
                return $transaksi->mobil->harga->harga ?? 0;
            });
    
            $normalisasiMobilDicuci = $maxMobilDicuci ? $totalMobilDicuci / $maxMobilDicuci : 0;
            $normalisasiUangDihasilkan = $maxUangDihasilkan ? $totalUangDihasilkan / $maxUangDihasilkan : 0;
    
            $skor = ($normalisasiMobilDicuci * $bobotKriteria[0]) + ($normalisasiUangDihasilkan * $bobotKriteria[1]);
    
            $hasil[] = [
                'karyawan' => $k,
                'total_mobil_dicuci' => $totalMobilDicuci,
                'total_uang_dihasilkan' => $totalUangDihasilkan,
                'skor' => $skor,
            ];
        }
    
        usort($hasil, fn($a, $b) => $b['skor'] <=> $a['skor']); // Urutkan berdasarkan skor
    
        $pdf = Pdf::loadView('spk.laporan', compact('hasil', 'startDate', 'endDate'));
        return $pdf->stream('laporan_spk.pdf');
    }
    
}
