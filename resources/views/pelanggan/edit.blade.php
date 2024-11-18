@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Edit Pelanggan</h3>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Input Nama Pelanggan --}}
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $pelanggan->nama) }}" required>
                @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input No. Telepon --}}
            <div class="mb-3">
                <label for="no_hp" class="form-label">No. Telepon</label>
                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $pelanggan->no_hp) }}" required>
                @error('no_hp')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Nomor Plat Mobil --}}
            <div class="mb-3">
                <label for="no_plat_mobil" class="form-label">Nomor Plat Mobil</label>
                <input type="text" class="form-control @error('no_plat_mobil') is-invalid @enderror" id="no_plat_mobil" name="no_plat_mobil" value="{{ old('no_plat_mobil', optional($pelanggan->mobil->first())->no_plat_mobil) }}" required>
                @error('no_plat_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Nama Mobil --}}
            <div class="mb-3">
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <input type="text" class="form-control @error('nama_mobil') is-invalid @enderror" id="nama_mobil" name="nama_mobil" value="{{ old('nama_mobil', optional($pelanggan->mobil->first())->nama_mobil) }}" required>
                @error('nama_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Dropdown Jenis Mobil --}}
            <div class="mb-3">
                <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                <select class="form-select @error('jenis_mobil') is-invalid @enderror" id="jenis_mobil" name="jenis_mobil" required>
                    <option value="">Pilih Jenis Mobil</option>
                    <option value="kecil" {{ old('jenis_mobil', optional($pelanggan->mobil->first())->jenis_mobil) == 'kecil' ? 'selected' : '' }}>Mobil Kecil</option>
                    <option value="besar" {{ old('jenis_mobil', optional($pelanggan->mobil->first())->jenis_mobil) == 'besar' ? 'selected' : '' }}>Mobil Besar</option>
                </select>
                @error('jenis_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Harga --}}
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga" value="{{ old('harga', optional(optional($pelanggan->mobil->first())->harga)->harga) }}" readonly>
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisMobilSelect = document.getElementById('jenis_mobil');
        const hargaInput = document.getElementById('harga');

        // Update harga berdasarkan jenis mobil
        const hargaMobil = @json($harga);
        jenisMobilSelect.addEventListener('change', function() {
            hargaInput.value = hargaMobil[this.value] || '';
        });

        // Set harga awal berdasarkan jenis mobil saat form dimuat
        const initialJenis = jenisMobilSelect.value;
        if (initialJenis) {
            hargaInput.value = hargaMobil[initialJenis] || '';
        }
    });
</script>

@endsection