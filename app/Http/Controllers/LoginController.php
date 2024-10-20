<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');  // Mengarahkan ke view login
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input hanya username/email dan password
        $credentials = $request->validate([
            'username' => ['required_without:email', 'string'], // Username harus ada atau email
            'email' => ['required_without:username', 'email'],  // Email harus ada jika username tidak ada
            'password' => ['required', 'string'],               // Password wajib ada
        ]);

        // Cek apakah login menggunakan username atau email
        $loginField = filter_var($request->input('username') ?: $request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Ambil user berdasarkan username atau email
        $user = Akun::where($loginField, $request->input($loginField))->first();

        // Cek apakah user ditemukan dan password sesuai
        if ($user && Hash::check($request->input('password'), $user->password)) {
            // Login menggunakan Auth
            Auth::login($user);
            $request->session()->regenerate();

            // Periksa role (posisi) dan arahkan sesuai role
            if ($user->posisi === 'admin') {
                return redirect()->intended('/dashboard');
            } elseif ($user->posisi === 'karyawan') {
                return redirect()->intended('/dashboard');
            }
        }

        // Jika login gagal
        return back()->withErrors([
            'login' => 'Username atau password salah.',
        ]);
    }

    // Fungsi logout
    public function logout(Request $request)
    {
        // Proses logout user
        Auth::logout();

        // Invalidate session dan regenerate token untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login
        return redirect('/login');
    }
}
