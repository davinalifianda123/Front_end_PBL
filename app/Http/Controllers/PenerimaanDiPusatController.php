<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailGudang;
use App\Models\PenerimaanDiPusat;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
class PenerimaanDiPusatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penerimaanDiPusat = PenerimaanDiPusat::with('jenisPenerimaan', 'asalBarang', 'barang')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Penerimaan Di Pusat retrieved successfully',
            'data' => $penerimaanDiPusat
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
            'id_jenis_penerimaan' => 'required|exists:jenis_penerimaans,id',
            'id_asal_barang' => 'required|exists:gudang_dan_tokos,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                PenerimaanDiPusat::create($validated);

                return response()->json([
                    'status' => true,
                    'message' => 'Data Penerimaan Di Pusat berhasil ditambahkan',
                ]);
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan Data Penerimaan Di Pusat. Silakan coba lagi.',
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
