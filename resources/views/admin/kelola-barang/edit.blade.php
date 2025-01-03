@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/create-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-barang/edit-barang.css') }}">
@endsection

@section('contents')
    <div id="edit-barang">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Edit Data Barang</div>
            <div class="btn-logout">
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <a class="nav-link"><button type="submit">Logout</button></a>
                </form>
            </div>
        </div>
        <div class="btn-back">
            <a href="{{ url('/kelola-barang') }}">
                <button>
                    <i class="fa-solid fa-arrow-left" style="padding-right: 5px;"></i>
                    Back
                </button>
            </a>
        </div>

        <div class="create-container">
            <form action="{{ route('admin.kelola-barang.update', $barang->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid-container-2">
                    <div class="input-container">
                        <div class="content" for="nama_barang">Nama Barang</div>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ $barang->nama_barang }}" placeholder="Nama Barang" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="jenis">Jenis Barang</div>
                        <input type="text" name="jenis" id="jenis" value="{{ $barang->jenis }}" placeholder="Jenis Barang" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="stok_barang">Stok Barang</div>
                        <input type="number" name="stok_barang" id="stok_barang" value="{{ $barang->stok_barang }}" placeholder="Stok Barang" required>
                    </div>
                </div>
                <div class="input-data">
                    <label class="content" for="deskripsi_barang">Deskripsi</label>
                    <textarea name="deskripsi_barang" id="deskripsi_barang" placeholder="Deskripsi" required>{{ $barang->deskripsi_barang }}</textarea>
                </div>
                <div class="container-price">
                    <div class="input-container">
                        <div class="content">Harga Sewa</div>
                    </div>
                </div>
                <div class="grid-container-2">
                    <div class="input-container">
                        <div class="content" for="harga_sewa1">1 Hari</div>
                        <input type="text" name="harga_sewa1" id="harga_sewa1" class="currency-input" placeholder="Harga Sewa 1 Hari" value="{{ $barang->harga_sewa1 }}" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="harga_sewa2">2 Hari</div>
                        <input type="text" name="harga_sewa2" id="harga_sewa2" class="currency-input" placeholder="Harga Sewa 2 Hari" value="{{ $barang->harga_sewa2 }}" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="harga_sewa3">3 Hari</div>
                        <input type="text" name="harga_sewa3" id="harga_sewa3" class="currency-input" placeholder="Harga Sewa 3 Hari" value="{{ $barang->harga_sewa3 }}" required>
                    </div>
                </div>
                <div class="input-data">
                    <div class="content" for="gambar_barang">Gambar</div>
                    <input type="file" name="gambar_barang" accept="image/*" id="imageInput">
                    @if($barang->gambar_barang)
                        <div id="imagePreview">
                            <img src="{{ asset('storage/' . $barang->gambar_barang) }}" alt="{{ $barang->nama_barang }}">
                        </div>
                    @else
                        <div>Tidak ada gambar saat ini.</div>
                    @endif
                    <div id="imagePreviewImg">
                        <img id="preview" src="" alt="Preview Gambar">
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

    {{-- JAVASCRIPT --}}
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

        // PREVIEW GAMBAR JIKA INPUT
        const imageInput = document.getElementById('imageInput');
        const preview = document.getElementById('preview');
        const imagePreview = document.getElementById('imagePreview');
        const imagePreviewImg = document.getElementById('imagePreviewImg');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                // Saat file selesai dibaca
                reader.onload = function (e) {
                    // Tampilkan preview gambar baru
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    imagePreviewImg.style.display = 'block';

                    // Sembunyikan gambar sebelumnya (jika ada)
                    imagePreview.style.display = 'none';
                };

                // Membaca file yang diupload sebagai data URL
                reader.readAsDataURL(file);
            } else {
                // Jika tidak ada file yang dipilih, tampilkan gambar sebelumnya lagi
                preview.src = '';
                imagePreviewImg.style.display = 'none';
                imagePreview.style.display = 'block';
            }
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
