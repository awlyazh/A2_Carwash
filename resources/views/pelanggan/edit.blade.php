@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <h3>Edit Pelanggan</h3>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Input Nama Pelanggan --}}
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $pelanggan->nama) }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input No. Telepon --}}
            <div class="mb-3">
                <label for="no_hp" class="form-label">No. Telepon</label>
                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $pelanggan->no_hp) }}" required pattern="[0-9\s]+" title="Hanya angka yang diperbolehkan">
                @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Nomor Plat Mobil --}}
            <div class="mb-3">
                <label for="no_plat_mobil" class="form-label">Nomor Plat Mobil</label>
                <input type="text" class="form-control @error('no_plat_mobil') is-invalid @enderror" id="no_plat_mobil" name="no_plat_mobil" value="{{ old('no_plat_mobil', optional($pelanggan->mobil->first())->no_plat_mobil) }}" required>
                @error('no_plat_mobil')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Dropdown Nama Mobil --}}
            <div class="mb-3">
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <select class="form-select @error('nama_mobil') is-invalid @enderror" id="nama_mobil" name="nama_mobil" required>
                    <option value="" disabled>Pilih Nama Mobil</option>
                    <option value="add_new" {{ old('nama_mobil') === 'add_new' ? 'selected' : '' }}>Tambah Nama Mobil Baru</option>
                    @foreach($mobil as $item)
                        <option value="{{ $item->nama_mobil }}" {{ old('nama_mobil', optional($pelanggan->mobil->first())->nama_mobil) === $item->nama_mobil ? 'selected' : '' }}>{{ $item->nama_mobil }}</option>
                    @endforeach
                </select>
                @error('nama_mobil')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Manual Nama Mobil (Hidden by Default) --}}
            <div class="mb-3 {{ old('nama_mobil') === 'add_new' ? '' : 'd-none' }}" id="nama_mobil_manual_container">
                <label for="nama_mobil_manual" class="form-label">Masukkan Nama Mobil Baru</label>
                <input type="text" class="form-control @error('nama_mobil_manual') is-invalid @enderror" id="nama_mobil_manual" name="nama_mobil_manual" value="{{ old('nama_mobil_manual') }}" placeholder="Masukkan nama mobil baru" {{ old('nama_mobil') === 'add_new' ? 'required' : '' }}>
                @error('nama_mobil_manual')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Dropdown Jenis Mobil --}}
            <div class="mb-3">
                <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                <select class="form-select @error('jenis_mobil') is-invalid @enderror" id="jenis_mobil" name="jenis_mobil" required>
                    <option value="">Pilih Jenis Mobil</option>
                    @foreach($harga as $item)
                        <option value="{{ $item->jenis_mobil }}" {{ old('jenis_mobil', $pelanggan->mobil->first()->jenis_mobil) === $item->jenis_mobil ? 'selected' : '' }}>
                            {{ ucfirst($item->jenis_mobil) }}
                        </option>
                    @endforeach
                </select>
                @error('jenis_mobil')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input Harga (Readonly) --}}
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga" readonly placeholder="Harga otomatis muncul berdasarkan jenis mobil">
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
    // Ambil data harga dari controller ke JavaScript
    var hargaData = @json($harga);

    // Update harga berdasarkan jenis mobil yang dipilih
    document.getElementById('jenis_mobil').addEventListener('change', function () {
        var hargaInput = document.getElementById('harga');
        var jenisMobil = this.value;

        var selectedHarga = hargaData.find(item => item.jenis_mobil === jenisMobil);

        hargaInput.value = selectedHarga ? 
            "Rp " + parseInt(selectedHarga.harga).toLocaleString('id-ID') : 
            ""; // Kosongkan jika harga tidak ditemukan
    });

    // Tampilkan input manual jika "Tambah Nama Mobil Baru" dipilih
    document.getElementById('nama_mobil').addEventListener('change', function () {
        var manualInputContainer = document.getElementById('nama_mobil_manual_container');
        var manualInput = document.getElementById('nama_mobil_manual');
        var namaMobilSelect = this.value;

        if (namaMobilSelect === "add_new") {
            manualInputContainer.classList.remove('d-none');
            manualInput.required = true; // Tambahkan 'required'
        } else {
            manualInputContainer.classList.add('d-none');
            manualInput.required = false; // Hapus 'required'
        }
    });

    // Sebelum mengirim form, pastikan jika nama mobil baru dimasukkan, kita kirimkan manual input
    document.querySelector("form").addEventListener("submit", function(event) {
        var namaMobilSelect = document.getElementById('nama_mobil').value;
        var namaMobilManual = document.getElementById('nama_mobil_manual').value.trim();

        if (namaMobilSelect === "add_new" && namaMobilManual !== "") {
            document.getElementById('nama_mobil').value = namaMobilManual; // Ganti dengan input manual
        }

        // Validasi harga tidak boleh kosong
        var hargaInput = document.getElementById('harga').value.trim();
        if (!hargaInput) {
            event.preventDefault(); // Blokir pengiriman form
            alert("Harga tidak boleh kosong. Pilih jenis mobil yang valid."); // Tampilkan pesan error
        }
    });
</script>
@endsection
