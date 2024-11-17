<?php

use App\Http\Controllers\Admin\AdminProfilController;
use App\Http\Controllers\Admin\KelolaBarangController;
use App\Http\Controllers\Admin\KelolaCustomerController;
use App\Http\Controllers\Admin\KelolaTransaksiController;
use App\Http\Controllers\Admin\KelolaUangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

// Dashboard Admin
Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

// Kelola Customer
Route::get('/kelola-customer', [KelolaCustomerController::class, 'kelolacustomer'])->name('kelolacustomer');

// Kelola Transaksi
Route::get('/kelola-transaksi', [KelolaTransaksiController::class, 'kelolatransaksi'])->name('kelolatransaksi');

// Kelola Barang
Route::get('/kelola-barang', [KelolaBarangController::class, 'kelolabarang'])->name('kelolabarang');

// Kelola Keuangan
Route::get('/kelola-keuangan', [KelolaUangController::class, 'kelolakeuangan'])->name('kelolakeuangan');

// Profil Admin
Route::get('/admin-profil', [AdminProfilController::class, 'adminprofil'])->name('adminprofil');
