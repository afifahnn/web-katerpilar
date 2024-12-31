<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class UserUploadController extends Controller
{
    public function getUpload($id)
    {
        $admin = Admin::first();
        $transaksi = Transaksi::findOrFail($id);
        return view('user.user-upload', compact('transaksi', 'admin'));
    }

    public function userUpload(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'metode_bayar' => 'required',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $fileImg = $request->file('bukti_bayar')->store('images/buktibayar', 'public');

        $transaksi->update([
            'metode_bayar' => $request->metode_bayar,
            'bukti_bayar' => $fileImg,
        ]);

        return redirect()->route('user.riwayat')->with('success', 'Berhasil upload bukti bayar.');
    }
}
