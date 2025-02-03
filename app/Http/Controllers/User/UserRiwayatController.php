<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Transaksi;
use Auth;
use Illuminate\Http\Request;

class UserRiwayatController extends Controller
{
    public function userRiwayat(Request $request)
    {
        $user = Auth::guard('customer')->user();

        if (!$user) {
            return redirect()->route('login')->with('alert', 'Silakan login terlebih dahulu');
        }

        $query = Transaksi::with('customer')
            ->where('customer_id', $user->id)
            ->orderBy('tgl_sewa', 'asc');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $transaksi = $query->paginate(10);

        return view('user.user-riwayat', compact('transaksi'));
    }

    // BATALKAN PESANAN
    public function batalkanPesanan($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $barangSewa = json_decode($transaksi->barang_sewa, true);
        $jumlahSewa = json_decode($transaksi->jumlah_sewa, true);

        if (!in_array($transaksi->status, ['diambil', 'dikembalikan', 'dibatalkan'])) {
            $transaksi->status = 'dibatalkan';
            $transaksi->save();

            foreach ($barangSewa as $index => $namaBarang) {
                $barang = Barang::where('nama_barang', $namaBarang)->first();
                if ($barang) {
                    $barang->stok_barang += $jumlahSewa[$index];
                    $barang->save();
                }
            }

            session()->flash('success', 'Pesanan berhasil dibatalkan.');
        } else {
            session()->flash('error', 'Tidak dapat membatalkan pesanan ini.');
        }

        return redirect()->route('user.riwayat');
    }
}
