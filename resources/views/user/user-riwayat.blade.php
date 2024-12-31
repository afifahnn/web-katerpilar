@extends('user-main-layout')

@section('user-extra-css')
    <link rel="stylesheet" href="{{ asset('css/user/user-riwayat.css') }}">
@endsection

@section('user-contents')
<div id="user-riwayat">
    <div class="riwayat-section">
        <div class="riwayat">Riwayat Transaksi Anda</div>
        <div class="riwayat-container">
            @if($transaksi->isEmpty())
                <div class="no-transactions">
                    <div>Anda belum pernah melakukan pemesanan barang</div>
                    <div class="btn-add-create">
                        <div class="btn-add-data">
                            <button type="button" onclick="window.location.href='/katalog'">Lihat Katalog</button>
                        </div>
                    </div>
                </div>
            @else
                @foreach($transaksi as $index => $item)
                    <div class="card-riwayat">
                        <div class="tanggal">
                            <div class="tgl-sewa">Tanggal sewa : </div>
                            <div>{{ \Carbon\Carbon::parse($item->tgl_sewa)->format('d/m/Y') }} <b>s.d.</b> {{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d/m/Y') }}</div>
                        </div>
                        <hr>
                        <div class="detail-riwayat">
                            <div class="barang">
                                <div class="brg-sewa">Barang sewa :</div>
                                <ul>
                                    @php
                                        $barang_sewa = json_decode($item->barang_sewa, true);  // Decode JSON menjadi array
                                        $jumlah_sewa = json_decode($item->jumlah_sewa, true);  // Decode JSON menjadi array
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
                            <div>
                                @if(strtolower($item->opsi_bayar) === 'non-cash')
                                    @if($item->bukti_bayar)
                                        <div class="pic-bukti">
                                            <img src="{{ asset('storage/' . $item->bukti_bayar) }}" alt="{{ $item->metode_bayar }}">
                                        </div>
                                    @else
                                        <a href="{{ route('user.upload', $item->id) }}" class="btn btn-primary">Upload Bukti Bayar</a>
                                    @endif
                                @endif
                            </div>
                            <div class="cancel-rental">
                                <form action="{{ route('user.riwayat.delete', $item->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-cancel" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                        <i class="fa-solid fa-ban" style="font-size: 15px; padding-right: 5px;"></i>
                                        <span>Batalkan Pesanan</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
