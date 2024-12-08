@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/create-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-keuangan/create-keuangan.css') }}">
@endsection

@section('contents')
    <div id="create-keuangan">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Tambah Data Keuangan</div>
            <div class="btn-logout">
                <button>Logout</button>
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
                        <div class="input-group">
                            <select class="form-select" id="inputGroupSelect04" name="jenis_transaksi" required>
                            <option disabled selected>Pilih...</option>
                            <option value="Pemasukan">Pemasukan</option>
                            <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="grid-container">
                    <div class="input-container">
                        <div class="content" for="nominal">Nominal</div>
                        <input type="text" name="nominal" id="nominal_display" class="currency-input" placeholder="Nominal" required>
                        <input type="hidden" name="nominal" id="nominal">
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
        // FORMAT RUPIAH
        // format rupiah untuk tampilan
        function formatRupiah(angka, prefix = 'Rp ') {
            const numberString = angka.replace(/[^,\d]/g, '');
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

        // hapus format rupiah untuk mendapatkan angka mentah
        function cleanRupiah(angka) {
            return angka.replace(/\D/g, '');
        }

        // terapkan event listener pada semua input
        document.querySelectorAll('.currency-input').forEach(input => {
            input.addEventListener('focus', function () {
                this.value = cleanRupiah(this.value);
            });

            input.addEventListener('blur', function () {
                this.value = formatRupiah(this.value);
            });

            input.addEventListener('input', function (e) {
                this.value = cleanRupiah(this.value);
            });
        });

        document.querySelector('form').addEventListener('submit', function (e) {
            document.querySelectorAll('.currency-input').forEach(input => {
                const hiddenInput = document.getElementById(input.id.replace('_display', ''));
                hiddenInput.value = cleanRupiah(input.value);
            });
        });
    </script>
@endsection
