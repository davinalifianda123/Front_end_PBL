<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailGudang;
use App\Models\PenerimaanDiPusat;
use App\Models\JenisPenerimaan;
use App\Models\GudangDanToko;
use App\Models\SatuanBerat;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
class PenerimaanDiPusatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $penerimaanDiPusat = PenerimaanDiPusat::with('jenisPenerimaan', 'asalBarang', 'barang', 'satuanBerat')
            ->orderBy('id', 'desc')
            ->paginate(10);

            return view('penerimaan_barang.index', compact('penerimaanDiPusat'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::all();
        $jenisPenerimaan = JenisPenerimaan::all();
        $asalBarang = GudangDanToko::all();
        $satuanBerat = SatuanBerat::all();

        return response()->json([
            'status' => true,
            'message' => 'Data Barang, Jenis Penerimaan, dan Asal Barang',
            'data' => [
                'barangs' => $barangs,
                'jenisPenerimaan' => $jenisPenerimaan,
                'asalBarang' => $asalBarang,
                'satuanBerat' => $satuanBerat,
            ]
        ]);
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
            'id_satuan_berat' => 'required|exists:satuan_berats,id',
            'berat_satuan_barang' => 'required|integer|min:1',
            'jumlah_barang' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        try {
            // dd($validated);
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
                'message' => "Gagal menambahkan Data Penerimaan Di Pusat. Silakan coba lagi. {$th->getMessage()}",
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $penerimaanDiPusat = PenerimaanDiPusat::with('jenisPenerimaan', 'asalBarang', 'barang', 'satuanBerat')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => "Data Penerimaan Di Pusat {$id}",
                'data' => $penerimaanDiPusat
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Data Penerimaan Di Pusat dengan ID: {$id} tidak ditemukan.",
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
        //     $penerimaanDiPusat = PenerimaanDiPusat::findOrFail($id);

        //     return DB::transaction(function () use ($validated, $id) {
        //         $penerimaanDiPusat->update($validated);

        //         return response()->json([
        //             'status' => true,
        //             'message' => "Data Penerimaan Di Pusat dengan ID: {$penerimaanDiPusat->$id} berhasil diperbarui",
        //         ]);
        //     }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => "Gagal memperbarui Data Penerimaan Di Pusat dengan ID: {$penerimaanDiPusat->$id}. Silakan coba lagi.",
        //     ]);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $penerimaanDiPusat = PenerimaanDiPusat::findOrFail($id);

            if ($penerimaanDiPusat->flag == 0) {
                return response()->json([
                    'status' => false,
                    'message' => "Data Penerimaan Di Pusat dengan ID: {$id} sudah dihapus sebelumnya",
                ]);
            }

            return DB::transaction(function () use ($id, $penerimaanDiPusat) {
                $penerimaanDiPusat->update(['flag' => 0]);

                return response()->json([
                    'status' => true,
                    'message' => "Data Penerimaan Di Pusat dengan ID: {$id} berhasil dihapus",
                ]);
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Gagal menghapus Data Penerimaan Di Pusat dengan ID: {$id}. Silakan coba lagi.",
            ]);
        }
    }
}
