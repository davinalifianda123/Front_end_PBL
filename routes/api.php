<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\CabangKeTokoController;

route::get('/look',[CabangKeTokoController::class,'index']);
route::post('/masukkandata',[CabangKeTokoController::class,'store']);

Route::get('/supplier-ke-pusats', [SupplierKePusatController::class, 'index']);
Route::post('/supplier-ke-pusats', [SupplierKePusatController::class, 'store']);
Route::get('/testPenerimaan', [PenerimaanDiPusatController::class, 'index']);
Route::post('/testPenerimaan', [PenerimaanDiPusatController::class, 'store']);
Route::get('/testDetailGudang', [DetailGudangController::class, 'index']);
Route::post('/testDetailGudang', [DetailGudangController::class, 'store']);
Route::get('/pusat-ke-cabangs', [PusatKeCabangController::class, 'index']);
Route::post('/pusat-ke-cabangs', [PusatKeCabangController::class, 'store']);


Route::get('/penerimaan-di-cabangs', [PenerimaanDiCabangController::class, 'index']);
Route::post('/penerimaan-di-cabangs', [PenerimaanDiCabangController::class, 'store']);
Route::get('/debug-route', function () {
    return response()->json(['ok' => true]);
});
Route::post('/test-post', function () {
    return response()->json(['message' => 'POST sukses']);
});
