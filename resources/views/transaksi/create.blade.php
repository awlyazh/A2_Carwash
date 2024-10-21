@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Tambah Transaksi</h3>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            {{-- Select No Plat Mobil --}}
            <div class="mb-3">
                <label for="no_plat_mobil" class="form-label">No Plat Mobil</label>
                <select class="form-control" id="no_plat_mobil" name="no_plat_mobil" required>
                    <option value="">Pilih Mobil</option>
                    @foreach ($mobil as $m)
                    <option value="{{ $m->no_plat_mobil }}">{{ $m->no_plat_mobil }}</option>
                    @endforeach
                </select>
                @error('no_plat_mobil')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Tanggal Transaksi --}}
            <div class="mb-3">
                <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" required>
                @error('tanggal_transaksi')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Select Metode Pembayaran --}}
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                    <option value="">Pilih Metode Pembayaran</option>
                    <option value="cash">Cash</option>
                    <option value="transfer bank">Transfer Bank</option>
                    <option value="qris">QRIS</option>
                </select>
                @error('metode_pembayaran')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Total Pembayaran --}}
            <div class="mb-3">
                <label for="total_pembayaran" class="form-label">Total Pembayaran</label>
                <input type="number" step="0.01" class="form-control" id="total_pembayaran" name="total_pembayaran" required min="0">
                @error('total_pembayaran')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Select Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="">Pilih Status</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ url('transaksi') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
