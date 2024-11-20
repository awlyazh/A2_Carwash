@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Tambah Pelanggan</h3>
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
                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
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
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <select class="form-select @error('nama_mobil') is-invalid @enderror" id="nama_mobil" name="nama_mobil" required>
                    <option value="">Pilih Nama Mobil</option>
                    @foreach($mobil as $item)
                        <option value="{{ $item->nama_mobil }}">{{ $item->nama_mobil }}</option>
                    @endforeach
                    <option value="add_new">Tambah Nama Mobil Baru</option>
                </select>
                @error('nama_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Manual Nama Mobil --}}
            <div class="mb-3 d-none" id="nama_mobil_manual_container">
                <label for="nama_mobil_manual" class="form-label">Masukkan Nama Mobil Baru</label>
                <input type="text" class="form-control @error('nama_mobil_manual') is-invalid @enderror" id="nama_mobil_manual" name="nama_mobil_manual" placeholder="Masukkan nama mobil baru">
                @error('nama_mobil_manual')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Dropdown Jenis Mobil --}}
            <div class="mb-3">
                <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                <select class="form-select @error('jenis_mobil') is-invalid @enderror" id="jenis_mobil" name="jenis_mobil" required>
                    <option value="">Pilih Jenis Mobil</option>
                    @foreach($harga as $item)
                        <option value="{{ $item->jenis_mobil }}">{{ ucfirst($item->jenis_mobil) }}</option>
                    @endforeach
                </select>
                @error('jenis_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Harga --}}
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga" readonly placeholder="Harga otomatis muncul berdasarkan jenis mobil">
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
    // Toggle input manual nama mobil
    document.getElementById('nama_mobil').addEventListener('change', function () {
        const manualInput = document.getElementById('nama_mobil_manual_container');
        const isManual = this.value === 'add_new';
        manualInput.classList.toggle('d-none', !isManual);
        document.getElementById('nama_mobil_manual').required = isManual;
    });

        // Update harga berdasarkan jenis mobil
        // Menyimpan data harga dari Blade ke dalam variabel JavaScript
    const hargaData = @json($harga);

// Update harga berdasarkan jenis mobil
document.getElementById('jenis_mobil').addEventListener('change', function () {
    const hargaInput = document.getElementById('harga');
    const jenisMobil = this.value;

    const selectedHarga = hargaData.find(item => item.jenis_mobil === jenisMobil);

    hargaInput.value = selectedHarga ? 
        "Rp " + parseInt(selectedHarga.harga).toLocaleString('id-ID') : 
        "";
});
</script>
@endsection
