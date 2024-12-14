@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Daftar Transaksi</h1>
    <a href="{{ url('transaksi/create') }}" class="btn btn-primary mb-3">Tambah</a>
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
                    <th>Pelanggan</th>
                    <th>Plat Mobil</th>
                    <th>Nama Mobil</th>
                    <th>Jenis Mobil</th>
                    <th>Harga</th>
                    <th>Nama Karyawan</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi as $index => $t)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $t->pelanggan->nama ?? '-' }}</td>
                    <td>{{ $t->no_plat_mobil ?? '-' }}</td>
                    <td>{{ $t->mobil->nama_mobil ?? '-' }}</td>
                    <td>{{ $t->mobil->jenis_mobil ?? '-' }}</td>
                    <td>Rp {{ number_format($t->mobil->harga->harga ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $t->karyawan->nama_karyawan ?? '-' }}</td>
                    <td>{{ ucfirst($t->metode_pembayaran) }}</td>
                    <td>
                        <span class="badge bg-{{ $t->status == 'selesai' ? 'success' : 'danger' }}">
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>
                    <td>
                        <!-- Tombol Edit -->
                        <a href="{{ route('transaksi.edit', $t->id_transaksi) }}" class="btn btn-warning mb-1" style="width: 100%;">Edit</a>

                        <!-- Tombol Kirim WhatsApp -->
                        @php
                        $whatsappSentFile = storage_path('app/whatsapp_sent.json');
                        $whatsappSent = file_exists($whatsappSentFile) ? json_decode(file_get_contents($whatsappSentFile), true) : [];
                        @endphp

                        @if(in_array($t->id_transaksi, $whatsappSent))
                        <button class="btn btn-secondary mb-1" style="width: 100%;" disabled>WhatsApp Sudah Dikirim</button>
                        @elseif($t->pelanggan && $t->pelanggan->no_hp)
                        <form action="{{ route('transaksi.kirimWhatsapp', $t->id_transaksi) }}" method="POST" style="width: 100%;">
                            @csrf
                            <button type="submit" class="btn btn-success mb-1" style="width: 100%;">WhatsApp</button>
                        </form>
                        @else
                        <button class="btn btn-secondary mb-1" style="width: 100%;" disabled>WhatsApp Tidak Tersedia</button>
                        @endif

                        <!-- Tombol Hapus -->
                        <form action="{{ route('transaksi.destroy', $t->id_transaksi) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');" style="width: 100%;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="width: 100%;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection