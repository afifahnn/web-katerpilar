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
        <a href="{{ url('/kelola-customer') }}">
            <div class="btn-back">
                <button>
                    <i class="fa-solid fa-arrow-left" style="padding-right: 5px;"></i>
                    Back
                </button>
            </div>
        </a>

        <div class="create-container">
            <div class="grid-container">
                <div class="input-container">
                    <div class="content">Nama</div>
                    <input placeholder="Nama" required>
                </div>
                <div class="input-container">
                    <div class="content">Nomor Telepon</div>
                    <input placeholder="e.g. 081234567890" required>
                </div>
            </div>
            <div class="grid-container">
                <div class="input-container">
                    <div class="content">Alamat</div>
                    <input placeholder="Alamat" required>
                </div>
                <div class="input-container">
                    <div class="content">Email</div>
                    <input placeholder="Email" required>
                </div>
            </div>

            <div class="btn-add-create">
                <div class="btn-add-data">
                    <i class="fa-solid fa-plus" style="color: #FFFFFF; font-size: 20px;"></i>
                    <button>Tambah Data</button>
                </div>
            </div>
        </div>

    </div>
@endsection
