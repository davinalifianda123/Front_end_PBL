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

Route::get('/testPenerimaan', [PenerimaanDiPusatController::class, 'index']);
Route::post('/testPenerimaan', [PenerimaanDiPusatController::class, 'store']);
Route::get('/testDetailGudang', [DetailGudangController::class, 'index']);
Route::post('/testDetailGudang', [DetailGudangController::class, 'store']);



