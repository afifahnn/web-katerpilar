<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class UserUploadController extends Controller
{
    public function userUpload(Request $request)
    {
        $request->validate([
            'metode_bayar' => 'required',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $fileImg = $request->file('bukti_bayar')->store('images/buktibayar', 'public');

        Transaksi::create([
            'metode_bayar' => $request->metode_bayar,
            'bukti_bayar' => $fileImg,
        ]);

        return redirect()->route('user.upload')->with('success', 'Berhasil upload bukti bayar.');
    }
}
