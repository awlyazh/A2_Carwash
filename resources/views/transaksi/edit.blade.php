@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Tambah Transaksi</h3>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            {{-- Select ID Pelanggan --}}
            <div class="mb-3">
                <label for="id_pelanggan" class="form-label">ID Pelanggan</label>
                <select class="form-control" id="id_pelanggan" name="id_pelanggan" required>
                    <option value="">Pilih Pelanggan</option>
                    @foreach ($pelanggan as $p)
                        <option value="{{ $p->id_pelanggan }}">{{ $p->nama }} (ID: {{ $p->id_pelanggan }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Select No Plat Mobil --}}
            <div class="mb-3">
                <label for="no_plat_mobil" class="form-label">No Plat Mobil</label>
                <select class="form-control" id="no_plat_mobil" name="no_plat_mobil" required>
                    <option value="">Pilih Mobil</option>
                    @foreach ($mobil as $m)
                        <option value="{{ $m->no_plat }}">{{ $m->no_plat }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Select ID Akun --}}
            <div class="mb-3">
                <label for="id_akun" class="form-label">ID Akun</label>
                <select class="form-control" id="id_akun" name="id_akun" required>
                    <option value="">Pilih Akun</option>
                    @foreach ($akun as $a)
                        <option value="{{ $a->id_akun }}">{{ $a->nama }} (ID: {{ $a->id_akun }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Input Tanggal Transaksi --}}
            <div class="mb-3">
                <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" required>
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
            </div>

            {{-- Input Total Pembayaran --}}
            <div class="mb-3">
                <label for="total_pembayaran" class="form-label">Total Pembayaran</label>
                <input type="number" step="0.01" class="form-control" id="total_pembayaran" name="total_pembayaran" required min="0">
            </div>

            {{-- Select Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="">Pilih Status</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
