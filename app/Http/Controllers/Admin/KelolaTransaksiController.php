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
        // $transaksi = Transaksi::all();
        // $customer = Customer::all();
        // return view('admin.admin-kelola-transaksi', ['transaksi' => $transaksi, 'customer' => $customer]);

        $transaksi = Transaksi::with('customer')->get();
        return view('admin.admin-kelola-transaksi', compact('transaksi'));
    }
}
