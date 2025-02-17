<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelolaBarangController extends Controller
{
    public function kelolabarang()
    {
        $barang = Barang::orderBy('jenis', 'asc')
        ->paginate(20);
        // ->get();
        return view('admin.admin-kelola-barang', ['barang' => $barang]);
    }

    // CREATE BARANG
    public function createBarang()
    {
        $barang = Barang::orderBy('jenis', 'asc')->get();
        return view('admin.kelola-barang.create', ['barang' => $barang]);
    }

    // STORE BARANG
    public function storeBarang(Request $request)
    {
        $request->validate([
            'gambar_barang' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_barang' => 'required',
            'stok_barang' => 'required|numeric',
            'harga_sewa1' => 'required|numeric',
            'harga_sewa2' => 'required|numeric',
            'harga_sewa3' => 'required|numeric',
            'deskripsi_barang' => 'required',
            'jenis' => 'required',
        ]);

        $filePath = $request->file('gambar_barang')->store('images/barang', 'public');

        $kelipatan1 = $request->harga_sewa2 - $request->harga_sewa1;
        $kelipatan2 = $request->harga_sewa3 - $request->harga_sewa2;
        $kelipatan = ($kelipatan1 + $kelipatan2) / 2;

        Barang::create([
            'gambar_barang' => $filePath,
            'nama_barang' => $request->nama_barang,
            'stok_barang' => $request->stok_barang,
            'harga_sewa1' => $request->harga_sewa1,
            'harga_sewa2' => $request->harga_sewa2,
            'harga_sewa3' => $request->harga_sewa3,
            'deskripsi_barang' => $request->deskripsi_barang,
            'jenis' => $request->jenis,
            'kelipatan' => $kelipatan,
        ]);

        session()->flash('success', 'Barang berhasil ditambahkan.');

        return redirect()->route('kelolabarang');
    }

    // EDIT BARANG
    public function editBarang($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.kelola-barang.edit', compact('barang'));
    }

    // UPDATE BARANG
    public function updateBarang(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'gambar_barang' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_barang' => 'required',
            'stok_barang' => 'required|numeric',
            'harga_sewa1' => 'required|numeric',
            'harga_sewa2' => 'required|numeric',
            'harga_sewa3' => 'required|numeric',
            'deskripsi_barang' => 'required',
            'jenis' => 'required',
        ]);

        $kelipatan1 = $request->harga_sewa2 - $request->harga_sewa1;
        $kelipatan2 = $request->harga_sewa3 - $request->harga_sewa2;
        $kelipatan = ($kelipatan1 + $kelipatan2) / 2;

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'stok_barang' => $request->stok_barang,
            'harga_sewa1' => $request->harga_sewa1,
            'harga_sewa2' => $request->harga_sewa2,
            'harga_sewa3' => $request->harga_sewa3,
            'deskripsi_barang' => $request->deskripsi_barang,
            'jenis' => $request->jenis,
            'kelipatan' => $kelipatan,
        ]);

        if ($request->hasFile('gambar_barang')) {
            if ($barang->gambar_barang) {
                \Storage::delete('public/' . $barang->gambar_barang);
            }

            $filePath = $request->file('gambar_barang')->store('images/barang', 'public');
            $barang->gambar_barang = $filePath;
            $barang->save();
        }

        session()->flash('success', 'Barang berhasil diperbarui.');

        return redirect()->route('kelolabarang');
    }

    // DELETE BARANG
    public function deleteBarang($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('kelolabarang')->with('success', 'Barang berhasil dihapus.');
    }
}
