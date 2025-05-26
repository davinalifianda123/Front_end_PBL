<?php

namespace App\Http\Controllers;

use App\Models\Kurir;
use App\Models\Barang;
use App\Models\Status;
use App\Models\SatuanBerat;
use Illuminate\Http\Request;
use App\Models\GudangDanToko;
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
        try {
            $pusatKeCabang = PusatKeCabang::with('pusat', 'cabang', 'barang','kurir', 'satuanBerat', 'status')
            ->orderBy('id', 'desc')
            ->paginate(10);

            return view('pengiriman_barang.index', compact('pusatKeCabang'));
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
        $pusat = GudangDanToko::all();
        $cabang = $pusat;
        $status = Status::all();
        $kurir = Kurir::all();
        $satuanBerat = SatuanBerat::all();

        return response()->json([
            'status' => true,
            'message' => 'Data Barang, Jenis Penerimaan, dan Asal Barang',
            'data' => [
                'barangs' => $barangs,
                'cabang' =>$cabang,
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
            'kode' => 'required|string', // jika harus unik
            'id_pusat' => 'required|exists:gudang_dan_tokos,id',       // sesuaikan nama tabel pusat
            'id_cabang' => 'required|exists:gudang_dan_tokos,id',     // sesuaikan nama tabel cabang
            'id_barang' => 'required|exists:barangs,id',
            'jumlah_barang' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'id_satuan_berat' => 'required|exists:satuan_berats,id',
            'id_kurir' => 'required|exists:kurirs,id',
            'id_status' => 'required|exists:statuses,id',
            'berat_satuan_barang' => 'required|numeric|min:1',
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
        try {
            $pusatKeCabang = PusatKeCabang::with('pusat', 'cabang', 'barang', 'kurir', 'satuanBerat', 'status')->findOrFail($id);

           return view('pengiriman_barang.show', [
                'pengirimanBarang' => $pusatKeCabang,
                'message' => "Data Barang Gudang dengan ID: {$id}",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Data Pusat Ke Cabang dengan ID: {$id} tidak ditemukan.",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
    {
    
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
            $pusatKeCabang = PusatKeCabang::findOrFail($id);

            if ($pusatKeCabang->flag == 0) {
                return redirect()->back()->with('error', "Data dengan ID: {$id} sudah dihapus sebelumnya.");
            }

            DB::transaction(function () use ($pusatKeCabang) {
                $pusatKeCabang->update(['flag' => 0]);
            }, 3);

            return redirect()->route('pusat-ke-cabang.index')->with('success', "Berhasil menghapus data pengiriman dengan ID: {$id}");
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Gagal menghapus data pengiriman dengan ID: {$id}");
        }
    }


    
}
