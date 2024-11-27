<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('gambar_barang')->nullable();
            $table->string('nama_barang');
            $table->integer('stok_barang');
            $table->integer('harga_sewa1');
            $table->integer('harga_sewa2');
            $table->integer('harga_sewa3');
            $table->text('deskripsi_barang');
            $table->string('jenis');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
