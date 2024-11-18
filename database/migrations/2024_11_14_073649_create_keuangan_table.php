<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_transaksi');
            $table->enum('jenis_transaksi', ['pemasukan', 'pengeluaran'])->default('pemasukan');
            $table->integer('nominal');
            $table->integer('laba');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
