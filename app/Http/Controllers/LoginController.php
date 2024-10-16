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
}