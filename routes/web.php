<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\PurchaseRequestController;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'is.admin'])->group(function () {
    Route::resource('produk', ProdukController::class);
    Route::post('produk/bulk-delete', [ProdukController::class, 'bulkDelete'])->name('produk.bulk-delete');
    Route::resource('kategori', KategoriController::class);
    Route::post('kategori/bulk-delete', [KategoriController::class, 'bulkDelete'])->name('kategori.bulk-delete');
    Route::resource('unit', SatuanController::class);
    Route::post('unit/bulk-delete', [SatuanController::class, 'bulkDelete'])->name('unit.bulk-delete');
    Route::resource('gudang', GudangController::class);
    Route::post('gudang/bulk-delete', [GudangController::class, 'bulkDelete'])->name('gudang.bulk-delete');
    Route::resource('supplier', SupplierController::class);
    Route::post('supplier/bulk-delete', [SupplierController::class, 'bulkDelete'])->name('supplier.bulk-delete');
    Route::resource('divisi', DivisiController::class);
    Route::post('divisi/bulk-delete', [DivisiController::class, 'bulkDelete'])->name('divisi.bulk-delete');
    Route::resource('permintaan', PurchaseRequestController::class);
    Route::post('permintaan/bulk-delete', [PurchaseRequestController::class, 'bulkDelete'])->name('pembelian.bulk-delete');
});


