<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class, // Jika kamu memiliki middleware Authenticate
        'role' => \App\Http\Middleware\RoleMiddleware::class, // Middleware Role yang baru
    ];
    protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $jadwalBesok = Jadwal::whereDate('tanggal', now()->addDay()->toDateString())->get();

        foreach ($jadwalBesok as $jadwal) {
            $message = "Halo, {$jadwal->pelanggan->name}, jadwal pencucian mobil Anda adalah besok. Mohon datang tepat waktu.";
            $fontee = new \App\Http\Controllers\FonteeController();
            $fontee->sendMessage($jadwal->pelanggan->phone, $message);
        }
    })->dailyAt('18:00'); // Kirim pesan setiap pukul 18:00
}

}
