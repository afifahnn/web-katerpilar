<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminProfilController extends Controller
{
    public function adminprofil()
    {
        $admin = Admin::first();
        return view('admin.admin-profil', ['admin' => $admin ]);
    }

    // EDIT PROFIL
    public function editProfil()
    {
        $admin = Admin::first();
        return view('admin.admin-update-profil', ['admin' => $admin ]);
    }

    // UPDATE PROFIL ADMIN
    public function updateProfil(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama_admin' => 'required',
            'username' => 'required',
            'telp_admin' => 'required',
            'jenis_rekening' => 'required',
            'no_rekening' => 'required',
            'password' => 'nullable|min:8|confirmed',
        ], [
            'password.min' => 'Password harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $admin = Admin::first();

        $admin->nama_admin = $request->nama_admin;
        $admin->username = $request->username;
        $admin->telp_admin = $request->telp_admin;
        $admin->jenis_rekening = $request->jenis_rekening;
        $admin->no_rekening = $request->no_rekening;

        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }

        $admin->save();

        session()->flash('success', 'Profil admin berhasil diperbarui.');

        return redirect()->route('adminprofil');
    }
}
