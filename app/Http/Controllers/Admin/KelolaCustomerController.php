<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class KelolaCustomerController extends Controller
{
    public function kelolacustomer()
    {
        $customer = Customer::all();
        return view('admin.admin-kelola-customer', ['customer' => $customer]);
    }

    // create customer
    public function createCustomer()
    {
        $customer = Customer::all();
        return view('admin.kelola-customer.create', ['customer' => $customer]);
    }

    // store customer
    public function storeCustomer(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required',
            'alamat_customer' => 'required',
            'telp_customer' => 'required',
        ]);

        Customer::create($request->all());

        // $customer = new Customer();
        // $customer->nama_customer = $request->input('nama_customer');
        // $customer->alamat_customer = $request->input('alamat_customer');
        // $customer->telp_customer = $request->input('telp_customer');
        // $customer->save();

        return redirect()->back()->with('success', 'Customer berhasil ditambahkan.');
    }
}
