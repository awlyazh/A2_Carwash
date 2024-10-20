@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Daftar Pelanggan</h1>
    <a href="{{ url( 'pelanggan/create') }}" class="btn btn-primary mb-3">Tambah</a>
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
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>No. Telepon</th>
                    <th>Nomor Plat Mobil</th>
                    <th>Nama Mobil</th>
                    <th>Jenis Mobil</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->no_hp }}</td>
                    <td>{{ $item->no_plat_mobil}}</td>
                    <td>{{ $item->nama_mobil }}</td>
                    <td>{{ $item->jenis_mobil }}</td>
                    <td>
                        <div class="d-flex flex-column">
                            <!-- Tombol Edit -->
                            <a href="{{ url('pelanggan/edit/'. $item->id_pelanggan) }}" class="btn btn-warning btn-sm mb-2" style="width: 100%;">Edit</a>

                            <!-- Tombol Hapus -->
                            <form action="{{ url('pelanggan/destroy', ['pengguna' => $item->id_pelanggan]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="width: 100%;" onclick="return confirm('Apakah Anda yakin ingin menghapus data pelanggan ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data pelanggan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection