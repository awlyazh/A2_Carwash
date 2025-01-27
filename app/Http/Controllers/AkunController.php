<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $akun = Akun::all();
        return view('akun.index', compact('akun'));
    }

    public function create()
    {
        return view('akun.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'username' => 'required|max:50',
                'password' => 'required|min:6',
                'email' => 'required|email|unique:akun,email|max:100',
                'posisi' => 'required|in:admin,karyawan',
            ],
            [
                'username.required' => 'Username harus diisi.',
                'username.max' => 'Username tidak boleh lebih dari 50 karakter.',
                'password.required' => 'Password harus diisi.',
                'password.min' => 'Password minimal 6 karakter.',
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'email.max' => 'Email tidak boleh lebih dari 100 karakter.',
                'posisi.required' => 'Posisi harus diisi.',
                'posisi.in' => 'Posisi yang dipilih tidak valid.',
            ]
        );

        Akun::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'posisi' => $request->posisi,
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $akun = Akun::findOrFail($id);
        return view('akun.edit', compact('akun'));
    }

    public function update(Request $request, $id)
    {
        // Mencari akun berdasarkan ID yang diberikan
        $akun = Akun::where('id_akun', '=', $id)->firstOrFail(); // Ambil satu data atau gagal

        // Validasi input
        $request->validate([
            'username' => 'required|max:50',
            'email' => 'required|email|unique:akun,email,' . $id . ',id_akun', // Abaikan email milik akun ini
            'posisi' => 'required|in:admin,karyawan',
        ], [
            'username.required' => 'Username harus diisi.',
            'username.max' => 'Username tidak boleh lebih dari 50 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'posisi.required' => 'Posisi harus diisi.',
            'posisi.in' => 'Posisi yang dipilih tidak valid.',
        ]);

        // Update data akun
        $akun->update([
            'username' => $request->username,
            'email' => $request->email,
            'posisi' => $request->posisi,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('akun.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $akun = Akun::findOrFail($id);
        $akun->delete();

        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus.');
    }
}
