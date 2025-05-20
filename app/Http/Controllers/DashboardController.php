<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBarang;
use App\Models\Barang;
use App\Models\User;
use App\Models\GudangDanToko;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahKategori = KategoriBarang::whereNull('deleted_at')->count();
        $jumlahBarang = Barang::whereNull('deleted_at')->count();
        $jumlahGudang = GudangDanToko::where('kategori_bangunan', 0)
                                     ->whereNull('deleted_at')
                                     ->count();
        $jumlahSupplier = GudangDanToko::where('kategori_bangunan', 1)
                                       ->whereNull('deleted_at')
                                       ->count();
        $jumlahToko = GudangDanToko::where('kategori_bangunan', 2)
                                   ->whereNull('deleted_at')
                                   ->count();

        // Mengirim data ke view
        return view('dashboard.index', compact(
            'jumlahKategori',
            'jumlahBarang',
            'jumlahGudang',
            'jumlahSupplier',
            'jumlahToko'
        ));
    }
}