@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Daftar Harga</h1>
    <a href="{{ url('harga/create') }}" class="btn btn-primary mb-3">Tambah</a>
</div>

<!-- Menampilkan pesan sukses jika ada -->
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-striped" id="table1">
            <thead>
                <tr class="text-center"> <!-- Added text-center class here for the headers -->
                    <th>No</th>
                    <th>Jenis Mobil</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($harga as $index => $item)
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->jenis_mobil }}</td>
                    <td>Rp {{ number_format($item->harga, 3, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('harga.edit', $item->id_harga) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('harga.destroy', $item->id_harga) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
