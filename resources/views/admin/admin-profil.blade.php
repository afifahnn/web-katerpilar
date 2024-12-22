@extends('admin-main-layout')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-profil.css') }}">
@endsection

@section('contents')
    <div id="admin-profil">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Kelola Data Keuangan</div>
            <div class="btn-logout">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <a class="nav-link"><button type="submit">Logout</button></a>
                </form>
            </div>
        </div>

        {{-- container --}}
        <div class="profil-container">
            <div class="grid-container">
                <div class="input-profil">
                    <div class="data-profil">Nama</div>
                    <input placeholder="Nama"></input>
                </div>
                <div class="input-profil">
                    <div class="data-profil">Nomor Telepon</div>
                    <input placeholder="Nomor Telepon"></input>
                </div>
            </div>
            <div class="grid-container">
                <div class="input-profil">
                    <div class="data-profil">Username</div>
                    <input placeholder="Username"></input>
                </div>
                <div class="input-profil">
                    <div class="data-profil">Email</div>
                    <input placeholder="Email"></input>
                </div>
            </div>
            <div class="grid-container">
                <div class="input-profil">
                    <div class="data-profil">Password</div>
                    <input placeholder="Password"></input>
                </div>
            </div>
            <div class="btn-profil">
                <div class="btn-edit-profil">
                    <i class="fa-solid fa-pen-to-square" style="color: #FFFFFF; font-size: 20px;"></i>
                    <button>Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
