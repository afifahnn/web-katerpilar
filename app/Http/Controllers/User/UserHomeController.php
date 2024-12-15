<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    public function userHome()
    {
        $barang = Barang::all();
        return view('user.user-home', ['barang' => $barang]);
    }
}
