<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $fillable = ['gambar_barang', 'nama_barang', 'stok_barang', 'harga_sewa1', 'harga_sewa2', 'harga_sewa3', 'deskripsi_barang', 'jenis', 'kelipatan'];

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'barang_id');
    }

    // public function admin()
    // {
    //     return $this->belongsTo(Admin::class, 'admin_id');
    // }

    // public function customer(): BelongsTo
    // {
    //     return $this->belongsTo(Customer::class, 'customer_id');
    // }
}
