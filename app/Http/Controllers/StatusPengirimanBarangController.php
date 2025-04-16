<?php

namespace App\Http\Controllers;

use App\Models\StatusPengirimanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusPengirimanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data dengan flag bernilai 1
        $statusList = StatusPengirimanBarang::where('flag', 1)->get();
        return view('status_pengiriman.index', compact('statusList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('status_pengiriman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_status' => 'required|string|max:255|unique:status_pengiriman_barangs',
        ]);

        DB::beginTransaction();
        try {
            StatusPengirimanBarang::create([
                'nama_status' => $request->nama_status,
                'flag' => 1,
            ]);
            
            DB::commit();
            return redirect()->route('status-pengiriman.index')
                ->with('success', 'Status pengiriman berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StatusPengirimanBarang $statusPengiriman)
    {
        // Memastikan hanya data dengan flag 1 yang bisa diakses
        if ($statusPengiriman->flag != 1) {
            return redirect()->route('status-pengiriman.index')
                ->with('error', 'Status pengiriman tidak ditemukan.');
        }
        
        return view('status_pengiriman.show', compact('statusPengiriman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusPengirimanBarang $statusPengiriman)
    {
        // Memastikan hanya data dengan flag 1 yang bisa diakses
        if ($statusPengiriman->flag != 1) {
            return redirect()->route('status-pengiriman.index')
                ->with('error', 'Status pengiriman tidak ditemukan.');
        }
        
        return view('status_pengiriman.edit', compact('statusPengiriman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StatusPengirimanBarang $statusPengiriman)
    {
        $request->validate([
            'nama_status' => 'required|string|max:255|unique:status_pengiriman_barangs,nama_status,' . $statusPengiriman->id,
        ]);

        DB::beginTransaction();
        try {
            $statusPengiriman->update([
                'nama_status' => $request->nama_status,
            ]);
            
            DB::commit();
            return redirect()->route('status-pengiriman.index')
                ->with('success', 'Status pengiriman berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * Melakukan soft delete dengan mengubah flag dari 1 ke 0
     */
    public function destroy(StatusPengirimanBarang $statusPengiriman)
    {
        DB::beginTransaction();
        try {
            // Soft delete dengan mengubah flag menjadi 0
            $statusPengiriman->update([
                'flag' => 0
            ]);
            
            DB::commit();
            return redirect()->route('status-pengiriman.index')
                ->with('success', 'Status pengiriman berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}