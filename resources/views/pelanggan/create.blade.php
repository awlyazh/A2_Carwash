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

            {{-- Input Nama Mobil dengan Dropdown --}}
            <div class="mb-3">
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <select id="nama_mobil" name="nama_mobil" class="form-select @error('nama_mobil') is-invalid @enderror" required onchange="checkForNewCar()">
                    <option value="">Pilih Nama Mobil</option>
                    <option value="Toyota Avanza">Toyota Avanza</option>
                    <option value="Honda Jazz">Honda Jazz</option>
                    <option value="Suzuki Ertiga">Suzuki Ertiga</option>
                    <option value="Mitsubishi Xpander">Mitsubishi Xpander</option>
                    <option value="Nissan Livina">Nissan Livina</option>
                    <option value="Toyota Fortuner">Toyota Fortuner</option>
                    <option value="Honda CR-V">Honda CR-V</option>
                    <option value="Ford Everest">Ford Everest</option>
                    <option value="Mitsubishi Pajero">Mitsubishi Pajero</option>
                    <option value="Toyota Hilux">Toyota Hilux</option>
                    <option value="Nissan Navara">Nissan Navara</option>
                    <option value="Honda Brio">Honda Brio</option>
                    <option value="Suzuki Swift">Suzuki Swift</option>
                    <option value="Hyundai Santa Fe">Hyundai Santa Fe</option>
                    <option value="Kia Seltos">Kia Seltos</option>
                    <option value="Daihatsu Terios">Daihatsu Terios</option>
                    <option value="Toyota Rush">Toyota Rush</option>
                    <option value="Ford Ranger">Ford Ranger</option>
                    <option value="Honda HR-V">Honda HR-V</option>
                    <option value="Nissan Terra">Nissan Terra</option>
                    <option value="Tambah Mobil Baru">Tambah Mobil Baru</option>
                </select>
                <input type="text" class="form-control mt-2 d-none" id="new_car_name" name="new_car_name" placeholder="Masukkan Nama Mobil Baru">
                @error('nama_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Jenis Mobil --}}
            <div class="mb-3">
                <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                <select class="form-select @error('jenis_mobil') is-invalid @enderror" id="jenis_mobil" name="jenis_mobil" required>
                    <option value="">Pilih Jenis Mobil</option>
                    <option value="Mobil Besar">Mobil Besar</option>
                    <option value="Mobil Kecil">Mobil Kecil</option>
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
