@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h1>Daftar Akun</h1>
    <a href="{{ route('akun.create') }}" class="btn btn-primary mb-3">Tambah</a>
</div>

<!-- Menampilkan pesan sukses jika ada -->
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- Tabel Daftar Akun -->
<div class="card">
    <div class="card-body">
        <table class="table table-striped" id="table1">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Posisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($akun as $item)
                <tr>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->posisi }}</td>
                    <td>
                        <div class="d-flex flex-column">
                            <!-- Tombol Edit -->
                            <a href="{{ route('akun.edit', $item->id_akun) }}" class="btn btn-warning btn-sm w-50 mb-2" role="button">Edit</a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('akun.destroy', $item->id_akun) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-50" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection