<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

// Halaman Utama langsung ke Login
Route::get('/', function () {
    return redirect('/login');
});

// 1. Route PUBLIC (Bisa diakses tanpa login)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. Route PROTECTED (Harus Login dulu)
Route::middleware(['auth'])->group(function () {
    
    // --- FITUR UMUM (Bisa Admin & Kasir) ---
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/print', [TransactionController::class, 'print'])->name('transactions.print');

    // --- FITUR KHUSUS ADMIN ---
    // Di sini kita panggil 'is_admin' sebagai string (TEKS), bukan fungsi.
    // Ini aman dan tidak akan bikin terminal error.
    Route::middleware(['is_admin'])->group(function () {
        
        // CRUD Produk
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        
    });

});