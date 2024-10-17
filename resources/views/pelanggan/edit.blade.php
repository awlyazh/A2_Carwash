@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Pelanggan</h2>

    <form action="{{ url('pelanggan/update', $pelanggan->id_pelanggan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama">Nama Pelanggan</label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $pelanggan->nama) }}" required>
            @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="no_hp">No. Telepon</label>
            <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $pelanggan->no_hp) }}" required>
            @error('no_hp')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="no_plat_mobil">Nomor Plat Mobil</label>
            <input type="text" name="no_plat_mobil" class="form-control @error('no_plat_mobil') is-invalid @enderror" value="{{ old('no_plat_mobil', $pelanggan->no_plat_mobil) }}" required>
            @error('no_plat_mobil')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="nama_mobil">Nama Mobil</label>
            <input type="text" name="nama_mobil" class="form-control @error('nama_mobil') is-invalid @enderror" value="{{ old('nama_mobil', $pelanggan->nama_mobil) }}" required>
            @error('nama_mobil')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="jenis_mobil">Jenis Mobil</label>
            <input type="text" name="jenis_mobil" class="form-control @error('jenis_mobil') is-invalid @enderror" value="{{ old('jenis_mobil', $pelanggan->jenis_mobil) }}" required>
            @error('jenis_mobil')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
