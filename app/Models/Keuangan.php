<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangans';
    protected $fillable = ['tgl_transaksi', 'jenis_transaksi', 'nominal', 'laba', 'deskripsi', 'transaksi_id'];

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    // public function admin()
    // {
    //     return $this->belongsTo(Admin::class, 'admin_id');
    // }
}
