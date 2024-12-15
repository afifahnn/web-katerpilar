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
        @foreach($barang->groupBy('jenis')->sortKeys() as $jenis => $barangs)
        <div class="jenis-barang">
            {{ $jenis }}
        </div>

        <div class="carousel-section">
            {{-- <button class="carousel-btn-left" onclick="scrollLeft()">&#10094;</button> --}}
            <div class="scroll-container">
                @foreach($barangs as $barang)
                <div class="card-container">
                    <div class="pic-barang">
                        <img src="{{ asset('storage/' . $barang->gambar_barang) }}" alt="barang">
                    </div>
                    <div class="product">
                        <div class="name">{{ $barang->nama_barang }}</div>
                        <div class="stok">
                            Stok :
                            @if($barang->stok_barang == 0)
                                <span style="color: red;">Habis</span>
                            @else
                                {{ $barang->stok_barang }}
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{-- <button class="carousel-btn-right" onclick="scrollRight()">&#10095;</button> --}}
        </div>
        @endforeach

    </div>
</div>

<!-- JavaScript -->
<script>
    function scrollLeft() {
        const container = document.querySelector('.scroll-container');
        container.scrollBy({ left: -80, behavior: 'smooth' });
    }

    function scrollRight() {
        const container = document.querySelector('.scroll-container');
        container.scrollBy({ left: 80, behavior: 'smooth' });
    }
</script>

@endsection
