@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-customer/create-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelola-keuangan/laporan-keuangan.css') }}">
@endsection

@section('contents')
<div id="laporan-keuangan">
    <div class="kelola-cust-top">
        <div class="kelola-cust-judul">Laporan Keuangan Keseluruhan</div>
        <div class="btn-logout">
            <button>Logout</button>
        </div>
    </div>
    <div class="btn-back">
        <a href="{{ url('/kelola-keuangan') }}">
            <button>
                <i class="fa-solid fa-arrow-left" style="padding-right: 5px;"></i>
                Back
            </button>
        </a>
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
                    <td class="col-deskripsi">{{ $item->deskripsi }}</td>
                    <td>
                        {{-- Rp {{ number_format($item->transaksi->total_bayar, 0, ',', '.') }} --}}
                        Rp 20.000
                    </td>
                    <td>
                        {{-- Rp {{ number_format($item->laba, 0, ',', '.') }} --}}
                        Rp 20.000
                    </td>
                    <td>Rp {{ number_format($item->laba, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->omzet, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <thead class="th-total">
                <tr>
                    <th style="text-align: end" colspan="3">Total</th>
                    <th>Rp Masuk</th>
                    <th>Rp Keluar</th>
                    <th>Rp Laba</th>
                    <th>Rp Omzet</th>
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
