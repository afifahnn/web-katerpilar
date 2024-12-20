<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserUploadController extends Controller
{
    public function userUpload()
    {
        return view('user.user-upload');
    }
}
