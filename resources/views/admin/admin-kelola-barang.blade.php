@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-cust.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-kelola-barang.css') }}">
@endsection

@section('contents')
    <div id="kelola-barang">
        <div class="kelola-cust-top">
            <div class="kelola-cust-judul">Kelola Data Barang</div>
            <div class="btn-logout">
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
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
            <a href="{{ route('admin.kelola-barang.create') }}">
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
                        <th rowspan="2" class="col-number">No.</th>
                        <th class="pic-head" rowspan="2">Gambar</th>
                        <th rowspan="2">
                            Jenis
                            <button id="sort-jenis" class="btn-sort" style="border: none; background: none;">
                                <i class="fa-solid fa-sort-down"></i>
                            </button>
                        </th>
                        <th rowspan="2">
                            Nama Barang
                            <button id="sort-name" class="btn-sort" style="border: none; background: none;">
                                <i class="fa-solid fa-sort-down"></i>
                            </button>
                        </th>
                        <th rowspan="2">
                            Stok
                            <button id="sort-stok" class="btn-sort" style="border: none; background: none;">
                                <i class="fa-solid fa-sort-down"></i>
                            </button>
                        </th>
                        <th colspan="3">Harga Sewa</th>
                        <th class="col-deskripsi" rowspan="2">Deskripsi</th>
                        <th rowspan="2">Aksi</th>
                    </tr>
                    <tr>
                        <th>1 Hari</th>
                        <th>2 Hari</th>
                        <th>3 Hari</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @if($barang->isEmpty())
                        <tr>
                            <td colspan="10" class="no-transactions">Belum ada data yang ditambahkan</td>
                        </tr>
                    @else
                        @foreach($barang as $index => $barangs)
                            <tr class="data-row">
                                <td class="col-number">{{ ($barang->currentPage() - 1) * $barang->perPage() + $loop->iteration }}.</td>
                                <td>
                                    <div class="pic-barang">
                                        <img src="{{ asset('storage/' . $barangs->gambar_barang) }}" alt="{{ $barangs->nama_barang }}">
                                    </div>
                                </td>
                                <td>{{ $barangs->jenis }}</td>
                                <td>{{ $barangs->nama_barang }}</td>
                                <td style="text-align: center">{{ $barangs->stok_barang }}</td>
                                <td>Rp {{ number_format($barangs->harga_sewa1, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($barangs->harga_sewa2, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($barangs->harga_sewa3, 0, ',', '.') }}</td>
                                <td class="col-deskripsi">{!! nl2br(e($barangs->deskripsi_barang)) !!}</td>
                                <td>
                                    <div class="btn-aksi">
                                        <form action="{{ route('admin.kelola-barang.delete', $barangs->id) }}" method="post" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-hapus">
                                                <i class="fa-solid fa-trash" style="color: #FFFFFF"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.kelola-barang.edit', $barangs->id) }}">
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

        {{-- pagination --}}
        <div class="pagination">
            {{ $barang->links() }}
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
    let sortOrderJenis = 'asc';
    let sortOrderStok = 'asc';

    // Nama
    document.getElementById('sort-name').addEventListener('click', function () {
        sortTableByColumn(4, 'sort-name', 'asc');
    });

    // Jenis
    document.getElementById('sort-jenis').addEventListener('click', function () {
        sortTableByColumn(3, 'sort-jenis', 'asc');
    });

    // Stok
    document.getElementById('sort-stok').addEventListener('click', function () {
        sortTableByColumn(5, 'sort-stok', 'asc');
    });

    function sortTableByColumn(columnIndex, buttonId, defaultOrder) {
        const rows = Array.from(document.querySelectorAll('#table-body .data-row'));
        const button = document.getElementById(buttonId);
        const arrowIcon = button.querySelector('i');

        let sortOrder;
        if (buttonId === 'sort-jenis') {
            sortOrder = sortOrderJenis;
        } else if (buttonId === 'sort-name') {
            sortOrder = sortOrderName;
        } else if (buttonId === 'sort-stok') {
            sortOrder = sortOrderStok;
        }

        sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
        arrowIcon.classList.toggle('fa-sort-down', sortOrder === 'asc');
        arrowIcon.classList.toggle('fa-sort-up', sortOrder === 'desc');

        rows.sort((a, b) => {
            const valueA = a.querySelector(`td:nth-child(${columnIndex})`).textContent.trim().toLowerCase();
            const valueB = b.querySelector(`td:nth-child(${columnIndex})`).textContent.trim().toLowerCase();

            let compareValueA = valueA;
            let compareValueB = valueB;

            if (columnIndex === 5) {
                compareValueA = parseInt(valueA.replace(/[^0-9]/g, ''), 10);
                compareValueB = parseInt(valueB.replace(/[^0-9]/g, ''), 10);
            }

            if (compareValueA < compareValueB) return sortOrder === 'asc' ? -1 : 1;
            if (compareValueA > compareValueB) return sortOrder === 'asc' ? 1 : -1;
            return 0;
        });

        const tableBody = document.getElementById('table-body');
        tableBody.innerHTML = '';
        rows.forEach((row, index) => {
            row.querySelector('.col-number').textContent = `${index + 1}.`;
            tableBody.appendChild(row);
        });

        if (buttonId === 'sort-jenis') sortOrderJenis = sortOrder;
        if (buttonId === 'sort-name') sortOrderName = sortOrder;
        if (buttonId === 'sort-stok') sortOrderStok = sortOrder;
    }

    // ALERT DELETE
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-form').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                var formElement = this;

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data ini akan dihapus dan tidak dapat dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        formElement.submit();
                    }
                });
            });
        });
    });

    // ALERT LOGOUT
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.logout-form').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                var formElement = this;

                Swal.fire({
                    text: "Apakah anda yakin akan Logout?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        formElement.submit();
                    }
                });
            });
        });
    });

    // SWAL
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    @endif

    @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'error',
            title: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    @endif
</script>
@endsection
