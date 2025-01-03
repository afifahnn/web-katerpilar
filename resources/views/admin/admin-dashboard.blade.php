@extends('admin-main-layout')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endsection

@section('contents')
    <div id="dashboard">
        <div class="dashboard-top">
            <div class="dashboard-judul">Dashboard</div>
            <div class="btn-logout">
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <a class="nav-link"><button type="submit">Logout</button></a>
                </form>
            </div>
        </div>
        <div style="padding: 20px;">
            <div>{{ date('d F Y') }}</div>
            <div class="dashboard-container">
                <div class="dashboard-card">
                    <i class="fa-solid fa-headset"></i>
                    <div>
                        <div style="font-weight: 600; font-size: 16px">Data Customer</div>
                        <div>{{ $totalCustomer }} orang</div>
                    </div>
                </div>
                <div class="dashboard-card">
                    <i class="fa-solid fa-toolbox"></i>
                    <div>
                        <div style="font-weight: 600; font-size: 16px">Data Stok Barang</div>
                        <div>{{ $totalBarang }} barang</div>
                    </div>
                </div>
            </div>
            <div class="dashboard-container">
                <div class="dashboard-card">
                    <i class="fa-solid fa-money-bills"></i>
                    <div>
                        <div style="font-weight: 600; font-size: 16px">Laba Keseluruhan Tahun {{ date('Y') }}</div>
                        <div>Rp {{ number_format($totalLaba, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="dashboard-card">
                    <i class="fa-solid fa-money-bill-trend-up"></i>
                    <div>
                        <div style="font-weight: 600; font-size: 16px">Omzet Keseluruhan Tahun {{ date('Y') }}</div>
                        <div>Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
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
</script>
@endsection
