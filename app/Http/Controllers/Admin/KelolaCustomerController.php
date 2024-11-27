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

        return redirect()->route('kelolacustomer')->with('success', 'Customer berhasil ditambahkan.');
    }

    // edit customer
    public function editCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.kelola-customer.edit', compact('customer'));
    }

    // update customer
    public function updateCustomer(Request $request, $id)
    {
        $request->validate([
            'nama_customer' => 'required',
            'alamat_customer' => 'required',
            'telp_customer' => 'required',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('kelolacustomer')->with('success', 'Customer berhasil diperbarui.');
    }

    // delete customer
    public function deleteCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('kelolacustomer')->with('success', 'Customer berhasil dihapus.');
    }
}
