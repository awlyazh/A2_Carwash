@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Tambah Akun</h3>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('akun.store') }}" method="POST">
            @csrf

            {{-- Tampilkan pesan kesalahan jika validasi gagal --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="posisi">Posisi</label>
                <select name="posisi" class="form-control @error('posisi') is-invalid @enderror" required>
                    <option value="admin" {{ old('posisi') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="karyawan" {{ old('posisi') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                </select>
                @error('posisi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('akun.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
