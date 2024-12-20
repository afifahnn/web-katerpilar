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
                    Anda belum pernah melakukan pemesanan barang
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
                            <div>{{ ucwords($item->opsi_bayar) }}</div>

                            <div>
                                @if(strtolower($item->opsi_bayar) === 'non-cash')
                                    <button class="btn-upload" onclick="window.location.href='/upload'">Upload bukti pembayaran</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
