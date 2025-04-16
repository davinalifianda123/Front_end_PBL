<?php

namespace App\Http\Controllers;

use App\Models\DetailReturBarang;
use App\Models\ReturBarang;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class DetailReturBarangController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(DetailReturBarang $detailReturBarang)
    {
        $detailReturBarang->load(['returBarang', 'barang']);
        return view('detail_retur_barang.show', compact('detailReturBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailReturBarang $detailReturBarang)
    {
        $barangs = Barang::all();
        $detailReturBarang->load('returBarang');
        
        return view('detail_retur_barang.edit', compact('detailReturBarang', 'barangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailReturBarang $detailReturBarang)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id',
            'jumlah_barang_retur' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $detailReturBarang->update([
                'id_barang' => $request->id_barang,
                'jumlah_barang_retur' => $request->jumlah_barang_retur,
            ]);
            
            DB::commit();
            return redirect()->route('retur-barang.show', $detailReturBarang->id_retur)
                ->with('success', 'Detail retur barang berhasil diperbarui.');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailReturBarang $detailReturBarang)
    {
        $returId = $detailReturBarang->id_retur;
        
        DB::beginTransaction();
        try {
            $detailReturBarang->delete();
            
            DB::commit();
            return redirect()->route('retur-barang.show', $returId)
                ->with('success', 'Detail retur barang berhasil dihapus.');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
    
    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_retur' => 'required|exists:retur_barangs,id',
            'id_barang' => 'required|exists:barangs,id',
            'jumlah_barang_retur' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            DetailReturBarang::create([
                'id_retur' => $request->id_retur,
                'id_barang' => $request->id_barang,
                'jumlah_barang_retur' => $request->jumlah_barang_retur,
            ]);
            
            DB::commit();
            return redirect()->route('retur-barang.show', $request->id_retur)
                ->with('success', 'Detail retur barang berhasil ditambahkan.');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }
    
    /**
     * Show form for creating new detail
     */
    public function create(ReturBarang $returBarang)
    {
        $barangs = Barang::all();
        return view('detail_retur_barang.create', compact('returBarang', 'barangs'));
    }
}