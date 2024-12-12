@extends('user-main-layout')

@section('user-extra-css')
    <link rel="stylesheet" href="{{ asset('css/user/user-home.css') }}">
@endsection

@section('user-contents')
<div id="user-home">
    {{-- HERO SECTION --}}
    <div class="hero-section">
        <div class="img-bg">
            <img src="{{ asset('img/bg.jpg') }}" alt="Background">
        </div>
        <div class="span-text">
            <div>Selamat Datang</div>
            <div>Katerpilar Outdoor Gear & Rental</div>
        </div>
        <div class="scroll-text">
            <i class="fa-solid fa-computer-mouse"></i>
            <i class="fa-solid fa-angles-down"></i>
            <div>scroll ke bawah untuk melihat katalog</div>
        </div>
    </div>

    {{-- KATALOG SECTION --}}
    <div class="katalog-section">
        <div class="jenis-barang">
            Tenda
        </div>
        <div class="carousel-section">
            <div class="card-container">
                <img alt="barang"></img>
                <div>Tenda Dome 6p</div>
                <div>Stok : 6</div>
            </div>
            <div class="card-container">
                <img alt="barang"></img>
                <div>Tenda Dome 6p</div>
                <div>Stok : 6</div>
            </div>
        </div>
    </div>
</div>
@endsection
