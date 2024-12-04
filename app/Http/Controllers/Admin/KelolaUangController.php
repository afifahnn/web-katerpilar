<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Http\Request;

class KelolaUangController extends Controller
{
    public function kelolakeuangan()
    {
        $keuangan = Keuangan::with('transaksi')
        // ->join('transaksis', 'keuangans.transaksi_id', '=', 'transaksis.id')
        // ->orderBy('transaksis.tgl_sewa', 'asc')
        // ->orderBy('keuangans.tgl_transaksi', 'asc')
        ->get();

        // dd($keuangan);

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

        return redirect()->route('kelolakeuangan')->with('success', 'Keuangan berhasil ditambahkan.');
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

        return redirect()->route('kelolakeuangan')->with('success', 'Keuangan berhasil diperbarui.');
    }

    // DELETE KEUANGAN
    public function deleteKeuangan($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $keuangan->delete();

        return redirect()->route('kelolakeuangan')->with('success', 'Keuangan berhasil dihapus.');
    }

    // LAPORAN KEUANGAN
    public function laporanKeuangan()
    {
        $keuangan = Keuangan::with('transaksi')
        // ->join('transaksis', 'keuangans.transaksi_id', '=', 'transaksis.id')
        // ->orderBy('transaksis.tgl_sewa', 'asc')
        // ->orderBy('keuangans.tgl_transaksi', 'asc')
        ->get();

        // dd($keuangan);

        return view('admin.kelola-keuangan.laporan-keuangan', compact('keuangan'));
    }

}
