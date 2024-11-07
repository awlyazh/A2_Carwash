@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Edit Pelanggan</h3>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ url('pelanggan/update', $pelanggan->id_pelanggan) }}" method="POST">
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
                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $pelanggan->no_hp) }}" required pattern="[0-9\s]+" title="Hanya angka yang diperbolehkan">
                @error('no_hp')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Nomor Plat Mobil --}}
            <div class="mb-3">
                <label for="no_plat_mobil" class="form-label">Nomor Plat Mobil</label>
                <input type="text" class="form-control @error('no_plat_mobil') is-invalid @enderror" id="no_plat_mobil" name="no_plat_mobil" value="{{ old('no_plat_mobil', $pelanggan->no_plat_mobil) }}" required>
                @error('no_plat_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Nama Mobil --}}
            <div class="mb-3">
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <select id="nama_mobil" name="nama_mobil" class="form-select @error('nama_mobil') is-invalid @enderror" required onchange="checkForNewCar()">
                    <option value="">Pilih Nama Mobil</option>
                    <option value="Toyota Avanza" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Toyota Avanza' ? 'selected' : '' }}>Toyota Avanza</option>
                    <option value="Honda Jazz" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Honda Jazz' ? 'selected' : '' }}>Honda Jazz</option>
                    <option value="Suzuki Ertiga" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Suzuki Ertiga' ? 'selected' : '' }}>Suzuki Ertiga</option>
                    <option value="Mitsubishi Xpander" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Mitsubishi Xpander' ? 'selected' : '' }}>Mitsubishi Xpander</option>
                    <option value="Nissan Livina" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Nissan Livina' ? 'selected' : '' }}>Nissan Livina</option>
                    <option value="Toyota Fortuner" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Toyota Fortuner' ? 'selected' : '' }}>Toyota Fortuner</option>
                    <option value="Honda CR-V" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Honda CR-V' ? 'selected' : '' }}>Honda CR-V</option>
                    <option value="Ford Everest" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Ford Everest' ? 'selected' : '' }}>Ford Everest</option>
                    <option value="Mitsubishi Pajero" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Mitsubishi Pajero' ? 'selected' : '' }}>Mitsubishi Pajero</option>
                    <option value="Toyota Hilux" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Toyota Hilux' ? 'selected' : '' }}>Toyota Hilux</option>
                    <option value="Nissan Navara" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Nissan Navara' ? 'selected' : '' }}>Nissan Navara</option>
                    <option value="Honda Brio" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Honda Brio' ? 'selected' : '' }}>Honda Brio</option>
                    <option value="Suzuki Swift" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Suzuki Swift' ? 'selected' : '' }}>Suzuki Swift</option>
                    <option value="Hyundai Santa Fe" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Hyundai Santa Fe' ? 'selected' : '' }}>Hyundai Santa Fe</option>
                    <option value="Kia Seltos" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Kia Seltos' ? 'selected' : '' }}>Kia Seltos</option>
                    <option value="Daihatsu Terios" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Daihatsu Terios' ? 'selected' : '' }}>Daihatsu Terios</option>
                    <option value="Toyota Rush" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Toyota Rush' ? 'selected' : '' }}>Toyota Rush</option>
                    <option value="Ford Ranger" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Ford Ranger' ? 'selected' : '' }}>Ford Ranger</option>
                    <option value="Honda HR-V" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Honda HR-V' ? 'selected' : '' }}>Honda HR-V</option>
                    <option value="Nissan Terra" {{ old('nama_mobil', $pelanggan->nama_mobil) == 'Nissan Terra' ? 'selected' : '' }}>Nissan Terra</option>
                    <option value="Tambah Mobil Baru">Tambah Mobil Baru</option>
                </select>
                <input type="text" class="form-control mt-2 d-none" id="new_car_name" name="new_car_name" placeholder="Masukkan Nama Mobil Baru" value="{{ old('new_car_name') }}">
                @error('nama_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Jenis Mobil --}}
            <div class="mb-3">
                <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                <select class="form-select @error('jenis_mobil') is-invalid @enderror" id="jenis_mobil" name="jenis_mobil" required>
                    <option value="">Pilih Jenis Mobil</option>
                    <option value="Mobil Besar" {{ old('jenis_mobil', $pelanggan->jenis_mobil) == 'Mobil Besar' ? 'selected' : '' }}>Mobil Besar</option>
                    <option value="Mobil Kecil" {{ old('jenis_mobil', $pelanggan->jenis_mobil) == 'Mobil Kecil' ? 'selected' : '' }}>Mobil Kecil</option>
                </select>
                @error('jenis_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ url('pelanggan') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan input nama mobil baru jika opsi 'Tambah Mobil Baru' dipilih
    function checkForNewCar() {
        var carSelect = document.getElementById("nama_mobil");
        var newCarInput = document.getElementById("new_car_name");

        // Jika pilihan 'Tambah Mobil Baru' dipilih, tampilkan input baru
        if (carSelect.value === "Tambah Mobil Baru") {
            newCarInput.classList.remove("d-none");  // Menampilkan input
        } else {
            newCarInput.classList.add("d-none");  // Menyembunyikan input
        }
    }
</script>
@endsection
