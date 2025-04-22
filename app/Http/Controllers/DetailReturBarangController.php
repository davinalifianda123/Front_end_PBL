<?php

namespace App\Http\Controllers;

use App\Models\DetailReturBarang;

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
}