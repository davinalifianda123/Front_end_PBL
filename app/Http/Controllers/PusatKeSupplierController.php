<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PusatKeSupplier;
class PusatKeSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $pusatKeSuppliers = PusatKeSupplier::with([
        'supplier',
        'pusat',
        'barang'
    ])->get();

    return response()->json($pusatKeSuppliers);
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
            'kode'=> 'required|string|max:255',
            'id_barang' => 'required|exists:barangs,id',
            'id_pusat' => 'required|exists:gudang_dan_tokos,id',
            'id_supplier' => 'required|exists:gudang_dan_tokos,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                PusatKeSupplier::create($validated);

                return response()->json([
                    'status' => true,
                    'message' => 'Pusat Ke Supplier berhasil ditambahkan',
                ]);
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan Pusat Ke Supplier. Silakan coba lagi.',
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
