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
        ->join('transaksis', 'keuangans.transaksi_id', '=', 'transaksis.id')
        ->orderBy('transaksis.tgl_sewa', 'asc')
        ->orderBy('keuangans.tgl_transaksi', 'asc')
        ->get();
        return view('admin.admin-kelola-uang', compact('keuangan'));
    }

    // create keuangan
    public function createKeuangan()
    {
        $keuangan = Keuangan::all();
        return view('admin.kelola-keuangan.create', ['keuangan' => $keuangan]);
    }

}
