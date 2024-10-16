@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Akun List</h1>
    <a href="{{ route('akun.create') }}" class="btn btn-primary">Tambah Akun</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
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
                        <a href="{{ route('akun.edit', $item->id_akun) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('akun.destroy', $item->id_akun) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
