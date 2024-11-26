<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

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

        Barang::create($request->all());

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan.');
    }
}
