<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['nama_customer', 'alamat_customer', 'telp_customer', 'email_customer'];

    protected $hidden = ['password_customer'];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'customer_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'customer_id');
    }
}
