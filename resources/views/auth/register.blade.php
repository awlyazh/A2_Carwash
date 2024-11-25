@extends('layouts.auth')

@section('content')
<div id="auth">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-12 mx-auto">
                <div class="card pt-4">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h3>Register</h3>
                            <p>Daftarkan akun Anda untuk melanjutkan.</p>
                        </div>

                        <!-- Tampilkan pesan error -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register.store') }}" method="POST">
                            @csrf <!-- Token CSRF untuk keamanan -->

                            <!-- Input Username -->
                            <div class="form-group position-relative has-icon-left">
                                <label for="username">Username</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control" id="username" name="username" 
                                        value="{{ old('username') }}" required minlength="3" maxlength="50"
                                        pattern="[a-zA-Z0-9_-]+" 
                                        title="Username hanya boleh mengandung huruf, angka, tanda hubung (-), atau garis bawah (_).">
                                    <div class="form-control-icon">
                                        <i data-feather="user"></i>
                                    </div>
                                </div>
                                @error('username')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Input Email -->
                            <div class="form-group position-relative has-icon-left">
                                <label for="email">Email</label>
                                <div class="position-relative">
                                    <input type="email" class="form-control" id="email" name="email" 
                                        value="{{ old('email') }}" required 
                                        title="Masukkan email yang valid.">
                                    <div class="form-control-icon">
                                        <i data-feather="mail"></i>
                                    </div>
                                </div>
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Input Password -->
                            <div class="form-group position-relative has-icon-left">
                                <label for="password">Password</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="password" name="password" 
                                        required minlength="8" maxlength="255"
                                        title="Password minimal 8 karakter.">
                                    <div class="form-control-icon">
                                        <i data-feather="lock"></i>
                                    </div>
                                </div>
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="form-group position-relative has-icon-left">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="password_confirmation" 
                                        name="password_confirmation" required minlength="8" maxlength="255"
                                        title="Konfirmasi password harus sesuai dengan password dan minimal 8 karakter.">
                                    <div class="form-control-icon">
                                        <i data-feather="lock"></i>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <!-- Pilihan Posisi -->
                            <div class="form-group position-relative has-icon-left">
                                <label for="posisi">Posisi</label>
                                <div class="position-relative">
                                    <select id="posisi" name="posisi" class="form-control" required>
                                        <option value="">Pilih Posisi</option>
                                        <option value="admin" {{ old('posisi') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="karyawan" {{ old('posisi') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                                    </select>
                                    <div class="form-control-icon">
                                        <i data-feather="briefcase"></i>
                                    </div>
                                </div>
                                @error('posisi')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Tombol Register -->
                            <div class="clearfix mt-4">
                                <button class="btn btn-primary float-right">Register</button>
                            </div>
                        </form>

                        <p class="text-center mt-3">
                            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
