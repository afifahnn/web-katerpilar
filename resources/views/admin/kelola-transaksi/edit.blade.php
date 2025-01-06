@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/create-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-transaksi/create-transaksi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-transaksi/edit-transaksi.css') }}">
@endsection

@section('contents')
<div id="edit-transaksi">
    <div class="kelola-cust-top">
        <div class="kelola-cust-judul">Edit Data Transaksi</div>
        <div class="btn-logout">
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <a class="nav-link"><button type="submit">Logout</button></a>
            </form>
        </div>
    </div>
    <div class="btn-back">
        <a href="{{ url('/kelola-transaksi') }}">
            <button>
                <i class="fa-solid fa-arrow-left" style="padding-right: 5px;"></i>
                Back
            </button>
        </a>
    </div>

    <div class="create-container">
        <form action="{{ route('admin.kelola-transaksi.update', $transaksi->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="input-data">
                <div class="content" for="nama_customer">Nama</div>
                <input class="form-control" name="nama_customer" list="datalistOptions" id="nama_customer" value="{{ $transaksi->customer->nama_customer }}" placeholder="Nama" required>
                <datalist id="datalistOptions">
                    @foreach ($customer as $index => $customer )
                        <option value="{{ $customer->nama_customer }}" data-telp="{{ $customer->telp_customer }}" data-alamat="{{ $customer->alamat_customer }}">
                    @endforeach
                </datalist>
            </div>
            <div class="grid-container">
                <div class="input-container">
                    <div class="content" for="telp_customer">Nomor Telepon</div>
                    <input type="text" name="telp_customer" id="telp_customer" value="{{ $transaksi->customer->telp_customer }}" placeholder="e.g 081234567890" required>
                </div>
                <div class="input-container">
                    <div class="content" for="alamat_customer">Alamat</div>
                    <input type="text" name="alamat_customer" id="alamat_customer" value="{{ $transaksi->customer->alamat_customer }}" placeholder="Alamat" required>
                </div>
            </div>
            <div class="grid-container">
                <div class="input-container">
                    <div class="content" for="tgl_sewa">Tanggal Sewa</div>
                    <input type="date" name="tgl_sewa" id="tanggalSewa" value="{{ $transaksi->tgl_sewa }}" required>
                </div>
                <div class="input-container">
                    <div class="content" for="tgl_kembali">Tanggal Kembali</div>
                    <input type="date" name="tgl_kembali" id="tanggalKembali" value="{{ $transaksi->tgl_kembali }}" required>
                </div>
            </div>
            <div class="input-data">
                <div class="content">Total Hari</div>
                <input type="text" id="totalHari" readonly placeholder="Total hari akan muncul di sini">
            </div>
            <div class="input-data">
                <div class="input-container">
                    <div class="content" for="opsi_bayar">Opsi Bayar</div>
                    <div class="input-group">
                        <select class="form-select" id="inputGroupSelect" name="opsi_bayar" required>
                            <option value="" disabled {{ $transaksi->opsi_bayar == null ? 'selected' : '' }}>Pilih...</option>
                            <option value="Cash" {{ $transaksi->opsi_bayar == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Non-Cash" {{ $transaksi->opsi_bayar == 'non-cash' ? 'selected' : '' }}>Non-Cash</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- barang yang disewa --}}
            <div class="input-data">
                <div class="content" for="barang_sewa">Barang yang Disewa </div>
                <div class="input-group">
                    <select class="form-select" id="inputGroupSelect04">
                    <option value="" disabled selected>Pilih...</option>
                    @foreach ($barang as $index => $item)
                        @php
                            $stokTampil = max(0, $item->stok_barang);
                        @endphp
                        @if ($item->stok_barang <= 0)
                            <option value="{{ $item->nama_barang }}"
                                    data-harga1="{{ $item->harga_sewa1 }}"
                                    data-harga2="{{ $item->harga_sewa2 }}"
                                    data-harga3="{{ $item->harga_sewa3 }}"
                                    data-kelipatan="{{ $item->kelipatan }}"
                                    data-stok="{{ $stokTampil }}" disabled>
                                {{ $item->nama_barang }} (Stok: {{ $stokTampil }})
                            </option>
                        @else
                            <option value="{{ $item->nama_barang }}"
                                    data-harga1="{{ $item->harga_sewa1 }}"
                                    data-harga2="{{ $item->harga_sewa2 }}"
                                    data-harga3="{{ $item->harga_sewa3 }}"
                                    data-kelipatan="{{ $item->kelipatan }}"
                                    data-stok="{{ $stokTampil }}">
                                {{ $item->nama_barang }} (Stok: {{ $stokTampil }})
                            </option>
                        @endif
                    @endforeach
                    </select>
                    <button class="btn btn-outline-secondary" type="button" id="addItemBtn">
                        <i class="fa-solid fa-plus" style="font-size: 20px;"></i>
                    </button>
                </div>
                <input type="hidden" name="barang_sewa[]" id="barangSewaInput">
                <input type="hidden" name="jumlah_sewa[]" id="jumlahSewaInput">
                <div id="selectedItems" style="margin-top: 10px;">
                    {{-- barang yang dipilih muncul di sini --}}
                </div>
            </div>

            <div class="input-data">
                <div class="content" for="total_bayar">Total Bayar</div>
                <input type="hidden" name="total_bayar" id="totalBayarRaw">
                <input type="text" name="total_bayar1" id="totalBayar" value="{{ $transaksi->total_bayar }}" readonly placeholder="Rp 0" onfocus="removeRupiahFormat(this)" onblur="applyRupiahFormat(this)">
            </div>
            <div class="bukti-bayar">
                <div class="input-data">
                    <div class="content">Bukti Pembayaran (jika pembayaran Non-Cash)</div>
                    <div class="metod">
                        <span>Metode Bayar :</span>
                        <input class="metod-input" type="text" name="metode_bayar" value="{{ $transaksi->metode_bayar }}">
                    </div>
                    @if($transaksi->bukti_bayar)
                        <div id="imagePreview">
                            <img src="{{ asset('storage/' . $transaksi->bukti_bayar) }}" alt="{{ $transaksi->bukti_bayar }}">
                        </div>
                    @else
                        <div>Tidak ada gambar saat ini.</div>
                    @endif
                </div>
            </div>

            <div class="btn-add-create"  id="addData">
                <div class="btn-add-data">
                    <button type="submit">Edit Data</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- JAVASCRIPT --}}
