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
}
