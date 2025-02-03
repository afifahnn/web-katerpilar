@extends('user-main-layout')

@section('user-extra-css')
    <link rel="stylesheet" href="{{ asset('css/user/user-riwayat.css') }}">
@endsection

@section('user-contents')
<div id="user-riwayat">
    <div class="riwayat-section">
        <div class="riwayat">Riwayat Transaksi Anda</div>
        <div class="riwayat-container">
            <div class="filter-status mb-3">
                <form action="{{ route('user.riwayat') }}" method="GET">
                    <label for="status">Filter Status:</label>
                    <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="booking" {{ request('status') == 'booking' ? 'selected' : '' }}>Booking</option>
                        <option value="diambil" {{ request('status') == 'diambil' ? 'selected' : '' }}>Diambil</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </form>
            </div>
            @if($transaksi->isEmpty())
                <div class="no-transactions">
                    <div>Tidak ada pesanan untuk status ini.</div>
                </div>
            @else
                @foreach($transaksi as $index => $item)
                    <div class="card-riwayat">
                        <div class="tanggal">
                            <div class="tgl-sewa">Tanggal sewa : </div>
                            <div>{{ \Carbon\Carbon::parse($item->tgl_sewa)->format('d/m/Y') }} <b>s.d.</b> {{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d/m/Y') }}</div>
                        </div>
                        <div class="tanggal">
                            <div class="tgl-sewa">Status Pesanan :</div>
                            <div style="font-weight: 600">
                                @php
                                    $statusStyles = [
                                        'menunggu' => ['color' => 'text-secondary', 'icon' => 'fa-clock'],
                                        'booking' => ['color' => 'text-warning', 'icon' => 'fa-calendar-check'],
                                        'diambil' => ['color' => 'text-success', 'icon' => 'fa-box'],
                                        'dikembalikan' => ['color' => 'text-primary', 'icon' => 'fa-check-circle'],
                                        'dibatalkan' => ['color' => 'text-danger', 'icon' => 'fa-times-circle']
                                    ];
                                    $status = $statusStyles[$item->status];
                                @endphp
                                <i class="fas {{ $status['icon'] }} {{ $status['color'] }}"></i>
                                <span class="{{ $status['color'] }}">{{ ucwords($item->status) }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="detail-riwayat">
                            <div class="barang">
                                <div class="brg-sewa">Barang sewa :</div>
                                <ul>
                                    @php
                                        $barang_sewa = json_decode($item->barang_sewa, true);
                                        $jumlah_sewa = json_decode($item->jumlah_sewa, true);
                                    @endphp

                                    @foreach($barang_sewa as $key => $barang)
                                        <li>
                                            <div class="items-sewa">
                                                <div>{{ $barang }}</div>
                                                <div>({{ $jumlah_sewa[$key] }})</div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="total">
                                <div class="total-bayar">Total bayar :</div>
                                <div>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</div>
                            </div>
                            <div class="total">
                                <div class="total-bayar">Opsi bayar :</div>
                                <div>{{ ucwords($item->opsi_bayar) }}</div>
                                @if(strtolower($item->opsi_bayar) === 'non-cash')
                                    <div>{{ $item->metode_bayar }}</div>
                                @endif
                            </div>
                            <div class="total">
                                <div>
                                    @if(strtolower($item->opsi_bayar) === 'non-cash')
                                        @if($item->bukti_bayar)
                                            <div class="total-bayar">Bukti bayar :</div>
                                            <div class="pic-bukti">
                                                <img src="{{ asset('storage/' . $item->bukti_bayar) }}" alt="{{ $item->metode_bayar }}">
                                            </div>
                                        @elseif(!in_array($item->status, ['dikembalikan', 'dibatalkan']))
                                            <a href="{{ route('user.upload', $item->id) }}" class="btn btn-primary">Upload Bukti Bayar</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="cancel-rental">
                                @if(\Carbon\Carbon::now()->lessThan(\Carbon\Carbon::parse($item->tgl_sewa)) && !in_array($item->status, ['diambil', 'dikembalikan', 'dibatalkan']))
                                    <form action="{{ route('user.riwayat.batalkan', $item->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn-cancel">
                                            <i class="fa-solid fa-ban" style="font-size: 15px; padding-right: 5px;"></i>
                                            <span>Batalkan Pesanan</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- pagination --}}
    <div class="pagination">
        {{ $transaksi->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-form').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                var formElement = this;

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Pesanan ini akan dibatalkan dan tidak dapat dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, batalkan!',
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
