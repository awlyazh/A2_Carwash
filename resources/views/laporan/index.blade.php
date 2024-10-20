@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h1>Cetak Laporan</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div class="col-6 mb-3">
                <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" required>
            </div>
            <div class="col-6 mb-3 px-1">
                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" required>
            </div>
        </div>

        <a target="_blank" onclick="this.href='/laporan/cetak/'+ document.getElementById('tanggal_awal').value + '/'+ document.getElementById('tanggal_akhir').value" href="{{ url('cetak') }}" class="btn btn-primary">Cetak</a>
    </div>
</div>

@endsection