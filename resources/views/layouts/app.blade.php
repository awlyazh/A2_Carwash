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
    <link rel="shortcut icon" href="{{ asset('voler/dist/assets/images/favicon.svg')}}" type="image/x-icon">
</head>

<body>
    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <h2>A2 Carwash</h2>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">

                        <li class="sidebar-title">Main Menu</li>

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

                        <li class="sidebar-item mb-3 {{ Request::is('transaksi') ? 'active' : '' }}">
                            <a href="{{ url('transaksi') }}" class='sidebar-link'>
                                <i data-feather="credit-card" width="20"></i>
                                <span>Transaksi</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Pengaturan</li>

                        <!-- Tambahkan Link Akun -->
                        <li class="sidebar-item {{ Request::is('akun') ? 'active' : '' }}">
                            <a href="{{ route('akun.index') }}" class='sidebar-link'>
                                <i data-feather="settings" width="20"></i>
                                <span>Akun</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="#" class='sidebar-link'>
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
                            <a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar mr-1">
                                    <img src="{{ asset('voler/dist/assets/images/avatar/avatar-s-1.png') }}" alt="">
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block">Hi, Azah</div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                                <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a>
                                <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i data-feather="log-out"></i> Logout</a>
                            </div>
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
</body>

</html>
