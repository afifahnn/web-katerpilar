<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KelolaCustomerController extends Controller
{
    public function kelolacustomer()
    {
        $customer = Customer::with('transaksi')->orderBy('nama_customer', 'asc')
        ->paginate(30);
        // ->get();
        return view('admin.admin-kelola-customer', ['customer' => $customer]);
    }

    // CREATE CUSTOMER
    public function createCustomer()
    {
        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        return view('admin.kelola-customer.create', ['customer' => $customer]);
    }

    // STORE CUSTOMER
    public function storeCustomer(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required',
            'alamat_customer' => 'required',
            'telp_customer' => 'required',
        ]);

        // Customer::create($request->all());
        Customer::firstOrCreate(
            ['telp_customer' => $request->telp_customer],
            [
                'nama_customer' => $request->nama_customer,
                'alamat_customer' => $request->alamat_customer,
            ]
        );

        session()->flash('success', 'Customer berhasil ditambahkan.');

        return redirect()->route('kelolacustomer');
    }

    // EDIT CUSTOMER
    public function editCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.kelola-customer.edit', compact('customer'));
    }

    // UPDATE CUSTOMER
    public function updateCustomer(Request $request, $id)
    {
        $request->validate([
            'nama_customer' => 'required',
            'alamat_customer' => 'required',
            'telp_customer' => 'required',
            'password' => 'nullable|min:8|confirmed',
        ], [
            'password.min' => 'Password harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $customer = Customer::findOrFail($id);
        // $customer->update($request->all());
        $customer->nama_customer = $request->nama_customer;
        $customer->telp_customer = $request->telp_customer;
        $customer->alamat_customer = $request->alamat_customer;

        if ($request->filled('password')) {
            $customer->password = bcrypt($request->password);
        }

        $customer->save();

        session()->flash('success', 'Customer berhasil diperbarui.');

        return redirect()->route('kelolacustomer');
    }

    // DELETE CUSTOMER
    // public function deleteCustomer($id)
    // {
    //     $customer = Customer::findOrFail($id);
    //     $customer->delete();

    //     return redirect()->route('kelolacustomer')->with('success', 'Customer berhasil dihapus.');
    // }
}
