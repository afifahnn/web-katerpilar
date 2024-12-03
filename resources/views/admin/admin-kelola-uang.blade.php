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
                <button>Logout</button>
            </div>
        </div>

        {{-- recap keuangan --}}
        <div class="bar-recap">
            <div class="recap-card-all">
                <div class="recap-card">
                    <i class="fa-solid fa-money-bills"></i>
                    <div>
                        <div class="recap-content">Laba Keseluruhan</div>
                        <div>Rp 900.000</div>
                    </div>
                </div>
                <div class="recap-card">
                    <i class="fa-solid fa-money-bill-trend-up"></i>
                    <div>
                        <div class="recap-content">Omzet Keseluruhan</div>
                        <div>Rp 1.000.000</div>
                    </div>
                </div>
            </div>
            <div class="recap-card">
                <i class="fa-solid fa-money-bills"></i>
                <div>
                    <div class="input-group mb-3">
                        <label class="input-group-text-1" for="inputGroupSelect01">Laba</label>
                        <select class="form-select" id="inputGroupSelect01">
                          <option selected>per Periode</option>
                          <option value="1">Januari</option>
                          <option value="2">Februari</option>
                          <option value="3">Maret</option>
                        </select>
                    </div>
                    <div style="font-weight: 600; font-size: 14px;">Rp 400.000</div>
                    <p></p>
                    <div style="padding-right: 10px">Laba yang diperoleh pada periode bulan tertentu</div>
                </div>
            </div>
            <div class="recap-card">
                <i class="fa-solid fa-money-bill-trend-up"></i>
                <div>
                    <div class="input-group mb-3">
                        <label class="input-group-text-1" for="inputGroupSelect01">Omzet</label>
                        <select class="form-select" id="inputGroupSelect01">
                          <option selected>per Periode</option>
                          <option value="1">Januari</option>
                          <option value="2">Februari</option>
                          <option value="3">Maret</option>
                        </select>
                    </div>
                    <div style="font-weight: 600; font-size: 14px;">Rp 600.000</div>
                    <p></p>
                    <div style="padding-right: 10px">Omzet yang diperoleh pada periode bulan tertentu</div>
                </div>
            </div>
        </div>

        {{-- search dan add data --}}
        <div class="bar-top-keuangan">
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
                        <th>Laba</th>
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
                        <td>Rp {{ number_format($item->laba, 0, ',', '.') }}</td>
                        <td class="col-deskripsi">{{ $item->deskripsi }}</td>
                        <td class="btn-aksi">
                            <button class="btn-hapus">
                                <i class="fa-solid fa-trash" style="color: #FFFFFF"></i>
                            </button>
                            <a href="{{ route('admin.kelola-keuangan.edit', $item->id) }}">
                                <button class="btn-edit">
                                    <i class="fa-solid fa-pen-to-square" style="color: #FFFFFF"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Lihat Laporan Keuangan --}}
        <div class="laporan-container">
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
        </div>
    </div>
@endsection
