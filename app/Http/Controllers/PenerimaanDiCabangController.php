<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenerimaanDiCabang;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePenerimaanDiCabangRequest;

class PenerimaanDiCabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penerimaanDiCabang = PenerimaanDiCabang::with('jenisPenerimaan', 'asalBarang', 'barang')->get();

        // return view('penerimaan-di-cabang.index', compact('penerimaanDiCabang'));

        return response()->json([
            'status' => true,
            'message' => 'Data Penerimaan Di Cabang',
            'data' => $penerimaanDiCabang,
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
                PenerimaanDiCabang::create($validated);

                return response()->json([
                    'status' => true,
                    'message' => 'Data Penerimaan Di Cabang berhasil ditambahkan',
                ]);
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan Data Penerimaan Di Cabang. Silakan coba lagi.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $penerimaanDiCabang = PenerimaanDiCabang::with('jenisPenerimaan', 'asalBarang', 'barang')->findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => "Data Penerimaan Di Cabang dengan ID: {$id}",
                'data' => $penerimaanDiCabang,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Data Penerimaan Di Cabang dengan ID: {$id} tidak ditemukan.",
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
        // $validated = $request->validate([
        //     'id_barang' => 'required|exists:barangs,id',
        //     'id_jenis_penerimaan' => 'required|exists:jenis_penerimaans,id',
        //     'id_asal_barang' => 'required|exists:gudang_dan_tokos,id',
        //     'jumlah' => 'required|integer|min:1',
        //     'tanggal' => 'required|date',
        // ]);

        // try {
        //     $penerimaanDiCabang = PenerimaanDiCabang::findOrFail($id);

        //     return DB::transaction(function () use ($validated, $penerimaanDiCabang) {
        //         $penerimaanDiCabang::update($validated);

        //         return response()->json([
        //             'status' => true,
        //             'message' => "Berhasil memperbaharui Data Penerimaan Di Cabang dengan ID: {$penerimaanDiCabang->id}",
        //         ]);
        //     }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => "Gagal memperbaharui Data Penerimaan Di Cabang dengan ID: {$penerimaanDiCabang->id}",
        //     ]);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $penerimaanDiCabang = PenerimaanDiCabang::findOrFail($id);

            if ($penerimaanDiCabang->flag == 0) {
                return response()->json([
                    'status' => false,
                    'message' => "Data Penerimaan Di Cabang dengan ID: {$id} sudah dihapus sebelumnya.",
                ]);
            }

            return DB::transaction(function () use ($id, $penerimaanDiCabang) {
                $penerimaanDiCabang->update(['flag' => 0]);

                return response()->json([
                    'status' => true,
                    'message' => "Berhasil menghapus Data Penerimaan Di Cabang dengan ID: {$id}",
                ]);
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Gagal menghapus Data Penerimaan Di Cabang dengan ID: {$id} {$th->getMessage()}",
            ]);
        }
    }
}
