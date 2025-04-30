<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TokoKeCabang;
use Illuminate\Support\Facades\DB;

class TokoKeCabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $TokoKeCabang = TokoKeCabang::with('toko', 'cabang', 'barang')->get();

        //

        return response()->json([
            'status' => true,
            'message' => 'Data Toko Ke Cabang',
            'data' => $TokoKeCabang,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'kode' => 'required|string',
            'id_cabang' => 'required|exists:gudang_dan_tokos,id',
            'id_toko' => 'required|exists:gudang_dan_tokos,id',
            'id_barang' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                TokoKeCabang::create($validated);

                return response()->json([
                    'status' => true,
                    'message' => 'Pengiriman berhasil dikirim dari Toko ke Cabang',
                ]);
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengirimkan barang Dari Toko ke Cabang. Silakan coba lagi.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


        //
    }


}
