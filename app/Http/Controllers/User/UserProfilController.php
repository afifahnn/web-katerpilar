<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfilController extends Controller
{
    public function userProfil()
    {
        return view('user.user-profil');
    }
}
