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
                        @if($t->pelanggan && $t->pelanggan->no_hp)
                        @php
                        // Format nomor telepon menjadi internasional
                        $noHp = ltrim($t->pelanggan->no_hp, '0'); // Hilangkan 0 di depan nomor telepon
                        $noHpInternational = "62" . $noHp; // Tambahkan kode negara Indonesia

                        // Buat pesan untuk WhatsApp
                        $pesan = "Halo {$t->pelanggan->nama}, transaksi Anda untuk mobil {$t->mobil->nama_mobil} telah selesai. Total harga: Rp " . number_format($t->mobil->harga->harga ?? 0, 0, ',', '.') . ". Terima kasih telah menggunakan layanan kami!";
                        $pesanTerencode = urlencode($pesan); // Encode pesan untuk URL
                        @endphp

                        <!-- Form Kirim WhatsApp -->
                        <form action="{{ route('transaksi.kirimWhatsapp', $t->id_transaksi) }}" method="POST" style="width: 100%;">
                            @csrf
                            <button type="submit" class="btn btn-success mb-1" style="width: 100%;">Kirim WhatsApp</button>
                        </form>

                        @else
                        <!-- Jika nomor telepon tidak tersedia -->
                        <button class="btn btn-secondary mb-1" style="width: 100%;" disabled>WhatsApp Tidak Tersedia</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
