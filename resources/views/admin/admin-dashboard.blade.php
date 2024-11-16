@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endsection

@section('contents')
    <div id="dashboard">
        <div class="dashboard-judul">Dashboard</div>
        <div>
            <div class="dashboard-container">
                <div class="dashboard-card">
                    <div style="font-weight: 600">Data Customer</div>
                    <div>12 orang</div>
                </div>
                <div class="dashboard-card">
                    <div style="font-weight: 600">Data Stok Barang</div>
                    <div>50 barang</div>
                </div>
            </div>
            <div class="dashboard-container">
                <div class="dashboard-card">
                    <div style="font-weight: 600">Laba</div>
                    <div>Rp 100.000</div>
                </div>
                <div class="dashboard-card">
                    <div style="font-weight: 600">Omzet</div>
                    <div>Rp 300.000</div>
                </div>
            </div>
        </div>
    </div>
@endsection
