<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use App\Models\Transaksi;
use DB;
use Illuminate\Http\Request;

class KelolaUangController extends Controller
{
    public function kelolakeuangan()
    {
        $keuangan = Keuangan::with('transaksi')
        ->paginate(10);
        // ->get();
        return view('admin.admin-kelola-uang', compact('keuangan'));
    }

    // CREATE KEUANGAN
    public function createKeuangan()
    {
        $keuangan = Keuangan::all();
        return view('admin.kelola-keuangan.create', ['keuangan' => $keuangan]);
    }

    // STORE KEUANGAN
    public function storeKeuangan(Request $request)
    {
        $request->validate([
            'tgl_transaksi' => 'required',
            'jenis_transaksi' => 'required|in:Pemasukan,Pengeluaran',
            'nominal' => 'required',
            'deskripsi' => 'required',
        ]);

        Keuangan::create($request->all());

        session()->flash('success', 'Pengeluaran berhasil ditambahkan.');

        return redirect()->route('kelolakeuangan');
    }

    // EDIT KEUANGAN
    public function editKeuangan($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        return view('admin.kelola-keuangan.edit', compact('keuangan'));
    }

    // UPDATE KEUANGAN
    public function updateKeuangan(Request $request, $id)
    {
        $request->validate([
            'tgl_transaksi' => 'required',
            'jenis_transaksi' => 'required|in:Pemasukan,Pengeluaran',
            'nominal' => 'required',
            'deskripsi' => 'required',
        ]);

        $keuangan = Keuangan::findOrFail($id);
        $keuangan->update($request->all());

        session()->flash('success', 'Pengeluaran berhasil diperbarui.');

        return redirect()->route('kelolakeuangan');
    }

    // DELETE KEUANGAN
    public function deleteKeuangan($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $keuangan->delete();

        return redirect()->route('kelolakeuangan')->with('success', 'Keuangan berhasil dihapus.');
    }

    // LAPORAN KEUANGAN
    public function laporanKeuangan(Request $request)
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

        $isEmpty = $laporanKeuangan->isEmpty();

        return view('admin.kelola-keuangan.laporan-keuangan', compact('laporanKeuangan', 'totalMasuk', 'totalKeluar', 'totalLaba', 'totalOmzet', 'isEmpty'));
    }

}
