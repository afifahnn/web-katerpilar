<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';
    protected $fillable = ['nama_customer', 'alamat_customer', 'telp_customer', 'email_customer'];

    protected $hidden = ['password_customer'];

    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class);
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }
}
