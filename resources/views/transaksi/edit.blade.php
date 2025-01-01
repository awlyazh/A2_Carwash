@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Edit Transaksi</h3>
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
                        <option 
                            value="{{ $m->no_plat_mobil }}"
                            data-nama-mobil="{{ $m->nama_mobil }}"
                            data-jenis-mobil="{{ optional($m->harga)->jenis_mobil }}"
                            data-harga="{{ optional($m->harga)->harga }}"
                            data-pelanggan-id="{{ $p->id_pelanggan }}"
                            {{ old('no_plat_mobil', $transaksi->no_plat_mobil) == $m->no_plat_mobil ? 'selected' : '' }}>
                            {{ $m->no_plat_mobil }} - {{ $p->nama }}
                        </option>
                        @endforeach
                    @endforeach
                </select>
                @error('no_plat_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Nama Mobil --}}
            <div class="mb-3">
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <input type="text" class="form-control" id="nama_mobil" name="nama_mobil" readonly value="{{ old('nama_mobil', optional($transaksi->mobil)->nama_mobil) }}">
            </div>

            {{-- Jenis Mobil --}}
            <div class="mb-3">
                <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                <input type="text" class="form-control" id="jenis_mobil" name="jenis_mobil" readonly value="{{ old('jenis_mobil', optional(optional($transaksi->mobil)->harga)->jenis_mobil) }}">
            </div>

            {{-- Harga Mobil --}}
            <div class="mb-3">
                <label for="harga_mobil" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga_mobil" name="harga_mobil" readonly value="{{ old('harga_mobil', optional(optional($transaksi->mobil)->harga)->harga) }}">
            </div>

            {{-- Pilih Nama Karyawan --}}
            <div class="mb-3">
                <label for="nama_karyawan" class="form-label">Pilih Karyawan</label>
                <select class="form-control @error('nama_karyawan') is-invalid @enderror" id="nama_karyawan" name="nama_karyawan" required>
                    <option value="">Pilih Nama Karyawan</option>
                    @foreach ($karyawan as $k)
                    <option 
                        value="{{ $k->nama_karyawan }}"
                        data-karyawan-id="{{ $k->id_karyawan }}"
                        data-mobil-dicuci="{{ $k->jumlah_mobil_dicuci ?? 0 }}"
                        data-uang-dihasilkan="{{ $k->jumlah_uang_dihasilkan ?? 0 }}"
                        {{ old('nama_karyawan', $transaksi->id_karyawan) == $k->id_karyawan ? 'selected' : '' }}>
                        {{ $k->nama_karyawan }}
                    </option>
                    @endforeach
                </select>
                @error('nama_karyawan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Tersembunyi untuk ID Karyawan --}}
            <input type="hidden" id="id_karyawan" name="id_karyawan" value="{{ old('id_karyawan', $transaksi->id_karyawan) }}">

            {{-- Jumlah Mobil Dicuci --}}
            <div class="mb-3">
                <label for="jumlah_mobil_dicuci" class="form-label">Jumlah Mobil yang Dicuci</label>
                <input type="number" class="form-control" id="jumlah_mobil_dicuci" name="jumlah_mobil_dicuci" readonly value="{{ old('jumlah_mobil_dicuci', optional($transaksi->karyawan)->jumlah_mobil_dicuci) }}">
            </div>

            {{-- Jumlah Uang yang Dihasilkan --}}
            <div class="mb-3">
                <label for="jumlah_uang_dihasilkan" class="form-label">Jumlah Uang yang Dihasilkan</label>
                <input type="number" class="form-control" id="jumlah_uang_dihasilkan" name="jumlah_uang_dihasilkan" readonly value="{{ old('jumlah_uang_dihasilkan', optional($transaksi->karyawan)->jumlah_uang_dihasilkan) }}">
            </div>

            {{-- Metode Pembayaran --}}
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select class="form-control @error('metode_pembayaran') is-invalid @enderror" id="metode_pembayaran" name="metode_pembayaran" required>
                    <option>Pilih Metode Pembayaran</option>
                    <option value="cash" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="transfer bank" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'transfer bank' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="qris" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'qris' ? 'selected' : '' }}>QRIS</option>
                </select>
                @error('metode_pembayaran')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Transaksi --}}
            <div class="mb-3">
                <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                <input type="date" class="form-control @error('tanggal_transaksi') is-invalid @enderror" id="tanggal_transaksi" name="tanggal_transaksi" required value="{{ old('tanggal_transaksi', $transaksi->tanggal_transaksi) }}">
                @error('tanggal_transaksi')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Tersembunyi untuk ID Pelanggan --}}
            <input type="hidden" id="id_pelanggan" name="id_pelanggan" value="{{ old('id_pelanggan', $transaksi->id_pelanggan) }}">

            {{-- Tombol Simpan --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const noPlatMobilSelect = document.getElementById('no_plat_mobil');
        const namaMobilInput = document.getElementById('nama_mobil');
        const jenisMobilInput = document.getElementById('jenis_mobil');
        const hargaMobilInput = document.getElementById('harga_mobil');
        const idPelangganInput = document.getElementById('id_pelanggan');

        noPlatMobilSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            namaMobilInput.value = selectedOption.getAttribute('data-nama-mobil') || '';
            jenisMobilInput.value = selectedOption.getAttribute('data-jenis-mobil') || '';
            hargaMobilInput.value = selectedOption.getAttribute('data-harga') || '';
            idPelangganInput.value = selectedOption.getAttribute('data-pelanggan-id') || '';
        });
    });
</script>

@endsection
