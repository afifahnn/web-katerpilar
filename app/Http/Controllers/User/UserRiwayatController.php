<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Auth;
use Illuminate\Http\Request;

class UserRiwayatController extends Controller
{
    public function userRiwayat()
    {
        $user = Auth::guard('customer')->user();

        $transaksi = Transaksi::with('customer')
            ->where('customer_id', $user->id)
            ->orderBy('tgl_sewa', 'asc')
            ->get();
        return view('user.user-riwayat', compact('transaksi'));
    }
}
