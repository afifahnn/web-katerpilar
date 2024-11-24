<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KelolaTransaksiController extends Controller
{
    public function kelolatransaksi()
    {
        $transaksi = Transaksi::with('customer')->get();
        return view('admin.admin-kelola-transaksi', compact('transaksi'));
    }

    // create transaksi
    public function createTransaksi()
    {
        $transaksi = Transaksi::all();
        return view('admin.kelola-transaksi.create', ['transaksi' => $transaksi]);
    }
}
