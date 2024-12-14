@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h1>Laporan Transaksi</h1>
</div>

<div class="card">
    <div class="card-body">
    <div class="mt-3 mb-3 d-flex justify-content-between">
            <div class="d-flex justify-content-start">
                <p><strong>Tanggal Awal:</strong> {{ $tanggal_awal }}</p>
                <p><strong> Tanggal Akhir:</strong> {{ $tanggal_akhir }}</p>
            </div>
            <a href="{{ url('/laporan/download/' . $tanggal_awal . '/' . $tanggal_akhir) }}"
                class="btn btn-success">
                Download PDF
            </a>
        </div>

        @if($posts->isEmpty())
        <div class="alert alert-info">Tidak ada data transaksi pada rentang tanggal ini.</div>
        @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Nomor Plat Mobil</th>
                    <th>Nama Mobil</th>
                    <th>Harga</th>
                    <th>Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $index => $post)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $post->pelanggan->nama ?? '-' }}</td>
                    <td>{{ $post->mobil->no_plat_mobil ?? $post->no_plat_mobil ?? '-' }}</td>
                    <td>{{ $post->mobil->nama_mobil ?? '-' }}</td>
                    <td>Rp {{ number_format($post->mobil->harga->harga ?? 0, 2, ',', '.') }}</td>
                    <td>{{ $post->tanggal_transaksi }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif


    </div>
</div>

@endsection