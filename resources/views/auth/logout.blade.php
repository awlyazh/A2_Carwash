@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Logout</h3>
</div>
<div class="card">
    <div class="card-body text-center">
        <p>Apakah Anda yakin ingin logout?</p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            {{-- Tombol Konfirmasi Logout --}}
            <button type="submit" class="btn btn-danger">Logout</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-link text-danger">Logout</button>
</form>

@endsection