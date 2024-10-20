<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah total pelanggan
        $totalPelanggan = Pelanggan::count();

        // Menghitung jumlah pelanggan baru dalam seminggu terakhir
        $pelangganBaru = Pelanggan::where('created_at', '>=', Carbon::now()->subWeek())->count();

        // Data lainnya bisa ditambahkan sesuai kebutuhan
        // Misalnya, pelanggan yang terakhir update
        $pelangganTerbaru = Pelanggan::latest()->take(5)->get();

        return view('dashboard.index', [
            'totalPelanggan' => $totalPelanggan,
            'pelangganBaru' => $pelangganBaru,
            'pelangganTerbaru' => $pelangganTerbaru
        ]);
    }
}
