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
            <div class="mb-3 mt-3"> <!-- Menambahkan margin-top -->
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <select id="nama_mobil" name="nama_mobil" class="form-select @error('nama_mobil') is-invalid @enderror" required onchange="checkForNewCar()">
                    <option value="">Pilih Nama Mobil</option>
                    {{-- Data nama mobil akan diambil dari database --}}
                    <option value="Tambah Mobil Baru">Tambah Mobil Baru</option>
                    @foreach ($masterNamaMobils as $mobil)
                    <option value="{{ $mobil->nama_mobil }}">{{ $mobil->nama_mobil }}</option>
                    @endforeach
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
                    <option value="kecil">Mobil Kecil</option>
                    <option value="besar">Mobil Besar</option>
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
            <a href="{{ url('pelanggan') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan input nama mobil baru jika opsi 'Tambah Mobil Baru' dipilih
    function checkForNewCar() {
        var carSelect = document.getElementById("nama_mobil");
        var newCarInput = document.getElementById("new_car_name");

        if (carSelect.value === "Tambah Mobil Baru") {
            newCarInput.classList.remove("d-none");  // Menampilkan input baru
        } else {
            newCarInput.classList.add("d-none");  // Menyembunyikan input
            // Mengatur nilai input nama mobil menjadi pilihan dropdown jika tidak memilih 'Tambah Mobil Baru'
            newCarInput.value = '';  // Menghapus nilai input baru
        }
    }

    // Fungsi untuk memperbarui harga berdasarkan jenis mobil yang dipilih
    function updateHarga() {
    var jenisMobil = document.getElementById("jenis_mobil");
    var hargaInput = document.getElementById("harga");
    var idHargaInput = document.getElementById("id_harga"); // Hidden input

    var selectedOption = jenisMobil.options[jenisMobil.selectedIndex];
    var harga = selectedOption.getAttribute("data-harga");
    var idHarga = selectedOption.getAttribute("data-id-harga"); // Tambahkan data-id-harga pada opsi dropdown

    if (harga) {
        hargaInput.value = "Rp " + harga.toLocaleString(); // Format harga dengan pemisah ribuan
        idHargaInput.value = idHarga; // Set nilai id_harga
    } else {
        hargaInput.value = "";
        idHargaInput.value = ""; // Kosongkan jika tidak ada harga
    }
}

document.getElementById('jenis_mobil').addEventListener('change', function () {
        var hargaInput = document.getElementById('harga');
        var jenisMobil = this.value;

        if (jenisMobil === 'kecil') {
            hargaInput.value = "Rp 50,000"; // Harga mobil kecil
        } else if (jenisMobil === 'besar') {
            hargaInput.value = "Rp 60,000"; // Harga mobil besar
        } else {
            hargaInput.value = ""; // Kosongkan jika tidak ada jenis mobil
        }
    });

    // Inisialisasi harga saat pertama kali memilih jenis mobil
    document.addEventListener("DOMContentLoaded", function() {
        updateHarga();
    });
</script>

@endsection
