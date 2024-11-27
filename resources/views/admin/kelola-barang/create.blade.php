@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/create-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-barang/create-barang.css') }}">
@endsection

@section('contents')
    <div id="create-barang">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Tambah Data Barang</div>
            <div class="btn-logout">
                <button>Logout</button>
            </div>
        </div>
        <a href="{{ url('/kelola-barang') }}">
            <div class="btn-back">
                <button>
                    <i class="fa-solid fa-arrow-left" style="padding-right: 5px;"></i>
                    Back
                </button>
            </div>
        </a>

        <div class="create-container">
            <form action="{{ route('admin.kelola-barang.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="grid-container">
                    <div class="input-container">
                        <div class="content" for="nama_barang">Nama Barang</div>
                        <input type="text" name="nama_barang" id="nama_barang" placeholder="Nama Barang" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="jenis">Jenis Barang</div>
                        <input type="text" name="jenis" id="jenis" placeholder="Jenis Barang" required>
                    </div>
                </div>
                <div class="grid-container">
                    <div class="input-container">
                        <div class="content" for="stok_barang">Stok Barang</div>
                        <input type="number" name="stok_barang" id="stok_barang" placeholder="Stok Barang" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="deskripsi_barang">Deskripsi</div>
                        <input type="text" name="deskripsi_barang" id="deskripsi_barang" placeholder="Deskripsi" required>
                    </div>
                </div>
                <div class="container-price">
                    <div class="input-container">
                        <div class="content">Harga Sewa</div>
                    </div>
                </div>
                <div class="grid-container-2">
                    <div class="input-container">
                        <div class="content" for="harga_sewa1">1 Hari</div>
                        <input type="text" name="harga_sewa1" id="harga_sewa1" class="currency-input" placeholder="Harga Sewa 1 Hari" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="harga_sewa2">2 Hari</div>
                        <input type="text" name="harga_sewa2" id="harga_sewa2" class="currency-input" placeholder="Harga Sewa 2 Hari" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="harga_sewa3">3 Hari</div>
                        <input type="text" name="harga_sewa3" id="harga_sewa3" class="currency-input" placeholder="Harga Sewa 3 Hari" required>
                    </div>
                </div>
                <div class="input-data">
                    <div class="content" for="gambar_barang">Gambar</div>
                    <input type="file" name="gambar_barang" accept="image/*" required id="imageInput">
                    <div id="imagePreview">
                        <img id="preview" src="" alt="Preview Gambar">
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

        // preview gambar
        const imageInput = document.getElementById('imageInput');
        const preview = document.getElementById('preview');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
