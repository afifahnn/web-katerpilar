@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
@endsection

@section('contents')
    <div id="kelola-customer">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Kelola Data Customer</div>
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
            <a href="{{ route('admin.kelola-customer.create') }}">
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
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telp.</th>
                        <th>Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @if($customer->isEmpty())
                        <tr>
                            <td colspan="10" class="no-transactions">Belum ada data yang ditambahkan</td>
                        </tr>
                    @else
                        @foreach($customer as $index => $customer)
                        <tr class="data-row">
                            <td class="col-number">{{ $loop->iteration }}.</td>
                            <td>{{ $customer->nama_customer}}</td>
                            <td>{{ $customer->alamat_customer}}</td>
                            <td>{{ $customer->telp_customer}}</td>
                            <td>
                                @if($customer->transaksi->isEmpty())
                                    0 kali
                                @else
                                    {{ $customer->transaksi->count() }} kali
                                @endif
                            </td>
                            <td>
                                <div class="btn-aksi">
                                    <form action="{{ route('admin.kelola-customer.delete', $customer->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-hapus" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                            <i class="fa-solid fa-trash" style="color: #FFFFFF"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.kelola-customer.edit', $customer->id) }}">
                                        <button type="submit" class="btn-edit">
                                            <i class="fa-solid fa-pen-to-square" style="color: #FFFFFF"></i>
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>

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
