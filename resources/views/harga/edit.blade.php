@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h1>Tambah Harga</h1>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('harga.update', $harga->id_harga) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                <input type="text" name="jenis_mobil" class="form-control" id="jenis_mobil" value="{{ $harga->jenis_mobil }}" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" id="harga" value="{{ $harga->harga }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('harga.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection