@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endsection

@section('contents')
    <div id="dashboard">
        <div class="dashboard-top">
            <div class="dashboard-judul">Dashboard</div>
            <div class="btn-logout">
                <button>Logout</button>
            </div>
        </div>
        <div style="padding: 20px;">
            <div class="dashboard-container">
                <div class="dashboard-card">
                    <i class="fa-solid fa-headset"></i>
                    <div>
                        <div style="font-weight: 600; font-size: 16px">Data Customer</div>
                        <div>12 orang</div>
                    </div>
                </div>
                <div class="dashboard-card">
                    <i class="fa-solid fa-toolbox"></i>
                    <div>
                        <div style="font-weight: 600; font-size: 16px">Data Stok Barang</div>
                        <div>50 barang</div>
                    </div>
                </div>
            </div>
            <div class="dashboard-container">
                <div class="dashboard-card">
                    <i class="fa-solid fa-money-bills"></i>
                    <div>
                        <div style="font-weight: 600; font-size: 16px">Laba</div>
                        <div>Rp 100.000</div>
                    </div>
                </div>
                <div class="dashboard-card">
                    <i class="fa-solid fa-money-bill-trend-up"></i>
                    <div>
                        <div style="font-weight: 600; font-size: 16px">Omzet</div>
                        <div>Rp 300.000</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
