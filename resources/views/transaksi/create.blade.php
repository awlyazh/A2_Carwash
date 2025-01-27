@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Tambah Transaksi</h3>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            {{-- Pilih Plat Mobil --}}
            <div class="mb-3">
                <label for="no_plat_mobil" class="form-label">Pilih Plat Mobil</label>
                <select class="form-control @error('no_plat_mobil') is-invalid @enderror" id="no_plat_mobil" name="no_plat_mobil" required>
                    <option value="">Pilih Plat Mobil</option>
                    @foreach ($pelanggan as $p)
                    @foreach ($p->mobil as $m)
                    <option value="{{ $m->no_plat_mobil }}"
                        data-nama-mobil="{{ $m->nama_mobil }}"
                        data-jenis-mobil="{{ $m->harga->jenis_mobil }}"
                        data-harga="{{ $m->harga->harga }}"
                        data-pelanggan-id="{{ $p->id_pelanggan }}">
                        {{ $m->no_plat_mobil }} - {{ $p->nama }}
                    </option>
                    @endforeach
                    @endforeach
                </select>
                @error('no_plat_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tampilkan Nama Mobil --}}
            <div class="mb-3">
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <input type="text" class="form-control" id="nama_mobil" name="nama_mobil" readonly>
            </div>

            {{-- Tampilkan Jenis Mobil --}}
            <div class="mb-3">
                <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                <input type="text" class="form-control" id="jenis_mobil" name="jenis_mobil" readonly>
            </div>

            {{-- Tampilkan Harga Mobil --}}
            <div class="mb-3">
                <label for="harga_mobil" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga_mobil" name="harga_mobil" readonly>
            </div>

            {{-- Pilih Nama Karyawan --}}
            <div class="mb-3">
                <label for="nama_karyawan" class="form-label">Pilih Karyawan</label>
                <select class="form-control @error('nama_karyawan') is-invalid @enderror" id="nama_karyawan" name="nama_karyawan" required>
                    <option value="">Pilih Nama Karyawan</option>
                    @foreach ($karyawan as $k)
                    <option value="{{ $k->id_karyawan }}"
                        data-nama-karyawan="{{ $k->nama_karyawan }}"
                        data-mobil-dicuci="{{ $k->jumlah_mobil_dicuci ?? 0 }}"
                        data-uang-dihasilkan="{{ $k->jumlah_uang_dihasilkan ?? 0 }}">
                        {{ $k->nama_karyawan }}
                    </option>
                    @endforeach
                </select>
                @error('nama_karyawan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Tersembunyi untuk ID Karyawan --}}
            <input type="hidden" id="id_karyawan" name="id_karyawan">

            {{-- Tampilkan Jumlah Mobil Dicuci --}}
            <div class="mb-3">
                <label for="jumlah_mobil_dicuci" class="form-label">Jumlah Mobil yang Dicuci</label>
                <input type="number" class="form-control" id="jumlah_mobil_dicuci" name="jumlah_mobil_dicuci" readonly>
            </div>

            {{-- Tampilkan Jumlah Uang yang Dihasilkan --}}
            <div class="mb-3">
                <label for="jumlah_uang_dihasilkan" class="form-label">Jumlah Uang yang Dihasilkan</label>
                <input type="number" class="form-control" id="jumlah_uang_dihasilkan" name="jumlah_uang_dihasilkan" readonly>
            </div>

            {{-- Select Metode Pembayaran --}}
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select class="form-control @error('metode_pembayaran') is-invalid @enderror" id="metode_pembayaran" name="metode_pembayaran" required>
                    <option>Pilih Metode Pembayaran</option>
                    <option value="cash">Cash</option>
                    <option value="transfer bank">Transfer Bank</option>
                    <option value="qris">QRIS</option>
                </select>
                @error('metode_pembayaran')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Tanggal Transaksi --}}
            <div class="mb-3">
                <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                <input type="date" class="form-control @error('tanggal_transaksi') is-invalid @enderror" id="tanggal_transaksi" name="tanggal_transaksi" required>
                @error('tanggal_transaksi')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status --}}
            <div class="mb-3" style="display: none;">
                <input type="text" class="form-control" id="status" name="status" value="selesai" readonly>
            </div>

            {{-- Input Tersembunyi untuk ID Pelanggan --}}
            <input type="hidden" id="id_pelanggan" name="id_pelanggan">

            {{-- Tombol Simpan --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ url('transaksi') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

{{-- JavaScript Dinamis --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const noPlatMobilSelect = document.getElementById('no_plat_mobil');
        const namaMobilInput = document.getElementById('nama_mobil');
        const jenisMobilInput = document.getElementById('jenis_mobil');
        const hargaMobilInput = document.getElementById('harga_mobil');
        const idPelangganInput = document.getElementById('id_pelanggan');
        const namaKaryawanSelect = document.getElementById('nama_karyawan');
        const idKaryawanInput = document.getElementById('id_karyawan');
        const jumlahMobilDicuciInput = document.getElementById('jumlah_mobil_dicuci');
        const jumlahUangDihasilkanInput = document.getElementById('jumlah_uang_dihasilkan');

        // Update data mobil ketika plat mobil dipilih
        noPlatMobilSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            namaMobilInput.value = selectedOption.getAttribute('data-nama-mobil') || '';
            jenisMobilInput.value = selectedOption.getAttribute('data-jenis-mobil') || '';
            hargaMobilInput.value = selectedOption.getAttribute('data-harga') || '';
            idPelangganInput.value = selectedOption.getAttribute('data-pelanggan-id') || '';
        });

        // Update data karyawan ketika nama karyawan dipilih
        namaKaryawanSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            idKaryawanInput.value = selectedOption.value || '';

            // Ambil nilai jumlah mobil dicuci, jika kosong atau null, set ke 0
            const mobilDicuci = selectedOption.getAttribute('data-mobil-dicuci');
            jumlahMobilDicuciInput.value = mobilDicuci ? mobilDicuci : 0;

            // Ambil nilai jumlah uang dihasilkan, jika kosong atau null, set ke 0
            const uangDihasilkan = selectedOption.getAttribute('data-uang-dihasilkan');
            jumlahUangDihasilkanInput.value = uangDihasilkan ? uangDihasilkan : 0;
        });
    });
</script>

@endsection