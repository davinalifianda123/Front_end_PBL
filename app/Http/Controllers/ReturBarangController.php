<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReturBarang\StoreReturBarangRequest;
use App\Http\Requests\ReturBarang\UpdateReturBarangRequest;
use App\Models\ReturBarang;
use App\Models\DetailReturBarang;
use App\Models\StatusRetur;
use App\Models\Barang;
use App\Models\PengirimanBarang;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class ReturBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $returBarangs = ReturBarang::with(['user', 'statusRetur', 'pengirimanBarang', 'detailReturBarangs'])
            ->orderBy('tanggal_retur', 'desc')
            ->where('flag', 1)
            ->paginate(10);
        
        return view('retur_barang.index', compact('returBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('nama_role', '!=', 'Supplier')->where('nama_role', '!=', 'Buyer');
        })->get();
        $statusReturs = StatusRetur::all();
        $pengirimanBarangs = PengirimanBarang::all();
        $barangs = Barang::all();
        
        return view('retur_barang.create', compact('users', 'statusReturs', 'pengirimanBarangs', 'barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReturBarangRequest $request)
    {
        DB::beginTransaction();
        try {
            // Buat retur barang utama
            $returBarang = ReturBarang::create([
                'id_penanggung_jawab' => $request->id_user,
                'tanggal_retur' => $request->tanggal_retur,
                'alasan_retur' => $request->alasan_retur,
                'id_pengiriman_barang' => $request->id_pengiriman_barang,
            ]);
            
            // Buat detail retur barang
            foreach ($request->id_barang as $index => $id_barang) {
                $detailPengirimanBarangs = PengirimanBarang::find($request->id_pengiriman_barang)->detailPengirimanBarangs;

                if ($detailPengirimanBarangs) {
                    foreach ($detailPengirimanBarangs as $detail) {
                        if ($detail) {
                            $namaBarang = $detail->nama_barang;
                            $jumlahStok = $detail->jumlah;
                
                            if ($jumlahStok < $request->jumlah_barang_retur[$index]) {
                                DB::rollBack();
                                return back()->with('error', 'Jumlah barang ' . $namaBarang . ' yang akan diretur tidak mencukupi')->withInput();
                            }

                            DetailReturBarang::create([
                                'id_retur' => $returBarang->id,
                                'id_barang' => $id_barang,
                                'jumlah_barang_retur' => $request->jumlah_barang_retur[$index],
                            ]);
                        }
                    }
                } else {
                    // Penanganan jika detail pengiriman barang tidak ditemukan
                    return back()->with('error', 'Detail pengiriman barang tidak ditemukan.')->withInput();
                }
            }
            
            DB::commit();
            return redirect()->route('retur-barang.index')
                ->with('success', 'Laporan retur barang berhasil dibuat.');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ReturBarang $returBarang)
    {
        $returBarang->load(['user', 'statusRetur', 'pengirimanBarang', 'detailReturBarangs.barang']);
        return view('retur_barang.show', compact('returBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReturBarang $returBarang)
    {
        $statusReturs = StatusRetur::all();
        $pengirimanBarangs = PengirimanBarang::all();
        $returBarang->load('detailReturBarangs.barang');
        
        return view('retur_barang.edit', compact('returBarang','statusReturs', 'pengirimanBarangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReturBarangRequest $request, ReturBarang $returBarang)
    {
        DB::beginTransaction();
        try {
            $returBarang->update($request->validated());
            
            DB::commit();
            return redirect()->route('retur-barang.index')
                ->with('success', 'Laporan retur barang berhasil diperbarui.');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReturBarang $returBarang)
    {
        DB::beginTransaction();
        try {
            // Hapus semua detail retur terkait
            $returBarang->detailReturBarangs()->update(['flag' => 0]);
            
            // Hapus retur barang utama
            $returBarang->update(['flag' => 0]);
            
            DB::commit();
            return redirect()->route('retur-barang.index')
                ->with('success', 'Laporan retur barang berhasil dihapus.');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}