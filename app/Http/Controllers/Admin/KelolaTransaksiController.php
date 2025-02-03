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
        $transaksi = Transaksi::with('customer')
        ->orderBy('tgl_sewa', 'asc')
        ->paginate(30);
        // ->get();
        return view('admin.admin-kelola-transaksi', compact('transaksi'));
    }

    // CREATE TRANSAKSI
    public function createTransaksi()
    {
        $transaksi = Transaksi::with('customer')->orderBy('tgl_sewa', 'asc')->get();
        $barang = Barang::orderBy('nama_barang', 'asc')->get();
        $customer = Customer::all();
        return view('admin.kelola-transaksi.create', ['barang' => $barang, 'transaksi' => $transaksi, 'customer' => $customer]);
    }

    // STORE TRANSAKSI
    public function storeTransaksi(Request $request)
    {
        try {
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
                'status' => 'required|in:menunggu,booking,diambil,dikembalikan,dibatalkan'
            ], [
                'tgl_kembali.after' => 'Tanggal kembali harus lebih besar dari tanggal sewa.',
            ]);

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
                'status' => $request->input('status', 'menunggu'),
                'total_bayar' => $request->total_bayar,
                'metode_bayar' => $request->metode_bayar,
            ]);

            foreach ($barangSewa as $index => $namaBarang) {
                $barang = Barang::where('nama_barang', $namaBarang)->first();
                if ($barang) {
                    if (in_array($request->status, ['menunggu', 'booking', 'diambil'])) {
                        $barang->stok_barang -= $jumlahSewa[$index];
                    }
                    $barang->save();
                }
            }

            session()->flash('success', 'Transaksi berhasil ditambahkan.');

            return redirect()->route('kelolatransaksi');
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
        $barang = Barang::orderBy('nama_barang', 'asc')->get();
        $customer = Customer::all();

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
            'status' => 'required|in:menunggu,booking,diambil,dikembalikan,dibatalkan'
        ], [
            'tgl_kembali.after' => 'Tanggal kembali harus lebih besar dari tanggal sewa.',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $statusLama = $transaksi->status;
        $statusBaru = $request->status;
        $barangSewa = isset($request->barang_sewa[0]) ? explode(',', $request->barang_sewa[0]) : [];
        $jumlahSewa = isset($request->jumlah_sewa[0]) ? explode(',', $request->jumlah_sewa[0]) : [];
        $jumlahSewa = array_map('intval', $jumlahSewa);

        $barangSewaLama = json_decode($transaksi->barang_sewa);
        $jumlahSewaLama = json_decode($transaksi->jumlah_sewa);

        $transaksi->update([
            'customer_id' => $transaksi->customer_id,
            'nama_customer' => $request->nama_customer,
            'alamat_customer' => $request->alamat_customer,
            'telp_customer' => $request->telp_customer,
            'tgl_sewa' => $request->tgl_sewa,
            'tgl_kembali' => $request->tgl_kembali,
            'total_bayar' => $request->total_bayar,
            'opsi_bayar' => $request->opsi_bayar,
            'status' => $request->status,
            'metode_bayar' => $request->metode_bayar,
        ]);

        $transaksi->barang_sewa = json_encode($barangSewa);
        $transaksi->jumlah_sewa = json_encode($jumlahSewa);
        $transaksi->save();

        // barang bertambah jika status 'kembali' dan 'batal'
        foreach ($barangSewa as $index => $namaBarang) {
            $barang = Barang::where('nama_barang', $namaBarang)->first();
            if ($barang) {
                $jumlah = $jumlahSewa[$index];

                if (in_array($statusLama, ['menunggu', 'booking', 'diambil']) && in_array($statusBaru, ['dikembalikan', 'dibatalkan'])) {
                    $barang->stok_barang += $jumlah;
                }

                elseif (in_array($statusLama, ['dikembalikan', 'dibatalkan']) && in_array($statusBaru, ['menunggu', 'booking', 'diambil'])) {
                    $barang->stok_barang -= $jumlah;
                }

                $barang->save();
            }
        }

        // barang yang diganti, ditambah, dikurang stoknya
        foreach ($barangSewaLama as $index => $namaBarang) {
            $barang = Barang::where('nama_barang', $namaBarang)->first();

            if ($barang) {
                $jumlahSewaLamaBarang = $jumlahSewaLama[$index];

                $key = array_search($namaBarang, $barangSewa);
                if ($key !== false) {
                    $jumlahSewaBaru = $jumlahSewa[$key];
                    if ($jumlahSewaBaru > $jumlahSewaLamaBarang) {
                        $barang->stok_barang -= ($jumlahSewaBaru - $jumlahSewaLamaBarang);
                    } elseif ($jumlahSewaBaru < $jumlahSewaLamaBarang) {
                        $barang->stok_barang += ($jumlahSewaLamaBarang - $jumlahSewaBaru);
                    }
                } else {
                    $barang->stok_barang += $jumlahSewaLamaBarang;
                }
                $barang->save();
            }
        }

        // barang yang baru saja ditambahkan
        foreach ($barangSewa as $index => $namaBarang) {
            if (!in_array($namaBarang, $barangSewaLama)) {
                $barang = Barang::where('nama_barang', $namaBarang)->first();
                if ($barang) {
                    $barang->stok_barang -= $jumlahSewa[$index];
                    $barang->save();
                }
            }
        }

        session()->flash('success', 'Transaksi berhasil diperbarui.');

        return redirect()->route('kelolatransaksi');
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

        $transaksi->delete();

        return redirect()->route('kelolatransaksi')->with('success', 'Transaksi berhasil dihapus.');
    }
}
