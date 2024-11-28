<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Laporan Transaksi</h1>
    <p><strong>Tanggal Awal:</strong> {{ $tanggal_awal }}</p>
    <p><strong>Tanggal Akhir:</strong> {{ $tanggal_akhir }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Nomor Plat Mobil</th>
                <th>Nama Mobil</th>
                <th>Harga</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $index => $post)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $post->pelanggan->nama ?? '-' }}</td>
                <td>{{ $post->mobil->no_plat_mobil ?? $post->no_plat_mobil ?? '-' }}</td>
                <td>{{ $post->mobil->nama_mobil ?? '-' }}</td>
                <td>Rp {{ number_format($post->mobil->harga->harga ?? 0, 2, ',', '.') }}</td>
                <td>{{ $post->tanggal_transaksi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
