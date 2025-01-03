<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Katerpilar Outdoor Gear & Rental</title>
    <link rel="icon" href="{{ asset('img/logo-black.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/admin-sidebar.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('extra-css')
</head>
<body>
    @include('components.admin-sidebar')

    <div class="main-content">
        @yield('contents')
    </div>

    <div class="footer">
        © Katerpilar Outdoor Gear & Rental 2025
    </div>
</body>
</html>
