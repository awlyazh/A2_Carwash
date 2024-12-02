@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Sistem Pendukung Keputusan (SPK)</h1>
</div>
<div class="card">
    <div class="card-body">

        <!-- Filter Rentang Tanggal -->
        <form method="GET" action="{{ route('spk.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <label for="start_date">Mulai Tanggal:</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" onchange="this.form.submit()">
                </div>
                <div class="col-md-6">
                    <label for="end_date">Sampai Tanggal:</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" onchange="this.form.submit()">
                </div>
            </div>
        </form>

        @if ($startDate && $endDate)
        <div>
            <h3>Data Karyawan</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama Karyawan</th>
                        <th>Jumlah Mobil Dicuci</th>
                        <th>Jumlah Uang Dihasilkan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawan as $k)
                    <tr>
                        <td>{{ $k->nama_karyawan }}</td>
                        <td>{{ $k->jumlah_mobil_dicuci }}</td>
                        <td>Rp {{ number_format($k->jumlah_uang_dihasilkan, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tombol Hitung Bobot AHP -->
        <button id="hitungAHPButton" class="btn btn-primary">Hitung Bobot AHP</button>

        <!-- Div untuk hasil AHP -->
        <div id="ahpResult" class="mt-4" style="display: none;">
            <h3>Bobot AHP</h3>
            <ul id="bobotAHPList"></ul>

            <!-- Tombol Hitung SAW -->
            <form method="POST" action="{{ route('spk.hitungSAW') }}">
                @csrf
                <input type="hidden" name="start_date" value="{{ $startDate }}">
                <input type="hidden" name="end_date" value="{{ $endDate }}">
                <button type="submit" class="btn btn-success">Hitung SAW</button>
            </form>
        </div>
        @endif
    </div>
</div>

<script>
    document.getElementById('hitungAHPButton').addEventListener('click', function() {
        fetch('{{ route("spk.hitungAHP") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    start_date: '{{ $startDate }}',
                    end_date: '{{ $endDate }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Tampilkan hasil AHP
                    const bobotList = document.getElementById('bobotAHPList');
                    bobotList.innerHTML = ''; // Kosongkan daftar
                    data.bobot.forEach((bobot, index) => {
                        const li = document.createElement('li');
                        li.textContent = `Kriteria ${index + 1}: ${bobot.toFixed(3)}`;
                        bobotList.appendChild(li);
                    });

                    // Tampilkan div hasil AHP
                    document.getElementById('ahpResult').style.display = 'block';
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>
@endsection