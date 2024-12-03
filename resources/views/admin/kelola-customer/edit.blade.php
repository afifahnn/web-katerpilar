@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/create-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/edit-customer.css') }}">
@endsection

@section('contents')
    <div id="edit-customer">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Edit Data Customer</div>
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
            <form action="{{ route('admin.kelola-customer.update', $customer->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="input-data">
                    <div class="content" for="nama_customer">Nama</div>
                    <input type="text" name="nama_customer" id="nama_customer" value="{{ $customer->nama_customer }}" required>
                </div>
                <div class="grid-container">
                    <div class="input-container">
                        <div class="content" for="alamat_customer">Alamat</div>
                        <input type="text" name="alamat_customer" id="alamat_customer" value="{{ $customer->alamat_customer }}" required>
                    </div>
                    <div class="input-container">
                        <div class="content" for="telp_customer">Nomor Telepon</div>
                        <input type="text" name="telp_customer" id="telp_customer" value="{{ $customer->telp_customer }}" required>
                    </div>
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
