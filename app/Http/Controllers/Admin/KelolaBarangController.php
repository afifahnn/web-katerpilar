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
        $barang = Barang::all();
        return view('admin.admin-kelola-barang', ['barang' => $barang]);
    }

    // create barang
    public function createBarang()
    {
        $barang = Barang::all();
        return view('admin.kelola-barang.create', ['barang' => $barang]);
    }

    // store barang
    public function storeBarang(Request $request)
    {
        $request->validate([
            'gambar_barang' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_barang' => 'required',
            'stok_barang' => 'required|numeric',
            'harga_sewa1' => 'required|numeric',
            'harga_sewa2' => 'required|numeric',
            'harga_sewa3' => 'required|numeric',
            'deskripsi_barang' => 'required',
            'jenis' => 'required',
        ]);

        if ($request->hasFile('gambar_barang')) {
            $image = $request->file('gambar_barang');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/product_images'), $imageName);
        }

        // Barang::create($request->all());

        $barang = new Barang();
        $barang->gambar_barang = 'storage/product_images/' . $imageName;
        $barang->nama_barang = $request->input('nama_barang');
        $barang->stok_barang = $request->input('stok_barang');
        $barang->harga_sewa1 = $request->input('harga_sewa1');
        $barang->harga_sewa2 = $request->input('harga_sewa2');
        $barang->harga_sewa3 = $request->input('harga_sewa3');
        $barang->deskripsi_barang = $request->input('deskripsi_barang');
        $barang->jenis = $request->input('jenis');
        $barang->save();

        // $filePath = $request->file('gambar_barang')->store('images', 'public');

        // Barang::create([
        //     'gambar_barang' => $filePath,
        //     'nama_barang' => $request->nama_barang,
        //     'stok_barang' => $request->stok_barang,
        //     'harga_sewa1' => $request->harga_sewa1,
        //     'harga_sewa2' => $request->harga_sewa2,
        //     'harga_sewa3' => $request->harga_sewa3,
        //     'deskripsi_barang' => $request->deskripsi_barang,
        //     'jenis' => $request->jenis,
        // ]);


        return redirect()->route('kelolabarang')->with('success', 'Barang berhasil ditambahkan.');
    }

    // edit barang
    public function editBarang($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.kelola-barang.edit', compact('barang'));
    }

    // update barang
    public function updateBarang(Request $request, Barang $barang)
    {
        $request->validate([
            'gambar_barang' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_barang' => 'required',
            'stok_barang' => 'required|numeric',
            'harga_sewa1' => 'required|numeric',
            'harga_sewa2' => 'required|numeric',
            'harga_sewa3' => 'required|numeric',
            'deskripsi_barang' => 'required',
            'jenis' => 'required',
        ]);

        if ($request->hasFile('gambar_barang')) {
            // Hapus gambar lama jika ada dan simpan yang baru
            if ($barang->gambar_barang) {
                Storage::disk('public')->delete($barang->gambar_barang);
            }
            $imagePath = $request->file('gambar_barang')->store('barang_images', 'public');
        } else {
            // Jika tidak ada file gambar baru, gunakan gambar yang ada
            $imagePath = $barang->gambar_barang;
        }

        $barang->update([
            'gambar_barang' => $imagePath,
            'nama_barang' => $request->nama_barang,
            'stok_barang' => $request->stok_barang,
            'harga_sewa1' => $request->harga_sewa1,
            'harga_sewa2' => $request->harga_sewa2,
            'harga_sewa3' => $request->harga_sewa3,
            'deskripsi_barang' => $request->deskripsi_barang,
            'jenis' => $request->jenis,
        ]);

        // $barang = Barang::findOrFail($id);
        // $barang->update($request->all());

        return redirect()->route('kelolabarang')->with('success', 'Barang berhasil diperbarui.');
    }

    // delete barang
    public function deleteBarang($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('kelolabarang')->with('success', 'Barang berhasil dihapus.');
    }
}
