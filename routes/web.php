<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReturBarangController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\PengirimanBarangController;
use App\Http\Controllers\DetailReturBarangController;
use App\Http\Controllers\DetailPenerimaanBarangController;
use App\Http\Controllers\StatusPengirimanBarangController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::resource('categories', KategoriBarangController::class);
Route::resource('gudangs', GudangController::class);
Route::resource('barangs', BarangController::class);

Route::resource('penerimaan-barang', PenerimaanBarangController::class);

Route::get('/penerimaan-barang/{penerimaanBarang}/details/create', [PenerimaanBarangController::class, 'createDetail'])
->name('penerimaan-barang.create-detail');

Route::post('/penerimaan-barang/{penerimaanBarang}/details', [PenerimaanBarangController::class, 'storeDetail'])
    ->name('penerimaan-barang.store-detail');

Route::get('/penerimaan-barang/details/{detailPenerimaan}', [PenerimaanBarangController::class, 'showDetail'])
    ->name('penerimaan-barang.show-detail');

Route::get('/penerimaan-barang/details/{detailPenerimaan}/edit', [PenerimaanBarangController::class, 'editDetail'])
    ->name('penerimaan-barang.edit-detail');

Route::put('/penerimaan-barang/details/{detailPenerimaan}', [PenerimaanBarangController::class, 'updateDetail'])
    ->name('penerimaan-barang.update-detail');

Route::delete('/penerimaan-barang/details/{detailPenerimaan}', [PenerimaanBarangController::class, 'destroyDetail'])
    ->name('penerimaan-barang.destroy-detail');
    
Route::resource('detail-penerimaan-barang', DetailPenerimaanBarangController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('status-pengiriman-barang', StatusPengirimanBarangController::class);
Route::resource('pengiriman-barang', PengirimanBarangController::class);


Route::get('pengiriman-barang/{pengirimanBarang}/detail/create', [PengirimanBarangController::class, 'createDetail'])
->name('pengiriman-barang.detail.create');

Route::post('pengiriman-barang/{pengirimanBarang}/detail', [PengirimanBarangController::class, 'storeDetail'])
    ->name('pengiriman-barang.detail.store');

Route::get('detail-pengiriman/{detailPengirimanBarang}', [PengirimanBarangController::class, 'showDetail'])
    ->name('pengiriman-barang.detail.show');

Route::get('detail-pengiriman/{detailPengirimanBarang}/edit', [PengirimanBarangController::class, 'editDetail'])
    ->name('pengiriman-barang.detail.edit');

Route::put('detail-pengiriman/{detailPengirimanBarang}', [PengirimanBarangController::class, 'updateDetail'])
    ->name('pengiriman-barang.detail.update');
    
Route::delete('detail-pengiriman/{detailPengirimanBarang}', [PengirimanBarangController::class, 'destroyDetail'])
    ->name('pengiriman-barang.detail.destroy');
// Retur Barang Routes
Route::resource('retur-barang', ReturBarangController::class);

// Detail Retur Barang Routes
Route::get('detail-retur-barang/{detailReturBarang}', [DetailReturBarangController::class, 'show'])->name('detail-retur-barang.show');
Route::get('detail-retur-barang/{detailReturBarang}/edit', [DetailReturBarangController::class, 'edit'])->name('detail-retur-barang.edit');
Route::put('detail-retur-barang/{detailReturBarang}', [DetailReturBarangController::class, 'update'])->name('detail-retur-barang.update');
Route::delete('detail-retur-barang/{detailReturBarang}', [DetailReturBarangController::class, 'destroy'])->name('detail-retur-barang.destroy');
Route::get('retur-barang/{returBarang}/detail/create', [DetailReturBarangController::class, 'create'])->name('detail-retur-barang.create');
Route::post('detail-retur-barang', [DetailReturBarangController::class, 'store'])->name('detail-retur-barang.store');