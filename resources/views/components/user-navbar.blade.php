<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- @vite('resources/css/app.css') --}}
    <link rel="stylesheet" href="{{ asset('css/user/user-navbar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Katerpilar Outdoor Gear & Rental</title>
</head>
<body>
    <div id="user-navbar">
        <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid mx-3">
                <a class="navbar-brand" href="#">
                    <div class="logo">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo">
                        <div class="logo-hi">
                            <div>Katerpilar Outdoor</div>
                            <div>Gear & Rental</div>
                        </div>
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item me-3 {{ Request::is('/') ? 'active' : '' }}">
                            <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                        </li>

                        @auth
                            <li class="nav-item me-3 {{ Request::is('rental') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/rental') }}">Pesan</a>
                            </li>
                            <li class="nav-item me-3 {{ Request::is('riwayat') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/riwayat') }}">Riwayat</a>
                            </li>
                            <li class="nav-item me-3 {{ Request::is('profil') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/profil') }}">Profil</a>
                            </li>
                        @endauth

                        <li class="nav-item me-3" id="btn-logout">
                            @auth
                                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                                    @csrf
                                    <a class="nav-link"><button type="submit" class="btn-logout">Logout</button></a>
                                </form>
                            @endauth
                            @guest
                                <a class="nav-link" href="{{ url('/login') }}"><b>Login</b></a>
                            @endguest
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <script>
        // ALERT LOGOUT
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.logout-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    var formElement = this;

                    Swal.fire({
                        text: "Apakah anda yakin akan Logout?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formElement.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
