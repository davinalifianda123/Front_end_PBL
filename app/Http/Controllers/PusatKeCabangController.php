<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PusatKeCabang;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PusatKeCabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pusatKeCabang = PusatKeCabang::with('pusat', 'cabang', 'barang')->get();

        return response()->json([
            'status'=> true,
            'message'=> 'Data Penerimaan Di Cabang',
            'data'=> $pusatKeCabang,
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
            'kode' => 'required|string', // jika harus unik
            'id_pusat' => 'required|exists:gudang_dan_tokos,id',       // sesuaikan nama tabel pusat
            'id_cabang' => 'required|exists:gudang_dan_tokos,id',     // sesuaikan nama tabel cabang
            'id_barang' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);
        try {
            return DB::transaction(function () use ($validated) {
                PusatKeCabang::create($validated); 
        
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil mengirimkan barang dari Pusat Ke Cabang.',
                ]);
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengirimkan barang dari Pusat Ke Cabang.',
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
