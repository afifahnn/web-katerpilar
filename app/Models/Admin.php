<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username_admin', 'password_admin', 'nama_admin', 'telp_admin', 'email_admin'
    ];

    protected $hidden = ['password_admin'];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'admin_id');
    }

    public function customer()
    {
        return $this->hasMany(Customer::class, 'admin_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'admin_id');
    }

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'admin_id');
    }
}
