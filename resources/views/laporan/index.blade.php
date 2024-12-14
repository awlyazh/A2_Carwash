@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h1>Cetak Laporan</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" class="form-control" id="tanggal_awal" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggal_akhir" required>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <!-- Tombol Cetak -->
                <a class="btn btn-primary"
                    onclick="navigateToCetak()">Cetak</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h1 class="mb-3 mt-1">Daftar Transaksi</h1>
        <table class="table table-striped" id="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pelanggan</th>
                    <th>Plat Mobil</th>
                    <th>Nama Mobil</th>
                    <th>Jenis Mobil</th>
                    <th>Harga</th>
                    <th>Nama Karyawan</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi as $index => $t)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $t->pelanggan->nama ?? '-' }}</td>
                    <td>{{ $t->no_plat_mobil ?? '-' }}</td>
                    <td>{{ $t->mobil->nama_mobil ?? '-' }}</td>
                    <td>{{ $t->mobil->harga->jenis_mobil ?? '-' }}</td>
                    <td>Rp {{ number_format($t->mobil->harga->harga ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $t->karyawan->nama_karyawan ?? '-' }}</td>
                    <td>{{ ucfirst($t->metode_pembayaran) }}</td>
                    <td>
                        <span class="badge bg-{{ $t->status == 'selesai' ? 'success' : 'danger' }}">
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function navigateToCetak() {
        const tanggalAwal = document.getElementById('tanggal_awal').value;
        const tanggalAkhir = document.getElementById('tanggal_akhir').value;

        if (!tanggalAwal || !tanggalAkhir) {
            alert('Harap isi tanggal awal dan tanggal akhir.');
            return;
        }

        window.location.href = `/laporan/cetak/${tanggalAwal}/${tanggalAkhir}`;
    }
</script>

@endsection