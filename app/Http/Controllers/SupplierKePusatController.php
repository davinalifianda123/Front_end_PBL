<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierKePusat;
use Illuminate\Support\Facades\DB;

class SupplierKePusatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $SupplierKePusat =SupplierKePusat::with('supplier','pusat','barang')->get();

        return response()->json([
        'status' => true,
        'message' =>'Data Supllier Ke Pusat',
        'data' => $SupplierKePusat,
        ]);

        // 

      //  return view('supplier-ke-pusat.index', compact (var_name: 'SupplierKePusat'));
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
            'kode' => 'required|string',
            'id_supplier' => 'required|exists:gudang_dan_tokos,id',
            'id_pusat' => 'required|exists:gudang_dan_tokos,id',
            'id_barang' => 'required|exists:gudang_dan_tokos,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        try {
            return DB::transaction(function () use ($validated) {
            SupplierKePusat::create($validated);

                return response()->json([
                    'status' => true,
                    'message' => 'Pengiriman barang berhasil dikirimkan dari Supplier Ke Pusat',
                ]);
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Pengiriman barang gagal dikirimkan dari Supplier Ke Pusat',
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
