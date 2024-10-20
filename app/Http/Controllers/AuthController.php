<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');  // Mengarahkan ke view login
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input login (bisa username atau email) dan password
        $credentials = $request->validate([
            'login' => ['required', 'string'],   // Input login bisa username atau email
            'password' => ['required', 'string'], // Password wajib ada
        ]);

        // Cek apakah input login adalah email atau username
        $loginField = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Ambil user berdasarkan username atau email
        $user = Akun::where($loginField, $request->input('login'))->first();

        // Cek apakah user ditemukan dan password sesuai
        if ($user) {
            if (Hash::check($request->input('password'), $user->password)) {
                // Login menggunakan Auth
                Auth::login($user);
                $request->session()->regenerate();

                // Periksa role (posisi) dan arahkan sesuai role
                if ($user->posisi === 'admin') {
                    return redirect()->intended('/dashboard');
                } elseif ($user->posisi === 'karyawan') {
                    return redirect()->intended('/dashboard');
                }
            } else {
                // Jika password salah
                return back()->withErrors([
                    'password' => 'Password yang dimasukkan salah.',
                ])->withInput();
            }
        } else {
            // Jika username/email tidak ditemukan
            return back()->withErrors([
                'login' => ucfirst($loginField) . ' tidak ditemukan.',
            ])->withInput();
        }
    }

    // Fungsi logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
