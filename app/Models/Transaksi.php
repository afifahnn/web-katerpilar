<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['tgl_sewa', 'tgl_kembali', 'jumlah_sewa', 'total_bayar'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
