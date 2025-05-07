<?php

use App\Http\Controllers\CabangKePusatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PusatKeSupplierController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\ReturBarangController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\PengirimanBarangController;
use App\Http\Controllers\DetailReturBarangController;
use App\Http\Controllers\DetailPenerimaanBarangController;
use App\Http\Controllers\StatusPengirimanBarangController;
use App\Http\Controllers\PenerimaanDiPusatController;
use App\Http\Controllers\DetailGudangController;
use App\Http\Controllers\PenerimaanDiCabangController;
use App\Http\Controllers\PusatKeCabangController;
use App\Http\Controllers\SupplierKePusatController;
use App\Http\Controllers\TokoKeCabangController;
use App\Http\Controllers\CabangKeTokoController;

Route::resource('pusat-ke-suppliers', PusatKeSupplierController::class);

Route::resource('cabang-ke-pusats', CabangKePusatController::class);

Route::resource('cabang-ke-tokos', CabangKeTokoController::class);

Route::resource('supplier-ke-pusats', SupplierKePusatController::class);

Route::resource('penerimaan-di-pusats', PenerimaanDiPusatController::class);

Route::resource('detail-gudangs', DetailGudangController::class);

Route::resource('pusat-ke-cabangs', PusatKeCabangController::class);

Route::resource('penerimaan-di-cabangs', PenerimaanDiCabangController::class);

Route::resource('toko-ke-cabangs', TokoKeCabangController::class);


// Route::get('/debug-route', function () {
//     return response()->json(['ok' => true]);
// });
// Route::post('/test-post', function () {
//     return response()->json(['message' => 'POST sukses']);
// });
