<?php
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

route::get('/cabang-ke-tokos',[CabangKeTokoController::class,'index']);
route::post('/cabang-ke-tokos',[CabangKeTokoController::class,'store']);
Route::get('/lihatpusatkesupplier', [PusatKeSupplierController::class, 'index']);
Route::post('/tambahpusatkesupplier', [PusatKeSupplierController::class, 'store']);
Route::get('/supplier-ke-pusats', [SupplierKePusatController::class, 'index']);
Route::post('/supplier-ke-pusats', [SupplierKePusatController::class, 'store']);
Route::get('/penerimaan-di-pusats', [PenerimaanDiPusatController::class, 'index']);
Route::post('/penerimaan-di-pusats', [PenerimaanDiPusatController::class, 'store']);
Route::delete('/penerimaan-di-pusats/{id}', [PenerimaanDiPusatController::class, 'destroy']);
Route::get('/penerimaan-di-pusats/{id}', [PenerimaanDiPusatController::class, 'show']);
Route::get('/detail-gudangs', [DetailGudangController::class, 'index']);
Route::post('/detail-gudangs', [DetailGudangController::class, 'store']);
Route::put('/detail-gudangs/{id}', [DetailGudangController::class, 'update']);
Route::get('/detail-gudangs/{id}', [DetailGudangController::class, 'show']);
Route::get('/pusat-ke-cabangs', [PusatKeCabangController::class, 'index']);
Route::post('/pusat-ke-cabangs', [PusatKeCabangController::class, 'store']);
Route::get('/penerimaan-di-cabangs', [PenerimaanDiCabangController::class, 'index']);
Route::post('/penerimaan-di-cabangs', [PenerimaanDiCabangController::class, 'store']);
Route::get('/toko-ke-cabangs', [TokoKeCabangController::class, 'index']);
Route::post('/toko-ke-cabangs', [TokoKeCabangController::class, 'store']);

Route::get('/debug-route', function () {
    return response()->json(['ok' => true]);
});
Route::post('/test-post', function () {
    return response()->json(['message' => 'POST sukses']);
});
