<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Menampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register'); // Path tetap di dalam folder views/auth
    }

    // Menangani proses register
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|unique:akun,username|max:50',
            'email' => 'required|email|unique:akun,email|max:100',
            'password' => 'required|min:6|confirmed',
            'posisi' => 'required|in:admin,karyawan',
        ], [
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'posisi.required' => 'Posisi harus diisi.',
            'posisi.in' => 'Posisi yang dipilih tidak valid.',
        ]);

        // Simpan data ke tabel akun
        Akun::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'posisi' => $request->posisi,
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login!');
    }
}
