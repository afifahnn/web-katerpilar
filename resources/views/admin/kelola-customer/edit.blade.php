@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/create-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/edit-customer.css') }}">
@endsection

@section('contents')
    <div id="edit-customer">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Edit Data Customer</div>
            <div class="btn-logout">
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <a class="nav-link"><button type="submit">Logout</button></a>
                </form>
            </div>
        </div>
        <div class="btn-back">
            <a href="{{ url('/kelola-customer') }}">
                <button>
                    <i class="fa-solid fa-arrow-left" style="padding-right: 5px;"></i>
                    Back
                </button>
            </a>
        </div>

        <div class="create-container">
            <form action="{{ route('admin.kelola-customer.update', $customer->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="input-data">
                    <div class="content" for="nama_customer">Nama</div>
                    <input type="text" name="nama_customer" id="nama_customer" value="{{ $customer->nama_customer }}" placeholder="Nama" required>
                </div>
                <div class="grid-container">
                    <div class="input-container">
                        <div class="content" for="alamat_customer">Alamat</div>
                        <input type="text" name="alamat_customer" id="alamat_customer" value="{{ $customer->alamat_customer }}" placeholder="Alamat" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="telp_customer">Nomor Telepon</div>
                        <input type="number" name="telp_customer" id="telp_customer" value="{{ $customer->telp_customer }}" placeholder="e.g. 081234567890" required>
                    </div>
                </div>
                <div class="btn-forgot" id="forgot-btn">Reset password</div>
                <div id="forgot-pwd" style="display: none;">
                    <div class="change-pwd">Ganti Password</div>
                    <div class="grid-container">
                        <div class="input-profil password-container">
                            <div class="data-profil">Password Baru</div>
                            <div class="password-wrapper">
                                <input type="password" name="password" id="password-input" placeholder="Password">
                                <i class="fa-solid fa-eye-slash" style="font-size: 16px" id="toggle-password"></i>
                            </div>
                            @if ($errors->has('password'))
                                <div class="error-input">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                        <div class="input-profil password-container">
                            <div class="data-profil">Konfirmasi Password</div>
                            <div class="password-wrapper">
                                <input type="password" name="password_confirmation" id="confirm-password-input" placeholder="Konfirmasi Password">
                                <i class="fa-solid fa-eye-slash" style="font-size: 16px" id="confirm-toggle-password"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn-add-create">
                    <div class="btn-add-data">
                        <button type="submit">Edit Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<script>
    // SWAL REQUIRED
    document.querySelectorAll('form input[required]').forEach(function (input) {
        input.addEventListener('invalid', function () {
            Swal.fire({
                position: 'bottom-end',
                title: 'Peringatan!',
                text: 'Semua field yang wajib diisi harus diisi terlebih dahulu!',
                icon: 'warning',
                toast: true,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: false,
            });
        });
    });

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

    // FORGOT PASSWORD
    document.addEventListener('DOMContentLoaded', function () {
        const forgotBtn = document.getElementById('forgot-btn');
        const forgotPwd = document.getElementById('forgot-pwd');

        forgotBtn.addEventListener('click', function () {
            if (forgotPwd.style.display === 'none' || forgotPwd.style.display === '') {
                forgotPwd.style.display = 'block';
            } else {
                forgotPwd.style.display = 'none';
            }
        });
    });

    // TOGGLE PASSWORD
    const togglePassword = document.getElementById('toggle-password');
    const confirmTogglePassword = document.getElementById('confirm-toggle-password');
    const passwordInput = document.getElementById('password-input');
    const confirmPasswordInput = document.getElementById('confirm-password-input');

    togglePassword.addEventListener('click', () => {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        togglePassword.classList.toggle('fa-eye');
    });

    confirmTogglePassword.addEventListener('click', () => {
        const type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
        confirmPasswordInput.type = type;
        confirmTogglePassword.classList.toggle('fa-eye');
    });
</script>
@endsection
