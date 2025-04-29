<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabangKeTokoController;

route::get('/look',[CabangKeTokoController::class,'index']);
route::post('/masukkandata',[CabangKeTokoController::class,'store']);
