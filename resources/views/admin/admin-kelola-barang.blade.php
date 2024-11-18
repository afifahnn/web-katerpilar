@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-barang.css') }}">
@endsection

@section('contents')
    <div id="kelola-barang">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Kelola Data Barang</div>
            <div class="btn-logout">
                <button>Logout</button>
            </div>
        </div>

        {{-- search dan add data --}}
        <div class="bar-top">
            <div class="search-bar">
                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Search . . ." aria-label="Username" aria-describedby="addon-wrapping">
                </div>
            </div>
            <div class="btn-add">
                <i class="fa-solid fa-plus" style="color: #FFFFFF; font-size: 20px"></i>
                <button>Tambah Data</button>
            </div>
        </div>

        {{-- tabel --}}
        <div class="tabel">
            <table class="data-table">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th class="pic-head" rowspan="2">Gambar</th>
                        <th rowspan="2">Jenis</th>
                        <th rowspan="2">Nama Barang</th>
                        <th rowspan="2">Stok</th>
                        <th colspan="3">Harga Sewa</th>
                        <th class="col-deskripsi" rowspan="2">Deskripsi</th>
                        <th rowspan="2">Aksi</th>
                    </tr>
                    <tr>
                        <th>1 Hari</th>
                        <th>2 Hari</th>
                        <th>3 Hari</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barang as $index => $barang)
                    <tr>
                        <td>{{ $barang->id }}.</td>
                        <td class="pic-barang">{{ $barang->gambar_barang }}</td>
                        <td>{{ $barang->jenis }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->stok_barang }}</td>
                        <td>Rp {{ number_format($barang->harga_sewa1, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($barang->harga_sewa2, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($barang->harga_sewa3, 0, ',', '.') }}</td>
                        <td class="col-deskripsi">{{ $barang->deskripsi_barang }}</td>
                        <td class="btn-aksi">
                            <button class="btn-hapus">
                                <i class="fa-solid fa-trash" style="color: #FFFFFF"></i>
                            </button>
                            <button class="btn-edit">
                                <i class="fa-solid fa-pen-to-square" style="color: #FFFFFF"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
