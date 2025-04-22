<?php

namespace App\Http\Controllers;

use App\Models\Kurir;
use App\Models\Barang;
use App\Models\Lokasi;
use App\Models\PengirimanBarang;
use Illuminate\Support\Facades\DB;
use App\Models\DetailPengirimanBarang;
use App\Models\StatusPengirimanBarang;
use App\Http\Requests\PengirimanBarang\StorePengirimanBarangRequest;
use App\Http\Requests\PengirimanBarang\UpdatePengirimanBarangRequest;

class PengirimanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengirimanBarangs = PengirimanBarang::with([
            'lokasiAsal',
            'lokasiTujuan',
            'kurir',
            'statusPengiriman',
            'detailPengirimanBarangs'
        ])->latest()->where('flag', 1)->paginate(10);

        return view('pengiriman_barang.index', compact('pengirimanBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kurirs = Kurir::where('flag', 1)->get();
        $gudangs = Lokasi::with('gudang')
            ->whereNotNull('id_gudang')
            ->where('flag', 1)
            ->get();
        $tokos = Lokasi::with(['toko.jenisToko'])
            ->whereNotNull('id_toko')
            ->where('flag', 1)
            ->get();
        $statusPengirimanBarangs = StatusPengirimanBarang::where('flag', 1)->get();
        $barangs = Barang::whereHas('toko', function ($query) {
            $query->whereHas('jenisToko', function ($query) {
                $query->where('nama_jenis_toko', 'Toko Perusahaan');
            });
        })
        ->orWhereHas('gudang')
        ->get();

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
    public function store(StorePengirimanBarangRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            $pengirimanBarang = PengirimanBarang::create($validated);

            // Buat detail pengiriman barang
            for ($i = 0; $i < count($validated['barang_id']); ++$i) {
                if (isset($validated['barang_id'][$i]) && isset($validated['jumlah'][$i])) {
                    $lokasiAsal = Lokasi::with(['gudang', 'toko.jenisToko'])->where('id', $validated['id_asal_barang'])->first();

                    if ($lokasiAsal->gudang || ($lokasiAsal->toko && $lokasiAsal->toko->jenisToko->nama_jenis_toko == 'Toko Perusahaan')) {
                        $barangData = Barang::where('id', $validated['barang_id'][$i])
                                        ->where(function ($query) use ($lokasiAsal) {
                                            if ($lokasiAsal && $lokasiAsal->gudang) {
                                                $query->where('id_gudang', $lokasiAsal->gudang->id);
                                            }
                                    
                                            if ($lokasiAsal && $lokasiAsal->toko) {
                                                $query->orWhere('id_toko', $lokasiAsal->toko->id);
                                            }
                                        })
                                        ->first();

                        if ($barangData->jumlah_stok < $validated['jumlah'][$i]) {
                            DB::rollBack();

                            return back()->with('error', "Jumlah barang {$barangData->nama_barang} yang akan dikirim tidak mencukupi")->withInput();
                        }

                        $barangData->jumlah_stok -= $validated['jumlah'][$i];
                        $barangData->save();
                    }

                    DetailPengirimanBarang::create([
                        'id_pengiriman_barang' => $pengirimanBarang['id'],
                        'id_barang' => $validated['barang_id'][$i],
                        'jumlah' => $validated['jumlah'][$i],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('pengiriman-barang.index')
                ->with('success', 'Pengiriman barang berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', "Terjadi kesalahan saat menambahkan data: {$e->getMessage()}")->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PengirimanBarang $pengirimanBarang)
    {
        $pengirimanBarang->load([
            'lokasiAsal',
            'lokasiTujuan',
            'kurir',
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
        $statusPengirimanBarangs = StatusPengirimanBarang::where('flag', 1)->get();
        $pengirimanBarang->load(['lokasiAsal.gudang', 'lokasiAsal.toko', 'lokasiTujuan.gudang', 'lokasiTujuan.toko', 'kurir', 'detailPengirimanBarangs']);

        return view('pengiriman_barang.edit', compact(
            'pengirimanBarang',
            'statusPengirimanBarangs'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePengirimanBarangRequest $request, PengirimanBarang $pengirimanBarang)
    {
        try {
            DB::beginTransaction();

            $pengirimanBarang->update($request->validated());

            DB::commit();

            return redirect()->route('pengiriman-barang.index', $pengirimanBarang->id)
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
            $pengirimanBarang->detailPengirimanBarangs()->update(['flag' => 0]);

            // Hapus pengiriman barang
            $pengirimanBarang->update(['flag' => 0]);

            DB::commit();

            return redirect()->route('pengiriman-barang.index')
                ->with('success', 'Data pengiriman barang berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors("Terjadi kesalahan saat menghapus data pengiriman: {$e->getMessage()}");
        }
    }

    /**
     * Show detail pengiriman barang
     */
    public function showDetail(PengirimanBarang $pengirimanBarang, DetailPengirimanBarang $detailPengirimanBarang)
    {
        $detailPengirimanBarang->load(['barang', 'pengirimanBarang']);
        return view('detail_pengiriman_barang.show', compact('detailPengirimanBarang'));
    }

    /**
     * Show Orders from a buyer
     */ 
    public function ordersIndex()
    {
        $pengirimanBarangs = PengirimanBarang::with([
            'lokasiAsal',
            'kurir',
            'statusPengiriman',
            'detailPengirimanBarangs'
        ])->latest()
        ->where('flag', 1)
        ->whereHas('lokasiTujuan', function ($query) {
            $query->where('id_toko', auth()->user()->toko->id);
        })
        ->paginate(10);

        return view('orders.index', compact('pengirimanBarangs'));
    }

    /** 
     * Show detail of Barangs in an order
     */
    public function ordersShow(PengirimanBarang $pengirimanBarang)
    {
        $pengirimanBarang->load([
            'lokasiAsal',
            'kurir',
            'statusPengiriman',
            'detailPengirimanBarangs.barang'
        ]);

        return view('orders.show', compact('pengirimanBarang'));
    }

    /** 
     * Show detail of Barangs in an order
     */
    public function ordersDetailShow(PengirimanBarang $pengirimanBarang, DetailPengirimanBarang $detailPengirimanBarang)
    {
        $detailPengirimanBarang->load([
            'barang',
            'pengirimanBarang'
        ]);

        return view('detail_order.show', compact('detailPengirimanBarang'));
    }
}