@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/create-customer.css') }}">
@endsection

@section('contents')
    <div id="create-customer">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Tambah Data Customer</div>
            <div class="btn-logout">
                <button>Logout</button>
            </div>
        </div>
        <div class="btn-back">
            <a href="{{ url('/kelola-customer') }}">
                <button>
                    <i class="fa-solid fa-arrow-left" style="padding-right: 5px;"></i>
                    Back
                </button>
            </a>
        </div>

        <div class="create-container">
            <form action="{{ route('admin.kelola-customer.store') }}" method="post">
                @csrf
                <div class="input-data">
                    <div class="content" for="nama_customer">Nama</div>
                    <input type="text" name="nama_customer" id="nama_customer" placeholder="Nama" required>
                </div>
                <div class="grid-container">
                    <div class="input-container">
                        <div class="content" for="alamat_customer">Alamat</div>
                        <input type="text" name="alamat_customer" id="alamat_customer" placeholder="Alamat" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="telp_customer">Nomor Telepon</div>
                        <input type="text" name="telp_customer" id="telp_customer" placeholder="e.g. 081234567890" required>
                    </div>
                </div>

                <div class="btn-add-create">
                    <div class="btn-add-data">
                        <i class="fa-solid fa-plus" style="color: #FFFFFF; font-size: 20px;"></i>
                        <button type="submit">Tambah Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
