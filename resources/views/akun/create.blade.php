@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Akun</h1>

    <form action="{{ route('akun.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="posisi">Posisi</label>
            <select name="posisi" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="karyawan">Karyawan</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('akun.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
