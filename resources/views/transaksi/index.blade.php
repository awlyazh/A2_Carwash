@extends('layouts.app')

@section('content')
    <h1>Daftar Transaksi</h1>

    <!-- Tombol Tambah Transaksi -->
    <a href="{{ url('transaksi/create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>

    <!-- Menampilkan pesan sukses jika ada -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Daftar Transaksi -->
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Plat Mobil</th>
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
                            <td>{{ $loop->iteration }}</td> <!-- Nomor urut -->
                            <td>{{ $item->no_plat_mobil }}</td>
                            <td>{{ ucfirst($item->metode_pembayaran) }}</td>
                            <td>{{ number_format($item->total_pembayaran, 2, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d-m-Y') }}</td> <!-- Format tanggal -->
                            <td>{{ ucfirst($item->status) }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <!-- Tombol Edit -->
                                    <a href="{{ url('transaksi/edit', ['transaksi' => $item->id_transaksi]) }}" class="btn btn-warning btn-sm mb-2" style="width: 100%;">Edit</a>
                                    
                                    <!-- Tombol Hapus -->
                                    <form action="{{ url('transaksi/destroy', ['transaksi' => $item->id_transaksi]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" style="width: 100%;" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
