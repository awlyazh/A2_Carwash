@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Harga</h1>
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
        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection
