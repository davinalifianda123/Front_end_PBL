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

Route::middleware('guest')->group(function () {
    Route::get('/', fn() => redirect('/login'));
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Routes untuk User & Role Management - hanya Admin
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/activate', [UserController::class, 'activate'])
            ->name('users.activate');
        Route::patch('users/{user}/deactivate', [UserController::class, 'deactivate'])
            ->name('users.deactivate');
    });
    
    // Routes untuk Categories - Admin, Supervisor, Staff
    Route::middleware(['role:Admin,Supervisor,Staff'])->group(function () {
        Route::resource('categories', KategoriBarangController::class);
        // Activate/Deactivate hanya untuk Admin dan Supervisor
        Route::middleware(['role:Admin,Supervisor'])->group(function () {
            Route::patch('categories/{category}/activate', [KategoriBarangController::class, 'activate'])
                ->name('categories.activate');
            Route::patch('categories/{category}/deactivate', [KategoriBarangController::class, 'deactivate'])
                ->name('categories.deactivate');
        });
    });
    
    // Routes untuk Barang - Admin, Supervisor, Staff, Supplier, Buyer
    Route::middleware(['role:Admin,Supervisor,Staff,Supplier,Buyer'])->group(function () {
        Route::resource('barangs', BarangController::class);
    });
    
    // Routes untuk Gudang - Admin, Supervisor, Staff
    Route::middleware(['role:Admin,Supervisor,Staff'])->group(function () {
        Route::resource('gudangs', GudangController::class);
        // Activate/Deactivate hanya untuk Admin dan Supervisor
        Route::middleware(['role:Admin,Supervisor'])->group(function () {
            Route::patch('gudangs/{gudang}/activate', [GudangController::class, 'activate'])
                ->name('gudangs.activate');
            Route::patch('gudangs/{gudang}/deactivate', [GudangController::class, 'deactivate'])
                ->name('gudangs.deactivate');
        });
    });
    
    // Routes untuk Toko - Admin, Supervisor, Staff
    Route::middleware(['role:Admin,Supervisor,Staff'])->group(function () {
        Route::resource('tokos', TokoController::class);
        // Activate/Deactivate hanya untuk Admin dan Supervisor
        Route::middleware(['role:Admin,Supervisor'])->group(function () {
            Route::patch('tokos/{toko}/activate', [TokoController::class, 'activate'])
                ->name('tokos.activate');
            Route::patch('tokos/{toko}/deactivate', [TokoController::class, 'deactivate'])
                ->name('tokos.deactivate');
        });
    });
    
    // Routes untuk Penerimaan Barang - Admin, Staff
    Route::middleware(['role:Admin,Staff'])->group(function () {
        Route::resource('penerimaan-barang', PenerimaanBarangController::class);
        Route::get('/penerimaan-barang/{penerimaanBarang}/details/create', [PenerimaanBarangController::class, 'createDetail'])
            ->name('penerimaan-barang.create-detail');
        Route::post('/penerimaan-barang/{penerimaanBarang}/details', [PenerimaanBarangController::class, 'storeDetail'])
            ->name('penerimaan-barang.store-detail');
        Route::get('/penerimaan-barang/details/{detailPenerimaan}', [PenerimaanBarangController::class, 'showDetail'])
            ->name('penerimaan-barang.show-detail');
        Route::get('/penerimaan-barang/details/{detailPenerimaan}/edit', [PenerimaanBarangController::class, 'editDetail'])
            ->name('penerimaan-barang.edit-detail');
        Route::put('/penerimaan-barang/details/{detailPenerimaan}', [PenerimaanBarangController::class, 'updateDetail'])
            ->name('penerimaan-barang.update-detail');
        Route::delete('/penerimaan-barang/details/{detailPenerimaan}', [PenerimaanBarangController::class, 'destroyDetail'])
            ->name('penerimaan-barang.destroy-detail');
        Route::resource('detail-penerimaan-barang', DetailPenerimaanBarangController::class);
    });
    
    // Status Pengiriman Barang - hanya Admin
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('status-pengiriman-barang', StatusPengirimanBarangController::class);
    });
    
    // Routes untuk Pengiriman Barang - Admin, Staff, Supplier
    Route::middleware(['role:Admin,Staff,Supplier'])->group(function () {
        // Buat resource pengiriman, tapi restrict mana yang bisa diakses oleh Supplier
        Route::resource('pengiriman-barang', PengirimanBarangController::class);
        
        // Detail view untuk semua role yang bisa akses pengiriman
        Route::get('detail-pengiriman/{detailPengirimanBarang}', [PengirimanBarangController::class, 'showDetail'])
            ->name('pengiriman-barang.detail.show');
        
        // Operasi manipulasi hanya untuk Admin dan Staff
        Route::middleware(['role:Admin,Staff'])->group(function () {
            Route::get('pengiriman-barang/{pengirimanBarang}/detail/create', [PengirimanBarangController::class, 'createDetail'])
                ->name('pengiriman-barang.detail.create');
            Route::post('pengiriman-barang/{pengirimanBarang}/detail', [PengirimanBarangController::class, 'storeDetail'])
                ->name('pengiriman-barang.detail.store');
            Route::get('detail-pengiriman/{detailPengirimanBarang}/edit', [PengirimanBarangController::class, 'editDetail'])
                ->name('pengiriman-barang.detail.edit');
            Route::put('detail-pengiriman/{detailPengirimanBarang}', [PengirimanBarangController::class, 'updateDetail'])
                ->name('pengiriman-barang.detail.update');
            Route::delete('detail-pengiriman/{detailPengirimanBarang}', [PengirimanBarangController::class, 'destroyDetail'])
                ->name('pengiriman-barang.detail.destroy');
        });
    });
    
    // Routes untuk Retur Barang - Admin, Staff, Buyer
    Route::middleware(['role:Admin,Staff,Buyer'])->group(function () {
        Route::resource('retur-barang', ReturBarangController::class);
        // Detail view untuk semua role yang bisa akses retur
        Route::get('detail-retur-barang/{detailReturBarang}', [DetailReturBarangController::class, 'show'])
            ->name('detail-retur-barang.show');
        Route::get('retur-barang/{returBarang}/detail/create', [DetailReturBarangController::class, 'create'])
            ->name('detail-retur-barang.create');
        Route::post('detail-retur-barang', [DetailReturBarangController::class, 'store'])
            ->name('detail-retur-barang.store');
        
        // Operasi edit dan delete hanya untuk Admin dan Staff
        Route::middleware(['role:Admin,Staff'])->group(function () {
            Route::get('detail-retur-barang/{detailReturBarang}/edit', [DetailReturBarangController::class, 'edit'])
                ->name('detail-retur-barang.edit');
            Route::put('detail-retur-barang/{detailReturBarang}', [DetailReturBarangController::class, 'update'])
                ->name('detail-retur-barang.update');
            Route::delete('detail-retur-barang/{detailReturBarang}', [DetailReturBarangController::class, 'destroy'])
                ->name('detail-retur-barang.destroy');
        });
    });
});