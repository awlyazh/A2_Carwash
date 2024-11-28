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
