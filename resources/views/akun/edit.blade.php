@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Akun</h1>

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

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('akun.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
