@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mt-2">
            <h1>Hasil Sistem Pendukung Keputusan (SPK)</h1>

            <div class="d-flex justify-content-end">
                <!-- Tombol Cetak -->
                <a class="btn btn-primary mb-3 mr-2"
                    href="{{ route('spk.cetak', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                    target="_blank">Unduh</a>
    
                <!-- Tombol Simpan -->
                <form action="{{ route('spk.simpan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="start_date" value="{{ $startDate }}">
                    <input type="hidden" name="end_date" value="{{ $endDate }}">
                    <input type="hidden" name="hasil" value="{{ json_encode($hasil) }}">
                    <button type="submit" class="btn btn-success mb-3">Simpan</button>
                </form>
            </div>
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
                    <td>{{ $data['karyawan'] }}</td>
                    <td>{{ $data['jumlah_mobil_dicuci'] }}</td>
                    <td>Rp {{ number_format($data['jumlah_uang_dihasilkan'], 2, ',', '.') }}</td>
                    <td>{{ isset($data['skor']) ? number_format($data['skor'], 3, ',', '.') : '-' }}</td>
                    <td>{{ $peringkat++ }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
