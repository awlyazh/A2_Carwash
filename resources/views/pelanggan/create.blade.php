@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Tambah Pelanggan</h3>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ url('pelanggan/store') }}" method="POST">
            @csrf

            {{-- Input Nama Pelanggan --}}
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input No. Telepon --}}
            <div class="mb-3">
                <label for="no_hp" class="form-label">No. Telepon</label>
                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required pattern="[0-9\s]+" title="Hanya angka yang diperbolehkan">
                @error('no_hp')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Nomor Plat Mobil --}}
            <div class="mb-3">
                <label for="no_plat_mobil" class="form-label">Nomor Plat Mobil</label>
                <input type="text" class="form-control @error('no_plat_mobil') is-invalid @enderror" id="no_plat_mobil" name="no_plat_mobil" value="{{ old('no_plat_mobil') }}" required>
                @error('no_plat_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Nama Mobil --}}
            <div class="mb-3">
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <input type="text" class="form-control @error('nama_mobil') is-invalid @enderror" id="nama_mobil" name="nama_mobil" value="{{ old('nama_mobil') }}" required>
                @error('nama_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Jenis Mobil --}}
            <div class="mb-3">
                <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                <input type="text" class="form-control @error('jenis_mobil') is-invalid @enderror" id="jenis_mobil" name="jenis_mobil" value="{{ old('jenis_mobil') }}" required>
                @error('jenis_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ url('pelanggan') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection