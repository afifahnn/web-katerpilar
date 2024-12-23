<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
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

    // DELETE RIWAYAT
    public function deleteRiwayat($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $barangSewa = json_decode($transaksi->barang_sewa, true);
        $jumlahSewa = json_decode($transaksi->jumlah_sewa, true);

        foreach ($barangSewa as $index => $namaBarang) {
            $barang = Barang::where('nama_barang', $namaBarang)->first();
            if ($barang) {
                $barang->stok_barang += $jumlahSewa[$index];
                $barang->save();
            }
        }

        // Hapus transaksi
        $transaksi->delete();

        return redirect()->route('user.riwayat')->with('success', 'Riwayat berhasil dihapus.');
    }
}
