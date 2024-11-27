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
Route::get('admin/kelola-customer/create', [KelolaCustomerController::class, 'createCustomer'])->name('admin.kelola-customer.create');
Route::post('/kelola-customer', [KelolaCustomerController::class, 'storeCustomer'])->name('admin.kelola-customer.store');
Route::get('admin/kelola-customer/{id}/edit', [KelolaCustomerController::class, 'editCustomer'])->name('admin.kelola-customer.edit');
Route::put('/kelola-customer/{id}', [KelolaCustomerController::class, 'updateCustomer'])->name('admin.kelola-customer.update');
Route::delete('/kelola-customer/{id}', [KelolaCustomerController::class, 'deleteCustomer'])->name('admin.kelola-customer.delete');

// Kelola Transaksi
Route::get('/kelola-transaksi', [KelolaTransaksiController::class, 'kelolatransaksi'])->name('kelolatransaksi');
Route::get('admin/kelola-transaksi/create', [KelolaTransaksiController::class, 'createTransaksi'])->name('admin.kelola-transaksi.create');
Route::post('/kelola-transaksi', [KelolaTransaksiController::class, 'storeTransaksi'])->name('admin.kelola-transaksi.store');

// Kelola Barang
Route::get('/kelola-barang', [KelolaBarangController::class, 'kelolabarang'])->name('kelolabarang');
Route::get('admin/kelola-barang/create', [KelolaBarangController::class, 'createBarang'])->name('admin.kelola-barang.create');
Route::post('/kelola-barang', [KelolaBarangController::class, 'storeBarang'])->name('admin.kelola-barang.store');
Route::get('admin/kelola-barang/{id}/edit', [KelolaBarangController::class, 'editBarang'])->name('admin.kelola-barang.edit');
Route::put('/kelola-barang/{id}', [KelolaBarangController::class, 'updateBarang'])->name('admin.kelola-barang.update');
Route::delete('/kelola-barang/{id}', [KelolaBarangController::class, 'deleteBarang'])->name('admin.kelola-barang.delete');

// Kelola Keuangan
Route::get('/kelola-keuangan', [KelolaUangController::class, 'kelolakeuangan'])->name('kelolakeuangan');
Route::get('admin/kelola-keuangan/create', [KelolaUangController::class, 'createKeuangan'])->name('admin.kelola-keuangan.create');

// Profil Admin
Route::get('/admin-profil', [AdminProfilController::class, 'adminprofil'])->name('adminprofil');
