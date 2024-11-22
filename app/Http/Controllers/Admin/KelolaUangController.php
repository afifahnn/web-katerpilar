<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Http\Request;

class KelolaUangController extends Controller
{
    public function kelolakeuangan()
    {
        $keuangan = Keuangan::all();
        return view('admin.admin-kelola-uang', ['keuangan' => $keuangan]);
    }

    // create keuangan
    public function createKeuangan()
    {
        $keuangan = Keuangan::all();
        return view('admin.kelola-keuangan.create', ['keuangan' => $keuangan]);
    }

}
