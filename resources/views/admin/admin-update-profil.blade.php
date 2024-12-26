@extends('admin-main-layout')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-profil.css') }}">
@endsection

@section('contents')
    <div id="admin-profil">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Edit Profil Admin</div>
            <div class="btn-logout">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <a class="nav-link"><button type="submit">Logout</button></a>
                </form>
            </div>
        </div>
        <div class="btn-back">
            <a href="{{ url('/admin-profil') }}">
                <button>
                    <i class="fa-solid fa-arrow-left" style="padding-right: 5px;"></i>
                    Back
                </button>
            </a>
        </div>

        {{-- container --}}
        <div class="profil-container">
            <form action="{{ route('adminprofil.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="grid-container">
                    <div class="input-profil">
                        <div class="data-profil">Nama</div>
                        <input value="{{ $admin->nama_admin }}" name="nama_admin" placeholder="Nama"></input>
                    </div>
                    <div class="input-profil">
                        <div class="data-profil">Nomor Telepon</div>
                        <input value="{{ $admin->telp_admin }}" name="telp_admin" placeholder="Nomor Telepon" required>
                    </div>
                </div>
                <div class="grid-container">
                    <div class="input-profil">
                        <div class="data-profil">Username</div>
                        <input value="{{ $admin->username }}" name="username" placeholder="Username" required>
                    </div>
                </div>
                <div>
                    <div class="change-pwd">Ganti Password</div>
                    <div class="grid-container">
                        <div class="input-profil password-container">
                            <div class="data-profil">Password Baru</div>
                            <div class="password-wrapper">
                                <input type="password" id="password-input" placeholder="Password">
                                <i class="fa-solid fa-eye-slash" style="font-size: 16px" id="toggle-password"></i>
                            </div>
                        </div>
                        <div class="input-profil password-container">
                            <div class="data-profil">Konfirmasi Password</div>
                            <div class="password-wrapper">
                                <input type="password" id="confirm-password-input" placeholder="Konfirmasi Password">
                                <i class="fa-solid fa-eye-slash" style="font-size: 16px" id="confirm-toggle-password"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="change-pwd">Informasi Lain</div>
                    <div class="grid-container">
                        <div class="input-profil">
                            <div class="data-profil">Jenis Pembayaran</div>
                            <div style="margin-bottom: 3px">*jenis pembayaran untuk informasi customer</div>
                            <input value="{{ $admin->jenis_pembayaran }}" name="jenis_rekening" placeholder="Jenis Pembayaran"></input>
                        </div>
                        <div class="input-profil">
                            <div class="data-profil">Nomor Rekening</div>
                            <div style="margin-bottom: 3px">*nomor rekening untuk informasi customer</div>
                            <input value="{{ $admin->no_rekening }}" name="no_rekening" placeholder="Nomor Rekening"></input>
                        </div>
                    </div>
                </div>
                <div class="btn-profil">
                    <div class="btn-edit-profil">
                        <button>Simpan</button>
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
