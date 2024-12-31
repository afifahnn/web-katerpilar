<?php

namespace App\Http\Controllers;

use App\Models\Customer;
// use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        ], [
            'required' => ':attribute wajib diisi.',
        ], [
            'username' => 'Username',
            'password' => 'Password',
        ]);

        // Cek login sebagai admin
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            // dd('Admin berhasil login');
            return redirect()->intended('/dashboard');
        }

        // Cek login sebagai customer
        if (Auth::guard('customer')->attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            // dd('Customer berhasil login');
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login' => 'Username atau Password tidak sesuai.'
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
            'username' => 'required|unique:customer,username',
            'password' => 'required|min:8|confirmed',
            'nama_customer' => 'required|string',
            'alamat_customer' => 'required|string',
            'telp_customer' => 'required|numeric',
        ], [
            'required' => ':attribute wajib diisi.',
            'password.min' => 'Password harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'telp_customer.numeric' => 'Nomor telepon harus berupa angka.',
        ], [
            'username' => 'Username',
            'password' => 'Password',
            'nama_customer' => 'Nama customer',
            'alamat_customer' => 'Alamat customer',
            'telp_customer' => 'Nomor telepon',
        ]);

        // dd($request->all());

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

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

