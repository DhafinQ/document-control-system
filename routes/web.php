<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
});

// Menampilkan formulir create user
Route::get('rbac/users/create', [UserController::class, 'create'])->name('create_user');

// Menyimpan user baru
Route::post('rbac/users/store', [UserController::class, 'store'])->name('store_user');
