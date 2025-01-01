@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Sistem Pendukung Keputusan (SPK)</h1>
</div>
<!-- Notifikasi Pesan -->
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
</div>
@endif
<div class="card">
    <div class="card-body">

        <!-- Filter Rentang Tanggal -->
        <form id="filter-form" method="GET" action="{{ route('spk.index') }}">
            <div class="row">
                <div class="col-md-6">
                    <label for="start_date">Tanggal Awal:</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date', $startDate ?? '') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="end_date">Tanggal Akhir:</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date', $endDate ?? '') }}" class="form-control">
                </div>
            </div>
        </form>

        <!-- Input Nilai Perbandingan Kriteria -->
        <div class="mt-4">
            <h3>Input Nilai Perbandingan AHP</h3>
            <form id="form-ahp">
                <div class="form-group">
                    <label for="nilai_1_2">Perbandingan Kriteria 1 dan Kriteria 2:</label>
                    <input type="number" step="0.01" id="nilai_1_2" class="form-control" placeholder="Masukkan nilai perbandingan">
                </div>
                <button type="button" id="hitungAHPButton" class="btn btn-primary mt-2">Hitung AHP</button>
            </form>
        </div>

        <!-- Hasil Matriks Perbandingan -->
        <div id="matriksPerbandingan" class="mt-4" style="display: none;">
            <h3>Hasil Matriks Perbandingan</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        <th>Kriteria 1</th>
                        <th>Kriteria 2</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Kriteria 1</th>
                        <td id="matriks_1_1"></td>
                        <td id="matriks_1_2"></td>
                    </tr>
                    <tr>
                        <th>Kriteria 2</th>
                        <td id="matriks_2_1"></td>
                        <td id="matriks_2_2"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Hasil Bobot AHP -->
        <div id="ahpResult" class="mt-4" style="display: none;">
            <h3>Bobot AHP</h3>
            <ul id="bobotAHPList"></ul>
        </div>

        <!-- Hitung SAW -->
        <form method="POST" action="{{ route('spk.hitungSAW') }}" id="form-saw" style="display: none;">
            @csrf
            <input type="hidden" name="start_date" value="{{ request('start_date', $startDate ?? '') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date', $endDate ?? '') }}">
            <button type="submit" class="btn btn-success mt-3">Hitung SAW</button>
        </form>
    </div>
</div>

<script>
    // Monitor perubahan input tanggal awal dan akhir
    document.getElementById('start_date').addEventListener('change', function() {
        document.getElementById('filter-form').submit();
    });

    document.getElementById('end_date').addEventListener('change', function() {
        document.getElementById('filter-form').submit();
    });

    // Tombol untuk menghitung AHP
    document.getElementById('hitungAHPButton').addEventListener('click', function() {
        const nilai_1_2 = document.getElementById('nilai_1_2').value;

        if (!nilai_1_2) {
            alert("Masukkan nilai perbandingan kriteria!");
            return;
        }

        // Lakukan fetch untuk menghitung AHP
        fetch('{{ route("spk.hitungAHP") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    nilai_1_2: nilai_1_2
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Tampilkan matriks perbandingan
                    document.getElementById('matriksPerbandingan').style.display = 'block';
                    document.getElementById('matriks_1_1').textContent = '1';
                    document.getElementById('matriks_1_2').textContent = nilai_1_2;
                    document.getElementById('matriks_2_1').textContent = (1 / nilai_1_2).toFixed(3);
                    document.getElementById('matriks_2_2').textContent = '1';

                    // Tampilkan bobot AHP
                    const bobotList = document.getElementById('bobotAHPList');
                    bobotList.innerHTML = ''; // Kosongkan daftar
                    data.bobot.forEach((bobot, index) => {
                        const li = document.createElement('li');
                        li.textContent = `Kriteria ${index + 1}: ${bobot.toFixed(3)}`;
                        bobotList.appendChild(li);
                    });
                    document.getElementById('ahpResult').style.display = 'block';

                    // Tampilkan tombol Hitung SAW
                    document.getElementById('form-saw').style.display = 'block';
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>
@endsection