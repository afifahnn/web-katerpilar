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
        <a href="{{ url('/kelola-keuangan') }}">
            <div class="btn-back">
                <button>
                    <i class="fa-solid fa-arrow-left" style="padding-right: 5px;"></i>
                    Back
                </button>
            </div>
        </a>

        <div class="create-container">
            <div class="grid-container">
                <div class="input-container">
                    <div class="content">Tanggal Transaksi</div>
                    <input type="date" placeholder="dd/mm/yyyy" required>
                </div>
                <div class="input-container">
                    <div class="content">Jenis Transaksi</div>
                    <div class="input-group">
                        <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                          <option selected>Pilih...</option>
                          <option value="1">Pemasukan</option>
                          <option value="2">Pengeluaran</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="grid-container">
                <div class="input-container">
                    <div class="content">Nominal</div>
                    <input type="text" class="currency-input" placeholder="Nominal" required>
                </div>
                <div class="input-container">
                    <div class="content">Deskripsi</div>
                    <input placeholder="Deskripsi" required>
                </div>
            </div>

            <div class="btn-add-create">
                <div class="btn-add-data">
                    <i class="fa-solid fa-plus" style="color: #FFFFFF; font-size: 20px;"></i>
                    <button>Tambah Data</button>
                </div>
            </div>

        </div>

    </div>

    {{-- javascript --}}
    <script>
        // format rupiah
        function formatRupiah(value) {
            const numberString = value.replace(/[^,\d]/g, '');
            const split = numberString.split(',');
            const sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            const ribuan = split[0].substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return split[1] !== undefined ? 'Rp ' + rupiah + ',' + split[1] : 'Rp ' + rupiah;
        }

        document.querySelectorAll('.currency-input').forEach(input => {
            input.addEventListener('input', function (e) {
                this.value = formatRupiah(this.value);
            });

            input.addEventListener('keypress', function (e) {
                const charCode = e.which || e.keyCode;
                if (charCode < 48 || charCode > 57) {
                    e.preventDefault();
                }
            });

            input.addEventListener('paste', function (e) {
                const clipboardData = (e.clipboardData || window.clipboardData).getData('text');
                if (!/^\d+$/.test(clipboardData)) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
