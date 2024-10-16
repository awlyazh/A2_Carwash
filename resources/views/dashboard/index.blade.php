@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h1>Statistik Pelanggan</h1>
</div>

<!-- Menampilkan statistik pelanggan -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <!-- Total Pelanggan -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h4 class="card-title">Total Pelanggan</h4>
                        <p class="card-text">{{ $totalPelanggan }}</p>
                    </div>
                </div>
            </div>

            <!-- Pelanggan Baru Minggu Ini -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h4 class="card-title">Pelanggan Baru (Minggu Ini)</h4>
                        <p class="card-text">{{ $pelangganBaru }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Pelanggan Terbaru -->
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Pelanggan Terbaru</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Waktu Ditambahkan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pelangganTerbaru as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td> <!-- Nomor urut -->
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->no_hp }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td> <!-- Format tanggal -->
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada pelanggan terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
