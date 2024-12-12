<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A2 Carwash</title>
    <link rel="stylesheet" href="{{ asset('voler/dist/assets/vendors/simple-datatables/style.css')}}">
    <link rel="stylesheet" href="{{ asset('voler/dist/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('voler/dist/assets/vendors/chartjs/Chart.min.css')}}">
    <link rel="stylesheet" href="{{ asset('voler/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{ asset('voler/dist/assets/css/app.css')}}">
    <link rel="shortcut icon" href="{{ asset('voler/dist/assets/images/a2.png')}}" type="image/x-icon">
</head>

<body>
    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <h1>A2 Carwash</h1>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">

                        <li class="sidebar-title">Menu Utama</li>

                        <li class="sidebar-item {{ Request::is('dashboard') ? 'active' : '' }}">
                            <a href="{{ url('dashboard') }}" class='sidebar-link'>
                                <i data-feather="home" width="20"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ Request::is('pelanggan') ? 'active' : '' }}">
                            <a href="{{ url('pelanggan') }}" class='sidebar-link'>
                                <i data-feather="users" width="20"></i>
                                <span>Pelanggan</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ Request::is('transaksi') ? 'active' : '' }}">
                            <a href="{{ url('transaksi') }}" class='sidebar-link'>
                                <i data-feather="credit-card" width="20"></i>
                                <span>Transaksi</span>
                            </a>
                        </li>

                        @if (Auth::user()->posisi === 'admin') <!-- Only visible for admin -->
                        <li class="sidebar-item {{ Request::is('laporan') ? 'active' : '' }}">
                            <a href="{{ url('laporan') }}" class='sidebar-link'>
                                <i data-feather="file-text" width="20"></i>
                                <span>Laporan</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ Request::is('spk') ? 'active' : '' }}">
                            <a href="{{ url('spk') }}" class='sidebar-link'>
                                <i data-feather="bar-chart-2" width="20"></i>
                                <span>SPK</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ Request::is('laporan-spk') ? 'active' : '' }}">
                            <a href="{{ url('laporan-spk') }}" class='sidebar-link'>
                                <i data-feather="clipboard" width="20"></i>
                                <span>Laporan SPK</span>
                            </a>
                        </li>

                        </li>
                        @endif

                        <li class="sidebar-title mt-3">Pengaturan</li>

                        @if (Auth::user()->posisi === 'admin') <!-- Only visible for admin -->
                        <li class="sidebar-item {{ Request::is('karyawan') ? 'active' : '' }}">
                            <a href="{{ url('karyawan') }}" class='sidebar-link'>
                                <i data-feather="briefcase" width="20"></i> <!-- Icon untuk Karyawan -->
                                <span>Karyawan</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Request::is('harga') ? 'active' : '' }}">
                            <a href="{{ url('harga') }}" class='sidebar-link'>
                                <i data-feather="tag" width="20"></i> <!-- Icon untuk Harga -->
                                <span>Harga</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Request::is('akun') ? 'active' : '' }}">
                            <a href="{{ route('akun.index') }}" class='sidebar-link'>
                                <i data-feather="user" width="20"></i> <!-- Icon untuk Akun -->
                                <span>Akun</span>
                            </a>
                        </li>
                        @endif

                        <li class="sidebar-item">
                            <form action="{{ route('logout') }}" method="POST" style="display: none;" id="logout-form">
                                @csrf
                            </form>
                            <a href="#" class='sidebar-link' onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i data-feather="log-out" width="20"></i>
                                <span>Keluar</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>

        <div id="main">
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">
                        <li class="dropdown">
                            <a href="" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar mr-1">
                                    <img src="{{ asset('voler/dist/assets/images/avatar/user.png') }}" alt="">
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block">Hi {{ Auth::user()->username }}! Semangat hari ini, ya!</div>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="main-content container-fluid">
                <section class="section">
                    @yield('content')
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-left">
                        <p>2024 &copy; A2 Carwash</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('voler/dist/assets/js/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('voler/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('voler/dist/assets/js/app.js') }}"></script>
    <script src="{{ asset('voler/dist/assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('voler/dist/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('voler/dist/assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('voler/dist/assets/js/main.js') }}"></script>
    <script src="{{ asset('voler/dist/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('voler/dist/assets/js/vendors.js') }}"></script>

    <script>
        feather.replace(); // Pastikan ikon Feather ter-render
    </script>
</body>

</html>