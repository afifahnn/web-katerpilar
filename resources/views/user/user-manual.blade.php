<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual User</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/user/user-manual.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @yield('extra-css')
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center fw-bold">📖 Manual User</h2>
        <p class="text-center text-muted">Panduan penggunaan sistem Katerpilar Outdoor Gear & Rental</p>

        <div class="accordion mt-4" id="manualAccordion">
            <!-- LOGIN -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#loginSection">
                        🔑 <b>Login</b>
                    </button>
                </h2>
                <div id="loginSection" class="accordion-collapse collapse show" data-bs-parent="#manualAccordion">
                    <div class="accordion-body">
                        1. Buka halaman login di <a href="{{ url('/login') }}" class="login-link">/login</a> <br>
                        2. Masukkan username dan password yang telah didaftarkan <br>
                        3. Klik tombol <b>Login</b> untuk masuk ke akun Anda
                    </div>
                </div>
            </div>

            <!-- REGISTER -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#registerSection">
                        📝 <b>Register</b>
                    </button>
                </h2>
                <div id="registerSection" class="accordion-collapse collapse" data-bs-parent="#manualAccordion">
                    <div class="accordion-body">
                        Lakukan registrasi akun terlebih dahulu apabila belum memiliki akun, dengan tata cara sebagai berikut : <br>
                        1. Buka halaman pendaftaran di <a href="{{ url('/register') }}" class="login-link">/register</a> <br>
                        2. Isi semua data yang diperlukan, seperti username, nama, nomor telepon, alamat, dan password <br>
                        3. Klik tombol <b>Register</b> untuk membuat akun baru
                    </div>
                </div>
            </div>

            <!-- LUPA PASSWORD -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#forgotPasswordSection">
                        🔄 <b>Lupa Password</b>
                    </button>
                </h2>
                <div id="forgotPasswordSection" class="accordion-collapse collapse" data-bs-parent="#manualAccordion">
                    <div class="accordion-body">
                        Jika Anda lupa password, hubungi admin melalui WhatsApp atau telepon di nomor berikut
                        <b>
                            <a href="https://wa.me/6281390986967" target="_blank" rel="noopener noreferrer" class="whatsapp-link">
                                <i class="fa-brands fa-whatsapp"></i> WhatsApp
                            </a>
                        </b>.
                        Admin akan mereset password dan memberikan informasi baru kepada Anda.
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
