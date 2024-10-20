@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Tambah Akun</h3>
</div>
<div class="card">
    <div class="card-body">
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

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('akun.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection