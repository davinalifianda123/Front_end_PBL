<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReturBarangController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\PengirimanBarangController;
use App\Http\Controllers\DetailReturBarangController;
use App\Http\Controllers\PenerimaanDiCabangController;
use App\Http\Controllers\DetailPenerimaanBarangController;
use App\Http\Controllers\StatusPengirimanBarangController;
use App\Models\CabangKePusat;
use App\Http\Controllers\CabangKePusatController;

use App\Http\Controllers\SupplierKePusatController;
use App\Http\Controllers\PenerimaanDiPusatController;
use App\Http\Controllers\DetailGudangController;
use App\Http\Controllers\CabangKeTokoController;
use App\Http\Controllers\GudangDanTokoController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PusatKeCabangController;
use App\Http\Controllers\PusatKeSupplierController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
  return redirect()->route('login');
});

// Halaman untuk guest (login, register, dll)
Route::middleware('jwt.guest')->group(function () {
    Route::get('/login', function () {
        return view('Auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});


Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('dashboard', DashboardController::class);
    
    // Resource utama GudangDanToko
    Route::resource('gudangs_dan_tokos', GudangDanTokoController::class);

    // Route khusus untuk filter kategori
    Route::get('/gudangs-only', [GudangDanTokoController::class, 'gudangs'])->name('gudangs.only');
    Route::get('/suppliers-only', [GudangDanTokoController::class, 'suppliers'])->name('suppliers.only');
    Route::get('/tokos-only', [GudangDanTokoController::class, 'tokos'])->name('tokos.only');

    // Routes untuk User & Role Management - hanya SuperAdmin dan Supervisor
    Route::middleware(['role:SuperAdmin,Supervisor'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);

        Route::patch('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::patch('users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    });

    // Routes untuk Categories - SuperAdmin, Supervisor, Admin
    Route::middleware(['role:SuperAdmin,Supervisor,Admin'])->group(function () {
        Route::resource('categories', KategoriBarangController::class);

        // Activate/Deactivate hanya untuk SuperAdmin dan Supervisor
        Route::middleware(['role:SuperAdmin,Supervisor'])->group(function () {
            Route::patch('categories/{category}/activate', [KategoriBarangController::class, 'activate'])->name('categories.activate');
            Route::patch('categories/{category}/deactivate', [KategoriBarangController::class, 'deactivate'])->name('categories.deactivate');
        });
    });

    // Routes untuk Barang - SuperAdmin, Supervisor, Admin, Supplier, Buyer
    Route::middleware(['role:SuperAdmin,Supervisor,Admin,Supplier,Buyer'])->group(function () {
        Route::resource('barangss', BarangController::class);

        // Activate/Deactivate hanya untuk SuperAdmin saja
        Route::middleware(['role:SuperAdmin'])->group(function () {
            Route::patch('barangss/{barang}/activate', [BarangController::class, 'activate'])->name('barangss.activate');
            Route::patch('barangss/{barang}/deactivate', [BarangController::class, 'deactivate'])->name('barangss.deactivate');
        });
    });

    // Resource lainnya
    Route::resource('kategori-barang', KategoriBarangController::class);
    Route::resource('gudangs', GudangController::class);
    Route::patch('/gudangs/{id}/deactivate', [GudangController::class, 'deactivate'])->name('gudangs.deactivate');
    Route::resource('tokos', TokoController::class);
    Route::resource('barangs', DetailGudangController::class);
    Route::resource('penerimaan-di-pusat', PenerimaanDiPusatController::class);
    Route::resource('pusat-ke-cabang', PusatKeCabangController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::patch('/suppliers/{id}/deactivate', [SupplierController::class, 'deactivate'])->name('suppliers.deactivate');
    Route::resource('pusat-ke-supplier', PusatKeSupplierController::class);

    //resource admin
    Route::resource('cabang-ke-pusat', CabangKePusatController::class);

    Route::get('/profile', function () {return view('profile.show');})->name('profile.show');
    Route::get('/profile/edit', function () {return view('profile.edit');})->name('profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    // Tambahkan route lain yang kamu perlukan di sini...
});


//Route untuk edit pada gudang
Route::get('/gudang', [GudangController::class, 'index'])->name('gudang.index');
Route::get('/gudang/create', [GudangController::class, 'create'])->name('gudang.create');
Route::post('/gudang', [GudangController::class, 'store'])->name('gudang.store');

Route::get('/gudang/{id}/edit', [GudangController::class, 'edit'])->name('gudang.edit');
Route::put('/gudang/{id}', [GudangController::class, 'update'])->name('gudang.update');
Route::get('/gudang/{id}', [GudangController::class, 'show'])->name('gudang.show');





//Route untuk edit pada toko
Route::get('/toko', [TokoController::class, 'index'])->name('toko.index');
Route::get('/toko/create', [TokoController::class, 'create'])->name('tokos.create');
Route::post('/toko', [TokoController::class, 'store'])->name('toko.store');
Route::get('/toko/{id}/edit', [TokoController::class, 'edit'])->name('toko.edit');
Route::put('/toko/{id}', [TokoController::class, 'update'])->name('toko.update');