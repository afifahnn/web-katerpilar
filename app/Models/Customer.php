<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;

    protected $table = 'customer';
    protected $fillable = ['username', 'password', 'nama_customer', 'alamat_customer', 'telp_customer', 'metode_bayar', 'bukti_bayar'];
    protected $hidden = ['password', 'remember_token',];

    // public function barang(): HasMany
    // {
    //     return $this->hasMany(Barang::class);
    // }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'customer_id');
    }
}
