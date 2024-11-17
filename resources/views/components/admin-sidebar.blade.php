<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- @vite('resources/css/app.css') --}}
    <link rel="stylesheet" href="{{ asset('css/admin-sidebar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Admin Katerpilar Outdoor</title>
</head>
<body>
    <div id="side-bar">
        <div class="logo">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
            <div class="logo-hi">
                <div class="logo-hello">Hello!</div>
                <div style="font-size: 13px">Admin</div>
            </div>
        </div>
        <div class="btn-sidebar">
            <ul>
                <li>
                    <i class="fa-solid fa-grip"></i>
                    <a href="{{ url('/') }}">Dashboard</a>
                </li>
                <li>
                    <i class="fa-solid fa-headset"></i>
                    <a href="{{ url('/kelola-customer') }}">Kelola Data Customer</a>
                </li>
                <li>
                    <i class="fa-solid fa-money-bill-transfer"></i>
                    <a href="{{ url('/kelola-transaksi') }}">Kelola Data Transaksi</a>
                </li>
                <li>
                    <i class="fa-solid fa-toolbox"></i>
                    <a href="{{ url('/kelola-barang') }}">Kelola Data Barang</a>
                </li>
                <li>
                    <i class="fa-solid fa-money-bill-trend-up"></i>
                    <a href="{{ url('/kelola-keuangan') }}">Kelola Keuangan</a>
                </li>
                <hr>
                <li>
                    <i class="fa-solid fa-user"></i>
                    <a href="{{ url('/admin-profil') }}">Profil</a>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>

