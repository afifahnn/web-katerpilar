@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/create-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-keuangan/create-keuangan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-keuangan/edit-keuangan.css') }}">
@endsection

@section('contents')
<div id="edit-keuangan">
    <div class="kelola-cust-top">
        <div class="kelola-cust-judul">Edit Data Pengeluaran</div>
        <div class="btn-logout">
            <form action="{{ route('logout') }}" method="POST">
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
        <form action="{{ route('admin.kelola-keuangan.update', $keuangan->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid-container">
                <div class="input-container">
                    <div class="content" for="tgl_transaksi">Tanggal Transaksi</div>
                    <input type="date" name="tgl_transaksi" value="{{ $keuangan->tgl_transaksi }}" required>
                </div>
                <div class="input-container">
                    <div class="content">Jenis Transaksi</div>
                    <input type="text" name="jenis_transaksi" value="{{ ucwords($keuangan->jenis_transaksi) }}" readonly required>
                    {{-- <div class="input-group">
                        <select class="form-select" id="inputGroupSelect04" name="jenis_transaksi" required>
                            <option disabled {{ $keuangan->jenis_transaksi == null ? 'selected' : '' }}>Pilih...</option>
                            <option value="Pemasukan" {{ $keuangan->jenis_transaksi == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="Pengeluaran" {{ $keuangan->jenis_transaksi == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div> --}}
                </div>
            </div>
            <div class="grid-container">
                <div class="input-container">
                    <div class="content" for="nominal">Nominal</div>
                    <input type="text" name="nominal" id="nominal" class="currency-input" placeholder="Nominal" value="{{ $keuangan->nominal}}" required>
                </div>
                <div class="input-container">
                    <div class="content" for="deskripsi">Deskripsi</div>
                    <input type="text" name="deskripsi" value="{{ $keuangan->deskripsi }}" required>
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
</script>
@endsection
