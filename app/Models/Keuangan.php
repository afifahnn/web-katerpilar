<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';
    protected $fillable = ['tgl_transaksi', 'jenis_transaksi', 'nominal', 'laba', 'deskripsi'];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
