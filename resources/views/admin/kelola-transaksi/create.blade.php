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
            <form action="{{ route('admin.kelola-transaksi.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-data">
                    <div class="content" for="nama_customer">Nama</div>
                    <input type="text" name="nama_customer" placeholder="Nama" required>
                </div>
                <div class="grid-container">
                    <div class="input-container">
                        <div class="content" for="telp_customer">Nomor Telepon</div>
                        <input type="text" name="telp_customer" placeholder="e.g. 081234567890" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="alamat_customer">Alamat</div>
                        <input type="text" name="alamat_customer" placeholder="Alamat" required>
                    </div>
                </div>
                <div class="grid-container">
                    <div class="input-container">
                        <div class="content" for="tgl_sewa">Tanggal Sewa</div>
                        <input type="date" name="tgl_sewa" id="tanggalSewa" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="tgl_kembali">Tanggal Kembali</div>
                        <input type="date" name="tgl_kembali" id="tanggalKembali" required>
                    </div>
                </div>
                <div class="input-data">
                    <div class="input-container">
                        <div class="content" for="opsi_bayar">Opsi Bayar</div>
                        <div class="input-group">
                            <select class="form-select" id="inputGroupSelect" aria-label="Example select with button addon">
                                <option value="" disabled selected>Pilih...</option>
                                <option value="Cash">Cash</option>
                                <option value="Non-Cash">Non-Cash</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- barang yang disewa --}}
                <div class="input-data">
                    <div class="content" for="barang_sewa">Barang yang Disewa </div>
                    <div class="input-group">
                        <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                        <option value="" disabled selected>Pilih...</option>
                        @foreach($barang as $index => $item)
                            <option value="{{ $item->id }}"
                                data-harga-sewa1="{{ $item->harga_sewa1 }}"
                                data-harga-sewa2="{{ $item->harga_sewa2 }}"
                                data-harga-sewa3="{{ $item->harga_sewa3 }}">
                                    {{ $item->nama_barang }}
                            </option>
                        @endforeach
                        </select>
                        <button class="btn btn-outline-secondary" type="button" id="addItemBtn">
                            <i class="fa-solid fa-plus" style="font-size: 20px;"></i>
                        </button>
                    </div>
                    <div id="selectedItems" style="margin-top: 10px;">
                        <!-- Pilihan akan muncul di sini -->
                    </div>
                    <input type="hidden" name="barang_sewa" id="barangSewaInput">
                    <input type="hidden" name="jumlah_sewa" id="jumlahSewaInput">
                </div>
                <div class="input-data">
                    <div class="content" for="total_bayar">Total Bayar</div>
                    <div id="totalBayar" class="form-control" readonly>Rp 0</div>
                </div>

                <div class="btn-add-create">
                    <div class="btn-add-data">
                        <i class="fa-solid fa-plus" style="color: #FFFFFF; font-size: 20px;"></i>
                        <button>Tambah Data</button>
                    </div>
                </div>
            </form>
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

        // add barang
        const addItemBtn = document.getElementById('addItemBtn');
        const selectBox = document.getElementById('inputGroupSelect04');
        const selectedItemsContainer = document.getElementById('selectedItems');
        const barangSewaInput = document.getElementById('barangSewaInput');
        const jumlahSewaInput = document.getElementById('jumlahSewaInput');
        const totalBayarDisplay = document.getElementById('totalBayar');
        const selectedItems = {}; // Menyimpan data barang dan jumlah

        addItemBtn.addEventListener('click', function () {
            const selectedValue = selectBox.value;
            const selectedText = selectBox.options[selectBox.selectedIndex].text;

            if (selectedValue === "") {
                alert('Pilih barang terlebih dahulu!');
                return;
            }

            // Ambil harga sewa berdasarkan lama sewa (harga_sewa1, harga_sewa2, harga_sewa3)
            const hargaSewa1 = parseFloat(selectBox.options[selectBox.selectedIndex].dataset.harga_sewa1 || 0);
            const hargaSewa2 = parseFloat(selectBox.options[selectBox.selectedIndex].dataset.harga_sewa2 || 0);
            const hargaSewa3 = parseFloat(selectBox.options[selectBox.selectedIndex].dataset.harga_sewa3 || 0);

            if (isNaN(hargaSewa1) || isNaN(hargaSewa2) || isNaN(hargaSewa3)) {
                alert('Harga sewa tidak valid! Pastikan data barang memiliki harga.');
                return;
            }

            // Tentukan harga berdasarkan lama sewa
            let hargaPerItem = 0;
            const tglSewa = new Date(document.getElementById('tanggalSewa').value);
            const tglKembali = new Date(document.getElementById('tanggalKembali').value);
            const lamaSewa = Math.ceil((tglKembali - tglSewa) / (1000 * 3600 * 24));  // Lama sewa dalam hari

            if (lamaSewa <= 1) {
                hargaPerItem = hargaSewa1;
            } else if (lamaSewa <= 3) {
                hargaPerItem = hargaSewa2;
            } else {
                hargaPerItem = hargaSewa3;
            }

            // Jika barang sudah ada, tambahkan jumlahnya
            if (selectedItems[selectedValue]) {
                selectedItems[selectedValue].quantity += 1;
                selectedItems[selectedValue].price = hargaPerItem;

                // Update tampilan jumlah
                const itemElement = document.querySelector(`.selected-item[data-value="${selectedValue}"]`);
                itemElement.querySelector('.item-quantity').textContent = `Jumlah: ${selectedItems[selectedValue].quantity}`;
                itemElement.querySelector('.item-price').textContent = `Harga: Rp ${(selectedItems[selectedValue].quantity * hargaPerItem).toFixed(2)}`;
            } else {
                // Tambahkan barang baru
                selectedItems[selectedValue] = {
                    name: selectedText,
                    quantity: 1,
                    price: hargaPerItem
                };

                const itemDiv = document.createElement('div');
                itemDiv.className = 'selected-item';
                itemDiv.dataset.value = selectedValue;
                itemDiv.innerHTML = `
                    ${selectedText} <span class="item-quantity">Jumlah: 1</span>
                    <span class="item-price">Harga: Rp ${hargaPerItem.toFixed(2)}</span>
                `;

                const removeBtn = document.createElement('button');
                removeBtn.className = 'btn btn-danger btn-sm ms-2';
                removeBtn.textContent = 'Hapus';
                removeBtn.addEventListener('click', function () {
                    delete selectedItems[selectedValue];
                    selectedItemsContainer.removeChild(itemDiv);
                    updateHiddenInputs();
                });

                itemDiv.appendChild(removeBtn);
                selectedItemsContainer.appendChild(itemDiv);
            }

            updateHiddenInputs();
            updateTotalBayar();
        });

        // Fungsi untuk memperbarui input tersembunyi
        function updateHiddenInputs() {
            const barangSewa = [];
            const jumlahSewa = [];

            for (const [id, data] of Object.entries(selectedItems)) {
                barangSewa.push(id);
                jumlahSewa.push(data.quantity);
            }

            barangSewaInput.value = JSON.stringify(barangSewa);
            jumlahSewaInput.value = JSON.stringify(jumlahSewa);
        }

        // Fungsi untuk menghitung total bayar
        // function updateTotalBayar() {
        //     let totalBayar = 0;
        //     const tglSewa = new Date(document.getElementById('tanggalSewa').value);
        //     const tglKembali = new Date(document.getElementById('tanggalKembali').value);

        //     // Hitung lama sewa dalam hari
        //     const lamaSewa = Math.ceil((tglKembali - tglSewa) / (1000 * 3600 * 24));

        //     if (lamaSewa < 1) {
        //         alert('Tanggal kembali tidak valid!');
        //         return;
        //     }

        //     // Kalkulasi total bayar
        //     for (const [id, data] of Object.entries(selectedItems)) {
        //         totalBayar += data.price * data.quantity * lamaSewa;
        //     }

        //     totalBayarDisplay.textContent = `Rp ${totalBayar.toFixed(2)}`;
        // }

        function updateTotalBayar() {
            let totalBayar = 0;

            for (const [id, data] of Object.entries(selectedItems)) {
                totalBayar += data.price * data.quantity;
            }

            totalBayarDisplay.textContent = `Rp ${totalBayar.toFixed(2)}`;
        }

        console.log('Tanggal Sewa:', tglSewa);
        //     console.log('Tanggal Kembali:', tglKembali);
        //     console.log('Lama Sewa:', lamaSewa);
            // console.log('Harga Sewa 1:', hargaSewa1);
            // console.log('Harga Sewa 2:', hargaSewa2);
            // console.log('Harga Sewa 3:', hargaSewa3);
            // console.log('Harga Per Item:', hargaPerItem);
            console.log('Selected Items:', selectedItems);

    </script>
@endsection
