<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfExportController extends Controller
{
    public function generatePDF(Request $request)
    {
        $tanggalAwal = $request->query('tanggal_awal');
        $tanggalAkhir = $request->query('tanggal_akhir');

        $combinedData = DB::query()
        ->fromSub(function ($query) {
            $query->from('keuangans')
                ->select(
                    'keuangans.tgl_transaksi AS tanggal',
                    DB::raw('NULL AS masuk'),
                    'keuangans.nominal AS keluar',
                    'keuangans.deskripsi'
                )
                ->unionAll(
                    DB::table('transaksis')
                        ->select(
                            'transaksis.tgl_sewa AS tanggal',
                            'transaksis.total_bayar AS masuk',
                            DB::raw('NULL AS keluar'),
                            DB::raw("'Sewa alat' AS deskripsi")
                        )
                );
        }, 'combined_data')
        ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
            $query->where('tanggal', '>=', $tanggalAwal);
        })
        ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
            $query->where('tanggal', '<=', $tanggalAkhir);
        })
        ->orderBy('tanggal', 'ASC')
        ->get();

        $currentLaba = 0;
        $currentOmzet = 0;
        $totalMasuk = 0;
        $totalKeluar = 0;

        $laporanKeuangan = $combinedData->map(function ($item) use (&$currentLaba, &$currentOmzet, &$totalMasuk, &$totalKeluar) {
            $item->laba = 0;
            $item->omzet = $currentOmzet;

            if ($item->masuk !== null) {
                $currentOmzet += $item->masuk;
                $currentLaba += $item->masuk;
                $totalMasuk += $item->masuk;
            }

            if ($item->keluar !== null) {
                $currentLaba -= $item->keluar;
                $totalKeluar += $item->keluar;
            }

            $item->laba = $currentLaba;
            $item->omzet = $currentOmzet;

            return $item;
        });

        $totalLaba = $currentLaba;
        $totalOmzet = $currentOmzet;

        $data = [
            'laporanKeuangan' => $laporanKeuangan,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'totalLaba' => $totalLaba,
            'totalOmzet' => $totalOmzet
        ];

        $pdf = Pdf::loadView('admin.pdf-view', $data);

        return $pdf->download('laporan-keuangan.pdf');
    }
}
