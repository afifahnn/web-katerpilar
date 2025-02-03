<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\Keuangan;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $currentYear = Carbon::now()->year;
        $combinedData = DB::query()
        ->fromSub(function ($query) use ($currentYear) {
            $query->from('keuangans')
                ->select(
                    'keuangans.tgl_transaksi AS tanggal',
                    DB::raw('NULL AS masuk'),
                    'keuangans.nominal AS keluar',
                    'keuangans.deskripsi'
                )
                ->whereYear('keuangans.tgl_transaksi', $currentYear)
                ->unionAll(
                    DB::table('transaksis')
                        ->select(
                            'transaksis.tgl_sewa AS tanggal',
                            'transaksis.total_bayar AS masuk',
                            DB::raw('NULL AS keluar'),
                            DB::raw("'Sewa alat' AS deskripsi")
                        )
                        ->whereYear('transaksis.tgl_sewa', $currentYear)
                        ->whereIn('transaksis.status', ['booking', 'diambil', 'dikembalikan'])
                );
        }, 'combined_data')
        ->orderBy('tanggal', 'ASC')
        ->get();

        $currentLaba = 0;
        $currentOmzet = 0;

        // laba dan omzet
        $combinedData->each(function ($item) use (&$currentLaba, &$currentOmzet) {
            if ($item->masuk !== null) {
                $currentOmzet += $item->masuk;
                $currentLaba += $item->masuk;
            }

            if ($item->keluar !== null) {
                $currentLaba -= $item->keluar;
            }
        });

        $totalCustomer = Customer::count();
        $totalBarang = Barang::count();

        return view('admin.admin-dashboard', [
            'totalCustomer' => $totalCustomer,
            'totalBarang' => $totalBarang,
            'totalLaba' => $currentLaba,
            'totalOmzet' => $currentOmzet,
        ]);
    }
}
