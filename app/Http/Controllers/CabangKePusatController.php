<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\CabangKePusat;
use App\Models\PenerimaanDiCabang;
use Attribute;
use Illuminate\Http\Request;

use function PHPUnit\Framework\callback;

class CabangKePusatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $CabangKePusat = CabangKePusat::with('pusat', 'cabang', 'barang')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data Cabang Ke Pusat',
            'data' => $CabangKePusat,
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
            'kode' => 'required|string',
            'id_pusat' => 'required|exists:gudang_dan_tokos,id',
            'id_cabang' => 'required|exists:gudang_dan_tokos,id',
            'id_barang' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                CabangKePusat::create($validated);

                return response()->json([
                    'status' => true,
                    'message' => 'Barang Berhasil Dikirim Dari Cabang Ke Pusat.',
                ]);
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengirimkan barang dari Cabang Ke Pusat. Silakan coba lagi.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $cabangKePusat = CabangKePusat::with('pusat', 'cabang', 'barang')->findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => "Data Cabang Ke Pusat dengan ID: {$id}",
                'data' => $cabangKePusat,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Data Cabang Ke Pusat dengan ID: {$id} tidak ditemukan.",
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
        // $validated = $request->validate(rules: [
        //     'kode' => 'required|string',
        //     'id_pusat' => 'required|exists:gudang_dan_tokos,id',
        //     'id_cabang' => 'required|exists:gudang_dan_tokos,id',
        //     'id_barang' => 'required|exists:barangs,id',
        //     'jumlah' => 'required|integer|min:1',
        //     'tanggal' => 'required|date',
        //     'keterangan' => 'nullable|string|max:255',
        // ]);

        // try {
        //     return DB::transaction(function () use ($validated) {
        //         CabangKePusat::create($validated);

        //         return response()->json([
        //             'status' => true,
        //             'message' => 'Barang Berhasil Dikirim Dari Cabang Ke Pusat.',
        //         ]);
        //     }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Gagal mengirimkan barang dari Cabang Ke Pusat. Silakan coba lagi.',
        //     ]);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $cabangKePusat = CabangKePusat::findOrFail($id);

            if ($cabangKePusat->flag == 0) {
                return response()->json(data:[
                    'status' => false,
                    'message' => "Data Cabang Ke Pusat dengan ID: {$id}
                    sudah dihapus sebelumnya.",
                ]);
            }

            return DB::transaction(callback: function () use ($id, $cabangKePusat) {
                $cabangKePusat->update(['flag' => 0]);

                return response()->json([
                    'status' => true,
                    'message' => "Berhasil menghapus Data Cabang Ke Pusat dengan ID: {$id}",
                ]);
            }, attempts: 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Gagal menghapus Data Cabang Ke Pusat dengan ID: {$id} {$th->getMessage()}",
            ]);
        }
    }
}
