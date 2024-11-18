@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Tambah Pelanggan </h3>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('pelanggan.store') }}" method="POST">
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

            {{-- Dropdown Nama Mobil --}}
            <div class="mb-3">
                <label for="existing_mobil" class="form-label">Nama Mobil</label>
                <select class="form-select @error('existing_mobil') is-invalid @enderror" id="existing_mobil" name="existing_mobil">
                    <option value="">Pilih Mobil</option>
                    @foreach($mobil as $car)
                    <option value="{{ $car->id_mobil }}">{{ $car->nama_mobil }}</option>
                    @endforeach
                    <option value="manual">Tambah Nama Mobil Baru</option>
                </select>
                @error('existing_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Nama Mobil Manual (Hidden) --}}
            <div class="mb-3" id="manual_mobil_input" style="display: none;">
                <label for="manual_nama_mobil" class="form-label">Tambah Mobil Baru</label>
                <input type="text" class="form-control" id="manual_nama_mobil" name="nama_mobil">
            </div>

            {{-- Dropdown Jenis Mobil --}}
            <div class="mb-3">
                <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                <select class="form-select @error('jenis_mobil') is-invalid @enderror" id="jenis_mobil" name="jenis_mobil" required>
                    <option value="">Pilih Jenis Mobil</option>
                    <option value="kecil" {{ old('jenis_mobil') == 'kecil' ? 'selected' : '' }}>Mobil Kecil</option>
                    <option value="besar" {{ old('jenis_mobil') == 'besar' ? 'selected' : '' }}>Mobil Besar</option>
                </select>
                @error('jenis_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Harga --}}
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga" value="{{ old('harga') }}" readonly>
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
    // Menampilkan input manual jika opsi "manual" dipilih
    document.getElementById('existing_mobil').addEventListener('change', function() {
        var selectedValue = this.value;
        var manualInput = document.getElementById('manual_mobil_input');

        if (selectedValue === "manual") {
            manualInput.style.display = "block";
            manualInput.querySelector('input').setAttribute('required', 'required');
        } else {
            manualInput.style.display = "none";
            manualInput.querySelector('input').removeAttribute('required');
        }
    });

    // Update harga berdasarkan jenis mobil yang dipilih
    document.getElementById('jenis_mobil').addEventListener('change', function() {
        var hargaInput = document.getElementById('harga');
        var jenisMobil = this.value;

        if (jenisMobil === "kecil") {
            hargaInput.value = "Rp 50.000"; // Simulasi harga berdasarkan jenis
        } else if (jenisMobil === "besar") {
            hargaInput.value = "Rp 60.000"; // Simulasi harga berdasarkan jenis
        } else {
            hargaInput.value = "";
        }
    });
</script>

@endsection