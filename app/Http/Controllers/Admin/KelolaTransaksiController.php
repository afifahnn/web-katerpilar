<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
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
        $barang = Barang::all();
        return view('admin.kelola-transaksi.create', ['barang' => $barang, 'transaksi' => $transaksi]);
    }

    // store transaksi
    public function storeTransaksi(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required',
            'alamat_customer' => 'required',
            'telp_customer' => 'required',
            'tgl_sewa' => 'required',
            'tgl_kembali' => 'required',
            'barang_sewa' => 'required',
            'jumlah_sewa' => 'required',
            'total_bayar' => 'required',
            'opsi_bayar' => 'required|in:Cash,Non-Cash'
        ]);

        // Customer::create($request->all());
        // Transaksi::create($request->all());

        // Buat data customer
        $customer = Customer::create([
            'nama_customer' => $request->nama_customer,
            'alamat_customer' => $request->alamat_customer,
            'telp_customer' => $request->telp_customer,
        ]);

        // Menghitung total bayar
        $barangIds = json_decode($request->barang_sewa);
        $jumlahBarang = json_decode($request->jumlah_sewa);
        $totalBayar = 0;

        foreach ($barangIds as $index => $barangId) {
            $barang = Barang::find($barangId);

            // Menentukan harga berdasarkan lama sewa
            $tglSewa = new \DateTime($request->tgl_sewa);
            $tglKembali = new \DateTime($request->tgl_kembali);
            $lamaSewa = $tglSewa->diff($tglKembali)->days;

            if ($lamaSewa <= 1) {
                $hargaPerItem = $barang->harga_sewa1;
            } elseif ($lamaSewa <= 3) {
                $hargaPerItem = $barang->harga_sewa2;
            } else {
                $hargaPerItem = $barang->harga_sewa3;
            }

            $totalBayar += $hargaPerItem * $jumlahBarang[$index];
        }

        // Buat data transaksi
        $transaksi = Transaksi::create([
            'customer_id' => $customer->id,
            'tgl_sewa' => $request->tgl_sewa,
            'tgl_kembali' => $request->tgl_kembali,
            'opsi_bayar' => $request->opsi_bayar,
            'total_bayar' => $totalBayar, // Simpan total bayar
        ]);

        // Proses data barang dan jumlah
        $barangSewa = json_decode($request->barang_sewa, true);
        $jumlahSewa = json_decode($request->jumlah_sewa, true);

        foreach ($barangSewa as $index => $barangId) {
            $transaksi->barangSewa()->create([
                'barang_id' => $barangId,
                'jumlah' => $jumlahSewa[$index],
            ]);
        }

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
    }
}
