<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan SPK</title>
</head>

<body>
    <h1>Laporan Sistem Pendukung Keputusan</h1>
    <p>Periode: {{ $startDate ?? '-' }} - {{ $endDate ?? '-' }}</p>
    <table border="1" cellspacing="0" cellpadding="8" width="100%">
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
                <td>{{ $data['karyawan'] }}</td>
                <td>{{ $data['jumlah_mobil_dicuci'] }}</td>
                <td>Rp {{ number_format($data['jumlah_uang_dihasilkan'], 2, ',', '.') }}</td>
                <td>{{ number_format($data['skor'], 3, ',', '.') }}</td>
                <td>{{ $peringkat++ }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>