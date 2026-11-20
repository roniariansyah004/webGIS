<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebGisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KecamatanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\UmkmController;
use App\Http\Controllers\Admin\ProdukController;

// Halaman Utama Publik WebGIS (Beranda Portal)
Route::get('/', [WebGisController::class, 'home'])->name('home');
Route::get('/peta', [WebGisController::class, 'index'])->name('peta');
Route::get('/umkm/{id}', [WebGisController::class, 'showDetail'])->name('umkm.detail');

// Public API Endpoint WebGIS
Route::get('/api/umkm-locations', [WebGisController::class, 'getUmkmLocations'])->name('api.umkm-locations');

// Route Autentikasi Admin (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Route Logout (Harus Authenticated)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Route Group Admin dengan proteksi Middleware Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource CRUD Manajemen Data
    Route::resource('kecamatan', KecamatanController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('umkm', UmkmController::class);
    Route::resource('produk', ProdukController::class);
});
