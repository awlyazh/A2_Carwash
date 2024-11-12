@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h1>Daftar Transaksi</h1>
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary mb-3">Tambah</a>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-striped" id="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>No Plat Mobil</th>
                    <th>Jenis Mobil</th>
                    <th>Metode Pembayaran</th>
                    <th>Total Pembayaran</th>
                    <th>Tanggal Transaksi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <!-- Nama Pelanggan -->
                    <td>{{ $item->pelanggan ? $item->pelanggan->nama : 'Pelanggan tidak tersedia' }}</td>

                    <!-- No Plat Mobil -->
                    <td>{{ $item->no_plat_mobil }}</td>

                    <!-- Jenis Mobil -->
                    <td>{{ $item->mobil ? ucfirst($item->mobil->jenis_mobil) : 'Jenis mobil tidak tersedia' }}</td>

                    <!-- Metode Pembayaran -->
                    <td>{{ ucfirst($item->metode_pembayaran) }}</td>

                    <!-- Total Pembayaran -->
                    <td>{{ number_format($item->total_pembayaran, 2, ',', '.') }}</td>

                    <!-- Tanggal Transaksi -->
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d-m-Y') }}</td>

                    <!-- Status -->
                    <td>{{ ucfirst($item->status) }}</td>

                    <td>
                        <div class="d-flex flex-column">
                            <a href="{{ route('transaksi.edit', $item->id_transaksi) }}" class="btn btn-warning btn-sm mb-2" style="width: 100%;">Edit</a>
                            <form action="{{ route('transaksi.destroy', $item->id_transaksi) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="width: 100%;" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection