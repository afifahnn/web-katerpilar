<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_sewa');
            $table->date('tgl_kembali');
            $table->json('barang_sewa');
            $table->json('jumlah_sewa')->nullable();
            $table->integer('total_bayar');
            $table->enum('opsi_bayar', ['cash', 'non-cash'])->default('cash');
            $table->string('metode_bayar')->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable()->unsigned();
            $table->unsignedBigInteger('barang_id')->nullable()->unsigned();
            $table->foreign('customer_id')->references('id')->on('customer')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
