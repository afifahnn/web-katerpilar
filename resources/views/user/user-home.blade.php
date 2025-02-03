@extends('user-main-layout')

@section('user-extra-css')
    <link rel="stylesheet" href="{{ asset('css/user/user-home.css') }}">
@endsection

@section('user-contents')
<div id="user-home">
    {{-- alert login --}}
    @if(!Auth::check())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Silahkan Login",
                    text: "Silahkan login terlebih dahulu untuk melakukan pemesanan barang.",
                    icon: "warning",
                    confirmButtonText: "Login",
                    showCancelButton: true,
                    cancelButtonText: "Nanti Saja"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('login') }}";
                    }
                });
            });
        </script>
    @endif

    {{-- HERO SECTION --}}
    <div class="hero-section">
        <div class="img-bg">
            <img src="{{ asset('img/bg11.jpg') }}" alt="Background">
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

    {{-- SEARCH BAR --}}
    <div class="search-bar">
        <div class="input-group flex-nowrap">
            <span class="input-group-text" id="addon-wrapping">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" id="search-input" class="form-control" placeholder="Search . . ." aria-label="Username" aria-describedby="addon-wrapping">
        </div>
    </div>

    <div id="not-found" class="text-center" style="display: none; margin-top: 20px; font-weight: 600; color: rgb(68, 68, 68);">
        Pencarian tidak ditemukan.
    </div>

    @if ($barang->isEmpty())
        <div class="alert alert-warning barang-empty">Belum ada alat yang disewakan saat ini</div>
    @endif

    {{-- KATALOG SECTION --}}
    <div class="katalog-section">
        @foreach($barang->groupBy('jenis')->sortKeys() as $jenis => $barangs)
        <div class="jenis-wrapper">
            <div class="jenis-barang">
                {{ $jenis }}
            </div>

            <div class="carousel-section">
                <div class="scroll-container">
                    @foreach($barangs as $barang)
                    <button type="button" class="btn p-0 shadow-none {{ $barang->stok_barang <= 0 ? 'disabled-barang' : '' }}" data-bs-toggle="modal" data-bs-target="#modalBarang{{ $barang->id }}">
                        <div class="card-container" data-name="{{ strtolower($barang->nama_barang) }}">
                            <div class="pic-barang">
                                <img src="{{ asset('storage/' . $barang->gambar_barang) }}" alt="barang">
                            </div>
                            <div class="product">
                                <div class="name">{{ $barang->nama_barang }}</div>
                                <div class="harga">
                                    Harga :
                                    Rp {{ number_format($barang->harga_sewa1, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </button>

                    {{-- MODAL --}}
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
                                            @if($barang->stok_barang <= 0)
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
                                            <div>
                                                <div>1 hari</div>
                                                <div>2 hari</div>
                                                <div>3 hari</div>
                                            </div>
                                            <div>
                                                <div>:</div>
                                                <div>:</div>
                                                <div>:</div>
                                            </div>
                                            <div>
                                                <div>Rp {{ number_format($barang->harga_sewa1, 0, ',', '.') }}</div>
                                                <div>Rp {{ number_format($barang->harga_sewa2, 0, ',', '.') }}</div>
                                                <div>Rp {{ number_format($barang->harga_sewa3, 0, ',', '.') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- INFORMATION SECTION --}}
    <div class="information-section">
        <div><i class="fa-solid fa-circle-info" style="font-size: 24px; color: #000000"></i></div>
        <div class="info-sk">
            <span>Syarat & Ketentuan</span>
            <ul>
                <li>Penyewa meninggalkan identitas diri KTP/kartu pelajar berlaku sebagai jaminan.</li>
                <li>Pemesanan alat dapat dilakukan via sistem atau datang langsung ke toko.</li>
                <li>Pelunasan transaksi maksimal saat ambil alat.</li>
                <li>Hitungan sewa 1 hari = 2 hari 1 malam.</li>
                <li>Harga sewa jika lebih dari 3 hari menyesuaikan.</li>
                <li>Jika ada kehilangan atau kerusakan alat ditanggung penyewa.</li>
            </ul>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    // SEARCH
    document.getElementById('search-input').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const jenisWrappers = document.querySelectorAll('.jenis-wrapper');
        let totalMatches = 0;

        jenisWrappers.forEach(wrapper => {
            const items = wrapper.querySelectorAll('.card-container');
            let hasMatch = false;

            items.forEach(item => {
                const name = item.getAttribute('data-name');
                if (name.includes(query)) {
                    item.parentElement.style.display = '';
                    hasMatch = true;
                    totalMatches++;
                } else {
                    item.parentElement.style.display = 'none';
                }
            });

            if (hasMatch) {
                wrapper.style.display = '';
            } else {
                wrapper.style.display = 'none';
            }
        });

        const notFoundMessage = document.getElementById('not-found');
        if (totalMatches === 0) {
            notFoundMessage.style.display = 'block';
        } else {
            notFoundMessage.style.display = 'none';
        }
    });
</script>

@endsection
