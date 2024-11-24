@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/create-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-transaksi/create-transaksi.css') }}">
@endsection

@section('contents')
    <div id="create-transaksi">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Tambah Data Transaksi</div>
            <div class="btn-logout">
                <button>Logout</button>
            </div>
        </div>
        <a href="{{ url('/kelola-transaksi') }}">
            <div class="btn-back">
                <button>
                    <i class="fa-solid fa-arrow-left" style="padding-right: 5px;"></i>
                    Back
                </button>
            </div>
        </a>

        <div class="create-container">
            <div class="input-data">
                <div class="content">Nama</div>
                <input placeholder="Nama" required>
            </div>
            <div class="grid-container">
                <div class="input-container">
                    <div class="content">Nomor Telepon</div>
                    <input placeholder="e.g. 081234567890" required>
                </div>
                <div class="input-container">
                    <div class="content">Alamat</div>
                    <input placeholder="Alamat" required>
                </div>
            </div>
            <div class="grid-container">
                <div class="input-container">
                    <div class="content">Tanggal Sewa</div>
                    <input type="date" id="tanggalSewa" required>
                </div>
                <div class="input-container">
                    <div class="content">Tanggal Kembali</div>
                    <input type="date" id="tanggalKembali" required>
                </div>
            </div>

            {{-- barang yang disewa --}}
            <div class="input-data">
                <div class="content">Barang yang Disewa</div>
                <div class="input-group">
                    <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                    <option selected>Pilih...</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                    </select>
                    <button class="btn btn-outline-secondary" type="button" id="addItemBtn">
                        <i class="fa-solid fa-plus" style="font-size: 20px;"></i>
                    </button>
                </div>
                <div id="selectedItems" style="margin-top: 10px;">
                    <!-- Pilihan akan muncul di sini -->
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
        // tanggal sewa dan tanggal kembali
        const tanggalSewa = document.getElementById('tanggalSewa');
        const tanggalKembali = document.getElementById('tanggalKembali');

        const today = new Date().toISOString().split('T')[0];
        tanggalSewa.setAttribute('min', today);

        tanggalSewa.addEventListener('change', function () {
            const selectedDate = this.value;
            tanggalKembali.setAttribute('min', selectedDate);
        });

        tanggalKembali.addEventListener('change', function () {
            const kembaliDate = new Date(this.value);
            const sewaDate = new Date(tanggalSewa.value);

            if (kembaliDate < sewaDate) {
                alert('Tanggal kembali tidak boleh sebelum tanggal sewa!');
                this.value = '';
            }
        });

        // add barang [CEK KEMBALI YAA NANTI]
        const addItemBtn = document.getElementById('addItemBtn');
        const selectBox = document.getElementById('inputGroupSelect04');
        const selectedItemsContainer = document.getElementById('selectedItems');

        addItemBtn.addEventListener('click', function () {
            const selectedValue = selectBox.value;
            const selectedText = selectBox.options[selectBox.selectedIndex].text;

            if (selectedValue === "") {
                alert('Pilih barang terlebih dahulu!');
                return;
            }

            // Cek apakah item sudah ditambahkan
            const existingItems = selectedItemsContainer.querySelectorAll('.selected-item');
            for (let item of existingItems) {
                if (item.dataset.value === selectedValue) {
                    alert('Barang ini sudah dipilih!');
                    return;
                }
            }

            // Tambahkan item ke daftar
            const itemDiv = document.createElement('div');
            itemDiv.className = 'selected-item';
            itemDiv.dataset.value = selectedValue;
            itemDiv.textContent = selectedText;

            // Tambahkan tombol hapus
            const removeBtn = document.createElement('button');
            removeBtn.className = 'btn btn-danger btn-sm ms-2';
            removeBtn.textContent = 'Hapus';
            removeBtn.addEventListener('click', function () {
                selectedItemsContainer.removeChild(itemDiv);
            });

            itemDiv.appendChild(removeBtn);
            selectedItemsContainer.appendChild(itemDiv);
        });
    </script>
@endsection
