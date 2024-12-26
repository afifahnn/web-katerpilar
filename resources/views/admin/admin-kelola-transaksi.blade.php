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
                    <input type="text" id="search-input" class="form-control" placeholder="Search . . ." aria-label="Username" aria-describedby="addon-wrapping">
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
                        <th class="col-number">No.</th>
                        <th>Tgl Sewa</th>
                        <th>Tgl Kembali</th>
                        <th>Nama</th>
                        <th>Total Barang Sewa</th>
                        <th>Total Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @if($transaksi->isEmpty())
                        <tr>
                            <td colspan="10" class="no-transactions">Belum ada data yang ditambahkan</td>
                        </tr>
                    @else
                        @foreach($transaksi as $index => $item)
                        <tr style="text-align: center" class="data-row">
                            <td class="col-number">{{ $loop->iteration }}.</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_sewa)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d/m/Y') }}</td>
                            <td>
                                {{ $item->customer->nama_customer }}
                            </td>
                            <td>
                                @php
                                    $jumlah_sewa = json_decode($item->jumlah_sewa, true);
                                @endphp
                                {{ array_sum($jumlah_sewa) }}
                            </td>
                            <td>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                            <td>
                                <div class="btn-aksi">
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalTransaksi{{ $item->id }}">
                                        <i class="fa-solid fa-circle-info" style="color: #FFFFFF; font-size: 17px;"></i>
                                    </button>
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
                                </div>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="modalTransaksi{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Transaksi</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body content-modals">
                                        <div class="isi-modals">
                                            <div class="judul-modal">Tanggal Sewa</div>
                                            <div>{{ \Carbon\Carbon::parse($item->tgl_sewa)->format('d/m/Y') }}</div>
                                        </div>
                                        <div class="isi-modals">
                                            <div class="judul-modal">Tanggal Kembali</div>
                                            <div>{{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d/m/Y') }}</div>
                                        </div>
                                        <div class="isi-modals">
                                            <div class="judul-modal">Nama Penyewa</div>
                                            <div>{{ $item->customer->nama_customer }}</div>
                                        </div>
                                        <div class="isi-modals">
                                            <div class="judul-modal">Alamat</div>
                                            <div>{{ $item->customer->alamat_customer }}</div>
                                        </div>
                                        <div class="isi-modals">
                                            <div class="judul-modal">Nomor Telepon</div>
                                            <div>{{ $item->customer->telp_customer }}</div>
                                        </div>
                                        <div class="isi-modals">
                                            <div class="judul-modal">Barang yang Disewa</div>
                                            <div>
                                                <ul>
                                                    @php
                                                        $barang_sewa = json_decode($item->barang_sewa, true);
                                                        $jumlah_sewa = json_decode($item->jumlah_sewa, true);
                                                    @endphp

                                                    @foreach($barang_sewa as $key => $barang)
                                                        <li>
                                                            <div class="items-modal">
                                                                <div>{{ $barang }}</div>
                                                                <div>({{ $jumlah_sewa[$key] }})</div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="isi-modals">
                                            <div class="judul-modal">Total Bayar</div>
                                            <div>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</div>
                                        </div>
                                        <div class="isi-modals">
                                            <div class="judul-modal">Metode Pembayaran</div>
                                            <div>
                                                <div>{{ ucwords($item->opsi_bayar) }}</div>
                                                <div>
                                                    @if(strtolower($item->opsi_bayar) === 'non-cash')
                                                        {{ $item->metode_bayar }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if(strtolower($item->opsi_bayar) === 'non-cash')
                                            <div class="isi-modals">
                                                <div class="judul-modal">Bukti Pembayaran</div>
                                                @if($item->bukti_bayar)
                                                <div>
                                                    <div class="pic-bukti">
                                                        <img src="{{ asset('storage/' . $item->bukti_bayar) }}" alt="{{ $item->metode_bayar }}">
                                                    </div>
                                                </div>
                                                @else
                                                    <div>Tidak ada gambar saat ini.</div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p id="no-data" style="display: none; text-align: center;">Data tidak ditemukan</p>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

{{-- JAVASCRIPT --}}
<script>
    // SEARCH
    document.getElementById('search-input').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#table-body .data-row');
        let hasVisibleRow = false;

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(filter));
            row.style.display = match ? '' : 'none';
            if (match) hasVisibleRow = true;
        });

        document.getElementById('no-data').style.display = hasVisibleRow ? 'none' : '';
    });
</script>
@endsection
