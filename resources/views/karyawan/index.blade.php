@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Daftar Karyawan</h1>
    <a href="{{ url( 'karyawan/create') }}" class="btn btn-primary mb-3">Tambah</a>
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
                    <th>Nama Karyawan</th>
                    <th>No HP</th>
                    <th>Jumlah Mobil Dicuci</th>
                    <th>Jumlah Uang Dihasilkan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawan as $index => $k)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $k->nama_karyawan }}</td>
                    <td>{{ $k->no_hp }}</td>
                    <td>{{ $k->jumlah_mobil_dicuci ?? 0 }}</td> <!-- Tampilkan 0 jika null -->
                    <td>Rp {{ number_format($k->jumlah_uang_dihasilkan ?? 0, 2) }}</td> <!-- Tampilkan 0 jika null -->
                    <td>
                        <a href="{{ route('karyawan.edit', $k->id_karyawan) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('karyawan.destroy', $k->id_karyawan) }}" method="POST" style="display:inline;">
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