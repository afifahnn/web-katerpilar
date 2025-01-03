@extends('user-main-layout')

@section('user-extra-css')
    <link rel="stylesheet" href="{{ asset('css/user/user-edit-profil.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/admin-profil.css') }}"> --}}
@endsection

@section('user-contents')
<div id="edit-profil">
    <div class="edit-profil-top">Edit Profil Customer</div>
    <div class="btn-back-profil">
        <a href="{{ url('/profil') }}">
            <button>
                <i class="fa-solid fa-arrow-left" style="padding-right: 5px;"></i>
                Back
            </button>
        </a>
    </div>

    {{-- CONTAINER EDIT --}}
    <div class="profil-container">
        <form action="{{ route('user.profil.update') }}" method="post">
            @csrf
            @method('PUT')
            <div class="grid-container">
                <div class="input-profil">
                    <div class="data-profil">Nama</div>
                    <input value="{{ Auth::guard('customer')->user()->nama_customer }}" name="nama_customer" placeholder="Nama"></input>
                </div>
                <div class="input-profil">
                    <div class="data-profil">Username</div>
                    <input value="{{ Auth::guard('customer')->user()->username }}" name="username" placeholder="Username" required>
                </div>
            </div>
            <div class="grid-container">
                <div class="input-profil">
                    <div class="data-profil">Nomor Telepon</div>
                    <input value="{{ Auth::guard('customer')->user()->telp_customer }}" name="telp_customer" placeholder="Nomor Telepon" required>
                </div>
                <div class="input-profil">
                    <div class="data-profil">Alamat</div>
                    <input value="{{ Auth::guard('customer')->user()->alamat_customer }}" name="alamat_customer" placeholder="Nomor Telepon" required>
                </div>
            </div>
            <div>
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
            <div class="btn-profil">
                <div class="btn-edit-profil">
                    <button type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- JAVASCRIPT --}}
<script>
    const togglePassword = document.getElementById('toggle-password');
    const confirmTogglePassword = document.getElementById('confirm-toggle-password');
    const passwordInput = document.getElementById('password-input');

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

    // SWAL REQUIRED
    document.querySelectorAll('form input[required], form select[required]').forEach(function (input) {
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
</script>
@endsection
