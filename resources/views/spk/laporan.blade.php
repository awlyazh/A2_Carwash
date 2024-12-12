@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Laporan SPK</h1>
</div>
<div class="card">
    <div class="card-body">

        <!-- Tabel Laporan SPK -->
        @if ($laporanSPK->count() > 0)
        <table class="table table-striped" id="table1">
            <thead>
                <tr>
                    <th>Nama Karyawan</th>
                    <th>Jumlah Mobil Dicuci</th>
                    <th>Jumlah Uang Dihasilkan</th>
                    <th>Skor</th>
                    <th>Peringkat</th>
                    <th>Periode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanSPK as $laporan)
                <tr>
                    <td>{{ $laporan->karyawan->nama_karyawan }}</td>
                    <td>{{ $laporan->jumlah_mobil_dicuci }}</td>
                    <td>Rp {{ number_format($laporan->jumlah_uang_dihasilkan, 2, ',', '.') }}</td>
                    <td>{{ number_format($laporan->skor, 3, ',', '.') }}</td>
                    <td>{{ $laporan->peringkat }}</td>
                    <td>{{ $laporan->tanggal_periode_start }} - {{ $laporan->tanggal_periode_end }}</td>
                    <td>
                        <!-- Tombol Lihat PDF -->
                        <a href="{{ route('spk.lihat', ['start_date' => $laporan->tanggal_periode_start, 'end_date' => $laporan->tanggal_periode_end]) }}"
                            class="btn btn-primary btn-sm"  target="_blank">Detail</a>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('spk.hapus') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="start_date" value="{{ $laporan->tanggal_periode_start }}">
                            <input type="hidden" name="end_date" value="{{ $laporan->tanggal_periode_end }}">
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus data untuk periode ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $laporanSPK->links() }}
        </div>
        @else
        <p class="text-center">Tidak ada data laporan SPK untuk periode ini.</p>
        @endif
    </div>
</div>
@endsection
