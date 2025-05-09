<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TokoKeCabang;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\Kurir;
use App\Models\GudangDanToko;
use App\Models\SatuanBerat;
use App\Models\Status;

class TokoKeCabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $TokoKeCabang = TokoKeCabang::with('toko', 'cabang', 'barang', 'kurir', 'satuanBerat', 'status')->get();

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
        $barang = Barang::all();
        $satuanBerat = SatuanBerat::all();
        $kurir = Kurir::all();
        $toko = GudangDanToko::all();
        $cabang = $toko;
        $status = Status::all();

        return response()->json([
            'status' => true,
            'message' => 'Data Toko Ke Cabang',
            'data' => [
                'barang' => $barang,
                'satuanBerat' => $satuanBerat,
                'kurir' => $kurir,
                'toko' => $toko,
                'cabang' => $cabang,
                'status' => $status,
            ],
        ]);
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
            'id_satuan_berat' => 'required|exists:satuan_berats,id',
            'id_kurir' => 'nullable|exists:kurirs,id',
            'id_status' => 'required|exists:statuses,id',
            'berat_satuan_barang' => 'required|numeric|min:0',
            'jumlah_barang' => 'required|integer|min:1',
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
        try {
            $tokoKeCabang = TokoKeCabang::with('toko', 'cabang', 'barang', 'kurir', 'satuanBerat', 'status')->findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => "Data Toko Ke Cabang dengan ID: {$id}",
                'data' => $tokoKeCabang,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Data Toko Ke Cabang dengan ID: {$id} tidak ditemukan",
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
            $tokoKeCabang = TokoKeCabang::findOrFail($id);

            if ($tokoKeCabang->flag == 0) {
                return response()->json([
                    'status' => false,
                    'message' => "Data Penerimaan Di Cabang dengan ID: {$id} sudah dihapus",
                ]);
            }

            return DB::transaction(function () use ($tokoKeCabang, $id) {
                $tokoKeCabang->update(['flag' => 0]);

                return response()->json([
                    'status' => true,
                    'message' => "Berhasil menghapus Data Penerimaan Di Cabang dengan ID: {$id}",
                ]);

            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th ) {
            return response()->json([
                'status' => false,
                'message' => "Gagal menghapus Data Penerimaan Di Cabang dengan ID: {$id}",
            ]);
        }
    }
}
