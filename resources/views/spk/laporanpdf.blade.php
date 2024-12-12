<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan SPK</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Laporan Sistem Pendukung Keputusan</h1>
    <p>Periode: {{ $startDate }} - {{ $endDate }}</p>
    <table>
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Jumlah Mobil Dicuci</th>
                <th>Jumlah Uang Dihasilkan</th>
                <th>Skor</th>
                <th>Peringkat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporanSPK as $laporan)
            <tr>
                <td>{{ $laporan->karyawan->nama_karyawan }}</td>
                <td>{{ $laporan->jumlah_mobil_dicuci }}</td>
                <td>Rp {{ number_format($laporan->jumlah_uang_dihasilkan, 2, ',', '.') }}</td>
                <td>{{ number_format($laporan->skor, 3, ',', '.') }}</td>
                <td>{{ $laporan->peringkat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>