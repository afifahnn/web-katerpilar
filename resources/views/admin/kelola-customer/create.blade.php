@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/create-customer.css') }}">
@endsection

@section('contents')
    <div id="create-customer">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Tambah Data Customer</div>
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
            <form action="{{ route('admin.kelola-customer.store') }}" method="post">
                @csrf
                <div class="input-data">
                    <div class="content" for="nama_customer">Nama</div>
                    <input type="text" name="nama_customer" id="nama_customer" placeholder="Nama" required>
                </div>
                <div class="grid-container">
                    <div class="input-container">
                        <div class="content" for="alamat_customer">Alamat</div>
                        <input type="text" name="alamat_customer" id="alamat_customer" placeholder="Alamat" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="telp_customer">Nomor Telepon</div>
                        <input type="number" name="telp_customer" id="telp_customer" placeholder="e.g. 081234567890" required>
                    </div>
                </div>

                <div class="btn-add-create">
                    <div class="btn-add-data">
                        <i class="fa-solid fa-plus" style="color: #FFFFFF; font-size: 20px;"></i>
                        <button type="submit">Tambah Data</button>
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
</script>
@endsection
