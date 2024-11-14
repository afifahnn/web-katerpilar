<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

// Dashboard Admin
Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
