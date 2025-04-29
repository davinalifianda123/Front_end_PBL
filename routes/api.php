<?php

use App\Http\Controllers\CabangKePusatController;
use Illuminate\Support\Facades\Route;

Route::get('lihatcabangkepusat',[CabangKePusatController::class,'index']);
Route::post('masukcabangkepusat',[CabangKePusatController::class,'store']);
