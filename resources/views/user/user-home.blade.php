@extends('user-main-layout')

@section('user-extra-css')
    <link rel="stylesheet" href="{{ asset('css/user/user-home.css') }}">
@endsection

@section('user-contents')
<div id="user-home">
    {{-- HERO SECTION --}}
    <div class="hero-section">
        <div class="img-bg">
            <img src="{{ asset('img/bg1.jpg') }}" alt="Background">
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
                <button type="button" class="btn p-0 shadow-none" data-bs-toggle="modal" data-bs-target="#modalBarang{{ $barang->id }}">
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
                </button>

                <div class="modal fade" id="modalBarang{{ $barang->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Barang</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="content-modal">
                                <img src="{{ asset('storage/' . $barang->gambar_barang) }}" alt="Foto produk">
                                <div class="judul-modal">
                                    <div class="nama-modal">{{ $barang->nama_barang }}</div>
                                    <div class="stok-modal">
                                        Stok Barang :
                                        @if($barang->stok_barang == 0)
                                            <span style="color: red;">Habis</span>
                                        @else
                                            {{ $barang->stok_barang }} item
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="judul-desk">Deskripsi :</div>
                                <div class="isi-modal">
                                    <div class="desk-modal">{!! nl2br(e($barang->deskripsi_barang)) !!}</div>
                                    <div class="harga-sewa">Harga Sewa :</div>
                                    <div class="harga-modal">
                                        <div>1 hari : Rp {{ number_format($barang->harga_sewa1, 0, ',', '.') }}</div>
                                        <div>2 hari : Rp {{ number_format($barang->harga_sewa2, 0, ',', '.') }}</div>
                                        <div>3 hari : Rp {{ number_format($barang->harga_sewa3, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
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
