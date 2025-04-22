<?php

namespace App\Http\Controllers;

use App\Models\DetailPenerimaanBarang;

class DetailPenerimaanBarangController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(DetailPenerimaanBarang $detailPenerimaanBarang)
    {
        $detailPenerimaanBarang->load(['penerimaanBarang', 'barang']);
        return view('detail_penerimaan_barang.show', compact('detailPenerimaanBarang'));
    }
}