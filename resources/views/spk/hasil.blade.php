@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mt-2">
            <h1>Hasil Sistem Pendukung Keputusan (SPK)</h1>

            <!-- Tambahkan Tombol Cetak -->
            <a class="btn btn-primary mb-3"
                href="{{ route('spk.cetak', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                target="_blank">Cetak</a>
        </div>
        <p>Periode: {{ $startDate ?? '-' }} - {{ $endDate ?? '-' }}</p>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama Karyawan</th>
                    <th>Jumlah Mobil Dicuci</th>
                    <th>Jumlah Uang Dihasilkan</th>
                    <th>Skor</th>
                    <th>Peringkat</th>
                </tr>
            </thead>
            <tbody>
                @php
                $peringkat = 1;
                @endphp
                @foreach ($hasil as $data)
                <tr>
                    <td>{{ $data['karyawan']->nama_karyawan }}</td>
                    <td>{{ $data['total_mobil_dicuci'] }}</td>
                    <td>Rp {{ number_format($data['total_uang_dihasilkan'], 2, ',', '.') }}</td>
                    <td>{{ number_format($data['skor'], 3, ',', '.') }}</td>
                    <td>{{ $peringkat++ }}</td> <!-- Peringkat berdasarkan urutan -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection