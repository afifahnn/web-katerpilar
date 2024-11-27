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
            <form action="{{ route('admin.kelola-barang.update', $barang->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="grid-container">
                    <div class="input-container">
                        <div class="content" for="nama_barang">Nama Barang</div>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ $barang->nama_barang }}" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="jenis">Jenis Barang</div>
                        <input type="text" name="jenis" id="jenis" value="{{ $barang->jenis }}" required>
                    </div>
                </div>
                <div class="grid-container">
                    <div class="input-container">
                        <div class="content" for="stok_barang">Stok Barang</div>
                        <input type="number" name="stok_barang" id="stok_barang" value="{{ $barang->stok_barang }}" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="deskripsi_barang">Deskripsi</div>
                        <input type="text" name="deskripsi_barang" id="deskripsi_barang" value="{{ $barang->deskripsi_barang }}" required>
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
                        <input type="text" name="harga_sewa1" id="harga_sewa1" class="currency-input" value="{{ $barang->harga_sewa1 }}" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="harga_sewa2">2 Hari</div>
                        <input type="text" name="harga_sewa2" id="harga_sewa2" class="currency-input" value="{{ $barang->harga_sewa2 }}" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="harga_sewa3">3 Hari</div>
                        <input type="text" name="harga_sewa3" id="harga_sewa3" class="currency-input" value="{{ $barang->harga_sewa3 }}" required>
                    </div>
                </div>
                <div class="input-data">
                    <div class="content" for="gambar_barang">Gambar</div>
                    <input type="file" name="gambar_barang" accept="image/*" required id="imageInput">
                    @if($barang->gambar_barang)
                        <div id="imagePreview">
                            <img id="preview" src="{{ asset($barang->gambar_barang) }}" alt="{{ $barang->gambar_barang }}">
                        </div>
                    @endif
                </div>

                <div class="btn-add-create">
                    <div class="btn-add-data">
                        <button type="submit">Edit Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
