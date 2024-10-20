@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Tambah Pelanggan</h3>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ url('pelanggan/store') }}" method="POST">
            @csrf

            {{-- Input Nama Pelanggan --}}
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            {{-- Input No. Telepon --}}
            <div class="mb-3">
                <label for="no_hp" class="form-label">No. Telepon</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" required pattern="[0-9\s]+" title="Hanya angka yang diperbolehkan">
            </div>


            <div class="mb-3">
                <label for="no_plat_mobil" class="form-label">Nomor Plat Mobil</label>
                <input type="text" class="form-control" id="no_plat_mobil" name="no_plat_mobil" required>
            </div>

            <div class="mb-3">
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <input type="text" class="form-control" id="nama mobil" name="nama mobil" required >
            </div>

            <div class="mb-3">
                <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                <input type="text" class="form-control" id="jenis_mobil" name="jenis_mobil" required >
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ url('pelanggan') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection