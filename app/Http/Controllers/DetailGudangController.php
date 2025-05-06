<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailGudang;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class DetailGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detailGudang = DetailGudang::with('barang', 'gudang', 'satuanBerat')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Detail Gudang retrieved successfully',
            'data' => $detailGudang
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
        $validated = $request->validate([
            'id_barang' => 'required|exists:barangs,id',
            'id_gudang' => 'required|exists:gudang_dan_tokos,id',
            'id_satuan_berat' => 'required|exists:satuan_berats,id',
            'jumlah_stok' => 'required|integer|min:1',
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                DetailGudang::create($validated);

                return response()->json([
                    'status' => true,
                    'message' => 'Data Detail Gudang berhasil ditambahkan',
                ]);
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan Data Detail Gudang. Silakan coba lagi.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $detailGudang = DetailGudang::with('barang', 'gudang', 'satuanBerat')->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => "Data Detail Gudang dengan ID: {$id}",
                'data' => $detailGudang
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Data Detail Gudang dengan ID: {$id} tidak ditemukan",
            ]);
        }
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
        $validated = $request->validate([
            'id_barang' => 'required|exists:barangs,id',
            'id_gudang' => 'required|exists:gudang_dan_tokos,id',
            'jumlah_stok' => 'required|integer|min:1',
            'id_satuan_berat' => 'required|exists:satuan_berats,id',
            'stok_opname' => 'required|integer|min:0|max:1',
        ]);

        try {
            $detailGudang = DetailGudang::findOrFail($id);

            return DB::transaction(function () use ($validated, $detailGudang) {
                $detailGudang->update($validated);

                return response()->json([
                    'status' => true,
                    'message' => "Data Detail Gudang dengan ID: {$detailGudang->id} berhasil diperbarui",
                ]);
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Gagal memperbarui Data Detail Gudang dengan ID: {$detailGudang->id}. Silakan coba lagi.",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
