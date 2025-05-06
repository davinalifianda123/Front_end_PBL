<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PusatKeSupplier;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\SatuanBerat;
use App\Models\GudangDanToko;
use App\Models\JenisPenerimaan;
use App\Models\Status;
use App\Models\Kurir;
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
        'barang',
        'kurir',
        'satuanBerat',
        'status'
    ])->get();

    return response()->json($pusatKeSuppliers);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::all();
        $supplier = GudangDanToko::all();
        $status = Status::all();
        $kurir = Kurir::all();
        $jenisPenerimaan = JenisPenerimaan::all();
        $asalBarang = $supplier;
        $satuanBerat = SatuanBerat::all();

        return response()->json([
            'status' => true,
            'message' => 'Data Barang, Jenis Penerimaan, dan Asal Barang',
            'data' => [
                'barangs' => $barangs,
                'jenisPenerimaan' => $jenisPenerimaan,
                'asalBarang' => $asalBarang,
                'satuanBerat' => $satuanBerat,
                'status'=>$status,
                'kurir' => $kurir,
                'asalBarang'=>$asalBarang,
            ]    
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode'=> 'required|string|max:255',
            'id_supplier' => 'required|exists:gudang_dan_tokos,id',
            'id_pusat' => 'required|exists:gudang_dan_tokos,id',
            'id_barang' => 'required|exists:barangs,id',
            'id_satuan_berat' => 'required|exists:satuan_berats,id',
            'id_kurir' => 'required|exists:kurirs,id',
            'id_status' => 'required|exists:statuses,id',
            'berat_satuan_barang' => 'required|numeric|min:1',
            'jumlah_barang' => 'required|integer|min:1',
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
                'message' => "Gagal menambahkan Pusat Ke Supplier. Silakan coba lagi. {$th->getMessage()}",
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try {
            $pusatkesupplier = PusatKeSupplier::with([
                'supplier',
                'pusat',
                'barang'
            ])->findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => "Data Pusat Ke Supplier dengan ID: {$id}",
                'data' => $pusatkesupplier,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Data Pusat Ke Supplier dengan ID: {$id} tidak ditemukan {$th->getMessage()}",
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
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pusatkesupplier = PusatKeSupplier::findOrFail($id);
            if($pusatkesupplier->flag == 0){
                return response()->json([
                    'status' => false,
                    'message' => "Data Pusat Ke Supplier dengan ID: {$id} sudah dihapus",
                ]);
            }
            return DB::transaction(function () use ($pusatkesupplier,$id) {
                $pusatkesupplier->update(['flag' => 0]);

                return response()->json([
                    'status' => true,
                    'message' => "Berhasil menghapus Pusat Ke Supplier dengan ID: {$id}",
                ]);
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Gagal menghapus Data Pusat Ke Supplier dengan ID: {$id}",
            ]);
        }
    }
}
