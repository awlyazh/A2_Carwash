<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
        }

        .mb-3 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-between mb-3">
        <h1>Daftar Transaksi</h1>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Plat Mobil</th>
                <th>Metode Pembayaran</th>
                <th>Total Pembayaran</th>
                <th>Tanggal Transaksi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cetak as $item)
            <tr>
                <td>{{ $loop->iteration }}</td> <!-- Nomor urut -->
                <td>{{ $item->no_plat_mobil }}</td>
                <td>{{ ucfirst($item->metode_pembayaran) }}</td>
                <td>{{ number_format($item->total_pembayaran, 2, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d-m-Y') }}</td> <!-- Format tanggal -->
                <td>{{ ucfirst($item->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <script type="text/javascript">
        window.print();
    </script>
</body>

</html>