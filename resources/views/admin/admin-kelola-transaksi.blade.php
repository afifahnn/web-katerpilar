@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-trans.css') }}">
@endsection

@section('contents')
    <div id="kelola-trans">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Kelola Data Transaksi</div>
            <div class="btn-logout">
                <button>Logout</button>
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
            <a href="{{ route('admin.kelola-transaksi.create') }}">
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
                        <th>Tgl Sewa</th>
                        <th>Tgl Kembali</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telp.</th>
                        <th scope="row" colspan="2">Barang Sewa</th>
                        <th>Total Bayar</th>
                        <th>Opsi Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi as $index => $item)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_sewa)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d/m/Y') }}</td>
                        <td>
                            {{ $item->customer->nama_customer }}
                        </td>
                        <td>{{ $item->customer->alamat_customer }}</td>
                        <td>{{ $item->customer->telp_customer }}</td>
                        <td class="col-barang">{{ $item->barang_sewa }}</td>
                        <td>{{ $item->jumlah_sewa }}</td>
                        <td>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                        <td>{{ ucwords($item->opsi_bayar) }}</td>
                        <td class="btn-aksi">
                            <form action="{{ route('admin.kelola-transaksi.delete', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-hapus" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                    <i class="fa-solid fa-trash" style="color: #FFFFFF"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.kelola-transaksi.edit', $item->id) }}">
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

    </div>
@endsection
