<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PusatKeSupplierController;

Route::get('/lihatpusatkesupplier', [PusatKeSupplierController::class, 'index']); 
Route::post('/tambahpusatkesupplier', [PusatKeSupplierController::class, 'store']);