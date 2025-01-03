@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/create-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-keuangan/create-keuangan.css') }}">
@endsection

@section('contents')
    <div id="create-keuangan">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Tambah Data Pengeluaran</div>
            <div class="btn-logout">
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <a class="nav-link"><button type="submit">Logout</button></a>
                </form>
            </div>
        </div>
        <div class="btn-back">
            <a href="{{ url('/kelola-keuangan') }}">
                <button>
                    <i class="fa-solid fa-arrow-left" style="padding-right: 5px;"></i>
                    Back
                </button>
            </a>
        </div>

        <div class="create-container">
            <form action="{{ route('admin.kelola-keuangan.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="grid-container">
                    <div class="input-container">
                        <div class="content" for="tgl_transaksi">Tanggal Transaksi</div>
                        <input type="date" name="tgl_transaksi" placeholder="dd/mm/yyyy" required>
                    </div>
                    <div class="input-container">
                        <div class="content">Jenis Transaksi</div>
                        <input type="text" name="jenis_transaksi" value="Pengeluaran" readonly required>
                    </div>
                </div>
                <div class="grid-container">
                    <div class="input-container">
                        <div class="content" for="nominal">Nominal</div>
                        <input type="text" name="nominal" id="nominal" class="currency-input" placeholder="Nominal" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="deskripsi">Deskripsi</div>
                        <input type="text" name="deskripsi" placeholder="Deskripsi" required>
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

    {{-- javascript --}}
    <script>
        // FORMAT RUPIAH UNTUK INPUT LANGSUNG
        function formatRupiah(angka, prefix = '') {
            const numberString = angka.replace(/[^,\d]/g, '').toString(); // Hanya angka
            const split = numberString.split(',');
            const sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            const ribuan = split[0].substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return prefix + (split[1] !== undefined ? rupiah + ',' + split[1] : rupiah);
        }

        function cleanRupiah(angka) {
            return angka.replace(/\D/g, '');
        }

        document.querySelectorAll('.currency-input').forEach(input => {
            input.addEventListener('input', function () {
                const rawValue = cleanRupiah(this.value); // Ambil angka mentah
                this.value = formatRupiah(rawValue, 'Rp '); // Format ulang dengan Rupiah
            });

            // Pastikan value yang dikirim adalah angka mentah
            input.closest('form').addEventListener('submit', function () {
                input.value = cleanRupiah(input.value); // Hapus format sebelum submit
            });
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
