<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @yield('extra-css')
</head>
<body>
    <div id="login-container">
        <img src="{{ asset('img/bg11.jpg') }}" class="img-bg">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="login-card">
                <div class="logo-head">
                    <img src="{{ asset('img/logo-white.png') }}" alt="Logo">
                    <span class="span-login">LOGIN</span>
                    <span class="span-text">Katerpilar Outdoor Gear & Rental</span>
                </div>
                <div class="us-container">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="username" name="username" placeholder="Username" value="{{ old('username') }}">
                </div>
                @if ($errors->has('username'))
                    <div class="error-input">
                        {{ $errors->first('username') }}
                    </div>
                @endif
                <div class="pwd-container" style="margin-bottom: 1px;">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="password-input" name="password" placeholder="Password">
                    <i class="fa-solid fa-eye-slash" id="toggle-password"></i>
                </div>
                <div class="forgot" onclick="window.location.href='/manual-user'">Lupa password?</div>
                @if ($errors->has('password'))
                    <div class="error-input">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                @if ($errors->has('login'))
                    <div class="error-input">
                        {{ $errors->first('login') }}
                    </div>
                @endif
                <div class="btn-login">
                    <button type="submit">Login</button>
                </div>
                <div class="link-regis">
                    <span>Belum punya akun?</span>
                    <a href="{{ url('/register') }}">Register</a>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

            </div>
        </form>
    </div>

    <div class="help-icon" onclick="window.location.href='/manual-user'">
        <i class="fa-solid fa-question"></i>
    </div>
</body>

{{-- JAVASCRIPT --}}
<script>
    // PASSWORD
    const passwordInput = document.getElementById("password-input");
    const togglePassword = document.getElementById("toggle-password");

    togglePassword.addEventListener("click", function () {
        const isPassword = passwordInput.type === "password";
        passwordInput.type = isPassword ? "text" : "password";

        togglePassword.classList.toggle("fa-eye-slash");
        togglePassword.classList.toggle("fa-eye");
    });
</script>
</html>

