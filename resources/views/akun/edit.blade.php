@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Edit Akun</h3>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('akun.update', $akun->id_akun) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" value="{{ $akun->username }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $akun->email }}" required>
            </div>

            <div class="form-group">
                <label for="posisi">Posisi</label>
                <select name="posisi" class="form-control" required>
                    <option value="admin" {{ $akun->posisi == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="karyawan" {{ $akun->posisi == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('akun.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection