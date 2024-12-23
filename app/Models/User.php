<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'username', 'email', 'nama', 'password', 'no_telepon'
    ];

    protected $hidden = ['password'];
}
