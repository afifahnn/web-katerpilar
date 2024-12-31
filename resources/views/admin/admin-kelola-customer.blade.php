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
                        <th>
                            Nama
                            <button id="sort-name" class="btn-sort" style="border: none; background: none;">
                                <i class="fa-solid fa-sort-down"></i>
                            </button>
                        </th>
                        <th>
                            Alamat
                            <button id="sort-address" class="btn-sort" style="border: none; background: none;">
                                <i class="fa-solid fa-sort-down"></i>
                            </button>
                        </th>
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

    // SORTING
    let sortOrderName = 'asc';
    let sortOrderAddress = 'asc';

    // Nama
    document.getElementById('sort-name').addEventListener('click', function () {
        sortTableByColumn(2, 'sort-name', 'asc');
    });

    // Alamat
    document.getElementById('sort-address').addEventListener('click', function () {
        sortTableByColumn(3, 'sort-address', 'asc');
    });

    function sortTableByColumn(columnIndex, buttonId, defaultOrder) {
        const rows = Array.from(document.querySelectorAll('#table-body .data-row'));
        const button = document.getElementById(buttonId);
        const arrowIcon = button.querySelector('i');

        let sortOrder;
        if (buttonId === 'sort-name') {
            sortOrder = sortOrderName;
        } else if (buttonId === 'sort-address') {
            sortOrder = sortOrderAddress;
        }

        sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
        arrowIcon.classList.toggle('fa-sort-down', sortOrder === 'asc');
        arrowIcon.classList.toggle('fa-sort-up', sortOrder === 'desc');

        rows.sort((a, b) => {
            const valueA = a.querySelector(`td:nth-child(${columnIndex})`).textContent.trim().toLowerCase();
            const valueB = b.querySelector(`td:nth-child(${columnIndex})`).textContent.trim().toLowerCase();

            if (valueA < valueB) return sortOrder === 'asc' ? -1 : 1;
            if (valueA > valueB) return sortOrder === 'asc' ? 1 : -1;
            return 0;
        });

        const tableBody = document.getElementById('table-body');
        tableBody.innerHTML = '';
        rows.forEach((row, index) => {
            row.querySelector('.col-number').textContent = `${index + 1}.`;
            tableBody.appendChild(row);
        });

        if (buttonId === 'sort-name') sortOrderName = sortOrder;
        if (buttonId === 'sort-address') sortOrderAddress = sortOrder;
    }
</script>
@endsection
