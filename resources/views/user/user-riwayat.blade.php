@extends('user-main-layout')

@section('user-extra-css')
    <link rel="stylesheet" href="{{ asset('css/user/user-riwayat.css') }}">
@endsection

@section('user-contents')
<div id="user-riwayat">
    <div class="riwayat-section">
        <div class="riwayat">Riwayat Transaksi Anda</div>
        <div class="riwayat-container">
            <div class="card-riwayat">
                <div class="tanggal">
                    <div class="tgl-sewa">Tanggal sewa : </div>
                    <div>01 Januari 2024 <b>s.d.</b> 02 Januari 2024</div>
                </div>
                <hr>
                <div class="detail-riwayat">
                    <div class="barang">
                        <div class="brg-sewa">Barang sewa :</div>
                        <ul>
                            <li>
                                <div class="items-sewa">
                                    <div>Carier 60L</div>
                                    <div>(1)</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="total">
                        <div class="total-bayar">Total bayar :</div>
                        <div>Rp 200.000</div>
                    </div>
                    <div>Cash/Non Cash</div>
                    <div>
                        <button class="btn-upload">Upload bukti pembayaran</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
