@extends('layouts.auth')

@section('content')
<div id="auth">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-12 mx-auto">
                <div class="card pt-4">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h3>Login</h3>
                            <p>Masukkan username atau email dan password Anda.</p>
                        </div>

                        <form action="{{ route('login') }}" method="POST">
                            @csrf <!-- Token CSRF untuk keamanan -->

                            <!-- Validasi Username atau Email -->
                            <div class="form-group position-relative has-icon-left">
                                <label for="login">Username atau Email</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control" id="login" name="login" value="{{ old('login') }}"
                                        required minlength="5" maxlength="50"
                                        pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}|[a-zA-Z0-9_-]{3,}$"
                                        title="Masukkan username atau email yang valid.">
                                    <div class="form-control-icon">
                                        <i data-feather="user"></i>
                                    </div>
                                </div>
                                @error('login')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Validasi Password -->
                            <div class="form-group position-relative has-icon-left">
                                <div class="clearfix">
                                    <label for="password">Password</label>
                                </div>
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

                            <div class="clearfix mt-4">
                                <button class="btn btn-primary float-right">Login</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection