<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Kurir;
use App\Models\PengirimanBarang;
use App\Models\DetailPengirimanBarang;
use App\Models\StatusPengirimanBarang;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PengirimanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengirimanBarangs = PengirimanBarang::with([
            'gudang',
            'kurir',
            'toko',
            'statusPengiriman',
            'detailPengirimanBarangs'
        ])->latest()->paginate(10);
        
        return view('pengiriman_barang.index', compact('pengirimanBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gudangs = Gudang::where('flag', 1)->get();
        $kurirs = Kurir::where('flag', 1)->get();
        $tokos = Toko::where('flag', 1)->get();
        $statusPengirimanBarangs = StatusPengirimanBarang::where('flag', 1)->get();
        $barangs = Barang::where('flag', 1)->get();
        
        return view('pengiriman_barang.create', compact(
            'gudangs',
            'kurirs',
            'tokos',
            'statusPengirimanBarangs',
            'barangs'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_gudang' => 'required|exists:gudangs,id',
            'tanggal_pengiriman' => 'required|date',
            'id_kurir' => 'required|exists:kurirs,id',
            'id_toko' => 'required|exists:tokos,id',
            'barang_id' => 'required|array',
            'barang_id.*' => 'exists:barangs,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();
            
            // Buat pengiriman barang baru
            $pengirimanBarang = PengirimanBarang::create([
                'id_gudang' => $request->id_gudang,
                'tanggal_pengiriman' => $request->tanggal_pengiriman,
                'id_kurir' => $request->id_kurir,
                'id_toko' => $request->id_toko,
                'id_status_pengiriman' => 1,
            ]);
            
            // Buat detail pengiriman barang
            for ($i = 0; $i < count($request->barang_id); $i++) {
                if (isset($request->barang_id[$i]) && isset($request->jumlah[$i])) {
                    $barangData = Barang::where('id', $request->barang_id[$i])->first();

                    if ($barangData->jumlah_stok < $request->jumlah[$i]) {
                        DB::rollBack();

                        return back()->with('error', 'Jumlah barang ' . $barangData->nama_barang . ' yang akan dikirim tidak mencukupi')->withInput();
                    }

                    $barangData->jumlah_stok -= $request->jumlah[$i];
                    $barangData->save();

                    DetailPengirimanBarang::create([
                        'id_barang' => $request->barang_id[$i],
                        'id_pengiriman_barang' => $pengirimanBarang->id,
                        'jumlah' => $request->jumlah[$i],
                    ]);
                }
            }

            DB::commit();
            
            return redirect()->route('pengiriman-barang.index')
                ->with('success', 'Pengiriman barang berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PengirimanBarang $pengirimanBarang)
    {
        $pengirimanBarang->load([
            'gudang',
            'kurir',
            'toko',
            'statusPengiriman',
            'detailPengirimanBarangs.barang'
        ]);
        
        return view('pengiriman_barang.show', compact('pengirimanBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengirimanBarang $pengirimanBarang)
    {
        $gudangs = Gudang::where('flag', 1)->get();
        $kurirs = Kurir::where('flag', 1)->get();
        $tokos = Toko::where('flag', 1)->get();
        $statusPengirimanBarangs = StatusPengirimanBarang::where('flag', 1)->get();
        $pengirimanBarang->load(['detailPengirimanBarangs']);
        
        return view('pengiriman_barang.edit', compact(
            'pengirimanBarang',
            'gudangs',
            'kurirs',
            'tokos',
            'statusPengirimanBarangs'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengirimanBarang $pengirimanBarang)
    {
        $request->validate([
            'id_gudang' => 'required|exists:gudangs,id',
            'tanggal_pengiriman' => 'required|date',
            'id_kurir' => 'required|exists:kurirs,id',
            'id_toko' => 'required|exists:tokos,id',
            'id_status_pengiriman' => 'required|exists:status_pengiriman_barangs,id',
        ]);

        try {
            DB::beginTransaction();
            
            $pengirimanBarang->update([
                'id_gudang' => $request->id_gudang,
                'tanggal_pengiriman' => $request->tanggal_pengiriman,
                'id_kurir' => $request->id_kurir,
                'id_toko' => $request->id_toko,
                'id_status_pengiriman' => $request->id_status_pengiriman,
            ]);
            
            DB::commit();
            
            return redirect()->route('pengiriman-barang.show', $pengirimanBarang->id)
                ->with('success', 'Data pengiriman barang berhasil diperbarui!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengirimanBarang $pengirimanBarang)
    {
        try {
            DB::beginTransaction();
            
            // Hapus semua detail pengiriman barang terkait
            $pengirimanBarang->detailPengirimanBarangs()->delete();
            
            // Hapus pengiriman barang
            $pengirimanBarang->delete();
            
            DB::commit();
            
            return redirect()->route('pengiriman-barang.index')
                ->with('success', 'Pengiriman barang berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form untuk menambah detail pengiriman barang
     */
    public function createDetail(PengirimanBarang $pengirimanBarang)
    {
        $barangs = Barang::where('flag', 1)->get();
        return view('pengiriman_barang.create-detail', compact('pengirimanBarang', 'barangs'));
    }

    /**
     * Simpan detail pengiriman barang baru
     */
    public function storeDetail(Request $request, PengirimanBarang $pengirimanBarang)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();
            
            DetailPengirimanBarang::create([
                'id_barang' => $request->id_barang,
                'id_pengiriman_barang' => $pengirimanBarang->id,
                'jumlah' => $request->jumlah,
            ]);
            
            DB::commit();
            
            return redirect()->route('pengiriman-barang.show', $pengirimanBarang->id)
                ->with('success', 'Detail pengiriman barang berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan detail pengiriman barang
     */
    public function showDetail(DetailPengirimanBarang $detailPengirimanBarang)
    {
        $detailPengirimanBarang->load(['barang', 'pengirimanBarang']);
        return view('pengiriman_barang.show-detail', compact('detailPengirimanBarang'));
    }

    /**
     * Tampilkan form untuk mengedit detail pengiriman barang
     */
    public function editDetail(DetailPengirimanBarang $detailPengirimanBarang)
    {
        $barangs = Barang::where('flag', 1)->get();
        return view('pengiriman_barang.edit-detail', compact('detailPengirimanBarang', 'barangs'));
    }

    /**
     * Update detail pengiriman barang
     */
    public function updateDetail(Request $request, DetailPengirimanBarang $detailPengirimanBarang)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();
            
            $detailPengirimanBarang->update([
                'id_barang' => $request->id_barang,
                'jumlah' => $request->jumlah,
            ]);
            
            DB::commit();
            
            return redirect()->route('pengiriman-barang.show', $detailPengirimanBarang->id_pengiriman_barang)
                ->with('success', 'Detail pengiriman barang berhasil diperbarui!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus detail pengiriman barang
     */
    public function destroyDetail(DetailPengirimanBarang $detailPengirimanBarang)
    {
        try {
            DB::beginTransaction();
            
            $id_pengiriman_barang = $detailPengirimanBarang->id_pengiriman_barang;
            $detailPengirimanBarang->delete();
            
            DB::commit();
            
            return redirect()->route('pengiriman-barang.show', $id_pengiriman_barang)
                ->with('success', 'Detail pengiriman barang berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}