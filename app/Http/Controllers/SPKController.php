<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Spk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SPKController extends Controller
{
    public function index(Request $request)
    {
        $bobotAHP = session('bobot_ahp') ?? null;

        // Ambil input tanggal awal dan akhir dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Ambil data karyawan beserta transaksi yang difilter berdasarkan tanggal
        $karyawan = Karyawan::with(['transaksi' => function ($query) use ($startDate, $endDate) {
            if ($startDate && $endDate) {
                $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
            }
        }])->get();

        return view('spk.index', compact('bobotAHP', 'startDate', 'endDate', 'karyawan'));
    }

    // Fungsi untuk menghitung AHP
    public function hitungAHP(Request $request)
    {
        $nilai_1_2 = $request->input('nilai_1_2');

        // Matriks perbandingan
        $matriksPerbandingan = [
            [1, $nilai_1_2],
            [1 / $nilai_1_2, 1],
        ];

        // Langkah 1: Normalisasi Matriks
        $jumlahKolom = array_map(fn($col) => array_sum(array_column($matriksPerbandingan, $col)), array_keys($matriksPerbandingan[0]));
        $matriksNormalisasi = array_map(
            fn($row) => array_map(fn($value, $colIndex) => $value / $jumlahKolom[$colIndex], $row, array_keys($row)),
            $matriksPerbandingan
        );

        // Langkah 2: Hitung Bobot Kriteria
        $bobotAHP = array_map(fn($row) => array_sum($row) / count($row), $matriksNormalisasi);

        // Simpan hasil ke session
        session([
            'bobot_ahp' => $bobotAHP,
            'matriks_normalisasi' => $matriksNormalisasi,
        ]);

        return response()->json([
            'status' => 'success',
            'matriks' => $matriksPerbandingan,
            'bobot' => $bobotAHP,
        ]);
    }

    // Fungsi untuk menghitung SAW
    public function hitungSAW(Request $request)
    {
        $bobotAHP = session('bobot_ahp');
        if (!$bobotAHP) {
            return redirect()->route('spk.index')->with('error', 'Hitung bobot AHP terlebih dahulu.');
        }

        // Ambil input tanggal awal dan akhir
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validasi keberadaan tanggal
        if (!$startDate || !$endDate) {
            return redirect()->route('spk.index')->with('error', 'Tanggal awal dan akhir harus diisi.');
        }

        // Ambil data karyawan beserta transaksi berdasarkan rentang tanggal
        $karyawan = Karyawan::with(['transaksi' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }])->get();

        $hasil = [];
        $maxMobilDicuci = 0;
        $maxUangDihasilkan = 0;

        // Hitung total mobil dicuci dan uang dihasilkan
        foreach ($karyawan as $k) {
            $totalMobilDicuci = $k->transaksi->count();
            $totalUangDihasilkan = $k->transaksi->sum(fn($t) => $t->mobil->harga->harga ?? 0);

            $maxMobilDicuci = max($maxMobilDicuci, $totalMobilDicuci);
            $maxUangDihasilkan = max($maxUangDihasilkan, $totalUangDihasilkan);

            $k->totalMobilDicuci = $totalMobilDicuci;
            $k->totalUangDihasilkan = $totalUangDihasilkan;
        }

        // Normalisasi dan hitung skor
        foreach ($karyawan as $k) {
            $normalisasiMobilDicuci = $maxMobilDicuci ? $k->totalMobilDicuci / $maxMobilDicuci : 0;
            $normalisasiUangDihasilkan = $maxUangDihasilkan ? $k->totalUangDihasilkan / $maxUangDihasilkan : 0;

            $skor = ($normalisasiMobilDicuci * $bobotAHP[0]) + ($normalisasiUangDihasilkan * $bobotAHP[1]);

            $hasil[] = [
                'id_karyawan' => $k->id_karyawan, // Tambahkan id_karyawan
                'karyawan' => $k->nama_karyawan,
                'jumlah_mobil_dicuci' => $k->totalMobilDicuci,
                'jumlah_uang_dihasilkan' => $k->totalUangDihasilkan,
                'skor' => $skor,
            ];
        }

        // Urutkan hasil berdasarkan skor
        usort($hasil, fn($a, $b) => $b['skor'] <=> $a['skor']);

        return view('spk.hasil', compact('hasil', 'startDate', 'endDate'));
    }
    public function simpanHasil(Request $request)
    {
        $hasil = json_decode($request->input('hasil'), true); // Decode JSON menjadi array
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (!$hasil || !$startDate || !$endDate) {
            return redirect()->route('spk.index')->with('error', 'Data hasil atau rentang tanggal tidak lengkap.');
        }

        foreach ($hasil as $peringkat => $item) {
            if (!isset($item['id_karyawan']) || is_null($item['id_karyawan'])) {
                return redirect()->route('spk.index')->with('error', 'Data karyawan tidak lengkap.');
            }

            Spk::create([
                'id_karyawan' => $item['id_karyawan'],
                'jumlah_mobil_dicuci' => $item['jumlah_mobil_dicuci'] ?? 0,
                'jumlah_uang_dihasilkan' => $item['jumlah_uang_dihasilkan'] ?? 0,
                'skor' => $item['skor'] ?? 0,
                'peringkat' => $peringkat + 1,
                'tanggal_periode_start' => $startDate,
                'tanggal_periode_end' => $endDate,
            ]);
        }

        return redirect()->route('spk.index')->with('success', 'Hasil SPK berhasil disimpan!');
    }

    public function cetakSPK(Request $request)
    {
        $bobotAHP = session('bobot_ahp');
        if (!$bobotAHP) {
            return redirect()->route('spk.index')->with('error', 'Hitung bobot AHP terlebih dahulu.');
        }

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $karyawan = Karyawan::with(['transaksi' => function ($query) use ($startDate, $endDate) {
            if ($startDate && $endDate) {
                $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
            }
        }])->get();

        $hasil = [];
        $maxMobilDicuci = 0;
        $maxUangDihasilkan = 0;

        foreach ($karyawan as $k) {
            $totalMobilDicuci = $k->transaksi->count();
            $totalUangDihasilkan = $k->transaksi->sum(fn($t) => $t->mobil->harga->harga ?? 0);

            $maxMobilDicuci = max($maxMobilDicuci, $totalMobilDicuci);
            $maxUangDihasilkan = max($maxUangDihasilkan, $totalUangDihasilkan);

            $k->totalMobilDicuci = $totalMobilDicuci;
            $k->totalUangDihasilkan = $totalUangDihasilkan;
        }

        foreach ($karyawan as $k) {
            $normalisasiMobilDicuci = $maxMobilDicuci ? $k->totalMobilDicuci / $maxMobilDicuci : 0;
            $normalisasiUangDihasilkan = $maxUangDihasilkan ? $k->totalUangDihasilkan / $maxUangDihasilkan : 0;

            $skor = ($normalisasiMobilDicuci * $bobotAHP[0]) + ($normalisasiUangDihasilkan * $bobotAHP[1]);

            $hasil[] = [
                'karyawan' => $k->nama_karyawan,
                'jumlah_mobil_dicuci' => $k->totalMobilDicuci,
                'jumlah_uang_dihasilkan' => $k->totalUangDihasilkan,
                'skor' => $skor,
            ];
        }

        usort($hasil, fn($a, $b) => $b['skor'] <=> $a['skor']);

        $pdf = Pdf::loadView('spk.pdf', compact('hasil', 'startDate', 'endDate'));
        return $pdf->download('laporan_spk.pdf');
    }

    public function laporanSPK(Request $request)
    {
        // Ambil filter tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Ambil hanya data dengan peringkat tertinggi (peringkat 1)
        $laporanSPK = Spk::with('karyawan')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->where('tanggal_periode_start', $startDate)
                    ->where('tanggal_periode_end', $endDate);
            })
            ->where('peringkat', 1) // Hanya peringkat tertinggi
            ->paginate(10);
    
        return view('spk.laporan', compact('laporanSPK', 'startDate', 'endDate'));
    }    

    public function hapusSPK(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Validasi input
        if (!$startDate || !$endDate) {
            return redirect()->route('spk.laporan')->with('error', 'Tanggal periode harus diisi.');
        }
    
        // Hapus data berdasarkan periode
        Spk::where('tanggal_periode_start', $startDate)
            ->where('tanggal_periode_end', $endDate)
            ->delete();
    
        return redirect()->route('spk.laporan')->with('success', 'Data SPK untuk periode ini berhasil dihapus.');
    }    

    public function lihatPDF(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
    
        // Validasi input
        if (!$startDate || !$endDate) {
            return redirect()->route('spk.laporan')->with('error', 'Tanggal periode harus diisi.');
        }
    
        // Ambil semua data dengan periode yang sama
        $laporanSPK = Spk::with('karyawan')
            ->where('tanggal_periode_start', $startDate)
            ->where('tanggal_periode_end', $endDate)
            ->orderBy('peringkat', 'asc') // Urutkan berdasarkan peringkat
            ->get();
    
        // Generate PDF
        $pdf = Pdf::loadView('spk.laporanpdf', compact('laporanSPK', 'startDate', 'endDate'));
        return $pdf->stream('laporan_spk.pdf');
    }
    
}
