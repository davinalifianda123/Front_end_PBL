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

Route::get('/lihatcabangkepusat',[CabangKePusatController::class,'index']);
Route::post('/masukcabangkepusat',[CabangKePusatController::class,'store']);
Route::get('/masukcabangkepusat/{id}',[CabangKePusatController::class,'show']);
Route::delete('hapuscabangkepusat/{id}',[CabangKePusatController::class,'destroy']);
route::get('/cabang-ke-tokos',[CabangKeTokoController::class,'index']);
route::post('/cabang-ke-tokos',[CabangKeTokoController::class,'store']);
route::delete('/cabang-ke-tokos/{id}',[CabangKeTokoController::class,'destroy']);
route::get('/cabang-ke-tokos/{id}',[CabangKeTokoController::class,'show']);
Route::get('/pusatkesupplier', [PusatKeSupplierController::class, 'index']);
Route::post('/pusatkesupplier', [PusatKeSupplierController::class, 'store']);
Route::get('/pusatkesupplier/{id}', [PusatKeSupplierController::class, 'show']);
Route::delete('/pusatkesupplier/{id}', [PusatKeSupplierController::class, 'destroy']);
Route::get('/createpusatkesupplier', [PusatKeSupplierController::class, 'create']);


Route::resource('supplier-ke-pusats', SupplierKePusatController::class);




Route::get('/penerimaan-di-pusats', [PenerimaanDiPusatController::class, 'index']);
Route::post('/penerimaan-di-pusats', [PenerimaanDiPusatController::class, 'store']);
Route::delete('/penerimaan-di-pusats/{id}', [PenerimaanDiPusatController::class, 'destroy']);
Route::get('/penerimaan-di-pusats/create', [PenerimaanDiPusatController::class, 'create']);
Route::get('/penerimaan-di-pusats/{id}', [PenerimaanDiPusatController::class, 'show']);
Route::get('/detail-gudangs', [DetailGudangController::class, 'index']);
Route::post('/detail-gudangs', [DetailGudangController::class, 'store']);
Route::put('/detail-gudangs/{id}', [DetailGudangController::class, 'update']);
Route::get('/detail-gudangs/{id}', [DetailGudangController::class, 'show']);
Route::get('/detail-gudangs/create', [DetailGudangController::class, 'create']);

Route::get('/pusat-ke-cabangs', [PusatKeCabangController::class, 'index']);
Route::post('/pusat-ke-cabangs', [PusatKeCabangController::class, 'store']);
Route::get('/pusat-ke-cabangs/{id}', [PusatKeCabangController::class, 'show']);
Route::delete('/pusat-ke-cabangs/{id}', [PusatKeCabangController::class, 'destroy']);
Route::get('/penerimaan-di-cabangs', [PenerimaanDiCabangController::class, 'index']);
Route::get('/penerimaan-di-cabangs/create', [PenerimaanDiCabangController::class, 'create']);
Route::post('/penerimaan-di-cabangs', [PenerimaanDiCabangController::class, 'store']);
Route::get('/penerimaan-di-cabangs/{id}', [PenerimaanDiCabangController::class, 'show']);
Route::delete('/penerimaan-di-cabangs/{id}', [PenerimaanDiCabangController::class, 'destroy']);

Route::get('/toko-ke-cabangs', [TokoKeCabangController::class, 'index']);
Route::post('/toko-ke-cabangs', [TokoKeCabangController::class, 'store']);
Route::delete('/toko-ke-cabangs/{id}', [TokoKeCabangController::class, 'destroy']);
Route::get('/toko-ke-cabangs/{id}', [TokoKeCabangController::class, 'show']);

// Route::get('/debug-route', function () {
//     return response()->json(['ok' => true]);
// });
// Route::post('/test-post', function () {
//     return response()->json(['message' => 'POST sukses']);
// });
