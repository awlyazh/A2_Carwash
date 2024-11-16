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
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" 
                    value="{{ old('nama', $pelanggan->nama) }}" required>
                @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input No. Telepon --}}
            <div class="mb-3">
                <label for="no_hp" class="form-label">No. Telepon</label>
                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" 
                    value="{{ old('no_hp', $pelanggan->no_hp) }}" required pattern="[0-9\s]+" 
                    title="Hanya angka yang diperbolehkan">
                @error('no_hp')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Nomor Plat Mobil --}}
            <div class="mb-3">
                <label for="no_plat_mobil" class="form-label">Nomor Plat Mobil</label>
                <input type="text" class="form-control @error('no_plat_mobil') is-invalid @enderror" id="no_plat_mobil" 
                    name="no_plat_mobil" value="{{ old('no_plat_mobil', $mobil->no_plat_mobil) }}" required>
                @error('no_plat_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Nama Mobil --}}
            <div class="mb-3">
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <select id="nama_mobil" name="nama_mobil" class="form-select @error('nama_mobil') is-invalid @enderror" 
                    required onchange="checkForNewCar()">
                    <option value="">Pilih Nama Mobil</option>
                    <option value="Tambah Mobil Baru" {{ old('nama_mobil', $mobil->nama_mobil) == 'Tambah Mobil Baru' ? 'selected' : '' }}>
                        Tambah Mobil Baru
                    </option>
                    @foreach ($masterNamaMobils as $item)
                        <option value="{{ $item->nama_mobil }}" 
                            {{ old('nama_mobil', $mobil->nama_mobil) == $item->nama_mobil ? 'selected' : '' }}>
                            {{ $item->nama_mobil }}
                        </option>
                    @endforeach
                </select>
                <input type="text" class="form-control mt-2 d-none" id="new_car_name" name="new_car_name" 
                    placeholder="Masukkan Nama Mobil Baru" value="{{ old('new_car_name') }}">
                @error('nama_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Jenis Mobil --}}
            <div class="mb-3">
                <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                <select class="form-select @error('jenis_mobil') is-invalid @enderror" id="jenis_mobil" name="jenis_mobil" required>
                    <option value="">Pilih Jenis Mobil</option>
                    @foreach($harga as $item)
                        <option value="{{ $item->jenis_mobil }}" 
                            {{ old('jenis_mobil', $mobil->jenis_mobil) == $item->jenis_mobil ? 'selected' : '' }}>
                            {{ $item->jenis_mobil }}
                        </option>
                    @endforeach
                </select>
                @error('jenis_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Harga --}}
            <div class="mb-3">
                <label for="id_harga" class="form-label">Harga</label>
                <select class="form-select @error('id_harga') is-invalid @enderror" id="id_harga" name="id_harga" required>
                    <option value="">Pilih Harga</option>
                    @foreach($harga as $item)
                        <option value="{{ $item->id_harga }}" 
                            {{ old('id_harga', $mobil->id_harga) == $item->id_harga ? 'selected' : '' }}>
                            {{ $item->jenis_mobil }} - {{ $item->harga }}
                        </option>
                    @endforeach
                </select>
                @error('id_harga')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
    function checkForNewCar() {
        const carSelect = document.getElementById("nama_mobil");
        const newCarInput = document.getElementById("new_car_name");

        if (carSelect.value === "Tambah Mobil Baru") {
            newCarInput.classList.remove("d-none");
        } else {
            newCarInput.classList.add("d-none");
        }
    }

    // Jalankan fungsi untuk menjaga tampilan saat reload
    checkForNewCar();
</script>
@endsection