<script>
    // AUTOCOMPLETE NAMA CUSTOMER
    document.getElementById('nama_customer').addEventListener('input', function() {
        var inputNama = this.value;
        var datalistOptions = document.querySelectorAll('#datalistOptions option');
        var telpCustomer = document.getElementById('telp_customer');
        var alamatCustomer = document.getElementById('alamat_customer');

        // Reset the fields
        telpCustomer.value = '';
        alamatCustomer.value = '';

        // Cari option yang sesuai dengan nama yang dimasukkan
        datalistOptions.forEach(function(option) {
            if (option.value === inputNama) {
                // Isi nomor telepon dan alamat
                telpCustomer.value = option.getAttribute('data-telp');
                alamatCustomer.value = option.getAttribute('data-alamat');
            }
        });
    });

    // TANGGAL SEWA DAN TANGGAL KEMBALI
    const tanggalSewa = document.getElementById('tanggalSewa');
    const tanggalKembali = document.getElementById('tanggalKembali');
    const totalHari = document.getElementById('totalHari');

    tanggalSewa.addEventListener('change', function () {
        const selectedDate = this.value;
        tanggalKembali.setAttribute('min', selectedDate);
        calculateTotalHari();
    });

    tanggalKembali.addEventListener('change', function () {
        const kembaliDate = new Date(this.value);
        const sewaDate = new Date(tanggalSewa.value);

        if (kembaliDate < sewaDate) {
            alert('Tanggal kembali tidak boleh sebelum tanggal sewa!');
            this.value = '';
            totalHari.value = ''; // Reset total hari
        } else {
            calculateTotalHari(); // Hitung ulang total hari
        }
    });

    // Fungsi untuk menghitung total hari
    function calculateTotalHari() {
        const sewaDate = new Date(tanggalSewa.value);
        const kembaliDate = new Date(tanggalKembali.value);

        if (sewaDate && kembaliDate) {
            const timeDiff = kembaliDate - sewaDate; // Selisih waktu dalam milidetik
            const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)); // Konversi ke hari
            totalHari.value = daysDiff > 0 ? daysDiff + " hari" : "";
        } else {
            totalHari.value = ''; // Jika tanggal tidak lengkap, reset total hari
        }
    }

    window.addEventListener('DOMContentLoaded', function () {
        calculateTotalHari();
    });

    // ADD BARANG
    const addItemBtn = document.getElementById('addItemBtn');
    const selectBox = document.getElementById('inputGroupSelect04');
    const selectedItemsContainer = document.getElementById('selectedItems');
    const barangSewaInput = document.getElementById('barangSewaInput');
    const jumlahSewaInput = document.getElementById('jumlahSewaInput');
    const selectedItems = {};
    console.log(selectedItems);

    // EDIT
    // Ambil data dari hidden inputs dan tampilkan di halaman
    const dataSewa = @json($data_sewa);
    console.log(document.getElementById('totalBayar').value);

    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi selectedItems
        // const selectedItems = {};
        const selectedItemsContainer = document.getElementById('selectedItems');

        dataSewa.forEach(item => {
            const selectedValue = item.barang;
            const quantity = item.jumlah;
            console.log(selectedValue);
            console.log(quantity);

            // Ambil elemen berdasarkan ID barang (selectedValue)
            const selectedText = document.querySelector(`#inputGroupSelect04 option[value="${selectedValue}"]`)?.text;
            const hargaSewa1 = parseFloat(document.querySelector(`#inputGroupSelect04 option[value="${selectedValue}"]`)?.dataset.harga1 || 0);
            const hargaSewa2 = parseFloat(document.querySelector(`#inputGroupSelect04 option[value="${selectedValue}"]`)?.dataset.harga2 || 0);
            const hargaSewa3 = parseFloat(document.querySelector(`#inputGroupSelect04 option[value="${selectedValue}"]`)?.dataset.harga3 || 0);
            const kelipatan = parseFloat(document.querySelector(`#inputGroupSelect04 option[value="${selectedValue}"]`)?.dataset.kelipatan || 0);
            const totalHariNumber = totalHari.value.match(/\d+/) ? parseInt(totalHari.value.match(/\d+/)[0]) : 0;

            let hargaPerItem;
            if (totalHariNumber <= 1) {
                hargaPerItem = hargaSewa1;
            } else if (totalHariNumber <= 2) {
                hargaPerItem = hargaSewa2;
            } else if (totalHariNumber <= 3) {
                hargaPerItem = hargaSewa3;
            } else {
                const extraDays = totalHariNumber - 3;
                const additionalCost = extraDays * kelipatan;
                hargaPerItem = hargaSewa3 + additionalCost;
            }

            // Masukkan data ke dalam selectedItems
            selectedItems[selectedValue] = {
                name: selectedText,
                quantity: quantity,
                price: hargaPerItem
            };

            // Tambahkan item ke container tampilan
            const itemDiv = document.createElement('div');
            itemDiv.className = 'selected-item';
            itemDiv.dataset.value = selectedValue;
            itemDiv.innerHTML = `
                <span class="item-product">${selectedText}</span>
                <span class="item-quantity">Jumlah: ${quantity}</span>
                <span class="item-price">Harga: ${formatRupiah(hargaPerItem * quantity)}</span>
            `;

            const removeBtn = document.createElement('button');
            removeBtn.className = 'btn btn-danger btn-sm ms-2';
            removeBtn.textContent = 'X';
            removeBtn.addEventListener('click', function () {
                delete selectedItems[selectedValue];
                selectedItemsContainer.removeChild(itemDiv);
                updateHiddenInputs();
            });

            itemDiv.appendChild(removeBtn);
            selectedItemsContainer.appendChild(itemDiv);
        });

        updateHiddenInputs();
    });

    addItemBtn.addEventListener('click', function () {
        const selectedValue = selectBox.value;
        const selectedText = selectBox.options[selectBox.selectedIndex]?.text;
        const hargaSewa1 = parseFloat(selectBox.options[selectBox.selectedIndex]?.dataset.harga1 || 0);
        const hargaSewa2 = parseFloat(selectBox.options[selectBox.selectedIndex]?.dataset.harga2 || 0);
        const hargaSewa3 = parseFloat(selectBox.options[selectBox.selectedIndex]?.dataset.harga3 || 0);
        const kelipatan = parseFloat(selectBox.options[selectBox.selectedIndex]?.dataset.kelipatan || 0);
        const stokBarang = parseInt(selectBox.options[selectBox.selectedIndex]?.dataset.stok || 0);

        if (selectedValue === "" || !selectedValue) {
            alert('Pilih barang terlebih dahulu!');
            return;
        }

        const totalHariText = totalHari.value.match(/\d+/); // Ambil angka dari total hari
        const totalHariNumber = totalHariText ? parseInt(totalHariText[0]) : 0;

        let hargaPerItem;
        if (totalHariNumber <= 1) {
            hargaPerItem = hargaSewa1;
        } else if (totalHariNumber <= 2) {
            hargaPerItem = hargaSewa2;
        } else if (totalHariNumber <= 3) {
            hargaPerItem = hargaSewa3;
        } else {
            const extraDays = totalHariNumber - 3;
            const additionalCost = extraDays * kelipatan;
            hargaPerItem = hargaSewa3 + additionalCost;
        }

        // Jika barang sudah ada, tambahkan jumlahnya
        if (selectedItems[selectedValue]) {
            if (selectedItems[selectedValue].quantity >= stokBarang) {
                alert(`Stok tidak mencukupi! Maksimal hanya ${stokBarang} unit.`);
                return;
            }
            selectedItems[selectedValue].quantity += 1;

            // Update tampilan jumlah dan harga per item
            const itemElement = document.querySelector(`.selected-item[data-value="${selectedValue}"]`);
            itemElement.querySelector('.item-quantity').textContent = `Jumlah: ${selectedItems[selectedValue].quantity}`;
            itemElement.querySelector('.item-price').textContent = `Harga: Rp ${hargaPerItem * selectedItems[selectedValue].quantity}`;
        } else {
            if (stokBarang <= 0) {
                alert('Barang ini sudah habis stoknya!');
                return;
            }

            // Tambahkan barang baru
            selectedItems[selectedValue] = {
                name: selectedText,
                quantity: 1,
                price: hargaPerItem
            };

            const formattedPrice = formatRupiah(hargaPerItem);

            const itemDiv = document.createElement('div');
            itemDiv.className = 'selected-item';
            itemDiv.dataset.value = selectedValue;
            itemDiv.innerHTML = `
                <span class="item-product">${selectedText}</span>
                <span class="item-quantity">Jumlah: 1</span>
                <span class="item-price">Harga: ${formattedPrice}</span>
            `;

            const removeBtn = document.createElement('button');
            removeBtn.className = 'btn btn-danger btn-sm ms-2';
            removeBtn.textContent = 'X';
            removeBtn.addEventListener('click', function () {
                delete selectedItems[selectedValue];
                selectedItemsContainer.removeChild(itemDiv);
                updateHiddenInputs();
            });

            itemDiv.appendChild(removeBtn);
            selectedItemsContainer.appendChild(itemDiv);
        }

        updateHiddenInputs();
    });

    document.querySelector('#addData').addEventListener('click', function (e) {
        if (Object.keys(selectedItems).length === 0) {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Tambahkan minimal satu barang sebelum menyimpan transaksi!',
                icon: 'warning',
                position: 'bottom-end',
                toast: true,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: false,
            });
            e.preventDefault();
        }
    });

    // Format angka menjadi Rupiah
    function formatRupiah(number) {
        return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Hilangkan format Rupiah untuk nilai asli
    function removeRupiahFormat(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
        updateRawValue(input.value);
    }

    // Terapkan kembali format Rupiah
    function applyRupiahFormat(input) {
        const value = parseInt(input.value || 0);
        input.value = formatRupiah(value);
    }

    // Fungsi untuk memperbarui nilai murni di hidden input
    function updateRawValue(value) {
        const totalBayarRaw = document.getElementById('totalBayarRaw');
        totalBayarRaw.value = value;
    }

    // Fungsi untuk memperbarui input tersembunyi
    function updateHiddenInputs() {
        const barangSewa = [];
        const jumlahSewa = [];
        let totalHarga = 0;

        for (const [id, data] of Object.entries(selectedItems)) {
            barangSewa.push(id);
            jumlahSewa.push(data.quantity);
            totalHarga += data.price * data.quantity;
        }

        barangSewaInput.value = barangSewa.join(',');
        jumlahSewaInput.value = jumlahSewa.join(',');

        const totalBayarInput = document.getElementById('totalBayar');
        totalBayarInput.value = formatRupiah(totalHarga);

        console.log("Total Harga: ", totalHarga);
        console.log("Total Bayar Value: ", totalBayarInput.value);

        updateRawValue(totalHarga);
    }

    // Bukti bayar muncul saat non-cash
    document.addEventListener('DOMContentLoaded', function () {
        const opsiBayarSelect = document.querySelector('select[name="opsi_bayar"]');
        const buktiBayarSection = document.querySelector('.bukti-bayar');

        const toggleFields = () => {
            const isNonCash = opsiBayarSelect.value === 'Non-Cash';

            buktiBayarSection.style.display = isNonCash ? 'block' : 'none';

            buktiBayarSection.querySelectorAll('input').forEach(input => {
                input.required = isNonCash;
            });
        };

        toggleFields();

        opsiBayarSelect.addEventListener('change', toggleFields);
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
