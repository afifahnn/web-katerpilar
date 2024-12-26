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
        $transaksi = Transaksi::with('customer')->orderBy('tgl_sewa', 'asc')->get();
        return view('admin.admin-kelola-transaksi', compact('transaksi'));
    }

    // CREATE TRANSAKSI
    public function createTransaksi()
    {
        $transaksi = Transaksi::with('customer')->orderBy('tgl_sewa', 'asc')->get();
        $barang = Barang::all();
        $customer = Customer::all();
        return view('admin.kelola-transaksi.create', ['barang' => $barang, 'transaksi' => $transaksi, 'customer' => $customer]);
    }

    // STORE TRANSAKSI
    public function storeTransaksi(Request $request)
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
                'opsi_bayar' => 'required|in:Cash,Non-Cash'
            ]);

            // Customer::create($request->all());
            // Transaksi::create($request->all());

            // Buat data customer
            $customer = Customer::firstOrCreate(
                ['telp_customer' => $request->telp_customer],
                [
                    'nama_customer' => $request->nama_customer,
                    'alamat_customer' => $request->alamat_customer,
                ]
            );

            // Menghitung total bayar
            // $barangIds = json_decode($request->barang_sewa);
            // $jumlahBarang = json_decode($request->jumlah_sewa);
            // $totalBayar = 0;

            // foreach ($barangIds as $index => $barangId) {
            //     $barang = Barang::find($barangId);

            //     // Menentukan harga berdasarkan lama sewa
            //     $tglSewa = new \DateTime($request->tgl_sewa);
            //     $tglKembali = new \DateTime($request->tgl_kembali);
            //     $lamaSewa = $tglSewa->diff($tglKembali)->days;

            //     if ($lamaSewa <= 1) {
            //         $hargaPerItem = $barang->harga_sewa1;
            //     } elseif ($lamaSewa <= 3) {
            //         $hargaPerItem = $barang->harga_sewa2;
            //     } else {
            //         $hargaPerItem = $barang->harga_sewa3;
            //     }

            //     $totalBayar += $hargaPerItem * $jumlahBarang[$index];
            // }

            $barangSewa = isset($request->barang_sewa[0]) ? explode(',', $request->barang_sewa[0]) : [];
            $jumlahSewa = isset($request->jumlah_sewa[0]) ? explode(',', $request->jumlah_sewa[0]) : [];
            $jumlahSewa = array_map('intval', $jumlahSewa);

            // dd($barangSewa, $jumlahSewa);
            // dd($request->all());

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
            ]);

            foreach ($barangSewa as $index => $namaBarang) {
                $barang = Barang::where('nama_barang', $namaBarang)->first();
                if ($barang) {
                    $barang->stok_barang -= $jumlahSewa[$index];
                    $barang->save();
                }
            }

            return redirect()->route('kelolatransaksi')->with('success', 'Transaksi berhasil ditambahkan.');
        }
        catch (\Exception $e) {
            \Log::error('Error saat menyimpan transaksi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // EDIT TRANSAKSI
    public function editTransaksi($id)
    {
        $transaksi = Transaksi::with('customer')->findOrFail($id);
        $barang = Barang::all();
        $customer = Customer::all();

        // $barang_sewa = explode(',', $transaksi->barang_sewa);
        // $jumlah_sewa = explode(',', $transaksi->jumlah_sewa);

        $barang_sewa = json_decode($transaksi->barang_sewa, true);
        $jumlah_sewa = json_decode($transaksi->jumlah_sewa, true);

        $data_sewa = [];
        foreach ($barang_sewa as $key => $barangs) {
            $data_sewa[] = [
                'barang' => $barangs,
                'jumlah' => $jumlah_sewa[$key] ?? 0,
            ];
        }

        return view('admin.kelola-transaksi.edit', compact('transaksi', 'customer', 'barang', 'data_sewa'));
    }

    // UPDATE TRANSAKSI
    public function updateTransaksi(Request $request, $id)
    {
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
            'opsi_bayar' => 'required|in:Cash,Non-Cash'
        ]);

        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'nama_customer' => $request->nama_customer,
            'alamat_customer' => $request->alamat_customer,
            'telp_customer' => $request->telp_customer,
            'tgl_sewa' => $request->tgl_sewa,
            'tgl_kembali' => $request->tgl_kembali,
            'barang_sewa' => json_encode($request->barang_sewa),
            'jumlah_sewa' => json_encode($request->jumlah_sewa),
            'total_bayar' => $request->total_bayar,
            'opsi_bayar' => $request->opsi_bayar,
            'metode_bayar' => $request->metode_bayar,
        ]);

        foreach ($request->barang_sewa as $index => $namaBarang) {
            $barang = Barang::where('nama_barang', $namaBarang)->first();

            if ($barang) {
                $jumlahSewa = $request->jumlah_sewa[$index];
                $barang->stok_barang -= $jumlahSewa;
                $barang->save();
            }
        }

        return redirect()->route('kelolatransaksi')->with('success', 'Transaksi berhasil diperbarui.');
    }

    // DELETE TRANSAKSI
    public function deleteTransaksi($id)
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

        return redirect()->route('kelolatransaksi')->with('success', 'Transaksi berhasil dihapus.');
    }
}
