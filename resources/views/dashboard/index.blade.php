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
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3'>
                                <h3 class='card-title'>Total Pelanggan</h3>
                                <div class="card-right mt-2">
                                    <p>{{ $totalPelanggan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pelanggan Baru Bulan Ini -->
            <div class="col-12 col-md-4">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3'>
                                <h3 class='card-title'>Pelanggan Baru (Bulan Ini)</h3>
                                <div class="card-right mt-2">
                                    <p>{{ $pelangganBaru }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Pelanggan Terbaru -->
<div class="card">
    <div class="card-body">
        <h2 class="mt-2 mb-3">Pelanggan Terbaru</h2>
        <table class="table table-striped" id="table1">
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