<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        @page {
            margin: 20mm 15mm 20mm 15mm;
            size: A4;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            line-height: 1.6;
            color: #000;
            margin: 0;
        }

        #pdf-section {
            text-align: center;
            margin: 0 auto;
        }

        .judul {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .container-tabel {
            width: 100%;
            margin-top: 20px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead th {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }

        .data-table tbody td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .data-table .th-total th {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 10px;
        }

        .col-deskripsi {
            text-align: left;
        }

        .footer {
            position: fixed;
            bottom: -15mm;
            right: 15mm;
            text-align: right;
            font-size: 9pt;
            color: #000;
        }
    </style>
</head>
<body>
    <div id="pdf-section">
        <div class="judul">
            LAPORAN KEUANGAN<br>
            @if(request('tanggal_awal') && request('tanggal_akhir'))
                Periode {{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') }}
            @else
                Laporan Keseluruhan
            @endif
            <br>
            Katerpilar Outdoor Gear & Rental
        </div>

        {{-- Tabel laporan --}}
        <div class="container-tabel">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th class="col-deskripsi">Keterangan</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Laba</th>
                        <th>Omzet</th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @foreach ($laporanKeuangan as $item)
                        <tr>
                            <td style="text-align: center">{{ $loop->iteration }}.</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td class="col-deskripsi">{{ $item->deskripsi }}</td>
                            <td>{{ $item->masuk ? 'Rp ' . number_format($item->masuk, 0, ',', '.') : '-' }}</td>
                            <td>{{ $item->keluar ? 'Rp ' . number_format($item->keluar, 0, ',', '.') : '-' }}</td>
                            <td>{{ $item->laba ? 'Rp ' . number_format($item->laba, 0, ',', '.') : '-' }}</td>
                            <td>{{ $item->omzet ? 'Rp ' . number_format($item->omzet, 0, ',', '.') : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <thead class="th-total">
                    <tr>
                        <th colspan="3">Total</th>
                        <th>Rp {{ number_format($totalMasuk, 0, ',', '.') }}</th>
                        <th>Rp {{ number_format($totalKeluar, 0, ',', '.') }}</th>
                        <th>Rp {{ number_format($totalLaba, 0, ',', '.') }}</th>
                        <th>Rp {{ number_format($totalOmzet, 0, ',', '.') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    </div>
</body>
</html>
