@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Tambah Transaksi</h3>
</div>
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
                            <option value="{{ $m->no_plat_mobil }}" data-pelanggan-id="{{ $p->id_pelanggan }}" data-nohp="{{ $p->no_hp }}">
                                {{ $m->no_plat_mobil }} - {{ $p->nama }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
                @error('no_plat_mobil')
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

            {{-- Select Metode Pembayaran --}}
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select class="form-control @error('metode_pembayaran') is-invalid @enderror" id="metode_pembayaran" name="metode_pembayaran" required>
                    <option value="">Pilih Metode Pembayaran</option>
                    <option value="cash">Cash</option>
                    <option value="transfer bank">Transfer Bank</option>
                    <option value="qris">QRIS</option>
                </select>
                @error('metode_pembayaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Select Jenis Mobil --}}
            <div class="mb-3">
                <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                <select class="form-control @error('jenis_mobil') is-invalid @enderror" id="jenis_mobil" name="jenis_mobil" required>
                    <option value="">Pilih Jenis Mobil</option>
                    <option value="kecil" data-harga="50000">Mobil Kecil - Rp 50,000</option>
                    <option value="besar" data-harga="60000">Mobil Besar - Rp 60,000</option>
                </select>
                @error('jenis_mobil')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Total Pembayaran --}}
            <div class="mb-3">
                <label for="total_pembayaran" class="form-label">Total Pembayaran</label>
                <input type="number" step="0.01" class="form-control @error('total_pembayaran') is-invalid @enderror" id="total_pembayaran" name="total_pembayaran" required readonly>
                @error('total_pembayaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Select Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">Pilih Status</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Tersembunyi untuk ID Pelanggan --}}
            <input type="hidden" id="id_pelanggan" name="id_pelanggan">

            {{-- Tombol Simpan --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ url('transaksi') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

{{-- JavaScript --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisMobilSelect = document.getElementById('jenis_mobil');
        const totalPembayaranInput = document.getElementById('total_pembayaran');
        const noPlatMobilSelect = document.getElementById('no_plat_mobil');
        
        // Update total pembayaran ketika jenis mobil dipilih
        jenisMobilSelect.addEventListener('change', function() {
            const selectedOption = jenisMobilSelect.options[jenisMobilSelect.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');
            totalPembayaranInput.value = harga ? harga : '';
        });

        // Update id_pelanggan ketika plat mobil dipilih
        noPlatMobilSelect.addEventListener('change', function() {
            const selectedOption = noPlatMobilSelect.options[noPlatMobilSelect.selectedIndex];
            const pelangganId = selectedOption.getAttribute('data-pelanggan-id');

            // Set ID pelanggan otomatis berdasarkan plat mobil
            document.getElementById('id_pelanggan').value = pelangganId;
        });
    });
</script>
@endsection
