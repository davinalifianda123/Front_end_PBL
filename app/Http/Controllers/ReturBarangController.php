<?php

namespace App\Http\Controllers;

use App\Models\ReturBarang;
use App\Models\DetailReturBarang;
use App\Models\StatusRetur;
use App\Models\Barang;
use App\Models\PengirimanBarang;
use App\Models\User;
use Illuminate\Http\Request;
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
            ->paginate(10);
        
        return view('retur_barang.index', compact('returBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $statusReturs = StatusRetur::all();
        $pengirimanBarangs = PengirimanBarang::all();
        $barangs = Barang::all();
        
        return view('retur_barang.create', compact('users', 'statusReturs', 'pengirimanBarangs', 'barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'tanggal_retur' => 'required|date',
            'alasan_retur' => 'required|string',
            'id_pengiriman_barang' => 'required|exists:pengiriman_barangs,id',
            'id_barang' => 'required|array',
            'id_barang.*' => 'exists:barangs,id',
            'jumlah_barang_retur' => 'required|array',
            'jumlah_barang_retur.*' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            // Buat retur barang utama
            $returBarang = ReturBarang::create([
                'id_user' => $request->id_user,
                'tanggal_retur' => $request->tanggal_retur,
                'alasan_retur' => $request->alasan_retur,
                'id_status_retur' => 1,
                'id_pengiriman_barang' => $request->id_pengiriman_barang,
            ]);
            
            // Buat detail retur barang
            foreach ($request->id_barang as $index => $id_barang) {
                $detailPengirimanBarangs = PengirimanBarang::find($request->id_pengiriman_barang)->detailPengirimanBarangs;

                if ($detailPengirimanBarangs) {
                    foreach ($detailPengirimanBarangs as $detail) {
                        $barang = $detail->barang;
                        if ($barang) {
                            $namaBarang = $barang->nama_barang;
                            $jumlahStok = $barang->jumlah_stok;
                
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
        $users = User::all();
        $statusReturs = StatusRetur::all();
        $pengirimanBarangs = PengirimanBarang::all();
        $returBarang->load('detailReturBarangs.barang');
        
        return view('retur_barang.edit', compact('returBarang', 'users', 'statusReturs', 'pengirimanBarangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReturBarang $returBarang)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'tanggal_retur' => 'required|date',
            'alasan_retur' => 'required|string',
            'id_status_retur' => 'required|exists:status_returs,id',
            'id_pengiriman_barang' => 'required|exists:pengiriman_barangs,id',
        ]);

        DB::beginTransaction();
        try {
            $returBarang->update([
                'id_user' => $request->id_user,
                'tanggal_retur' => $request->tanggal_retur,
                'alasan_retur' => $request->alasan_retur,
                'id_status_retur' => $request->id_status_retur,
                'id_pengiriman_barang' => $request->id_pengiriman_barang,
            ]);
            
            DB::commit();
            return redirect()->route('retur-barang.show', $returBarang->id)
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
            $returBarang->detailReturBarangs()->delete();
            
            // Hapus retur barang utama
            $returBarang->delete();
            
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