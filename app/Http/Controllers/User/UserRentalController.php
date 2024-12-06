<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserRentalController extends Controller
{
    public function userRental()
    {
        return view('user.user-rental');
    }
}
