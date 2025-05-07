<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierKePusat;
use Illuminate\Support\Facades\DB;
use App\Models\Kurir;
use App\Models\Barang;
use App\Models\Status;
use App\Models\SatuanBerat;
use App\Models\GudangDanToko;


class SupplierKePusatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $SupplierKePusat =SupplierKePusat::with('supplier','pusat','barang', 'kurir', 'satuanBerat','status')->get();

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
        $barangs = Barang::all();
        $supplier = GudangDanToko::all();
        $pusat = $supplier;
        $status = Status::all();
        $kurir = Kurir::all();
        $satuanBerat = SatuanBerat::all();


        return response()->json([
            'status' => true,
            'message' => 'Data Barang, Jenis Penerimaan, dan Asal Barang',
            'data' => [
                'barangs' => $barangs,
                'supplier' => $supplier,
                'satuanBerat' => $satuanBerat,
                'status'=>$status,
                'kurir' => $kurir,
                'asalBarang'=>$pusat,
                

            ]
        ]);
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
            'jumlah_barang' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'id_satuan_berat' => 'required|exists:satuan_berats,id',
            'id_kurir' => 'required|exists:kurirs,id',
            'id_status' => 'required|exists:statuses,id',
            'berat_satuan_barang' => 'required|numeric|min:1',
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
        try {
            $SupplierKePusat = SupplierKePusat::with('supplier','pusat','barang','kurir', 'satuanBerat','status')->findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => "Data Supplier Ke Pusat  dengan ID: {$id}",
                'data' => $SupplierKePusat,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Data Supplier Ke Pusat dengan ID: {$id} tidak ditemukan.",
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
        //  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $SupplierKePusat = SupplierKePusat::findOrFail(id: $id);

            if ($SupplierKePusat->flag == 0){
                return response()->json(data: [
                    'status' => false,
                    'message' => "Data Supplier Ke Pusat dengan ID: {$id} sudah dihapus sebelumnya",
                ]);
                
            }

            return DB::transaction(function () use ($id, $SupplierKePusat) {
                $SupplierKePusat->update(['flag' => 0]);

                return response()->json(data: [
                    'status' => true,
                    'message' => "Berhasil menghapus Data Supplier Ke Pusat dengan ID: {$id}",
                ]);
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Gagal menghapus Data Supplier Ke Pusat dengan ID: {$id}",
            ]);
        }
    }

}
