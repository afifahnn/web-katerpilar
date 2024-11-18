<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = ['tgl_sewa', 'tgl_kembali', 'jumlah_sewa', 'total_bayar'];

    public function customer(): BelongsTo
    {
        // return $this->belongsTo(Customer::class, 'customer_id');
        return $this->belongsTo(Customer::class);
    }
}
