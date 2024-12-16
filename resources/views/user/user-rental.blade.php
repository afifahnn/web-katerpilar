@extends('user-main-layout')

@section('user-extra-css')
    <link rel="stylesheet" href="{{ asset('css/user/user-rental.css') }}">
@endsection

@section('user-contents')
<div id="user-rental">
    <div class="container-rental">
        <div class="judul-rental">FORM PEMESANAN</div>
        {{-- <form action="{{ route('admin.kelola-transaksi.store') }}" method="post" enctype="multipart/form-data">
            @csrf --}}
            <div class="input-data">
                <div class="content" for="nama_customer">Nama</div>
                <input class="form-control" name="nama_customer" list="datalistOptions" id="nama_customer" placeholder="Nama">
                <datalist id="datalistOptions">
                    @foreach ( $customer as $index => $customer )
                        <option value="{{ $customer->nama_customer }}" data-telp="{{ $customer->telp_customer }}" data-alamat="{{ $customer->alamat_customer }}">
                    @endforeach
                </datalist>
            </div>
            <div class="grid-container">
                <div class="input-container">
                    <div class="content" for="telp_customer">Nomor Telepon</div>
                    <input type="text" id="telp_customer" name="telp_customer" placeholder="e.g. 081234567890" required>
                </div>
                <div class="input-container">
                    <div class="content" for="alamat_customer">Alamat</div>
                    <input type="text" id="alamat_customer" name="alamat_customer" placeholder="Alamat" required>
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
                                    data-harga3="{{ $item->harga_sewa3 }}" disabled>
                                {{ $item->nama_barang }} (Stok: {{ $item->stok_barang }})
                            </option>
                        @else
                            <option value="{{ $item->nama_barang }}"
                                    data-harga1="{{ $item->harga_sewa1 }}"
                                    data-harga2="{{ $item->harga_sewa2 }}"
                                    data-harga3="{{ $item->harga_sewa3 }}">
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

            <div class="btn-add-create">
                <div class="btn-add-data">
                    <button type="submit">Tambah Data</button>
                </div>
            </div>
        {{-- </form> --}}
    </div>
</div>
@endsection
