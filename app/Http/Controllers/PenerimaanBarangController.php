<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Models\PenerimaanBarang;
use Illuminate\Support\Facades\DB;
use App\Models\DetailPenerimaanBarang;
use App\Http\Requests\PenerimaanBarang\StorePenerimaanBarangRequest;
use App\Http\Requests\PenerimaanBarang\UpdatePenerimaanBarangRequest;

class PenerimaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PenerimaanBarang::with(['lokasiAsal.gudang', 'lokasiAsal.toko', 'lokasiTujuan.gudang', 'lokasiTujuan.toko', 'detailPenerimaanBarang']);

        // Filter pencarian (on the way)
        // if ($request->has('search') && !empty($request->search)) {
        //     $search = $request->search;
        //     $query->where(function ($q) use ($search) {
        //         $q->whereHas('supplier', function ($subQuery) use ($search) {
        //             $subQuery->where('nama_toko_supplier', 'like', '%' . $search . '%')->where('flag', 1);
        //         })
        //             ->orWhereHas('gudang', function ($subQuery) use ($search) {
        //                 $subQuery->where('nama_gudang', 'like', '%' . $search . '%')->where('flag', 1);
        //             })
        //             ->orWhere('tanggal_penerimaan', 'like', '%' . $search . '%');
        //     });
        // }

        $penerimaanBarangs = $query->orderBy('tanggal_penerimaan', 'desc')->paginate(10);

        return view('penerimaan_barang.index', compact('penerimaanBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gudangs = Lokasi::with('gudang')
            ->whereNotNull('id_gudang')
            ->where('flag', 1)
            ->get();
        $tokos = Lokasi::with(['toko.jenisToko'])
            ->whereNotNull('id_toko')
            ->where('flag', 1)
            ->get();
        $barangs = Barang::whereHas('toko', function ($query) {
            $query->whereHas('jenisToko', function ($query) {
                $query->where('nama_jenis_toko', 'Toko Perusahaan');
            });
        })
        ->orWhereHas('gudang')
        ->get();

        return view('penerimaan_barang.create', compact('gudangs', 'tokos', 'barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenerimaanBarangRequest $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();

            // Simpan penerimaan barang
            $penerimaanBarang = PenerimaanBarang::create([
                'id_asal_barang' => $validated['id_asal_barang'],
                'id_tujuan_pengiriman' => $validated['id_tujuan_pengiriman'],
                'tanggal_penerimaan' => $validated['tanggal_penerimaan'],
            ]);

            // Simpan detail penerimaan barang
            $barangCount = count($validated['barang_id']);

            $detailPenerimaanBarangArray = [];
            for ($i = 0; $i < $barangCount; $i++) {
                $barang = Barang::where('id', $validated['barang_id'][$i])->first();
                if ($barang) {
                    $barang->jumlah_stok += $validated['jumlah'][$i];
                    $barang->save();
                }

                $detailPenerimaanBarangArray[] = [
                    'id_penerimaan_barang' => $penerimaanBarang->id,
                    'id_barang' => $validated['barang_id'][$i],
                    'jumlah' => $validated['jumlah'][$i],
                ];
            }
            DetailPenerimaanBarang::insert($detailPenerimaanBarangArray);

            DB::commit();

            return redirect()->route('penerimaan-barang.index', $penerimaanBarang)
                ->with('success', 'Penerimaan barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PenerimaanBarang $penerimaanBarang)
    {
        $penerimaanBarang->load(['supplier', 'gudang', 'detailPenerimaanBarang.barang']);

        return view('penerimaan_barang.show', compact('penerimaanBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PenerimaanBarang $penerimaanBarang)
    {
        $penerimaanBarang->load(['detailPenerimaanBarang.barang']);
        $gudangs = Gudang::where('flag', 1)->orderBy('nama_gudang')->get();

        return view('penerimaan_barang.edit', compact('penerimaanBarang', 'gudangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenerimaanBarangRequest $request, PenerimaanBarang $penerimaanBarang)
    {
        // Validasi data penerimaan barang
        $request->validate([
            'id_supplier' => 'required|exists:suppliers,id',
            'id_gudang' => 'required|exists:gudangs,id',
            'tanggal_penerimaan' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            // Update penerimaan barang
            $penerimaanBarang->update([
                'id_supplier' => $request->id_supplier,
                'id_gudang' => $request->id_gudang,
                'tanggal_penerimaan' => $request->tanggal_penerimaan,
            ]);

            DB::commit();

            return redirect()->route('penerimaan-barang.index')
                ->with('success', 'Penerimaan barang berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui penerimaan barang: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenerimaanBarang $penerimaanBarang)
    {
        DB::beginTransaction();

        try {
            $detailPenerimaanBarangs = DetailPenerimaanBarang::where('id_penerimaan_barang', $penerimaanBarang->id)->get();

            foreach ($detailPenerimaanBarangs as $detail) {
                $barang = Barang::find($detail->id_barang);
                if ($barang) {
                    $barang->jumlah_stok = max(0, $barang->jumlah_stok - $detail->jumlah);
                    $barang->save();
                }
            }

            $penerimaanBarang->delete();

            DB::commit();

            return redirect()->route('penerimaan-barang.index')
                ->with('success', 'Penerimaan barang dan semua detailnya berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show detailed information for a specific detail record.
     */
    public function showDetail(DetailPenerimaanBarang $detailPenerimaan)
    {
        $detailPenerimaan->load(['penerimaanBarang', 'barang']);

        return view('detail_penerimaan_barang.show', compact('detailPenerimaan'));
    }
}