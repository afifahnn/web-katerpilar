<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Auth;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // LOGIN
    public function login()
    {
        return view('login');
    }

    // POST LOGIN
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        // // Cek login sebagai admin
        // if (Auth::guard('admin')->attempt(['username' => $request->username, 'password_admin' => $request->password])) {
        //     $request->session()->regenerate();
        //     return redirect()->intended('/dashboard');
        // }

        // // Cek login sebagai customer
        // if (Auth::guard('customer')->attempt(['username' => $request->username, 'password_customer' => $request->password])) {
        //     $request->session()->regenerate();
        //     return redirect()->intended('/');
        // }

        return back()->withErrors([
            'login' => 'Username atau Password tidak terdaftar.'
        ])->onlyInput('username');
    }

    // REGISTER
    public function register()
    {
        return view('register');
    }

    // POST REGISTER
    public function storeRegister(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|confirmed|min:6',
            'nama_customer' => 'required|string',
            'alamat_customer' => 'required|string',
            'telp_customer' => 'required',
        ]);

        Customer::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama_customer' => $request->nama_customer,
            'alamat_customer' => $request->alamat_customer,
            'telp_customer' => $request->telp_customer,
        ]);

        $request->session()->flash('success', 'Registration successful!');

        // Redirect ke halaman login
        return redirect('/login');
    }
}

