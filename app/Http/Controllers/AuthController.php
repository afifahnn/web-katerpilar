<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // LOGIN
    public function login()
    {
        return view('login');
    }

    // REGISTER
    public function register()
    {
        return view('register');
    }
}

