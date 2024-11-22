@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
@endsection

@section('contents')
    <div id="kelola-customer">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Kelola Data Customer</div>
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
            <a href="{{ route('admin.kelola-customer.create') }}">
                <div class="btn-add">
                    <i class="fa-solid fa-plus" style="color: #FFFFFF; font-size: 20px"></i>
                    <button>Tambah Data</button>
                </div>
            </a>
        </div>

        {{-- tabel --}}
        <div class="tabel">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telp.</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customer as $index => $customer)
                    <tr>
                        <td>{{ $customer->id }}.</td>
                        <td>{{ $customer->nama_customer}}</td>
                        <td>{{ $customer->alamat_customer}}</td>
                        <td>{{ $customer->telp_customer}}</td>
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
