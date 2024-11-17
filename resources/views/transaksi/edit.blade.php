@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Edit Transaksi</h3>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('transaksi.update', $transaksi->id_transaksi) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Pilih Plat Mobil --}}
            <div class="mb-3">
                <label for="no_plat_mobil" class="form-label">Pilih Plat Mobil</label>
                <select class="form-control @error('no_plat_mobil') is-invalid @enderror" id="no_plat_mobil" name="no_plat_mobil" required>
                    <option value="">Pilih Plat Mobil</option>
                    @foreach ($pelanggan as $p)
                        @foreach ($p->mobil as $m)
                            <option value="{{ $m->no_plat_mobil }}" 
                                    data-nama-mobil="{{ $m->nama_mobil }}" 
                                    data-jenis-mobil="{{ $m->jenis_mobil }}" 
                                    data-harga="{{ $m->harga->harga }}"
                                    {{ $m->no_plat_mobil == $transaksi->no_plat_mobil ? 'selected' : '' }}>
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
                <input type="text" class="form-control" id="nama_mobil" name="nama_mobil" value="{{ $transaksi->mobil->nama_mobil ?? '' }}" readonly>
            </div>

            {{-- Tampilkan Jenis Mobil --}}
            <div class="mb-3">
                <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                <input type="text" class="form-control" id="jenis_mobil" name="jenis_mobil" value="{{ $transaksi->mobil->jenis_mobil ?? '' }}" readonly>
            </div>

            {{-- Tampilkan Harga Mobil --}}
            <div class="mb-3">
                <label for="harga_mobil" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga_mobil" name="harga_mobil" value="{{ $transaksi->harga ?? '' }}" readonly>
            </div>

            {{-- Input Tanggal Transaksi --}}
            <div class="mb-3">
                <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                <input type="date" class="form-control @error('tanggal_transaksi') is-invalid @enderror" id="tanggal_transaksi" name="tanggal_transaksi" value="{{ $transaksi->tanggal_transaksi }}" required>
                @error('tanggal_transaksi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Nama Karyawan --}}
            <div class="mb-3">
                <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                <input type="text" class="form-control @error('nama_karyawan') is-invalid @enderror" id="nama_karyawan" name="nama_karyawan" value="{{ $transaksi->karyawan->nama_karyawan ?? '' }}" required>
                @error('nama_karyawan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jumlah Mobil Dicuci --}}
            <div class="mb-3">
                <label for="jumlah_mobil_dicuci" class="form-label">Jumlah Mobil yang Dicuci</label>
                <input type="number" class="form-control @error('jumlah_mobil_dicuci') is-invalid @enderror" id="jumlah_mobil_dicuci" name="jumlah_mobil_dicuci" value="{{ $transaksi->jumlah_mobil_dicuci ?? 1 }}" readonly>
                @error('jumlah_mobil_dicuci')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jumlah Uang yang Dihasilkan --}}
            <div class="mb-3">
                <label for="jumlah_uang_dihasilkan" class="form-label">Jumlah Uang yang Dihasilkan</label>
                <input type="number" class="form-control @error('jumlah_uang_dihasilkan') is-invalid @enderror" id="jumlah_uang_dihasilkan" name="jumlah_uang_dihasilkan" value="{{ $transaksi->jumlah_uang_dihasilkan ?? '' }}" readonly>
                @error('jumlah_uang_dihasilkan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Select Metode Pembayaran --}}
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select class="form-control @error('metode_pembayaran') is-invalid @enderror" id="metode_pembayaran" name="metode_pembayaran" required>
                    <option value="">Pilih Metode Pembayaran</option>
                    <option value="cash" {{ $transaksi->metode_pembayaran == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="transfer bank" {{ $transaksi->metode_pembayaran == 'transfer bank' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="qris" {{ $transaksi->metode_pembayaran == 'qris' ? 'selected' : '' }}>QRIS</option>
                </select>
                @error('metode_pembayaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Total Pembayaran --}}
            <div class="mb-3">
                <label for="total_pembayaran" class="form-label">Total Pembayaran</label>
                <input type="number" step="0.01" class="form-control @error('total_pembayaran') is-invalid @enderror" id="total_pembayaran" name="total_pembayaran" value="{{ $transaksi->total_pembayaran }}" readonly>
                @error('total_pembayaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Select Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">Pilih Status</option>
                    <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ $transaksi->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Tersembunyi untuk ID Pelanggan --}}
            <input type="hidden" id="id_pelanggan" name="id_pelanggan" value="{{ $transaksi->id_pelanggan }}">

            {{-- Tombol Simpan --}}
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
        const jumlahUangDihasilkanInput = document.getElementById('jumlah_uang_dihasilkan');
        const totalPembayaranInput = document.getElementById('total_pembayaran');

        // Update nama, jenis mobil, dan harga otomatis
        noPlatMobilSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            namaMobilInput.value = selectedOption.getAttribute('data-nama-mobil');
            jenisMobilInput.value = selectedOption.getAttribute('data-jenis-mobil');
            const harga = selectedOption.getAttribute('data-harga');
            hargaMobilInput.value = harga;
            jumlahUangDihasilkanInput.value = harga;
            totalPembayaranInput.value = harga;
        });
    });
</script>
@endsection
