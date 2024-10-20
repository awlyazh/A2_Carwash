@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Edit Transaksi</h3>
</div>

<div class="card">
    <div class="card-body">
        <!-- Form untuk mengedit transaksi -->
        <form action="{{ route('transaksi.update', $transaksi->id_transaksi) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Select No Plat Mobil --}}
            <div class="mb-3">
                <label for="no_plat_mobil" class="form-label">No Plat Mobil</label>
                <select class="form-control" id="no_plat_mobil" name="no_plat_mobil" required>
                    <option value="">Pilih Mobil</option>
                    @foreach ($mobil as $m)
                    <option value="{{ $m->no_plat_mobil }}" {{ $transaksi->no_plat_mobil == $m->no_plat_mobil ? 'selected' : '' }}>
                        {{ $m->no_plat_mobil }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Input Tanggal Transaksi --}}
            <div class="mb-3">
                <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" value="{{ $transaksi->tanggal_transaksi }}" required>
            </div>

            {{-- Select Metode Pembayaran --}}
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                    <option value="cash" {{ $transaksi->metode_pembayaran == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="transfer bank" {{ $transaksi->metode_pembayaran == 'transfer bank' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="qris" {{ $transaksi->metode_pembayaran == 'qris' ? 'selected' : '' }}>QRIS</option>
                </select>
            </div>

            {{-- Input Total Pembayaran --}}
            <div class="mb-3">
                <label for="total_pembayaran" class="form-label">Total Pembayaran</label>
                <input type="number" step="0.01" class="form-control" id="total_pembayaran" name="total_pembayaran" value="{{ $transaksi->total_pembayaran }}" required min="0">
            </div>

            {{-- Select Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ $transaksi->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ url('transaksi') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection