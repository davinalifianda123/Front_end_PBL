<?php

namespace App\Http\Controllers;

use App\Models\DetailPenerimaanBarang;
use Illuminate\Http\Request;

class DetailPenerimaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = DetailPenerimaanBarang::with(['penerimaanBarang', 'barang'])->paginate(10);
        return view('detail_penerimaan_barang.index', compact('details'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_penerimaan_barang' => 'required|exists:penerimaan_barangs,id',
            'id_barang' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'required|integer|min:0',
        ]);

        DetailPenerimaanBarang::create($validated);

        return redirect()->route('detail-penerimaan-barang.index')
            ->with('success', 'Detail penerimaan barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailPenerimaanBarang $detailPenerimaanBarang)
    {
        $detailPenerimaanBarang->load(['penerimaanBarang', 'barang']);
        return view('detail_penerimaan_barang.show', compact('detailPenerimaanBarang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailPenerimaanBarang $detailPenerimaanBarang)
    {
        $validated = $request->validate([
            'id_penerimaan_barang' => 'required|exists:penerimaan_barangs,id',
            'id_barang' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'required|integer|min:0',
        ]);

        $detailPenerimaanBarang->update($validated);

        return redirect()->route('detail-penerimaan-barang.index')
            ->with('success', 'Detail penerimaan barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailPenerimaanBarang $detailPenerimaanBarang)
    {
        $detailPenerimaanBarang->delete();

        return redirect()->route('detail-penerimaan-barang.index')
            ->with('success', 'Detail penerimaan barang berhasil dihapus.');
    }
}