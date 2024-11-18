@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Edit Karyawan</h3>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('karyawan.update', $karyawan->id_karyawan) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Input Nama Karyawan --}}
            <div class="mb-3">
                <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                <input type="text" class="form-control @error('nama_karyawan') is-invalid @enderror" id="nama_karyawan" name="nama_karyawan" value="{{ old('nama_karyawan', $karyawan->nama_karyawan) }}" required>
                @error('nama_karyawan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input No. HP --}}
            <div class="mb-3">
                <label for="no_hp" class="form-label">No. HP</label>
                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $karyawan->no_hp) }}" required pattern="[0-9\s]+" title="Hanya angka yang diperbolehkan">
                @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
