@extends('admin-main-layout')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-profil.css') }}">
@endsection

@section('contents')
    <div id="admin-profil">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Profil Admin</div>
            <div class="btn-logout">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <a class="nav-link"><button type="submit">Logout</button></a>
                </form>
            </div>
        </div>

        {{-- container --}}
        <div class="profil-container">
            <div class="info-profil">
                <div style="font-weight: 600">
                    <div>Nama</div>
                    <div>Username</div>
                    <div>Nomor Telepon</div>
                    <div>Jenis Pembayaran</div>
                    <div>Nomor Rekening</div>
                </div>
                <div>
                    <div>:</div>
                    <div>:</div>
                    <div>:</div>
                    <div>:</div>
                    <div>:</div>
                </div>
                <div>
                    <div>{{ $admin->nama_admin }}</div>
                    <div>{{ $admin->username }}</div>
                    <div>{{ $admin->telp_admin }}</div>
                    <div>{{ $admin->jenis_rekening }}</div>
                    <div>{{ $admin->no_rekening }}</div>
                </div>
            </div>

            <div class="btn-profil-2">
                <div class="btn-edit-profil-2">
                    <i class="fa-solid fa-pen-to-square" style="color: #000000; font-size: 20px;"></i>
                    <a href="{{ url('/admin-update-profil') }}">
                        <button>Edit Profil</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
