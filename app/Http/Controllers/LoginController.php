<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');  // Arahkan ke view login
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'email' => ['required', 'email'],
            'position' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');  // Arahkan setelah login berhasil
        }

        return back()->withErrors([
            'email' => 'Kredensial yang Anda berikan tidak cocok dengan data kami.',
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();

        // Hapus session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login atau halaman lain
        return redirect('/login');
    }

    public function verifikasi(Request $request)
{
    // Validasi input
    $request->validate([
        'username' => ['required'],
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Ambil semua data user dari tabel users
    $users = \App\Models\Akun::all();

    // Cek apakah ada user dengan username dan email yang cocok
    foreach ($users as $user) {
        if ($user->username === $request->input('username') && $user->email === $request->input('email')) {
            // Jika username dan email cocok, cek apakah password cocok (tanpa hashing)
            if ($user->password === $request->input('password')) {
                // Jika password cocok, login manual
                $request->session()->put('user_id', $user->id); // Simpan ID user di session
                $request->session()->regenerate();

                return redirect()->intended('dashboard'); // Arahkan setelah login berhasil
            } else {
                // Password salah
                return back()->withErrors([
                    'password' => 'Password yang Anda masukkan salah.',
                ]);
            }
        }
    }

    // Jika tidak ditemukan user yang cocok
    return back()->withErrors([
        'email' => 'Kredensial yang Anda berikan tidak cocok dengan data kami.',
    ]);
}

    
}