@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Akun</h1>
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

                        <button class="btn btn-danger" onclick="confirmDelete({{ $item->id_akun }})">Hapus</button>

                        <form id="delete-form-{{ $item->id_akun }}" action="{{ route('akun.destroy', $item->id_akun) }}" method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    function confirmDelete(akunId) {
        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus data akun ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + akunId).submit();
            }
        });
    }
</script>

@endsection
