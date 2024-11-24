<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaksi extends Model
{
    use HasFactory;

    // protected $table = 'transaksi';
    protected $fillable = ['tgl_sewa', 'tgl_kembali', 'barang_sewa', 'jumlah_sewa', 'total_bayar', 'opsi_bayar', 'customer_id', 'barang_id'];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function keuangan(): HasOne
    {
        return $this->hasOne(Keuangan::class, 'transaksi_id');
    }
}
