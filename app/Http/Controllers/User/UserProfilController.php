<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Auth;
use Illuminate\Http\Request;

class UserProfilController extends Controller
{
    public function userProfil()
    {
        return view('user.user-profil');
    }

    // EDIT PROFIL
    public function editProfil()
    {
        return view('user.user-edit-profil');
    }

    // UPDATE PROFIL
    public function updateProfil(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama_customer' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:customer,username,' . Auth::guard('customer')->user()->id . ',id',
            'telp_customer' => 'required|numeric',
            'alamat_customer' => 'required|string|max:255',
            'password' => 'nullable|min:8|confirmed',
        ], [
            'password.min' => 'Password harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $customer = Auth::guard('customer')->user();

        $customer->nama_customer = $request->nama_customer;
        $customer->username = $request->username;
        $customer->telp_customer = $request->telp_customer;
        $customer->alamat_customer = $request->alamat_customer;

        if ($request->filled('password')) {
            $customer->password = bcrypt($request->password);
        }

        $customer->save();

        session()->flash('success', 'Profil berhasil diperbarui.');

        return redirect()->route('user.profil');
    }
}
