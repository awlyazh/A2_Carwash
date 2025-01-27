<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Ubah dengan rute login sesuai kebutuhan
        }

        $user = Auth::user();

        // Cek apakah user memiliki salah satu dari role yang diberikan
        if (!$user || !in_array($user->posisi, $roles)) {
            abort(403); // Akses ditolak
        }

        return $next($request); // Melanjutkan ke middleware berikutnya
    }
}
