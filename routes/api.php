<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ReturBarangController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\PengirimanBarangController;
use App\Http\Controllers\DetailReturBarangController;
use App\Http\Controllers\PenerimaanDiCabangController;
use App\Http\Controllers\DetailPenerimaanBarangController;
use App\Http\Controllers\StatusPengirimanBarangController;

Route::get('/penerimaan-di-cabangs', [PenerimaanDiCabangController::class, 'index']);
Route::post('/penerimaan-di-cabangs', [PenerimaanDiCabangController::class, 'store']);
Route::get('/debug-route', function () {
    return response()->json(['ok' => true]);
});
Route::post('/test-post', function () {
    return response()->json(['message' => 'POST sukses']);
});
