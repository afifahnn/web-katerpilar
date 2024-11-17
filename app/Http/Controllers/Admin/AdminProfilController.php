<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminProfilController extends Controller
{
    public function adminprofil()
    {
        return view('admin.admin-profil');
    }
}
