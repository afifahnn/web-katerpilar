@extends('user-main-layout')

@section('user-extra-css')
    <link rel="stylesheet" href="{{ asset('css/user/user-rental.css') }}">
@endsection

@section('user-contents')
<div id="user-rental">
    <div class="container-rental">
        <div class="judul-rental">FORM PEMESANAN</div>
        <form id="rentalForm" action="{{ route('user.rental') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="input-data">
                <div class="content" for="nama_customer">Nama</div>
                <input class="form-control" name="nama_customer" list="datalistOptions" id="nama_customer" placeholder="Nama" value="{{ Auth::guard('customer')->user()->nama_customer }}" required>
            </div>
            <div class="grid-container">
                <div class="input-container">
                    <div class="content" for="telp_customer">Nomor Telepon</div>
                    <input type="text" id="telp_customer" name="telp_customer" placeholder="e.g. 081234567890" value="{{ Auth::guard('customer')->user()->telp_customer }}" required>
                </div>
                <div class="input-container">
                    <div class="content" for="alamat_customer">Alamat</div>
                    <input type="text" id="alamat_customer" name="alamat_customer" placeholder="Alamat" value="{{ Auth::guard('customer')->user()->alamat_customer }}" required>
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
                <div class="content">Total Hari</div>
                <input type="text" id="totalHari" readonly placeholder="Total hari akan muncul di sini">
            </div>
            <div class="input-data">
                <div class="input-container">
                    <div class="content" for="opsi_bayar">Opsi Bayar</div>
                    <div class="input-group">
                        <select class="form-select" id="inputGroupSelect" name="opsi_bayar" required>
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
                    <select class="form-select" id="inputGroupSelect04">
                    <option value="" disabled selected>Pilih...</option>
                    @foreach ($barang as $index => $item)
                        @if ($item->stok_barang == 0)
                            <option value="{{ $item->nama_barang }}"
                                    data-harga1="{{ $item->harga_sewa1 }}"
                                    data-harga2="{{ $item->harga_sewa2 }}"
                                    data-harga3="{{ $item->harga_sewa3 }}"
                                    data-kelipatan="{{ $item->kelipatan }}"
                                    data-stok="{{ $item->stok_barang }}" disabled>
                                {{ $item->nama_barang }} (Stok: {{ $item->stok_barang }})
                            </option>
                        @else
                            <option value="{{ $item->nama_barang }}"
                                    data-harga1="{{ $item->harga_sewa1 }}"
                                    data-harga2="{{ $item->harga_sewa2 }}"
                                    data-harga3="{{ $item->harga_sewa3 }}"
                                    data-kelipatan="{{ $item->kelipatan }}"
                                    data-stok="{{ $item->stok_barang }}">
                                {{ $item->nama_barang }} (Stok: {{ $item->stok_barang }})
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
                    {{-- pilihan akan muncul di sini --}}
                </div>
            </div>
            <div class="input-data">
                <div class="content" for="total_bayar">Total Bayar</div>
                <input type="hidden" name="total_bayar" id="totalBayarRaw">
                <input type="text" name="total_bayar1" id="totalBayar" readonly placeholder="Rp 0" onfocus="removeRupiahFormat(this)" onblur="applyRupiahFormat(this)">
            </div>

            <div class="bukti-bayar">
                <div class="input-data">
                    <div class="content-tf">Silahkan transfer di nomor rekening berikut :</div>
                    <div class="norek-content">
                        <div class="bank-content">{{ $admin->jenis_rekening }}</div>
                        <div class="norek">{{ $admin->no_rekening }}</div>
                    </div>
                </div>
                <div class="input-data">
                    <div class="content" for="metode_bayar">Metode Pembayaran</div>
                    <input type="text" name="metode_bayar" placeholder="e.g. Transfer Bank B**"></input>
                </div>
                <div class="input-data">
                    <div class="content" for="bukti_bayar">Upload Bukti Pembayaran</div>
                    <input type="file" name="bukti_bayar" accept="image/*" id="imageInput">
                    <div id="imagePreview">
                        <img id="preview" src="" alt="Preview Gambar">
                    </div>
                </div>
            </div>

            <div class="btn-add-create" id="addData">
                <div class="btn-add-data">
                    <button type="submit">Pesan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- JAVASCRIPT --}}
<script>
    // TANGGAL SEWA DAN TANGGAL KEMBALI
    const tanggalSewa = document.getElementById('tanggalSewa');
    const tanggalKembali = document.getElementById('tanggalKembali');
    const totalHari = document.getElementById('totalHari');

    const today = new Date().toISOString().split('T')[0];
    tanggalSewa.setAttribute('min', today);

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
            totalHari.value = '';
        } else {
            calculateTotalHari();
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

    // ADD BARANG
    const addItemBtn = document.getElementById('addItemBtn');
    const selectBox = document.getElementById('inputGroupSelect04');
    const selectedItemsContainer = document.getElementById('selectedItems');
    const barangSewaInput = document.getElementById('barangSewaInput');
    const jumlahSewaInput = document.getElementById('jumlahSewaInput');
    const selectedItems = {}; // Menyimpan data barang dan jumlah

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
        }
        else {
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

            // Update tampilan jumlah
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

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(number);
    }

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
        totalBayarRaw.value = value; // Simpan nilai asli
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

        barangSewaInput.value = barangSewa;
        jumlahSewaInput.value = jumlahSewa;

        const totalBayarInput = document.getElementById('totalBayar');
        totalBayarInput.value = formatRupiah(totalHarga);

        updateRawValue(totalHarga);
    }

    // PREVIEW GAMBAR
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

    // SWAL
    @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @endif

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
</script>
@endsection
