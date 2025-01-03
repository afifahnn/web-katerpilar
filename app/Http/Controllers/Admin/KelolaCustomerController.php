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

        Customer::create($request->all());

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
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        session()->flash('success', 'Customer berhasil diperbarui.');

        return redirect()->route('kelolacustomer');
    }

    // DELETE CUSTOMER
    public function deleteCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('kelolacustomer')->with('success', 'Customer berhasil dihapus.');
    }
}
