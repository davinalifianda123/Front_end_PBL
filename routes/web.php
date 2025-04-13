<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\DetailPenerimaanBarangController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::resource('categories', KategoriBarangController::class);
Route::resource('gudangs', GudangController::class);
Route::resource('barangs', BarangController::class);

Route::resource('penerimaan-barang', PenerimaanBarangController::class);
Route::controller(PenerimaanBarangController::class)->group(function() {
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
});

Route::resource('detail-penerimaan-barang', DetailPenerimaanBarangController::class);