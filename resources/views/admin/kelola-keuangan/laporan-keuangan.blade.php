@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/create-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-keuangan/laporan-keuangan.css') }}">
@endsection

@section('contents')
<div id="laporan-keuangan">
    <div class="kelola-cust-top">
        <div class="kelola-cust-judul">Laporan Keuangan</div>
        <div class="btn-logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <a class="nav-link"><button type="submit">Logout</button></a>
            </form>
        </div>
    </div>

    {{-- recap keuangan --}}
    <div class="bar-recap">
        <div class="recap-card-all">
            <div class="recap-card">
                <i class="fa-solid fa-money-bills"></i>
                <div>
                    <div class="recap-content">Laba</div>
                    <div class="laba-omzet">Rp {{ number_format($totalLaba, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="recap-card">
                <i class="fa-solid fa-money-bill-trend-up"></i>
                <div>
                    <div class="recap-content">Omzet</div>
                    <div class="laba-omzet">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- filter tampilan per periode --}}
    <div class="filter-date">
        <div class="judul-filter">Laporan Keuangan per Periode</div>
        <div class="top-btn">
            <form method="GET" action="{{ route('laporankeuangan') }}">
                <div class="display-tanggal">
                    <div class="input-tgl">
                        <div class="content-tgl">Tanggal Awal</div>
                        <input type="date" name="tanggal_awal" id="tanggalAwal" value="{{ request('tanggal_awal') }}">
                    </div>
                    <div class="input-tgl">
                        <div class="content-tgl">Tanggal Akhir</div>
                        <input type="date" name="tanggal_akhir" id="tanggalAkhir" value="{{ request('tanggal_akhir') }}">
                    </div>
                    <div class="btn-apply">
                        <button type="submit">Terapkan</button>
                    </div>
                </div>
            </form>
            <div class="btn-apply">
                <a href="{{ route('laporankeuangan') }}">
                    <button>Lihat Keseluruhan</button>
                </a>
            </div>
        </div>
    </div>

    {{-- tabel --}}
    <div class="container-tabel">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th class="col-deskripsi">Keterangan</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Laba</th>
                    <th>Omzet</th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                @foreach ($laporanKeuangan as $item)
                    <tr>
                        <td style="text-align: center">{{ $loop->iteration }}.</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td class="col-deskripsi">{{ $item->deskripsi }}</td>
                        <td>{{ $item->masuk ? 'Rp ' . number_format($item->masuk, 0, ',', '.') : '-' }}</td>
                        <td>{{ $item->keluar ? 'Rp ' . number_format($item->keluar, 0, ',', '.') : '-' }}</td>
                        <td>{{ $item->laba ? 'Rp ' . number_format($item->laba, 0, ',', '.') : '-' }}</td>
                        <td>{{ $item->omzet ? 'Rp ' . number_format($item->omzet, 0, ',', '.') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
            <thead class="th-total">
                <tr>
                    <th colspan="3">Total</th>
                    <th>Rp {{ number_format($totalMasuk, 0, ',', '.') }}</th>
                    <th>Rp {{ number_format($totalKeluar, 0, ',', '.') }}</th>
                    <th>Rp {{ number_format($totalLaba, 0, ',', '.') }}</th>
                    <th>Rp {{ number_format($totalOmzet, 0, ',', '.') }}</th>
                </tr>
            </thead>
        </table>
    </div>

    {{-- Cetak Laporan Keuangan --}}
    <div class="btn-cetak">
        <button>Cetak</button>
    </div>

</div>
@endsection
