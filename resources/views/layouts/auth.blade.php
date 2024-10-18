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

    @yield('content')

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