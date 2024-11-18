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
}
