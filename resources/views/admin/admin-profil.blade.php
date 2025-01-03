@extends('admin-main-layout')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-profil.css') }}">
@endsection

@section('contents')
    <div id="admin-profil">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Profil Admin</div>
            <div class="btn-logout">
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <a class="nav-link"><button type="submit">Logout</button></a>
                </form>
            </div>
        </div>

        {{-- container --}}
        <div class="profil-container">
            <div class="info-profil">
                <div style="font-weight: 600">
                    <div>Nama</div>
                    <div>Username</div>
                    <div>Nomor Telepon</div>
                    <div>Jenis Pembayaran</div>
                    <div>Nomor Rekening</div>
                </div>
                <div>
                    <div>:</div>
                    <div>:</div>
                    <div>:</div>
                    <div>:</div>
                    <div>:</div>
                </div>
                <div>
                    <div>{{ $admin->nama_admin }}</div>
                    <div>{{ $admin->username }}</div>
                    <div>{{ $admin->telp_admin }}</div>
                    <div>{{ $admin->jenis_rekening }}</div>
                    <div>{{ $admin->no_rekening }}</div>
                </div>
            </div>

            <div class="btn-profil-2">
                <div class="btn-edit-profil-2">
                    <i class="fa-solid fa-pen-to-square" style="color: #000000; font-size: 20px;"></i>
                    <a href="{{ url('/admin-update-profil') }}">
                        <button>Edit Profil</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

<script>
    // SWAL
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    @endif

    @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'error',
            title: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    @endif

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
@endsection
