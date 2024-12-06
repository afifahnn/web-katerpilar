<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins';
    protected $fillable = ['username', 'password', 'nama_admin', 'telp_admin'];
    protected $hidden = ['password'];

    // public function barang()
    // {
    //     return $this->hasMany(Barang::class, 'admin_id');
    // }

    // public function customer()
    // {
    //     return $this->hasMany(Customer::class, 'admin_id');
    // }

    // public function transaksi()
    // {
    //     return $this->hasMany(Transaksi::class, 'admin_id');
    // }

    // public function keuangan()
    // {
    //     return $this->hasMany(Keuangan::class, 'admin_id');
    // }
}
