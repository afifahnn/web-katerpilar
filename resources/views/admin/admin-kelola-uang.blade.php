@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-uang.css') }}">
@endsection

@section('contents')
    <div id="kelola-keuangan">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Kelola Data Keuangan</div>
            <div class="btn-logout">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <a class="nav-link"><button type="submit">Logout</button></a>
                </form>
            </div>
        </div>

        {{-- search dan add data --}}
        <div class="bar-top">
            <div class="search-bar">
                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Search . . ." aria-label="Username" aria-describedby="addon-wrapping">
                </div>
            </div>
            <a href="{{ route('admin.kelola-keuangan.create') }}">
                <div class="btn-add">
                    <i class="fa-solid fa-plus" style="color: #FFFFFF; font-size: 20px"></i>
                    <button>Tambah Data</button>
                </div>
            </a>
        </div>

        {{-- tabel --}}
        <div class="tabel">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tgl Transaksi</th>
                        <th>Jenis Transaksi</th>
                        <th>Nominal</th>
                        <th class="col-deskripsi" rowspan="2">Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keuangan as $index => $item)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>
                            @if ($item->transaksi)
                                {{ \Carbon\Carbon::parse($item->transaksi->tgl_sewa)->format('d/m/Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($item->tgl_transaksi)->format('d/m/Y') }}
                            @endif
                        </td>
                        <td>{{ ucwords($item->jenis_transaksi) }}</td>
                        <td>
                            @if ($item->transaksi)
                                Rp {{ number_format($item->transaksi->total_bayar, 0, ',', '.') }}
                            @else
                                Rp {{ number_format($item->nominal, 0, ',', '.') }}
                            @endif
                        </td>
                        <td class="col-deskripsi">{{ $item->deskripsi }}</td>
                        <td>
                            <div class="btn-aksi">
                                <form action="{{ route('admin.kelola-keuangan.delete', $item->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-hapus" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                        <i class="fa-solid fa-trash" style="color: #FFFFFF"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.kelola-keuangan.edit', $item->id) }}">
                                    <button class="btn-edit">
                                        <i class="fa-solid fa-pen-to-square" style="color: #FFFFFF"></i>
                                    </button>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Lihat Laporan Keuangan --}}
        {{-- <div class="laporan-container">
            <div class="lihat-laporan">Lihat Laporan Keuangan :</div>
            <div class="btn-laporan">
                <div class="btn-bulan">
                    <button>Lihat per Bulan</button>
                </div>
                <a href="{{ route('admin.kelola-keuangan.laporan-keuangan') }}">
                    <div class="btn-lap">
                        <button>Lihat Keseluruhan</button>
                    </div>
                </a>
            </div>
        </div> --}}
    </div>
@endsection
