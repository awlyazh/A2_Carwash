<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan SPK</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 8px;
        }
    </style>
</head>

<body>
    <h2>Laporan Sistem Pendukung Keputusan (SPK)</h2>
    <p>Periode: {{ $startDate ?? '-' }} - {{ $endDate ?? '-' }}</p>

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
            @php $peringkat = 1; @endphp
            @foreach ($hasil as $data)
            <tr>
                <td>{{ $data['karyawan']->nama_karyawan }}</td>
                <td>{{ $data['total_mobil_dicuci'] }}</td>
                <td>Rp {{ number_format($data['total_uang_dihasilkan'], 2, ',', '.') }}</td>
                <td>{{ number_format($data['skor'], 3, ',', '.') }}</td>
                <td>{{ $peringkat++ }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>