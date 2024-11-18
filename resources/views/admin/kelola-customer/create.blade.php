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
            <button>
                <i class="fa-solid fa-arrow-left" style="padding-right: 5px;"></i>
                Back
            </button>
        </div>

        <div>
            <div>Nama</div>
        </div>

    </div>
@endsection
