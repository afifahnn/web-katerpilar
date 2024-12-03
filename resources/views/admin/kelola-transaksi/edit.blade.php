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
            <button>Logout</button>
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
                <input type="text" name="nama_customer" value="{{ $transaksi->customer->nama_customer }}" required>
            </div>
            <div class="grid-container">
                <div class="input-container">
                    <div class="content" for="telp_customer">Nomor Telepon</div>
                    <input type="text" name="telp_customer" value="{{ $transaksi->customer->telp_customer }}" required>
                </div>
                <div class="input-container">
                    <div class="content" for="alamat_customer">Alamat</div>
                    <input type="text" name="alamat_customer" value="{{ $transaksi->customer->alamat_customer }}" required>
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
                <div class="input-container">
                    <div class="content" for="opsi_bayar">Opsi Bayar</div>
                    <div class="input-group">
                        <select class="form-select" id="inputGroupSelect" name="opsi_bayar" required>
                            <option value="" disabled {{ $transaksi->opsi_bayar == null ? 'selected' : '' }}>Pilih...</option>
                            <option value="Cash" {{ $transaksi->opsi_bayar == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Non-Cash" {{ $transaksi->opsi_bayar == 'Non-Cash' ? 'selected' : '' }}>Non-Cash</option>
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
                            <option value="{{ $item->nama_barang }}" disabled>
                                {{ $item->nama_barang }} (Stok : {{ $item->stok_barang }})
                            </option>
                        @else
                            <option value="{{ $item->nama_barang }}">
                                {{ $item->nama_barang }} (Stok : {{ $item->stok_barang }})
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
                <input type="number" name="total_bayar">
                @error('total_bayar')
                    <small style="color: red;">{{ $message }}</small>
                @enderror
                {{-- <div id="totalBayar" class="form-control" readonly>Rp 0</div> --}}
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
    // TANGGAL SEWA DAN TANGGAL KEMBALI
    const tanggalSewa = document.getElementById('tanggalSewa');
    const tanggalKembali = document.getElementById('tanggalKembali');

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

        if (selectedValue === "" || !selectedValue) {
            alert('Pilih barang terlebih dahulu!');
            return;
        }

        // Jika barang sudah ada, tambahkan jumlahnya
        if (selectedItems[selectedValue]) {
            selectedItems[selectedValue].quantity += 1;

            // Update tampilan jumlah
            const itemElement = document.querySelector(`.selected-item[data-value="${selectedValue}"]`);
            itemElement.querySelector('.item-quantity').textContent = `Jumlah: ${selectedItems[selectedValue].quantity}`;
        } else {
            // Tambahkan barang baru
            selectedItems[selectedValue] = {
                name: selectedText,
                quantity: 1
            };

            const itemDiv = document.createElement('div');
            itemDiv.className = 'selected-item';
            itemDiv.dataset.value = selectedValue;
            itemDiv.innerHTML = `
                ${selectedText} <span class="item-quantity">Jumlah: 1</span>
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
    });

    document.querySelector('form').addEventListener('submit', function (e) {
        // Cek apakah ada barang yang ditambahkan
        if (Object.keys(selectedItems).length === 0) {
            alert('Tambahkan minimal satu barang sebelum menyimpan transaksi!');
            e.preventDefault(); // Mencegah form dikirim
        }
    });

    // Fungsi untuk memperbarui input tersembunyi
    function updateHiddenInputs() {
        const barangSewa = [];
        const jumlahSewa = [];

        for (const [id, data] of Object.entries(selectedItems)) {
            barangSewa.push(id);
            jumlahSewa.push(data.quantity);
        }

        barangSewaInput.value = barangSewa;
        jumlahSewaInput.value = jumlahSewa;
    }

</script>
@endsection