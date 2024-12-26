<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class UserRentalController extends Controller
{
    public function userRental()
    {
        $transaksi = Transaksi::with('customer')->orderBy('tgl_sewa', 'asc')->get();
        $barang = Barang::all();
        $customer = Customer::all();
        $admin = Admin::first();
        return view('user.user-rental', ['barang' => $barang, 'transaksi' => $transaksi, 'customer' => $customer, 'admin' => $admin]);
    }

    // STORE RENTAL
    public function storeRental(Request $request)
    {
        try {
            // dd($request->all());

            $request->validate([
                'nama_customer' => 'required',
                'alamat_customer' => 'required',
                'telp_customer' => 'required',
                'tgl_sewa' => 'required',
                'tgl_kembali' => 'required|date|after:tgl_sewa',
                'barang_sewa' => 'required',
                'jumlah_sewa' => 'required',
                'total_bayar' => 'required',
                'opsi_bayar' => 'required|in:Cash,Non-Cash',
                'metode_bayar' => $request->opsi_bayar === 'Non-Cash' ? 'required' : 'nullable',
                'bukti_bayar' => $request->opsi_bayar === 'Non-Cash' ? 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' : 'nullable',
            ]);

            $fileImg = null;
            if ($request->hasFile('bukti_bayar')) {
                $fileImg = $request->file('bukti_bayar')->store('images/buktibayar', 'public');
            }

            // Buat data customer
            $customer = Customer::firstOrCreate(
                ['telp_customer' => $request->telp_customer],
                [
                    'nama_customer' => $request->nama_customer,
                    'alamat_customer' => $request->alamat_customer,
                ]
            );

            $barangSewa = isset($request->barang_sewa[0]) ? explode(',', $request->barang_sewa[0]) : [];
            $jumlahSewa = isset($request->jumlah_sewa[0]) ? explode(',', $request->jumlah_sewa[0]) : [];
            $jumlahSewa = array_map('intval', $jumlahSewa);

            // Buat data transaksi
            Transaksi::create([
                'customer_id' => $customer->id,
                'tgl_sewa' => $request->tgl_sewa,
                'tgl_kembali' => $request->tgl_kembali,
                'barang_sewa' => json_encode($barangSewa),
                'jumlah_sewa' => json_encode($jumlahSewa),
                'opsi_bayar' => $request->opsi_bayar,
                'total_bayar' => $request->total_bayar,
                'metode_bayar' => $request->metode_bayar,
                'bukti_bayar' => $fileImg,
            ]);

            foreach ($barangSewa as $index => $namaBarang) {
                $barang = Barang::where('nama_barang', $namaBarang)->first();
                if ($barang) {
                    $barang->stok_barang -= $jumlahSewa[$index];
                    $barang->save();
                }
            }

            return redirect()->route('rental')
                // ->with('show_modal', $request->opsi_bayar === 'Non-Cash')
                ->with('success', 'Transaksi berhasil ditambahkan.');
        }
        catch (\Exception $e) {
            \Log::error('Error saat menyimpan transaksi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
